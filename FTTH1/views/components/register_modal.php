<!-- Modal Registro -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- Register Section -->
                <section id="registerSection" class="app-section py-5">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="login-form">
                                    <div class="text-center mb-4">
                                        <i class="bi bi-broadcast-pin" style="font-size: 3rem; color: var(--primary-color);"></i>
                                        <h2 class="mt-2 mb-4">FIBERTEC</h2>
                                        <p class="text-muted">Registro de Clientes</p>
                                    </div>
                                    
                                    <form id="registerForm" action="<?php echo URL_ROOT; ?>/register" method="POST">
                                        <div class="mb-3">
                                            <label for="registerName" class="form-label">Nombre Completo</label>
                                            <input type="text" class="form-control" id="registerName" name="registerName" placeholder="Ingrese su nombre completo" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="registerEmail" class="form-label">Correo Electrónico</label>
                                            <input type="email" class="form-control" id="registerEmail" name="registerEmail" placeholder="nombre@ejemplo.com" required>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="registerPassword" class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" id="registerPassword" name="registerPassword" placeholder="********" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="registerPasswordConfirm" class="form-label">Confirmar Contraseña</label>
                                                <input type="password" class="form-control" id="registerPasswordConfirm" name="registerPasswordConfirm" placeholder="********" required>
                                            </div>
                                        </div>
                                        
                                        <!-- Campo oculto para designar como cliente -->
                                        <input type="hidden" name="registerRole" value="client">
                                        
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="termsCheck" name="termsCheck" required>
                                            <label class="form-check-label" for="termsCheck">Acepto los <a href="#">términos y condiciones</a></label>
                                        </div>
                                        
                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Registrarse</button>
                                        </div>
                                        
                                        <hr class="my-4">
                                        
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-dark">
                                                <i class="bi bi-google me-2"></i>Registrarse con Google
                                            </button>
                                            <button type="button" class="btn btn-outline-primary">
                                                <i class="bi bi-facebook me-2"></i>Registrarse con Facebook
                                            </button>
                                        </div>
                                        
                                        <div class="text-center mt-3">
                                            <p>¿Ya tienes una cuenta? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Inicia sesión</a></p>
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