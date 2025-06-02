<?php require_once 'views/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Detalle de Instalación</h2>
    <table class="table table-bordered">
        <tr><th>ID Instalación</th><td><?php echo $data['instalacion']['id_instalacion']; ?></td></tr>
        <tr><th>ID Caja NAP</th><td><?php echo $data['instalacion']['id_caja']; ?></td></tr>
        <tr><th>Técnico</th><td><?php echo isset($data['instalacion']['nombre_tecnico']) ? $data['instalacion']['nombre_tecnico'] : $data['instalacion']['id_tecnico']; ?></td></tr>
        <tr><th>Tipo de Instalación</th><td><?php echo ucfirst($data['instalacion']['tipo_instalacion']); ?></td></tr>
        <tr><th>Fecha de Instalación</th><td><?php echo $data['instalacion']['fecha_instalacion']; ?></td></tr>
        <tr><th>Observaciones</th><td><?php echo $data['instalacion']['observaciones'] ?? '-'; ?></td></tr>
    </table>
    <a href="<?php echo URL_ROOT; ?>/instalaciones" class="btn btn-secondary">Volver</a>
    <a href="<?php echo URL_ROOT; ?>/instalaciones/editar/<?php echo $data['instalacion']['id_instalacion']; ?>" class="btn btn-warning">Editar</a>
    <form action="<?php echo URL_ROOT; ?>/instalaciones/eliminar/<?php echo $data['instalacion']['id_instalacion']; ?>" method="POST" style="display:inline;">
        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar esta instalación?');">Eliminar</button>
    </form>
</div>
<?php require_once 'views/layouts/footer.php'; ?> 