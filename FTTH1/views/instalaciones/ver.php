                            <a href="<?php echo URL_ROOT; ?>/instalaciones/editar/<?php echo $data['instalacion']->id_instalacion; ?>" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="<?php echo URL_ROOT; ?>/instalaciones/eliminar/<?php echo $data['instalacion']->id_instalacion; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('¿Está seguro de eliminar esta instalación?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a> 