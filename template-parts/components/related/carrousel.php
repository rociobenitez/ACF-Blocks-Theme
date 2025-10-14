<?php
/**
 * Related items carousel component.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$items = $args['items'] ?? [];
$items_per_row = (int) ( $args['items_per_row'] ?? 3 );
$see_all_cta = (array) ( $args['see_all_cta'] ?? [] );
$is_block_editor = (bool) ( $args['is_block_editor'] ?? false );
$show_controls = (bool) ( $args['show_controls'] ?? false );
$carousel = (array) ( $args['carousel'] ?? [] );
$related_count = is_array($items) ? count($items) : 0;
$is_carousel = ($related_count > $items_per_row);
$aspect_ratio = $args['aspect_ratio'] ?? '4-3';

$classes = [
    'related__list',
    'related__list--carousel',
    'related__list--cols-' . $items_per_row,
];
$attrs = [
    'class' => implode(' ', $classes),
    'data-items-per-row' => esc_attr($items_per_row),
    'data-autoplay' => !empty($carousel['enable_autoplay']) ? 'true' : 'false',
    'data-autoplay-delay' => esc_attr((int) ( $carousel['autoplay_delay'] ?? 5000 )),
];
?>
<?php if (!$is_block_editor): ?>
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
                foreach ( $items as $item ) {
                    $post_id = is_object($item) ? (int) $item->ID : (int) $item;

                    // If no title, do not render the card
                    $service_title = get_the_title($post_id);
                    if ( ! $service_title ) continue;

                    echo render_component('card', [
                        'post_id'   => $post_id,
                        'cta_text'  => 'Ver más',
                        'aspect_ratio' => $aspect_ratio,
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
<?php else: ?>
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
<?php endif; ?>