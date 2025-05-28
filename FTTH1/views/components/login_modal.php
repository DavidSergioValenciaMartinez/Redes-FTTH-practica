<!-- Modal Login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- Login Section -->
                <section id="loginSection" class="app-section py-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="login-form">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-broadcast-pin" style="font-size: 3rem; color: var(--primary-color);"></i>
                                        <h2 class="mt-2 mb-4">FIBERTEC</h2>
                                        <p class="text-muted">Sistema para Redes de Fibra Óptica FTTH</p>
                                    </div>
                                    <form id="loginForm" action="<?php echo URL_ROOT; ?>/login" method="POST">
                                        <div class="mb-3">
                                            <label for="loginEmail" class="form-label" id="emailLabel">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="loginEmail" name="loginEmail" placeholder="nombre@ejemplo.com" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="loginPassword" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="loginPassword" name="loginPassword" placeholder="********" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Usuario</label>
                                            <div class="d-flex flex-wrap">
                                                <div class="form-check me-3 mb-2">
                                                    <input class="form-check-input" type="radio" name="userRole" id="roleClient" value="client" checked>
                                                    <label class="form-check-label" for="roleClient">
                                                        Cliente
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 mb-2">
                                                    <input class="form-check-input" type="radio" name="userRole" id="roleTechnician" value="technician">
                                                    <label class="form-check-label" for="roleTechnician">
                                                        Técnico
                                                    </label>
                                                </div>
                                                <div class="form-check me-3 mb-2">
                                                    <input class="form-check-input" type="radio" name="userRole" id="roleOperator" value="operator">
                                                    <label class="form-check-label" for="roleOperator">
                                                        Operador
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="userRole" id="roleAdmin" value="admin">
                                                    <label class="form-check-label" for="roleAdmin">
                                                        Administrador
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Recordarme</label>
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                                        </div>
                                        <hr class="my-4">
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-dark">
                                                <i class="bi bi-google me-2"></i>Continuar con Google
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="bi bi-facebook me-2"></i>Continuar con Facebook
                                            </button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <p>¿No tienes una cuenta? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Regístrate</a></p>
                                            <a href="#" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<!-- Script para validar el dominio del correo según el rol -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Obtener elementos del formulario
    const roleInputs = document.querySelectorAll('#loginForm input[name="userRole"]');
    const emailInput = document.getElementById('loginEmail');
    
    // Función para validar el dominio del correo
    function validateEmailDomain() {
        const selectedRole = document.querySelector('#loginForm input[name="userRole"]:checked').value;
        const email = emailInput.value.trim();
        
        // Remover cualquier mensaje de error previo
        const oldError = document.getElementById('loginEmailDomainError');
        if (oldError) oldError.remove();
        
        // Si no hay email, no validar
        if (!email) return;
        
        let errorMessage = null;
        
        // Verificar roles de staff (técnico, operador, admin)
        if (['technician', 'operator', 'admin'].includes(selectedRole)) {
            if (email.indexOf('@solufiber-srl.com') === -1) {
                errorMessage = `Para ingresar como ${getRoleName(selectedRole)}, debe usar un correo con dominio @solufiber-srl.com`;
            }
        } 
        // Verificar rol cliente
        else if (selectedRole === 'client') {
            if (email.indexOf('@solufiber-srl.com') !== -1) {
                errorMessage = 'Las cuentas con dominio @solufiber-srl.com están reservadas para el personal de Solufiber';
            }
        }
        
        // Mostrar mensaje de error si existe
        if (errorMessage) {
            const errorDiv = document.createElement('div');
            errorDiv.id = 'loginEmailDomainError';
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
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        validateEmailDomain();
        
        // Si hay error de dominio, prevenir envío del formulario
        if (document.getElementById('loginEmailDomainError')) {
            e.preventDefault();
        }
    });
});
</script> 