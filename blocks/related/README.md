# Related Content Block

Bloque versátil para mostrar contenido relacionado en formato de cuadrícula o carrusel con múltiples opciones de configuración.

## Características

-   **Dos modos de display**: Grid estático o carrusel interactivo
-   **Selección de contenido**: Manual o automática
-   **Configuración flexible**: Número de elementos por fila, aspectos de imagen
-   **Carrusel avanzado**: Controles, autoplay, temporización personalizable
-   **Estilos múltiples**: Default, cards con sombra, minimalista

## Uso

1. Añadir el bloque "Contenido Relacionado" en el editor
2. Configurar cabecera (tagline, título, descripción)
3. Seleccionar modo (manual/automático) y tipo de contenido
4. Elegir layout (grid/carrusel) y elementos por fila
5. Configurar opciones de carrusel si aplica
6. Añadir CTA "Ver todo" (opcional)

## Archivos incluidos

-   `block.json` - Configuración del bloque
-   `render.php` - Template de renderizado
-   `style.css` - Estilos del frontend
-   `script.js` - Funcionalidad del carrusel
-   `group_related.json` - Campos ACF (en /acf-json)

## Campos ACF

### Cabecera

-   **Tagline**: Texto pequeño encima del título
-   **Title**: Título principal de la sección
-   **Tag Title**: Etiqueta HTML del título (h1-h6)
-   **Description**: Descripción de la sección

### Contenido

-   **Source Mode**: Modo de selección (manual/automatic)
-   **Related**: Selector de contenido (posts, páginas, CPTs)
-   **Layout Mode**: Tipo de layout (grid/carousel)
-   **Items Per Row**: Elementos por fila (1-4)
-   **Image Aspect Ratio**: Proporción de las imágenes

### Carrusel

-   **Show Carousel Controls**: Mostrar controles de navegación
-   **Enable Autoplay**: Activar reproducción automática
-   **Autoplay Delay**: Tiempo entre transiciones (ms)

### Estilo

-   **Padding Y**: Espaciado vertical (sm/md/lg/xl)
-   **See All CTA**: Botón "Ver todo" con enlace

## Modos de layout

### Grid

-   Cuadrícula estática responsive
-   Configuración de 1-4 columnas
-   Se adapta automáticamente en móviles

### Carrusel

-   Solo activo si hay más elementos que items_per_row
-   Controles de navegación opcionales
-   Autoplay configurable
-   Touch/swipe en dispositivos móviles

## Estilos disponibles

-   **Default**: Estilo por defecto limpio
-   **Cards**: Tarjetas con sombra y bordes redondeados
-   **Minimal**: Diseño minimalista sin bordes

## Casos de uso

-   **Blog relacionado**: Posts relacionados al final de artículos
-   **Portfolio**: Proyectos o trabajos relacionados
-   **Productos**: Items relacionados en e-commerce
-   **Servicios**: Servicios complementarios
-   **Testimonios**: Reseñas o casos de éxito

## Funcionalidad JavaScript

-   **Carrusel responsivo**: Adaptación automática del número de slides
-   **Touch/swipe**: Navegación táctil en móviles
-   **Autoplay inteligente**: Se pausa al hacer hover
-   **Controles accesibles**: Navegación por teclado
-   **Performance**: Lazy loading de imágenes
