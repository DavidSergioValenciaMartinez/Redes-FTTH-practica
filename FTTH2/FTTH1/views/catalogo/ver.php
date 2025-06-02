<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Detalle del Producto</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <?php if (!empty($data['producto']['imagen'])): ?>
                                <img src="<?php echo URL_ROOT . '/public/img/productos/' . htmlspecialchars($data['producto']['imagen']); ?>" alt="Imagen del producto" class="img-fluid rounded border" style="max-height:200px;">
                            <?php else: ?>
                                <img src="<?php echo URL_ROOT . '/public/img/productos'; ?>" alt="Sin imagen" class="img-fluid rounded border" style="max-height:200px;">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>ID:</strong> <?php echo $data['producto']['id_producto']; ?></li>
                                <li class="list-group-item"><strong>Tipo:</strong> <?php echo $data['producto']['tipo_producto']; ?></li>
                                <li class="list-group-item"><strong>Marca:</strong> <?php echo $data['producto']['marca']; ?></li>
                                <li class="list-group-item"><strong>Nombre:</strong> <?php echo $data['producto']['nombre']; ?></li>
                                <li class="list-group-item"><strong>Descripción:</strong> <?php echo $data['producto']['descripcion']; ?></li>
                                <li class="list-group-item"><strong>Precio:</strong> <span class="badge bg-success">Bs <?php echo number_format($data['producto']['precio'], 2); ?></span></li>
                                <li class="list-group-item"><strong>Imagen:</strong> 
                                    <?php if (!empty($data['producto']['imagen'])): ?>
                                        <img src="<?php echo URL_ROOT . '/public/img/productos/' . htmlspecialchars($data['producto']['imagen']); ?>" alt="Imagen del producto" style="max-width:120px; max-height:120px;" class="img-thumbnail">
                                    <?php else: ?>
                                        <img src="<?php echo URL_ROOT . '/public/img/productos'; ?>" alt="Sin imagen" style="max-width:120px; max-height:120px;" class="img-thumbnail">
                                    <?php endif; ?>
                                </li>
                                <li class="list-group-item"><strong>Creado en:</strong> <?php echo $data['producto']['creado_en']; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="<?php echo URL_ROOT; ?>/catalogo" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 