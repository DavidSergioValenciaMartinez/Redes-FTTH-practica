<?php
// Configuración general de la aplicación
define('SITE_NAME', 'SOLUFIBER S.R.L.');
define('APP_ROOT', dirname(dirname(__FILE__)));
define('URL_ROOT', 'http://localhost/FTTH1');
define('URL_SUBFOLDER', '');
define('BASE_URL', 'http://localhost/FTTH1');
define('URL_PUBLIC', 'http://localhost/FTTH1/public');
define('VIEWS_PATH', APP_ROOT . '/views');

// Configuración de la base de datos
define('DB_HOST', 'localhost:3306');
define('DB_USER', 'root');
define('DB_PASS', '12345678');
define('DB_NAME', 'solufiber_ftth');

// Configuración de sesiones
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Cambiar a 1 en producción con HTTPS

// Zona horaria
date_default_timezone_set('Europe/Madrid');

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1); // Cambiar a 0 en producción
?> 