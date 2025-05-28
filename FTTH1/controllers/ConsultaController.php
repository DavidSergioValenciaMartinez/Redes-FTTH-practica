<?php
/**
 * Controlador para la sección de consulta
 */
class ConsultaController extends Controller {
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar cualquier dependencia o modelo necesario
    }
    
    /**
     * Método para mostrar la página de consulta
     */
    public function index() {
        $data = [
            'title' => 'Consulta y Monitoreo - SOLUFIBER S.R.L.',
            'currentSection' => 'consulta'
        ];
        
        $this->view('sections/consulta', $data);
    }
    
    /**
     * Método para verificar una caja NAP (para llamada AJAX)
     */
    public function verificarNap() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['napId'])) {
            $napId = $_POST['napId'];
            
            // Aquí iría la lógica de verificación real
            $result = ['success' => true, 'message' => 'NAP verificada correctamente'];
            
            // Devolver JSON
            header('Content-Type: application/json');
            echo json_encode($result);
        } else {
            // Error si no es POST o falta el ID
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Solicitud inválida']);
        }
        exit;
    }
}
?> 