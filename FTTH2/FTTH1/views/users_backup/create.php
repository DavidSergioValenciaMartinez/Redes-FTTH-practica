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
                    
                    <form action="<?php echo URL_ROOT; ?>/users/create" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="role" class="form-label">Tipo de Usuario *</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                <option value="client" <?php echo isset($userData['role']) && $userData['role'] == 'client' ? 'selected' : ''; ?>>Cliente</option>
                                <option value="technician" <?php echo isset($userData['role']) && $userData['role'] == 'technician' ? 'selected' : ''; ?>>Técnico</option>
                                <option value="operator" <?php echo isset($userData['role']) && $userData['role'] == 'operator' ? 'selected' : ''; ?>>Operador</option>
                                <option value="admin" <?php echo isset($userData['role']) && $userData['role'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                            </select>
                            <div class="form-text">
                                El rol determina los permisos del usuario en el sistema.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="<?php echo isset($userData['name']) ? $userData['name'] : ''; ?>" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre completo.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($userData['email']) ? $userData['email'] : ''; ?>" required>
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
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="form-text">
                                La contraseña debe tener al menos 8 caracteres, incluir números y letras.
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingrese una contraseña.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            <div class="invalid-feedback">
                                Las contraseñas no coinciden.
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
        const roleSelect = document.getElementById('role');
        const emailInput = document.getElementById('email');
        const nameInput = document.getElementById('name');
        const emailHelp = document.querySelector('.email-help');
        const emailGenerated = document.getElementById('emailGenerated');
        const emailWarning = document.getElementById('emailWarning');
        const emailClientInfo = document.getElementById('emailClientInfo');
        
        // Función para mostrar/ocultar campos según el rol
        function toggleEmailVisibility() {
            const role = roleSelect.value;
            
            // Para roles de staff (admin, operator, technician)
            if (['admin', 'operator', 'technician'].includes(role)) {
                emailInput.readOnly = true;
                emailInput.placeholder = 'Se generará automáticamente';
                emailGenerated.classList.remove('d-none');
                emailWarning.classList.add('d-none');
                emailClientInfo.classList.add('d-none');
                
                // Generar email basado en nombre y rol
                if (nameInput.value) {
                    generateEmail();
                }
            } else {
                // Para clientes
                emailInput.readOnly = false;
                emailInput.placeholder = '';
                emailGenerated.classList.add('d-none');
                emailWarning.classList.add('d-none');
                emailClientInfo.classList.remove('d-none');
            }
        }
        
        // Generar email basado en nombre y rol
        function generateEmail() {
            const role = roleSelect.value;
            const name = nameInput.value.trim().toLowerCase();
            
            if (!name || !['admin', 'operator', 'technician'].includes(role)) {
                return;
            }
            
            // Eliminar acentos y caracteres especiales
            const normalizedName = name.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            // Eliminar caracteres no alfanuméricos
            const cleanName = normalizedName.replace(/[^a-z0-9]/g, '');
            
            let email = '';
            const domain = 'solufiber-srl.com';
            
            if (role === 'admin') {
                email = `admin@${domain}`;
            } else if (role === 'operator') {
                email = `operador.${cleanName}@${domain}`;
            } else { // technician
                email = `${cleanName}@${domain}`;
            }
            
            emailInput.value = email;
        }
        
        // Eventos
        roleSelect.addEventListener('change', toggleEmailVisibility);
        nameInput.addEventListener('input', function() {
            if (['admin', 'operator', 'technician'].includes(roleSelect.value)) {
                generateEmail();
            }
        });
        
        // Validación de formulario
        const form = document.querySelector('form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        
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
        
        // Inicializar
        toggleEmailVisibility();
    });
</script> 