<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Registrar Medición de Puerto</h2>
    <form action="<?php echo URL_ROOT; ?>/mediciones/crear" method="POST" class="needs-validation" novalidate>
        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">Datos de la Medición</h5></div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="id_puerto" class="form-label">Puerto *</label>
                        <select class="form-select" id="id_puerto" name="id_puerto" required>
                            <option value="">Seleccione un puerto...</option>
                            <?php foreach($data['puertos'] as $puerto): ?>
                                <option value="<?php echo $puerto['id_puerto']; ?>">
                                    <?php echo htmlspecialchars($puerto['codigo_caja']) . ' - Puerto ' . htmlspecialchars($puerto['numero_puerto']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Seleccione un puerto.</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="potencia_dbm" class="form-label">Potencia (dBm) *</label>
                        <input type="number" step="0.01" class="form-control" id="potencia_dbm" name="potencia_dbm" required>
                        <div class="invalid-feedback">Ingrese la potencia.</div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="atenuacion_db" class="form-label">Atenuación (dB) *</label>
                        <input type="number" step="0.01" class="form-control" id="atenuacion_db" name="atenuacion_db" required>
                        <div class="invalid-feedback">Ingrese la atenuación.</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="fuente" class="form-label">Fuente *</label>
                        <select class="form-select" id="fuente" name="fuente" required>
                            <option value="manual">Manual</option>
                            <option value="iot">IoT</option>
                        </select>
                        <div class="invalid-feedback">Seleccione la fuente.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo URL_ROOT; ?>/mediciones" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Medición</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>
<?php require_once 'views/layouts/footer.php'; ?> 