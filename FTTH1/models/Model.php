<?php
/**
 * Clase Model base
 * Proporciona métodos comunes para todos los modelos
 */
class Model {
    /**
     * Instancia de la conexión a la base de datos
     * @var PDO
     */
    protected $db;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Inicializar la conexión a la base de datos cuando sea necesario
        $this->db = $this->getDbConnection();
    }
    
    /**
     * Obtiene la conexión a la base de datos
     * 
     * @return PDO
     */
    protected function getDbConnection() {
        // Para implementación real:
        
        try {
            $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME;
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ];
            
            return new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Registrar error y devolver null
            error_log('Error de conexión: ' . $e->getMessage());
            return null;
        }
        
        // Por ahora, simplemente devolvemos null
        // return null;
    }
    
    /**
     * Prepara una consulta SQL con parámetros
     * 
     * @param string $sql Consulta SQL
     * @param array $params Parámetros para la consulta
     * @return PDOStatement|null
     */
    protected function prepare($sql, $params = []) {
        // Verificar si hay conexión a la base de datos
        if (!$this->db) {
            return null;
        }
        
        try {
            $stmt = $this->db->prepare($sql);
            
            // Vincular parámetros si existen
            if (!empty($params)) {
                foreach ($params as $param => $value) {
                    $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                    $stmt->bindValue(is_numeric($param) ? $param + 1 : $param, $value, $type);
                }
            }
            
            return $stmt;
        } catch (PDOException $e) {
            // Registrar error y devolver null
            error_log('Error en consulta: ' . $e->getMessage());
            return null;
        }
    }
}
?>