<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestión de Usuarios</h4>
                    <a href="<?php echo URL_ROOT; ?>/users/create" class="btn btn-light">
                        <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['mensaje'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <a href="<?php echo URL_ROOT; ?>/user/by-role?role=admin" class="btn btn-outline-primary">Administradores</a>
                                <a href="<?php echo URL_ROOT; ?>/user/by-role?role=operator" class="btn btn-outline-primary">Operadores</a>
                                <a href="<?php echo URL_ROOT; ?>/user/by-role?role=technician" class="btn btn-outline-primary">Técnicos</a>
                                <a href="<?php echo URL_ROOT; ?>/user/by-role?role=client" class="btn btn-outline-primary">Clientes</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <?php if (isset($showInactive) && $showInactive): ?>
                                <a href="<?php echo URL_ROOT; ?>/users" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye"></i> Mostrar solo activos
                                </a>
                            <?php else: ?>
                                <a href="<?php echo URL_ROOT; ?>/users?includeInactive=1" class="btn btn-outline-secondary">
                                    <i class="bi bi-eye-slash"></i> Mostrar inactivos
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Tabla de usuarios -->
                    <?php if (empty($users)): ?>
                        <div class="alert alert-info">No hay usuarios para mostrar</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): 
                                        // Determinar rol basado en el email
                                        $role = 'Cliente';
                                        $badgeClass = 'bg-secondary';
                                        
                                        // Usar correo en vez de email
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
                                        $nombre = isset($user['nombre_completo']) ? $user['nombre_completo'] : (isset($user['name']) ? $user['name'] : '?');
                                        $email = isset($user['correo']) ? $user['correo'] : (isset($user['email']) ? $user['email'] : '?');
                                        $ultimo_acceso = isset($user['ultimo_acceso']) ? $user['ultimo_acceso'] : (isset($user['last_login']) ? $user['last_login'] : null);
                                    ?>
                                    <tr class="<?php echo $status == 'Inactivo' ? 'table-danger' : ''; ?>">
                                        <td><?php echo $id; ?></td>
                                        <td><?php echo $nombre; ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><span class="badge <?php echo $badgeClass; ?>"><?php echo $role; ?></span></td>
                                        <td><span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                                        <td>
                                            <?php 
                                                echo $ultimo_acceso ? date('d/m/Y H:i', strtotime($ultimo_acceso)) : 'Nunca';
                                            ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo URL_ROOT; ?>/users/verDetalle?id=<?php echo $id; ?>" 
                                                   class="btn btn-info" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo URL_ROOT; ?>/users/edit?id=<?php echo $id; ?>" 
                                                   class="btn btn-primary" title="Editar usuario">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <?php if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@solufiber-srl.com'): ?>
                                                <a href="<?php echo URL_ROOT; ?>/users/manageRoles?id=<?php echo $id; ?>" 
                                                   class="btn btn-secondary" title="Gestionar Roles">
                                                    <i class="bi bi-person-badge"></i>
                                                </a>
                                                <?php endif; ?>
                                                
                                                <?php if ($status == 'Activo' && $role !== 'Administrador'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/users/delete?id=<?php echo $id; ?>" 
                                                       class="btn btn-warning" title="Desactivar usuario"
                                                       onclick="return confirm('¿Está seguro de desactivar este usuario?')">
                                                        <i class="bi bi-person-x"></i>
                                                    </a>
                                                <?php elseif ($status == 'Inactivo'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/users/activate?id=<?php echo $id; ?>" 
                                                       class="btn btn-success" title="Activar usuario"
                                                       onclick="return confirm('¿Está seguro de activar este usuario?')">
                                                        <i class="bi bi-person-check"></i>
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div> 
</div> 