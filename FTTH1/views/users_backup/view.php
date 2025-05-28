<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detalles del Usuario</h4>
                    <a href="<?php echo URL_ROOT; ?>/user" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <?php 
                        // Determinar rol basado en el email
                        $role = 'Cliente';
                        $badgeClass = 'bg-secondary';
                        
                        $correo = isset($user['correo']) ? $user['correo'] : '';
                        
                        if (!empty($correo) && strpos($correo, '@solufiber-srl.com') !== false) {
                            if (strpos($correo, 'admin@') === 0) {
                                $role = 'Administrador';
                                $badgeClass = 'bg-danger';
                            } else if (strpos($correo, 'operador.') === 0) {
                                $role = 'Operador';
                                $badgeClass = 'bg-warning text-dark';
                            } else {
                                $role = 'Técnico';
                                $badgeClass = 'bg-info text-dark';
                            }
                        }
                        
                        // Determinar estado
                        $status = isset($user['active']) && $user['active'] == 1 ? 'Activo' : 'Inactivo';
                        $statusClass = $status == 'Activo' ? 'bg-success' : 'bg-danger';
                        
                        // Mapear campos que puedan tener nombres diferentes
                        $id = isset($user['id_usuario']) ? $user['id_usuario'] : (isset($user['id']) ? $user['id'] : '?');
                        $nombre = isset($user['nombre_completo']) ? $user['nombre_completo'] : (isset($user['name']) ? $user['name'] : '');
                        $email = isset($user['correo']) ? $user['correo'] : (isset($user['email']) ? $user['email'] : '');
                        $ultimo_acceso = isset($user['ultimo_acceso']) ? $user['ultimo_acceso'] : (isset($user['last_login']) ? $user['last_login'] : null);
                        $fecha_creacion = isset($user['fecha_creacion']) ? $user['fecha_creacion'] : (isset($user['created_at']) ? $user['created_at'] : null);
                    ?>
                    
                    <div class="row mb-4">
                        <div class="col text-center">
                            <div class="avatar-circle mx-auto mb-3">
                                <span class="initials"><?php echo strtoupper(substr($nombre, 0, 1)); ?></span>
                            </div>
                            <h3><?php echo $nombre; ?></h3>
                            <span class="badge <?php echo $badgeClass; ?> mb-2"><?php echo $role; ?></span>
                            <span class="badge <?php echo $statusClass; ?> mb-2"><?php echo $status; ?></span>
                            <p class="text-muted"><?php echo $email; ?></p>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th class="table-light" style="width: 30%">ID de Usuario</th>
                                    <td><?php echo $id; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Nombre Completo</th>
                                    <td><?php echo $nombre; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Correo Electrónico</th>
                                    <td><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Teléfono</th>
                                    <td><?php echo isset($user['telefono']) ? $user['telefono'] : 'No disponible'; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Dirección</th>
                                    <td><?php echo isset($user['direccion']) ? $user['direccion'] : 'No disponible'; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Rol</th>
                                    <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $role; ?></span></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Estado</th>
                                    <td><span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Fecha de Creación</th>
                                    <td><?php echo $fecha_creacion ? date('d/m/Y H:i', strtotime($fecha_creacion)) : 'No disponible'; ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light">Último Acceso</th>
                                    <td><?php echo $ultimo_acceso ? date('d/m/Y H:i', strtotime($ultimo_acceso)) : 'Nunca'; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        <a href="<?php echo URL_ROOT; ?>/user/edit?id=<?php echo $id; ?>" class="btn btn-primary me-2">
                            <i class="bi bi-pencil"></i> Editar Usuario
                        </a>
                        <?php if ($status == 'Activo' && $role !== 'Administrador'): ?>
                            <a href="<?php echo URL_ROOT; ?>/user/delete?id=<?php echo $id; ?>" 
                               class="btn btn-warning"
                               onclick="return confirm('¿Está seguro de desactivar este usuario?')">
                                <i class="bi bi-person-x"></i> Desactivar Usuario
                            </a>
                        <?php elseif ($status == 'Inactivo'): ?>
                            <a href="<?php echo URL_ROOT; ?>/user/activate?id=<?php echo $id; ?>" 
                               class="btn btn-success"
                               onclick="return confirm('¿Está seguro de activar este usuario?')">
                                <i class="bi bi-person-check"></i> Activar Usuario
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 100px;
        height: 100px;
        background-color: #0d6efd;
        text-align: center;
        border-radius: 50%;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .initials {
        position: relative;
        font-size: 50px;
        line-height: 50px;
        color: #fff;
        font-weight: bold;
    }
</style> 