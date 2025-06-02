<?php
class CatalogoController extends Controller {
    private $productoModel;
    public function __construct() {
        $this->productoModel = $this->model('Producto');
    }
    public function index() {
        $productos = $this->productoModel->obtenerTodos();
        $data = ['title' => 'Catálogo', 'productos' => $productos];
        $this->view('catalogo/index', $data);
    }
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            // Procesar imagen subida
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/img/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                    $data['imagen'] = $fileName;
                } else {
                    $data['imagen'] = '';
                }
            } else {
                $data['imagen'] = '';
            }
            if (empty($data['imagen'])) {
                die('Error: Debes subir una imagen.');
            }
            $this->productoModel->crear($data);
            header('Location: ' . URL_ROOT . '/catalogo');
            exit;
        }
        $data = ['title' => 'Nuevo Producto'];
        $this->view('catalogo/crear', $data);
    }
    public function editar($id) {
        $producto = $this->productoModel->obtenerPorId($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            // Procesar imagen si se sube una nueva
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/img/productos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '_' . basename($_FILES['imagen']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadFile)) {
                    $data['imagen'] = $fileName;
                } else {
                    $data['imagen'] = $producto['imagen'];
                }
            } else {
                $data['imagen'] = $producto['imagen'];
            }
            $this->productoModel->actualizar($id, $data);
            header('Location: ' . URL_ROOT . '/catalogo');
            exit;
        }
        $data = ['title' => 'Editar Producto', 'producto' => $producto];
        $this->view('catalogo/editar', $data);
    }
    public function eliminar($id) {
        $this->productoModel->eliminar($id);
        header('Location: ' . URL_ROOT . '/catalogo');
        exit;
    }
    public function ver($id) {
        $producto = $this->productoModel->obtenerPorId($id);
        $data = ['title' => 'Detalle Producto', 'producto' => $producto];
        $this->view('catalogo/ver', $data);
    }
} 