<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Editar Puerto #<?php echo $puerto['numero_puerto']; ?> (Caja NAP #<?php echo $puerto['id_caja']; ?>)</h2>
    <form action="<?php echo URL_ROOT; ?>/puertos/editar/<?php echo $puerto['id_puerto']; ?>" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado *</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="">Seleccione...</option>
                <option value="disponible" <?php echo ($puerto['estado'] == 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                <option value="ocupado" <?php echo ($puerto['estado'] == 'ocupado') ? 'selected' : ''; ?>>Ocupado</option>
                <option value="defectuoso" <?php echo ($puerto['estado'] == 'defectuoso') ? 'selected' : ''; ?>>Defectuoso</option>
            </select>
            <div class="invalid-feedback">Seleccione un estado.</div>
        </div>
        <div class="mb-3">
            <label for="cliente_usuario_id" class="form-label">ID Cliente (opcional)</label>
            <input type="number" class="form-control" id="cliente_usuario_id" name="cliente_usuario_id" value="<?php echo $puerto['cliente_usuario_id']; ?>">
        </div>
        <div class="mb-3">
            <label for="splitter_tipo" class="form-label">Tipo de Splitter</label>
            <select class="form-select" id="splitter_tipo" name="splitter_tipo">
                <option value="">-</option>
                <option value="balanceado" <?php echo ($puerto['splitter_tipo'] == 'balanceado') ? 'selected' : ''; ?>>Balanceado</option>
                <option value="desbalanceado" <?php echo ($puerto['splitter_tipo'] == 'desbalanceado') ? 'selected' : ''; ?>>Desbalanceado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="splitter_ratio" class="form-label">Ratio de Splitter</label>
            <select class="form-select" id="splitter_ratio" name="splitter_ratio">
                <option value="">-</option>
                <option value="1:2" <?php echo ($puerto['splitter_ratio'] == '1:2') ? 'selected' : ''; ?>>1:2</option>
                <option value="1:4" <?php echo ($puerto['splitter_ratio'] == '1:4') ? 'selected' : ''; ?>>1:4</option>
                <option value="1:8" <?php echo ($puerto['splitter_ratio'] == '1:8') ? 'selected' : ''; ?>>1:8</option>
                <option value="1:16" <?php echo ($puerto['splitter_ratio'] == '1:16') ? 'selected' : ''; ?>>1:16</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="splitter_atenuacion_db" class="form-label">Atenuación Splitter (dB)</label>
            <input type="number" step="0.01" class="form-control" id="splitter_atenuacion_db" name="splitter_atenuacion_db" value="<?php echo $puerto['splitter_atenuacion_db']; ?>">
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo URL_ROOT; ?>/puertos/index/<?php echo $puerto['id_caja']; ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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