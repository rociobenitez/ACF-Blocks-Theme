# FAQs Block

Bloque de preguntas frecuentes con funcionalidad de acordeón accesible y múltiples variantes de diseño.

## Características

-   **Acordeón accesible**: Solo una pregunta abierta a la vez
-   **Múltiples variantes**: Simple, con imagen a la izquierda o derecha
-   **Contenido estructurado**: Tagline, título, descripción e items
-   **Etiquetas personalizables**: Selección de etiquetas HTML para títulos
-   **JavaScript nativo**: Funcionalidad de acordeón sin dependencias

## Uso

1. Añadir el bloque "FAQs" en el editor
2. Configurar cabecera (tagline, título, descripción)
3. Añadir preguntas y respuestas en el repeater
4. Seleccionar variante de diseño (simple/imagen izquierda/derecha)
5. Configurar etiquetas HTML apropiadas

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `script.js` - Funcionalidad del acordeón
-   `group_faqs.json` - Campos ACF (en /acf-json)

## Campos ACF

-   **Media**: Imagen para variantes con media
-   **Tagline**: Texto pequeño encima del título
-   **Title**: Título principal de la sección
-   **Tag Title**: Etiqueta HTML del título (h1-h6)
-   **Tag FAQ**: Etiqueta HTML de las preguntas (h1-h6)
-   **Description**: Descripción de la sección
-   **Items**: Repeater con preguntas y respuestas
    -   **Question**: Pregunta del FAQ
    -   **Answer**: Respuesta (WYSIWYG)

## Variantes de estilo

-   **Simple**: Solo texto, sin imagen (por defecto)
-   **Imagen Izquierda**: Imagen al lado izquierdo del contenido
-   **Imagen Derecha**: Imagen al lado derecho del contenido

## Funcionalidad JavaScript

-   **Acordeón accesible**: Manejo de estados aria-expanded
-   **Teclado**: Navegación con Enter y Espacio
-   **Auto-cierre**: Solo una pregunta abierta simultáneamente
-   **Animaciones**: Transiciones suaves en la apertura/cierre

## Casos de uso

-   Secciones de ayuda y soporte
-   Preguntas sobre productos/servicios
-   Información técnica detallada
-   Proceso de compra o contratación
-   Políticas y términos de uso
