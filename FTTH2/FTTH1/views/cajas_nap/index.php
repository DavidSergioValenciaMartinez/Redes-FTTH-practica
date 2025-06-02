<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cajas NAP</h3>
                    <?php if (tienePermiso('crear_cajas_nap')): ?>
                    <div class="card-tools d-flex gap-2">
                        <a href="<?php echo URL_ROOT; ?>/cajas_nap/crear" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Nueva Caja NAP
                        </a>
                        <a href="<?php echo URL_ROOT; ?>/cajas_nap/grafica" class="btn btn-info btn-sm">
                            <i class="fas fa-th"></i> Mostrar gráfica de puertos
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Ubicación</th>
                                    <th>Departamento</th>
                                    <th>Estado</th>
                                    <th>Puertos</th>
                                    <th>Potencia</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data['cajas'] as $caja): ?>
                                <tr>
                                    <td><?php echo $caja['codigo_caja']; ?></td>
                                    <td><?php echo $caja['ubicacion']; ?></td>
                                    <td><?php echo $caja['nombre_departamento'] ?? 'No asignado'; ?></td>
                                    <td>
                                        <span class="badge badge-<?php echo strtolower($caja['estado']) === 'activo' ? 'success' : 'danger'; ?>">
                                            <?php echo ucfirst($caja['estado']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php echo $caja['puertos_disponibles']; ?>/<?php echo $caja['total_puertos']; ?>
                                        (<?php echo $caja['puertos_ocupados']; ?> ocupados)
                                    </td>
                                    <td><?php echo $caja['potencia_dbm']; ?> dBm</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?php echo URL_ROOT; ?>/cajas_nap/ver/<?php echo $caja['id_caja']; ?>" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if (tienePermiso('editar_cajas_nap')): ?>
                                            <a href="<?php echo URL_ROOT; ?>/cajas_nap/editar/<?php echo $caja['id_caja']; ?>" 
                                               class="btn btn-primary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php if (tienePermiso('eliminar_cajas_nap')): ?>
                                            <a href="<?php echo URL_ROOT; ?>/cajas_nap/eliminar/<?php echo $caja['id_caja']; ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('¿Está seguro de eliminar esta caja NAP?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>