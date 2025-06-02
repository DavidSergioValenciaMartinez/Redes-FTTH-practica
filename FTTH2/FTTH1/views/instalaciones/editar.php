<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Editar Instalación</h2>
    <form action="<?php echo URL_ROOT; ?>/instalaciones/editar/<?php echo $data['instalacion']['id_instalacion']; ?>" method="POST" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="id_tecnico" class="form-label">Técnico *</label>
            <select class="form-select" id="id_tecnico" name="id_tecnico" required>
                <option value="">Seleccione un técnico...</option>
                <?php
                // Obtener lista de técnicos
                $db = new Database();
                $stmt = $db->connect()->prepare("SELECT t.id_tecnico, u.nombre_completo FROM tbl_tecnicos t JOIN tbl_usuarios u ON t.id_usuario = u.id_usuario ORDER BY u.nombre_completo");
                $stmt->execute();
                $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach($tecnicos as $tecnico): ?>
                    <option value="<?php echo $tecnico['id_tecnico']; ?>" <?php if($tecnico['id_tecnico'] == $data['instalacion']['id_tecnico']) echo 'selected'; ?>><?php echo htmlspecialchars($tecnico['nombre_completo']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">Seleccione el técnico responsable.</div>
        </div>
        <div class="mb-3">
            <label for="tipo_instalacion" class="form-label">Tipo de Instalación *</label>
            <select class="form-select" id="tipo_instalacion" name="tipo_instalacion" required>
                <option value="">Seleccione...</option>
                <option value="nueva" <?php if($data['instalacion']['tipo_instalacion'] == 'nueva') echo 'selected'; ?>>Nueva</option>
                <option value="mantenimiento" <?php if($data['instalacion']['tipo_instalacion'] == 'mantenimiento') echo 'selected'; ?>>Mantenimiento</option>
                <option value="reparacion" <?php if($data['instalacion']['tipo_instalacion'] == 'reparacion') echo 'selected'; ?>>Reparación</option>
            </select>
            <div class="invalid-feedback">Seleccione el tipo de instalación.</div>
        </div>
        <div class="mb-3">
            <label for="fecha_instalacion" class="form-label">Fecha de Instalación *</label>
            <input type="datetime-local" class="form-control" id="fecha_instalacion" name="fecha_instalacion" required value="<?php echo date('Y-m-d\TH:i', strtotime($data['instalacion']['fecha_instalacion'])); ?>">
            <div class="invalid-feedback">Ingrese la fecha de la instalación.</div>
        </div>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="3"><?php echo htmlspecialchars($data['instalacion']['observaciones'] ?? ''); ?></textarea>
        </div>
        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo URL_ROOT; ?>/instalaciones" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar Cambios</button>
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