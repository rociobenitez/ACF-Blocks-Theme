<?php
/**
 * Page Header Helpers
 * @package Starter\Theme
 */

namespace Starter\Theme;

defined('ABSPATH') || exit;

/**
 * Devuelve el ID de contexto correcto:
 * - Si "Página de entradas" está activa (is_home y NO es portada), usa page_for_posts.
 * - En otro caso, usa el objeto consultado.
 */
function ph_get_context_id(): int {
    if (is_home() && !is_front_page()) {
        return (int) get_option('page_for_posts');
    }
    return (int) get_queried_object_id();
}

/**
 * Modelo de datos del Page Header con fallbacks.
 * Usa tus campos actuales:
 *  - ph_enable, ph_title, ph_subtitle, ph_kicker
 *  - ph_bg_image (url), ph_overlay_opacity (0..1)
 *  - ph_breadcrumbs (bool), ph_show_form (bool), ph_id_form (text)
 */
function ph_get_data(): array {
    $id = ph_get_context_id();

    // Habilitar/deshabilitar
    $enabled = (bool) get_field('ph_enable', $id);
    if (!$enabled) {
        return ['enabled' => false];
    }

    // Título
    $title = get_field('ph_title', $id);
    if (!$title) {
        // get_the_title() debe recibir el ID correcto (pág. de entradas también)
        $title = get_the_title($id);
    }

    $subtitle = (string) (get_field('ph_subtitle', $id) ?: '');
    $kicker   = (string) (get_field('ph_kicker', $id) ?: '');

    // Imagen: ACF URL -> destacada -> default
    $acf_bg_url = get_field('ph_bg_image', $id); // ya viene como URL por tu return_format
    if (is_string($acf_bg_url) && $acf_bg_url !== '') {
        $bg_url = $acf_bg_url;
    } else {
        $thumb_id = get_post_thumbnail_id($id);
        $bg_url = $thumb_id ? wp_get_attachment_image_url($thumb_id, '1536x1536') : '';
        if (!$bg_url) {
            $bg_url = get_template_directory_uri() . '/assets/images/default.jpg';
        }
    }

    // Overlay 0..1
    $overlay = get_field('ph_overlay_opacity', $id);
    $overlay = is_numeric($overlay) ? max(0, min(1, (float) $overlay)) : 0.5;

    // Breadcrumbs
    $show_breadcrumbs = (bool) get_field('ph_breadcrumbs', $id);

    // Formulario (Gravity Forms por shortcode)
    $show_form = (bool) get_field('ph_show_form', $id);
    $form_id   = trim((string) (get_field('ph_id_form', $id) ?: ''));

    return apply_filters('starter/ph_data', [
        'enabled'     => true,
        'title'       => $title,
        'subtitle'    => $subtitle,
        'kicker'      => $kicker,
        'bg_url'      => $bg_url,
        'overlay'     => $overlay,
        'breadcrumbs' => $show_breadcrumbs,
        'show_form'   => $show_form,
        'form_id'     => $form_id,
        'context_id'  => $id,
    ]);
}

/**
 * Genera los ítems de las migas de pan.
 * Minimalista y suficiente para páginas y la "página de entradas".
 */
function generate_breadcrumbs(): array {
    $items = [];

    // Home siempre primero
    $items[] = [
        'label' => esc_html__('Inicio', 'starter'),
        'url'   => home_url('/'),
    ];

    // Página de entradas (is_home sin ser portada)
    if (is_home() && !is_front_page()) {
        $posts_page_id = (int) get_option('page_for_posts');
        $items[] = [
            'label' => get_the_title($posts_page_id),
            'url'   => null, // actual
        ];
        return $items;
    }

    // Portada: no añadimos más
    if (is_front_page()) {
        return $items; // solo "Inicio"
    }

    // Páginas (con jerarquía)
    if (is_singular('page')) {
        $current = get_queried_object();
        if ($current && !is_wp_error($current)) {
            $ancestors = array_reverse(get_post_ancestors($current));
            foreach ($ancestors as $a) {
                $items[] = [
                    'label' => get_the_title($a),
                    'url'   => get_permalink($a),
                ];
            }
            $items[] = [
                'label' => get_the_title($current),
                'url'   => null,
            ];
        }
        return $items;
    }

    // Fallback genérico (por si lo usas en otros contextos)
    $items[] = [
        'label' => wp_get_document_title(),
        'url'   => null,
    ];
    return $items;
}

/**
 * Render accesible + JSON-LD de los breadcrumbs.
 */
function render_breadcrumbs(): void {
    $items = generate_breadcrumbs();
    if (count($items) < 2) {
        return; // no mostrar si no hay ruta real
    }

    // JSON-LD
    $ld = [
        '@context' => 'https://schema.org',
        '@type'    => 'BreadcrumbList',
        'itemListElement' => [],
    ];

    // URL actual para items sin URL
    $current_url = function () {
        // Suficiente y seguro para mayorías de casos
        return esc_url((is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
    };

    foreach ($items as $i => $it) {
        $ld['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => wp_strip_all_tags($it['label']),
            'item'     => $it['url'] ? esc_url($it['url']) : $current_url(),
        ];
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumbs"><ol>';
    foreach ($items as $it) {
        if (!empty($it['url'])) {
            printf(
                '<li><a href="%s">%s</a></li>',
                esc_url($it['url']),
                esc_html($it['label'])
            );
        } else {
            printf(
                '<li aria-current="page">%s</li>',
                esc_html($it['label'])
            );
        }
    }
    echo '</ol></nav>';
    echo '<script type="application/ld+json">' . wp_json_encode($ld) . '</script>';
}
