<?php
/**
 * Clase Controller base
 * Proporciona métodos comunes para todos los controladores
 */
class Controller {
    /**
     * Carga un modelo
     *
     * @param string $model Nombre del modelo
     * @return object Instancia del modelo
     */
    protected function model($model) {
        // Cargar archivo del modelo
        require_once 'models/' . $model . '.php';

        // Instanciar el modelo
        return new $model();
    }

    /**
     * Renderiza una vista
     *
     * @param string $view Nombre de la vista
     * @param array $data Datos que se pasan a la vista
     * @return void
     */
    protected function view($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        if (!empty($data)) {
            extract($data);
        }

        // Incluir el header
        require_once 'views/layouts/header.php';

        // Incluir la vista solicitada
        require_once 'views/' . $view . '.php';

        // Incluir el footer
        require_once 'views/layouts/footer.php';
    }

    /**
     * Redirige a otra página
     *
     * @param string $url URL a la que redirigir
     * @return void
     */
    protected function redirect($url) {
        header('Location: ' . URL_ROOT . $url);
        exit;
    }

    /**
     * Renderiza una vista sin el layout completo (para AJAX o componentes parciales)
     *
     * @param string $view Nombre de la vista
     * @param array $data Datos que se pasan a la vista
     * @return void
     */
    protected function partial($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        if (!empty($data)) {
            extract($data);
        }

        // Incluir solo la vista solicitada
        require_once 'views/' . $view . '.php';
    }
}
?>