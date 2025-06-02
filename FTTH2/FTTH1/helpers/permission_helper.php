<?php
/**
 * Verifica si el usuario actual tiene un permiso específico
 * @param string $permiso Nombre del permiso a verificar
 * @return bool
 */
function tienePermiso($permiso) {
    // Si no hay sesión de usuario, no tiene permisos
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    // Si es administrador, tiene todos los permisos
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        return true;
    }

    // Si es técnico, tiene permisos específicos
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'tecnico') {
        $permisosTecnico = [
            'ver_cajas_nap',
            'crear_cajas_nap',
            'editar_cajas_nap'
        ];
        return in_array($permiso, $permisosTecnico);
    }

    // Por defecto, no tiene permisos
    return false;
} 