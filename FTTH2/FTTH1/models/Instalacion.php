<?php
class Instalacion {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function obtenerTodasPorCaja($id_caja) {
        $query = "SELECT i.*, u.nombre_completo as nombre_tecnico FROM tbl_instalaciones i JOIN tbl_tecnicos t ON i.id_tecnico = t.id_tecnico JOIN tbl_usuarios u ON t.id_usuario = u.id_usuario WHERE i.id_caja = :id_caja ORDER BY i.fecha_instalacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id_instalacion) {
        $query = "SELECT i.*, u.nombre_completo as nombre_tecnico FROM tbl_instalaciones i JOIN tbl_tecnicos t ON i.id_tecnico = t.id_tecnico JOIN tbl_usuarios u ON t.id_usuario = u.id_usuario WHERE i.id_instalacion = :id_instalacion LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_instalacion', $id_instalacion, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function crear($data) {
        $query = "INSERT INTO tbl_instalaciones (id_caja, id_tecnico, tipo_instalacion, fecha_instalacion, observaciones) VALUES (:id_caja, :id_tecnico, :tipo_instalacion, :fecha_instalacion, :observaciones)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $data['id_caja'], PDO::PARAM_INT);
        $stmt->bindParam(':id_tecnico', $data['id_tecnico'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_instalacion', $data['tipo_instalacion']);
        $stmt->bindParam(':fecha_instalacion', $data['fecha_instalacion']);
        $stmt->bindParam(':observaciones', $data['observaciones']);
        return $stmt->execute();
    }
    public function actualizar($id_instalacion, $data) {
        $query = "UPDATE tbl_instalaciones SET id_tecnico = :id_tecnico, tipo_instalacion = :tipo_instalacion, fecha_instalacion = :fecha_instalacion, observaciones = :observaciones WHERE id_instalacion = :id_instalacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_instalacion', $id_instalacion, PDO::PARAM_INT);
        $stmt->bindParam(':id_tecnico', $data['id_tecnico'], PDO::PARAM_INT);
        $stmt->bindParam(':tipo_instalacion', $data['tipo_instalacion']);
        $stmt->bindParam(':fecha_instalacion', $data['fecha_instalacion']);
        $stmt->bindParam(':observaciones', $data['observaciones']);
        return $stmt->execute();
    }
    public function eliminar($id_instalacion) {
        $query = "DELETE FROM tbl_instalaciones WHERE id_instalacion = :id_instalacion";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_instalacion', $id_instalacion, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function obtenerTodas() {
        $query = "SELECT * FROM tbl_instalaciones ORDER BY fecha_instalacion DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 