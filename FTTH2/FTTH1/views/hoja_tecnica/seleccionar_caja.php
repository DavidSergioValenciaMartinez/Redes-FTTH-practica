<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Seleccionar Caja NAP</h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo URL_ROOT; ?>/hoja_tecnica/crear" method="POST" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="id_caja" class="form-label">Seleccione la Caja NAP *</label>
                            <select class="form-select" id="id_caja" name="id_caja" required>
                                <option value="">Seleccione una caja...</option>
                                <?php foreach ($data['cajas'] as $caja): ?>
                                    <option value="<?php echo $caja['id_caja']; ?>">
                                        <?php echo $caja['codigo_caja']; ?> - 
                                        <?php echo $caja['ubicacion']; ?> 
                                        (Puertos: <?php echo $caja['puertos_disponibles']; ?>/<?php echo $caja['total_puertos']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una caja NAP
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo URL_ROOT; ?>/hoja_tecnica" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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