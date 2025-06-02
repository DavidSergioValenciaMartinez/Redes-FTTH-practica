<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar Usuario</h4>
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
                    
                    <form action="<?php echo URL_ROOT; ?>/users/edit?id=<?php echo $id; ?>" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">ID de Usuario</label>
                            <input type="text" class="form-control" value="<?php echo $id; ?>" readonly disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Rol del Usuario *</label>
                            <select class="form-select" id="rol_usuario" name="rol_usuario" required onchange="mostrarCamposRol()">
                                <option value="admin" <?php echo ($role === 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                                <option value="tecnico" <?php echo ($role === 'Técnico') ? 'selected' : ''; ?>>Técnico</option>
                                <option value="cliente" <?php echo ($role === 'Cliente') ? 'selected' : ''; ?>>Cliente</option>
                            </select>
                        </div>
                        <div id="campos_admin" style="display:none">
                            <div class="mb-3">
                                <label for="nivel_acceso" class="form-label">Nivel de Acceso</label>
                                <select class="form-select" id="nivel_acceso" name="nivel_acceso">
                                    <option value="total" <?php echo ($rolData['nivel_acceso'] ?? '') === 'total' ? 'selected' : ''; ?>>Total</option>
                                    <option value="reportes" <?php echo ($rolData['nivel_acceso'] ?? '') === 'reportes' ? 'selected' : ''; ?>>Reportes</option>
                                    <option value="configuraciones" <?php echo ($rolData['nivel_acceso'] ?? '') === 'configuraciones' ? 'selected' : ''; ?>>Configuraciones</option>
                                </select>
                            </div>
                        </div>
                        <div id="campos_tecnico" style="display:none">
                            <div class="mb-3">
                                <label for="certificacion" class="form-label">Certificación</label>
                                <input type="text" class="form-control" id="certificacion" name="certificacion" value="<?php echo $rolData['certificacion'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="area_asignada" class="form-label">Área Asignada</label>
                                <input type="text" class="form-control" id="area_asignada" name="area_asignada" value="<?php echo $rolData['area_asignada'] ?? ''; ?>">
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
                            <div class="input-group">
                                <input type="text" class="form-control" id="correo_local" name="correo_local" value="<?php echo isset($email) ? explode('@', $email)[0] : ''; ?>" required>
                                <span class="input-group-text" id="correo_dominio">@gmail.com</span>
                                <input type="hidden" id="correo" name="correo" value="<?php echo $email; ?>">
                            </div>
                            <div class="form-text">
                                El correo electrónico no se puede cambiar de dominio para técnicos o administradores.
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
                        
                        <div class="mb-3">
                            <label for="fotografia" class="form-label">Fotografía (opcional)</label>
                            <?php if (!empty($user['fotografia'])): ?>
                                <div class="mb-2">
                                    <img src="<?php echo $user['fotografia']; ?>" alt="Fotografía actual" style="max-width: 120px; max-height: 120px; border-radius: 8px; border: 1px solid #ccc;">
                                </div>
                            <?php endif; ?>
                            <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*">
                            <div class="form-text">Si desea cambiar la fotografía, seleccione un archivo. De lo contrario, deje este campo vacío.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($user['fecha_nacimiento']) ? $user['fecha_nacimiento'] : ''; ?>" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                            <div class="invalid-feedback" id="edadFeedback" style="display:none;">Debes ser mayor de 18 años.</div>
                        </div>
                        
                        <?php if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@solufiber-srl.com'): ?>
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

<?php endif; ?>

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

    function mostrarCamposRol() {
        var rol = document.getElementById('rol_usuario').value;
        document.getElementById('campos_admin').style.display = rol === 'admin' ? 'block' : 'none';
        document.getElementById('campos_tecnico').style.display = rol === 'tecnico' ? 'block' : 'none';
    }

    function actualizarDominioCorreo() {
        var rol = document.getElementById('rol_usuario').value;
        var dominio = '@gmail.com';
        if (rol === 'admin' || rol === 'tecnico') {
            dominio = '@solufiber-srl.com';
        }
        document.getElementById('correo_dominio').textContent = dominio;
    }

    function actualizarCorreoCompleto() {
        var local = document.getElementById('correo_local').value;
        var dominio = document.getElementById('correo_dominio').textContent;
        document.getElementById('correo').value = local + dominio;
    }

    document.getElementById('rol_usuario').addEventListener('change', function() {
        actualizarDominioCorreo();
        actualizarCorreoCompleto();
    });

    document.getElementById('correo_local').addEventListener('input', actualizarCorreoCompleto);

    document.addEventListener('DOMContentLoaded', function() {
        actualizarDominioCorreo();
        actualizarCorreoCompleto();
    });

    document.getElementById('fecha_nacimiento').addEventListener('change', function() {
        const input = this;
        const feedback = document.getElementById('edadFeedback');
        const fecha = new Date(input.value);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fecha.getFullYear();
        const m = hoy.getMonth() - fecha.getMonth();
        let esMenor = false;
        if (m < 0 || (m === 0 && hoy.getDate() < fecha.getDate())) {
            esMenor = (edad - 1) < 18;
        } else {
            esMenor = edad < 18;
        }
        if (esMenor) {
            input.setCustomValidity('Debes ser mayor de 18 años.');
            feedback.style.display = 'block';
        } else {
            input.setCustomValidity('');
            feedback.style.display = 'none';
        }
    });
</script> 