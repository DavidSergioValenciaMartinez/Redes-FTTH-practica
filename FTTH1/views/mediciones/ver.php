<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Detalle de Medición</h2>
    <table class="table table-bordered">
        <tr><th>ID Medición</th><td><?php echo $data['medicion']['id_medicion']; ?></td></tr>
        <tr><th>Caja NAP</th><td><?php echo htmlspecialchars($data['medicion']['codigo_caja']); ?></td></tr>
        <tr><th>Puerto</th><td><?php echo htmlspecialchars($data['medicion']['numero_puerto']); ?></td></tr>
        <tr><th>Potencia (dBm)</th><td><?php echo htmlspecialchars($data['medicion']['potencia_dbm']); ?></td></tr>
        <tr><th>Atenuación (dB)</th><td><?php echo htmlspecialchars($data['medicion']['atenuacion_db']); ?></td></tr>
        <tr><th>Medido por</th><td><?php echo htmlspecialchars($data['medicion']['nombre_usuario']); ?></td></tr>
        <tr><th>Fecha</th><td><?php echo date('d/m/Y H:i', strtotime($data['medicion']['medido_en'])); ?></td></tr>
        <tr><th>Fuente</th><td><?php echo ucfirst($data['medicion']['fuente']); ?></td></tr>
    </table>
    <a href="<?php echo URL_ROOT; ?>/mediciones" class="btn btn-secondary">Volver</a>
    <a href="<?php echo URL_ROOT; ?>/mediciones/editar/<?php echo $data['medicion']['id_medicion']; ?>" class="btn btn-warning">Editar</a>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 