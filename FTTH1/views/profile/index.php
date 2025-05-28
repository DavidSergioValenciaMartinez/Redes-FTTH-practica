<?php
// Título de la página
$pageTitle = 'Mi Perfil';
// Incluir el encabezado
require_once VIEWS_PATH . '/layouts/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Mi Perfil</h4>
                </div>
                <div class="card-body">
                    <?php flash('profile_message'); ?>
                    
                    <?php if(isset($data['user']) && $data['user']): ?>
                        <form action="<?php echo URL_ROOT; ?>/profile/update" method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="nombre_completo" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control <?php echo (!empty($data['nombre_completo_err'])) ? 'is-invalid' : ''; ?>" 
                                    id="nombre_completo" name="nombre_completo" 
                                    value="<?php echo $data['user']->nombre_completo; ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingrese su nombre completo.
                                </div>
                            </div>
                            
                            <?php 
                            // Verificar si el usuario es cliente (no tiene correo @solufiber-srl.com)
                            $isClient = (strpos($data['user']->correo, '@solufiber-srl.com') === false);
                            if($isClient): 
                            ?>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control <?php echo (!empty($data['correo_err'])) ? 'is-invalid' : ''; ?>" 
                                    id="correo" name="correo" 
                                    value="<?php echo $data['user']->correo; ?>" required>
                                <div class="invalid-feedback">
                                    Por favor ingrese un correo electrónico válido.
                                </div>
                                <div class="form-text">Este correo se utilizará para iniciar sesión.</div>
                            </div>
                            <?php else: ?>
                            <div class="mb-3">
                                <label for="correo_disabled" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" 
                                    id="correo_disabled" 
                                    value="<?php echo $data['user']->correo; ?>" disabled readonly>
                                <input type="hidden" name="correo" value="<?php echo $data['user']->correo; ?>">
                                <div class="form-text">Como miembro del personal, no puede cambiar su correo electrónico.</div>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                                <a href="<?php echo URL_ROOT; ?>/profile/password" class="btn btn-outline-secondary">
                                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">
                            No se encontró información del usuario. <a href="<?php echo URL_ROOT; ?>">Volver al inicio</a>
                        </div>
                    <?php endif; ?>
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

<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?> 