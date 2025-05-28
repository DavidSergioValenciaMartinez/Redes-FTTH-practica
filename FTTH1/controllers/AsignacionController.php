<?php
class AsignacionController extends Controller {
    private $asignacionModel;
    private $clienteModel;
    private $db;

    public function __construct() {
        require_once __DIR__ . '/../config/database.php';
        $db = new Database();
        $this->db = $db->connect();
        $this->asignacionModel = $this->model('Asignacion');
        $this->clienteModel = $this->model('Cliente');
    }

    public function index() {
        $asignaciones = $this->asignacionModel->obtenerTodas();
        $data = ['title' => 'Asignaciones', 'asignaciones' => $asignaciones];
        $this->view('asignaciones/index', $data);
    }

    public function crear() {
        $clientes = $this->clienteModel->obtenerTodos();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'id_cliente' => $_POST['id_cliente'],
                'fecha_asignacion' => $_POST['fecha_asignacion'],
                'estado' => $_POST['estado']
            ];
            if ($this->asignacionModel->crear($data)) {
                header('Location: ' . URL_ROOT . '/asignaciones');
                exit;
            } else {
                $error = 'Error al crear la asignación.';
            }
        }
        $data = ['title' => 'Crear Asignación', 'clientes' => $clientes];
        $this->view('asignaciones/crear', $data);
    }

    public function editar() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ' . URL_ROOT . '/asignaciones'); exit; }
        
        $clientes = $this->clienteModel->obtenerTodos(); // También necesitamos la lista para editar

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'id_cliente' => $_POST['id_cliente'],
                'fecha_asignacion' => $_POST['fecha_asignacion'],
                'estado' => $_POST['estado']
            ];
            if ($this->asignacionModel->actualizar($id, $data)) {
                header('Location: ' . URL_ROOT . '/asignaciones');
                exit;
            } else {
                $error = 'Error al actualizar la asignación.';
            }
        }
        $asignacion = $this->asignacionModel->obtenerPorId($id);
        $data = ['title' => 'Editar Asignación', 'asignacion' => $asignacion, 'clientes' => $clientes];
        $this->view('asignaciones/editar', $data);
    }

    public function ver() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ' . URL_ROOT . '/asignaciones'); exit; }
        $asignacion = $this->asignacionModel->obtenerPorId($id);
        $data = ['title' => 'Ver Asignación', 'asignacion' => $asignacion];
        $this->view('asignaciones/ver', $data);
    }

    public function eliminar() {
        $id = $_GET['id'] ?? null;
        if (!$id) { header('Location: ' . URL_ROOT . '/asignaciones'); exit; }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->asignacionModel->eliminar($id)) {
                header('Location: ' . URL_ROOT . '/asignaciones');
                exit;
            } else {
                $error = 'Error al eliminar la asignación.';
            }
        }
        $asignacion = $this->asignacionModel->obtenerPorId($id);
         $data = ['title' => 'Eliminar Asignación', 'asignacion' => $asignacion];
        $this->view('asignaciones/eliminar', $data);
    }
} 