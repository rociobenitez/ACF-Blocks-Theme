# Theme Customization

Guía para adaptar el starter theme a un nuevo proyecto.

## Checklist de personalización

Al empezar un nuevo proyecto, sigue estos pasos en orden:

- [ ] Cambiar paleta de colores en `theme.json`
- [ ] Elegir preset tipográfico o definir fuentes custom
- [ ] Ajustar logo y favicon
- [ ] Actualizar `style.css` (nombre del theme, autor, descripción)
- [ ] Actualizar colores semánticos en `assets/css/main.css` si es necesario
- [ ] Configurar bloques ACF necesarios
- [ ] Eliminar bloques y templates que no se usen
- [ ] Verificar variaciones de estilo

## 1. Cambiar la paleta de colores

Edita `theme.json > settings.color.palette`. Mantén los **mismos slugs** y cambia solo los valores hex:

```json
{
  "settings": {
    "color": {
      "palette": [
        {
          "name": "Primary",
          "slug": "primary",
          "color": "#TU_COLOR"
        },
        {
          "name": "Primary Dark",
          "slug": "primary-dark",
          "color": "#TU_COLOR"
        },
        {
          "name": "Accent",
          "slug": "accent",
          "color": "#TU_COLOR"
        },
        ...
      ]
    }
  }
}
```

**Importante**: No cambies los slugs. Todo el CSS del theme depende de estos nombres:

- `white`, `black`, `bg`, `bg-secondary`, `bg-dark`
- `primary`, `primary-dark`, `accent`
- `text`, `text-body`, `text-heading`, `text-muted`
- `border`

Si añades colores nuevos, usa slugs semánticos (ej: `secondary`, `highlight`).

### Actualizar variaciones de color

Después de cambiar la paleta base, actualiza las variaciones en `styles/colors/`:

- `01-light.json` — mismos colores que la paleta base
- `02-dark.json` — inversión oscura de los colores
- `03-neutral.json` — variación neutra/corporativa

## 2. Elegir/Cambiar tipografía

### Opción A: Usar un preset existente

El theme incluye 4 presets tipográficos en `styles/typography/`. Selecciona uno desde:
**Apariencia → Editor → Estilos → Tipografía**

| Preset          | Fuentes                  | Estilo      |
| --------------- | ------------------------ | ----------- |
| Serif & Display | Beiruti + Literata       | Elegante    |
| Mono & Serif    | Fira Code + Vollkorn     | Técnico     |
| Sans & Display  | Ysabeau Office + Platypi | Moderno     |
| Slab & Sans     | Roboto Slab + Manrope    | Corporativo |

### Opción B: Definir fuentes custom

1. Añade los archivos `.woff2` en `assets/fonts/{nombre-fuente}/`
2. Edita `theme.json > settings.typography.fontFamilies`:

```json
{
	"name": "Mi Fuente",
	"slug": "primary",
	"fontFamily": "\"Mi Fuente\", sans-serif",
	"fontFace": [
		{
			"src": ["file:./assets/fonts/mi-fuente/MiFuente-Variable.woff2"],
			"fontWeight": "200 800",
			"fontStyle": "normal",
			"fontFamily": "Mi Fuente"
		}
	]
}
```

3. Si cambias las fuentes base (primary/secondary), los aliases en `main.css` (`--font-body`, `--font-heading`, `--font-display`) se actualizan automáticamente.

### Opción C: Crear un preset tipográfico nuevo

Crea un archivo JSON en `styles/typography/`:

```json
{
	"version": 3,
	"title": "Mi Preset",
	"settings": {
		"typography": {
			"fontFamilies": [
				// Define fontFamilies con fontFace
				// NO incluyas fontSizes — usa los del theme.json base
			]
		}
	}
}
```

## 3. Ajustar sombras, radius, motion

Edita `theme.json > settings.custom`:

```json
{
	"settings": {
		"custom": {
			"shadows": {
				"100": "0 1px 2px rgb(0 0 0 / 0.08)",
				"200": "0 2px 8px rgb(0 0 0 / 0.12)"
			},
			"radius": {
				"2": "0.125rem",
				"4": "0.25rem",
				"8": "0.5rem",
				"pill": "999px"
			},
			"motion": {
				"duration": {
					"fast": "120ms",
					"base": "200ms",
					"slow": "320ms"
				}
			}
		}
	}
}
```

## 4. Añadir un nuevo bloque ACF

1. Crea el directorio: `blocks/{nombre-bloque}/`
2. Archivos necesarios:
    - `block.json` — Registro del bloque
    - `render.php` — Template de renderizado
    - `fields.php` — Campos ACF
    - `style.css` — Estilos frontend
    - `editor.css` — Estilos del editor (opcional)

3. En `style.css`, usa **solo tokens del sistema**:

```css
/* ✅ Correcto */
.mi-bloque {
	color: var(--wp--preset--color--text);
	font-size: var(--wp--preset--font-size--16);
	padding: var(--wp--preset--spacing--24);
	border-radius: var(--wp--custom--radius--8);
	transition: all var(--wp--custom--motion--duration--base)
		var(--wp--custom--motion--easing--standard);
}

/* ❌ Incorrecto */
.mi-bloque {
	color: #1a1a1a;
	font-size: 1rem;
	padding: 1.5rem;
}
```

## 5. Configurar layout

El layout se define en `theme.json > settings.custom.layout`:

```json
{
	"layout": {
		"contentMaxWidth": "800px",
		"contentMaxWidthWide": "900px",
		"contentMaxWidthFull": "1200px"
	}
}
```

Y en `settings.layout`:

```json
{
	"layout": {
		"contentSize": "var(--wp--custom--layout--content-max-width)",
		"wideSize": "var(--wp--custom--layout--content-max-width-wide)"
	}
}
```

## 6. Eliminar lo que no necesites

El starter theme incluye bloques, templates y patterns que pueden no ser necesarios en todos los proyectos:

- **Bloques**: elimina directorios de `blocks/` que no uses
- **Templates**: elimina archivos de `templates/` que no apliquen
- **Patterns**: elimina archivos de `patterns/` que no uses
- **Variaciones**: elimina presets de `styles/` que no necesites
- **Fuentes**: elimina directorios de `assets/fonts/` que no uses (reduce peso)

## 7. Documentación adicional

- **Style Guide**: `docs/style-guide.md` — Referencia completa de tokens
- **CSS Architecture**: `docs/css-architecture.md` — Dónde poner cada cosa
- **CLAUDE.md**: Convenciones de código y estructura del proyecto
- **ROADMAP.md**: Plan de desarrollo y estado de cada fase

### Dónde alojar la documentación

Recomendaciones para equipos:

1. **En el repositorio** (`docs/`): siempre actualizada con el código
2. **GitHub Wiki**: para documentación extendida, onboarding, tutoriales
3. **Storybook/Pattern Library**: para documentación visual de componentes (futuro)

El README.md del repositorio debe enlazar a `docs/` para acceso rápido.
