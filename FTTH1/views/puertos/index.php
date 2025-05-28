<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2 class="mb-4">
        <?php if (isset($id_caja)): ?>
            Puertos de la Caja NAP #<?php echo $id_caja; ?>
        <?php else: ?>
            Todos los Puertos
        <?php endif; ?>
    </h2>
    <?php if (isset($id_caja)): ?>
        <a href="<?php echo URL_ROOT; ?>/puertos/crear/<?php echo $id_caja; ?>" class="btn btn-success mb-3">Nuevo Puerto</a>
    <?php else: ?>
        <a href="<?php echo URL_ROOT; ?>/puertos/crear" class="btn btn-success mb-3">Nuevo Puerto</a>
    <?php endif; ?>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Estado</th>
                <th>Cliente</th>
                <th>Splitter Tipo</th>
                <th>Splitter Ratio</th>
                <th>Atenuación (dB)</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($puertos)): ?>
                <tr><td colspan="7" class="text-center">No hay puertos registrados</td></tr>
            <?php else: ?>
                <?php foreach ($puertos as $puerto): ?>
                    <tr>
                        <td><?php echo $puerto['numero_puerto']; ?></td>
                        <td>
                            <span class="badge bg-<?php 
                                echo $puerto['estado'] == 'disponible' ? 'success' : 
                                    ($puerto['estado'] == 'ocupado' ? 'primary' : 'danger'); 
                            ?>">
                                <?php echo ucfirst($puerto['estado']); ?>
                            </span>
                        </td>
                        <td>
                            <?php 
                            if ($puerto['cliente_usuario_id']) {
                                echo htmlspecialchars($puerto['nombre_cliente']);
                            } else {
                                echo '-';
                            }
                            ?>
                        </td>
                        <td><?php echo $puerto['splitter_tipo'] ?? '-'; ?></td>
                        <td><?php echo $puerto['splitter_ratio'] ?? '-'; ?></td>
                        <td><?php echo $puerto['splitter_atenuacion_db'] ?? '-'; ?></td>
                        <td>
                            <a href="<?php echo URL_ROOT; ?>/puertos/ver/<?php echo $puerto['id_puerto']; ?>" class="btn btn-info btn-sm">Ver</a>
                            <a href="<?php echo URL_ROOT; ?>/puertos/editar/<?php echo $puerto['id_puerto']; ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="<?php echo URL_ROOT; ?>/puertos/eliminar/<?php echo $puerto['id_puerto']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar este puerto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (isset($id_caja)): ?>
        <a href="<?php echo URL_ROOT; ?>/cajas_nap/ver/<?php echo $id_caja; ?>" class="btn btn-secondary mt-3">Volver a Caja NAP</a>
    <?php endif; ?>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 