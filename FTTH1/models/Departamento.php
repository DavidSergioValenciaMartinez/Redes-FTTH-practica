<?php
require_once 'config/database.php';

class Departamento {
    private $conn;
    
    // Propiedades de la tabla
    public $id_departamento;
    public $nombre_departamento;
    public $codigo_departamento;
    public $id_region;
    
    // Constructor con conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener todos los departamentos
     * @return PDOStatement
     */
    public function obtenerTodos() {
        $query = "SELECT * FROM tbl_departamentos ORDER BY nombre_departamento ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    /**
     * Obtener departamentos por región
     * @param int $id_region ID de la región
     * @return PDOStatement
     */
    public function obtenerPorRegion($id_region) {
        $query = "SELECT d.*, r.nombre_region 
                  FROM tbl_departamentos d
                  LEFT JOIN tbl_regiones r ON d.id_region = r.id_region
                  WHERE d.id_region = :id_region
                  ORDER BY d.nombre_departamento ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_region', $id_region);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener un departamento por ID
     * @param int $id ID del departamento
     * @return bool Éxito de la operación
     */
    public function obtenerPorId($id) {
        $query = "SELECT d.*, r.nombre_region 
                  FROM tbl_departamentos d
                  LEFT JOIN tbl_regiones r ON d.id_region = r.id_region
                  WHERE d.id_departamento = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Asignar valores a las propiedades del objeto
            $this->id_departamento = $row['id_departamento'];
            $this->nombre_departamento = $row['nombre_departamento'];
            $this->codigo_departamento = $row['codigo_departamento'];
            $this->id_region = $row['id_region'];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener los distritos de un departamento
     * @return array Distritos
     */
    public function obtenerDistritos() {
        $query = "SELECT * FROM tbl_distritos
                  WHERE id_departamento = :id_departamento
                  ORDER BY nombre_distrito ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear un nuevo departamento
     * @return bool Éxito de la operación
     */
    public function crear() {
        $query = "INSERT INTO tbl_departamentos
                  (nombre_departamento, codigo_departamento, id_region)
                  VALUES
                  (:nombre_departamento, :codigo_departamento, :id_region)";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_departamento = htmlspecialchars(strip_tags($this->nombre_departamento));
        $this->codigo_departamento = htmlspecialchars(strip_tags($this->codigo_departamento));
        
        // Vincular parámetros
        $stmt->bindParam(':nombre_departamento', $this->nombre_departamento);
        $stmt->bindParam(':codigo_departamento', $this->codigo_departamento);
        $stmt->bindParam(':id_region', $this->id_region);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_departamento = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Actualizar un departamento
     * @return bool Éxito de la operación
     */
    public function actualizar() {
        $query = "UPDATE tbl_departamentos
                  SET nombre_departamento = :nombre_departamento,
                      codigo_departamento = :codigo_departamento,
                      id_region = :id_region
                  WHERE id_departamento = :id_departamento";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_departamento = htmlspecialchars(strip_tags($this->nombre_departamento));
        $this->codigo_departamento = htmlspecialchars(strip_tags($this->codigo_departamento));
        
        // Vincular parámetros
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->bindParam(':nombre_departamento', $this->nombre_departamento);
        $stmt->bindParam(':codigo_departamento', $this->codigo_departamento);
        $stmt->bindParam(':id_region', $this->id_region);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener Número total de cajas NAP en este departamento
     * @return int Número de cajas NAP
     */
    public function obtenerTotalCajasNap() {
        $query = "SELECT COUNT(*) as total FROM tbl_cajas_nap
                  WHERE id_departamento = :id_departamento";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    
    /**
     * Obtener estadísticas de clientes por departamento
     * @return array Estadísticas
     */
    public function obtenerEstadisticas() {
        $query = "SELECT 
                    COUNT(DISTINCT c.id_cliente) as total_clientes,
                    SUM(CASE WHEN s.nombre_servicio = 'Internet' THEN 1 ELSE 0 END) as clientes_internet,
                    SUM(CASE WHEN s.nombre_servicio = 'Televisión' THEN 1 ELSE 0 END) as clientes_television
                  FROM tbl_instalaciones i
                  JOIN tbl_clientes c ON i.id_cliente = c.id_cliente
                  JOIN tbl_servicios_contratados sc ON c.id_cliente = sc.id_cliente
                  JOIN tbl_servicios s ON sc.id_servicio = s.id_servicio
                  JOIN tbl_puertos_nap p ON i.id_puerto = p.id_puerto
                  JOIN tbl_cajas_nap n ON p.id_caja = n.id_caja
                  WHERE n.id_departamento = :id_departamento";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear un nuevo departamento (solo nombre y descripción)
     */
    public function crearDepartamento($nombre, $descripcion) {
        $db = new PDO('mysql:host=localhost:3306;dbname=solufiber_ftth;charset=utf8mb4', 'root', '12345678');
        $sql = "INSERT INTO tbl_departamentos (nombre_departamento, descripcion) VALUES (:nombre, :descripcion)";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':descripcion', $descripcion, PDO::PARAM_STR);
        return $stmt->execute();
    }
}

class Distrito {
    private $conn;
    
    // Propiedades de la tabla
    public $id_distrito;
    public $nombre_distrito;
    public $codigo_distrito;
    public $id_departamento;
    
    // Constructor con conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener todos los distritos
     * @return PDOStatement
     */
    public function obtenerTodos() {
        $query = "SELECT di.*, d.nombre_departamento 
                  FROM tbl_distritos di
                  LEFT JOIN tbl_departamentos d ON di.id_departamento = d.id_departamento
                  ORDER BY di.nombre_distrito ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener distritos por departamento
     * @param int $id_departamento ID del departamento
     * @return PDOStatement
     */
    public function obtenerPorDepartamento($id_departamento) {
        $query = "SELECT di.*, d.nombre_departamento 
                  FROM tbl_distritos di
                  LEFT JOIN tbl_departamentos d ON di.id_departamento = d.id_departamento
                  WHERE di.id_departamento = :id_departamento
                  ORDER BY di.nombre_distrito ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $id_departamento);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener un distrito por ID
     * @param int $id ID del distrito
     * @return bool Éxito de la operación
     */
    public function obtenerPorId($id) {
        $query = "SELECT di.*, d.nombre_departamento 
                  FROM tbl_distritos di
                  LEFT JOIN tbl_departamentos d ON di.id_departamento = d.id_departamento
                  WHERE di.id_distrito = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Asignar valores a las propiedades del objeto
            $this->id_distrito = $row['id_distrito'];
            $this->nombre_distrito = $row['nombre_distrito'];
            $this->codigo_distrito = $row['codigo_distrito'];
            $this->id_departamento = $row['id_departamento'];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Crear un nuevo distrito
     * @return bool Éxito de la operación
     */
    public function crear() {
        $query = "INSERT INTO tbl_distritos
                  (nombre_distrito, codigo_distrito, id_departamento)
                  VALUES
                  (:nombre_distrito, :codigo_distrito, :id_departamento)";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_distrito = htmlspecialchars(strip_tags($this->nombre_distrito));
        $this->codigo_distrito = htmlspecialchars(strip_tags($this->codigo_distrito));
        
        // Vincular parámetros
        $stmt->bindParam(':nombre_distrito', $this->nombre_distrito);
        $stmt->bindParam(':codigo_distrito', $this->codigo_distrito);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_distrito = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Actualizar un distrito
     * @return bool Éxito de la operación
     */
    public function actualizar() {
        $query = "UPDATE tbl_distritos
                  SET nombre_distrito = :nombre_distrito,
                      codigo_distrito = :codigo_distrito,
                      id_departamento = :id_departamento
                  WHERE id_distrito = :id_distrito";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->nombre_distrito = htmlspecialchars(strip_tags($this->nombre_distrito));
        $this->codigo_distrito = htmlspecialchars(strip_tags($this->codigo_distrito));
        
        // Vincular parámetros
        $stmt->bindParam(':id_distrito', $this->id_distrito);
        $stmt->bindParam(':nombre_distrito', $this->nombre_distrito);
        $stmt->bindParam(':codigo_distrito', $this->codigo_distrito);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener cajas NAP en este distrito
     * @return array Cajas NAP
     */
    public function obtenerCajasNap() {
        $query = "SELECT n.*, e.nombre_estado
                  FROM tbl_cajas_nap n
                  JOIN tbl_estados e ON n.id_estado = e.id_estado
                  WHERE n.id_distrito = :id_distrito
                  ORDER BY n.codigo_caja ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_distrito', $this->id_distrito);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener estadísticas de puertos en este distrito
     * @return array Estadísticas
     */
    public function obtenerEstadisticasPuertos() {
        $query = "SELECT 
                    COUNT(*) as total_puertos,
                    SUM(CASE WHEN p.id_estado = 1 THEN 1 ELSE 0 END) as puertos_disponibles,
                    SUM(CASE WHEN p.id_estado = 2 THEN 1 ELSE 0 END) as puertos_ocupados,
                    SUM(CASE WHEN p.id_estado = 3 THEN 1 ELSE 0 END) as puertos_reservados,
                    SUM(CASE WHEN p.id_estado = 4 THEN 1 ELSE 0 END) as puertos_defectuosos
                  FROM tbl_puertos_nap p
                  JOIN tbl_cajas_nap n ON p.id_caja = n.id_caja
                  WHERE n.id_distrito = :id_distrito";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_distrito', $this->id_distrito);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 