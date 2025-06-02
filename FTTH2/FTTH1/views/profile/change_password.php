<?php require_once APPROOT . '/views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row mb-3">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URL_ROOT; ?>/profile">Mi Perfil</a></li>
                    <li class="breadcrumb-item active">Cambiar Contraseña</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-key me-2"></i>Cambiar Contraseña</h4>
                </div>

                <div class="card-body">
                    <?php flash('profile_message'); ?>

                    <form action="<?php echo URL_ROOT; ?>/profile/updatePassword" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" class="form-control <?php echo (!empty($data['current_password_err'])) ? 'is-invalid' : ''; ?>" 
                                id="current_password" name="current_password" required>
                            <div class="invalid-feedback">
                                <?php echo $data['current_password_err']; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control <?php echo (!empty($data['new_password_err'])) ? 'is-invalid' : ''; ?>" 
                                id="new_password" name="new_password" required>
                            <div class="invalid-feedback">
                                <?php echo $data['new_password_err']; ?>
                            </div>
                            <div class="form-text">
                                La contraseña debe tener al menos 8 caracteres.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" 
                                id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">
                                <?php echo $data['confirm_password_err']; ?>
                            </div>
                        </div>
                        
                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle me-1"></i> Después de cambiar su contraseña, tendrá que iniciar sesión nuevamente.
                            </small>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Contraseña
                            </button>
                            
                            <a href="<?php echo URL_ROOT; ?>/profile" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Volver al Perfil
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Script para validación del formulario
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?> 