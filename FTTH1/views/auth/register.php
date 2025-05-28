<!-- Vista de Registro -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-broadcast-pin" style="font-size: 3.5rem; color: #0d6efd;"></i>
                        <h2 class="mt-2 mb-2 fw-bold">SOLUFIBER S.R.L.</h2>
                        <p class="text-muted">Registro de Usuario</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/register" method="POST">
                        <div class="mb-3">
                            <label for="nombre_completo" class="form-label">Nombre completo</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                                       value="<?php echo isset($userData['nombre_completo']) ? $userData['nombre_completo'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" 
                                       value="<?php echo isset($userData['correo']) ? $userData['correo'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="tel" class="form-control" id="telefono" name="telefono"
                                       value="<?php echo isset($userData['telefono']) ? $userData['telefono'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" class="form-control" id="direccion" name="direccion"
                                       value="<?php echo isset($userData['direccion']) ? $userData['direccion'] : ''; ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                            </div>
                            <div class="form-text">La contraseña debe tener al menos 8 caracteres, incluir números y letras.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="contrasena_confirm" class="form-label">Confirmar contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" class="form-control" id="contrasena_confirm" name="contrasena_confirm" required>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="termsAgree" name="terms" required>
                            <label class="form-check-label" for="termsAgree">Acepto los <a href="#">términos y condiciones</a></label>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Registrarme</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <p>¿Ya tienes una cuenta? <a href="<?php echo URL_ROOT; ?>/login">Inicia Sesión</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para validar el dominio del correo según el rol -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del formulario
    const roleInputs = document.querySelectorAll('input[name="tipo_usuario"]');
    const emailInput = document.getElementById('correo');
    
    // Función para validar el dominio del correo
    function validateEmailDomain() {
        const selectedRole = document.querySelector('input[name="tipo_usuario"]:checked').value;
        const email = emailInput.value.trim();
        
        // Remover cualquier mensaje de error previo
        const oldError = document.getElementById('emailDomainError');
        if (oldError) oldError.remove();
        
        // Si no hay email, no validar
        if (!email) return;
        
        let errorMessage = null;
        
        // Verificar roles de staff (técnico, operador, admin)
        if (['technician', 'operator', 'admin'].includes(selectedRole)) {
            if (email.indexOf('@solufiber-srl.com') === -1) {
                errorMessage = `Para registrarse como ${getRoleName(selectedRole)}, debe usar un correo con dominio @solufiber-srl.com`;
            }
        } 
        // Verificar rol cliente
        else if (selectedRole === 'client') {
            if (email.indexOf('@solufiber-srl.com') !== -1) {
                errorMessage = 'Las cuentas con dominio @solufiber-srl.com están reservadas para el personal de SOLUFIBER S.R.L.';
            }
        }
        
        // Mostrar mensaje de error si existe
        if (errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'emailDomainError';
            errorDiv.className = 'text-danger mt-1';
            errorDiv.innerHTML = `<small><i class="fas fa-exclamation-circle"></i> ${errorMessage}</small>`;
            emailInput.parentNode.after(errorDiv);
        }
    }
    
    // Función para obtener nombre del rol en español
    function getRoleName(role) {
        const roles = {
            'client': 'Cliente',
            'technician': 'Técnico',
            'operator': 'Operador',
            'admin': 'Administrador'
        };
        return roles[role] || 'Usuario';
    }
    
    // Añadir eventos para validar cuando cambia el rol o el email
    roleInputs.forEach(input => {
        input.addEventListener('change', validateEmailDomain);
    });
    
    emailInput.addEventListener('blur', validateEmailDomain);
    emailInput.addEventListener('input', validateEmailDomain);
    
    // Validar formulario antes de enviarlo
    document.querySelector('form').addEventListener('submit', function(e) {
        validateEmailDomain();
        
        // Si hay error de dominio, prevenir envío del formulario
        if (document.getElementById('emailDomainError')) {
            e.preventDefault();
            // Hacer scroll al error
            document.getElementById('emailDomainError').scrollIntoView({behavior: 'smooth'});
        }
    });
});
</script> 