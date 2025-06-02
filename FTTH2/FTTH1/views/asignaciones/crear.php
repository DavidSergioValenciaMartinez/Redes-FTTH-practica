<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <h2>Nueva Asignación</h2>
    <form action="<?php echo URL_ROOT; ?>/asignaciones/crear" method="POST">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">Cliente</label>
            <select class="form-select" id="id_cliente" name="id_cliente" required>
                <option value="">Seleccione un cliente...</option>
                <?php if (isset($data['clientes']) && is_array($data['clientes'])): ?>
                    <?php foreach($data['clientes'] as $cliente): ?>
                        <option value="<?php echo $cliente['id_cliente']; ?>">
                            <?php echo htmlspecialchars($cliente['id_cliente']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="fecha_asignacion" class="form-label">Fecha de Asignación</label>
            <input type="datetime-local" class="form-control" id="fecha_asignacion" name="fecha_asignacion" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente">Pendiente</option>
                <option value="activo">Activo</option>
                <option value="finalizado">Finalizado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="<?php echo URL_ROOT; ?>/asignaciones" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 