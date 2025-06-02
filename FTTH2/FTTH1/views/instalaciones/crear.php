<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Crear Instalación<?php if (!empty($data['id_caja'])): ?> para Caja NAP #<?php echo $data['id_caja']; ?><?php endif; ?></h2>
    <form action="<?php echo URL_ROOT; ?>/instalaciones/crear<?php echo !empty($data['id_caja']) ? '/' . $data['id_caja'] : ''; ?>" method="POST" class="needs-validation" novalidate>
        <?php if (empty($data['id_caja'])): ?>
        <div class="mb-3">
            <label for="id_caja" class="form-label">Caja NAP *</label>
            <select class="form-select" id="id_caja" name="id_caja" required>
                <option value="">Seleccione una caja...</option>
                <?php foreach ($data['cajas'] as $caja): ?>
                    <option value="<?php echo $caja['id_caja']; ?>"><?php echo $caja['codigo_caja']; ?> - <?php echo $caja['ubicacion']; ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Seleccione la caja NAP asociada.</div>
        </div>
        <?php else: ?>
        <input type="hidden" name="id_caja" value="<?php echo $data['id_caja']; ?>">
        <?php endif; ?>
        <div class="mb-3">
            <label for="id_tecnico" class="form-label">Técnico *</label>
            <select class="form-select" id="id_tecnico" name="id_tecnico" required>
                <option value="">Seleccione un técnico...</option>
                <?php if (!empty($data['tecnicos'])): foreach($data['tecnicos'] as $tecnico): ?>
                    <option value="<?php echo $tecnico['id_tecnico']; ?>"><?php echo htmlspecialchars($tecnico['nombre_completo']); ?></option>
                <?php endforeach; endif; ?>
            </select>
            <div class="invalid-feedback">Seleccione el técnico responsable.</div>
        </div>
        <div class="mb-3">
            <label for="tipo_instalacion" class="form-label">Tipo de Instalación *</label>
            <select class="form-select" id="tipo_instalacion" name="tipo_instalacion" required>
                <option value="">Seleccione...</option>
                <option value="nueva">Nueva</option>
                <option value="mantenimiento">Mantenimiento</option>
                <option value="reparacion">Reparación</option>
            </select>
            <div class="invalid-feedback">Seleccione el tipo de instalación.</div>
        </div>
        <div class="mb-3">
            <label for="fecha_instalacion" class="form-label">Fecha de Instalación *</label>
            <input type="datetime-local" class="form-control" id="fecha_instalacion" name="fecha_instalacion" required>
            <div class="invalid-feedback">Ingrese la fecha de la instalación.</div>
        </div>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo URL_ROOT; ?>/instalaciones<?php echo !empty($data['id_caja']) ? '/index/' . $data['id_caja'] : ''; ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
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