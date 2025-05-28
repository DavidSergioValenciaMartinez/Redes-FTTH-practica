<?php
require_once __DIR__ . '/../models/Puerto.php';
require_once __DIR__ . '/../models/CajaNap.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/database.php';

class PuertoController extends Controller {
    private $puertoModel;
    private $cajaNapModel;
    public function __construct() {
        $db = new Database();
        $this->puertoModel = new Puerto($db->connect());
        $this->cajaNapModel = new CajaNap($db->connect());
    }
    public function index() {
        $puertos = $this->puertoModel->obtenerTodos();
        $data = [
            'title' => 'Puertos',
            'puertos' => $puertos
        ];
        $this->view('puertos/index', $data);
    }
    public function crear() {
        $cajas = $this->cajaNapModel->obtenerTodas();
        $usuarioModel = new Usuario((new Database())->connect());
        $clientes = $usuarioModel->obtenerClientes()->fetchAll(PDO::FETCH_ASSOC);
        $data = [
            'title' => 'Registrar Puerto',
            'cajas' => $cajas,
            'clientes' => $clientes
        ];
        $this->view('puertos/crear', $data);
    }
    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->puertoModel->crear($_POST);
            header('Location: ' . URL_ROOT . '/puertos');
            exit;
        }
    }
    public function editar($id) {
        $puerto = $this->puertoModel->obtenerPorId($id);
        $cajas = $this->cajaNapModel->obtenerTodas();
        $usuarioModel = new Usuario((new Database())->connect());
        $clientes = $usuarioModel->obtenerClientes()->fetchAll(PDO::FETCH_ASSOC);
        $data = [
            'title' => 'Editar Puerto',
            'puerto' => $puerto,
            'cajas' => $cajas,
            'clientes' => $clientes
        ];
        $this->view('puertos/editar', $data);
    }
    public function actualizar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->puertoModel->actualizar($id, $_POST);
            header('Location: ' . URL_ROOT . '/puertos');
            exit;
        }
    }
    public function eliminar($id) {
        $this->puertoModel->eliminar($id);
        header('Location: ' . URL_ROOT . '/puertos');
        exit;
    }
    public function ver($id) {
        $puerto = $this->puertoModel->obtenerPorId($id);
        if (!$puerto) {
            flash('mensaje', 'Puerto no encontrado', 'alert alert-danger');
            header('Location: ' . URL_ROOT . '/puertos');
            exit;
        }

        $data = [
            'title' => 'Detalle del Puerto',
            'puerto' => $puerto
        ];
        $this->view('puertos/ver', $data);
    }
} 