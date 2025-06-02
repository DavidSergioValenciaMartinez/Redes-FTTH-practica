<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Crear Nuevo Usuario</h4>
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
                            Usuario creado correctamente
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="<?php echo URL_ROOT; ?>/users/create" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="nombre_completo" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                                   value="<?php echo isset($userData['nombre_completo']) ? $userData['nombre_completo'] : ''; ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre completo.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico *</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="correo_local" name="correo_local" placeholder="usuario" required>
                                <span class="input-group-text" id="correo_dominio">@gmail.com</span>
                                <input type="hidden" id="correo" name="correo" value="">
                            </div>
                            <div class="form-text email-help">
                                <span id="emailGenerated" class="d-none text-info">
                                    <i class="bi bi-info-circle"></i> 
                                    El correo electrónico se generará automáticamente basado en el nombre y el rol.
                                </span>
                                <span id="emailWarning" class="d-none text-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Los correos para staff deben ser del dominio @solufiber-srl.com.
                                </span>
                                <span id="emailClientInfo" class="d-none">
                                    El correo no puede ser del dominio @solufiber-srl.com para clientes.
                                </span>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingrese un correo electrónico válido.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            <div class="form-text">
                                La contraseña debe tener al menos 8 caracteres, incluir números y letras.
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingrese una contraseña.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control" id="confirmar_contrasena" name="confirmar_contrasena" required>
                            <div class="invalid-feedback">
                                Las contraseñas no coinciden.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" 
                                   value="<?php echo isset($userData['telefono']) ? $userData['telefono'] : ''; ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" rows="2"><?php echo isset($userData['direccion']) ? $userData['direccion'] : ''; ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cedula_identidad" class="form-label">Cédula de Identidad *</label>
                            <input type="text" class="form-control" id="cedula_identidad" name="cedula_identidad" value="<?php echo isset($userData['cedula_identidad']) ? $userData['cedula_identidad'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="nombre_usuario" class="form-label">Nombre de Usuario *</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo isset($userData['nombre_usuario']) ? $userData['nombre_usuario'] : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                            <div class="invalid-feedback" id="edadFeedback" style="display:none;">Debes ser mayor de 18 años.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fotografia" class="form-label">Fotografía (obligatoria)</label>
                            <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Rol del Usuario *</label>
                            <select class="form-select" id="rol_usuario" name="rol_usuario" required onchange="mostrarCamposRol()">
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="admin">Administrador</option>
                                <option value="tecnico">Técnico</option>
                                <option value="cliente">Cliente</option>
                            </select>
                        </div>
                        <div id="campos_admin" style="display:none">
                            <div class="mb-3">
                                <label for="nivel_acceso" class="form-label">Nivel de Acceso</label>
                                <select class="form-select" id="nivel_acceso" name="nivel_acceso">
                                    <option value="total">Total</option>
                                    <option value="reportes">Reportes</option>
                                    <option value="configuraciones">Configuraciones</option>
                                </select>
                            </div>
                        </div>
                        <div id="campos_tecnico" style="display:none">
                            <div class="mb-3">
                                <label for="certificacion" class="form-label">Certificación</label>
                                <input type="text" class="form-control" id="certificacion" name="certificacion">
                            </div>
                            <div class="mb-3">
                                <label for="area_asignada" class="form-label">Área Asignada</label>
                                <input type="text" class="form-control" id="area_asignada" name="area_asignada">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-person-plus-fill"></i> Crear Usuario
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
        const emailInput = document.getElementById('correo');
        const nameInput = document.getElementById('nombre_completo');
        
        // Validación de formulario
        const form = document.querySelector('form');
        const password = document.getElementById('contrasena');
        const confirmPassword = document.getElementById('confirmar_contrasena');
        
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            // Verificar que las contraseñas coincidan
            if (password.value !== confirmPassword.value) {
                confirmPassword.setCustomValidity('Las contraseñas no coinciden');
                event.preventDefault();
                event.stopPropagation();
            } else {
                confirmPassword.setCustomValidity('');
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

        function mostrarCamposRol() {
            var rol = document.getElementById('rol_usuario').value;
            document.getElementById('campos_admin').style.display = rol === 'admin' ? 'block' : 'none';
            document.getElementById('campos_tecnico').style.display = rol === 'tecnico' ? 'block' : 'none';
        }
        mostrarCamposRol();

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
    });
</script> 