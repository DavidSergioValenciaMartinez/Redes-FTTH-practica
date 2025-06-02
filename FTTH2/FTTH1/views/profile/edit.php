<?php
// Título de la página
$pageTitle = 'Editar Perfil';
// Incluir el encabezado
require_once APPROOT . '/views/layouts/header.php';
?>

<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo URL_ROOT; ?>/profile">Mi Perfil</a></li>
                    <li class="breadcrumb-item active">Editar Perfil</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Editar Perfil</h4>
                </div>

                <div class="card-body">
                    <?php flash('profile_message'); ?>

                    <form action="<?php echo URL_ROOT; ?>/profile/update" method="POST">
                        <div class="mb-3">
                            <label for="nombre_completo" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control <?php echo (!empty($data['nombre_completo_err'])) ? 'is-invalid' : ''; ?>" 
                                id="nombre_completo" name="nombre_completo" 
                                value="<?php echo isset($data['user']) ? $data['user']->nombre_completo : ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $data['nombre_completo_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control <?php echo (!empty($data['correo_err'])) ? 'is-invalid' : ''; ?>" 
                                id="correo" name="correo" 
                                value="<?php echo isset($data['user']) ? $data['user']->correo : ''; ?>" required>
                            <div class="invalid-feedback">
                                <?php echo $data['correo_err']; ?>
                            </div>
                            <div class="form-text">Este correo se utilizará para iniciar sesión.</div>
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control <?php echo (!empty($data['telefono_err'])) ? 'is-invalid' : ''; ?>" 
                                id="telefono" name="telefono" 
                                value="<?php echo isset($data['user']) ? $data['user']->telefono : ''; ?>">
                            <div class="invalid-feedback">
                                <?php echo $data['telefono_err']; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control <?php echo (!empty($data['direccion_err'])) ? 'is-invalid' : ''; ?>" 
                                id="direccion" name="direccion" rows="3"><?php echo isset($data['user']) ? $data['user']->direccion : ''; ?></textarea>
                            <div class="invalid-feedback">
                                <?php echo $data['direccion_err']; ?>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?php echo URL_ROOT; ?>/profile" class="btn btn-light me-md-2">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once APPROOT . '/views/layouts/footer.php'; ?> 