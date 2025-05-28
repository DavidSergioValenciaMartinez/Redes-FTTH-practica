<?php
require_once __DIR__ . '/../models/Medicion.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Puerto.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session_helper.php';

class MedicionController extends Controller {
    private $medicionModel;
    private $usuarioModel;
    private $puertoModel;
    public function __construct() {
        $db = new Database();
        $this->medicionModel = new Medicion($db->connect());
        $this->usuarioModel = new Usuario($db->connect());
        $this->puertoModel = new Puerto($db->connect());
    }
    public function index() {
        $mediciones = $this->medicionModel->obtenerTodas();
        $data = [
            'title' => 'Medición de Puertos',
            'mediciones' => $mediciones
        ];
        $this->view('mediciones/index', $data);
    }
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_puerto' => $_POST['id_puerto'],
                'potencia_dbm' => $_POST['potencia_dbm'],
                'atenuacion_db' => $_POST['atenuacion_db'],
                'medido_por' => $_SESSION['user_id'],
                'fuente' => $_POST['fuente'] ?? 'manual'
            ];
            if ($this->medicionModel->crear($data)) {
                flash('mensaje', 'Medición registrada correctamente', 'alert alert-success');
                redirect('/mediciones');
            } else {
                flash('mensaje', 'Error al registrar la medición', 'alert alert-danger');
            }
        }
        $puertos = $this->medicionModel->obtenerPuertos();
        $data = [
            'title' => 'Registrar Medición',
            'puertos' => $puertos
        ];
        $this->view('mediciones/crear', $data);
    }
    public function editar($id) {
        $medicion = $this->medicionModel->obtenerPorId($id);
        if (!$medicion) {
            flash('mensaje', 'Medición no encontrada', 'alert alert-danger');
            redirect('/mediciones');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_puerto' => $_POST['id_puerto'],
                'potencia_dbm' => $_POST['potencia_dbm'],
                'atenuacion_db' => $_POST['atenuacion_db'],
                'medido_por' => $_SESSION['user_id'],
                'fuente' => $_POST['fuente'] ?? 'manual'
            ];
            if ($this->medicionModel->actualizar($id, $data)) {
                flash('mensaje', 'Medición actualizada correctamente', 'alert alert-success');
                redirect('/mediciones');
            } else {
                flash('mensaje', 'Error al actualizar la medición', 'alert alert-danger');
            }
        }
        $puertos = $this->medicionModel->obtenerPuertos();
        $data = [
            'title' => 'Editar Medición',
            'medicion' => $medicion,
            'puertos' => $puertos
        ];
        $this->view('mediciones/editar', $data);
    }
    public function ver($id) {
        $medicion = $this->medicionModel->obtenerPorId($id);
        if (!$medicion) {
            flash('mensaje', 'Medición no encontrada', 'alert alert-danger');
            redirect('/mediciones');
        }
        $data = [
            'title' => 'Detalle de Medición',
            'medicion' => $medicion
        ];
        $this->view('mediciones/ver', $data);
    }
    public function eliminar($id) {
        if ($this->medicionModel->eliminar($id)) {
            flash('mensaje', 'Medición eliminada correctamente', 'alert alert-success');
        } else {
            flash('mensaje', 'Error al eliminar la medición', 'alert alert-danger');
        }
        redirect('/mediciones');
    }
} 