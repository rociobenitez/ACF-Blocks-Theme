# Form Block

Bloque de formulario de contacto integrado con Gravity Forms y contenido promocional.

## Características

-   **Integración con Gravity Forms**: Selector de formulario por ID
-   **Layout flexible**: Variantes de fondo e imagen lateral
-   **Contenido estructurado**: Subtítulo, título, descripción y formulario
-   **Ajax**: Envío de formulario sin recarga de página
-   **Responsive**: Adaptación automática a diferentes dispositivos

## Uso

1. Añadir el bloque "Formulario" en el editor
2. Seleccionar variante de layout (background/text-left/text-right)
3. Cargar imagen de fondo o lateral
4. Configurar contenido (subtítulo, título, descripción)
5. Seleccionar ID del formulario de Gravity Forms
6. Configurar etiqueta HTML apropiada para el título

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `editor.css` - Estilos del editor
-   `group_form.json` - Campos ACF (en /acf-json)

## Campos ACF

-   **Layout Variant**: Variante de diseño (background/text-left/text-right)
-   **Image**: Imagen principal del bloque
-   **Subheading**: Texto secundario encima del título
-   **Heading**: Título principal del formulario
-   **Heading Tag**: Etiqueta HTML del título (h1-h6)
-   **Body**: Contenido descriptivo (WYSIWYG)
-   **Form ID**: ID del formulario de Gravity Forms

## Variantes de layout

-   **Background**: Imagen de fondo con contenido superpuesto
-   **Text Left**: Formulario a la derecha, contenido a la izquierda
-   **Text Right**: Formulario a la izquierda, contenido a la derecha

## Dependencias

-   **Gravity Forms**: Plugin requerido para la funcionalidad del formulario
-   **Ajax**: Formularios configurados para envío asíncrono

## Estilos disponibles

-   **Default**: Estilo por defecto
-   **Rounded**: Imagen con bordes redondeados
-   **Shadow**: Con sombra en el contenedor

## Casos de uso

-   Formularios de contacto
-   Solicitudes de presupuesto
-   Registros de newsletter
-   Formularios de soporte
-   Contacto comercial

## Configuración

Para usar el bloque correctamente:

1. Instalar y activar Gravity Forms
2. Crear formulario en Gravity Forms
3. Anotar el ID del formulario
4. Configurar el ID en el campo Form ID del bloque
