<?php
require_once 'config/database.php';

class Usuario {
    private $conn;
    
    // Propiedades de la tabla
    public $id_usuario;
    public $nombre_usuario;
    public $contrasena_hash;
    public $nombre_completo;
    public $telefono;
    public $direccion;
    public $correo;
    public $roles = [];
    
    // Constructor con conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener todos los usuarios
     * @return PDOStatement
     */
    public function obtenerTodos() {
        $query = "SELECT * FROM tbl_usuarios ORDER BY nombre_completo ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener un usuario por ID
     * @param int $id ID del usuario
     * @return bool Éxito de la operación
     */
    public function obtenerPorId($id) {
        $query = "SELECT * FROM tbl_usuarios WHERE id_usuario = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Asignar valores a las propiedades del objeto
            $this->id_usuario = $row['id_usuario'];
            $this->nombre_usuario = $row['nombre_usuario'];
            $this->nombre_completo = $row['nombre_completo'];
            $this->telefono = $row['telefono'];
            $this->direccion = $row['direccion'];
            $this->correo = $row['correo'];
            
            // Obtener roles
            $this->obtenerRoles();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener un usuario por nombre de usuario
     * @param string $nombre_usuario Nombre de usuario
     * @return bool Éxito de la operación
     */
    public function obtenerPorNombreUsuario($nombre_usuario) {
        $query = "SELECT * FROM tbl_usuarios WHERE nombre_usuario = :nombre_usuario";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nombre_usuario', $nombre_usuario);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Asignar valores a las propiedades del objeto
            $this->id_usuario = $row['id_usuario'];
            $this->nombre_usuario = $row['nombre_usuario'];
            $this->contrasena_hash = $row['contrasena_hash'];
            $this->nombre_completo = $row['nombre_completo'];
            $this->telefono = $row['telefono'];
            $this->direccion = $row['direccion'];
            $this->correo = $row['correo'];
            
            // Obtener roles
            $this->obtenerRoles();
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Verificar credenciales de usuario
     * @param string $nombre_usuario Nombre de usuario
     * @param string $password Contraseña
     * @return bool Éxito de la autenticación
     */
    public function login($nombre_usuario, $password) {
        if ($this->obtenerPorNombreUsuario($nombre_usuario)) {
            if (password_verify($password, $this->contrasena_hash)) {
                // Actualizar último acceso
                $query = "UPDATE tbl_usuarios SET ultimo_acceso = NOW() WHERE id_usuario = :id_usuario";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':id_usuario', $this->id_usuario);
                $stmt->execute();
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Crear un nuevo usuario
     * @return bool Éxito de la operación
     */
    public function crear() {
        $query = "INSERT INTO tbl_usuarios
                  (nombre_usuario, contrasena_hash, nombre_completo, telefono, direccion, correo)
                  VALUES
                  (:nombre_usuario, :contrasena_hash, :nombre_completo, :telefono, :direccion, :correo)";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_usuario = htmlspecialchars(strip_tags($this->nombre_usuario));
        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        
        // Hash de la contraseña
        $this->contrasena_hash = password_hash($this->contrasena_hash, PASSWORD_DEFAULT);
        
        // Vincular parámetros
        $stmt->bindParam(':nombre_usuario', $this->nombre_usuario);
        $stmt->bindParam(':contrasena_hash', $this->contrasena_hash);
        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':correo', $this->correo);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_usuario = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Actualizar un usuario
     * @return bool Éxito de la operación
     */
    public function actualizar() {
        $query = "UPDATE tbl_usuarios
                  SET nombre_completo = :nombre_completo,
                      telefono = :telefono,
                      direccion = :direccion,
                      correo = :correo
                  WHERE id_usuario = :id_usuario";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_completo = htmlspecialchars(strip_tags($this->nombre_completo));
        $this->telefono = htmlspecialchars(strip_tags($this->telefono));
        $this->direccion = htmlspecialchars(strip_tags($this->direccion));
        $this->correo = htmlspecialchars(strip_tags($this->correo));
        
        // Vincular parámetros
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':nombre_completo', $this->nombre_completo);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':correo', $this->correo);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Cambiar la contraseña de un usuario
     * @param string $nueva_password Nueva contraseña
     * @return bool Éxito de la operación
     */
    public function cambiarPassword($nueva_password) {
        $query = "UPDATE tbl_usuarios
                  SET contrasena_hash = :contrasena_hash
                  WHERE id_usuario = :id_usuario";
        
        $stmt = $this->conn->prepare($query);
        
        // Hash de la contraseña
        $password_hash = password_hash($nueva_password, PASSWORD_DEFAULT);
        
        // Vincular parámetros
        $stmt->bindParam(':contrasena_hash', $password_hash);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener roles de un usuario
     * @return void
     */
    public function obtenerRoles() {
        $query = "SELECT r.* 
                  FROM tbl_roles r
                  JOIN tbl_roles_usuarios ru ON r.id_rol = ru.id_rol
                  WHERE ru.id_usuario = :id_usuario";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->execute();
        
        $this->roles = [];
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->roles[] = $row;
        }
    }
    
    /**
     * Verificar si un usuario tiene un rol específico
     * @param string $rol_nombre Nombre del rol (tecnico, cliente, administrador)
     * @return bool
     */
    public function tieneRol($rol_nombre) {
        foreach ($this->roles as $rol) {
            if ($rol['nombre_rol'] === $rol_nombre) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Asignar un rol a un usuario
     * @param int $id_rol ID del rol
     * @return bool Éxito de la operación
     */
    public function asignarRol($id_rol) {
        $query = "INSERT INTO tbl_roles_usuarios
                  (id_usuario, id_rol)
                  VALUES
                  (:id_usuario, :id_rol)";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':id_rol', $id_rol);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            // Actualizar roles
            $this->obtenerRoles();
            return true;
        }
        
        return false;
    }
    
    /**
     * Crear cliente asociado a este usuario
     * @return bool Éxito de la operación
     */
    public function crearCliente() {
        // Verificar que el cliente no exista ya
        $query = "SELECT id_cliente FROM tbl_clientes WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true; // El cliente ya existe
        }
        
        // Crear cliente
        $query = "INSERT INTO tbl_clientes
                  (id_usuario)
                  VALUES
                  (:id_usuario)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            // Obtener ID del rol cliente
            $queryRol = "SELECT id_rol FROM tbl_roles WHERE nombre_rol = 'cliente' LIMIT 1";
            $stmtRol = $this->conn->prepare($queryRol);
            $stmtRol->execute();
            $rol = $stmtRol->fetch(PDO::FETCH_ASSOC);
            
            if ($rol) {
                // Asignar rol de cliente
                return $this->asignarRol($rol['id_rol']);
            }
        }
        
        return false;
    }
    
    /**
     * Crear técnico asociado a este usuario
     * @param string $certificacion Certificaciones del técnico
     * @param string $area_asignada Área asignada
     * @return bool Éxito de la operación
     */
    public function crearTecnico($certificacion, $area_asignada) {
        // Verificar que el técnico no exista ya
        $query = "SELECT id_tecnico FROM tbl_tecnicos WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true; // El técnico ya existe
        }
        
        // Crear técnico
        $query = "INSERT INTO tbl_tecnicos
                  (id_usuario, certificacion, area_asignada)
                  VALUES
                  (:id_usuario, :certificacion, :area_asignada)";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $certificacion = htmlspecialchars(strip_tags($certificacion));
        $area_asignada = htmlspecialchars(strip_tags($area_asignada));
        
        // Vincular parámetros
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':certificacion', $certificacion);
        $stmt->bindParam(':area_asignada', $area_asignada);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            // Obtener ID del rol técnico
            $queryRol = "SELECT id_rol FROM tbl_roles WHERE nombre_rol = 'tecnico' LIMIT 1";
            $stmtRol = $this->conn->prepare($queryRol);
            $stmtRol->execute();
            $rol = $stmtRol->fetch(PDO::FETCH_ASSOC);
            
            if ($rol) {
                // Asignar rol de técnico
                return $this->asignarRol($rol['id_rol']);
            }
        }
        
        return false;
    }

    public function obtenerClientes() {
        $query = "SELECT u.* FROM tbl_usuarios u
                  INNER JOIN tbl_clientes c ON u.id_usuario = c.id_usuario
                  ORDER BY u.nombre_completo ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function obtenerPorRol($rol) {
        if ($rol === 'tecnico') {
            $query = "SELECT DISTINCT u.* 
                     FROM tbl_usuarios u
                     INNER JOIN tbl_tecnicos t ON u.id_usuario = t.id_usuario
                     ORDER BY u.nombre_completo";
        } else if ($rol === 'cliente') {
            $query = "SELECT DISTINCT u.* 
                     FROM tbl_usuarios u
                     INNER JOIN tbl_clientes c ON u.id_usuario = c.id_usuario
                     ORDER BY u.nombre_completo";
        } else {
            return [];
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
} 