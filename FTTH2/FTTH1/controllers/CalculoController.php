<?php
/**
 * Controlador para los cálculos de balanceados y desbalanceados
 */
class CalculoController extends Controller {
    private $calculoAtenuacionModel;
    private $db;

    /**
     * Constructor
     */
    public function __construct() {
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            exit;
        }
        
        // Verificar si el usuario tiene el rol adecuado
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])) {
            flash('mensaje', 'No tienes permisos para acceder a esta sección', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/');
            exit;
        }

        require_once __DIR__ . '/../config/database.php';
        $db = new Database();
        $this->db = $db->connect();
        $this->calculoAtenuacionModel = $this->model('CalculoAtenuacion');
    }
    
    /**
     * Muestra la página de cálculos balanceados
     */
    public function balanceados() {
        require_once __DIR__ . '/../models/CajaNap.php';
        $cajaNapModel = new CajaNap($this->db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cajas_nap'])) {
            $cajasSeleccionadas = $_POST['cajas_nap'];
            $puertoModel = new Puerto($this->db);
            // Obtener solo los puertos de las cajas seleccionadas
            $in = str_repeat('?,', count($cajasSeleccionadas) - 1) . '?';
            $sql = "SELECT p.id_puerto, p.numero_puerto, c.codigo_caja, u.nombre_completo as nombre_cliente,
                           p.splitter_tipo, p.splitter_ratio, p.splitter_atenuacion_db
                    FROM tbl_puertos p
                    INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                    LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario
                    WHERE p.estado = 'disponible' AND p.id_caja IN ($in)
                    ORDER BY c.codigo_caja, p.numero_puerto";
            $stmt = $this->db->prepare($sql);
            foreach ($cajasSeleccionadas as $k => $idCaja) {
                $stmt->bindValue($k + 1, $idCaja, PDO::PARAM_INT);
            }
            $stmt->execute();
            $puertos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = [
                'title' => 'Cálculo Balanceado',
                'puertos' => $puertos,
                'cajas_seleccionadas' => $cajasSeleccionadas,
                'num_naps' => count($cajasSeleccionadas)
            ];
            $this->view('calculo/balanceados', $data);
        } else {
            // Primer paso: mostrar checkboxes de cajas NAP
            $cajas = $cajaNapModel->obtenerTodas();
            $data = [
                'title' => 'Seleccionar Cajas NAP',
                'cajas' => $cajas
            ];
            $this->view('calculo/seleccionar_cajas', $data);
        }
    }

    /**
     * Handles the selection of the number of NAP boxes
     */
    public function seleccionarNaps() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

            $num_naps = trim(htmlspecialchars($_POST['num_naps'], ENT_QUOTES, 'UTF-8'));

            if (!empty($num_naps) && is_numeric($num_naps) && (int)$num_naps > 0) {
                // Store the number of NAPs in session or pass directly to view
                // For simplicity, let's redirect back to balanceados with POST data
                // A better approach might be to store in session or pass via URL

                // Option 1: Store in session (requires session_start() if not already)
                // $_SESSION['num_naps'] = (int) $num_naps;
                // header('Location: ' . URL_ROOT . '/calculo/balanceados');

                // Option 2: Pass via POST (handled in balanceados() method)
                 $data = [
                    'title' => 'Cálculos Balanceados - SOLUFIBER S.R.L.',
                    'active_page' => 'balanceados',
                    'num_naps' => (int) $num_naps
                ];
                 $this->view('calculo/balanceados', $data);

            } else {
                flash('mensaje_error', 'Por favor, ingrese un número válido de cajas NAP.', 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/calculo/balanceados');
            }
            exit;
        } else {
            header('Location: ' . URL_ROOT . '/calculo/balanceados');
            exit;
        }
    }

    /**
     * Procesa el cálculo balanceado y guarda los resultados
     */
    public function calcularBalanceado() {
        // Verificar si la solicitud es POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar los datos POST
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

            // Validar y obtener el ID del puerto
            if (!isset($_POST['id_puerto']) || empty($_POST['id_puerto'])) {
                flash('mensaje_calculo', 'Error: Debe seleccionar un puerto válido.', 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/calculo/balanceados');
                exit;
            }

            $id_puerto = (int)htmlspecialchars(trim($_POST['id_puerto']), ENT_QUOTES, 'UTF-8');
            $num_naps = isset($_POST['num_naps']) ? (int)htmlspecialchars(trim($_POST['num_naps']), ENT_QUOTES, 'UTF-8') : 0;
            $naps_data = isset($_POST['naps']) ? $_POST['naps'] : [];
            $nivel_insercion = isset($_POST['nivel_insercion']) ? (float)htmlspecialchars(trim($_POST['nivel_insercion']), ENT_QUOTES, 'UTF-8') : 0;

            // Validar datos requeridos
            if ($num_naps <= 0 || empty($naps_data) || $nivel_insercion == 0) {
                flash('mensaje_calculo', 'Error: Todos los campos son requeridos.', 'alert alert-danger');
                header('Location: ' . URL_ROOT . '/calculo/balanceados');
                exit;
            }

            // Fórmulas exactas solicitadas por el usuario
            $total_distancia_km = 0;
            $total_conectores = 0;
            $total_fusiones = 0;
            $total_atenuacion_cable = 0;
            $total_atenuacion_cable_drop = 0;
            $total_atenuacion_acopladores = 0;
            $total_atenuacion_fusiones = 0;
            $total_atenuacion_splitters = 0;
            $splitter_values = [
                '1:2' => 3.6,
                '1:4' => 7.2,
                '1:8' => 11,
                '1:16' => 14,
                '1:32' => 17.5
            ];
            $suma_cable_fo_m = 0;
            $detalle_ultima_caja = [];
            $ultima_caja_index = $num_naps; // índice de la última caja
            for ($i = 1; $i <= $num_naps; $i++) {
                if (!isset($naps_data[$i])) {
                    throw new Exception("Datos incompletos para la NAP #$i");
                }
                $nap = $naps_data[$i];
                $distancia_fo_m = (float)(htmlspecialchars($nap['distancia_fo'] ?? 0, ENT_QUOTES, 'UTF-8'));
                $cable_dropp_m = (float)(htmlspecialchars($nap['cable_dropp'] ?? 0, ENT_QUOTES, 'UTF-8'));
                $fusiones_fo = (int)(htmlspecialchars($nap['fusiones_fo'] ?? 0, ENT_QUOTES, 'UTF-8'));
                $acopladores = (int)(htmlspecialchars($nap['acopladores'] ?? 0, ENT_QUOTES, 'UTF-8'));
                $atenuacion_splitter = 0;
                if (isset($nap['splitters']) && is_array($nap['splitters'])) {
                    foreach ($nap['splitters'] as $splitter) {
                        $ratio = htmlspecialchars($splitter['ratio'] ?? '', ENT_QUOTES, 'UTF-8');
                        if (isset($splitter_values[$ratio])) {
                            $atenuacion_splitter += $splitter_values[$ratio];
                        }
                    }
                }
                // Sumar todas las distancias FO hasta la última caja
                $suma_cable_fo_m += $distancia_fo_m;
                // Si es la última caja, guardar sus detalles
                if ($i == $ultima_caja_index) {
                    $atenuacion_cable = ($suma_cable_fo_m / 1000) * 0.2;
                    $atenuacion_cable_drop = ($cable_dropp_m / 1000) * 0.2;
                    $atenuacion_acopladores = $acopladores * 0.5;
                    $atenuacion_fusiones = $fusiones_fo * 0.03;
                    $detalle_ultima_caja = [
                        'atenuacion_cable' => round($atenuacion_cable, 2),
                        'atenuacion_cable_drop' => round($atenuacion_cable_drop, 2),
                        'atenuacion_acopladores' => round($atenuacion_acopladores, 2),
                        'atenuacion_fusiones' => round($atenuacion_fusiones, 2),
                        'atenuacion_splitters' => round($atenuacion_splitter, 2)
                    ];
                    // Calcular los resultados solo con la suma de FO y los valores de la última caja
                    $atenuacion_parcial_total = $atenuacion_cable + $atenuacion_cable_drop + $atenuacion_acopladores + $atenuacion_fusiones + $atenuacion_splitter;
                    $nivel_insercion = isset($_POST['nivel_insercion']) && $_POST['nivel_insercion'] !== '' ? (float)$_POST['nivel_insercion'] : -5;
                    $atenuacion_total_cliente_dbm = $atenuacion_parcial_total - 5;
                    $atenuacion_total_caja_nap_dbm = $atenuacion_total_cliente_dbm - $atenuacion_cable_drop;
                }
            }
            // Guardar en la base de datos usando el modelo
            $data_to_save = [
                'id_puerto' => $id_puerto,
                'tipo_calculo' => 'balanceado',
                'distancia_km' => round($suma_cable_fo_m / 1000, 2),
                'conectores' => $acopladores, // solo última caja
                'fusiones' => $fusiones_fo, // solo última caja
                'atenuacion_total_db' => round($atenuacion_parcial_total, 2),
                'calculado_por' => $_SESSION['user_id']
            ];
            if ($this->calculoAtenuacionModel->guardarCalculo($data_to_save)) {
                $data_for_view = [
                    'title' => 'Cálculos Balanceados - SOLUFIBER S.R.L.',
                    'active_page' => 'balanceados',
                    'num_naps' => $num_naps,
                    'atenuacion_parcial_total' => round($atenuacion_parcial_total, 2),
                    'atenuacion_cable' => $detalle_ultima_caja['atenuacion_cable'],
                    'atenuacion_cable_drop' => $detalle_ultima_caja['atenuacion_cable_drop'],
                    'atenuacion_acopladores' => $detalle_ultima_caja['atenuacion_acopladores'],
                    'atenuacion_fusiones' => $detalle_ultima_caja['atenuacion_fusiones'],
                    'atenuacion_splitters' => $detalle_ultima_caja['atenuacion_splitters'],
                    'atenuacion_total_cliente_db' => round($atenuacion_total_cliente_dbm, 2),
                    'atenuacion_total_caja_nap_db' => round($atenuacion_total_caja_nap_dbm, 2)
                ];
                flash('mensaje_calculo', 'Cálculo realizado y guardado correctamente.', 'alert alert-success');
                $this->view('calculo/balanceados', $data_for_view);
            } else {
                throw new Exception("Error al guardar el cálculo en la base de datos");
            }

        } else {
            // Si no es POST, redirigir a la página de cálculos balanceados
            header('Location: ' . URL_ROOT . '/calculo/balanceados');
            exit;
        }
    }

    /**
     * Muestra la página de cálculos desbalanceados
     */
    public function desbalanceados() {
        $data = [
            'title' => 'Cálculos Desbalanceados - SOLUFIBER S.R.L.',
            'active_page' => 'desbalanceados'
        ];
        
        $this->view('calculo/desbalanceados', $data);
    }
}