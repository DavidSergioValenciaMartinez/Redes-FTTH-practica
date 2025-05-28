<?php
/**
 * Controlador para la autenticación de usuarios
 */
class AuthController extends Controller {
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar cualquier dependencia o modelo necesario
    }
    
    /**
     * Método para mostrar y procesar el formulario de login
     */
    public function login() {
        // Si ya está logueado, redirigir a inicio
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar login
            $correo = $_POST['correo'] ?? '';
            $contrasena = $_POST['contrasena'] ?? '';
            $rememberMe = isset($_POST['rememberMe']);
            
            // Verificar credenciales con el modelo de usuario
            $userModel = new UserModel();
            $user = $userModel->authenticate($correo, $contrasena);
            
            if ($user) {
                // Establecer sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                // Redirigir a inicio
                $this->redirect('/');
            } else {
                // Mostrar página de login con error
                $data = [
                    'title' => 'Iniciar Sesión - SOLUFIBER S.R.L.',
                    'currentSection' => '',
                    'error' => 'Credenciales inválidas'
                ];
                
                $this->view('auth/login', $data);
            }
        } else {
            // Mostrar formulario de login
            $data = [
                'title' => 'Iniciar Sesión - SOLUFIBER S.R.L.',
                'currentSection' => ''
            ];
            
            $this->view('auth/login', $data);
        }
    }
    
    /**
     * Método para mostrar y procesar el formulario de registro
     */
    public function register() {
        // Si ya está logueado, redirigir a inicio
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar registro
            $userData = [
                'nombre_completo' => $_POST['nombre_completo'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'contrasena' => $_POST['contrasena'] ?? '',
                'contrasena_confirm' => $_POST['contrasena_confirm'] ?? ''
            ];
            $error = null;
            // Validar que el correo no sea de staff
            $email = $userData['correo'];
            if (strpos($email, '@solufiber-srl.com') !== false) {
                $error = 'Las cuentas con dominio @solufiber-srl.com están reservadas para el personal de Solufiber';
            }
            if ($error) {
                $data = [
                    'title' => 'Registro - SOLUFIBER S.R.L.',
                    'currentSection' => '',
                    'error' => $error,
                    'userData' => $userData
                ];
                $this->view('auth/register', $data);
                return;
            }
            // Proceder con el registro
            $userModel = new UserModel();
            $result = $userModel->register($userData);
            if ($result) {
                // Insertar en tbl_clientes
                $userModel->insertCliente($result);
                // Establecer sesión directamente (iniciar sesión automáticamente)
                $_SESSION['user_id'] = $result;
                $_SESSION['user_name'] = $userData['nombre_completo'];
                $_SESSION['user_email'] = $userData['correo'];
                $_SESSION['user_role'] = 'cliente';
                $_SESSION['mensaje'] = 'Registro exitoso. ¡Bienvenido a SOLUFIBER S.R.L.!';
                $this->redirect('/');
            } else {
                $data = [
                    'title' => 'Registro - SOLUFIBER S.R.L.',
                    'currentSection' => '',
                    'error' => 'Error en el registro. Es posible que el correo ya esté registrado.',
                    'userData' => $userData
                ];
                $this->view('auth/register', $data);
            }
        } else {
            $data = [
                'title' => 'Registro - SOLUFIBER S.R.L.',
                'currentSection' => ''
            ];
            $this->view('auth/register', $data);
        }
    }
    
    /**
     * Método para cerrar sesión
     */
    public function logout() {
        // Destruir la sesión
        session_unset();
        session_destroy();
        
        // Redirigir a inicio
        $this->redirect('/');
    }
    
    /**
     * Obtiene el nombre del rol en español
     * 
     * @param string $role Código del rol
     * @return string Nombre del rol en español
     */
    private function getRoleName($role) {
        $roles = [
            'client' => 'Cliente',
            'technician' => 'Técnico',
            'operator' => 'Operador',
            'admin' => 'Administrador'
        ];
        
        return $roles[$role] ?? 'Usuario';
    }
    
    /**
     * Mostrar y procesar formulario de recuperación de contraseña
     */
    public function forgot() {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $telefono = $_POST['telefono'] ?? '';
            if (empty($telefono)) {
                $mensaje = 'Por favor ingrese su número de WhatsApp.';
            } else {
                // Buscar usuario por teléfono
                $userModel = new UserModel();
                $user = $userModel->getByPhone($telefono);
                if ($user) {
                    // Enviar WhatsApp con Twilio
                    require_once __DIR__ . '/../../vendor/autoload.php';
                    $sid = 'TU_TWILIO_SID'; // Reemplaza por tu SID
                    $token = 'TU_TWILIO_AUTH_TOKEN'; // Reemplaza por tu token
                    $twilioNumber = 'whatsapp:+14155238886'; // Número de WhatsApp de Twilio (sandbox)
                    $client = new \Twilio\Rest\Client($sid, $token);
                    $mensajeTexto = 'Hola ' . $user['nombre_completo'] . ', para restablecer tu contraseña ingresa a: ' . URL_ROOT . '/reset-password?user=' . $user['id_usuario'];
                    try {
                        $client->messages->create(
                            'whatsapp:+' . $telefono, // El número del usuario
                            [
                                'from' => $twilioNumber,
                                'body' => $mensajeTexto
                            ]
                        );
                        $mensaje = 'Se enviaron las instrucciones a tu WhatsApp.';
                    } catch (Exception $e) {
                        $mensaje = 'No se pudo enviar el mensaje de WhatsApp. Intente más tarde.';
                    }
                } else {
                    $mensaje = 'Si el número existe en nuestro sistema, recibirá instrucciones para restablecer su contraseña.';
                }
            }
        }
        $data = [
            'title' => 'Recuperar Contraseña',
            'mensaje' => $mensaje
        ];
        $this->view('auth/forgot', $data);
    }
}
?> 