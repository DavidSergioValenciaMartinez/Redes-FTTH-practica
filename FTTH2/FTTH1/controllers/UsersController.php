<?php
/**
 * Controlador para la sección de usuarios
 */
class UsersController extends Controller {
    /**
     * Modelo de usuarios
     * @var UserModel
     */
    protected $userModel;
    
    /**
     * Conexión a la base de datos
     * @var PDO
     */
    protected $db;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar modelo de usuarios
        $this->userModel = new UserModel();
        
        // Inicializar la conexión a la base de datos
        try {
            $host = 'localhost:3306';
            $dbname = 'solufiber_ftth';
            $username = 'root';
            $password = '12345678';
            
            $this->db = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
        
        // Verificar si el usuario está autenticado para la mayoría de acciones
        // Excepto login y registro
        $allowedActions = ['login', 'register', 'authenticate'];
        $currentAction = isset($_GET['action']) ? $_GET['action'] : '';
        
        if (!in_array($currentAction, $allowedActions) && !isset($_SESSION['user_id'])) {
            header('Location: ' . URL_ROOT . '/login');
            exit;
        }
        
        // Verificar permisos para acciones administrativas
        $adminActions = ['index', 'create', 'edit', 'delete', 'activate', 'deactivate'];
        
        if (in_array($currentAction, $adminActions) && 
            (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@solufiber-srl.com')) {
            header('Location: ' . URL_ROOT . '/');
            exit;
        }
    }
    
    /**
     * Mostrar listado de usuarios
     */
    public function index() {
        $showInactive = isset($_GET['includeInactive']) && $_GET['includeInactive'] == 1;
        
        $data = [
            'title' => 'Gestión de Usuarios - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'users' => $this->userModel->getAll(),
            'showInactive' => $showInactive
        ];
        
        $this->view('users/index', $data);
    }
    
    /**
     * Ver detalles de un usuario
     */
    public function verDetalle($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        
        $data = [
            'title' => 'Detalles de Usuario - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'user' => $user
        ];
        
        $this->view('users/view', $data);
    }
    
    /**
     * Crear nuevo usuario
     */
    public function create() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recoger datos del formulario
            $userData = [
                'nombre_completo' => $_POST['nombre_completo'] ?? '',
                'correo' => $_POST['correo'] ?? '',
                'contrasena' => $_POST['contrasena'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'direccion' => $_POST['direccion'] ?? '',
                'cedula_identidad' => $_POST['cedula_identidad'] ?? '',
                'nombre_usuario' => $_POST['nombre_usuario'] ?? '',
                'fecha_nacimiento' => $_POST['fecha_nacimiento'] ?? '',
            ];
            $rol = $_POST['rol_usuario'] ?? '';
            // Validar edad mínima
            if (!empty($userData['fecha_nacimiento'])) {
                $fecha = new DateTime($userData['fecha_nacimiento']);
                $hoy = new DateTime();
                $edad = $hoy->diff($fecha)->y;
                if ($edad < 18) {
                    $error = 'El usuario debe ser mayor o igual a 18 años.';
                }
            }
            // Validar que la fotografía esté presente y procesarla
            if (!isset($_FILES['fotografia']) || $_FILES['fotografia']['error'] !== UPLOAD_ERR_OK) {
                $error = 'Debe subir una fotografía.';
            } else {
                $uploadDir = __DIR__ . '/../../public/uploads/fotos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '_' . basename($_FILES['fotografia']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $uploadFile)) {
                    $userData['fotografia'] = '/uploads/fotos/' . $fileName;
                } else {
                    $error = 'Error al subir la fotografía.';
                }
            }
            // Validar campos obligatorios
            foreach(['nombre_completo','correo','contrasena','cedula_identidad','nombre_usuario','fecha_nacimiento','fotografia'] as $campo) {
                if (empty($userData[$campo])) {
                    $error = 'Todos los campos son obligatorios.';
                    break;
                }
            }
            if ($error) {
                $data = [
                    'title' => 'Crear Usuario - SOLUFIBER S.R.L.',
                    'currentSection' => 'usuarios',
                    'error' => $error
                ];
                $this->view('users/create', $data);
                return;
            }
            // Registrar usuario
            $userId = $this->userModel->register($userData);
            if ($userId) {
                // Insertar en la tabla de rol correspondiente
                if ($rol === 'admin') {
                    $nivel_acceso = $_POST['nivel_acceso'] ?? 'total';
                    $this->userModel->insertAdmin($userId, $nivel_acceso);
                } else if ($rol === 'tecnico') {
                    $certificacion = $_POST['certificacion'] ?? '';
                    $area_asignada = $_POST['area_asignada'] ?? '';
                    $this->userModel->insertTecnico($userId, $certificacion, $area_asignada);
                } else if ($rol === 'cliente') {
                    $this->userModel->insertCliente($userId);
                }
                $_SESSION['mensaje'] = 'Usuario creado correctamente';
                $this->redirect('/users');
                return;
            } else {
                $error = 'Error al crear el usuario. Verifique los datos e intente nuevamente.';
            }
        }
        $data = [
            'title' => 'Crear Usuario - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'error' => $error
        ];
        $this->view('users/create', $data);
    }
    
    /**
     * Editar usuario existente
     */
    public function edit($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        $user = $this->userModel->getById($id);
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        // Obtener el rol actual y los datos de rol
        $rolActual = $this->userModel->getUserRoleType($id);
        $rolData = $this->userModel->getRoleAttributes($id, $rolActual);
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'nombre_completo' => $_POST['nombre_completo'] ?? '',
                'telefono' => $_POST['telefono'] ?? '',
                'direccion' => $_POST['direccion'] ?? ''
            ];
            if (!empty($_POST['contrasena'])) {
                $userData['contrasena'] = $_POST['contrasena'];
            }
            // Validar edad mínima si se envía fecha_nacimiento
            if (isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento'])) {
                $fecha = new DateTime($_POST['fecha_nacimiento']);
                $hoy = new DateTime();
                $edad = $hoy->diff($fecha)->y;
                if ($edad < 18) {
                    $error = 'El usuario debe ser mayor o igual a 18 años.';
                } else {
                    $userData['fecha_nacimiento'] = $_POST['fecha_nacimiento'];
                }
            }
            // Procesar fotografía si se sube una nueva
            if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../../public/uploads/fotos/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '_' . basename($_FILES['fotografia']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $uploadFile)) {
                    $userData['fotografia'] = '/uploads/fotos/' . $fileName;
                }
            }
            $rolNuevo = $_POST['rol_usuario'] ?? $rolActual;
            // Actualizar usuario
            $this->userModel->update($id, $userData);
            // Si el rol cambió, eliminar de las otras tablas y agregar a la nueva
            if ($rolNuevo !== $rolActual) {
                $this->userModel->removeFromAllRoles($id);
                if ($rolNuevo === 'admin') {
                    $nivel_acceso = $_POST['nivel_acceso'] ?? 'total';
                    $this->userModel->insertAdmin($id, $nivel_acceso);
                } else if ($rolNuevo === 'tecnico') {
                    $certificacion = $_POST['certificacion'] ?? '';
                    $area_asignada = $_POST['area_asignada'] ?? '';
                    $this->userModel->insertTecnico($id, $certificacion, $area_asignada);
                } else if ($rolNuevo === 'cliente') {
                    $this->userModel->insertCliente($id);
                }
            } else {
                // Si el rol no cambió, actualizar los atributos si corresponde
                if ($rolNuevo === 'admin') {
                    $nivel_acceso = $_POST['nivel_acceso'] ?? 'total';
                    $this->userModel->updateAdminAttributes($id, $nivel_acceso);
                } else if ($rolNuevo === 'tecnico') {
                    $certificacion = $_POST['certificacion'] ?? '';
                    $area_asignada = $_POST['area_asignada'] ?? '';
                    $this->userModel->updateTecnicoAttributes($id, $certificacion, $area_asignada);
                }
            }
            $_SESSION['mensaje'] = 'Usuario actualizado correctamente';
            $this->redirect('/users');
            return;
        }
        $data = [
            'title' => 'Editar Usuario - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'user' => $user,
            'error' => $error,
            'rolActual' => $rolActual,
            'rolData' => $rolData
        ];
        $this->view('users/edit', $data);
    }
    
    /**
     * Eliminar usuario (desactivar)
     */
    public function delete($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        
        // Verificar que no se esté intentando eliminar al administrador
        if ($this->userModel->isAdmin($user['correo'])) {
            $_SESSION['error'] = 'No se puede eliminar al administrador principal';
            $this->redirect('/users');
            return;
        }
        
        // Desactivar en lugar de eliminar
        $result = $this->userModel->deactivate($id);
        
        if ($result) {
            $_SESSION['mensaje'] = 'Usuario desactivado correctamente';
        } else {
            $_SESSION['error'] = 'Error al desactivar el usuario';
        }
        
        $this->redirect('/users');
    }
    
    /**
     * Activar un usuario previamente desactivado
     */
    public function activate($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        
        $result = $this->userModel->activate($id);
        
        if ($result) {
            $_SESSION['mensaje'] = 'Usuario activado correctamente';
        } else {
            $_SESSION['error'] = 'Error al activar el usuario';
        }
        
        $this->redirect('/users');
    }
    
    /**
     * Listar usuarios por rol
     */
    public function byRole($role = null) {
        if (!isset($role)) {
            $role = isset($_GET['role']) ? $_GET['role'] : 'client';
        }
        
        if (!in_array($role, ['admin', 'operator', 'technician', 'client'])) {
            $role = 'client';
        }
        
        $users = $this->userModel->getByRole($role);
        
        $data = [
            'title' => 'Usuarios por Rol - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'users' => $users,
            'currentRole' => $role,
            'showInactive' => false
        ];
        
        $this->view('users/index', $data);
    }
    
    /**
     * Gestionar roles de un usuario
     */
    public function manageRoles($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        
        // Verificar que el usuario actual es administrador
        if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@solufiber-srl.com') {
            $_SESSION['error'] = 'No tiene permisos para gestionar roles';
            $this->redirect('/users');
            return;
        }
        
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        
        $error = null;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener el rol seleccionado
            $selectedRole = isset($_POST['selected_role']) ? $_POST['selected_role'] : '';
            
            if (empty($selectedRole)) {
                $error = 'Debe seleccionar un rol';
            } else {
                // Iniciar transacción
                $this->db->beginTransaction();
                
                try {
                    // Obtener los datos actuales del usuario
                    $userData = [
                        'nombre_completo' => $user['nombre_completo'],
                        'correo' => $user['correo']
                    ];
                    
                    // Determinar nuevo correo electrónico basado en el rol seleccionado
                    $domain = 'solufiber-srl.com';
                    $nombreNormalizado = $this->normalizarNombre($userData['nombre_completo']);
                    
                    switch ($selectedRole) {
                        case 'administrador':
                            $newEmail = "admin@$domain";
                            break;
                        case 'operador':
                            $newEmail = "operador.$nombreNormalizado@$domain";
                            break;
                        case 'tecnico':
                            $newEmail = "$nombreNormalizado@$domain";
                            break;
                        case 'cliente':
                            // Para clientes, mantener correo original si no es del dominio solufiber
                            if (strpos($userData['correo'], "@$domain") !== false) {
                                // Si el correo actual es del dominio solufiber, cambiarlo a uno genérico
                                $newEmail = "$nombreNormalizado@gmail.com";
                            } else {
                                $newEmail = $userData['correo'];
                            }
                            break;
                        default:
                            throw new Exception('Rol no válido');
                    }
                    
                    // Verificar si el correo ha cambiado
                    if ($newEmail !== $userData['correo']) {
                        // Verificar si el nuevo correo ya existe
                        if ($this->userModel->emailExists($newEmail) && $newEmail != 'admin@solufiber-srl.com') {
                            throw new Exception('El correo generado ya está en uso por otro usuario.');
                        }
                        
                        // Actualizar el correo electrónico
                        $updateResult = $this->userModel->updateEmail($id, $newEmail);
                        
                        if (!$updateResult) {
                            throw new Exception('Error al actualizar el correo electrónico del usuario');
                        }
                    }
                    
                    // Buscar el ID del rol correspondiente
                    $roleName = '';
                    switch ($selectedRole) {
                        case 'administrador':
                            $roleName = 'admin';
                            break;
                        case 'operador':
                            $roleName = 'operador';
                            break;
                        case 'tecnico':
                            $roleName = 'tecnico';
                            break;
                        case 'cliente':
                            $roleName = 'cliente';
                            break;
                    }
                    
                    // Intentar primero con el nombre del rol exacto
                    $roleId = $this->userModel->getRoleIdByName($roleName);
                    
                    // Si no se encuentra, intentar con variantes comunes
                    if (!$roleId) {
                        // Intentar con variantes (singular/plural, mayúsculas/minúsculas)
                        $alternativeNames = [
                            'admin' => ['administrador', 'Admin', 'Administrador', 'ADMIN'],
                            'operador' => ['Operador', 'operarios', 'Operarios'],
                            'tecnico' => ['Tecnico', 'técnico', 'Técnico', 'técnicos', 'Técnicos'],
                            'cliente' => ['Cliente', 'clientes', 'Clientes']
                        ];
                        
                        if (isset($alternativeNames[$roleName])) {
                            foreach ($alternativeNames[$roleName] as $altName) {
                                $roleId = $this->userModel->getRoleIdByName($altName);
                                if ($roleId) break;
                            }
                        }
                    }
                    
                    if (!$roleId) {
                        throw new Exception('Rol no encontrado en la base de datos. Verifique que los roles están configurados correctamente.');
                    }
                    
                    // Eliminar roles anteriores
                    $this->userModel->removeRole($id);
                    
                    // Asignar el nuevo rol
                    $assignResult = $this->userModel->assignRole($id, $roleId);
                    
                    if (!$assignResult) {
                        throw new Exception('Error al asignar el nuevo rol');
                    }
                    
                    $this->db->commit();
                    $_SESSION['mensaje'] = 'Rol actualizado correctamente';
                    $this->redirect('/users');
                    return;
                    
                } catch (Exception $e) {
                    $this->db->rollBack();
                    $error = 'Error al actualizar el rol: ' . $e->getMessage();
                }
            }
        }
        
        $data = [
            'title' => 'Gestionar Rol - SOLUFIBER S.R.L.',
            'currentSection' => 'usuarios',
            'user' => $user,
            'error' => $error
        ];
        
        $this->view('users/manage_roles', $data);
    }
    
    /**
     * Normaliza un nombre para usarlo en correos electrónicos
     * Elimina acentos, espacios y caracteres especiales
     * 
     * @param string $nombre Nombre a normalizar
     * @return string Nombre normalizado
     */
    private function normalizarNombre($nombre) {
        // Convertir a minúsculas
        $nombre = strtolower($nombre);
        
        // Eliminar acentos
        $nombre = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'U', 'N'],
            $nombre
        );
        
        // Eliminar espacios y caracteres especiales
        return preg_replace('/[^a-z0-9]/', '', $nombre);
    }
    
    /**
     * Editar atributos específicos del rol de un usuario
     */
    public function editRoleAttributes($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        $user = $this->userModel->getById($id);
        if (!$user) {
            $_SESSION['error'] = 'Usuario no encontrado';
            $this->redirect('/users');
            return;
        }
        // Determinar el tipo de rol y cargar los datos correspondientes
        $rol = $this->userModel->getUserRoleType($id); // admin, tecnico, cliente
        $rolData = $this->userModel->getRoleAttributes($id, $rol);
        $data = [
            'title' => 'Editar atributos de rol',
            'user' => $user,
            'rol' => $rol,
            'rolData' => $rolData
        ];
        $this->view('users/edit_role_attributes', $data);
    }
    
    /**
     * Actualizar atributos específicos del rol de un usuario
     */
    public function updateRoleAttributes($id = null) {
        if (!isset($id)) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
        }
        if (!isset($id)) {
            $this->redirect('/users');
            return;
        }
        $rol = $this->userModel->getUserRoleType($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            switch ($rol) {
                case 'admin':
                    $nivel_acceso = $_POST['nivel_acceso'] ?? 'total';
                    $this->userModel->updateAdminAttributes($id, $nivel_acceso);
                    break;
                case 'tecnico':
                    $certificacion = $_POST['certificacion'] ?? '';
                    $area_asignada = $_POST['area_asignada'] ?? '';
                    $this->userModel->updateTecnicoAttributes($id, $certificacion, $area_asignada);
                    break;
                case 'cliente':
                    // No hay atributos adicionales
                    break;
            }
            $_SESSION['mensaje'] = 'Atributos de rol actualizados correctamente';
            $this->redirect('/users/edit?id=' . $id);
            return;
        }
        $this->redirect('/users/editRoleAttributes?id=' . $id);
    }
    
    /**
     * Mostrar el perfil del usuario autenticado
     */
    public function perfil() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/auth/login');
            return;
        }
        $user = $this->userModel->getById($_SESSION['user_id']);
        if (!$user) {
            $_SESSION['error'] = 'No se pudo obtener la información del usuario.';
            $this->redirect('/');
            return;
        }
        $data = [
            'title' => 'Mi Perfil',
            'user' => $user
        ];
        $this->view('users/perfil', $data);
    }
}
?> 