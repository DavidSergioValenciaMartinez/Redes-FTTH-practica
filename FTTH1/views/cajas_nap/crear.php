<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear Caja NAP</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo URL_ROOT; ?>/cajas_nap/guardar" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo_caja">Código de Caja *</label>
                                    <input type="text" class="form-control" id="codigo_caja" name="codigo_caja" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el código de la caja
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación *</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese la ubicación
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_departamento">Departamento *</label>
                                    <select class="form-control" id="id_departamento" name="id_departamento" required>
                                        <option value="">Seleccione un departamento...</option>
                                        <?php foreach ($data['departamentos'] as $departamento): ?>
                                            <option value="<?php echo $departamento['id_departamento']; ?>">
                                                <?php echo $departamento['nombre_departamento']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un departamento
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado *</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_puertos">Total de Puertos *</label>
                                    <input type="number" class="form-control" id="total_puertos" name="total_puertos" 
                                           min="1" max="16" required>
                                    <div class="invalid-feedback">
                                        El número de puertos debe estar entre 1 y 16
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="potencia_dbm">Potencia (dBm)</label>
                                    <input type="number" class="form-control" id="potencia_dbm" name="potencia_dbm" 
                                           step="0.01">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="capacidad">Capacidad</label>
                                    <input type="text" class="form-control" id="capacidad" name="capacidad">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fabricante">Fabricante</label>
                                    <input type="text" class="form-control" id="fabricante" name="fabricante">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

    // Cargar distritos cuando se selecciona un departamento
    document.getElementById('id_departamento').addEventListener('change', function() {
        var idDepartamento = this.value;
        var distritoSelect = document.getElementById('id_distrito');
        
        // Limpiar opciones actuales
        distritoSelect.innerHTML = '<option value="">Seleccione un distrito...</option>';
        
        if (idDepartamento) {
            // Hacer la petición AJAX
            fetch('<?php echo URL_ROOT; ?>/cajas_nap/getDistritos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'id_departamento=' + idDepartamento
            })
            .then(response => response.json())
            .then(data => {
                data.forEach(function(distrito) {
                    var option = document.createElement('option');
                    option.value = distrito.id_distrito;
                    option.textContent = distrito.nombre_distrito;
                    distritoSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
        }
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 