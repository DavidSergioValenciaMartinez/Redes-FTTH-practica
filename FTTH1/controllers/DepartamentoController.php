<?php
require_once __DIR__ . '/../models/Departamento.php';
require_once __DIR__ . '/../config/database.php';

class DepartamentoController extends Controller {
    private $departamentoModel;
    public function __construct() {
        $db = new Database();
        $this->departamentoModel = new Departamento($db->connect());
    }
    public function create() {
        $error = null;
        $success = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre_departamento'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            if (empty($nombre)) {
                $error = 'El nombre del departamento es obligatorio.';
            } else {
                $result = $this->departamentoModel->crearDepartamento($nombre, $descripcion);
                if ($result) {
                    $success = true;
                } else {
                    $error = 'Error al registrar el departamento.';
                }
            }
        }
        $data = [
            'title' => 'Registrar Departamento',
            'error' => $error,
            'success' => $success
        ];
        $this->view('departamentos/create', $data);
    }
    public function crear($id_caja = null) {
        // ...
    }
} 