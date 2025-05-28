<?php
class HojaTecnica {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function obtenerPorId($id_hoja_caja) {
        $query = "SELECT h.*, u.nombre_completo as nombre_tecnico, c.nombre_completo as nombre_cliente 
                 FROM tbl_hoja_tecnica_cajas_nap h 
                 LEFT JOIN tbl_usuarios u ON h.id_tecnico = u.id_usuario 
                 LEFT JOIN tbl_usuarios c ON h.cliente_usuario_id = c.id_usuario 
                 WHERE h.id_hoja_caja = :id_hoja_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_hoja_caja', $id_hoja_caja);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorIdCaja($id_caja) {
        $query = "SELECT h.*, u.nombre_completo as nombre_tecnico, c.nombre_completo as nombre_cliente 
                 FROM tbl_hoja_tecnica_cajas_nap h 
                 LEFT JOIN tbl_usuarios u ON h.id_tecnico = u.id_usuario 
                 LEFT JOIN tbl_usuarios c ON h.cliente_usuario_id = c.id_usuario 
                 WHERE h.id_caja = :id_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $id_caja);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function obtenerTodas() {
        $query = "SELECT h.*, u.nombre_completo as nombre_tecnico, c.nombre_completo as nombre_cliente,
                        cn.codigo_caja, cn.ubicacion
                 FROM tbl_hoja_tecnica_cajas_nap h 
                 LEFT JOIN tbl_usuarios u ON h.id_tecnico = u.id_usuario 
                 LEFT JOIN tbl_usuarios c ON h.cliente_usuario_id = c.id_usuario 
                 LEFT JOIN tbl_cajas_nap cn ON h.id_caja = cn.id_caja
                 ORDER BY h.id_hoja_caja DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function crear($data) {
        $query = "INSERT INTO tbl_hoja_tecnica_cajas_nap (
            id_caja, id_tecnico, cliente_usuario_id, tipo_trabajo, fabricante, 
            modelo, numero_serie, codigo_caja, ubicacion, capacidad, 
            total_puertos, puertos_disponibles, puertos_ocupados, potencia_dbm, 
            estado, tipo_caja, tipo_conector, dimensiones, material, 
            grado_proteccion, descripcion_equipo, codigo_qr, observaciones
        ) VALUES (
            :id_caja, :id_tecnico, :cliente_usuario_id, :tipo_trabajo, :fabricante,
            :modelo, :numero_serie, :codigo_caja, :ubicacion, :capacidad,
            :total_puertos, :puertos_disponibles, :puertos_ocupados, :potencia_dbm,
            :estado, :tipo_caja, :tipo_conector, :dimensiones, :material,
            :grado_proteccion, :descripcion_equipo, :codigo_qr, :observaciones
        )";
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        return $stmt->execute();
    }
    
    public function actualizar($id_hoja_caja, $data) {
        $query = "UPDATE tbl_hoja_tecnica_cajas_nap SET 
            id_tecnico = :id_tecnico,
            cliente_usuario_id = :cliente_usuario_id,
            tipo_trabajo = :tipo_trabajo,
            fabricante = :fabricante,
            modelo = :modelo,
            numero_serie = :numero_serie,
            codigo_caja = :codigo_caja,
            ubicacion = :ubicacion,
            capacidad = :capacidad,
            total_puertos = :total_puertos,
            puertos_disponibles = :puertos_disponibles,
            puertos_ocupados = :puertos_ocupados,
            potencia_dbm = :potencia_dbm,
            estado = :estado,
            tipo_caja = :tipo_caja,
            tipo_conector = :tipo_conector,
            dimensiones = :dimensiones,
            material = :material,
            grado_proteccion = :grado_proteccion,
            descripcion_equipo = :descripcion_equipo,
            codigo_qr = :codigo_qr,
            observaciones = :observaciones
            WHERE id_hoja_caja = :id_hoja_caja";
            
        $stmt = $this->conn->prepare($query);
        $data['id_hoja_caja'] = $id_hoja_caja;
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        
        return $stmt->execute();
    }
    
    public function eliminar($id_hoja_caja) {
        $query = "DELETE FROM tbl_hoja_tecnica_cajas_nap WHERE id_hoja_caja = :id_hoja_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_hoja_caja', $id_hoja_caja);
        return $stmt->execute();
    }
} 