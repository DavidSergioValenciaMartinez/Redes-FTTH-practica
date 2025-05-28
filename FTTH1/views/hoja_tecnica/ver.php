<?php require_once VIEWS_PATH . '/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Detalle de Hoja Técnica</h2>
    <table class="table table-bordered">
        <tr><th>ID Caja</th><td><?php echo $hoja['id_caja']; ?></td></tr>
        <tr><th>Departamento</th><td><?php echo $hoja['id_departamento']; ?></td></tr>
        <tr><th>Código Caja</th><td><?php echo $hoja['codigo_caja']; ?></td></tr>
        <tr><th>Ubicación</th><td><?php echo $hoja['ubicacion']; ?></td></tr>
        <tr><th>Total Puertos</th><td><?php echo $hoja['total_puertos']; ?></td></tr>
        <tr><th>Puertos Disponibles</th><td><?php echo $hoja['puertos_disponibles']; ?></td></tr>
        <tr><th>Puertos Ocupados</th><td><?php echo $hoja['puertos_ocupados']; ?></td></tr>
        <tr><th>Potencia (dBm)</th><td><?php echo $hoja['potencia_dbm']; ?></td></tr>
        <tr><th>Estado</th><td><?php echo ucfirst($hoja['estado']); ?></td></tr>
        <tr><th>Fabricante</th><td><?php echo $hoja['fabricante']; ?></td></tr>
        <tr><th>Modelo</th><td><?php echo $hoja['modelo']; ?></td></tr>
        <tr><th>Capacidad</th><td><?php echo $hoja['capacidad']; ?></td></tr>
    </table>
    <a href="<?php echo URL_ROOT; ?>/hoja_tecnica" class="btn btn-secondary">Volver</a>
    <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/editar/<?php echo $hoja['id_caja']; ?>" class="btn btn-warning">Editar</a>
</div>
<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?> 