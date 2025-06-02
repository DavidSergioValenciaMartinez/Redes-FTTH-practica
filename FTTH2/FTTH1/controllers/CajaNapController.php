<?php
require_once __DIR__ . '/../models/CajaNap.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Departamento.php';
require_once __DIR__ . '/../helpers/session_helper.php';
/**
 * Controlador para la gestión de cajas NAP
 */
class CajaNapController extends Controller {
    private $cajaNapModel;
    private $tiposCajaModel;
    private $estadosModel;
    private $departamentosModel;
    private $distritosModel;
    private $tecnicosModel;
    private $departamentoModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Verificar si el usuario está autenticado
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            exit;
        }
        
        // Inicializar modelos
        $db = new Database();
        $this->cajaNapModel = new CajaNap($db->connect());
        $this->departamentoModel = new Departamento($db->connect());
        $this->distritosModel = new Distrito($db->connect());
        
        // Cargar otros modelos necesarios
        // Estos modelos deberían existir o necesitan ser creados
        // $this->tiposCajaModel = new TipoCaja($db->connect());
        // $this->estadosModel = new Estado($db->connect());
        // $this->tecnicosModel = new Tecnico($db->connect());
    }
    
    /**
     * Método para mostrar todas las cajas NAP
     */
    public function index() {
        // Solo permitir acceso a técnicos y administradores
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])) {
            flash('mensaje', 'No tienes permisos para acceder a esta sección', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/');
            exit;
        }
        
        // Obtener todas las cajas NAP
        $cajas = $this->cajaNapModel->obtenerTodas();
        
        $data = [
            'title' => 'Gestión de Cajas NAP - SOLUFIBER S.R.L.',
            'currentSection' => 'cajas_nap',
            'cajas' => $cajas
        ];
        
        $this->view('cajas_nap/index', $data);
    }
    
    /**
     * Método para mostrar detalles de una caja NAP
     * @param int $id ID de la caja NAP
     */
    public function ver($id) {
        // Solo permitir acceso a técnicos y administradores
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])) {
            flash('mensaje', 'No tienes permisos para acceder a esta sección', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/');
            exit;
        }
        
        // Obtener la caja NAP
        if (!$this->cajaNapModel->obtenerPorId($id)) {
            flash('mensaje', 'Caja NAP no encontrada', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        
        // Obtener los puertos de la caja
        $puertos = $this->cajaNapModel->obtenerPuertos();
        $estadisticas = $this->cajaNapModel->obtenerEstadisticasPuertos();
        
        $data = [
            'title' => 'Detalles de Caja NAP - SOLUFIBER S.R.L.',
            'currentSection' => 'cajas_nap',
            'caja' => $this->cajaNapModel,
            'puertos' => $puertos,
            'estadisticas' => $estadisticas
        ];
        
        $this->view('cajas_nap/ver', $data);
    }
    
    /**
     * Método para mostrar el formulario de creación de caja NAP
     */
    public function crear() {
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])) {
            flash('mensaje', 'No tienes permisos para crear cajas NAP', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        $departamentos = $this->departamentoModel->obtenerTodos();
        $data = [
            'title' => 'Crear Caja NAP - SOLUFIBER S.R.L.',
            'currentSection' => 'cajas_nap',
            'departamentos' => $departamentos
        ];
        $this->view('cajas_nap/crear', $data);
    }
    
    /**
     * Método para procesar la creación de una caja NAP
     */
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitizar y validar datos
            $data = [
                'id_departamento' => filter_input(INPUT_POST, 'id_departamento', FILTER_SANITIZE_NUMBER_INT),
                'codigo_caja' => filter_input(INPUT_POST, 'codigo_caja', FILTER_DEFAULT),
                'ubicacion' => filter_input(INPUT_POST, 'ubicacion', FILTER_DEFAULT),
                'total_puertos' => filter_input(INPUT_POST, 'total_puertos', FILTER_SANITIZE_NUMBER_INT),
                'puertos_disponibles' => filter_input(INPUT_POST, 'puertos_disponibles', FILTER_SANITIZE_NUMBER_INT),
                'puertos_ocupados' => filter_input(INPUT_POST, 'puertos_ocupados', FILTER_SANITIZE_NUMBER_INT),
                'potencia_dbm' => filter_input(INPUT_POST, 'potencia_dbm', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'estado' => filter_input(INPUT_POST, 'estado', FILTER_DEFAULT),
                'fabricante' => filter_input(INPUT_POST, 'fabricante', FILTER_DEFAULT),
                'modelo' => filter_input(INPUT_POST, 'modelo', FILTER_DEFAULT),
                'capacidad' => filter_input(INPUT_POST, 'capacidad', FILTER_DEFAULT)
            ];

            // Validar datos requeridos
            if (empty($data['id_departamento']) || empty($data['codigo_caja']) || empty($data['ubicacion']) || empty($data['total_puertos'])) {
                flash('mensaje', 'Por favor complete todos los campos requeridos', 'alert alert-danger');
                redirect('/cajas_nap/crear');
                return;
            }

            // Validar rango de puertos
            if ($data['total_puertos'] < 1 || $data['total_puertos'] > 16) {
                flash('mensaje', 'El número total de puertos debe estar entre 1 y 16', 'alert alert-danger');
                redirect('/cajas_nap/crear');
                return;
            }

            // Validar suma de disponibles y ocupados
            if ($data['puertos_disponibles'] < 0 || $data['puertos_ocupados'] < 0 || ($data['puertos_disponibles'] + $data['puertos_ocupados'] > $data['total_puertos'])) {
                flash('mensaje', 'La suma de puertos disponibles y ocupados no puede superar el total ni ser negativos', 'alert alert-danger');
                redirect('/cajas_nap/crear');
                return;
            }

            // Validar que el codigo_caja no exista ya
            if ($this->cajaNapModel->existeCodigoCaja($data['codigo_caja'])) {
                flash('mensaje', 'El código de caja NAP ya existe. Por favor, elige otro.', 'alert alert-danger');
                redirect('/cajas_nap/crear');
                return;
            }

            // Intentar crear la caja
            $id_caja = $this->cajaNapModel->crear($data);
            if ($id_caja) {
                require_once __DIR__ . '/../models/Puerto.php';
                $db = new Database();
                $conn = $db->connect();
                $puertoModel = new Puerto($conn);
                // Insertar los puertos automáticamente
                for ($i = 1; $i <= $data['total_puertos']; $i++) {
                    $puertoModel->crear([
                        'id_caja' => $id_caja,
                        'numero_puerto' => $i,
                        'estado' => 'disponible',
                        'cliente_usuario_id' => null,
                        'splitter_tipo' => null,
                        'splitter_ratio' => null,
                        'splitter_atenuacion_db' => null
                    ]);
                }
                flash('mensaje', 'Caja NAP creada correctamente y puertos generados', 'alert alert-success');
                redirect('/cajas_nap');
            } else {
                flash('mensaje', 'Error al crear la caja NAP', 'alert alert-danger');
                redirect('/cajas_nap/crear');
            }
        } else {
            redirect('/cajas_nap');
        }
    }
    
    /**
     * Método para mostrar el formulario de edición de caja NAP
     * @param int $id ID de la caja NAP
     */
    public function editar($id) {
        // Solo permitir acceso a técnicos y administradores
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])) {
            flash('mensaje', 'No tienes permisos para editar cajas NAP', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        
        // Obtener la caja NAP
        $caja = $this->cajaNapModel->obtenerPorId($id);
        if (!$caja) {
            flash('mensaje', 'Caja NAP no encontrada', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        
        // Obtener departamentos
        $departamentos = $this->departamentoModel->obtenerTodos();
        
        $data = [
            'title' => 'Editar Caja NAP - SOLUFIBER S.R.L.',
            'currentSection' => 'cajas_nap',
            'departamentos' => $departamentos,
            'caja' => $caja
        ];
        
        $this->view('cajas_nap/editar', $data);
    }
    
    /**
     * Método para procesar la actualización de una caja NAP
     */
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_departamento' => filter_input(INPUT_POST, 'id_departamento', FILTER_SANITIZE_NUMBER_INT),
                'codigo_caja' => filter_input(INPUT_POST, 'codigo_caja', FILTER_DEFAULT),
                'ubicacion' => filter_input(INPUT_POST, 'ubicacion', FILTER_DEFAULT),
                'total_puertos' => filter_input(INPUT_POST, 'total_puertos', FILTER_SANITIZE_NUMBER_INT),
                'puertos_disponibles' => filter_input(INPUT_POST, 'puertos_disponibles', FILTER_SANITIZE_NUMBER_INT),
                'puertos_ocupados' => filter_input(INPUT_POST, 'puertos_ocupados', FILTER_SANITIZE_NUMBER_INT),
                'potencia_dbm' => filter_input(INPUT_POST, 'potencia_dbm', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'estado' => filter_input(INPUT_POST, 'estado', FILTER_DEFAULT),
                'fabricante' => filter_input(INPUT_POST, 'fabricante', FILTER_DEFAULT),
                'modelo' => filter_input(INPUT_POST, 'modelo', FILTER_DEFAULT),
                'capacidad' => filter_input(INPUT_POST, 'capacidad', FILTER_DEFAULT)
            ];
            
            if ($this->cajaNapModel->actualizar($id, $data)) {
                flash('mensaje', 'Caja NAP actualizada correctamente', 'alert alert-success');
                redirect('/cajas_nap');
            } else {
                flash('mensaje', 'Error al actualizar la caja NAP', 'alert alert-danger');
                redirect('/cajas_nap/editar/' . $id);
            }
        } else {
            redirect('/cajas_nap');
        }
    }
    
    /**
     * Método para cambiar el estado de una caja NAP
     * @param int $id ID de la caja NAP
     * @param int $estado Nuevo estado
     */
    public function cambiarEstado($id, $estado) {
        // Verificar permisos
        if (!tienePermiso('editar_cajas_nap')) {
            flash('mensaje', 'No tienes permisos para editar cajas NAP', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        
        // Obtener la caja NAP
        if (!$this->cajaNapModel->obtenerPorId($id)) {
            flash('mensaje', 'Caja NAP no encontrada', 'alert alert-danger');
            redirect('/cajas_nap');
        }
        
        // Cambiar el estado
        if ($this->cajaNapModel->cambiarEstado($estado)) {
            flash('mensaje', 'Estado de caja NAP actualizado correctamente', 'alert alert-success');
        } else {
            flash('mensaje', 'Error al actualizar el estado de la caja NAP', 'alert alert-danger');
        }
        
        redirect('/cajas_nap');
    }
    
    /**
     * Método para obtener distritos por departamento (AJAX)
     */
    public function getDistritos() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_departamento'])) {
            $idDepartamento = filter_input(INPUT_POST, 'id_departamento', FILTER_SANITIZE_NUMBER_INT);
            $distritos = $this->distritosModel->obtenerPorDepartamento($idDepartamento);
            header('Content-Type: application/json');
            echo json_encode($distritos);
            exit;
        }
        http_response_code(400);
        echo json_encode(['error' => 'Solicitud inválida']);
        exit;
    }
    
    public function eliminar($id) {
        if ($this->cajaNapModel->eliminar($id)) {
            flash('mensaje', 'Caja NAP eliminada correctamente', 'alert alert-success');
        } else {
            flash('mensaje', 'Error al eliminar la caja NAP', 'alert alert-danger');
        }
        redirect('/cajas_nap');
    }
    
    /**
     * Mostrar gráfica de puertos de una caja NAP
     */
    public function grafica() {
        // Obtener todas las cajas para el selector
        $cajas = $this->cajaNapModel->obtenerTodas();
        $puertos = [];
        $cajaSeleccionada = null;
        $hojasTecnicas = [];
        if (isset($_GET['id_caja']) && is_numeric($_GET['id_caja'])) {
            $id_caja = (int)$_GET['id_caja'];
            $cajaSeleccionada = $this->cajaNapModel->obtenerPorId($id_caja);
            $puertos = $this->cajaNapModel->obtenerPuertosPorCaja($id_caja);
            // Obtener hojas técnicas de la caja seleccionada
            require_once __DIR__ . '/../models/HojaTecnica.php';
            $db = new Database();
            $hojaTecnicaModel = new HojaTecnica($db->connect());
            $hojasTecnicas = $hojaTecnicaModel->obtenerPorIdCaja($id_caja);
            // Si obtenerPorIdCaja devuelve solo una, convertir a array
            if ($hojasTecnicas && isset($hojasTecnicas['id_hoja_caja'])) {
                $hojasTecnicas = [$hojasTecnicas];
            }
        }
        $data = [
            'title' => 'Gráfica de Puertos de Caja NAP',
            'cajas' => $cajas,
            'puertos' => $puertos,
            'cajaSeleccionada' => $cajaSeleccionada,
            'hojas_tecnicas' => $hojasTecnicas
        ];
        $this->view('cajas_nap/grafica', $data);
    }
}
?> 