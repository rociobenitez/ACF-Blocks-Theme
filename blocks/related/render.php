<?php
/**
 * Related Content block template (ACF Block)
 * - BEM naming convention
 * - Card - reusable component
 * - Semantic HTML and accessibility
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Block ID and classes
$id = $block['anchor'] ?? ('related-' . $block['id']);

// Detect if in block editor
$is_block_editor = function_exists('get_current_screen') && ( is_admin() && ( $s = get_current_screen() ) && $s->is_block_editor() );

// ACF fields
$tagline         = trim((string) get_field('tagline'));
$title           = trim((string) get_field('title'));
$tag_title       = trim((string) get_field('tag_title'));
$description     = trim((string) get_field('description'));
$related         = get_field('related');
$mode            = (string) ( get_field('layout_mode') ?: 'grid' );
$source_mode     = (string) ( get_field('source_mode') ?: 'manual' );
$see_all_cta     = (array) get_field('see_all_cta') ?: [];
$items_per_row   = (int) ( get_field('items_per_row') ?: 3 );
$show_controls   = (bool) get_field('show_carousel_controls');
$enable_autoplay = (bool) get_field('enable_autoplay');
$autoplay_delay  = (int)  ( get_field('autoplay_delay') ?: 5000 );
$padding_y       = (string) ( get_field('padding_y') ?: 'lg' );
$aspect_ratio    = (string) ( get_field('image_aspect_ratio') ?: '4-3');

// Layout logic
$related_count = is_array($related) ? count($related) : 0;
$is_carousel = ($mode === 'carousel') && ($related_count > $items_per_row);

if ( $related_count === 0 ) {
    return;
}

$classes = [
    'related',
    'related--py-' . $padding_y,
    'related--cols-' . $items_per_row,
    'related--' . $mode,
];

if ( $is_carousel ) {
	$classes[] = 'related--carousel';
}

$attrs = get_block_wrapper_attributes([
    'class' => implode(' ', $classes),
    'id' => esc_attr($id),
    'data-mode' => esc_attr($mode),
    'data-cols' => esc_attr($items_per_row),
    'data-items-per-row' => esc_attr($items_per_row),
    'data-autoplay' => $enable_autoplay ? 'true' : 'false',
    'data-autoplay-delay' => esc_attr($autoplay_delay),
]);

?>
<section <?php echo $attrs; ?>>
    
    <?php if ( $is_block_editor && $related_count === 0 ): ?>
		<div class="related__editor-help" role="note">
			<p><strong>Showcase de Servicios:</strong> añade elementos en el campo “related”.</p>
			<p><em>Con más de <?php echo (int) $items_per_row; ?> ítems se activa el carrusel.</em></p>
		</div>
	<?php endif; ?>

    <div class="container">
        <!-- Header Section -->
        <?php if ($tagline || $title || $description || $is_block_editor): ?>
            <?php
            echo render_component('header-section', [
                'tagline'         => $tagline,
                'title'           => $title,
                'tag_title'       => $tag_title,
                'description'     => $description,
                'is_block_editor' => $is_block_editor,
                'extra_cls'       => 'related__header',
            ]);
            ?>
        <?php endif; ?>

        <?php
        $partial = $mode === 'carousel' ? 'related/carrousel' : 'related/grid';
        echo render_component($partial, [
            'items'           => $related,
            'items_per_row'   => $items_per_row,
            'see_all_cta'     => $see_all_cta,
            'is_block_editor' => $is_block_editor,
            'show_controls'   => $show_controls,
            'aspect_ratio'    => $aspect_ratio,
            'carousel'     => [
                'controls' => $show_controls,
                'autoplay' => $enable_autoplay,
                'delay'  => $autoplay_delay,
            ]
        ]);
        ?>
    </div>

</section>