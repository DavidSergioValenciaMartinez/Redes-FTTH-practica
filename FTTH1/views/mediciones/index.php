<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Medición de Puertos</h2>
        <a href="<?php echo URL_ROOT; ?>/mediciones/crear" class="btn btn-success">Nueva Medición</a>
    </div>
    <?php flash('mensaje'); ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Caja NAP</th>
                    <th>Puerto</th>
                    <th>Potencia (dBm)</th>
                    <th>Atenuación (dB)</th>
                    <th>Medido por</th>
                    <th>Fecha</th>
                    <th>Fuente</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($data['mediciones'])): ?>
                    <tr>
                        <td colspan="9" class="text-center">No hay mediciones registradas</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['mediciones'] as $med): ?>
                        <tr>
                            <td><?php echo $med['id_medicion']; ?></td>
                            <td><?php echo htmlspecialchars($med['codigo_caja']); ?></td>
                            <td><?php echo htmlspecialchars($med['numero_puerto']); ?></td>
                            <td><?php echo htmlspecialchars($med['potencia_dbm']); ?></td>
                            <td><?php echo htmlspecialchars($med['atenuacion_db']); ?></td>
                            <td><?php echo htmlspecialchars($med['nombre_usuario']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($med['medido_en'])); ?></td>
                            <td><?php echo ucfirst($med['fuente']); ?></td>
                            <td>
                                <a href="<?php echo URL_ROOT; ?>/mediciones/ver/<?php echo $med['id_medicion']; ?>" class="btn btn-info btn-sm">Ver</a>
                                <a href="<?php echo URL_ROOT; ?>/mediciones/editar/<?php echo $med['id_medicion']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="<?php echo URL_ROOT; ?>/mediciones/eliminar/<?php echo $med['id_medicion']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta medición?');">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 