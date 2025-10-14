# CTA Block

Bloque de llamada a la acción (Call to Action) con imagen de fondo, contenido centrado y botón prominente.

## Características

-   **Variantes de layout**: Imagen de fondo o imagen lateral
-   **Contenido estructurado**: Subtítulo, título, descripción y botón
-   **Etiquetas HTML personalizables**: Selección de etiqueta para el título (h1-h6)
-   **Estilos de botón**: Primario, secundario, outline
-   **Responsive**: Adaptación automática a diferentes pantallas

## Uso

1. Añadir el bloque "CTA" en el editor
2. Seleccionar variante de layout (background/lateral)
3. Cargar imagen de fondo o lateral
4. Configurar contenido (subtítulo, título, descripción)
5. Añadir enlace con estilo de botón deseado
6. Seleccionar etiqueta HTML apropiada para el título

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `editor.css` - Estilos del editor
-   `group_cta.json` - Campos ACF (en /acf-json)

## Campos ACF

-   **Layout Variant**: Variante de diseño (background/lateral)
-   **Image**: Imagen principal del CTA
-   **Subheading**: Texto secundario encima del título
-   **Heading**: Título principal del CTA
-   **Heading Tag**: Etiqueta HTML del título (h1, h2, h3, h4, h5, h6)
-   **Body**: Contenido descriptivo (WYSIWYG)
-   **Link**: Enlace del botón de acción
-   **Link Style**: Estilo del botón (primary/secondary/outline)

## Variantes de layout

-   **Background**: Imagen de fondo con contenido superpuesto
-   **Lateral**: Imagen al lado del contenido

## Estilos disponibles

-   **Default**: Estilo por defecto
-   **Rounded**: Imagen con bordes redondeados
-   **Shadow**: Con sombra en el contenedor

## Casos de uso

-   Promoción de servicios o productos
-   Invitación a descargas
-   Registro en newsletters
-   Contacto comercial
-   Conversión de leads
