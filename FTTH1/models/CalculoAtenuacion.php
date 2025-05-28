<?php

class CalculoAtenuacion extends Model {
    protected $table = 'tbl_calculos_atenuacion';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Guarda un nuevo cálculo de atenuación en la base de datos.
     *
     * @param array $data Datos del cálculo a guardar.
     * @return bool True si se guarda correctamente, false en caso contrario.
     */
    public function guardarCalculo($data) {
        $sql = 'INSERT INTO ' . $this->table . ' (id_puerto, tipo_calculo, distancia_km, conectores, fusiones, atenuacion_total_db, calculado_por) VALUES (:id_puerto, :tipo_calculo, :distancia_km, :conectores, :fusiones, :atenuacion_total_db, :calculado_por)';
        
        // Use the prepare method from the base Model class
        $stmt = $this->prepare($sql);

        // Check if prepare was successful
        if (!$stmt) {
            error_log('Error preparing SQL statement: ' . $sql);
            return false;
        }

        // Bind values
        // Note: Using bindValue with named placeholders
        $stmt->bindValue(':id_puerto', $data['id_puerto']);
        $stmt->bindValue(':tipo_calculo', 'balanceado'); // Assuming this model is specifically for balanceado
        $stmt->bindValue(':distancia_km', $data['distancia_km']); // Use distancia_km from the passed data
        $stmt->bindValue(':conectores', $data['conectores'] ?? 0); // Default to 0 if not provided
        $stmt->bindValue(':fusiones', $data['fusiones'] ?? 0); // Default to 0 if not provided
        $stmt->bindValue(':atenuacion_total_db', $data['atenuacion_total_db']);
        $stmt->bindValue(':calculado_por', $data['calculado_por']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}