<!-- Contenido principal - Sección Noticias -->
<main>
    <div class="container mt-5">
        <h2 class="text-center mb-5">Noticias y Novedades</h2>
        
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Buscar noticias..." id="buscarNoticias">
                    <button class="btn btn-primary" type="button" id="btnBuscarNoticias">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-4">
                <select class="form-select" id="filtroCategoria">
                    <option value="todos" selected>Todas las categorías</option>
                    <option value="tecnologia">Tecnología</option>
                    <option value="empresa">Empresa</option>
                    <option value="eventos">Eventos</option>
                    <option value="productos">Productos</option>
                </select>
            </div>
        </div>
        
        <!-- Noticia destacada -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card bg-dark text-white shadow-sm">
                    <img src="https://via.placeholder.com/1200x400?text=Nueva+Tecnología+FTTH" class="card-img" alt="Noticia destacada">
                    <div class="card-img-overlay d-flex flex-column justify-content-end" style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0.1));">
                        <span class="badge bg-primary mb-2">Tecnología</span>
                        <h3 class="card-title">Lanzamos nueva tecnología FTTH con velocidades de hasta 10 Gbps</h3>
                        <p class="card-text">Nuestra empresa ha implementado la última tecnología XGS-PON, permitiendo velocidades simétricas de hasta 10 Gbps para hogares y empresas.</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small>15 de Mayo, 2023</small>
                            <a href="#" class="btn btn-sm btn-outline-light">Leer más</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Lista de noticias -->
        <div class="row g-4">
            <!-- Noticia 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Evento+FTTH" class="card-img-top" alt="Evento FTTH">
                    <div class="card-body">
                        <span class="badge bg-primary mb-2">Eventos</span>
                        <h5 class="card-title">Participamos en la Feria Internacional de Telecomunicaciones</h5>
                        <p class="card-text">Nuestra empresa presentó las últimas soluciones en tecnología FTTH durante la feria internacional celebrada en Madrid.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">3 de Abril, 2023</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Noticia 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Alianza+Estratégica" class="card-img-top" alt="Alianza Estratégica">
                    <div class="card-body">
                        <span class="badge bg-success mb-2">Empresa</span>
                        <h5 class="card-title">Nueva alianza estratégica con proveedor líder en soluciones de red</h5>
                        <p class="card-text">Hemos firmado un acuerdo de colaboración con uno de los principales fabricantes mundiales de equipamiento para redes FTTH.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">18 de Marzo, 2023</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Noticia 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Nuevo+OLT" class="card-img-top" alt="Nuevo OLT">
                    <div class="card-body">
                        <span class="badge bg-info mb-2">Productos</span>
                        <h5 class="card-title">Presentamos nuestro nuevo modelo de OLT de alta capacidad</h5>
                        <p class="card-text">El nuevo equipo OLT-8000XG permite gestionar hasta 8,000 ONUs simultáneamente con un consumo energético reducido.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">25 de Febrero, 2023</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Noticia 4 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Digitalización" class="card-img-top" alt="Digitalización">
                    <div class="card-body">
                        <span class="badge bg-secondary mb-2">Tecnología</span>
                        <h5 class="card-title">La digitalización impulsa la demanda de redes FTTH en el sector empresarial</h5>
                        <p class="card-text">El crecimiento de la transformación digital en las empresas ha incrementado la demanda de infraestructuras de fibra óptica de alta capacidad.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">10 de Febrero, 2023</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Noticia 5 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Certificación" class="card-img-top" alt="Certificación">
                    <div class="card-body">
                        <span class="badge bg-success mb-2">Empresa</span>
                        <h5 class="card-title">Obtenemos la certificación ISO 9001 en gestión de calidad</h5>
                        <p class="card-text">Nuestra empresa ha sido reconocida con la certificación ISO 9001, validando nuestros procesos de gestión de calidad en el diseño e implementación de redes FTTH.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">5 de Enero, 2023</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
            
            <!-- Noticia 6 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Formación" class="card-img-top" alt="Formación">
                    <div class="card-body">
                        <span class="badge bg-warning mb-2">Eventos</span>
                        <h5 class="card-title">Lanzamos programa de formación en instalación de redes FTTH</h5>
                        <p class="card-text">Iniciamos un programa de capacitación para técnicos en el despliegue y mantenimiento de redes de fibra óptica hasta el hogar.</p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                        <small class="text-muted">15 de Diciembre, 2022</small>
                        <a href="#" class="btn btn-sm btn-outline-primary">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Paginación -->
        <div class="row mt-5">
            <div class="col-12">
                <nav aria-label="Paginación noticias">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <!-- Suscripción al boletín -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card bg-light shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h4 class="mb-3">Suscríbete a nuestro boletín</h4>
                        <p class="mb-4">Recibe nuestras últimas noticias y promociones directamente en tu correo electrónico.</p>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <form id="formSuscripcion" class="d-flex gap-2">
                                    <input type="email" class="form-control" id="emailSuscripcion" placeholder="Tu email" required>
                                    <button type="submit" class="btn btn-primary">Suscribirse</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 