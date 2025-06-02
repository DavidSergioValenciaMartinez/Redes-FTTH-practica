<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Registrar Puerto</h2>
    <form action="<?php echo URL_ROOT; ?>/puertos/guardar" method="POST">
        <div class="mb-3">
            <label for="id_caja" class="form-label">Caja NAP</label>
            <select class="form-select" id="id_caja" name="id_caja" required>
                <option value="">Seleccione una caja</option>
                <?php foreach($cajas as $caja): ?>
                    <option value="<?php echo $caja['id_caja']; ?>"><?php echo $caja['codigo_caja']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="numero_puerto" class="form-label">Número de Puerto</label>
            <input type="number" class="form-control" id="numero_puerto" name="numero_puerto" min="1" max="16" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="disponible">Disponible</option>
                <option value="ocupado">Ocupado</option>
                <option value="defectuoso">Defectuoso</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cliente_usuario_id" class="form-label">Cliente asignado</label>
            <select class="form-select" id="cliente_usuario_id" name="cliente_usuario_id">
                <option value="">Sin cliente</option>
                <?php foreach($clientes as $cliente): ?>
                    <option value="<?php echo $cliente['id_usuario']; ?>"><?php echo $cliente['nombre_completo']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="splitter_tipo" class="form-label">Tipo de Splitter</label>
            <select class="form-select" id="splitter_tipo" name="splitter_tipo">
                <option value="">Seleccione</option>
                <option value="balanceado">Balanceado</option>
                <option value="desbalanceado">Desbalanceado</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="splitter_ratio" class="form-label">Proporción de Splitter</label>
            <select class="form-select" id="splitter_ratio" name="splitter_ratio" required>
                <option value="">Seleccione</option>
                <option value="1:2">1:2</option>
                <option value="1:4">1:4</option>
                <option value="1:8">1:8</option>
                <option value="1:16">1:16</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="splitter_atenuacion_db" class="form-label">Atenuación del Splitter (dB)</label>
            <input type="number" step="0.01" class="form-control" id="splitter_atenuacion_db" name="splitter_atenuacion_db" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratioSelect = document.getElementById('splitter_ratio');
    const atenuacionInput = document.getElementById('splitter_atenuacion_db');
    const atenuaciones = {
        '1:2': 3.6,
        '1:4': 7.2,
        '1:8': 11,
        '1:16': 14
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