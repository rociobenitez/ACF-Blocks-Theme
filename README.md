# Starter Theme — ACF Blocks Theme

Minimal, production-ready WordPress starter theme focused on **reusable ACF Blocks**.  
No build step (plain CSS/JS), token-based styling (CSS Custom Properties), and clean PHP with WordPress Coding Standards.

> **Requirements**
>
> -   WordPress **6.8+**
> -   PHP **8.0+**
> -   **ACF PRO 6.6+**

## Features

-   **ACF Blocks** via `block.json` + PHP render templates.
-   **Local JSON** for ACF Field Groups (`/acf-json`) – versioned and sync-able.
-   **Token-based CSS** (CSS Custom Properties) + light BEM; theme-agnostic.
-   **No build**: one core CSS and per-block CSS.
-   **Auto-register** blocks from `/blocks/*`.
-   **Coding standards**: PHPCS (WPCS), ESLint, Prettier (optional).
-   **Docs-as-code** friendly (MkDocs or plain `/docs`).

## Project Structure

```
acf-blocks-theme/
├─ style.css
├─ functions.php
├─ theme.json
├─ composer.json
├─ acf-json/                # ACF Local JSON (commit to repo)
├─ assets/
│  ├─ fonts/                # font files
│  ├─ images/               # image files
│  ├─ css/
│  │  ├─ fonts.css          # font imports
│  │  ├─ editor.css         # editor styles (optional)
│  │  └─ main.css           # core styles
│  └─ js/                   # minimal editor/front helpers
├─ blocks/                  # each block = folder with block.json + render.php + style.css
│  └─ hero/
│     ├─ block.json
│     ├─ render.php
│     └─ style.css
├─ parts/
│  ├─ header.html
│  └─ footer.html
├─ styles
│  └─ typograpy/
├─ inc/
│  ├─ class-theme.php       # main bootstrap (hooks)
│  ├─ class-acf-json.php    # ACF Local JSON + options page
│  └─ class-acf-blocks.php  # category + auto-register blocks from /blocks
├─ templates/               # html templates (e.g. single.php)
└─ languages/               # translations (.pot/.po/.mo)
```

## Installation

1. Copy the theme to `wp-content/themes/starter-theme/`.
2. Activate **ACF PRO**.
3. Activate **Starter Theme** in `Appearance → Themes`.
4. In ACF:
    - Create/Sync field groups under `acf-json/`.
    - For blocks: set location rule **Block → is equal to → `namespace/block`** (e.g. `starter/hero`).

## Usage

-   Insert blocks from **Starter/Starter Blocks** category in the editor.
-   Configure fields (layout, media, CTAs, spacing, background preset).
-   Tokens (colors/spacing) can be overridden by the client project.

## License

GPL-2.0-or-later.
ACF PRO is a commercial dependency and is not distributed with this theme.

<br>
<small>Built by Rocío Benítez García. Inspired by WordPress & ACF modern block patterns.<small>
