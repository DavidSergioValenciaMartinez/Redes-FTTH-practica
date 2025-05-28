<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <h2>Detalle de Asignación</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>ID Asignación:</strong> <?php echo $data['asignacion']['id_asignacion']; ?></li>
        <li class="list-group-item"><strong>Cliente:</strong> <?php echo $data['asignacion']['nombre_cliente']; ?></li>
        <li class="list-group-item"><strong>Fecha de Asignación:</strong> <?php echo $data['asignacion']['fecha_asignacion']; ?></li>
        <li class="list-group-item"><strong>Estado:</strong> <?php echo $data['asignacion']['estado']; ?></li>
    </ul>
    <a href="<?php echo URL_ROOT; ?>/asignaciones" class="btn btn-secondary mt-3">Volver</a>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 