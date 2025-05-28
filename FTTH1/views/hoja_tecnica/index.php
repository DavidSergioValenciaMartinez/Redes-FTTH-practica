<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Hojas Técnicas</h2>
        <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/seleccionar_caja" class="btn btn-success">Nueva Hoja Técnica</a>
    </div>

    <?php flash('mensaje'); ?>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Caja NAP</th>
                    <th>Técnico</th>
                    <th>Tipo de Trabajo</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['hojas_tecnicas'])): ?>
                    <tr>
                        <td colspan="7" class="text-center">No hay hojas técnicas registradas</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['hojas_tecnicas'] as $hoja): ?>
                        <tr>
                            <td><?php echo $hoja['id_hoja_caja']; ?></td>
                            <td><?php echo $hoja['codigo_caja']; ?></td>
                            <td><?php echo $hoja['nombre_tecnico']; ?></td>
                            <td><?php echo ucfirst($hoja['tipo_trabajo']); ?></td>
                            <td>
                                <span class="badge bg-<?php 
                                    echo $hoja['estado'] === 'activa' ? 'success' : 
                                        ($hoja['estado'] === 'inactiva' ? 'danger' : 'warning'); 
                                ?>">
                                    <?php echo ucfirst($hoja['estado']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($hoja['creado_en'])); ?></td>
                            <td>
                                <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/ver/<?php echo $hoja['id_hoja_caja']; ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/editar/<?php echo $hoja['id_hoja_caja']; ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/eliminar/<?php echo $hoja['id_hoja_caja']; ?>" 
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('¿Está seguro de eliminar esta hoja técnica?');">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 