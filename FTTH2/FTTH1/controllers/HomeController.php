<?php
/**
 * Controlador para la página de inicio
 */
class HomeController extends Controller {
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar cualquier dependencia o modelo necesario
    }
    
    /**
     * Muestra la página de inicio
     */
    public function index() {
        // Datos para la vista
        $data = [
            'title' => 'SOLUFIBER S.R.L. - Gestión de Redes FTTH',
            'description' => 'Soluciones profesionales para la gestión y monitoreo de redes de fibra óptica FTTH',
            'active_page' => 'inicio'
        ];
        
        // Cargar la vista
        $this->view('sections/home', $data);
    }
}
?> 