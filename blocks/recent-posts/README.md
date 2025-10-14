# Recent Posts Block

Bloque simple que muestra automáticamente los posts más recientes del blog con imagen destacada.

## Características

-   **Automático**: No requiere selección manual de posts
-   **Configurable**: Permite elegir entre 3 o 4 posts
-   **Responsive**: Se adapta a diferentes tamaños de pantalla
-   **Optimizado**: Solo muestra posts con imagen destacada
-   **Estilizado**: Diseño moderno con efectos hover

## Uso

1. Añadir el bloque "Recent Posts" en el editor de Gutenberg
2. Seleccionar el número de posts a mostrar (3 o 4)
3. El bloque mostrará automáticamente los posts más recientes

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `editor.css` - Estilos del editor
-   `group_recent_posts_block.json` - Campos ACF (en /acf-json)

## Campos ACF

-   **Número de posts** (posts_count): Selector entre 3 o 4 posts

## Diseño

-   Grid responsivo que se adapta según el número de posts
-   Imagen destacada con efecto hover
-   Meta información (fecha y categoría)
-   Título con limitación de líneas
-   Excerpt truncado
-   Enlace "Leer más" con animación

## CSS Variables utilizadas

-   Colores del sistema Habitat UI
-   Variables de espaciado del tema
-   Breakpoints responsivos estándar
