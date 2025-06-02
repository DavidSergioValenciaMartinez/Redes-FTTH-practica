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
            $data = $_POST;
            if (empty($data['cliente_usuario_id'])) {
                $data['cliente_usuario_id'] = null;
            }
            $this->puertoModel->crear($data);
            // Actualizar contadores en la caja NAP
            if (isset($data['id_caja'])) {
                $caja = $this->cajaNapModel->obtenerPorId($data['id_caja']);
                if ($caja) {
                    $ocupados = $caja['puertos_ocupados'];
                    $disponibles = $caja['puertos_disponibles'];
                    if (isset($data['estado']) && $data['estado'] === 'ocupado') {
                        $ocupados++;
                        $disponibles = max(0, $disponibles - 1);
                    }
                    $this->cajaNapModel->actualizar($data['id_caja'], [
                        'id_departamento' => $caja['id_departamento'],
                        'codigo_caja' => $caja['codigo_caja'],
                        'ubicacion' => $caja['ubicacion'],
                        'total_puertos' => $caja['total_puertos'],
                        'puertos_disponibles' => $disponibles,
                        'puertos_ocupados' => $ocupados,
                        'potencia_dbm' => $caja['potencia_dbm'],
                        'estado' => $caja['estado'],
                        'fabricante' => $caja['fabricante'],
                        'modelo' => $caja['modelo'],
                        'capacidad' => $caja['capacidad']
                    ]);
                }
            }
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
            $data = $_POST;
            // Si numero_puerto no viene en el POST, tomarlo del registro original
            if (empty($data['numero_puerto'])) {
                $puerto = $this->puertoModel->obtenerPorId($id);
                $data['numero_puerto'] = $puerto['numero_puerto'];
            }
            $this->puertoModel->actualizar($id, $data);
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