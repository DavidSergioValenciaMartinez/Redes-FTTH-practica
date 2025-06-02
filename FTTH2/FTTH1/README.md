# FiberNet Pro - Sistema de Gestión de Redes FTTH

FiberNet Pro es un sistema para la gestión y monitoreo de redes de fibra óptica FTTH, desarrollado con PHP siguiendo el patrón de arquitectura Modelo-Vista-Controlador (MVC).

## Características

- Monitoreo en tiempo real de redes FTTH
- Gestión de equipos, splitters y ONUs
- Calculadora de pérdidas ópticas
- Sistema de soporte técnico integrado
- Panel de administración completo
- Diseño responsive y moderno

## Requisitos del Sistema

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web Apache/Nginx
- Extensiones PHP: PDO, MySQLi, JSON

## Instalación

1. Clonar el repositorio:
   ```
   git clone https://github.com/tuusuario/fibernet-pro.git
   ```

2. Crear una base de datos MySQL para la aplicación.

3. Configurar el archivo `config/config.php` con los detalles de conexión a la base de datos y otros ajustes.

4. Importar la estructura de la base de datos desde el archivo `database.sql` (pendiente de creación).

5. Configurar el servidor web para que el directorio raíz apunte a la carpeta del proyecto.

6. Asegúrese de que el servidor web tenga permisos de escritura en las carpetas:
   - `uploads/`
   - `logs/`

## Estructura del Proyecto (MVC)

El proyecto está estructurado siguiendo el patrón MVC:

- **Modelos (`models/`)**: Contienen la lógica de negocio y acceso a datos.
- **Vistas (`views/`)**: Archivos de presentación organizados por secciones.
- **Controladores (`controllers/`)**: Gestionan las solicitudes y coordinan la aplicación.
- **Configuración (`config/`)**: Archivos de configuración y rutas.
- **Archivos públicos (`public/`)**: CSS, JavaScript e imágenes.

## Uso

1. Acceda a la aplicación a través de su navegador web:
   ```
   http://localhost/FTTH1/
   ```

2. Para el primer acceso, utilice las credenciales de administrador:
   - Usuario: `admin@example.com`
   - Contraseña: `password`

3. Es recomendable cambiar la contraseña predeterminada inmediatamente después del primer inicio de sesión.

## Personalización

El sistema está diseñado para ser fácilmente personalizable:

- Los estilos se encuentran en `public/css/styles.css`
- El JavaScript principal está en `public/js/main.js`
- Las vistas se pueden modificar en la carpeta `views/`

## Contribuir

Si desea contribuir al proyecto, por favor:

1. Haga un fork del repositorio
2. Cree una rama para su característica (`git checkout -b feature/nueva-caracteristica`)
3. Realice sus cambios y haga commit (`git commit -am 'Añadir nueva característica'`)
4. Envíe los cambios (`git push origin feature/nueva-caracteristica`)
5. Abra un Pull Request

## Licencia

Este proyecto está licenciado bajo la Licencia MIT - vea el archivo LICENSE para más detalles.

## Contacto

Para preguntas o soporte, por favor contacte a [su-email@ejemplo.com]. 