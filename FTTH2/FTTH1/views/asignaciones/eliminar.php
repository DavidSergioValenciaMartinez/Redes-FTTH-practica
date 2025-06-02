<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <h2>Eliminar Asignación</h2>
    <div class="alert alert-danger">¿Estás seguro de que deseas eliminar esta asignación?</div>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID Asignación:</strong> <?php echo $data['asignacion']['id_asignacion']; ?></li>
        <li class="list-group-item"><strong>ID Cliente:</strong> <?php echo $data['asignacion']['id_cliente']; ?></li>
        <li class="list-group-item"><strong>Fecha de Asignación:</strong> <?php echo $data['asignacion']['fecha_asignacion']; ?></li>
        <li class="list-group-item"><strong>Estado:</strong> <?php echo $data['asignacion']['estado']; ?></li>
    </ul>
    <form action="<?php echo URL_ROOT; ?>/asignaciones/eliminar?id=<?php echo $data['asignacion']['id_asignacion']; ?>" method="POST" class="mt-3">
        <button type="submit" class="btn btn-danger">Eliminar</button>
        <a href="<?php echo URL_ROOT; ?>/asignaciones" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 