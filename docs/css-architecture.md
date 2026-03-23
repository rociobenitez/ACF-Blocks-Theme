# CSS Architecture

Guía de arquitectura CSS para mantener consistencia entre proyectos.

## Principio fundamental

> **`theme.json` es la fuente única de verdad** para todos los design tokens (colores, font-sizes, spacing, sombras, radius).

WordPress genera automáticamente variables CSS desde theme.json:

| Origen en theme.json               | Variable CSS generada               |
| ---------------------------------- | ----------------------------------- |
| `settings.color.palette`           | `--wp--preset--color--{slug}`       |
| `settings.typography.fontSizes`    | `--wp--preset--font-size--{slug}`   |
| `settings.typography.fontFamilies` | `--wp--preset--font-family--{slug}` |
| `settings.spacing.spacingSizes`    | `--wp--preset--spacing--{slug}`     |
| `settings.custom.*`                | `--wp--custom--{key}--{subkey}`     |

**Regla**: nunca redefinir estos valores en CSS. Usarlos directamente.

## Dónde vive cada cosa

### `theme.json`

- Paleta de colores completa
- Familias tipográficas y font-sizes
- Escala de spacing
- Sombras, border-radius, motion (via `settings.custom`)
- Containers (via `settings.custom`)
- Layout (contentSize, wideSize)
- Estilos globales: body, headings, links, buttons
- Estilos de bloques core (paragraph, list, code, quote, navigation, etc.)
- CSS inline para `.wp-site-blocks`, `.container`, `.alignleft/right/center`

### `assets/css/main.css`

Solo tokens y estilos que **NO se pueden expresar en theme.json**:

- Font weight tokens (`--fw-regular` a `--fw-bold`)
- Line height tokens (`--lh-tight`, `--lh-base`, `--lh-relaxed`)
- Letter spacing tokens (`--ls-base`, `--ls-wide`, etc.)
- Layout spacing con `clamp()` (`--flow-space`, `--component-spacing`, etc.)
- Colores semánticos (success, warning, error, info)
- Z-index scale
- Transiciones complejas (`--transition-btn`)
- Aliases de radius por componente
- WordPress core utilities (`.alignnone`, `.wp-caption`, `.screen-reader-text`)
- Estilos de componentes: buttons (.btn--\*), navbar, footer, header-section
- Media queries responsive

### `assets/css/blog.css`

- Estilos específicos del blog: post cards, sidebar, categorías
- Se carga condicionalmente solo en páginas de blog

### `assets/css/editor.css`

- Importa `main.css`
- Ajustes específicos del editor de bloques
- Placeholders, focus states, tipografía de código

### `assets/css/components/*.css`

- Componentes reutilizables con su propio archivo CSS
- Ejemplo: `team-member-card.css`

### `blocks/{nombre}/style.css`

- Estilos frontend de cada bloque ACF
- Se cargan automáticamente por WordPress cuando el bloque se usa

### `blocks/{nombre}/editor.css`

- Ajustes específicos del editor para cada bloque

### `styles/colors/*.json`

- Variaciones de paleta de colores
- Redefinen los mismos slugs que `theme.json`

### `styles/typography/*.json`

- Variaciones tipográficas
- Solo sobrescriben `fontFamilies`, nunca `fontSizes`

## Convenciones CSS

### Nomenclatura BEM

```css
.block-name {
} /* Bloque */
.block-name__element {
} /* Elemento */
.block-name--modifier {
} /* Modificador */
```

### Variables: qué usar dónde

```css
/* CORRECTO — usar --wp--preset--* directamente */
color: var(--wp--preset--color--primary);
font-size: var(--wp--preset--font-size--16);
padding: var(--wp--preset--spacing--24);
border-radius: var(--wp--custom--radius--8);
box-shadow: var(--wp--custom--shadows--200);

/* CORRECTO — usar tokens CSS-only para lo que no está en theme.json */
font-weight: var(--fw-semibold);
line-height: var(--lh-tight);
letter-spacing: var(--ls-wide);
z-index: var(--z-modal);
transition: var(--transition-btn);

/* INCORRECTO — nunca hardcodear valores que tienen token */
color: #1e293b; /* ❌ usar var(--wp--preset--color--primary) */
font-size: 1rem; /* ❌ usar var(--wp--preset--font-size--16) */
padding: 1.5rem; /* ❌ usar var(--wp--preset--spacing--24) */
border-radius: 0.5rem; /* ❌ usar var(--wp--custom--radius--8) */
```

### Reglas para nuevos estilos

1. **Busca primero en theme.json** si el valor ya existe como token
2. **Usa `--wp--preset--*`** para colores, font-sizes, spacing
3. **Usa `--wp--custom--*`** para sombras, radius, motion, containers
4. **Usa tokens CSS-only** de main.css para font-weights, line-heights, letter-spacing, z-index
5. **Nunca añadas alias** que simplemente renombren una variable de WordPress
6. **Fallbacks**: no uses fallbacks para variables del palette — siempre deben estar definidas

### Reglas para nuevos bloques

1. Crea `blocks/{nombre}/style.css` con estilos BEM
2. Usa solo variables `--wp--preset--*`, `--wp--custom--*`, y tokens CSS-only
3. Si el bloque necesita ajustes de editor, crea `blocks/{nombre}/editor.css`
4. No repitas estilos que ya están en `main.css` o `theme.json`

## Carga de assets

```
Frontend:
  ├── theme.json → WordPress genera CSS con --wp--preset--* y --wp--custom--*
  ├── assets/css/main.css → siempre cargado
  ├── assets/css/blog.css → solo en páginas de blog
  └── blocks/*/style.css → cuando se usa el bloque

Editor:
  ├── theme.json → WordPress aplica styles en el iframe
  ├── assets/css/editor.css → importa main.css
  └── blocks/*/editor.css → cuando se edita el bloque
```

## Breakpoints

| Breakpoint | Media query            | Uso                  |
| ---------- | ---------------------- | -------------------- |
| Mobile     | default (mobile-first) | Base styles          |
| Tablet     | `min-width: 600px`     | Layout de 2 columnas |
| Desktop sm | `min-width: 782px`     | Navbar completa      |
| Desktop    | `min-width: 1024px`    | Container lg         |
| Desktop lg | `min-width: 1280px`    | Container xl         |
| Desktop xl | `min-width: 1536px`    | Container 2xl        |
