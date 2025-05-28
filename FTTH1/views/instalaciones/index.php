<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">Instalaciones de la Caja NAP #<?php echo $id_caja; ?></h2>
    <div class="mb-3">
        <a href="<?php echo URL_ROOT; ?>/instalaciones/crear/<?php echo $id_caja; ?>" class="btn btn-success">Nueva Instalación</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Técnico</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($instalaciones)): ?>
                <tr><td colspan="6" class="text-center">No hay instalaciones registradas</td></tr>
            <?php else: ?>
                <?php foreach ($instalaciones as $instalacion): ?>
                    <tr>
                        <td><?php echo $instalacion['id_instalacion']; ?></td>
                        <td><?php echo $instalacion['id_tecnico']; ?></td>
                        <td><?php echo ucfirst($instalacion['tipo_instalacion']); ?></td>
                        <td><?php echo $instalacion['fecha_instalacion']; ?></td>
                        <td><?php echo $instalacion['observaciones'] ?? '-'; ?></td>
                        <td class="text-center">
                            <a href="<?php echo URL_ROOT; ?>/instalaciones/ver/<?php echo $instalacion['id_instalacion']; ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/instalaciones/editar/<?php echo $instalacion['id_instalacion']; ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/instalaciones/eliminar/<?php echo $instalacion['id_instalacion']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta instalación?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-secondary mt-3">Volver a Cajas NAP</a>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 