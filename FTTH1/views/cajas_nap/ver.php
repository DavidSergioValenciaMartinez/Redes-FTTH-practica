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

    <?php if(!isset($data['caja']) || empty($data['caja'])): ?>
        <div class="alert alert-danger">
            <i class="mdi mdi-alert-circle"></i> La caja NAP solicitada no existe o ha sido eliminada.
            <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="alert-link">Volver al listado</a>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Información General</h4>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Estado:</span>
                            <?php if($data['caja']->estado == 'activo'): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php elseif($data['caja']->estado == 'inactivo'): ?>
                                <span class="badge bg-danger">Inactivo</span>
                            <?php else: ?>
                                <span class="badge bg-warning">En Mantenimiento</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <th>Código:</th>
                                        <td><?php echo $data['caja']->codigo_caja; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Capacidad:</th>
                                        <td><?php echo $data['caja']->capacidad; ?> puertos</td>
                                    </tr>
                                    <tr>
                                        <th>Puertos Utilizados:</th>
                                        <td>
                                            <div class="progress mb-2">
                                                <?php 
                                                    $utilizados = $data['caja']->puertos_utilizados;
                                                    $capacidad = $data['caja']->capacidad;
                                                    $porcentaje = ($capacidad > 0) ? round(($utilizados / $capacidad) * 100) : 0;
                                                    $clase = 'bg-success';
                                                    
                                                    if ($porcentaje >= 90) {
                                                        $clase = 'bg-danger';
                                                    } else if ($porcentaje >= 70) {
                                                        $clase = 'bg-warning';
                                                    }
                                                ?>
                                                <div class="progress-bar <?php echo $clase; ?>" role="progressbar" 
                                                     style="width: <?php echo $porcentaje; ?>%" 
                                                     aria-valuenow="<?php echo $porcentaje; ?>" 
                                                     aria-valuemin="0" 
                                                     aria-valuemax="100">
                                                    <?php echo $porcentaje; ?>%
                                                </div>
                                            </div>
                                            <small><?php echo $utilizados; ?> de <?php echo $capacidad; ?> puertos utilizados</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Departamento:</th>
                                        <td><?php echo $data['caja']->departamento; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Distrito:</th>
                                        <td><?php echo $data['caja']->distrito; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <h5>Ubicación Detallada</h5>
                            <p><?php echo $data['caja']['ubicacion']; ?></p>
                        </div>
                        
                        <?php if(!empty($data['caja']['observaciones'])): ?>
                            <div class="mt-4">
                                <h5>Observaciones</h5>
                                <p><?php echo $data['caja']['observaciones']; ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-outline-secondary">
                                <i class="mdi mdi-arrow-left"></i> Volver
                            </a>
                            
                            <div>
                                <?php if(tienePermiso('cajas_nap_editar')): ?>
                                    <a href="<?php echo URL_ROOT; ?>/cajas_nap/editar/<?php echo $data['caja']['id_caja']; ?>" class="btn btn-primary me-2">
                                        <i class="mdi mdi-pencil"></i> Editar
                                    </a>
                                <?php endif; ?>
                                
                                <?php if(tienePermiso('puertos_nap_gestionar')): ?>
                                    <a href="<?php echo URL_ROOT; ?>/puertos_nap/gestion/<?php echo $data['caja']['id_caja']; ?>" class="btn btn-success">
                                        <i class="mdi mdi-ethernet"></i> Gestionar Puertos
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Ubicación en Mapa</h4>
                        
                        <?php if(!empty($data['caja']['latitud']) && !empty($data['caja']['longitud'])): ?>
                            <div id="mapa" style="height: 400px; width: 100%;"></div>
                            
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Inicializar el mapa
                                    function initMap() {
                                        const position = {
                                            lat: <?php echo $data['caja']['latitud']; ?>, 
                                            lng: <?php echo $data['caja']['longitud']; ?>
                                        };
                                        
                                        const map = new google.maps.Map(document.getElementById('mapa'), {
                                            zoom: 16,
                                            center: position
                                        });
                                        
                                        const marker = new google.maps.Marker({
                                            position: position,
                                            map: map,
                                            title: '<?php echo $data['caja']['codigo_caja']; ?>'
                                        });
                                        
                                        const infoWindow = new google.maps.InfoWindow({
                                            content: '<div><strong><?php echo $data['caja']['codigo_caja']; ?></strong><br>' +
                                                     'Cap: <?php echo $data['caja']['capacidad']; ?> puertos<br>' +
                                                     'Ubic: <?php echo addslashes(substr($data['caja']['ubicacion'], 0, 50)); ?>...</div>'
                                        });
                                        
                                        marker.addListener('click', () => {
                                            infoWindow.open(map, marker);
                                        });
                                    }
                                    
                                    // Cargar mapa cuando el script de Google Maps esté listo
                                    if (typeof google === 'object' && typeof google.maps === 'object') {
                                        initMap();
                                    } else {
                                        // Si el script de Google Maps no está cargado, cargar dinámicamente
                                        const script = document.createElement('script');
                                        script.src = 'https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&callback=initMap';
                                        script.async = true;
                                        script.defer = true;
                                        window.initMap = initMap;
                                        document.head.appendChild(script);
                                    }
                                });
                            </script>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <i class="mdi mdi-map-marker-off"></i> No se ha registrado la ubicación geográfica de esta caja NAP.
                                <?php if(tienePermiso('cajas_nap_editar')): ?>
                                    <a href="<?php echo URL_ROOT; ?>/cajas_nap/editar/<?php echo $data['caja']['id_caja']; ?>" class="alert-link">
                                        Editar para agregar ubicación
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="card mt-4">
                    <div class="card-body">
                        <h4 class="card-title">Resumen de Puertos</h4>
                        
                        <div class="mt-3">
                            <canvas id="grafico-puertos" height="230"></canvas>
                        </div>
                        
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-4 text-center border-end">
                                    <h3 class="text-primary"><?php echo $data['caja']['puertos_libres']; ?></h3>
                                    <p class="text-muted">Puertos Libres</p>
                                </div>
                                <div class="col-md-4 text-center border-end">
                                    <h3 class="text-success"><?php echo $data['caja']['puertos_activos']; ?></h3>
                                    <p class="text-muted">Puertos Activos</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <h3 class="text-danger"><?php echo $data['caja']['puertos_inactivos']; ?></h3>
                                    <p class="text-muted">Puertos Inactivos</p>
                                </div>
                            </div>
                        </div>
                        
                        <?php if(tienePermiso('puertos_nap_gestionar')): ?>
                            <div class="text-center mt-4">
                                <a href="<?php echo URL_ROOT; ?>/puertos_nap/gestion/<?php echo $data['caja']['id_caja']; ?>" class="btn btn-outline-primary">
                                    Ver Detalle de Puertos
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php if(isset($data['caja']) && !empty($data['caja'])): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfico de puertos
    const ctxPuertos = document.getElementById('grafico-puertos').getContext('2d');
    const libre = <?php echo $data['caja']['puertos_libres']; ?>;
    const activo = <?php echo $data['caja']['puertos_activos']; ?>;
    const inactivo = <?php echo $data['caja']['puertos_inactivos']; ?>;
    
    new Chart(ctxPuertos, {
        type: 'doughnut',
        data: {
            labels: ['Libres', 'Activos', 'Inactivos'],
            datasets: [{
                data: [libre, activo, inactivo],
                backgroundColor: ['#4B49AC', '#57B657', '#F3797E'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            cutout: '70%',
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
<?php endif; ?>

<?php require VIEWS_PATH . '/layouts/footer.php'; ?> 