<?php
/**
 * Clase Router - Manejo de rutas
 */
class Router {
    /**
     * Rutas disponibles en la aplicación
     */
    private static $routes = [
        '/' => ['controller' => 'HomeController', 'action' => 'index'],
        '/inicio' => ['controller' => 'HomeController', 'action' => 'index'],
        '/catalogo' => ['controller' => 'CatalogoController', 'action' => 'index'],
        '/catalogo/agregar' => ['controller' => 'CatalogoController', 'action' => 'agregar'],
        '/catalogo/guardar' => ['controller' => 'CatalogoController', 'action' => 'guardar'],
        '/catalogo/editar' => ['controller' => 'CatalogoController', 'action' => 'editar'],
        '/catalogo/actualizar' => ['controller' => 'CatalogoController', 'action' => 'actualizar'],
        '/catalogo/eliminar' => ['controller' => 'CatalogoController', 'action' => 'eliminar'],
        '/catalogo/ver' => ['controller' => 'CatalogoController', 'action' => 'ver'],
        '/consulta' => ['controller' => 'ConsultaController', 'action' => 'index'],
        '/soporte' => ['controller' => 'SoporteController', 'action' => 'index'],
        '/soporte/getNapInfo' => ['controller' => 'SoporteController', 'action' => 'getNapInfo'],
        '/soporte/hojaTecnica' => ['controller' => 'SoporteController', 'action' => 'hojaTecnica'],
        '/soporte/guardarHojaTecnica' => ['controller' => 'SoporteController', 'action' => 'guardarHojaTecnica'],
        '/soporte/crearTicket' => ['controller' => 'SoporteController', 'action' => 'crearTicket'],
        '/empresa' => ['controller' => 'EmpresaController', 'action' => 'index'],
        '/noticias' => ['controller' => 'NoticiasController', 'action' => 'index'],
        '/login' => ['controller' => 'AuthController', 'action' => 'login'],
        '/register' => ['controller' => 'AuthController', 'action' => 'register'],
        '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
        '/forgot' => ['controller' => 'AuthController', 'action' => 'forgot'],
        
        // Nuevas rutas para gestión de usuarios
        '/users' => ['controller' => 'UsersController', 'action' => 'index'],
        '/users/create' => ['controller' => 'UsersController', 'action' => 'create'],
        '/users/verDetalle' => ['controller' => 'UsersController', 'action' => 'verDetalle'],
        '/users/edit' => ['controller' => 'UsersController', 'action' => 'edit'],
        '/users/delete' => ['controller' => 'UsersController', 'action' => 'delete'],
        '/users/activate' => ['controller' => 'UsersController', 'action' => 'activate'],
        '/users/by-role' => ['controller' => 'UsersController', 'action' => 'byRole'],
        '/auth/google' => ['controller' => 'AuthController', 'action' => 'google'],
        '/auth/facebook' => ['controller' => 'AuthController', 'action' => 'facebook'],
        '/departamentos' => ['controller' => 'DepartamentoController', 'action' => 'create'],
        '/cajas_nap' => ['controller' => 'CajaNapController', 'action' => 'index'],
        '/cajas_nap/crear' => ['controller' => 'CajaNapController', 'action' => 'crear'],
        '/cajas_nap/guardar' => ['controller' => 'CajaNapController', 'action' => 'guardar'],
        '/cajas_nap/editar' => ['controller' => 'CajaNapController', 'action' => 'editar'],
        '/cajas_nap/actualizar' => ['controller' => 'CajaNapController', 'action' => 'actualizar'],
        '/cajas_nap/ver' => ['controller' => 'CajaNapController', 'action' => 'ver'],
        '/cajas_nap/eliminar' => ['controller' => 'CajaNapController', 'action' => 'eliminar'],
        '/puertos' => ['controller' => 'PuertoController', 'action' => 'index'],
        '/puertos/crear' => ['controller' => 'PuertoController', 'action' => 'crear'],
        '/puertos/guardar' => ['controller' => 'PuertoController', 'action' => 'guardar'],
        '/puertos/editar' => ['controller' => 'PuertoController', 'action' => 'editar'],
        '/puertos/actualizar' => ['controller' => 'PuertoController', 'action' => 'actualizar'],
        '/puertos/eliminar' => ['controller' => 'PuertoController', 'action' => 'eliminar'],
        '/puertos/ver' => ['controller' => 'PuertoController', 'action' => 'ver'],
        '/instalaciones' => ['controller' => 'InstalacionController', 'action' => 'index'],
        '/instalaciones/crear' => ['controller' => 'InstalacionController', 'action' => 'crear'],
        '/instalaciones/editar' => ['controller' => 'InstalacionController', 'action' => 'editar'],
        '/instalaciones/ver' => ['controller' => 'InstalacionController', 'action' => 'ver'],
        '/instalaciones/eliminar' => ['controller' => 'InstalacionController', 'action' => 'eliminar'],
        '/hoja_tecnica' => ['controller' => 'HojaTecnicaController', 'action' => 'index'],
        '/hoja_tecnica/seleccionar_caja' => ['controller' => 'HojaTecnicaController', 'action' => 'seleccionarCaja'],
        '/hoja_tecnica/crear' => ['controller' => 'HojaTecnicaController', 'action' => 'crear'],
        '/hoja_tecnica/editar' => ['controller' => 'HojaTecnicaController', 'action' => 'editar'],
        '/hoja_tecnica/ver' => ['controller' => 'HojaTecnicaController', 'action' => 'ver'],
        '/hoja_tecnica/eliminar' => ['controller' => 'HojaTecnicaController', 'action' => 'eliminar'],
        '/balanceados' => ['controller' => 'CalculoController', 'action' => 'balanceados'],
        '/balanceados/seleccionarNaps' => ['controller' => 'CalculoController', 'action' => 'seleccionarNaps'],
        '/balanceados/calcularBalanceado' => ['controller' => 'CalculoController', 'action' => 'calcularBalanceado'],
        '/desbalanceados' => ['controller' => 'CalculoController', 'action' => 'desbalanceados'],
        '/perfil' => ['controller' => 'UsersController', 'action' => 'perfil'],
        '/mediciones' => ['controller' => 'MedicionController', 'action' => 'index'],
        '/mediciones/crear' => ['controller' => 'MedicionController', 'action' => 'crear'],
        '/mediciones/editar' => ['controller' => 'MedicionController', 'action' => 'editar'],
        '/mediciones/ver' => ['controller' => 'MedicionController', 'action' => 'ver'],
        '/mediciones/eliminar' => ['controller' => 'MedicionController', 'action' => 'eliminar'],
        '/asignaciones' => ['controller' => 'AsignacionController', 'action' => 'index'],
        '/asignaciones/crear' => ['controller' => 'AsignacionController', 'action' => 'crear'],
        '/asignaciones/editar' => ['controller' => 'AsignacionController', 'action' => 'editar'],
        '/asignaciones/ver' => ['controller' => 'AsignacionController', 'action' => 'ver'],
        '/asignaciones/eliminar' => ['controller' => 'AsignacionController', 'action' => 'eliminar'],
    ];

    /**
     * Enruta la solicitud a la acción del controlador correspondiente
     * 
     * @param string $request URL solicitada
     * @return void
     */
    public static function route($request) {
        // Obtener la ruta base
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        
        // Para debug - guardar el basePath original
        $logFile = fopen('debug_log.txt', 'a');
        fwrite($logFile, date('Y-m-d H:i:s') . " - Original BasePath: " . $basePath . PHP_EOL);
        fwrite($logFile, date('Y-m-d H:i:s') . " - Original Request: " . $request . PHP_EOL);
        
        // Si el basePath es /FTTH1, necesitamos asegurarnos de que lo quitamos correctamente
        if ($basePath == '/FTTH1') {
            $request = preg_replace('#^/FTTH1/?#', '/', $request);
        } else {
            // Limpiar la ruta normalmente
            $request = str_replace($basePath, '', $request);
        }
        
        // Eliminar barras finales
        $request = rtrim($request, '/');
        
        // Si está vacío, es la ruta raíz
        if (empty($request)) {
            $request = '/';
        }

        // Para debug - escribir la ruta normalizada
        fwrite($logFile, date('Y-m-d H:i:s') . " - Normalized Request: " . $request . PHP_EOL);
        
        // Verificar si la ruta existe exactamente como está
        if (isset(self::$routes[$request])) {
            fwrite($logFile, date('Y-m-d H:i:s') . " - Route found: " . $request . PHP_EOL);
            fclose($logFile);
            
            $controller = self::$routes[$request]['controller'];
            $action = self::$routes[$request]['action'];
            
            // Instanciar el controlador
            $controllerInstance = new $controller();
            
            // Llamar a la acción
            $controllerInstance->$action();
            return;
        } 
        // Verificar si hay coincidencia parcial (para urls como /catalogo/1)
        else {
            $found = false;
            
            // Verificar si es una ruta con parámetros
            $parts = explode('/', $request);
            
            if (count($parts) >= 3) {
                // Obtener la ruta base sin el parámetro
                $baseRoute = '/' . $parts[1] . '/' . $parts[2];
                
                fwrite($logFile, date('Y-m-d H:i:s') . " - Checking route with parameters: " . $baseRoute . PHP_EOL);
                
                // Verificar si la ruta base existe
                if (isset(self::$routes[$baseRoute])) {
                    $controller = self::$routes[$baseRoute]['controller'];
                    $action = self::$routes[$baseRoute]['action'];
                    
                    // Obtener los parámetros adicionales
                    $params = array_slice($parts, 3);
                    
                    fwrite($logFile, date('Y-m-d H:i:s') . " - Route with parameters found: " . $baseRoute . " - Parameters: " . implode(',', $params) . PHP_EOL);
                    fclose($logFile);
                    
                    // Instanciar el controlador
                    $controllerInstance = new $controller();
                    
                    // Llamar a la acción con los parámetros
                    call_user_func_array([$controllerInstance, $action], $params);
                    return;
                }
            }
            
            // Buscar si la ruta comienza con alguna de las rutas conocidas
            foreach (self::$routes as $route => $routeInfo) {
                if ($route !== '/' && strpos($request, $route) === 0) {
                    fwrite($logFile, date('Y-m-d H:i:s') . " - Partial match: " . $route . " for " . $request . PHP_EOL);
                    
                    $controller = $routeInfo['controller'];
                    $action = $routeInfo['action'];
                    
                    // Extraer parámetros (si hay)
                    $params = [];
                    if (strlen($request) > strlen($route)) {
                        $paramString = substr($request, strlen($route) + 1); // +1 para la barra
                        $params = explode('/', $paramString);
                        
                        fwrite($logFile, date('Y-m-d H:i:s') . " - Extracted parameters: " . $paramString . PHP_EOL);
                    }
                    
                    fclose($logFile);
                    
                    // Instanciar el controlador
                    $controllerInstance = new $controller();
                    
                    // Llamar a la acción con parámetros si hay
                    if (!empty($params)) {
                        call_user_func_array([$controllerInstance, $action], $params);
                    } else {
                        $controllerInstance->$action();
                    }
                    
                    $found = true;
                    break;
                }
            }
            
            // Si no se encontró ninguna coincidencia
            if (!$found) {
                fwrite($logFile, date('Y-m-d H:i:s') . " - No route found for: " . $request . PHP_EOL);
                fclose($logFile);
                
                // Página no encontrada
                http_response_code(404);
                require_once 'views/error/404.php';
            }
        }
    }
}
?>