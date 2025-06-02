<?php
require_once 'config/database.php';

class Puerto extends Model {
    protected $table = 'tbl_puertos';

    public function __construct() {
        parent::__construct();
    }

    public function obtenerTodos() {
        $sql = "SELECT p.*, u.nombre_completo as nombre_cliente, c.codigo_caja 
                FROM tbl_puertos p 
                LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario 
                LEFT JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja 
                ORDER BY p.id_puerto DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = "SELECT p.*, u.nombre_completo as nombre_cliente 
                FROM tbl_puertos p 
                LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario 
                WHERE p.id_puerto = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $query = "INSERT INTO tbl_puertos (id_caja, numero_puerto, estado, cliente_usuario_id, splitter_tipo, splitter_ratio, splitter_atenuacion_db) VALUES (:id_caja, :numero_puerto, :estado, :cliente_usuario_id, :splitter_tipo, :splitter_ratio, :splitter_atenuacion_db)";
        $stmt = $this->prepare($query);
        $stmt->bindParam(':id_caja', $data['id_caja']);
        $stmt->bindParam(':numero_puerto', $data['numero_puerto']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':cliente_usuario_id', $data['cliente_usuario_id']);
        $stmt->bindParam(':splitter_tipo', $data['splitter_tipo']);
        $stmt->bindParam(':splitter_ratio', $data['splitter_ratio']);
        $stmt->bindParam(':splitter_atenuacion_db', $data['splitter_atenuacion_db']);
        return $stmt->execute();
    }

    public function actualizar($id, $data) {
        $query = "UPDATE tbl_puertos SET id_caja = :id_caja, numero_puerto = :numero_puerto, estado = :estado, cliente_usuario_id = :cliente_usuario_id, splitter_tipo = :splitter_tipo, splitter_ratio = :splitter_ratio, splitter_atenuacion_db = :splitter_atenuacion_db WHERE id_puerto = :id_puerto";
        $stmt = $this->prepare($query);
        $stmt->bindParam(':id_puerto', $id);
        $stmt->bindParam(':id_caja', $data['id_caja']);
        $stmt->bindParam(':numero_puerto', $data['numero_puerto']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':cliente_usuario_id', $data['cliente_usuario_id']);
        $stmt->bindParam(':splitter_tipo', $data['splitter_tipo']);
        $stmt->bindParam(':splitter_ratio', $data['splitter_ratio']);
        $stmt->bindParam(':splitter_atenuacion_db', $data['splitter_atenuacion_db']);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $query = "DELETE FROM tbl_puertos WHERE id_puerto = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Obtiene los puertos disponibles para cálculos
     * @return array Array de puertos disponibles
     */
    public function obtenerPuertosDisponibles() {
        // Usar la misma lógica que obtenerTodos pero solo para puertos disponibles
        $sql = "SELECT p.*, u.nombre_completo as nombre_cliente, c.nombre_caja
                FROM tbl_puertos p 
                LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario 
                INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja 
                WHERE p.estado = 'disponible'
                ORDER BY c.nombre_caja, p.numero_puerto";
        
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute()) {
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Para depuración
            error_log("Puertos disponibles encontrados: " . print_r($resultados, true));
            return $resultados;
        }
        
        error_log("Error al ejecutar la consulta de puertos disponibles: " . print_r($stmt->errorInfo(), true));
        return [];
    }

    public function obtenerPuertosParaBalanceado() {
        $sql = "SELECT p.id_puerto, p.numero_puerto, c.codigo_caja, u.nombre_completo as nombre_cliente,
                       p.splitter_tipo, p.splitter_ratio, p.splitter_atenuacion_db
                FROM tbl_puertos p
                INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario
                WHERE p.estado = 'disponible'
                ORDER BY c.codigo_caja, p.numero_puerto";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 