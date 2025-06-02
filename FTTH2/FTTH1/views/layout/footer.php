    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <!-- Footer para PC (estático) - Se oculta en móviles -->
            <div class="d-none d-md-block">
                <div class="row">
                    <div class="col-md-3 mb-4 mb-md-0">
                        <div class="text-center mb-3">
                            <img src="<?php echo URL_ROOT; ?>/public/img/logo.png" alt="Logo Solufiber" height="60" class="mb-2">
                            <h5 class="mb-0">SOLUFIBER S.R.L.</h5>
                        </div>
                        <p class="text-center text-muted small">Soluciones integrales para redes FTTH</p>
                        <div class="text-center mt-3">
                            <span class="badge bg-success mb-1 d-block">Proveedores Certificados</span>
                            <span class="badge bg-primary d-block">Servicio 24/7</span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <h5 class="border-bottom pb-2 mb-3">Contacto</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i> Av. Principal #123<br>
                                <span class="ms-4 small">Santa Cruz, Bolivia</span>
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-phone me-2 text-primary"></i> (591) 3-456-7890
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-mobile-alt me-2 text-primary"></i> (591) 70012345
                            </li>
                            <li>
                                <i class="fas fa-envelope me-2 text-primary"></i> info@solufiber.com
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3 mb-4 mb-md-0">
                        <h5 class="border-bottom pb-2 mb-3">Enlaces Rápidos</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <a href="<?php echo URL_ROOT; ?>/inicio" class="text-light text-decoration-none">
                                    <i class="fas fa-angle-right me-2 text-primary"></i>Inicio
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?php echo URL_ROOT; ?>/catalogo" class="text-light text-decoration-none">
                                    <i class="fas fa-angle-right me-2 text-primary"></i>Catálogo de Productos
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?php echo URL_ROOT; ?>/consulta" class="text-light text-decoration-none">
                                    <i class="fas fa-angle-right me-2 text-primary"></i>Consultas
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="<?php echo URL_ROOT; ?>/soporte" class="text-light text-decoration-none">
                                    <i class="fas fa-angle-right me-2 text-primary"></i>Soporte Técnico
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo URL_ROOT; ?>/empresa" class="text-light text-decoration-none">
                                    <i class="fas fa-angle-right me-2 text-primary"></i>Nuestra Empresa
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <h5 class="border-bottom pb-2 mb-3">Horario de Atención</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="far fa-clock me-2 text-primary"></i> Lunes a Viernes
                                <div class="ms-4 small">8:00 - 18:00</div>
                            </li>
                            <li class="mb-2">
                                <i class="far fa-clock me-2 text-primary"></i> Sábados
                                <div class="ms-4 small">9:00 - 13:00</div>
                            </li>
                            <li class="mb-3">
                                <i class="fas fa-exclamation-circle me-2 text-warning"></i> Emergencias
                                <div class="ms-4 small text-warning">Servicio 24/7</div>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-between mt-4 social-icons">
                            <a href="#" class="text-light fs-5"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="text-light fs-5"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-light fs-5"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="text-light fs-5"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="text-light fs-5"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer para móviles (dinámico) - Se muestra solo en móviles -->
            <div class="d-md-none">
                <div class="text-center mb-4">
                    <img src="<?php echo URL_ROOT; ?>/public/img/logo.png" alt="Logo Solufiber" height="50" class="mb-2">
                    <h5 class="mb-0">SOLUFIBER S.R.L.</h5>
                    <p class="text-muted small">Soluciones integrales para redes FTTH</p>
                </div>
                
                <!-- Acordeón para información en móviles -->
                <div class="accordion" id="footerAccordion">
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingContact">
                            <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContact" aria-expanded="false" aria-controls="collapseContact">
                                <i class="fas fa-address-card me-2"></i> Contacto
                            </button>
                        </h2>
                        <div id="collapseContact" class="accordion-collapse collapse" aria-labelledby="headingContact" data-bs-parent="#footerAccordion">
                            <div class="accordion-body bg-dark">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-map-marker-alt me-2 text-primary"></i> Av. Principal #123, Santa Cruz
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-phone me-2 text-primary"></i> (591) 3-456-7890
                                    </li>
                                    <li>
                                        <i class="fas fa-envelope me-2 text-primary"></i> info@solufiber.com
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingLinks">
                            <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLinks" aria-expanded="false" aria-controls="collapseLinks">
                                <i class="fas fa-link me-2"></i> Enlaces Rápidos
                            </button>
                        </h2>
                        <div id="collapseLinks" class="accordion-collapse collapse" aria-labelledby="headingLinks" data-bs-parent="#footerAccordion">
                            <div class="accordion-body bg-dark">
                                <div class="row">
                                    <div class="col-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <a href="<?php echo URL_ROOT; ?>/inicio" class="text-light text-decoration-none">
                                                    <i class="fas fa-angle-right me-1 text-primary"></i>Inicio
                                                </a>
                                            </li>
                                            <li class="mb-2">
                                                <a href="<?php echo URL_ROOT; ?>/catalogo" class="text-light text-decoration-none">
                                                    <i class="fas fa-angle-right me-1 text-primary"></i>Catálogo
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <a href="<?php echo URL_ROOT; ?>/soporte" class="text-light text-decoration-none">
                                                    <i class="fas fa-angle-right me-1 text-primary"></i>Soporte
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo URL_ROOT; ?>/empresa" class="text-light text-decoration-none">
                                                    <i class="fas fa-angle-right me-1 text-primary"></i>Empresa
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item bg-transparent">
                        <h2 class="accordion-header" id="headingHours">
                            <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHours" aria-expanded="false" aria-controls="collapseHours">
                                <i class="far fa-clock me-2"></i> Horario de Atención
                            </button>
                        </h2>
                        <div id="collapseHours" class="accordion-collapse collapse" aria-labelledby="headingHours" data-bs-parent="#footerAccordion">
                            <div class="accordion-body bg-dark">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <i class="far fa-clock me-2 text-primary"></i> Lunes a Viernes: 8:00 - 18:00
                                    </li>
                                    <li class="mb-2">
                                        <i class="far fa-clock me-2 text-primary"></i> Sábados: 9:00 - 13:00
                                    </li>
                                    <li>
                                        <i class="fas fa-exclamation-circle me-2 text-warning"></i> Emergencias: Servicio 24/7
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Redes sociales para móviles -->
                <div class="mt-4 text-center">
                    <a href="#" class="text-light mx-2 fs-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-light mx-2 fs-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-light mx-2 fs-4"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-light mx-2 fs-4"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="text-light mx-2 fs-4"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <hr class="my-4 bg-secondary">
            
            <!-- Derechos de autor - Común para todas las resoluciones -->
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 small">
                        &copy; <?php echo date('Y'); ?> SOLUFIBER S.R.L. Todos los derechos reservados.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-light text-decoration-none small mx-2">Términos y Condiciones</a>
                    <a href="#" class="text-light text-decoration-none small mx-2">Política de Privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (requerido para algunas funcionalidades) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- JsBarcode para generar códigos de barras -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo URL_ROOT; ?>/public/js/main.js"></script>

    <!-- Script para JsBarcode alternativo (asegura la carga) -->
    <script>
    if (typeof JsBarcode === 'undefined') {
        // Si JsBarcode no se cargó, intentar cargarlo de nuevo
        const script = document.createElement('script');
        script.src = 'https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js';
        script.async = true;
        script.onload = function() {
            console.log('JsBarcode cargado correctamente de forma secundaria');
            // Disparar un evento para notificar que JsBarcode está disponible
            document.dispatchEvent(new Event('jsbarcode_loaded'));
        };
        document.body.appendChild(script);
    }
    </script>
    
    <!-- Incluir los modales para login y registro -->
    <?php include_once(VIEWS_PATH . '/components/login_modal.php'); ?>
    <?php include_once(VIEWS_PATH . '/components/register_modal.php'); ?>
</body>
</html> 