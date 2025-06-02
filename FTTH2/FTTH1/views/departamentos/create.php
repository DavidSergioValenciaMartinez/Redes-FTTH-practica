<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center">Registrar Departamento</h3>
                    <?php if (isset(
                        $error) && $error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success">Departamento registrado correctamente.</div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nombre_departamento" class="form-label">Nombre del Departamento *</label>
                            <select class="form-control" id="nombre_departamento" name="nombre_departamento" required>
                                <option value="">Seleccione un departamento...</option>
                                <option value="La Paz">La Paz</option>
                                <option value="Oruro">Oruro</option>
                                <option value="Potosí">Potosí</option>
                                <option value="Chuquisaca">Chuquisaca</option>
                                <option value="Cochabamba">Cochabamba</option>
                                <option value="Tarija">Tarija</option>
                                <option value="Santa Cruz">Santa Cruz</option>
                                <option value="Beni">Beni</option>
                                <option value="Pando">Pando</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 