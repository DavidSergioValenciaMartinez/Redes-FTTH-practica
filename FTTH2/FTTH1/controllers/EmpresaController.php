<?php
/**
 * Controlador de la sección Empresa
 */
class EmpresaController extends Controller {
    
    /**
     * Constructor
     */
    public function __construct() {
        // No llamar al constructor del padre, ya que Controller no tiene constructor
    }
    
    /**
     * Método index - Muestra la página principal de Empresa
     */
    public function index() {
        // Redirigir a la página de inicio ya que hemos integrado el contenido de empresa allí
        header('Location: ' . URL_ROOT . '/inicio');
        exit;
    }
    
    /**
     * Método contactar - Procesa el formulario de contacto de la empresa
     */
    public function contactar() {
        // Verificar que sea una petición POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitizar datos
            $nombre = trim(filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING));
            $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
            $telefono = trim(filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING));
            $empresa = trim(filter_input(INPUT_POST, 'empresa', FILTER_SANITIZE_STRING));
            $interes = trim(filter_input(INPUT_POST, 'interes', FILTER_SANITIZE_STRING));
            $mensaje = trim(filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING));
            
            // Validar datos (validación básica)
            if (empty($nombre) || empty($email) || empty($mensaje)) {
                $_SESSION['error'] = 'Por favor, complete todos los campos requeridos.';
                header('Location: ' . URL_ROOT . '/inicio');
                exit;
            }
            
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Por favor, ingrese un email válido.';
                header('Location: ' . URL_ROOT . '/inicio');
                exit;
            }
            
            // Aquí se procesaría el envío del correo o guardado en base de datos
            // ... (código para enviar o guardar el mensaje)
            
            // Mensaje de éxito y redirección
            $_SESSION['mensaje'] = 'Su mensaje ha sido enviado correctamente. Nos pondremos en contacto con usted a la brevedad.';
            header('Location: ' . URL_ROOT . '/inicio');
            exit;
        } else {
            // Si no es POST, redireccionar a la página de empresa
            header('Location: ' . URL_ROOT . '/inicio');
            exit;
        }
    }
    
}
?> 