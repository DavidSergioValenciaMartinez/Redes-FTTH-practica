    </div><!-- Cierre de main-content -->
    <!-- Footer -->
    <footer class="footer bg-dark">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">SOLUFIBER S.R.L.</h5>
                    <p class="text-light">Soluciones profesionales para la gestión y monitoreo de redes de fibra óptica FTTH con tecnología de vanguardia.</p>
                    <div class="d-flex mt-3">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/inicio" class="text-light">Inicio</a></li>
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/catalogo" class="text-light">Catálogo</a></li>
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/consulta" class="text-light">Consulta</a></li>
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/soporte" class="text-light">Soporte</a></li>
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/empresa" class="text-light">Empresa</a></li>
                        <li class="mb-2"><a href="<?php echo URL_ROOT; ?>/noticias" class="text-light">Noticias</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="text-white mb-3">Contacto</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light"><i class="fas fa-map-marker-alt me-2"></i>Cochabamba – Bolivia</li>
                        <li class="mb-2 text-light"><i class="fas fa-phone me-2"></i>Cel. 72271213 - 76786085</li>
                        <li class="mb-2 text-light"><i class="fas fa-envelope me-2"></i>mmiranda@solufibersrl.com</li>
                        <li class="mb-2 text-light"><i class="fas fa-envelope me-2"></i>solufiber@gmail.com</li>
                        <li class="mb-2 text-light"><i class="fas fa-globe me-2"></i>www.solufibersrl.com</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5 class="text-white mb-3">Soporte Técnico</h5>
                    <p class="text-light">¿Necesitas ayuda? Nuestro equipo está disponible 24/7.</p>
                    <a href="<?php echo URL_ROOT; ?>/soporte" class="btn btn-outline-light">Contactar Soporte</a>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="row">
                <div class="col-md-6">
                    <p class="text-light mb-0">&copy; 2023 Solufiber SLR. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3">Términos de Servicio</a>
                    <a href="#" class="text-light me-3">Política de Privacidad</a>
                    <a href="#" class="text-light">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modales para login y registro -->
    <?php if (!isset($_SESSION['user_id'])): ?>
        <!-- Modales eliminados para usar las páginas de autenticación directamente -->
    <?php endif; ?>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts personalizados -->
    <script src="<?php echo URL_ROOT; ?>/public/js/main.js"></script>
</body>
</html> 