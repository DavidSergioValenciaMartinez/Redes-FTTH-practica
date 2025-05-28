<?php
/**
 * Controlador para la gestión del perfil de usuario
 */
class ProfileController extends Controller {
    /**
     * Modelo de usuarios
     * @var UserModel
     */
    private $userModel;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Verificar si el usuario ha iniciado sesión
        if (!isLoggedIn()) {
            redirect('auth/login');
        }
        
        // Cargar el modelo de usuario
        $this->userModel = $this->model('UserModel');
    }
    
    /**
     * Mostrar el perfil del usuario actual
     */
    public function index() {
        // Obtener los datos del usuario actual
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getById($userId);
        
        if (!$user) {
            flash('profile_message', 'No se pudo obtener la información del perfil', 'alert alert-danger');
            redirect('home');
        }
        
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user,
            'nombre_completo_err' => '',
            'correo_err' => ''
        ];
        
        $this->view('profile/index', $data);
    }
    
    /**
     * Mostrar formulario para editar perfil
     */
    public function edit() {
        // Obtener los datos del usuario actual
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getUserById($userId);
        
        if (!$userData) {
            flash('profile_error', 'No se pudo obtener la información del perfil', 'alert alert-danger');
            redirect('profile');
        }
        
        $data = [
            'title' => 'Editar Perfil',
            'nombre_completo' => $userData->nombre_completo,
            'correo' => $userData->correo,
            'telefono' => $userData->telefono,
            'direccion' => $userData->direccion,
            'nombre_completo_err' => '',
            'correo_err' => '',
            'telefono_err' => '',
            'direccion_err' => '',
            'current_password_err' => '',
            'new_password_err' => '',
            'confirm_password_err' => ''
        ];
        
        $this->view('profile/edit', $data);
    }
    
    /**
     * Procesar actualización del perfil
     */
    public function update() {
        // Verificar que sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('profile');
        }
        
        // Procesar el formulario
        // Sanitizar los datos POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Obtener los datos del usuario actual
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getById($userId);
        
        $data = [
            'title' => 'Editar Perfil',
            'userId' => $userId,
            'nombre_completo' => trim($_POST['nombre_completo']),
            'correo' => trim($_POST['correo']),
            'telefono' => $userData['telefono'] ?? '',
            'direccion' => $userData['direccion'] ?? '',
            'nombre_completo_err' => '',
            'correo_err' => ''
        ];
        
        // Validar nombre
        if (empty($data['nombre_completo'])) {
            $data['nombre_completo_err'] = 'Por favor ingrese su nombre completo';
        }
        
        // Validar correo (solo si es cliente)
        $isClient = (strpos($userData['correo'], '@solufiber-srl.com') === false);
        
        if ($isClient) {
            if (empty($data['correo'])) {
                $data['correo_err'] = 'Por favor ingrese un correo electrónico';
            } elseif (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
                $data['correo_err'] = 'Por favor ingrese un correo electrónico válido';
            } elseif ($data['correo'] != $userData['correo']) {
                // Verificar si el correo ya está registrado por otro usuario
                if ($this->userModel->findUserByEmail($data['correo'])) {
                    $data['correo_err'] = 'El correo ya está registrado por otro usuario';
                }
            }
        } else {
            // Si no es cliente, mantener el correo original
            $data['correo'] = $userData['correo'];
        }
        
        // Verificar errores antes de actualizar
        if (empty($data['nombre_completo_err']) && empty($data['correo_err'])) {
            // Actualizar usuario
            if ($this->userModel->updateProfile($userId, $data)) {
                // Actualizar la sesión con el nuevo nombre si es necesario
                if ($_SESSION['user_name'] != $data['nombre_completo']) {
                    $_SESSION['user_name'] = $data['nombre_completo'];
                }
                
                flash('profile_message', 'Su perfil ha sido actualizado correctamente', 'alert alert-success');
                redirect('profile');
            } else {
                flash('profile_message', 'Ocurrió un error al actualizar su perfil', 'alert alert-danger');
                $data['user'] = $userData;
                $this->view('profile/index', $data);
            }
        } else {
            // Cargar la vista con errores
            $data['user'] = $userData;
            $this->view('profile/index', $data);
        }
    }
    
    /**
     * Mostrar formulario para cambiar contraseña
     */
    public function password() {
        // Obtener los datos del usuario actual
        $userId = $_SESSION['user_id'];
        $user = $this->userModel->getById($userId);
        
        if (!$user) {
            flash('profile_message', 'No se pudo obtener la información del perfil', 'alert alert-danger');
            redirect('profile');
        }
        
        $data = [
            'title' => 'Cambiar Contraseña',
            'user' => $user,
            'current_password_err' => '',
            'new_password_err' => '',
            'confirm_password_err' => ''
        ];
        
        $this->view('profile/change_password', $data);
    }
    
    /**
     * Actualizar contraseña
     */
    public function updatePassword() {
        // Verificar que sea una solicitud POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('profile');
        }
        
        // Procesar el formulario
        // Sanitizar los datos POST
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        $userId = $_SESSION['user_id'];
        $userData = $this->userModel->getById($userId);
        
        $data = [
            'title' => 'Cambiar Contraseña',
            'user' => $userData,
            'current_password' => trim($_POST['current_password']),
            'new_password' => trim($_POST['new_password']),
            'confirm_password' => trim($_POST['confirm_password']),
            'current_password_err' => '',
            'new_password_err' => '',
            'confirm_password_err' => ''
        ];
        
        // Validar contraseña actual
        if (empty($data['current_password'])) {
            $data['current_password_err'] = 'Por favor ingrese su contraseña actual';
        } elseif (!password_verify($data['current_password'], $userData['contrasena_hash'])) {
            $data['current_password_err'] = 'La contraseña actual es incorrecta';
        }
        
        // Validar nueva contraseña
        if (empty($data['new_password'])) {
            $data['new_password_err'] = 'Por favor ingrese la nueva contraseña';
        } elseif (strlen($data['new_password']) < 8) {
            $data['new_password_err'] = 'La contraseña debe tener al menos 8 caracteres';
        }
        
        // Validar confirmación de contraseña
        if (empty($data['confirm_password'])) {
            $data['confirm_password_err'] = 'Por favor confirme la nueva contraseña';
        } elseif ($data['new_password'] != $data['confirm_password']) {
            $data['confirm_password_err'] = 'Las contraseñas no coinciden';
        }
        
        // Verificar errores antes de actualizar
        if (empty($data['current_password_err']) && empty($data['new_password_err']) && 
            empty($data['confirm_password_err'])) {
            
            // Hash de la nueva contraseña
            $data['new_password'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
            
            // Actualizar contraseña
            if ($this->userModel->updatePassword($userId, $data['new_password'])) {
                // Cerrar sesión para que el usuario inicie sesión con la nueva contraseña
                logout();
                flash('login_success', 'Su contraseña ha sido actualizada. Por favor inicie sesión nuevamente.', 'alert alert-success');
                redirect('auth/login');
            } else {
                flash('profile_message', 'Ocurrió un error al actualizar su contraseña', 'alert alert-danger');
                $this->view('profile/change_password', $data);
            }
        } else {
            // Cargar la vista con errores
            $this->view('profile/change_password', $data);
        }
    }
    
    /**
     * Mostrar histórico de actividades del usuario
     */
    public function activity() {
        $userId = $_SESSION['user_id'];
        $activities = $this->userModel->getUserActivities($userId);
        
        $data = [
            'title' => 'Historial de Actividad',
            'activities' => $activities
        ];
        
        $this->view('profile/activity', $data);
    }
}
?> 
?> 