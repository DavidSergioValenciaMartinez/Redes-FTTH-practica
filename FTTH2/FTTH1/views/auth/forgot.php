<!-- Vista de Recuperación de Contraseña -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-key" style="font-size: 3.5rem; color: #0d6efd;"></i>
                        <h2 class="mt-2 mb-2 fw-bold">Recuperar Contraseña</h2>
                        <p class="text-muted">Ingrese su número de WhatsApp registrado y le enviaremos instrucciones para restablecer su contraseña.</p>
                    </div>
                    <?php if (isset($mensaje) && $mensaje): ?>
                        <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
                    <?php endif; ?>
                    <form action="<?php echo URL_ROOT; ?>/forgot" method="POST">
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número de WhatsApp</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-whatsapp"></i></span>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej: 59172271213" required>
                            </div>
                            <div class="form-text">Incluya el código de país. Ejemplo para Bolivia: 591XXXXXXXX</div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Enviar Instrucciones</button>
                        </div>
                        <div class="text-center mt-3">
                            <a href="<?php echo URL_ROOT; ?>/login">Volver al inicio de sesión</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 