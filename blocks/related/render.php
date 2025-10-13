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
        <!-- related List Section -->
        <?php /*if ($related_count > 0): ?>
            <div class="related__container" aria-live="polite">
                
                <!-- Carousel Controls -->
                <?php if ($show_controls && $is_carousel): ?>
                    <div class="related__controls" aria-hidden="false">
						<button type="button" class="related__control related__control--prev" aria-label="Servicio anterior" data-action="prev">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
						</button>
						<button type="button" class="related__control related__control--next" aria-label="Siguiente servicio" data-action="next">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z"/></svg>
						</button>
					</div>
                <?php endif; ?>

                <!-- related List -->
                <div class="related__wrapper">
                    <div class="related__grid" role="region" aria-label="Lista de servicios">
                        <?php
						foreach ( $related as $item ) {
							$post_id = is_object($item) ? (int) $item->ID : (int) $item;

							// If no title, do not render the card
							$service_title = get_the_title($post_id);
							if ( ! $service_title ) continue;

							echo render_component('card', [
								'post_id'   => $post_id,
								'cta_text'  => 'Ver más',
								// Allows optional BEM modifiers for variants
								'extra_cls' => '',
							]);
						}
                        ?>
                    </div>
                </div>

                <?php if ($is_carousel): ?>
                    <div class="related__indicators" role="tablist" aria-label="Paginación del carrousel">
                        <?php
                        $total_slides = (int) ceil($related_count / $items_per_row);
                        for ($i = 0; $i < $total_slides; $i++):
                            $is_active = $i === 0;
                        ?>
                            <button 
                                type="button" 
                                class="related__indicator <?php echo $i === 0 ? 'related__indicator--active' : ''; ?>"
                                role="tab"
                                aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                aria-label="Ir a la página <?php echo $i + 1; ?>"
                                data-slide="<?php echo (int) $i; ?>">
                            </button>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php elseif ($is_block_editor): ?>
            <div class="related__empty">
                <div class="related__empty-content">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <rect x="37.5" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <rect x="65" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <circle cx="22.5" cy="30" r="3" fill="#ccc"/>
                        <circle cx="50" cy="30" r="3" fill="#ccc"/>
                        <circle cx="77.5" cy="30" r="3" fill="#ccc"/>
                    </svg>
                    <p>Selecciona contenido para mostrar</p>
                </div>
            </div>
        <?php endif; */?>

    </div>

</section>