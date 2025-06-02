<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <h2>Editar Asignación</h2>
    <form action="<?php echo URL_ROOT; ?>/asignaciones/editar?id=<?php echo $data['asignacion']['id_asignacion']; ?>" method="POST">
        <div class="mb-3">
            <label for="id_cliente" class="form-label">ID Cliente</label>
            <input type="number" class="form-control" id="id_cliente" name="id_cliente" value="<?php echo $data['asignacion']['id_cliente']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="fecha_asignacion" class="form-label">Fecha de Asignación</label>
            <input type="datetime-local" class="form-control" id="fecha_asignacion" name="fecha_asignacion" value="<?php echo date('Y-m-d\TH:i', strtotime($data['asignacion']['fecha_asignacion'])); ?>" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
                <option value="pendiente" <?php if($data['asignacion']['estado']=='pendiente') echo 'selected'; ?>>Pendiente</option>
                <option value="activo" <?php if($data['asignacion']['estado']=='activo') echo 'selected'; ?>>Activo</option>
                <option value="finalizado" <?php if($data['asignacion']['estado']=='finalizado') echo 'selected'; ?>>Finalizado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?php echo URL_ROOT; ?>/asignaciones" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 