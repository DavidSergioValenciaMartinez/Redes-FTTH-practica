<?php require VIEWS_PATH . '/layouts/header.php'; ?>

<div class="main-content">
    <div class="page-header">
        <h1 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-lan"></i>
            </span> Detalle de Caja NAP
        </h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo URL_ROOT; ?>">Inicio</a></li>
                <li class="breadcrumb-item"><a href="<?php echo URL_ROOT; ?>/cajas_nap">Cajas NAP</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detalle</li>
            </ol>
        </nav>
    </div>

    <?php flash('mensaje'); ?>

    <?php if (isset($data['caja']) && $data['caja']): ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Información de la Caja NAP</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th width="30%">ID:</th>
                                        <td><?php echo $data['caja']['id_caja']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Código:</th>
                                        <td class="font-weight-bold"><?php echo $data['caja']['codigo_caja']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Departamento:</th>
                                        <td><?php echo $data['caja']['nombre_departamento']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Distrito:</th>
                                        <td><?php echo $data['caja']['nombre_distrito']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ubicación:</th>
                                        <td><?php echo $data['caja']['ubicacion']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Capacidad:</th>
                                        <td><?php echo $data['caja']['capacidad']; ?> puertos</td>
                                    </tr>
                                    <tr>
                                        <th>Puertos libres:</th>
                                        <td>
                                            <?php 
                                                $porcentajeLibre = ($data['caja']['puertos_libres'] / $data['caja']['capacidad']) * 100;
                                                $colorClass = ($porcentajeLibre > 50) ? 'text-success' : 
                                                            (($porcentajeLibre > 20) ? 'text-warning' : 'text-danger');
                                            ?>
                                            <span class="<?php echo $colorClass; ?> font-weight-bold">
                                                <?php echo $data['caja']['puertos_libres']; ?> puertos 
                                                (<?php echo number_format($porcentajeLibre, 1); ?>%)
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Estado:</th>
                                        <td>
                                            <?php if ($data['caja']['estado'] == 'activo'): ?>
                                                <span class="badge bg-success">Activo</span>
                                            <?php elseif ($data['caja']['estado'] == 'inactivo'): ?>
                                                <span class="badge bg-danger">Inactivo</span>
                                            <?php elseif ($data['caja']['estado'] == 'mantenimiento'): ?>
                                                <span class="badge bg-warning text-dark">En Mantenimiento</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary"><?php echo ucfirst($data['caja']['estado']); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php if (!empty($data['caja']['latitud']) && !empty($data['caja']['longitud'])): ?>
                                    <tr>
                                        <th>Coordenadas:</th>
                                        <td>
                                            <a href="https://www.google.com/maps?q=<?php echo $data['caja']['latitud']; ?>,<?php echo $data['caja']['longitud']; ?>" 
                                               target="_blank" class="text-primary">
                                                <?php echo $data['caja']['latitud']; ?>, <?php echo $data['caja']['longitud']; ?>
                                                <i class="mdi mdi-map-marker-radius"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if (!empty($data['caja']['observaciones'])): ?>
                                    <tr>
                                        <th>Observaciones:</th>
                                        <td><?php echo nl2br($data['caja']['observaciones']); ?></td>
                                    </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <th>Fecha de creación:</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($data['caja']['fecha_creacion'])); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Última actualización:</th>
                                        <td><?php echo date('d/m/Y H:i', strtotime($data['caja']['fecha_actualizacion'])); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4 d-flex gap-2">
                            <?php if (esAdmin() || tienePermiso('cajas_nap_editar')): ?>
                                <a href="<?php echo URL_ROOT; ?>/cajas_nap/editar/<?php echo $data['caja']['id_caja']; ?>" 
                                   class="btn btn-warning me-2">
                                    <i class="mdi mdi-pencil"></i> Editar
                                </a>
                            <?php endif; ?>
                            
                            <?php if (esAdmin() || tienePermiso('cajas_nap_estado')): ?>
                                <button type="button" class="btn btn-info me-2" data-bs-toggle="modal" data-bs-target="#cambiarEstadoModal">
                                    <i class="mdi mdi-sync"></i> Cambiar Estado
                                </button>
                            <?php endif; ?>
                            
                            <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-light">
                                <i class="mdi mdi-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Ocupación de Puertos</h4>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-gradient-success text-white">
                                    <div class="card-body text-center py-3">
                                        <h2 class="mb-2"><?php echo $data['caja']['capacidad']; ?></h2>
                                        <p class="mb-0">Capacidad Total</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-gradient-primary text-white">
                                    <div class="card-body text-center py-3">
                                        <h2 class="mb-2"><?php echo $data['caja']['puertos_libres']; ?></h2>
                                        <p class="mb-0">Puertos Disponibles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="progress mt-4" style="height: 30px;">
                            <?php 
                                $porcentajeOcupado = (($data['caja']['capacidad'] - $data['caja']['puertos_libres']) / $data['caja']['capacidad']) * 100;
                            ?>
                            <div class="progress-bar bg-danger" role="progressbar" 
                                style="width: <?php echo $porcentajeOcupado; ?>%;" 
                                aria-valuenow="<?php echo $porcentajeOcupado; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo number_format($porcentajeOcupado, 1); ?>% Ocupado
                            </div>
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: <?php echo 100 - $porcentajeOcupado; ?>%;" 
                                aria-valuenow="<?php echo 100 - $porcentajeOcupado; ?>" aria-valuemin="0" aria-valuemax="100">
                                <?php echo number_format(100 - $porcentajeOcupado, 1); ?>% Libre
                            </div>
                        </div>
                        
                        <!-- Aquí se podría añadir una tabla con el detalle de los clientes asignados a cada puerto -->
                        <h5 class="mt-4">Lista de Puertos</h5>
                        <div class="table-responsive mt-3">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Puerto</th>
                                        <th>Estado</th>
                                        <th>Cliente</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    // Aquí se debería recorrer la lista de puertos que viene en $data['puertos']
                                    // Por ahora generamos un ejemplo basado en la capacidad
                                    $puertosOcupados = $data['caja']['capacidad'] - $data['caja']['puertos_libres'];
                                    
                                    for ($i = 1; $i <= $data['caja']['capacidad']; $i++): 
                                        $ocupado = $i <= $puertosOcupados;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td>
                                            <?php if ($ocupado): ?>
                                                <span class="badge bg-danger">Ocupado</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Libre</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($ocupado): ?>
                                                <a href="#" class="text-decoration-none">Cliente Ejemplo</a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($ocupado): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger">Liberar</button>
                                            <?php else: ?>
                                                <button type="button" class="btn btn-sm btn-outline-primary">Asignar</button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            <i class="mdi mdi-alert-circle-outline"></i>
            No se encontró la caja NAP solicitada.
            <br>
            <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-sm btn-outline-danger mt-3">
                <i class="mdi mdi-arrow-left"></i> Volver a la lista
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Modal para cambiar estado -->
<div class="modal fade" id="cambiarEstadoModal" tabindex="-1" aria-labelledby="cambiarEstadoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cambiarEstadoModalLabel">Cambiar Estado de Caja NAP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="<?php echo URL_ROOT; ?>/cajas_nap/cambiarEstado">
                <div class="modal-body">
                    <input type="hidden" name="id_caja" value="<?php echo $data['caja']['id_caja']; ?>">
                    
                    <div class="form-group">
                        <label for="estado">Nuevo Estado</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="">Seleccione un estado</option>
                            <option value="activo" <?php echo ($data['caja']['estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                            <option value="inactivo" <?php echo ($data['caja']['estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                            <option value="mantenimiento" <?php echo ($data['caja']['estado'] == 'mantenimiento') ? 'selected' : ''; ?>>En Mantenimiento</option>
                        </select>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label for="motivo_cambio">Motivo del cambio</label>
                        <textarea class="form-control" id="motivo_cambio" name="motivo_cambio" rows="3" 
                            placeholder="Explique brevemente por qué está cambiando el estado"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require VIEWS_PATH . '/layouts/footer.php'; ?> 