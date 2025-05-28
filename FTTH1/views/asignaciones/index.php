<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-5">
    <h2>Asignaciones de Servicios a Clientes</h2>
    <a href="<?php echo URL_ROOT; ?>/asignaciones/crear" class="btn btn-success mb-3">Nueva Asignación</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha Asignación</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['asignaciones'] as $asignacion): ?>
                <tr>
                    <td><?php echo $asignacion['id_asignacion']; ?></td>
                    <td><?php echo $asignacion['nombre_cliente']; ?></td>
                    <td><?php echo $asignacion['fecha_asignacion']; ?></td>
                    <td><?php echo $asignacion['estado']; ?></td>
                    <td>
                        <a href="<?php echo URL_ROOT; ?>/asignaciones/ver?id=<?php echo $asignacion['id_asignacion']; ?>" class="btn btn-info btn-sm">Ver</a>
                        <a href="<?php echo URL_ROOT; ?>/asignaciones/editar?id=<?php echo $asignacion['id_asignacion']; ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="<?php echo URL_ROOT; ?>/asignaciones/eliminar?id=<?php echo $asignacion['id_asignacion']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 