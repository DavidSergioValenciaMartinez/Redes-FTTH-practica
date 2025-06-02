<?php
require_once 'config/database.php';

class CajaNap {
    private $conn;
    
    // Propiedades de la tabla
    public $id_caja;
    public $id_departamento;
    public $codigo_caja;
    public $ubicacion;
    public $total_puertos;
    public $puertos_disponibles;
    public $puertos_ocupados;
    public $potencia_dbm;
    public $estado;
    public $fabricante;
    public $modelo;
    public $capacidad;
    public $fecha_instalacion;
    public $id_tecnico_responsable;
    public $observaciones;
    // Propiedades adicionales usadas en joins y controladores
    public $creado_en;
    public $nombre_departamento;
    public $coordenadas;
    public $id_estado;
    public $id_distrito;
    public $id_tipo_caja;
    
    // Constructor con conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener todas las cajas NAP
     * @return array
     */
    public function obtenerTodas() {
        $query = "SELECT c.*, 
                        d.nombre_departamento
                 FROM tbl_cajas_nap c 
                 LEFT JOIN tbl_departamentos d ON c.id_departamento = d.id_departamento 
                 ORDER BY c.codigo_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener cajas NAP por departamento
     * @param int $id_departamento ID del departamento
     * @return PDOStatement
     */
    public function obtenerPorDepartamento($id_departamento) {
        $query = "SELECT c.*, 
                  e.nombre_estado, 
                  d.nombre_distrito, 
                  dep.nombre_departamento,
                  t.nombre_tipo_caja
                  FROM tbl_cajas_nap c
                  LEFT JOIN tbl_estados e ON c.id_estado = e.id_estado
                  LEFT JOIN tbl_distritos d ON c.id_distrito = d.id_distrito
                  LEFT JOIN tbl_departamentos dep ON c.id_departamento = dep.id_departamento
                  LEFT JOIN tbl_tipos_caja t ON c.id_tipo_caja = t.id_tipo_caja
                  WHERE c.id_departamento = :id_departamento
                  ORDER BY c.codigo_caja ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_departamento', $id_departamento);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener cajas NAP por distrito
     * @param int $id_distrito ID del distrito
     * @return PDOStatement
     */
    public function obtenerPorDistrito($id_distrito) {
        $query = "SELECT c.*, 
                  e.nombre_estado, 
                  d.nombre_distrito, 
                  dep.nombre_departamento,
                  t.nombre_tipo_caja
                  FROM tbl_cajas_nap c
                  LEFT JOIN tbl_estados e ON c.id_estado = e.id_estado
                  LEFT JOIN tbl_distritos d ON c.id_distrito = d.id_distrito
                  LEFT JOIN tbl_departamentos dep ON c.id_departamento = dep.id_departamento
                  LEFT JOIN tbl_tipos_caja t ON c.id_tipo_caja = t.id_tipo_caja
                  WHERE c.id_distrito = :id_distrito
                  ORDER BY c.codigo_caja ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_distrito', $id_distrito);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener cajas NAP por estado
     * @param int $id_estado ID del estado
     * @return PDOStatement
     */
    public function obtenerPorEstado($id_estado) {
        $query = "SELECT c.*, 
                  e.nombre_estado, 
                  d.nombre_distrito, 
                  dep.nombre_departamento,
                  t.nombre_tipo_caja
                  FROM tbl_cajas_nap c
                  LEFT JOIN tbl_estados e ON c.id_estado = e.id_estado
                  LEFT JOIN tbl_distritos d ON c.id_distrito = d.id_distrito
                  LEFT JOIN tbl_departamentos dep ON c.id_departamento = dep.id_departamento
                  LEFT JOIN tbl_tipos_caja t ON c.id_tipo_caja = t.id_tipo_caja
                  WHERE c.id_estado = :id_estado
                  ORDER BY c.codigo_caja ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_estado', $id_estado);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener caja NAP por ID
     * @param int $id ID de la caja NAP
     * @return bool
     */
    public function obtenerPorId($id) {
        $query = "SELECT c.*, 
                        d.nombre_departamento
                 FROM tbl_cajas_nap c 
                 LEFT JOIN tbl_departamentos d ON c.id_departamento = d.id_departamento 
                 WHERE c.id_caja = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Crear una nueva caja NAP
     * @return bool Éxito de la operación
     */
    public function crear($data) {
        $query = "INSERT INTO tbl_cajas_nap (
                    id_departamento, codigo_caja, ubicacion, total_puertos,
                    puertos_disponibles, puertos_ocupados, potencia_dbm,
                    estado, fabricante, modelo, capacidad
                ) VALUES (
                    :id_departamento, :codigo_caja, :ubicacion, :total_puertos,
                    :puertos_disponibles, :puertos_ocupados, :potencia_dbm,
                    :estado, :fabricante, :modelo, :capacidad
                )";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_departamento', $data['id_departamento']);
        $stmt->bindParam(':codigo_caja', $data['codigo_caja']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':total_puertos', $data['total_puertos']);
        $stmt->bindParam(':puertos_disponibles', $data['puertos_disponibles']);
        $stmt->bindParam(':puertos_ocupados', $data['puertos_ocupados']);
        $stmt->bindParam(':potencia_dbm', $data['potencia_dbm']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':fabricante', $data['fabricante']);
        $stmt->bindParam(':modelo', $data['modelo']);
        $stmt->bindParam(':capacidad', $data['capacidad']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }
    
    /**
     * Actualizar caja NAP
     * @return bool Éxito de la operación
     */
    public function actualizar($id, $data) {
        $query = "UPDATE tbl_cajas_nap SET 
                    id_departamento = :id_departamento,
                    codigo_caja = :codigo_caja,
                    ubicacion = :ubicacion,
                    total_puertos = :total_puertos,
                    puertos_disponibles = :puertos_disponibles,
                    puertos_ocupados = :puertos_ocupados,
                    potencia_dbm = :potencia_dbm,
                    estado = :estado,
                    fabricante = :fabricante,
                    modelo = :modelo,
                    capacidad = :capacidad
                WHERE id_caja = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_departamento', $data['id_departamento']);
        $stmt->bindParam(':codigo_caja', $data['codigo_caja']);
        $stmt->bindParam(':ubicacion', $data['ubicacion']);
        $stmt->bindParam(':total_puertos', $data['total_puertos']);
        $stmt->bindParam(':puertos_disponibles', $data['puertos_disponibles']);
        $stmt->bindParam(':puertos_ocupados', $data['puertos_ocupados']);
        $stmt->bindParam(':potencia_dbm', $data['potencia_dbm']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':fabricante', $data['fabricante']);
        $stmt->bindParam(':modelo', $data['modelo']);
        $stmt->bindParam(':capacidad', $data['capacidad']);
        
        return $stmt->execute();
    }
    
    /**
     * Cambiar estado de caja NAP
     * @param int $id_estado Nuevo estado
     * @return bool Éxito de la operación
     */
    public function cambiarEstado($id_estado) {
        $query = "UPDATE tbl_cajas_nap
                  SET id_estado = :id_estado
                  WHERE id_caja = :id_caja";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros
        $stmt->bindParam(':id_caja', $this->id_caja);
        $stmt->bindParam(':id_estado', $id_estado);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_estado = $id_estado;
            return true;
        }
        
        return false;
    }
    
    /**
     * Crear puertos automáticamente
     * @return bool Éxito de la operación
     */
    private function crearPuertos() {
        $puerto = new PuertoNap($this->conn);
        $puerto->id_caja = $this->id_caja;
        $puerto->id_estado = 1; // Disponible por defecto
        
        $success = true;
        
        for ($i = 1; $i <= $this->capacidad; $i++) {
            $puerto->numero_puerto = $i;
            if (!$puerto->crear()) {
                $success = false;
            }
        }
        
        return $success;
    }
    
    /**
     * Obtener puertos de la caja NAP
     * @return array Puertos
     */
    public function obtenerPuertos() {
        $query = "SELECT * FROM tbl_puertos
                  WHERE id_caja = :id_caja
                  ORDER BY numero_puerto ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $this->id_caja);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Obtener estadísticas de los puertos de la caja NAP
     * @return array Estadísticas
     */
    public function obtenerEstadisticasPuertos() {
        $query = "SELECT 
                  COUNT(*) as total_puertos,
                  SUM(CASE WHEN p.estado = 'disponible' THEN 1 ELSE 0 END) as puertos_disponibles,
                  SUM(CASE WHEN p.estado = 'ocupado' THEN 1 ELSE 0 END) as puertos_ocupados,
                  SUM(CASE WHEN p.estado = 'defectuoso' THEN 1 ELSE 0 END) as puertos_defectuosos
                  FROM tbl_puertos p
                  WHERE p.id_caja = :id_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $this->id_caja);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function eliminar($id) {
        $query = "DELETE FROM tbl_cajas_nap WHERE id_caja = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Obtener los puertos de una caja NAP específica
     */
    public function obtenerPuertosPorCaja($id_caja) {
        $query = "SELECT p.*, u.nombre_completo as nombre_cliente
                  FROM tbl_puertos p
                  LEFT JOIN tbl_usuarios u ON p.cliente_usuario_id = u.id_usuario
                  WHERE p.id_caja = :id_caja
                  ORDER BY p.numero_puerto ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_caja', $id_caja, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function existeCodigoCaja($codigo) {
        $query = "SELECT COUNT(*) FROM tbl_cajas_nap WHERE codigo_caja = :codigo_caja";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo_caja', $codigo);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}

class PuertoNap {
    private $conn;
    
    // Propiedades de la tabla
    public $id_puerto;
    public $id_caja;
    public $numero_puerto;
    public $id_estado;
    public $observaciones;
    
    // Constructor con conexión a la base de datos
    public function __construct($db) {
        $this->conn = $db;
    }
    
    /**
     * Obtener puerto por ID
     * @param int $id ID del puerto
     * @return bool Éxito de la operación
     */
    public function obtenerPorId($id) {
        $query = "SELECT p.*, e.nombre_estado, c.codigo_caja
                  FROM tbl_puertos p
                  LEFT JOIN tbl_estados e ON p.id_estado = e.id_estado
                  LEFT JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                  WHERE p.id_puerto = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            // Asignar valores a las propiedades del objeto
            $this->id_puerto = $row['id_puerto'];
            $this->id_caja = $row['id_caja'];
            $this->numero_puerto = $row['numero_puerto'];
            $this->id_estado = $row['id_estado'];
            $this->observaciones = $row['observaciones'];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener puertos disponibles
     * @return PDOStatement
     */
    public function obtenerDisponibles() {
        $query = "SELECT p.*, c.codigo_caja, d.nombre_distrito, dep.nombre_departamento
                  FROM tbl_puertos p
                  JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                  JOIN tbl_distritos d ON c.id_distrito = d.id_distrito
                  JOIN tbl_departamentos dep ON c.id_departamento = dep.id_departamento
                  WHERE p.id_estado = 1
                  ORDER BY dep.nombre_departamento, d.nombre_distrito, c.codigo_caja, p.numero_puerto ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Obtener puertos por estado
     * @param int $id_estado ID del estado
     * @return PDOStatement
     */
    public function obtenerPorEstado($id_estado) {
        $query = "SELECT p.*, c.codigo_caja, d.nombre_distrito, dep.nombre_departamento
                  FROM tbl_puertos p
                  JOIN tbl_cajas_nap c ON p.id_caja = c.id_caja
                  JOIN tbl_distritos d ON c.id_distrito = d.id_distrito
                  JOIN tbl_departamentos dep ON c.id_departamento = dep.id_departamento
                  WHERE p.id_estado = :id_estado
                  ORDER BY dep.nombre_departamento, d.nombre_distrito, c.codigo_caja, p.numero_puerto ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_estado', $id_estado);
        $stmt->execute();
        
        return $stmt;
    }
    
    /**
     * Crear un nuevo puerto
     * @return bool Éxito de la operación
     */
    public function crear() {
        $query = "INSERT INTO tbl_puertos
                  (id_caja, numero_puerto, id_estado, observaciones)
                  VALUES
                  (:id_caja, :numero_puerto, :id_estado, :observaciones)";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->observaciones = htmlspecialchars(strip_tags($this->observaciones ?? ''));
        
        // Vincular parámetros
        $stmt->bindParam(':id_caja', $this->id_caja);
        $stmt->bindParam(':numero_puerto', $this->numero_puerto);
        $stmt->bindParam(':id_estado', $this->id_estado);
        $stmt->bindParam(':observaciones', $this->observaciones);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_puerto = $this->conn->lastInsertId();
            return true;
        }
        
        return false;
    }
    
    /**
     * Actualizar puerto
     * @return bool Éxito de la operación
     */
    public function actualizar() {
        $query = "UPDATE tbl_puertos
                  SET id_estado = :id_estado,
                      observaciones = :observaciones
                  WHERE id_puerto = :id_puerto";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $this->observaciones = htmlspecialchars(strip_tags($this->observaciones ?? ''));
        
        // Vincular parámetros
        $stmt->bindParam(':id_puerto', $this->id_puerto);
        $stmt->bindParam(':id_estado', $this->id_estado);
        $stmt->bindParam(':observaciones', $this->observaciones);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Cambiar estado de puerto
     * @param int $id_estado Nuevo estado
     * @return bool Éxito de la operación
     */
    public function cambiarEstado($id_estado) {
        $query = "UPDATE tbl_puertos
                  SET id_estado = :id_estado
                  WHERE id_puerto = :id_puerto";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros
        $stmt->bindParam(':id_puerto', $this->id_puerto);
        $stmt->bindParam(':id_estado', $id_estado);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            $this->id_estado = $id_estado;
            return true;
        }
        
        return false;
    }
    
    /**
     * Asignar puerto a un cliente (instalación)
     * @param int $id_cliente ID del cliente
     * @param int $id_tecnico ID del técnico
     * @param string $fecha_instalacion Fecha de instalación
     * @return bool Éxito de la operación
     */
    public function asignarCliente($id_cliente, $id_tecnico, $fecha_instalacion) {
        // Primero cambiamos el estado del puerto a ocupado (2)
        if (!$this->cambiarEstado(2)) {
            return false;
        }
        
        // Creamos la instalación
        $query = "INSERT INTO tbl_instalaciones
                  (id_cliente, id_puerto, id_tecnico, fecha_instalacion)
                  VALUES
                  (:id_cliente, :id_puerto, :id_tecnico, :fecha_instalacion)";
        
        $stmt = $this->conn->prepare($query);
        
        // Vincular parámetros
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':id_puerto', $this->id_puerto);
        $stmt->bindParam(':id_tecnico', $id_tecnico);
        $stmt->bindParam(':fecha_instalacion', $fecha_instalacion);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Obtener instalación actual del puerto
     * @return array|null Datos de la instalación o null si no está asignado
     */
    public function obtenerInstalacion() {
        if ($this->id_estado != 2) { // Si no está ocupado
            return null;
        }
        
        $query = "SELECT i.*, 
                  c.nombre as nombre_cliente,
                  CONCAT(u.nombre_completo, ' (', u.nombre_usuario, ')') as tecnico_instalador
                  FROM tbl_instalaciones i
                  JOIN tbl_clientes c ON i.id_cliente = c.id_cliente
                  JOIN tbl_tecnicos t ON i.id_tecnico = t.id_tecnico
                  JOIN tbl_usuarios u ON t.id_usuario = u.id_usuario
                  WHERE i.id_puerto = :id_puerto
                  ORDER BY i.fecha_instalacion DESC
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_puerto', $this->id_puerto);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Liberar puerto (desinstalar cliente)
     * @param string $fecha_desinstalacion Fecha de desinstalación
     * @param int $id_tecnico ID del técnico que realiza la desinstalación
     * @param string $motivo Motivo de la desinstalación
     * @return bool Éxito de la operación
     */
    public function liberarPuerto($fecha_desinstalacion, $id_tecnico, $motivo) {
        // Obtenemos la instalación actual
        $instalacion = $this->obtenerInstalacion();
        
        if (!$instalacion) {
            return false;
        }
        
        // Actualizamos la instalación con fecha de desinstalación
        $query = "UPDATE tbl_instalaciones
                  SET fecha_desinstalacion = :fecha_desinstalacion,
                      id_tecnico_desinstalacion = :id_tecnico,
                      motivo_desinstalacion = :motivo
                  WHERE id_instalacion = :id_instalacion";
        
        $stmt = $this->conn->prepare($query);
        
        // Escapar datos
        $motivo = htmlspecialchars(strip_tags($motivo));
        
        // Vincular parámetros
        $stmt->bindParam(':id_instalacion', $instalacion['id_instalacion']);
        $stmt->bindParam(':fecha_desinstalacion', $fecha_desinstalacion);
        $stmt->bindParam(':id_tecnico', $id_tecnico);
        $stmt->bindParam(':motivo', $motivo);
        
        // Ejecutar consulta
        if ($stmt->execute()) {
            // Cambiar estado del puerto a disponible (1)
            return $this->cambiarEstado(1);
        }
        
        return false;
    }
} 