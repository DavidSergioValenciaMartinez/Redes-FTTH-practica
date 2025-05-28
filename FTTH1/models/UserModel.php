<?php
/**
 * Modelo para gestión de usuarios
 */
class UserModel extends Model {
    /**
     * Tabla de la base de datos
     * @var string
     */
    protected $table = 'tbl_usuarios';
    
    /**
     * Constructor
     */
    public function __construct() {
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
    }
    
    /**
     * Autentica a un usuario
     * 
     * @param string $correo Correo del usuario
     * @param string $contrasena Contraseña del usuario
     * @return array|bool Datos del usuario o false si no se encuentra
     */
    public function authenticate($correo, $contrasena) {
        try {
            // Buscar el usuario por correo electrónico
            $sql = "SELECT * FROM {$this->table} WHERE correo = :correo LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
            $stmt->execute();
            
            $user = $stmt->fetch();
            
            if ($user && password_verify($contrasena, $user['contrasena_hash'])) {
                // Determinar si es administrador basado en el correo
                $isAdmin = (strpos($correo, 'admin@solufiber-srl.com') !== false);
                $isStaff = (strpos($correo, '@solufiber-srl.com') !== false);
                
                // Determinar el rol basado en el dominio o prefijo del correo
                $role = 'client'; // Por defecto cliente
                
                if ($isStaff) {
                    $username = explode('@', $correo)[0];
                    if ($isAdmin) {
                        $role = 'admin';
                    } else if (strpos($username, 'operador') !== false) {
                        $role = 'operator';
                    } else {
                        $role = 'technician'; // Por defecto técnico para dominio solufiber
                    }
                }
                
                // Actualizar último acceso
                $this->updateLastLogin($user['id_usuario']);
                
                // Quitar la contraseña antes de devolver el usuario
                unset($user['contrasena_hash']);
                
                // Agregar el rol para uso en la sesión
                $user['role'] = $role;
                
                // Definir el nombre para la sesión
                $user['name'] = $user['nombre_completo'];
                $user['id'] = $user['id_usuario'];
                $user['email'] = $user['correo'];
                
                return $user;
            }
            
            return false;
            
        } catch (PDOException $e) {
            error_log('Error en autenticación: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualiza la fecha del último acceso
     * 
     * @param int $userId ID del usuario
     * @return bool
     */
    private function updateLastLogin($userId) {
        try {
            $sql = "UPDATE {$this->table} SET ultimo_acceso = NOW() WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al actualizar último acceso: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Registra un nuevo usuario
     * 
     * @param array $data Datos del usuario
     * @return bool|int Éxito o fracaso, o ID del usuario creado
     */
    public function register($data) {
        // Validar datos mínimos
        if (empty($data['correo']) || empty($data['contrasena'])) {
            return false;
        }
        
        try {
            // Validar si el email ya existe
            $sql = "SELECT id_usuario FROM {$this->table} WHERE correo = :correo LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':correo', $data['correo'], PDO::PARAM_STR);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return false; // Email ya existe
            }
            
            // Mapear campos del formulario a la tabla de base de datos
            $insertData = [
                'nombre_completo' => $data['nombre_completo'],
                'correo' => $data['correo'],
                'contrasena_hash' => password_hash($data['contrasena'], PASSWORD_DEFAULT),
                'telefono' => $data['telefono'] ?? null,
                'direccion' => $data['direccion'] ?? null,
                'nombre_usuario' => explode('@', $data['correo'])[0] // Usar primera parte del email como nombre de usuario
            ];
            
            // Preparar campos y valores
            $fields = array_keys($insertData);
            $placeholders = array_map(function($field) { return ":$field"; }, $fields);
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") 
                    VALUES (" . implode(', ', $placeholders) . ")";
                    
            $stmt = $this->db->prepare($sql);
            
            // Bindear cada valor
            foreach ($insertData as $key => $value) {
                $type = is_null($value) ? PDO::PARAM_NULL : (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
                $stmt->bindValue(":$key", $value, $type);
            }
            
            $stmt->execute();
            return $this->db->lastInsertId();
            
        } catch (PDOException $e) {
            error_log('Error en registro: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene un usuario por su ID
     * 
     * @param int $id ID del usuario
     * @return array|bool Datos del usuario o false si no se encuentra
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_usuario = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $user = $stmt->fetch();
            
            if ($user) {
                // Quitar la contraseña antes de devolver el usuario
                unset($user['contrasena_hash']);
                return $user;
            }
            
            return false;
        } catch (PDOException $e) {
            error_log('Error al obtener usuario: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene todos los usuarios
     * 
     * @return array Listado de usuarios
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY nombre_completo ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $users = $stmt->fetchAll();
            
            // Quitar contraseñas
            foreach ($users as &$user) {
                unset($user['contrasena_hash']);
            }
            
            return $users;
        } catch (PDOException $e) {
            error_log('Error al obtener usuarios: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Actualiza los datos de un usuario
     * 
     * @param int $id ID del usuario
     * @param array $data Datos a actualizar
     * @return bool Éxito o fracaso
     */
    public function update($id, $data) {
        // Validar datos mínimos
        if (empty($id) || empty($data)) {
            return false;
        }
        
        // Si se incluye contraseña, hashearla
        if (!empty($data['contrasena'])) {
            $data['contrasena_hash'] = password_hash($data['contrasena'], PASSWORD_DEFAULT);
            // Eliminar la contraseña original para no incluirla en la consulta SQL
            unset($data['contrasena']);
        }
        
        // Quitar campos que no van en la actualización
        unset($data['confirmar_contrasena']);
        unset($data['id_usuario']);
        unset($data['role']);
        
        if (empty($data)) {
            return true; // No hay datos para actualizar
        }
        
        // Preparar campos y valores
        $sets = [];
        $values = ['id' => $id];
        
        foreach ($data as $key => $value) {
            $sets[] = "$key = :$key";
            $values[$key] = $value;
        }
        
        $sql = "UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id_usuario = :id";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt && $stmt->execute($values);
        } catch (PDOException $e) {
            error_log('Error al actualizar usuario: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Desactiva un usuario (en lugar de eliminarlo)
     * 
     * @param int $id ID del usuario
     * @return bool Éxito o fracaso
     */
    public function deactivate($id) {
        return $this->update($id, ['active' => 0]);
    }
    
    /**
     * Activa un usuario
     * 
     * @param int $id ID del usuario
     * @return bool Éxito o fracaso
     */
    public function activate($id) {
        return $this->update($id, ['active' => 1]);
    }
    
    /**
     * Verifica si un correo es válido según el rol
     * 
     * @param string $email Correo electrónico
     * @param string $role Rol (admin, operator, technician, client)
     * @return bool Si el correo es válido para el rol
     */
    public function isValidEmailForRole($email, $role) {
        $domain = 'solufiber-srl.com';
        
        // Para roles de staff, el correo debe ser del dominio solufiber-srl.com
        if (in_array($role, ['admin', 'operator', 'technician'])) {
            if (strpos($email, "@$domain") === false) {
                return false;
            }
            
            // Verificar prefijos específicos
            $username = explode('@', $email)[0];
            
            if ($role === 'admin' && $username !== 'admin') {
                return false;
            }
            
            if ($role === 'operator' && strpos($username, 'operador') !== 0) {
                return false;
            }
        } 
        // Para clientes, el correo NO debe ser del dominio solufiber-srl.com
        else if ($role === 'client') {
            if (strpos($email, "@$domain") !== false) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Crea un correo electrónico de staff basado en el nombre y rol
     * 
     * @param string $name Nombre completo
     * @param string $role Rol (admin, operator, technician)
     * @return string Correo formateado
     */
    public function generateStaffEmail($name, $role) {
        $domain = 'solufiber-srl.com';
        $name = strtolower($name);
        
        // Eliminar acentos y caracteres especiales
        $name = preg_replace('([^A-Za-z0-9])', '', $this->removeAccents($name));
        
        if ($role === 'admin') {
            return "admin@$domain";
        } else if ($role === 'operator') {
            return "operador.$name@$domain";
        } else {
            return "$name@$domain";
        }
    }
    
    /**
     * Elimina acentos y caracteres especiales
     * 
     * @param string $string Cadena a procesar
     * @return string Cadena procesada
     */
    private function removeAccents($string) {
        $unwanted_array = [
            'á'=>'a', 'é'=>'e', 'í'=>'i', 'ó'=>'o', 'ú'=>'u',
            'Á'=>'A', 'É'=>'E', 'Í'=>'I', 'Ó'=>'O', 'Ú'=>'U', 
            'ñ'=>'n', 'Ñ'=>'N', 'ü'=>'u', 'Ü'=>'U',
            ' '=>'', ','=>'', '.'=>''
        ];
        return strtr($string, $unwanted_array);
    }
    
    /**
     * Verifica si un usuario es administrador
     * 
     * @param string $email Correo electrónico
     * @return bool Si es administrador
     */
    public function isAdmin($email) {
        return (strpos($email, 'admin@solufiber-srl.com') !== false);
    }
    
    /**
     * Obtiene usuarios por rol basado en patrón de correo
     * 
     * @param string $role Rol (admin, operator, technician, client)
     * @return array Usuarios con ese rol
     */
    public function getByRole($role) {
        $domain = 'solufiber-srl.com';
        $pattern = '';
        
        switch ($role) {
            case 'admin':
                $pattern = "admin@$domain";
                break;
            case 'operator':
                $pattern = "%operador%@$domain";
                break;
            case 'technician':
                $pattern = "%@$domain";
                // Excluir administradores y operadores
                $sql = "SELECT * FROM {$this->table} 
                        WHERE email LIKE :pattern 
                        AND email NOT LIKE 'admin@$domain' 
                        AND email NOT LIKE 'operador%@$domain'
                        AND active = 1
                        ORDER BY name ASC";
                break;
            case 'client':
                $sql = "SELECT * FROM {$this->table} 
                        WHERE email NOT LIKE '%@$domain'
                        AND active = 1
                        ORDER BY name ASC";
                break;
            default:
                return [];
        }
        
        // Si no se definió un SQL específico, usar la consulta estándar
        if (!isset($sql)) {
            $sql = "SELECT * FROM {$this->table} WHERE email LIKE :pattern AND active = 1 ORDER BY name ASC";
        }
        
        $params = [];
        if (isset($pattern)) {
            $params['pattern'] = $pattern;
        }
        
        $stmt = $this->db->prepare($sql);
        
        if ($stmt && $stmt->execute($params)) {
            $users = $stmt->fetchAll();
            
            // Quitar contraseñas
            foreach ($users as &$user) {
                unset($user['contrasena_hash']);
            }
            
            return $users;
        }
        
        return [];
    }
    
    /**
     * Actualiza el perfil del usuario
     * 
     * @param int $userId ID del usuario
     * @param array $data Datos del perfil
     * @return bool
     */
    public function updateProfile($userId, $data) {
        $this->db->query('UPDATE tbl_usuarios SET 
                         nombre_completo = :nombre_completo,
                         correo = :correo,
                         telefono = :telefono,
                         direccion = :direccion
                         WHERE id = :id');
        
        // Vincular valores
        $this->db->bind(':nombre_completo', $data['nombre_completo']);
        $this->db->bind(':correo', $data['correo']);
        $this->db->bind(':telefono', $data['telefono']);
        $this->db->bind(':direccion', $data['direccion']);
        $this->db->bind(':id', $userId);
        
        // Ejecutar
        if ($this->db->execute()) {
            // Registrar la actividad
            $this->logActivity($userId, 'Actualización de perfil');
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Actualiza la contraseña del usuario
     * 
     * @param int $userId ID del usuario
     * @param string $password Nueva contraseña (ya cifrada)
     * @return bool
     */
    public function updatePassword($userId, $password) {
        $this->db->query('UPDATE tbl_usuarios SET password = :password WHERE id = :id');
        
        // Vincular valores
        $this->db->bind(':password', $password);
        $this->db->bind(':id', $userId);
        
        // Ejecutar
        if ($this->db->execute()) {
            // Registrar la actividad
            $this->logActivity($userId, 'Cambio de contraseña');
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Registra una actividad del usuario
     * 
     * @param int $userId ID del usuario
     * @param string $action Acción realizada
     * @return bool
     */
    public function logActivity($userId, $action) {
        $this->db->query('INSERT INTO tbl_actividad_usuarios (usuario_id, accion, fecha_hora)
                         VALUES (:usuario_id, :accion, NOW())');
        
        // Vincular valores
        $this->db->bind(':usuario_id', $userId);
        $this->db->bind(':accion', $action);
        
        // Ejecutar
        return $this->db->execute();
    }
    
    /**
     * Obtiene la última actividad del usuario
     * 
     * @param int $userId ID del usuario
     * @return mixed Último registro de actividad o false
     */
    public function getLastActivity($userId) {
        $this->db->query('SELECT * FROM tbl_actividad_usuarios 
                         WHERE usuario_id = :usuario_id 
                         ORDER BY fecha_hora DESC LIMIT 1');
        
        $this->db->bind(':usuario_id', $userId);
        
        return $this->db->single();
    }
    
    /**
     * Obtiene todas las actividades del usuario
     * 
     * @param int $userId ID del usuario
     * @return array
     */
    public function getUserActivities($userId) {
        $this->db->query('SELECT * FROM tbl_actividad_usuarios 
                         WHERE usuario_id = :usuario_id 
                         ORDER BY fecha_hora DESC LIMIT 50');
        
        $this->db->bind(':usuario_id', $userId);
        
        return $this->db->resultSet();
    }
    
    /**
     * Obtiene todos los roles disponibles en el sistema
     * 
     * @return array Listado de roles
     */
    public function getAllRoles() {
        try {
            $sql = "SELECT * FROM tbl_roles ORDER BY nombre_rol ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener roles: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Asigna un rol a un usuario
     * 
     * @param int $userId ID del usuario
     * @param int $roleId ID del rol
     * @return bool Éxito o fracaso
     */
    public function assignRole($userId, $roleId) {
        try {
            // Verificar si ya existe una asignación
            $checkSql = "SELECT id_rol_usuario FROM tbl_roles_usuarios 
                        WHERE id_usuario = :userId AND id_rol = :roleId LIMIT 1";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $checkStmt->bindValue(':roleId', $roleId, PDO::PARAM_INT);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                return true; // Ya existe esta asignación
            }
            
            $sql = "INSERT INTO tbl_roles_usuarios (id_usuario, id_rol) 
                    VALUES (:userId, :roleId)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':roleId', $roleId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al asignar rol: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Elimina un rol de un usuario
     * 
     * @param int $userId ID del usuario
     * @param int $roleId ID del rol (opcional, si no se proporciona elimina todos los roles)
     * @return bool Éxito o fracaso
     */
    public function removeRole($userId, $roleId = null) {
        try {
            if ($roleId === null) {
                // Eliminar todos los roles del usuario
                $sql = "DELETE FROM tbl_roles_usuarios WHERE id_usuario = :userId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            } else {
                // Eliminar un rol específico
                $sql = "DELETE FROM tbl_roles_usuarios 
                        WHERE id_usuario = :userId AND id_rol = :roleId";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindValue(':roleId', $roleId, PDO::PARAM_INT);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al eliminar rol: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene los roles asignados a un usuario
     * 
     * @param int $userId ID del usuario
     * @return array Roles asignados
     */
    public function getUserRoles($userId) {
        try {
            $sql = "SELECT r.* FROM tbl_roles r
                    JOIN tbl_roles_usuarios ru ON r.id_rol = ru.id_rol
                    WHERE ru.id_usuario = :userId
                    ORDER BY r.nombre_rol ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log('Error al obtener roles de usuario: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Registra un nuevo usuario con roles
     * 
     * @param array $data Datos del usuario
     * @param array $roles IDs de roles a asignar
     * @return bool|int Éxito o fracaso, o ID del usuario creado
     */
    public function registerWithRoles($data, $roles = []) {
        // Iniciar transacción
        $this->db->beginTransaction();
        
        try {
            // Registrar usuario primero
            $userId = $this->register($data);
            
            if (!$userId) {
                $this->db->rollBack();
                return false;
            }
            
            // Asignar roles
            if (!empty($roles)) {
                foreach ($roles as $roleId) {
                    $this->assignRole($userId, $roleId);
                }
            }
            
            $this->db->commit();
            return $userId;
            
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error en registro con roles: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Verifica si un correo electrónico ya existe en la base de datos
     * 
     * @param string $email Correo electrónico a verificar
     * @return bool Verdadero si el correo ya existe
     */
    public function emailExists($email) {
        try {
            $sql = "SELECT id_usuario FROM {$this->table} WHERE correo = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log('Error al verificar email: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Actualiza el correo electrónico de un usuario
     * 
     * @param int $userId ID del usuario
     * @param string $newEmail Nuevo correo electrónico
     * @return bool Éxito o fracaso
     */
    public function updateEmail($userId, $newEmail) {
        try {
            $sql = "UPDATE {$this->table} SET correo = :email WHERE id_usuario = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':email', $newEmail, PDO::PARAM_STR);
            $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log('Error al actualizar email: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene el ID de un rol por su nombre
     * 
     * @param string $roleName Nombre del rol
     * @return int|bool ID del rol o falso si no se encuentra
     */
    public function getRoleIdByName($roleName) {
        try {
            $sql = "SELECT id_rol FROM tbl_roles WHERE nombre_rol = :nombre LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':nombre', $roleName, PDO::PARAM_STR);
            $stmt->execute();
            
            $result = $stmt->fetch();
            
            if ($result) {
                return $result['id_rol'];
            }
            
            return false;
        } catch (PDOException $e) {
            error_log('Error al obtener ID de rol: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Obtiene el tipo de rol del usuario (admin, tecnico, cliente)
     */
    public function getUserRoleType($id_usuario) {
        // Verificar si es administrador
        $sql = "SELECT * FROM tbl_administradores WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()) return 'admin';
        // Verificar si es técnico
        $sql = "SELECT * FROM tbl_tecnicos WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()) return 'tecnico';
        // Verificar si es cliente
        $sql = "SELECT * FROM tbl_clientes WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetch()) return 'cliente';
        return null;
    }
    
    /**
     * Obtiene los atributos específicos del rol del usuario
     */
    public function getRoleAttributes($id_usuario, $rol) {
        switch ($rol) {
            case 'admin':
                $sql = "SELECT * FROM tbl_administradores WHERE id_usuario = :id";
                break;
            case 'tecnico':
                $sql = "SELECT * FROM tbl_tecnicos WHERE id_usuario = :id";
                break;
            case 'cliente':
                $sql = "SELECT * FROM tbl_clientes WHERE id_usuario = :id";
                break;
            default:
                return null;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    /**
     * Actualiza el nivel de acceso de un administrador
     */
    public function updateAdminAttributes($id_usuario, $nivel_acceso) {
        $sql = "UPDATE tbl_administradores SET nivel_acceso = :nivel WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nivel', $nivel_acceso, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    /**
     * Actualiza la certificación y área asignada de un técnico
     */
    public function updateTecnicoAttributes($id_usuario, $certificacion, $area_asignada) {
        $sql = "UPDATE tbl_tecnicos SET certificacion = :cert, area_asignada = :area WHERE id_usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cert', $certificacion, PDO::PARAM_STR);
        $stmt->bindValue(':area', $area_asignada, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    /**
     * Inserta un usuario como administrador
     */
    public function insertAdmin($id_usuario, $nivel_acceso) {
        $sql = "INSERT INTO tbl_administradores (id_usuario, nivel_acceso) VALUES (:id, :nivel)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':nivel', $nivel_acceso, PDO::PARAM_STR);
        return $stmt->execute();
    }
    /**
     * Inserta un usuario como técnico
     */
    public function insertTecnico($id_usuario, $certificacion, $area_asignada) {
        $sql = "INSERT INTO tbl_tecnicos (id_usuario, certificacion, area_asignada) VALUES (:id, :cert, :area)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->bindValue(':cert', $certificacion, PDO::PARAM_STR);
        $stmt->bindValue(':area', $area_asignada, PDO::PARAM_STR);
        return $stmt->execute();
    }
    /**
     * Inserta un usuario como cliente
     */
    public function insertCliente($id_usuario) {
        $sql = "INSERT INTO tbl_clientes (id_usuario) VALUES (:id)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id_usuario, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
    /**
     * Elimina al usuario de todas las tablas de roles (admin, tecnico, cliente)
     */
    public function removeFromAllRoles($id_usuario) {
        $this->db->prepare('DELETE FROM tbl_administradores WHERE id_usuario = :id')->execute([':id' => $id_usuario]);
        $this->db->prepare('DELETE FROM tbl_tecnicos WHERE id_usuario = :id')->execute([':id' => $id_usuario]);
        $this->db->prepare('DELETE FROM tbl_clientes WHERE id_usuario = :id')->execute([':id' => $id_usuario]);
    }
    
    /**
     * Obtiene un usuario por su correo electrónico
     */
    public function getByEmail($correo) {
        $sql = "SELECT * FROM {$this->table} WHERE correo = :correo LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':correo', $correo, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch();
        if ($user) {
            unset($user['contrasena_hash']);
            return $user;
        }
        return false;
    }
    
    /**
     * Obtiene un usuario por su número de teléfono
     * @param string $telefono
     * @return array|bool
     */
    public function getByPhone($telefono) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE telefono = :telefono LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':telefono', $telefono, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                unset($user['contrasena_hash']);
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log('Error al buscar usuario por teléfono: ' . $e->getMessage());
            return false;
        }
    }
}
?> 