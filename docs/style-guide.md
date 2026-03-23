# Style Guide

Referencia completa de design tokens y convenciones de estilo.

<div class="callout callout--tip">

**Fuente de verdad**: `theme.json` para todos los tokens base. Consulta `assets/css/main.css` solo para tokens que no se pueden expresar en JSON.

</div>

---

## Paleta de Colores

### Brand & UI

<div class="color-grid">
	<div class="color-card">
		<div class="color-card__preview" style="background:#FFFFFF; border-bottom: 1px solid #E2E8F0;"></div>
		<div class="color-card__info">
			<span class="color-card__name">White</span>
			<span class="color-card__hex">#FFFFFF</span>
			<span class="color-card__var">--wp--preset--color--white</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#000000;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Black</span>
			<span class="color-card__hex">#000000</span>
			<span class="color-card__var">--wp--preset--color--black</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#1E293B;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Primary</span>
			<span class="color-card__hex">#1E293B</span>
			<span class="color-card__var">--wp--preset--color--primary</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#0F172A;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Primary Dark</span>
			<span class="color-card__hex">#0F172A</span>
			<span class="color-card__var">--wp--preset--color--primary-dark</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#6366F1;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Accent</span>
			<span class="color-card__hex">#6366F1</span>
			<span class="color-card__var">--wp--preset--color--accent</span>
		</div>
	</div>
</div>

### Backgrounds

<div class="color-grid">
	<div class="color-card">
		<div class="color-card__preview" style="background:#FFFFFF; border-bottom: 1px solid #E2E8F0;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Background</span>
			<span class="color-card__hex">#FFFFFF</span>
			<span class="color-card__var">--wp--preset--color--bg</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#F8FAFC;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Background Secondary</span>
			<span class="color-card__hex">#F8FAFC</span>
			<span class="color-card__var">--wp--preset--color--bg-secondary</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#0F172A;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Background Dark</span>
			<span class="color-card__hex">#0F172A</span>
			<span class="color-card__var">--wp--preset--color--bg-dark</span>
		</div>
	</div>
</div>

### Text & Border

<div class="color-grid">
	<div class="color-card">
		<div class="color-card__preview" style="background:#0F172A;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Text</span>
			<span class="color-card__hex">#0F172A</span>
			<span class="color-card__var">--wp--preset--color--text</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#334155;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Text Body</span>
			<span class="color-card__hex">#334155</span>
			<span class="color-card__var">--wp--preset--color--text-body</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#0F172A;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Text Heading</span>
			<span class="color-card__hex">#0F172A</span>
			<span class="color-card__var">--wp--preset--color--text-heading</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#94A3B8;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Text Muted</span>
			<span class="color-card__hex">#94A3B8</span>
			<span class="color-card__var">--wp--preset--color--text-muted</span>
		</div>
	</div>
	<div class="color-card">
		<div class="color-card__preview" style="background:#E2E8F0;"></div>
		<div class="color-card__info">
			<span class="color-card__name">Border</span>
			<span class="color-card__hex">#E2E8F0</span>
			<span class="color-card__var">--wp--preset--color--border</span>
		</div>
	</div>
</div>

### Colores semánticos <small>(solo en CSS — `main.css`)</small>

Para estados de feedback: formularios, alertas, badges.

**Success**

<div class="semantic-row">
	<span class="semantic-chip" style="background:#f0fdf4"></span>
	<span class="semantic-chip" style="background:#dcfce7"></span>
	<span class="semantic-chip" style="background:#bbf7d0"></span>
	<span class="semantic-chip" style="background:#86efac"></span>
	<span class="semantic-chip" style="background:#4ade80"></span>
	<span class="semantic-chip" style="background:#22c55e"></span>
	<span class="semantic-chip" style="background:#16a34a"></span>
	<span class="semantic-chip" style="background:#15803d"></span>
	<span class="semantic-chip" style="background:#166534"></span>
	<span class="semantic-chip" style="background:#14532d"></span>
	<span class="semantic-chip" style="background:#052e16"></span>
</div>

`var(--color-success)` · `var(--color-success-light)` · `var(--color-success-dark)`

**Warning**

<div class="semantic-row">
	<span class="semantic-chip" style="background:#fffbeb"></span>
	<span class="semantic-chip" style="background:#fef3c7"></span>
	<span class="semantic-chip" style="background:#fde68a"></span>
	<span class="semantic-chip" style="background:#fcd34d"></span>
	<span class="semantic-chip" style="background:#fbbf24"></span>
	<span class="semantic-chip" style="background:#f59e0b"></span>
	<span class="semantic-chip" style="background:#d97706"></span>
	<span class="semantic-chip" style="background:#b45309"></span>
	<span class="semantic-chip" style="background:#92400e"></span>
	<span class="semantic-chip" style="background:#78350f"></span>
	<span class="semantic-chip" style="background:#451a03"></span>
</div>

`var(--color-warning)` · `var(--color-warning-light)` · `var(--color-warning-dark)`

**Error**

<div class="semantic-row">
	<span class="semantic-chip" style="background:#fff1f2"></span>
	<span class="semantic-chip" style="background:#ffe4e6"></span>
	<span class="semantic-chip" style="background:#fecdd3"></span>
	<span class="semantic-chip" style="background:#fda4af"></span>
	<span class="semantic-chip" style="background:#fb7185"></span>
	<span class="semantic-chip" style="background:#f43f5e"></span>
	<span class="semantic-chip" style="background:#e11d48"></span>
	<span class="semantic-chip" style="background:#be123c"></span>
	<span class="semantic-chip" style="background:#9f1239"></span>
	<span class="semantic-chip" style="background:#881337"></span>
	<span class="semantic-chip" style="background:#4c0519"></span>
</div>

`var(--color-error)` · `var(--color-error-light)` · `var(--color-error-dark)`

**Info**

<div class="semantic-row">
	<span class="semantic-chip" style="background:#f0f9ff"></span>
	<span class="semantic-chip" style="background:#e0f2fe"></span>
	<span class="semantic-chip" style="background:#bae6fd"></span>
	<span class="semantic-chip" style="background:#7dd3fc"></span>
	<span class="semantic-chip" style="background:#38bdf8"></span>
	<span class="semantic-chip" style="background:#0ea5e9"></span>
	<span class="semantic-chip" style="background:#0284c7"></span>
	<span class="semantic-chip" style="background:#0369a1"></span>
	<span class="semantic-chip" style="background:#075985"></span>
	<span class="semantic-chip" style="background:#0c4a6e"></span>
	<span class="semantic-chip" style="background:#082f49"></span>
</div>

`var(--color-info)` · `var(--color-info-light)` · `var(--color-info-dark)`

### Variaciones de color

<div class="variation-grid">
	<div class="variation-card">
		<div class="variation-card__header" style="background:#fff; color:#0F172A;">Light (default)</div>
		<div class="variation-card__colors">
			<div style="background:#FFFFFF"></div>
			<div style="background:#F8FAFC"></div>
			<div style="background:#1E293B"></div>
			<div style="background:#6366F1"></div>
			<div style="background:#0F172A"></div>
			<div style="background:#E2E8F0"></div>
		</div>
	</div>
	<div class="variation-card">
		<div class="variation-card__header" style="background:#0F172A; color:#F1F5F9;">Dark</div>
		<div class="variation-card__colors">
			<div style="background:#0F172A"></div>
			<div style="background:#1E293B"></div>
			<div style="background:#818CF8"></div>
			<div style="background:#A78BFA"></div>
			<div style="background:#F8FAFC"></div>
			<div style="background:#334155"></div>
		</div>
	</div>
	<div class="variation-card">
		<div class="variation-card__header" style="background:#fafafa; color:#18181B;">Neutral</div>
		<div class="variation-card__colors">
			<div style="background:#FAFAFA"></div>
			<div style="background:#F4F4F5"></div>
			<div style="background:#3F3F46"></div>
			<div style="background:#71717A"></div>
			<div style="background:#18181B"></div>
			<div style="background:#E4E4E7"></div>
		</div>
	</div>
</div>

---

## Tipografía

### Familias de fuentes

| Alias            | Fuente     | Variable CSS                           | Uso           |
| ---------------- | ---------- | -------------------------------------- | ------------- |
| `--font-body`    | Manrope    | `--wp--preset--font-family--primary`   | Texto general |
| `--font-heading` | Manrope    | `--wp--preset--font-family--primary`   | Headings      |
| `--font-display` | Montserrat | `--wp--preset--font-family--secondary` | Hero, display |
| `--font-mono`    | Fira Code  | `--wp--preset--font-family--monospace` | Code          |

### Escala de font-sizes

<div class="type-preview">
	<div class="type-preview__label">10px — 0.625rem</div>
	<div style="font-size:0.625rem; line-height:1.4;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">12px — 0.75rem</div>
	<div style="font-size:0.75rem; line-height:1.4;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">14px — 0.875rem</div>
	<div style="font-size:0.875rem; line-height:1.4;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">16px — 1rem (base)</div>
	<div style="font-size:1rem; line-height:1.4;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">18px — 1.125rem</div>
	<div style="font-size:1.125rem; line-height:1.4;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">20px — 1.25rem</div>
	<div style="font-size:1.25rem; line-height:1.3;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">24px — 1.5rem</div>
	<div style="font-size:1.5rem; line-height:1.3;">The quick brown fox jumps over the lazy dog</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">30px — 1.875rem</div>
	<div style="font-size:1.875rem; line-height:1.2;">The quick brown fox jumps</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">36px — 2.25rem</div>
	<div style="font-size:2.25rem; line-height:1.2;">The quick brown fox</div>
</div>
<div class="type-preview">
	<div class="type-preview__label">48px — 3rem</div>
	<div style="font-size:3rem; line-height:1.1;">The quick brown</div>
</div>

Todos disponibles como `var(--wp--preset--font-size--{slug})`. Slugs completos: `10`, `12`, `14`, `16`, `17`, `18`, `20`, `22`, `24`, `30`, `32`, `36`, `40`, `48`, `60`, `72`, `96`.

### Font weights <small>(solo CSS)</small>

| Token           | Valor | Preview                                             |
| --------------- | ----- | --------------------------------------------------- |
| `--fw-regular`  | 400   | <span style="font-weight:400">Texto regular</span>  |
| `--fw-medium`   | 500   | <span style="font-weight:500">Texto medium</span>   |
| `--fw-semibold` | 600   | <span style="font-weight:600">Texto semibold</span> |
| `--fw-bold`     | 700   | <span style="font-weight:700">Texto bold</span>     |

### Line heights <small>(solo CSS)</small>

| Token          | Valor | Uso                    |
| -------------- | ----- | ---------------------- |
| `--lh-tight`   | 1.2   | Headings               |
| `--lh-base`    | 1.6   | Texto general          |
| `--lh-relaxed` | 1.8   | Texto largo, artículos |

### Headings <small>(theme.json — clamp)</small>

| Heading | Tamaño                           | Preview                                                                                             |
| ------- | -------------------------------- | --------------------------------------------------------------------------------------------------- |
| h1      | `clamp(2rem, 5vw, 3.5rem)`       | <span style="font-size:2rem; font-weight:700; color:#0F172A; line-height:1.2;">Heading 1</span>     |
| h2      | `clamp(1.75rem, 4vw, 2.5rem)`    | <span style="font-size:1.75rem; font-weight:600; color:#0F172A; line-height:1.2;">Heading 2</span>  |
| h3      | `clamp(1.5rem, 3vw, 2rem)`       | <span style="font-size:1.5rem; font-weight:600; color:#0F172A; line-height:1.2;">Heading 3</span>   |
| h4      | `clamp(1.25rem, 2.5vw, 1.75rem)` | <span style="font-size:1.25rem; font-weight:600; color:#0F172A; line-height:1.2;">Heading 4</span>  |
| h5      | `clamp(1.125rem, 2vw, 1.5rem)`   | <span style="font-size:1.125rem; font-weight:600; color:#0F172A; line-height:1.2;">Heading 5</span> |
| h6      | `clamp(1rem, 1.5vw, 1.25rem)`    | <span style="font-size:1rem; font-weight:600; color:#0F172A; line-height:1.2;">Heading 6</span>     |

---

## Spacing

### Escala completa

| Slug | Tamaño   | Variable CSS                | Visual                                                |
| ---- | -------- | --------------------------- | ----------------------------------------------------- |
| `0`  | 0        | `--wp--preset--spacing--0`  |                                                       |
| `2`  | 0.125rem | `--wp--preset--spacing--2`  | <span class="spacing-bar" style="width:2px;"></span>  |
| `4`  | 0.25rem  | `--wp--preset--spacing--4`  | <span class="spacing-bar" style="width:4px;"></span>  |
| `8`  | 0.5rem   | `--wp--preset--spacing--8`  | <span class="spacing-bar" style="width:8px;"></span>  |
| `10` | 0.625rem | `--wp--preset--spacing--10` | <span class="spacing-bar" style="width:10px;"></span> |
| `12` | 0.75rem  | `--wp--preset--spacing--12` | <span class="spacing-bar" style="width:12px;"></span> |
| `16` | 1rem     | `--wp--preset--spacing--16` | <span class="spacing-bar" style="width:16px;"></span> |
| `24` | 1.5rem   | `--wp--preset--spacing--24` | <span class="spacing-bar" style="width:24px;"></span> |
| `32` | 2rem     | `--wp--preset--spacing--32` | <span class="spacing-bar" style="width:32px;"></span> |
| `36` | 2.25rem  | `--wp--preset--spacing--36` | <span class="spacing-bar" style="width:36px;"></span> |
| `40` | 2.5rem   | `--wp--preset--spacing--40` | <span class="spacing-bar" style="width:40px;"></span> |
| `48` | 3rem     | `--wp--preset--spacing--48` | <span class="spacing-bar" style="width:48px;"></span> |
| `56` | 3.5rem   | `--wp--preset--spacing--56` | <span class="spacing-bar" style="width:56px;"></span> |
| `64` | 4rem     | `--wp--preset--spacing--64` | <span class="spacing-bar" style="width:64px;"></span> |
| `80` | 5rem     | `--wp--preset--spacing--80` | <span class="spacing-bar" style="width:80px;"></span> |
| `96` | 6rem     | `--wp--preset--spacing--96` | <span class="spacing-bar" style="width:96px;"></span> |

### Layout spacing <small>(solo CSS — clamp)</small>

| Token                 | Valor                                     |
| --------------------- | ----------------------------------------- |
| `--flow-space`        | `1.5625rem`                               |
| `--column-gap`        | `clamp(2.5rem, 2.5vw + 1.75rem, 3.75rem)` |
| `--box-spacing`       | `clamp(1rem, 2.5vw + 0.25rem, 2.25rem)`   |
| `--container-spacing` | `clamp(1rem, 2.5vw + 0.25rem, 2.25rem)`   |
| `--component-spacing` | `clamp(3rem, 6.5vw + 1.05rem, 6.25rem)`   |

---

## Sombras

<div style="display:flex; gap:24px; flex-wrap:wrap; margin:16px 0;">
	<div style="text-align:center;">
		<div class="shadow-preview" style="box-shadow:0 1px 2px rgb(0 0 0 / 0.08);"></div>
		<div style="font-size:12px; color:#94A3B8;">Shadow 100</div>
	</div>
	<div style="text-align:center;">
		<div class="shadow-preview" style="box-shadow:0 2px 8px rgb(0 0 0 / 0.12);"></div>
		<div style="font-size:12px; color:#94A3B8;">Shadow 200</div>
	</div>
	<div style="text-align:center;">
		<div class="shadow-preview" style="box-shadow:rgba(99,99,99,0.2) 0px 2px 8px 0px;"></div>
		<div style="font-size:12px; color:#94A3B8;">Shadow Menu</div>
	</div>
	<div style="text-align:center;">
		<div class="shadow-preview" style="box-shadow:0 0 0 2px rgba(99,102,241,0.3);"></div>
		<div style="font-size:12px; color:#94A3B8;">Shadow Input</div>
	</div>
</div>

| Slug    | Variable CSS                   |
| ------- | ------------------------------ |
| `100`   | `--wp--custom--shadows--100`   |
| `200`   | `--wp--custom--shadows--200`   |
| `menu`  | `--wp--custom--shadows--menu`  |
| `input` | `--wp--custom--shadows--input` |
| `text`  | `--wp--custom--shadows--text`  |

---

## Border Radius

<div style="display:flex; gap:16px; flex-wrap:wrap; margin:16px 0; align-items:flex-end;">
	<div style="text-align:center;">
		<div class="radius-preview" style="border-radius:0.125rem;"></div>
		<div style="font-size:12px; color:#94A3B8;">2 (0.125rem)</div>
	</div>
	<div style="text-align:center;">
		<div class="radius-preview" style="border-radius:0.25rem;"></div>
		<div style="font-size:12px; color:#94A3B8;">4 (0.25rem)</div>
	</div>
	<div style="text-align:center;">
		<div class="radius-preview" style="border-radius:0.5rem;"></div>
		<div style="font-size:12px; color:#94A3B8;">8 (0.5rem)</div>
	</div>
	<div style="text-align:center;">
		<div class="radius-preview" style="border-radius:999px;"></div>
		<div style="font-size:12px; color:#94A3B8;">pill (999px)</div>
	</div>
</div>

| Slug   | Variable CSS                 |
| ------ | ---------------------------- |
| `2`    | `--wp--custom--radius--2`    |
| `4`    | `--wp--custom--radius--4`    |
| `8`    | `--wp--custom--radius--8`    |
| `pill` | `--wp--custom--radius--pill` |

---

## Motion / Transitions

| Token  | Valor                          | Variable CSS                             |
| ------ | ------------------------------ | ---------------------------------------- |
| Fast   | `120ms`                        | `--wp--custom--motion--duration--fast`   |
| Base   | `200ms`                        | `--wp--custom--motion--duration--base`   |
| Slow   | `320ms`                        | `--wp--custom--motion--duration--slow`   |
| Easing | `cubic-bezier(0.2, 0, 0.2, 1)` | `--wp--custom--motion--easing--standard` |

---

## Botones

<div style="display:flex; flex-wrap:wrap; gap:8px; margin:16px 0; padding:24px; background:#F8FAFC; border-radius:8px;">
	<span class="btn-preview" style="background:#0F172A; color:#fff;">Default</span>
	<span class="btn-preview" style="background:#1E293B; color:#fff;">Primary</span>
	<span class="btn-preview" style="background:#6366F1; color:#fff;">Secondary</span>
	<span class="btn-preview" style="background:transparent; color:#0F172A; border:2px solid #0F172A;">Outline</span>
	<span class="btn-preview" style="background:transparent; color:#1E293B; border:2px solid #1E293B;">Outline Primary</span>
	<span class="btn-preview" style="background:transparent; color:#6366F1; border:2px solid #6366F1;">Outline Secondary</span>
	<span class="btn-preview" style="background:transparent; color:#0F172A; text-decoration:underline; border:none;">Ghost</span>
</div>

<div style="display:flex; flex-wrap:wrap; gap:8px; margin:16px 0; padding:24px; background:#0F172A; border-radius:8px;">
	<span class="btn-preview" style="background:transparent; color:#fff; border:2px solid #fff;">Transparent</span>
</div>

| Clase                                | Descripción                      |
| ------------------------------------ | -------------------------------- |
| `.btn`                               | Base (obligatorio)               |
| `.btn--sm` / `.btn--md` / `.btn--lg` | Tamaños                          |
| `.btn--default`                      | Botón oscuro                     |
| `.btn--primary`                      | Botón primary (brand)            |
| `.btn--secondary`                    | Botón accent                     |
| `.btn--outline`                      | Borde oscuro, fondo transparente |
| `.btn--outline-primary`              | Borde primary                    |
| `.btn--outline-secondary`            | Borde accent                     |
| `.btn--transparent`                  | Para fondos oscuros              |
| `.btn--ghost`                        | Sin borde, solo texto            |

---

## Z-index <small>(solo CSS)</small>

| Token          | Valor | Uso                  |
| -------------- | ----- | -------------------- |
| `--z-below`    | -1    | Detrás del contenido |
| `--z-base`     | 0     | Normal               |
| `--z-dropdown` | 1000  | Menús desplegables   |
| `--z-sticky`   | 1100  | Headers sticky       |
| `--z-overlay`  | 1200  | Overlays             |
| `--z-modal`    | 1300  | Modales              |
| `--z-popover`  | 1400  | Popovers / Tooltips  |
| `--z-tooltip`  | 1500  | Tooltips             |

---

## Containers

| Slug  | Ancho  | Variable CSS                   |
| ----- | ------ | ------------------------------ |
| `sm`  | 640px  | `--wp--custom--container--sm`  |
| `md`  | 768px  | `--wp--custom--container--md`  |
| `lg`  | 1024px | `--wp--custom--container--lg`  |
| `xl`  | 1280px | `--wp--custom--container--xl`  |
| `2xl` | 1536px | `--wp--custom--container--2xl` |

---

## Breakpoints

| Breakpoint | Ancho mínimo | Uso                        |
| ---------- | ------------ | -------------------------- |
| Mobile     | < 600px      | Base styles (mobile-first) |
| Tablet     | 600px        | Layout de 2 columnas       |
| Desktop sm | 782px        | Navbar completa            |
| Desktop    | 1024px       | Container lg               |
| Desktop lg | 1280px       | Container xl               |
| Desktop xl | 1536px       | Container 2xl              |

---

## Presets tipográficos

4 presets intercambiables en `styles/typography/`:

| Preset          | Fuentes                  | Estilo      |
| --------------- | ------------------------ | ----------- |
| Serif & Display | Beiruti + Literata       | Elegante    |
| Mono & Serif    | Fira Code + Vollkorn     | Técnico     |
| Sans & Display  | Ysabeau Office + Platypi | Moderno     |
| Slab & Sans     | Roboto Slab + Manrope    | Corporativo |

Selecciona desde: **Apariencia → Editor → Estilos → Tipografía**
