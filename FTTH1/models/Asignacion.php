<?php
class Asignacion extends Model {
    protected $table = 'tbl_clientes_productos_servicios';

    public function obtenerTodas() {
        $sql = 'SELECT a.*, c.nombre FROM ' . $this->table . ' a INNER JOIN tbl_clientes c ON a.id_cliente = c.id_cliente ORDER BY a.fecha_asignacion DESC';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($id) {
        $sql = 'SELECT a.*, c.nombre FROM ' . $this->table . ' a INNER JOIN tbl_clientes c ON a.id_cliente = c.id_cliente WHERE a.id_asignacion = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($data) {
        $sql = 'INSERT INTO ' . $this->table . ' (id_cliente, fecha_asignacion, estado) VALUES (:id_cliente, :fecha_asignacion, :estado)';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_cliente', $data['id_cliente']);
        $stmt->bindValue(':fecha_asignacion', $data['fecha_asignacion']);
        $stmt->bindValue(':estado', $data['estado']);
        return $stmt->execute();
    }

    public function actualizar($id, $data) {
        $sql = 'UPDATE ' . $this->table . ' SET id_cliente = :id_cliente, fecha_asignacion = :fecha_asignacion, estado = :estado WHERE id_asignacion = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id_cliente', $data['id_cliente']);
        $stmt->bindValue(':fecha_asignacion', $data['fecha_asignacion']);
        $stmt->bindValue(':estado', $data['estado']);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id_asignacion = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 