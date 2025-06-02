<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['title']) ? $data['title'] : 'FTTH Management System'; ?></title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo URL_ROOT; ?>/public/img/favicon.png" type="image/png">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/css/style.css">
</head>
<body class="<?php echo isset($_COOKIE['alt_style']) ? 'alt-style' : ''; ?>" 
      data-role="<?php echo isset($_SESSION['user_role']) ? $_SESSION['user_role'] : ''; ?>">

    <!-- Mensajes de alerta -->
    <?php if(isset($_SESSION['mensaje'])): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        unset($_SESSION['mensaje']);
    endif; 
    ?>
    
    <?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 end-0 m-3" style="z-index: 9999;" role="alert">
        <?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        unset($_SESSION['error']);
    endif; 
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo URL_ROOT; ?>/">
                <img src="<?php echo URL_ROOT; ?>/public/img/logo.png" alt="Logo" height="40" class="me-2">
                <span>SOLUFIBER S.R.L.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($data['currentSection']) && $data['currentSection'] === 'home') ? 'active' : ''; ?>" href="<?php echo URL_ROOT; ?>/inicio" data-section="home">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($data['currentSection']) && $data['currentSection'] === 'catalogo') ? 'active' : ''; ?>" href="<?php echo URL_ROOT; ?>/catalogo" data-section="catalogo">
                            <i class="fas fa-book me-1"></i>Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($data['currentSection']) && $data['currentSection'] === 'consulta') ? 'active' : ''; ?>" href="<?php echo URL_ROOT; ?>/consulta" data-section="consulta">
                            <i class="fas fa-search me-1"></i>Consulta
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($data['currentSection']) && $data['currentSection'] === 'soporte') ? 'active' : ''; ?>" href="<?php echo URL_ROOT; ?>/soporte" data-section="soporte">
                            <i class="fas fa-headset me-1"></i>Soporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($data['currentSection']) && $data['currentSection'] === 'empresa') ? 'active' : ''; ?>" href="<?php echo URL_ROOT; ?>/empresa" data-section="empresa">
                            <i class="fas fa-building me-1"></i>Empresa
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-id-card me-2"></i>Perfil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/logout"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <button class="btn nav-link" id="toggleStyle">
                                <i class="fas fa-adjust"></i>
                            </button>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo URL_ROOT; ?>/login">
                                <i class="fas fa-sign-in-alt me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main> 
    <pre><?php print_r($data['puertos']); ?></pre>
    </main> 