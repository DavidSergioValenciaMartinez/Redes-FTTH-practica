<!-- Contenido principal - Sección Consulta -->
<main>
    <div class="container mt-5">
        <h2 class="text-center mb-5">Consulta de Servicios</h2>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="consultaTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="estado-tab" data-bs-toggle="tab" data-bs-target="#estado" type="button" role="tab" aria-controls="estado" aria-selected="true">Estado de Servicio</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="ticket-tab" data-bs-toggle="tab" data-bs-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="false">Consultar Ticket</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="facturas-tab" data-bs-toggle="tab" data-bs-target="#facturas" type="button" role="tab" aria-controls="facturas" aria-selected="false">Facturas</button>
                            </li>
                        </ul>
                        <div class="tab-content p-3" id="consultaTabContent">
                            <div class="tab-pane fade show active" id="estado" role="tabpanel" aria-labelledby="estado-tab">
                                <form id="formEstadoServicio" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="numeroServicio" class="form-label">Número de Servicio o Cliente</label>
                                        <input type="text" class="form-control" id="numeroServicio" placeholder="Ingrese su número de cliente" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un número de servicio válido.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipoDocumento" class="form-label">Tipo de Documento</label>
                                        <select class="form-select" id="tipoDocumento" required>
                                            <option value="" selected disabled>Seleccione</option>
                                            <option value="dni">DNI</option>
                                            <option value="ruc">RUC</option>
                                            <option value="ce">Carnet de Extranjería</option>
                                            <option value="pasaporte">Pasaporte</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un tipo de documento.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numeroDocumento" class="form-label">Número de Documento</label>
                                        <input type="text" class="form-control" id="numeroDocumento" placeholder="Ingrese su número de documento" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un número de documento válido.
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="submit">Consultar Estado</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="ticket-tab">
                                <form id="formConsultaTicket" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="numeroTicket" class="form-label">Número de Ticket</label>
                                        <input type="text" class="form-control" id="numeroTicket" placeholder="Ej. TKT-12345678" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un número de ticket válido.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correoTicket" class="form-label">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="correoTicket" placeholder="ejemplo@correo.com" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un correo electrónico válido.
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="submit">Consultar Ticket</button>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="facturas" role="tabpanel" aria-labelledby="facturas-tab">
                                <form id="formFacturas" class="needs-validation" novalidate>
                                    <div class="mb-3">
                                        <label for="numeroServicioFactura" class="form-label">Número de Servicio o Cliente</label>
                                        <input type="text" class="form-control" id="numeroServicioFactura" placeholder="Ingrese su número de cliente" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un número de servicio válido.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tipoDocumentoFactura" class="form-label">Tipo de Documento</label>
                                        <select class="form-select" id="tipoDocumentoFactura" required>
                                            <option value="" selected disabled>Seleccione</option>
                                            <option value="dni">DNI</option>
                                            <option value="ruc">RUC</option>
                                            <option value="ce">Carnet de Extranjería</option>
                                            <option value="pasaporte">Pasaporte</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Por favor seleccione un tipo de documento.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="numeroDocumentoFactura" class="form-label">Número de Documento</label>
                                        <input type="text" class="form-control" id="numeroDocumentoFactura" placeholder="Ingrese su número de documento" required>
                                        <div class="invalid-feedback">
                                            Por favor ingrese un número de documento válido.
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary" type="submit">Consultar Facturas</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main> 