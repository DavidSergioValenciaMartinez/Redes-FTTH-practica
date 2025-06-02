<?php
require_once __DIR__ . '/../models/HojaTecnica.php';
require_once __DIR__ . '/../models/CajaNap.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../helpers/session_helper.php';

class HojaTecnicaController extends Controller {
    private $hojaTecnicaModel;
    private $cajaNapModel;
    private $usuarioModel;
    
    public function __construct() {
        $db = new Database();
        $this->hojaTecnicaModel = new HojaTecnica($db->connect());
        $this->cajaNapModel = new CajaNap($db->connect());
        $this->usuarioModel = new Usuario($db->connect());
    }
    
    public function index() {
        $hojasTecnicas = $this->hojaTecnicaModel->obtenerTodas();
        $data = [
            'title' => 'Hojas Técnicas',
            'hojas_tecnicas' => $hojasTecnicas
        ];
        $this->view('hoja_tecnica/index', $data);
    }
    
    public function seleccionarCaja() {
        $data = [
            'title' => 'Seleccionar Caja NAP',
            'cajas' => $this->cajaNapModel->obtenerTodas()
        ];
        $this->view('hoja_tecnica/seleccionar_caja', $data);
    }
    
    public function crear($id_caja = null) {
        // Si no se proporciona ID de caja o no es una solicitud POST con id_caja, redirigir a la selección
        if (!$id_caja && (!isset($_POST['id_caja']) || empty($_POST['id_caja']))) {
            redirect('/hoja_tecnica/seleccionar_caja');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Si es el formulario de selección de caja
            if (isset($_POST['id_caja']) && !isset($_POST['id_tecnico'])) {
                $id_caja = $_POST['id_caja'];
                // Obtener técnicos y clientes
                $tecnicos = $this->usuarioModel->obtenerPorRol('tecnico');
                $clientes = $this->usuarioModel->obtenerPorRol('cliente');
                
                // Obtener datos de la caja
                $caja = $this->cajaNapModel->obtenerPorId($id_caja);
                if (!$caja) {
                    flash('mensaje', 'Caja NAP no encontrada', 'alert alert-danger');
                    redirect('/hoja_tecnica');
                    return;
                }
                
                $data = [
                    'title' => 'Crear Hoja Técnica',
                    'caja' => $caja,
                    'tecnicos' => $tecnicos,
                    'clientes' => $clientes
                ];
                
                $this->view('hoja_tecnica/crear', $data);
                return;
            }
            // Si es el formulario completo de hoja técnica
            else if (isset($_POST['id_tecnico'])) {
                $data = [
                    'id_caja' => $id_caja,
                    'id_tecnico' => $_POST['id_tecnico'],
                    'cliente_usuario_id' => $_POST['cliente_usuario_id'] ?: null,
                    'tipo_trabajo' => $_POST['tipo_trabajo'],
                    'fabricante' => $_POST['fabricante'],
                    'modelo' => $_POST['modelo'],
                    'numero_serie' => $_POST['numero_serie'],
                    'codigo_caja' => $_POST['codigo_caja'],
                    'ubicacion' => $_POST['ubicacion'],
                    'capacidad' => $_POST['capacidad'],
                    'total_puertos' => $_POST['total_puertos'],
                    'puertos_disponibles' => $_POST['puertos_disponibles'],
                    'puertos_ocupados' => $_POST['puertos_ocupados'],
                    'potencia_dbm' => $_POST['potencia_dbm'],
                    'estado' => $_POST['estado'],
                    'tipo_caja' => $_POST['tipo_caja'],
                    'tipo_conector' => $_POST['tipo_conector'],
                    'dimensiones' => $_POST['dimensiones'],
                    'material' => $_POST['material'],
                    'grado_proteccion' => $_POST['grado_proteccion'],
                    'descripcion_equipo' => $_POST['descripcion_equipo'],
                    'codigo_qr' => $_POST['codigo_qr'],
                    'observaciones' => $_POST['observaciones']
                ];
                
                if ($this->hojaTecnicaModel->crear($data)) {
                    // Actualizar puertos disponibles y ocupados en la caja NAP
                    $caja = $this->cajaNapModel->obtenerPorId($id_caja);
                    if ($caja) {
                        $cajaData = [
                            'id_departamento' => $caja['id_departamento'],
                            'codigo_caja' => $caja['codigo_caja'],
                            'ubicacion' => $caja['ubicacion'],
                            'total_puertos' => $caja['total_puertos'],
                            'puertos_disponibles' => $caja['puertos_disponibles'] - 1,
                            'puertos_ocupados' => $caja['puertos_ocupados'] + 1,
                            'potencia_dbm' => $caja['potencia_dbm'],
                            'estado' => $caja['estado'],
                            'fabricante' => $caja['fabricante'],
                            'modelo' => $caja['modelo'],
                            'capacidad' => $caja['capacidad']
                        ];
                        $this->cajaNapModel->actualizar($id_caja, $cajaData);
                    }
                    
                    flash('mensaje', 'Hoja técnica creada correctamente', 'alert alert-success');
                    redirect('/hoja_tecnica');
                } else {
                    flash('mensaje', 'Error al crear la hoja técnica', 'alert alert-danger');
                }
            }
        }
        
        // Obtener técnicos y clientes
        $tecnicos = $this->usuarioModel->obtenerPorRol('tecnico');
        $clientes = $this->usuarioModel->obtenerPorRol('cliente');
        
        // Obtener datos de la caja
        $caja = $this->cajaNapModel->obtenerPorId($id_caja);
        if (!$caja) {
            flash('mensaje', 'Caja NAP no encontrada', 'alert alert-danger');
            redirect('/hoja_tecnica');
        }
        
        $data = [
            'title' => 'Crear Hoja Técnica',
            'caja' => $caja,
            'tecnicos' => $tecnicos,
            'clientes' => $clientes
        ];
        
        $this->view('hoja_tecnica/crear', $data);
    }
    
    public function editar($id_hoja_caja) {
        $hojaTecnica = $this->hojaTecnicaModel->obtenerPorId($id_hoja_caja);
        if (!$hojaTecnica) {
            flash('mensaje', 'Hoja técnica no encontrada', 'alert alert-danger');
            redirect('/hoja_tecnica');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id_tecnico' => $_POST['id_tecnico'],
                'cliente_usuario_id' => $_POST['cliente_usuario_id'] ?: null,
                'tipo_trabajo' => $_POST['tipo_trabajo'],
                'fabricante' => $_POST['fabricante'],
                'modelo' => $_POST['modelo'],
                'numero_serie' => $_POST['numero_serie'],
                'codigo_caja' => $_POST['codigo_caja'],
                'ubicacion' => $_POST['ubicacion'],
                'capacidad' => $_POST['capacidad'],
                'total_puertos' => $_POST['total_puertos'],
                'puertos_disponibles' => $_POST['puertos_disponibles'],
                'puertos_ocupados' => $_POST['puertos_ocupados'],
                'potencia_dbm' => $_POST['potencia_dbm'],
                'estado' => $_POST['estado'],
                'tipo_caja' => $_POST['tipo_caja'],
                'tipo_conector' => $_POST['tipo_conector'],
                'dimensiones' => $_POST['dimensiones'],
                'material' => $_POST['material'],
                'grado_proteccion' => $_POST['grado_proteccion'],
                'descripcion_equipo' => $_POST['descripcion_equipo'],
                'codigo_qr' => $_POST['codigo_qr'],
                'observaciones' => $_POST['observaciones']
            ];
            
            if ($this->hojaTecnicaModel->actualizar($id_hoja_caja, $data)) {
                flash('mensaje', 'Hoja técnica actualizada correctamente', 'alert alert-success');
                redirect('/hoja_tecnica');
            } else {
                flash('mensaje', 'Error al actualizar la hoja técnica', 'alert alert-danger');
            }
        }
        
        $data = [
            'title' => 'Editar Hoja Técnica',
            'hoja_tecnica' => $hojaTecnica
        ];
        
        $this->view('hoja_tecnica/editar', $data);
    }
    
    public function ver($id_hoja_caja) {
        $hojaTecnica = $this->hojaTecnicaModel->obtenerPorId($id_hoja_caja);
        if (!$hojaTecnica) {
            flash('mensaje', 'Hoja técnica no encontrada', 'alert alert-danger');
            redirect('/hoja_tecnica');
        }
        
        $data = [
            'title' => 'Ver Hoja Técnica',
            'hoja_tecnica' => $hojaTecnica
        ];
        
        $this->view('hoja_tecnica/ver', $data);
    }
    
    public function eliminar($id_hoja_caja) {
        if ($this->hojaTecnicaModel->eliminar($id_hoja_caja)) {
            flash('mensaje', 'Hoja técnica eliminada correctamente', 'alert alert-success');
        } else {
            flash('mensaje', 'Error al eliminar la hoja técnica', 'alert alert-danger');
        }
        redirect('/hoja_tecnica');
    }
} 