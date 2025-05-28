<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-ethernet me-2"></i>
                        Detalle del Puerto #<?php echo $puerto['numero_puerto']; ?>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" style="width: 40%">Número de Puerto:</th>
                                    <td><?php echo $puerto['numero_puerto']; ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Estado:</th>
                                    <td>
                                        <span class="badge bg-<?php 
                                            echo $puerto['estado'] == 'disponible' ? 'success' : 
                                                ($puerto['estado'] == 'ocupado' ? 'primary' : 'danger'); 
                                        ?>">
                                            <?php echo ucfirst($puerto['estado']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Cliente:</th>
                                    <td>
                                        <?php 
                                        if ($puerto['cliente_usuario_id']) {
                                            echo htmlspecialchars($puerto['nombre_cliente']);
                                        } else {
                                            echo '-';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="bg-light" style="width: 40%">Tipo de Splitter:</th>
                                    <td><?php echo $puerto['splitter_tipo'] ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Ratio de Splitter:</th>
                                    <td><?php echo $puerto['splitter_ratio'] ?? '-'; ?></td>
                                </tr>
                                <tr>
                                    <th class="bg-light">Atenuación Splitter:</th>
                                    <td><?php echo $puerto['splitter_atenuacion_db'] ? $puerto['splitter_atenuacion_db'] . ' dB' : '-'; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Información Adicional</h5>
                        <table class="table table-bordered">
                            <tr>
                                <th class="bg-light" style="width: 40%">Última Actualización:</th>
                                <td><?php echo $puerto['actualizado_en'] ?? '-'; ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="<?php echo URL_ROOT; ?>/puertos/index/<?php echo $puerto['id_caja']; ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Volver a Puertos
                        </a>
                        <div>
                            <a href="<?php echo URL_ROOT; ?>/puertos/editar/<?php echo $puerto['id_puerto']; ?>" class="btn btn-primary me-2">
                                <i class="fas fa-edit me-2"></i>Editar Puerto
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/puertos/eliminar/<?php echo $puerto['id_puerto']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro que desea eliminar este puerto?');">
                                <i class="fas fa-trash me-2"></i>Eliminar Puerto
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 