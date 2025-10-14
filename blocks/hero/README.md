# Hero Block

Bloque hero versátil con múltiples estilos y opciones de personalización para crear secciones de encabezado impactantes.

## Características

-   **Tres estilos distintos**: Centrado, Split (texto + imagen), Cover + Overlay
-   **Múltiples tipos de fondo**: Sin fondo, imagen o vídeo
-   **Contenido estructurado**: Tagline, título, subtítulo, descripción y botones
-   **Alineación flexible**: Vertical (arriba, centro, abajo) y horizontal personalizable
-   **Responsive**: Adaptación automática a diferentes dispositivos

## Uso

1. Añadir el bloque "Hero" en el editor
2. Seleccionar estilo deseado (Centrado/Split/Overlay)
3. Configurar contenido (tagline, título, subtítulo, texto)
4. Añadir media (imagen o vídeo) según el estilo
5. Configurar botones primario y secundario (opcional)
6. Ajustar espaciado y alineación

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `editor.css` - Estilos del editor
-   `group_hero.json` - Campos ACF (en /acf-json)

## Campos ACF

### Contenido básico

-   **Tagline**: Texto pequeño encima del título
-   **Title**: Título principal del hero
-   **Subtitle**: Subtítulo secundario
-   **Text**: Descripción del hero (WYSIWYG)

### Configuración global

-   **Padding Y**: Espaciado vertical (sm/md/lg)
-   **Vertical Align**: Alineación vertical (top/center/bottom)

### Media

-   **Background Type**: Tipo de fondo (none/image/video)
-   **Background Image**: Imagen de fondo
-   **Background Video**: Vídeo de fondo

### Botones

-   **Primary Button**: Botón principal con configuración de estilo
-   **Secondary Button**: Botón secundario (opcional)

### Específico por estilo

-   **Split Position**: Posición del contenido en estilo Split
-   **Content Align**: Alineación del contenido en estilo Overlay
-   **Overlay**: Configuración de overlay para estilo Cover

## Estilos disponibles

### Centrado (por defecto)

-   Contenido centrado en la página
-   Fondo opcional (imagen o vídeo)
-   Ideal para páginas principales

### Split (Texto + Imagen)

-   Diseño de dos columnas
-   Imagen/vídeo en una columna, contenido en otra
-   Posición configurable (izquierda/derecha)

### Cover + Overlay

-   Imagen/vídeo de fondo obligatorio
-   Overlay con opacidad ajustable
-   Contenido superpuesto centrado o a la izquierda

## Casos de uso

-   **Homepage**: Sección principal de bienvenida
-   **Landing pages**: Encabezados promocionales
-   **Páginas de servicios**: Introducción con impacto visual
-   **Páginas de producto**: Presentación destacada
-   **Páginas institucionales**: Bienvenida corporativa

## Características técnicas

-   **Responsive**: Grid que se adapta en móviles
-   **Performance**: Lazy loading para imágenes y vídeos
-   **Accesibilidad**: Estructura semántica correcta
-   **SEO**: Etiquetas HTML apropiadas para los títulos
