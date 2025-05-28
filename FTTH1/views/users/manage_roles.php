<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestionar Rol de Usuario</h4>
                    <a href="<?php echo URL_ROOT; ?>/users" class="btn btn-light">
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
                    
                    <div class="mb-4">
                        <h5>Usuario: <?php echo isset($user['nombre_completo']) ? $user['nombre_completo'] : ''; ?></h5>
                        <p class="text-muted mb-0">
                            <i class="bi bi-envelope"></i> <?php echo isset($user['correo']) ? $user['correo'] : ''; ?>
                        </p>
                        <p class="text-muted">
                            <i class="bi bi-person-badge"></i> ID: <?php echo isset($user['id_usuario']) ? $user['id_usuario'] : ''; ?>
                        </p>
                    </div>
                    
                    <?php
                    // Determinar el rol actual del usuario basado en el correo electrónico
                    $currentRole = 'cliente';
                    $correo = isset($user['correo']) ? $user['correo'] : '';
                    
                    if (!empty($correo) && strpos($correo, '@solufiber-srl.com') !== false) {
                        if (strpos($correo, 'admin@') === 0) {
                            $currentRole = 'administrador';
                        } else if (strpos($correo, 'operador.') === 0) {
                            $currentRole = 'operador';
                        } else {
                            $currentRole = 'tecnico';
                        }
                    }
                    ?>
                    
                    <form action="<?php echo URL_ROOT; ?>/users/manageRoles?id=<?php echo $user['id_usuario']; ?>" method="POST">
                        <h5>Seleccionar Rol</h5>
                        <p class="text-muted">Seleccione el rol que tendrá este usuario en el sistema.</p>
                        
                        <div class="list-group mb-4">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="selected_role" id="role_admin" value="administrador" <?php echo $currentRole === 'administrador' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="role_admin">
                                    <strong>Administrador</strong>
                                    <small class="text-muted d-block">Acceso completo a todas las funciones del sistema.</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="selected_role" id="role_operador" value="operador" <?php echo $currentRole === 'operador' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="role_operador">
                                    <strong>Operador</strong>
                                    <small class="text-muted d-block">Gestión de operaciones diarias y atención al cliente.</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="selected_role" id="role_tecnico" value="tecnico" <?php echo $currentRole === 'tecnico' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="role_tecnico">
                                    <strong>Técnico</strong>
                                    <small class="text-muted d-block">Instalaciones, mantenimiento y soporte técnico.</small>
                                </label>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="selected_role" id="role_cliente" value="cliente" <?php echo $currentRole === 'cliente' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="role_cliente">
                                    <strong>Cliente</strong>
                                    <small class="text-muted d-block">Acceso limitado a sus propios servicios y solicitudes.</small>
                                </label>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Importante:</strong> Al cambiar el rol se modificará el correo electrónico del usuario según las políticas del sistema.
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