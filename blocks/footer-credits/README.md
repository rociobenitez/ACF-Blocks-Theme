# Footer Credits Block

Bloque simple que muestra la línea de copyright con el año actual y nombre de la empresa.

## Características

-   **Copyright automático**: Año actual dinámico
-   **Nombre de empresa**: Desde constante ST_COMPANY_NAME o título del sitio
-   **Sin configuración**: No requiere campos ACF
-   **Texto localizable**: Preparado para traducción
-   **Minimalista**: Diseño limpio y simple

## Uso

1. Añadir el bloque "Footer · Créditos" en el footer
2. Se mostrará automáticamente con el formato: © 2025 Empresa. Todos los derechos reservados.
3. No requiere configuración adicional

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend

## Lógica del bloque

-   **Año**: Se obtiene automáticamente con `wp_date('Y')`
-   **Empresa**:
    -   Prioridad 1: Constante `ST_COMPANY_NAME`
    -   Prioridad 2: `get_bloginfo('name')` (título del sitio)
-   **Texto**: Localizable con función `esc_html_e()`

## Configuración

Para personalizar el nombre de la empresa, definir la constante en `wp-config.php`:

```php
define('ST_COMPANY_NAME', 'Mi Empresa S.L.');
```

## Casos de uso

-   Footer de sitios web
-   Líneas de copyright
-   Información legal básica
-   Créditos corporativos

## Ventajas

-   **Automático**: Sin mantenimiento manual del año
-   **Flexible**: Funciona con o sin configuración
-   **Estándar**: Formato de copyright universalmente reconocido
-   **Ligero**: Sin dependencias ni campos complejos
