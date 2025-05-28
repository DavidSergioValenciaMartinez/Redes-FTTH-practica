<?php
class Cliente extends Model {
    protected $table = 'tbl_clientes';

    public function obtenerTodos() {
        $sql = 'SELECT id_cliente FROM ' . $this->table . ' ORDER BY id_cliente ASC';
        $stmt = $this->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Puedes agregar otros métodos CRUD si son necesarios más adelante
} 