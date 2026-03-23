# ACF Starter Theme — Documentación

Bienvenido a la documentación del sistema de design tokens y arquitectura CSS del **ACF Starter Theme**.

## Contenido

### [Style Guide](style-guide.md)
Referencia completa de todos los design tokens: colores, tipografía, spacing, sombras, radius, transiciones y más. Consulta aquí cuando necesites saber qué variable usar.

### [CSS Architecture](css-architecture.md)
Dónde vive cada cosa en el código. Cómo WordPress genera las variables CSS desde `theme.json`. Convenciones BEM, reglas para nuevos estilos y nuevos bloques.

### [Theme Customization](theme-customization.md)
Guía paso a paso para adaptar el starter theme a un nuevo proyecto: cambiar colores, tipografía, layout, añadir bloques, y más.

---

## Principios

<div class="callout callout--tip">

**theme.json es la fuente única de verdad** para todos los design tokens (colores, font-sizes, spacing, sombras, radius). Nunca redefinas estos valores en CSS.

</div>

| Qué necesitas                    | Dónde buscarlo                |
| -------------------------------- | ----------------------------- |
| Color, font-size, spacing        | `--wp--preset--*`             |
| Shadow, radius, motion, container| `--wp--custom--*`             |
| Font-weight, line-height, z-index| Tokens CSS en `main.css`      |
| Reglas de componentes, buttons   | `main.css`                    |
| Estilos de un bloque ACF         | `blocks/{nombre}/style.css`   |

## Quick start

```bash
# 1. Clona el theme
git clone <repo-url> wp-content/themes/mi-proyecto

# 2. Cambia la paleta en theme.json
# 3. Elige un preset tipográfico
# 4. Elimina bloques que no necesites
# 5. Empieza a construir
```
