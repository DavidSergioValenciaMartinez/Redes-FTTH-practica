<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo isset($data['title']) ? $data['title'] : 'SOLUFIBER S.R.L. - Soluciones de Fibra Optica'; ?></title>
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= BASE_URL ?>/public/img/favicon.png" type="image/png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="<?php echo URL_ROOT; ?>/public/css/styles.css">
</head>
<body data-role="<?= isset($_SESSION['user_role']) ? $_SESSION['user_role'] : 'guest' ?>"<?= isset($_COOKIE['alt_style']) && $_COOKIE['alt_style'] == '1' ? ' class="alt-style"' : '' ?>>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo URL_ROOT; ?>">
                <i class="fas fa-network-wired me-2"></i>
                <span class="fw-bold">SOLUFIBER <span class="text-primary">S.R.L.</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3" style="min-width: 140px; justify-content: center;" <?php echo (isset($active_page) && $active_page === 'inicio') ? 'active' : ''; ?> href="<?php echo URL_ROOT; ?>/inicio">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])): ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3" style="min-width: 140px; justify-content: center;" href="<?php echo URL_ROOT; ?>/catalogo">
                            <i class="fas fa-book me-1"></i> Catálogo
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3" style="min-width: 140px; justify-content: center;" href="<?php echo URL_ROOT; ?>/soporte">
                            <i class="fas fa-headset me-1"></i> Soporte
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3" style="min-width: 140px; justify-content: center;" href="<?php echo URL_ROOT; ?>/consulta">
                            <i class="fas fa-search me-1"></i> Consulta
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center px-3" style="min-width: 140px; justify-content: center;" <?php echo (isset($active_page) && $active_page === 'asignaciones') ? 'active' : ''; ?> href="<?php echo URL_ROOT; ?>/asignaciones">
                            <i class="fas fa-user-tag me-1"></i> Asignaciones
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_role']) && in_array($_SESSION['user_role'], ['tecnico', 'admin', 'technician'])): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isset($active_page) && in_array($active_page, ['balanceados','desbalanceados'])) ? 'active' : ''; ?>" href="#" id="calculoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-calculator me-1"></i> Cálculo
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="calculoDropdown">
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/balanceados"><i class="fas fa-balance-scale me-1"></i> Balanceados</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/desbalanceados"><i class="fas fa-unbalance me-1"></i> Desbalanceados</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle <?php echo (isset($active_page) && in_array($active_page, ['departamentos','cajas_nap','puertos','instalaciones'])) ? 'active' : ''; ?>" href="#" id="gestionDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-cogs me-1"></i> Verificación de Red
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="gestionDropdown">
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/departamentos"><i class="fas fa-map-marker-alt me-1"></i> Departamentos</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/cajas_nap"><i class="fas fa-box me-1"></i> Cajas NAP</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/puertos"><i class="mdi mdi-ethernet me-1"></i> Puertos</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/instalaciones"><i class="fas fa-tools me-1"></i> Instalaciones</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/hoja_tecnica"><i class="fas fa-file-alt me-1"></i> Hoja Técnica</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/asignaciones"><i class="fas fa-user-tag me-1"></i> Asignaciones</a></li>
                            <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/mediciones"><i class="fas fa-microscope me-1"></i> Medición de Puertos</a></li>
                        </ul>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-1"></i> <?php echo $_SESSION['user_name']; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/perfil"><i class="fas fa-id-card me-1"></i> Mi Perfil</a></li>
                                <?php if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@solufiber-srl.com'): ?>
                                <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/users"><i class="fas fa-users-cog me-1"></i> Gestión de Usuarios</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo URL_ROOT; ?>/logout"><i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo URL_ROOT; ?>/login" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesion
                        </a>
                        <a href="<?php echo URL_ROOT; ?>/register" class="btn btn-primary">
                            <i class="fas fa-user-plus me-1"></i> Registro
                        </a>
                    <?php endif; ?>
                    <button id="toggleStyle" class="btn btn-sm btn-secondary ms-2" title="Cambiar estilo">
                        <i class="fas fa-palette"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <?php if (isset($_SESSION['mensaje'])): ?>
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['mensaje']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['mensaje']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <!-- Aquí comienza el contenido principal -->
    <div class="main-content">

