<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <?php 
                            $roleTitle = 'Usuarios';
                            switch ($currentRole) {
                                case 'admin':
                                    $roleTitle = 'Administradores';
                                    break;
                                case 'operator':
                                    $roleTitle = 'Operadores';
                                    break;
                                case 'technician':
                                    $roleTitle = 'Técnicos';
                                    break;
                                case 'client':
                                    $roleTitle = 'Clientes';
                                    break;
                            }
                            echo $roleTitle;
                        ?>
                    </h4>
                    <a href="<?php echo URL_ROOT; ?>/users" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Volver
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
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
                                <a href="<?php echo URL_ROOT; ?>/users/by-role?role=admin" class="btn btn-outline-primary <?php echo $currentRole === 'admin' ? 'active' : ''; ?>">Administradores</a>
                                <a href="<?php echo URL_ROOT; ?>/users/by-role?role=operator" class="btn btn-outline-primary <?php echo $currentRole === 'operator' ? 'active' : ''; ?>">Operadores</a>
                                <a href="<?php echo URL_ROOT; ?>/users/by-role?role=technician" class="btn btn-outline-primary <?php echo $currentRole === 'technician' ? 'active' : ''; ?>">Técnicos</a>
                                <a href="<?php echo URL_ROOT; ?>/users/by-role?role=client" class="btn btn-outline-primary <?php echo $currentRole === 'client' ? 'active' : ''; ?>">Clientes</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="<?php echo URL_ROOT; ?>/users/create" class="btn btn-primary">
                                <i class="bi bi-person-plus-fill"></i> Nuevo Usuario
                            </a>
                        </div>
                    </div>
                    
                    <!-- Tabla de usuarios -->
                    <?php if (empty($users)): ?>
                        <div class="alert alert-info">No hay usuarios para mostrar en esta categoría</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Último Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): 
                                        // Determinar estado
                                        $status = isset($user['active']) && $user['active'] == 1 ? 'Activo' : 'Inactivo';
                                        $statusClass = $status == 'Activo' ? 'bg-success' : 'bg-danger';
                                        
                                        // Determinar si es administrador
                                        $isAdmin = strpos($user['email'], 'admin@solufiber-srl.com') !== false;
                                    ?>
                                    <tr class="<?php echo $status == 'Inactivo' ? 'table-danger' : ''; ?>">
                                        <td><?php echo $user['id']; ?></td>
                                        <td><?php echo $user['name']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><span class="badge <?php echo $statusClass; ?>"><?php echo $status; ?></span></td>
                                        <td>
                                            <?php 
                                                echo isset($user['last_login']) ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Nunca';
                                            ?>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo URL_ROOT; ?>/users/view?id=<?php echo $user['id']; ?>" 
                                                   class="btn btn-info" title="Ver detalles">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?php echo URL_ROOT; ?>/users/edit?id=<?php echo $user['id']; ?>" 
                                                   class="btn btn-primary" title="Editar usuario">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <?php if ($status == 'Activo' && !$isAdmin): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/users/deactivate?id=<?php echo $user['id']; ?>" 
                                                       class="btn btn-warning" title="Desactivar usuario"
                                                       onclick="return confirm('¿Está seguro de desactivar este usuario?')">
                                                        <i class="bi bi-person-x"></i>
                                                    </a>
                                                <?php elseif ($status == 'Inactivo'): ?>
                                                    <a href="<?php echo URL_ROOT; ?>/users/activate?id=<?php echo $user['id']; ?>" 
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