<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Editar atributos de rol</h4>
                    <a href="<?php echo URL_ROOT; ?>/users/edit?id=<?php echo $user['id_usuario']; ?>" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo URL_ROOT; ?>/users/updateRoleAttributes?id=<?php echo $user['id_usuario']; ?>" method="POST">
                        <?php if ($rol === 'admin'): ?>
                            <div class="mb-3">
                                <label for="nivel_acceso" class="form-label">Nivel de Acceso</label>
                                <select class="form-select" id="nivel_acceso" name="nivel_acceso" required>
                                    <option value="total" <?php echo ($rolData['nivel_acceso'] ?? '') === 'total' ? 'selected' : ''; ?>>Total</option>
                                    <option value="reportes" <?php echo ($rolData['nivel_acceso'] ?? '') === 'reportes' ? 'selected' : ''; ?>>Reportes</option>
                                    <option value="configuraciones" <?php echo ($rolData['nivel_acceso'] ?? '') === 'configuraciones' ? 'selected' : ''; ?>>Configuraciones</option>
                                </select>
                            </div>
                        <?php elseif ($rol === 'tecnico'): ?>
                            <div class="mb-3">
                                <label for="certificacion" class="form-label">Certificación</label>
                                <input type="text" class="form-control" id="certificacion" name="certificacion" value="<?php echo $rolData['certificacion'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="area_asignada" class="form-label">Área Asignada</label>
                                <input type="text" class="form-control" id="area_asignada" name="area_asignada" value="<?php echo $rolData['area_asignada'] ?? ''; ?>">
                            </div>
                        <?php elseif ($rol === 'cliente'): ?>
                            <div class="alert alert-info">Este usuario es cliente. No hay atributos adicionales para editar.</div>
                        <?php endif; ?>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 