<!-- Vista de Login -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <img id="logo-solufiber-login" src="<?php echo URL_ROOT; ?>/public/img/Solufiber-01.png" alt="Logo Solufiber" style="height:64px; width:auto;">
                        <p class="text-muted">Sistema para Redes de Fibra Óptica FTTH</p>
                    </div>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['mensaje'])): ?>
                        <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
                    <?php endif; ?>

                    <form action="<?php echo URL_ROOT; ?>/login" method="POST">
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="nombre@ejemplo.com" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="********" required>
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
                        <div class="text-center mt-3">
                            <p>¿No tienes una cuenta? <a href="<?php echo URL_ROOT; ?>/register">Regístrate</a></p>
                            <a href="<?php echo URL_ROOT; ?>/forgot" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateLogoLogin() {
        var logo = document.getElementById('logo-solufiber-login');
        if (document.body.classList.contains('alt-style')) {
            logo.src = '<?php echo URL_ROOT; ?>/public/img/Solufiber-03.1-03.png';
        } else {
            logo.src = '<?php echo URL_ROOT; ?>/public/img/Solufiber-01.png';
        }
    }
    updateLogoLogin();
    var toggle = document.getElementById('toggleStyle');
    if (toggle) {
        toggle.addEventListener('click', function() {
            setTimeout(updateLogoLogin, 100);
        });
    }
});
</script> 