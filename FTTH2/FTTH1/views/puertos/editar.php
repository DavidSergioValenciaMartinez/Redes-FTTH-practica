<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Editar Puerto #<?php echo $puerto['numero_puerto']; ?> (Caja NAP #<?php echo $puerto['id_caja']; ?>)</h2>
    <form action="<?php echo URL_ROOT; ?>/puertos/actualizar/<?php echo $puerto['id_puerto']; ?>" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id_caja" value="<?php echo $puerto['id_caja']; ?>">
        <input type="hidden" name="numero_puerto" value="<?php echo $puerto['numero_puerto']; ?>">
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
            <label for="cliente_usuario_id" class="form-label">Cliente asignado</label>
            <select class="form-select" id="cliente_usuario_id" name="cliente_usuario_id">
                <option value="">Sin cliente</option>
                <?php foreach($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_usuario']; ?>" <?php echo ($puerto['cliente_usuario_id'] == $cliente['id_usuario']) ? 'selected' : ''; ?>><?php echo $cliente['nombre_completo']; ?></option>
                <?php endforeach; ?>
            </select>
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
                <option value="1:32" <?php echo ($puerto['splitter_ratio'] == '1:32') ? 'selected' : ''; ?>>1:32</option>
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
    // Script para autollenar atenuación según el ratio
    const ratioSelect = document.getElementById('splitter_ratio');
    const atenuacionInput = document.getElementById('splitter_atenuacion_db');
    const atenuaciones = {
        '1:2': 3.6,
        '1:4': 7.2,
        '1:8': 11,
        '1:16': 14,
        '1:32': 17.5
    };
    ratioSelect.addEventListener('change', function() {
        const val = this.value;
        if (atenuaciones[val] !== undefined) {
            atenuacionInput.value = atenuaciones[val];
        } else {
            atenuacionInput.value = '';
        }
    });
});
</script>
<?php require_once 'views/layouts/footer.php'; ?> 