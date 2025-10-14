# Footer Contact Block

Bloque de información de contacto que obtiene los datos desde la página de Opciones de ACF.

## Características

-   **Datos centralizados**: Información desde ACF Options
-   **Información completa**: Teléfono, WhatsApp, email, dirección, horarios
-   **Enlaces automáticos**: Tel, mailto y WhatsApp funcionales
-   **Google Maps**: Integración con enlace a ubicación
-   **Condicional**: Solo se muestra si hay datos configurados

## Uso

1. Configurar datos de contacto en "Opciones" del admin
2. Añadir el bloque "Footer · Contacto" donde se necesite
3. El bloque mostrará automáticamente toda la información disponible
4. No requiere configuración adicional en el bloque

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   Campos en `group_options.json` (en /acf-json)

## Campos ACF (desde Opciones)

-   **Phone**: Teléfono principal
-   **WhatsApp**: Número de WhatsApp
-   **Email**: Email de contacto
-   **Address**: Dirección física
-   **City**: Ciudad
-   **Province**: Provincia/Estado
-   **Postal Code**: Código postal
-   **Google Maps Link**: Enlace a Google Maps
-   **Opening Hours**: Horarios de apertura (WYSIWYG)

## Funcionalidad

-   **Normalización de teléfonos**: Formato automático para enlaces tel:
-   **WhatsApp**: Enlace directo a chat de WhatsApp
-   **Email**: Enlace mailto automático
-   **Dirección completa**: Combinación de dirección, ciudad, provincia y CP
-   **Condicional**: Solo muestra elementos con datos

## Casos de uso

-   Footer de sitios web
-   Páginas de contacto
-   Información corporativa
-   Datos de sucursales
-   Información de atención al cliente

## Ventajas

-   **Mantenimiento centralizado**: Un solo lugar para actualizar datos
-   **Reutilizable**: Mismo bloque en múltiples ubicaciones
-   **Consistencia**: Misma información en todo el sitio
-   **Fácil actualización**: Sin necesidad de editar múltiples páginas
