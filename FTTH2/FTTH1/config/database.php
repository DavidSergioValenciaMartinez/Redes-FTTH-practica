<?php
/**
 * Conexión a la base de datos
 */
class Database {
    private $host = 'localhost:3306';
    private $db_name = 'solufiber_ftth';
    private $username = 'root';
    private $password = '12345678';
    private $conn;

    /**
     * Establecer la conexión con la base de datos
     * @return PDO objeto de conexión
     */
    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4',
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            // Establecer el conjunto de caracteres
            $this->conn->exec("SET NAMES 'utf8mb4'");
            
        } catch(PDOException $e) {
            error_log('Error de conexión: ' . $e->getMessage());
        }

        return $this->conn;
    }
} 