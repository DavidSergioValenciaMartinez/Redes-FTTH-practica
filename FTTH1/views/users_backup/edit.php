<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar Usuario</h4>
                    <a href="<?php echo URL_ROOT; ?>/user" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Usuario actualizado correctamente
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php 
                        // Determinar rol basado en el email
                        $role = 'Cliente';
                        $badgeClass = 'bg-secondary';
                        
                        $correo = isset($user['correo']) ? $user['correo'] : '';
                        
                        if (!empty($correo) && strpos($correo, '@solufiber-srl.com') !== false) {
                            if (strpos($correo, 'admin@') === 0) {
                                $role = 'Administrador';
                                $badgeClass = 'bg-danger';
                            } else if (strpos($correo, 'operador.') === 0) {
                                $role = 'Operador';
                                $badgeClass = 'bg-warning text-dark';
                            } else {
                                $role = 'Técnico';
                                $badgeClass = 'bg-info text-dark';
                            }
                        }
                        
                        // Mapear campos que puedan tener nombres diferentes
                        $id = isset($user['id_usuario']) ? $user['id_usuario'] : (isset($user['id']) ? $user['id'] : '?');
                        $nombre = isset($user['nombre_completo']) ? $user['nombre_completo'] : (isset($user['name']) ? $user['name'] : '');
                        $email = isset($user['correo']) ? $user['correo'] : (isset($user['email']) ? $user['email'] : '');
                    ?>
                    
                    <form action="<?php echo URL_ROOT; ?>/user/edit?id=<?php echo $id; ?>" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label class="form-label">ID de Usuario</label>
                            <input type="text" class="form-control" value="<?php echo $id; ?>" readonly disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <div>
                                <span class="badge <?php echo $badgeClass; ?>"><?php echo $role; ?></span>
                                <small class="text-muted ms-2">El rol no se puede cambiar</small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                                   value="<?php echo $nombre; ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre completo.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" value="<?php echo $email; ?>" readonly disabled>
                            <div class="form-text">
                                El correo electrónico no se puede cambiar.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" 
                                   value="<?php echo isset($user['telefono']) ? $user['telefono'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2"><?php echo isset($user['direccion']) ? $user['direccion'] : ''; ?></textarea>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5>Cambiar Contraseña</h5>
                        <p class="text-muted">Deje estos campos en blanco si no desea cambiar la contraseña</p>
                        
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Nueva Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena">
                            <div class="form-text">
                                La contraseña debe tener al menos 8 caracteres, incluir números y letras.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmar_contrasena" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena">
                            <div class="invalid-feedback">
                                Las contraseñas no coinciden.
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación de formulario
        const form = document.querySelector('form');
        const password = document.getElementById('contrasena');
        const confirmPassword = document.getElementById('confirmar_contrasena');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Si se introduce una contraseña, verificar que ambas coincidan
            if (password.value || confirmPassword.value) {
                if (password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
            
            form.classList.add('was-validated');
        });
        
        confirmPassword.addEventListener('input', function() {
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            } else {
                confirmPassword.setCustomValidity('');
            }
        });
    });
</script> 