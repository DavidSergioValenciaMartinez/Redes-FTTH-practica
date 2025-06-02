<?php
class Distrito {
    private $conn;
    
    // Propiedades
    public $id_distrito;
    public $id_departamento;
    public $nombre_distrito;
    public $codigo_distrito;
    public $estado;
    
    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener todos los distritos
     * @return PDOStatement
     */
    public function obtenerTodos() {
        $query = "SELECT d.*, dep.nombre_departamento 
                 FROM tbl_distritos d
                 LEFT JOIN tbl_departamentos dep ON d.id_departamento = dep.id_departamento
                 WHERE d.estado = 'activo'
                 ORDER BY dep.nombre_departamento, d.nombre_distrito";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener distritos por departamento
     * @param int $id_departamento ID del departamento
     * @return array
     */
    public function obtenerPorDepartamento($id_departamento) {
        $query = "SELECT * FROM tbl_distritos 
                 WHERE id_departamento = :id_departamento 
                 AND estado = 'activo'
                 ORDER BY nombre_distrito";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $id_departamento);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener distrito por ID
     * @param int $id ID del distrito
     * @return bool
     */
    public function obtenerPorId($id) {
        $query = "SELECT d.*, dep.nombre_departamento 
                 FROM tbl_distritos d
                 LEFT JOIN tbl_departamentos dep ON d.id_departamento = dep.id_departamento
                 WHERE d.id_distrito = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $this->id_distrito = $row['id_distrito'];
            $this->id_departamento = $row['id_departamento'];
            $this->nombre_distrito = $row['nombre_distrito'];
            $this->codigo_distrito = $row['codigo_distrito'];
            $this->estado = $row['estado'];
            return true;
        }
        
        return false;
    }
    
    /**
     * Crear nuevo distrito
     * @return bool
     */
    public function crear() {
        $query = "INSERT INTO tbl_distritos 
                 (id_departamento, nombre_distrito, codigo_distrito, estado)
                 VALUES
                 (:id_departamento, :nombre_distrito, :codigo_distrito, :estado)";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre_distrito = htmlspecialchars(strip_tags($this->nombre_distrito));
        $this->codigo_distrito = htmlspecialchars(strip_tags($this->codigo_distrito));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular valores
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->bindParam(':nombre_distrito', $this->nombre_distrito);
        $stmt->bindParam(':codigo_distrito', $this->codigo_distrito);
        $stmt->bindParam(':estado', $this->estado);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_distrito = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Actualizar distrito
     * @return bool
     */
    public function actualizar() {
        $query = "UPDATE tbl_distritos 
                 SET id_departamento = :id_departamento,
                     nombre_distrito = :nombre_distrito,
                     codigo_distrito = :codigo_distrito,
                     estado = :estado
                 WHERE id_distrito = :id_distrito";
        
        $stmt = $this->conn->prepare($query);
        
        // Sanitizar datos
        $this->nombre_distrito = htmlspecialchars(strip_tags($this->nombre_distrito));
        $this->codigo_distrito = htmlspecialchars(strip_tags($this->codigo_distrito));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        
        // Vincular valores
        $stmt->bindParam(':id_distrito', $this->id_distrito);
        $stmt->bindParam(':id_departamento', $this->id_departamento);
        $stmt->bindParam(':nombre_distrito', $this->nombre_distrito);
        $stmt->bindParam(':codigo_distrito', $this->codigo_distrito);
        $stmt->bindParam(':estado', $this->estado);
        
        // Ejecutar consulta
        return $stmt->execute();
    }
    
    /**
     * Eliminar distrito
     * @return bool
     */
    public function eliminar() {
        $query = "DELETE FROM tbl_distritos WHERE id_distrito = :id_distrito";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_distrito', $this->id_distrito);
        
        return $stmt->execute();
    }
} 