<?php
class Medicion {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function obtenerTodas() {
        $sql = "SELECT m.*, p.numero_puerto, c.codigo_caja, u.nombre_completo as nombre_usuario
                FROM tbl_mediciones m
                INNER JOIN tbl_puertos p ON m.id_puerto = p.id_puerto
                INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                INNER JOIN tbl_usuarios u ON m.medido_por = u.id_usuario
                ORDER BY m.medido_en DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
        $sql = "SELECT m.*, p.numero_puerto, c.codigo_caja, u.nombre_completo as nombre_usuario
                FROM tbl_mediciones m
                INNER JOIN tbl_puertos p ON m.id_puerto = p.id_puerto
                INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                INNER JOIN tbl_usuarios u ON m.medido_por = u.id_usuario
                WHERE m.id_medicion = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function crear($data) {
        $sql = "INSERT INTO tbl_mediciones (id_puerto, potencia_dbm, atenuacion_db, medido_por, fuente) VALUES (:id_puerto, :potencia_dbm, :atenuacion_db, :medido_por, :fuente)";
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        return $stmt->execute();
    }
    public function actualizar($id, $data) {
        $sql = "UPDATE tbl_mediciones SET id_puerto = :id_puerto, potencia_dbm = :potencia_dbm, atenuacion_db = :atenuacion_db, medido_por = :medido_por, fuente = :fuente WHERE id_medicion = :id";
        $stmt = $this->conn->prepare($sql);
        $data['id'] = $id;
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        return $stmt->execute();
    }
    public function eliminar($id) {
        $sql = "DELETE FROM tbl_mediciones WHERE id_medicion = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function obtenerPuertos() {
        $sql = "SELECT p.id_puerto, p.numero_puerto, c.codigo_caja FROM tbl_puertos p INNER JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja ORDER BY c.codigo_caja, p.numero_puerto";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 