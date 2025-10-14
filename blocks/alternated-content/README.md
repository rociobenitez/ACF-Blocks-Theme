# Alternated Content Block

Bloque de contenido alternado que permite combinar imagen y texto con layout flexible.

## Características

-   **Layout flexible**: Imagen a la izquierda o derecha del texto
-   **Contenido completo**: Tagline, título, contenido y botones
-   **Alineación vertical**: Centro, arriba o abajo
-   **Estilos personalizables**: Default, imagen redondeada, con sombra
-   **Responsive**: Se adapta automáticamente a dispositivos móviles

## Uso

1. Añadir el bloque "Contenido Alternado" en el editor
2. Configurar imagen y su posición (izquierda/derecha)
3. Añadir contenido de texto (tagline, título, descripción)
4. Configurar botones primario y secundario (opcional)
5. Ajustar espaciado y alineación vertical

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `editor.css` - Estilos del editor
-   `group_alternated_content.json` - Campos ACF (en /acf-json)

## Campos ACF

-   **Tagline**: Texto pequeño encima del título
-   **Title**: Título principal de la sección
-   **Content**: Contenido descriptivo (WYSIWYG)
-   **Image**: Imagen destacada de la sección
-   **Image Position**: Posición de la imagen (izquierda/derecha)
-   **Primary Button**: Botón principal con estilos configurables
-   **Secondary Button**: Botón secundario (opcional)
-   **Padding Y**: Espaciado vertical (sm/md/lg/xl)
-   **Vertical Align**: Alineación vertical del contenido

## Estilos disponibles

-   **Default**: Estilo por defecto
-   **Rounded**: Imagen con bordes redondeados
-   **Shadow**: Con sombra en la tarjeta

## Responsive

En dispositivos móviles, la imagen se muestra siempre arriba del contenido independientemente de la configuración de posición.
