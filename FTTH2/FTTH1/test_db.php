<?php
require_once 'config/database.php';

// Mostrar errores en caso de fallos
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de Conexión a la Base de Datos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #0d6efd;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #28a745;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #dc3545;
        }
        .params {
            background-color: #e2f0fb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #0d6efd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prueba de Conexión a Base de Datos</h1>
        
        <div class="params">
            <h3>Parámetros de Conexión</h3>
            <p><strong>Host:</strong> localhost:3306</p>
            <p><strong>Base de datos:</strong> solufiber_ftth</p>
            <p><strong>Usuario:</strong> root</p>
            <p><strong>Contraseña:</strong> 12345678</p>
        </div>
        
        <?php
        try {
            // Crear instancia de la clase Database
            $database = new Database();
            
            // Intentar conectar
            $db = $database->connect();
            
            if ($db) {
                echo "<div class='success'>
                    <h3>✅ Conexión Exitosa</h3>
                    <p>Se ha establecido correctamente la conexión a la base de datos <strong>solufiber_ftth</strong>.</p>
                </div>";
                
                // Intentar realizar una consulta simple para verificar que todo funciona
                $query = "SHOW TABLES";
                $stmt = $db->prepare($query);
                $stmt->execute();
                
                $tables = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($tables) > 0) {
                    echo "<h2>Tablas en la Base de Datos</h2>";
                    echo "<table>";
                    echo "<tr><th>#</th><th>Nombre de la Tabla</th></tr>";
                    
                    $count = 1;
                    foreach ($tables as $table) {
                        echo "<tr>";
                        echo "<td>" . $count . "</td>";
                        echo "<td>" . $table['Tables_in_solufiber_ftth'] . "</td>";
                        echo "</tr>";
                        $count++;
                    }
                    
                    echo "</table>";
                } else {
                    echo "<div class='warning'>
                        <h3>⚠️ Base de Datos Vacía</h3>
                        <p>La conexión fue exitosa, pero la base de datos no contiene tablas.</p>
                    </div>";
                }
                
            } else {
                echo "<div class='error'>
                    <h3>❌ Error de Conexión</h3>
                    <p>No se pudo establecer la conexión a la base de datos.</p>
                </div>";
            }
        } catch (PDOException $e) {
            echo "<div class='error'>
                <h3>❌ Error de Conexión</h3>
                <p>" . $e->getMessage() . "</p>
            </div>";
        }
        ?>
        
        <a href="conexion_actualizada.php" class="btn">Volver a la Página de Configuración</a>
    </div>
</body>
</html> 