<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Base de Datos - SOLUFIBER S.R.L.</title>
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
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }
        .card h2 {
            margin-top: 0;
            color: #0d6efd;
        }
        .btn {
            display: inline-block;
            background-color: #0d6efd;
            color: white;
            padding: 10px 15px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo i {
            font-size: 48px;
            color: #0d6efd;
        }
    </style>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="bi bi-broadcast-pin"></i>
            <h1>SOLUFIBER S.R.L.</h1>
            <p>Configuración de Base de Datos</p>
        </div>
        
        <div class="card">
            <h2>Parámetros de Conexión</h2>
            <p>Ver los detalles sobre los cambios realizados en la configuración de la base de datos.</p>
            <a href="conexion_actualizada.php" class="btn">Ver Configuración</a>
        </div>
        
        <div class="card">
            <h2>Prueba de Conexión</h2>
            <p>Verificar que la conexión a la base de datos funciona correctamente con los nuevos parámetros.</p>
            <a href="test_db.php" class="btn">Probar Conexión</a>
        </div>
        
        <div class="card">
            <h2>Acceder al Sistema</h2>
            <p>Ir a la página principal del sistema para comenzar a utilizarlo con la nueva configuración.</p>
            <a href="index.php" class="btn">Ir al Sistema</a>
        </div>
        
        <hr>
        <p style="text-align: center; color: #6c757d;">© 2023 SOLUFIBER S.R.L. - Sistema para Redes de Fibra Óptica FTTH</p>
    </div>
</body>
</html> 