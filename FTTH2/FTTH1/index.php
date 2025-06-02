<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cargar helpers
require_once 'helpers/session_helper.php';
require_once 'helpers/permission_helper.php';

// Cargar configuración
require_once 'config/config.php';
require_once 'config/routes.php';

// Autoload de clases (modelos y controladores)
spl_autoload_register(function($class) {
    // Verificar si es un modelo
    if (file_exists('models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    }
    // Verificar si es un controlador
    elseif (file_exists('controllers/' . $class . '.php')) {
        require_once 'controllers/' . $class . '.php';
    }
});

// Iniciar la sesión
session_start();

// Obtener la URL solicitada
$request = $_SERVER['REQUEST_URI'];

// Para depuración - guardar en un archivo de log
$logFile = fopen('debug_log.txt', 'a');
fwrite($logFile, date('Y-m-d H:i:s') . " - Request: " . $request . PHP_EOL);

// Eliminar posibles parámetros de consulta
$request = strtok($request, '?');

// Para depuración
fwrite($logFile, date('Y-m-d H:i:s') . " - Cleaned Request: " . $request . PHP_EOL);
fwrite($logFile, date('Y-m-d H:i:s') . " - Script Name: " . $_SERVER['SCRIPT_NAME'] . PHP_EOL);
fwrite($logFile, date('Y-m-d H:i:s') . " - Base Path: " . dirname($_SERVER['SCRIPT_NAME']) . PHP_EOL);
fclose($logFile);

// Enrutar la solicitud
Router::route($request);
?> 