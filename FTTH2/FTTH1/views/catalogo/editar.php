<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="container my-5">
    <h2>Editar Producto</h2>
    <form action="<?php echo URL_ROOT; ?>/catalogo/editar/<?php echo $data['producto']['id_producto']; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="tipo_producto" class="form-label">Tipo de Producto</label>
            <select class="form-select" id="tipo_producto" name="tipo_producto" required>
                <option value="">Seleccione tipo...</option>
                <option value="caja_nap" <?php if($data['producto']['tipo_producto']=='caja_nap') echo 'selected'; ?>>Caja NAP</option>
                <option value="splitter" <?php if($data['producto']['tipo_producto']=='splitter') echo 'selected'; ?>>Splitter</option>
                <option value="conector" <?php if($data['producto']['tipo_producto']=='conector') echo 'selected'; ?>>Conector</option>
                <option value="cable" <?php if($data['producto']['tipo_producto']=='cable') echo 'selected'; ?>>Cable</option>
                <option value="otro" <?php if($data['producto']['tipo_producto']=='otro') echo 'selected'; ?>>Otro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="<?php echo htmlspecialchars($data['producto']['marca']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($data['producto']['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($data['producto']['descripcion']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio</label>
            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="<?php echo $data['producto']['precio']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen actual</label><br>
            <?php if (!empty($data['producto']['imagen'])): ?>
                <img src="<?php echo htmlspecialchars($data['producto']['imagen']); ?>" alt="Imagen actual" style="max-width:150px; max-height:150px;" class="img-thumbnail mb-2">
            <?php else: ?>
                <span class="text-muted">Sin imagen</span>
            <?php endif; ?>
            <br>
            <label for="imagen" class="form-label mt-2">Subir nueva imagen</label>
            <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="preview" src="#" alt="Previsualización" style="display:none; max-width:200px; max-height:200px;" class="img-thumbnail" />
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="<?php echo URL_ROOT; ?>/catalogo" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('preview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    if(event.target.files[0]){
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?> 