<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">
        <?php if (isset($data['caja'])): ?>
            Hoja Técnica - Caja NAP #<?php echo $data['caja']['id_caja']; ?>
        <?php else: ?>
            Nueva Hoja Técnica
        <?php endif; ?>
    </h2>
    
    <form action="<?php echo URL_ROOT; ?>/hoja_tecnica/crear<?php echo isset($data['caja']) ? '/' . $data['caja']['id_caja'] : ''; ?>" method="POST" class="needs-validation" novalidate>
        <?php if (isset($data['caja'])): ?>
            <input type="hidden" name="id_caja" value="<?php echo $data['caja']['id_caja']; ?>">
        <?php endif; ?>

        <!-- Información General -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información General</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_tecnico" class="form-label">Técnico Responsable *</label>
                        <select class="form-select" id="id_tecnico" name="id_tecnico" required>
                            <option value="">Seleccione un técnico...</option>
                            <?php foreach($data['tecnicos'] as $tecnico): ?>
                                <option value="<?php echo $tecnico->id_usuario; ?>">
                                    <?php echo htmlspecialchars($tecnico->nombre_completo); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un técnico.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cliente_usuario_id" class="form-label">Cliente (opcional)</label>
                        <select class="form-select" id="cliente_usuario_id" name="cliente_usuario_id">
                            <option value="">Sin cliente</option>
                            <?php foreach($data['clientes'] as $cliente): ?>
                                <option value="<?php echo $cliente->id_usuario; ?>">
                                    <?php echo htmlspecialchars($cliente->nombre_completo); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_trabajo" class="form-label">Tipo de Trabajo *</label>
                        <select class="form-select" id="tipo_trabajo" name="tipo_trabajo" required>
                            <option value="">Seleccione...</option>
                            <option value="instalacion">Instalación</option>
                            <option value="mantenimiento">Mantenimiento</option>
                            <option value="reemplazo">Reemplazo</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un tipo de trabajo.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado *</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="">Seleccione...</option>
                            <option value="activa">Activa</option>
                            <option value="inactiva">Inactiva</option>
                            <option value="mantenimiento">En Mantenimiento</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione un estado.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de la Caja -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Información de la Caja</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fabricante" class="form-label">Fabricante *</label>
                        <input type="text" class="form-control" id="fabricante" name="fabricante" 
                               value="<?php echo htmlspecialchars($data['caja']['fabricante'] ?? ''); ?>" required>
                        <div class="invalid-feedback">Por favor ingrese el fabricante.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="modelo" class="form-label">Modelo *</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" 
                               value="<?php echo htmlspecialchars($data['caja']['modelo'] ?? ''); ?>" required>
                        <div class="invalid-feedback">Por favor ingrese el modelo.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numero_serie" class="form-label">Número de Serie *</label>
                        <input type="text" class="form-control" id="numero_serie" name="numero_serie" required>
                        <div class="invalid-feedback">Por favor ingrese el número de serie.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="codigo_caja" class="form-label">Código de Caja *</label>
                        <input type="text" class="form-control" id="codigo_caja" name="codigo_caja" 
                               value="<?php echo htmlspecialchars($data['caja']['codigo_caja'] ?? ''); ?>" required readonly>
                        <div class="invalid-feedback">Por favor ingrese el código de caja.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ubicacion" class="form-label">Ubicación *</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                               value="<?php echo htmlspecialchars($data['caja']['ubicacion'] ?? ''); ?>" required>
                        <div class="invalid-feedback">Por favor ingrese la ubicación.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="capacidad" class="form-label">Capacidad *</label>
                        <input type="text" class="form-control" id="capacidad" name="capacidad" 
                               value="<?php echo htmlspecialchars($data['caja']['capacidad'] ?? ''); ?>" required>
                        <div class="invalid-feedback">Por favor ingrese la capacidad.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="total_puertos" class="form-label">Total Puertos *</label>
                        <input type="number" class="form-control" id="total_puertos" name="total_puertos" 
                               value="<?php echo htmlspecialchars($data['caja']['total_puertos'] ?? ''); ?>" required readonly>
                        <div class="invalid-feedback">Por favor ingrese el total de puertos.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="puertos_disponibles" class="form-label">Puertos Disponibles *</label>
                        <input type="number" class="form-control" id="puertos_disponibles" name="puertos_disponibles" 
                               value="<?php echo htmlspecialchars($data['caja']['puertos_disponibles'] ?? ''); ?>" required readonly>
                        <div class="invalid-feedback">Por favor ingrese los puertos disponibles.</div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="puertos_ocupados" class="form-label">Puertos Ocupados *</label>
                        <input type="number" class="form-control" id="puertos_ocupados" name="puertos_ocupados" 
                               value="<?php echo htmlspecialchars($data['caja']['puertos_ocupados'] ?? ''); ?>" required readonly>
                        <div class="invalid-feedback">Por favor ingrese los puertos ocupados.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="potencia_dbm" class="form-label">Potencia (dBm) *</label>
                        <input type="number" step="0.01" class="form-control" id="potencia_dbm" name="potencia_dbm" 
                               value="<?php echo htmlspecialchars($data['caja']['potencia_dbm'] ?? ''); ?>" required>
                        <div class="invalid-feedback">Por favor ingrese la potencia en dBm.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Especificaciones Técnicas -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Especificaciones Técnicas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_caja" class="form-label">Tipo de Caja *</label>
                        <select class="form-select" id="tipo_caja" name="tipo_caja" required>
                            <option value="">Seleccione...</option>
                            <option value="NAP">NAP</option>
                            <option value="SPLITTER">SPLITTER</option>
                            <option value="DISTRIBUCION">DISTRIBUCIÓN</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione el tipo de caja.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_conector" class="form-label">Tipo de Conector *</label>
                        <select class="form-select" id="tipo_conector" name="tipo_conector" required>
                            <option value="">Seleccione...</option>
                            <option value="SC/APC">SC/APC</option>
                            <option value="SC/UPC">SC/UPC</option>
                            <option value="FC/APC">FC/APC</option>
                            <option value="FC/UPC">FC/UPC</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione el tipo de conector.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dimensiones" class="form-label">Dimensiones (mm) *</label>
                        <input type="text" class="form-control" id="dimensiones" name="dimensiones" 
                               placeholder="ej: 200x150x100" required>
                        <div class="invalid-feedback">Por favor ingrese las dimensiones.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="material" class="form-label">Material *</label>
                        <select class="form-select" id="material" name="material" required>
                            <option value="">Seleccione...</option>
                            <option value="PLASTICO">PLÁSTICO</option>
                            <option value="METAL">METAL</option>
                            <option value="COMPUESTO">COMPUESTO</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione el material.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="grado_proteccion" class="form-label">Grado de Protección (IP) *</label>
                        <select class="form-select" id="grado_proteccion" name="grado_proteccion" required>
                            <option value="">Seleccione...</option>
                            <option value="IP54">IP54</option>
                            <option value="IP55">IP55</option>
                            <option value="IP65">IP65</option>
                            <option value="IP66">IP66</option>
                            <option value="IP67">IP67</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione el grado de protección.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="codigo_qr" class="form-label">Tipo de Código Identificador</label>
                        <select class="form-select" id="codigo_qr" name="codigo_qr">
                            <option value="QR">QR</option>
                            <option value="barra">Código de Barras</option>
                        </select>
                        <div class="invalid-feedback">Por favor seleccione el tipo de código.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="descripcion_equipo" class="form-label">Descripción del Equipo</label>
                        <textarea class="form-control" id="descripcion_equipo" name="descripcion_equipo" rows="3"></textarea>
                        <div class="invalid-feedback">Por favor ingrese la descripción del equipo.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Observaciones</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="observaciones" class="form-label">Observaciones Generales</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="4" 
                              placeholder="Ingrese cualquier observación relevante sobre la instalación o el equipo"></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo URL_ROOT; ?>/hoja_tecnica" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Hoja Técnica</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Validación de puertos
    const totalPuertos = document.getElementById('total_puertos');
    const puertosDisponibles = document.getElementById('puertos_disponibles');
    const puertosOcupados = document.getElementById('puertos_ocupados');

    function validarPuertos() {
        const total = parseInt(totalPuertos.value) || 0;
        const disponibles = parseInt(puertosDisponibles.value) || 0;
        const ocupados = parseInt(puertosOcupados.value) || 0;

        if (disponibles + ocupados > total) {
            puertosOcupados.setCustomValidity('La suma de puertos disponibles y ocupados no puede exceder el total');
        } else {
            puertosOcupados.setCustomValidity('');
        }
    }

    totalPuertos.addEventListener('change', validarPuertos);
    puertosDisponibles.addEventListener('change', validarPuertos);
    puertosOcupados.addEventListener('change', validarPuertos);

    // Manejar el cambio de caja en el select si está presente
    var codigoCajaSelect = document.getElementById('codigo_caja');
    var idCajaHidden = document.getElementById('id_caja_hidden_select');

    if (codigoCajaSelect && idCajaHidden) {
        codigoCajaSelect.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var idCaja = selectedOption.getAttribute('data-id');
            idCajaHidden.value = idCaja; // Actualizar el campo oculto

            // Opcional: Si quieres prellenar otros campos al cambiar la caja en el selector
            // Esto requeriría una llamada AJAX adicional o tener todos los datos de las cajas en el cliente
            // Por ahora, confiamos en que el controlador carga los datos correctos al cargar la página de creación.

        });
         // Trigger change on load if an option is selected by default (not the empty one)
         // Esto es útil si se recarga la página con una caja preseleccionada.
         if(codigoCajaSelect.value !== ""){
             codigoCajaSelect.dispatchEvent(new Event('change'));
         }
    } else if (document.querySelector('input[name="id_caja"][type="hidden"]')){
        // If id_caja is a hidden input (meaning a box was selected)
        // No need to do anything with the select, as the ID is already in a hidden field
    }

});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 