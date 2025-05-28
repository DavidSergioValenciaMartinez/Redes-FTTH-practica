<?php require_once VIEWS_PATH . '/layouts/header.php'; ?>
<div class="container my-4">
    <h2>Editar Hoja Técnica de Caja NAP</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Departamento</label>
            <select name="id_departamento" class="form-select" required>
                <?php foreach ($departamentos as $dep): ?>
                    <option value="<?php echo $dep['id_departamento']; ?>" <?php if ($dep['id_departamento'] == $hoja['id_departamento']) echo 'selected'; ?>><?php echo $dep['nombre_departamento']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Código Caja</label>
            <input type="text" name="codigo_caja" class="form-control" value="<?php echo $hoja['codigo_caja']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Ubicación</label>
            <input type="text" name="ubicacion" class="form-control" value="<?php echo $hoja['ubicacion']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Total Puertos</label>
            <input type="number" name="total_puertos" class="form-control" value="<?php echo $hoja['total_puertos']; ?>" min="1" max="16" required>
        </div>
        <div class="mb-3">
            <label>Puertos Disponibles</label>
            <input type="number" name="puertos_disponibles" class="form-control" value="<?php echo $hoja['puertos_disponibles']; ?>" min="0" required>
        </div>
        <div class="mb-3">
            <label>Puertos Ocupados</label>
            <input type="number" name="puertos_ocupados" class="form-control" value="<?php echo $hoja['puertos_ocupados']; ?>" min="0" required>
        </div>
        <div class="mb-3">
            <label>Potencia (dBm)</label>
            <input type="number" step="0.01" name="potencia_dbm" class="form-control" value="<?php echo $hoja['potencia_dbm']; ?>">
        </div>
        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-select" required>
                <option value="activo" <?php if ($hoja['estado'] == 'activo') echo 'selected'; ?>>Activo</option>
                <option value="inactivo" <?php if ($hoja['estado'] == 'inactivo') echo 'selected'; ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Fabricante</label>
            <input type="text" name="fabricante" class="form-control" value="<?php echo $hoja['fabricante']; ?>">
        </div>
        <div class="mb-3">
            <label>Modelo</label>
            <input type="text" name="modelo" class="form-control" value="<?php echo $hoja['modelo']; ?>">
        </div>
        <div class="mb-3">
            <label>Capacidad</label>
            <input type="text" name="capacidad" class="form-control" value="<?php echo $hoja['capacidad']; ?>">
        </div>
        <button type="submit" class="btn btn-success">Guardar Cambios</button>
        <a href="<?php echo URL_ROOT; ?>/hoja_tecnica/ver/<?php echo $hoja['id_caja']; ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?php require_once VIEWS_PATH . '/layouts/footer.php'; ?> 