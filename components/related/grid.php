<?php
/**
 * Related items grid component.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$items = $args['items'] ?? [];
$items_per_row = (int) ( $args['items_per_row'] ?? 3 );
$see_all_cta = (array) ( $args['see_all_cta'] ?? [] );
$is_block_editor = (bool) ( $args['is_block_editor'] ?? false );
$aspect_ratio = $args['aspect_ratio'] ?? '4-3';

$classes = [
    'related__list',
    'related__list--grid',
    'related__list--cols-' . $items_per_row,
];
$attrs = [
    'class' => implode(' ', $classes),
    'data-items-per-row' => esc_attr($items_per_row),
];
?>
<?php if ( !$is_block_editor ): ?>
    <div class="related__container" aria-live="polite">
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