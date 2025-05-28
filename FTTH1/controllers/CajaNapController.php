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
                'codigo_caja' => filter_input(INPUT_POST, 'codigo_caja', FILTER_SANITIZE_STRING),
                'ubicacion' => filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING),
                'total_puertos' => filter_input(INPUT_POST, 'total_puertos', FILTER_SANITIZE_NUMBER_INT),
                'puertos_disponibles' => filter_input(INPUT_POST, 'total_puertos', FILTER_SANITIZE_NUMBER_INT), // Inicialmente igual al total
                'puertos_ocupados' => 0, // Inicialmente 0
                'potencia_dbm' => filter_input(INPUT_POST, 'potencia_dbm', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING),
                'fabricante' => filter_input(INPUT_POST, 'fabricante', FILTER_SANITIZE_STRING),
                'modelo' => filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING),
                'capacidad' => filter_input(INPUT_POST, 'capacidad', FILTER_SANITIZE_STRING)
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

            // Intentar crear la caja
            if ($this->cajaNapModel->crear($data)) {
                flash('mensaje', 'Caja NAP creada correctamente', 'alert alert-success');
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
                'codigo_caja' => filter_input(INPUT_POST, 'codigo_caja', FILTER_SANITIZE_STRING),
                'ubicacion' => filter_input(INPUT_POST, 'ubicacion', FILTER_SANITIZE_STRING),
                'total_puertos' => filter_input(INPUT_POST, 'total_puertos', FILTER_SANITIZE_NUMBER_INT),
                'puertos_disponibles' => filter_input(INPUT_POST, 'puertos_disponibles', FILTER_SANITIZE_NUMBER_INT),
                'puertos_ocupados' => filter_input(INPUT_POST, 'puertos_ocupados', FILTER_SANITIZE_NUMBER_INT),
                'potencia_dbm' => filter_input(INPUT_POST, 'potencia_dbm', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION),
                'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING),
                'fabricante' => filter_input(INPUT_POST, 'fabricante', FILTER_SANITIZE_STRING),
                'modelo' => filter_input(INPUT_POST, 'modelo', FILTER_SANITIZE_STRING),
                'capacidad' => filter_input(INPUT_POST, 'capacidad', FILTER_SANITIZE_STRING)
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
}
?> 