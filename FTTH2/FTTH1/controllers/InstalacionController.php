<?php
require_once __DIR__ . '/../models/Instalacion.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/CajaNap.php';

class InstalacionController extends Controller {
    private $instalacionModel;
    public function __construct() {
        $db = new Database();
        $this->instalacionModel = new Instalacion($db->connect());
    }
    // Listar instalaciones de una caja o todas
    public function index($id_caja = null) {
        if ($id_caja) {
            $instalaciones = $this->instalacionModel->obtenerTodasPorCaja($id_caja);
            $title = 'Instalaciones de Caja NAP';
        } else {
            $instalaciones = $this->instalacionModel->obtenerTodas();
            $title = 'Instalaciones';
        }
        $data = [
            'title' => $title,
            'instalaciones' => $instalaciones,
            'id_caja' => $id_caja
        ];
        $this->view('instalaciones/index', $data);
    }
    // Ver una instalación
    public function ver($id_instalacion) {
        $instalacion = $this->instalacionModel->obtenerPorId($id_instalacion);
        $data = [
            'title' => 'Detalle de Instalación',
            'instalacion' => $instalacion
        ];
        $this->view('instalaciones/ver', $data);
    }
    // Crear instalación
    public function crear($id_caja = null) {
        $db = new Database();
        $cajaNapModel = new CajaNap($db->connect());
        $cajas = $cajaNapModel->obtenerTodas();
        // Obtener técnicos
        $tecnicos = [];
        $stmt = $db->connect()->prepare("SELECT t.id_tecnico, u.nombre_completo FROM tbl_tecnicos t JOIN tbl_usuarios u ON t.id_usuario = u.id_usuario ORDER BY u.nombre_completo");
        $stmt->execute();
        $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Validar id_caja
        if ($id_caja !== null && !is_numeric($id_caja)) {
            header('Location: ' . URL_ROOT . '/instalaciones');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_caja_post = $_POST['id_caja'] ?? $id_caja;
            if (!is_numeric($id_caja_post)) {
                header('Location: ' . URL_ROOT . '/instalaciones');
                exit;
            }
            $data = [
                'id_caja' => $id_caja_post,
                'id_tecnico' => $_POST['id_tecnico'],
                'tipo_instalacion' => $_POST['tipo_instalacion'],
                'fecha_instalacion' => $_POST['fecha_instalacion'],
                'observaciones' => $_POST['observaciones'] ?? null
            ];
            $this->instalacionModel->crear($data);
            $_SESSION['mensaje'] = 'Instalación creada correctamente';
            header('Location: ' . URL_ROOT . '/instalaciones');
            exit;
        }
        $data = [
            'title' => 'Crear Instalación',
            'id_caja' => $id_caja,
            'cajas' => $cajas,
            'tecnicos' => $tecnicos
        ];
        $this->view('instalaciones/crear', $data);
    }
    // Editar instalación
    public function editar($id_instalacion) {
        $instalacion = $this->instalacionModel->obtenerPorId($id_instalacion);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_tecnico' => $_POST['id_tecnico'],
                'tipo_instalacion' => $_POST['tipo_instalacion'],
                'fecha_instalacion' => $_POST['fecha_instalacion'],
                'observaciones' => $_POST['observaciones'] ?? null
            ];
            $this->instalacionModel->actualizar($id_instalacion, $data);
            $_SESSION['mensaje'] = 'Instalación actualizada correctamente';
            header('Location: ' . URL_ROOT . '/instalaciones/index/' . $instalacion['id_caja']);
            exit;
        }
        $data = [
            'title' => 'Editar Instalación',
            'instalacion' => $instalacion
        ];
        $this->view('instalaciones/editar', $data);
    }
    // Eliminar instalación
    public function eliminar($id_instalacion) {
        $instalacion = $this->instalacionModel->obtenerPorId($id_instalacion);
        $this->instalacionModel->eliminar($id_instalacion);
        $_SESSION['mensaje'] = 'Instalación eliminada correctamente';
        header('Location: ' . URL_ROOT . '/instalaciones/index/' . $instalacion['id_caja']);
        exit;
    }
} 