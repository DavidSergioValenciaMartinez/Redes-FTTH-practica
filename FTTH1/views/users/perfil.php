<?php require_once VIEWS_PATH . '/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Mi Perfil</h2>
    <div class="card mt-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Nombre completo:</strong><br>
                    <?php echo htmlspecialchars($user['nombre_completo']); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Correo electrónico:</strong><br>
                    <?php echo htmlspecialchars($user['correo']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Nombre de usuario:</strong><br>
                    <?php echo htmlspecialchars($user['nombre_usuario']); ?>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Teléfono:</strong><br>
                    <?php echo htmlspecialchars($user['telefono']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Dirección:</strong><br>
                    <?php echo htmlspecialchars($user['direccion']); ?>
                </div>
            </div>
            <div class="mt-4">
                <a href="<?php echo URL_ROOT; ?>/users/edit/<?php echo $user['id_usuario']; ?>" class="btn btn-primary">Editar Perfil</a>
            </div>
        </div>
    </div>
</div>
<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?> 