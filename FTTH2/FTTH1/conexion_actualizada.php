<?php
// Archivo de demostración visual de la configuración de base de datos actualizada
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Base de Datos</title>
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
        h1 {
            color: #0d6efd;
            text-align: center;
            margin-bottom: 30px;
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
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .old {
            background-color: #ffeeee;
        }
        .new {
            background-color: #eeffee;
        }
        .code {
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            font-family: monospace;
            white-space: pre;
            overflow-x: auto;
            margin: 20px 0;
        }
        .btn {
            display: block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto;
            max-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Actualización de Configuración de Base de Datos</h1>
        
        <h2>Cambios Realizados</h2>
        <table>
            <tr>
                <th>Parámetro</th>
                <th class="old">Configuración Anterior</th>
                <th class="new">Nueva Configuración</th>
            </tr>
            <tr>
                <td>Host</td>
                <td class="old">localhost</td>
                <td class="new">localhost:3306</td>
            </tr>
            <tr>
                <td>Usuario</td>
                <td class="old">root</td>
                <td class="new">root</td>
            </tr>
            <tr>
                <td>Contraseña</td>
                <td class="old">[vacía]</td>
                <td class="new">12345678</td>
            </tr>
            <tr>
                <td>Base de datos</td>
                <td class="old">solufiber_ftth</td>
                <td class="new">solufiber_ftth</td>
            </tr>
        </table>

        <h2>Código Actualizado</h2>
        <p>El archivo <code>config/database.php</code> ha sido modificado con los nuevos parámetros:</p>
        
        <div class="code">
&lt;?php
/**
 * Conexión a la base de datos
 */
class Database {
    private $host = 'localhost:3306';
    private $db_name = 'solufiber_ftth';
    private $username = 'root';
    private $password = '12345678';
    private $conn;

    // resto del código...
}
?&gt;
</div>

        <h2>Verificación de Conexión</h2>
        <p>Para verificar que la conexión funciona correctamente, puede acceder al script de prueba:</p>
        
        <a href="test_db.php" class="btn">Probar Conexión</a>
        
        <p>Este script intentará conectarse a la base de datos con los nuevos parámetros y mostrará las tablas disponibles si la conexión es exitosa.</p>
    </div>
</body>
</html> 