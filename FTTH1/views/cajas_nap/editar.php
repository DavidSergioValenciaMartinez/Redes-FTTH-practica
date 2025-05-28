<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Editar Caja NAP</h3>
                </div>
                <div class="card-body">
                    <form action="<?php echo URL_ROOT; ?>/cajas_nap/actualizar/<?php echo $data['caja']['id_caja']; ?>" method="POST" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo_caja">Código de Caja *</label>
                                    <input type="text" class="form-control" id="codigo_caja" name="codigo_caja" 
                                           value="<?php echo $data['caja']['codigo_caja']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el código de la caja
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_departamento">Departamento *</label>
                                    <select class="form-control" id="id_departamento" name="id_departamento" required>
                                        <option value="">Seleccione un departamento</option>
                                        <?php foreach ($data['departamentos'] as $departamento): ?>
                                            <option value="<?php echo $departamento['id_departamento']; ?>" 
                                                    <?php echo ($departamento['id_departamento'] == $data['caja']['id_departamento']) ? 'selected' : ''; ?>>
                                                <?php echo $departamento['nombre_departamento']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un departamento
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="ubicacion">Ubicación *</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                                           value="<?php echo $data['caja']['ubicacion']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese la ubicación
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total_puertos">Total de Puertos *</label>
                                    <input type="number" class="form-control" id="total_puertos" name="total_puertos" 
                                           value="<?php echo $data['caja']['total_puertos']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el total de puertos
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="puertos_disponibles">Puertos Disponibles *</label>
                                    <input type="number" class="form-control" id="puertos_disponibles" name="puertos_disponibles" 
                                           value="<?php echo $data['caja']['puertos_disponibles']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese los puertos disponibles
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="puertos_ocupados">Puertos Ocupados *</label>
                                    <input type="number" class="form-control" id="puertos_ocupados" name="puertos_ocupados" 
                                           value="<?php echo $data['caja']['puertos_ocupados']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese los puertos ocupados
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="potencia_dbm">Potencia (dBm)</label>
                                    <input type="number" step="0.01" class="form-control" id="potencia_dbm" name="potencia_dbm" 
                                           value="<?php echo $data['caja']['potencia_dbm']; ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estado">Estado *</label>
                                    <select class="form-control" id="estado" name="estado" required>
                                        <option value="activo" <?php echo ($data['caja']['estado'] == 'activo') ? 'selected' : ''; ?>>Activo</option>
                                        <option value="inactivo" <?php echo ($data['caja']['estado'] == 'inactivo') ? 'selected' : ''; ?>>Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="capacidad">Capacidad *</label>
                                    <input type="text" class="form-control" id="capacidad" name="capacidad" 
                                           value="<?php echo $data['caja']['capacidad']; ?>" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese la capacidad
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fabricante">Fabricante</label>
                                    <input type="text" class="form-control" id="fabricante" name="fabricante" 
                                           value="<?php echo $data['caja']['fabricante']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modelo">Modelo</label>
                                    <input type="text" class="form-control" id="modelo" name="modelo" 
                                           value="<?php echo $data['caja']['modelo']; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                <a href="<?php echo URL_ROOT; ?>/cajas_nap" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?> 