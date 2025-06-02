<?php
class Producto extends Model {
    protected $table = 'tbl_productos';

    public function obtenerTodos() {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY creado_en DESC';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPorId($id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id_producto = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function crear($data) {
        $sql = 'INSERT INTO ' . $this->table . ' (tipo_producto, marca, nombre, descripcion, precio, imagen) VALUES (:tipo_producto, :marca, :nombre, :descripcion, :precio, :imagen)';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':tipo_producto', $data['tipo_producto']);
        $stmt->bindValue(':marca', $data['marca']);
        $stmt->bindValue(':nombre', $data['nombre']);
        $stmt->bindValue(':descripcion', $data['descripcion']);
        $stmt->bindValue(':precio', $data['precio']);
        $stmt->bindValue(':imagen', $data['imagen']);
        return $stmt->execute();
    }
    public function actualizar($id, $data) {
        $sql = 'UPDATE ' . $this->table . ' SET tipo_producto = :tipo_producto, marca = :marca, nombre = :nombre, descripcion = :descripcion, precio = :precio, imagen = :imagen WHERE id_producto = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':tipo_producto', $data['tipo_producto']);
        $stmt->bindValue(':marca', $data['marca']);
        $stmt->bindValue(':nombre', $data['nombre']);
        $stmt->bindValue(':descripcion', $data['descripcion']);
        $stmt->bindValue(':precio', $data['precio']);
        $stmt->bindValue(':imagen', $data['imagen']);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function eliminar($id) {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id_producto = :id';
        $stmt = $this->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
} 