<?php
/**
 * Services Showcase block template.
 * 
 * @param array $block The block settings and attributes.
 * @see https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Block ID and classes
$id = $block['anchor'] ?? ('services-' . $block['id']);

// Detectar si estamos en el editor de bloques
$is_block_editor = is_admin() && function_exists('get_current_screen') && ( get_current_screen() && get_current_screen()->is_block_editor() );

// Header fields
$tagline = get_field('tagline');
$title = get_field('title');
$description = get_field('description');

// Services and layout options
$services = get_field('services');
$items_per_row = get_field('items_per_row') ?: 3;
$show_carousel_controls = get_field('show_carousel_controls');
$enable_autoplay = get_field('enable_autoplay');
$autoplay_delay = get_field('autoplay_delay') ?: 5000;

// Layout options
$padding_y = get_field('padding_y') ?: 'lg';

// Build BEM classes
$classes = [
    'services',
    'services--py-' . sanitize_html_class($padding_y),
    'services--cols-' . sanitize_html_class($items_per_row),
];

// Add carousel class if more than items per row
$services_count = is_array($services) ? count($services) : 0;
$is_carousel = $services_count > $items_per_row;

if ($is_carousel) {
    $classes[] = 'services--carousel';
}

if ($show_carousel_controls && $is_carousel) {
    $classes[] = 'services--with-controls';
}

// Build wrapper attributes
$wrapper_attrs = get_block_wrapper_attributes([
    'class' => implode(' ', $classes),
    'id' => $id,
    'data-items-per-row' => $items_per_row,
    'data-autoplay' => $enable_autoplay ? 'true' : 'false',
    'data-autoplay-delay' => $autoplay_delay,
]);

// Helper function to render service card
$render_service_card = function($service_post) {
    if (!$service_post) return '';
    
    $post_id = $service_post->ID;
    $title = get_the_title($post_id);
    $excerpt = get_the_excerpt($post_id);
    $permalink = get_permalink($post_id);
    $thumbnail = get_the_post_thumbnail($post_id, 'medium', [
        'class' => 'services__card-image',
        'loading' => 'lazy'
    ]);
    
    // Fallback image if no thumbnail
    if (!$thumbnail) {
        $thumbnail = '<div class="services__card-image services__card-image--placeholder">
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="80" height="80" fill="#f0f0f0"/>
                <path d="M20 30L40 15L60 30M20 50L40 35L60 50" stroke="#ccc" stroke-width="2" fill="none"/>
            </svg>
        </div>';
    }
    
    return sprintf(
        '<article class="services__card">
            <a href="%s" class="services__card-link">
                <div class="services__card-media">
                    %s
                </div>
                <div class="services__card-content">
                    <h3 class="services__card-title">%s</h3>
                    %s
                    <div class="services__card-actions">
                        <a href="%s" class="btn btn-outline-primary btn--sm services__card-btn">
                            Ver más
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 0L6.6 1.4L12.2 7H0v2h12.2l-5.6 5.6L8 16l8-8z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </a>
        </article>',
        esc_url($permalink),
        $thumbnail,
        esc_html($title),
        $excerpt ? '<p class="services__card-excerpt">' . esc_html($excerpt) . '</p>' : '',
        esc_url($permalink)
    );
};

?>
<section <?php echo $wrapper_attrs; ?>>
    
    <?php if ($is_block_editor && (!$services || $services_count === 0)): ?>
        <div class="services__editor-help">
            <p><strong>🎯 Showcase de Servicios:</strong> Selecciona servicios para mostrar en este bloque.</p>
            <p>💡 <em>Si seleccionas más de <?php echo $items_per_row; ?> servicios, se activará el carrousel automáticamente.</em></p>
        </div>
    <?php endif; ?>

    <div class="container">
        <!-- Header Section -->
        <?php if ($tagline || $title || $description || $is_block_editor): ?>
            <header class="services__header">
                <?php if ($tagline): ?>
                    <p class="services__tagline"><?php echo esc_html($tagline); ?></p>
                <?php elseif ($is_block_editor): ?>
                    <p class="services__tagline services__placeholder-text">Agrega un tagline...</p>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="services__title"><?php echo esc_html($title); ?></h2>
                <?php elseif ($is_block_editor): ?>
                    <h2 class="services__title services__placeholder-text">Título de la sección</h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="services__description"><?php echo esc_html($description); ?></p>
                <?php elseif ($is_block_editor): ?>
                    <p class="services__description services__placeholder-text">Descripción de los servicios...</p>
                <?php endif; ?>
            </header>
        <?php endif; ?>

        <!-- Services Grid/Carousel -->
        <?php if ($services && $services_count > 0): ?>
            <div class="services__container">
                
                <!-- Carousel Controls -->
                <?php if ($show_carousel_controls && $is_carousel): ?>
                    <div class="services__controls">
                        <button type="button" class="services__control services__control--prev" aria-label="Servicio anterior">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/>
                            </svg>
                        </button>
                        <button type="button" class="services__control services__control--next" aria-label="Siguiente servicio">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M8.59 16.59L13.17 12L8.59 7.41L10 6l6 6-6 6-1.41-1.41z"/>
                            </svg>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Services List -->
                <div class="services__wrapper">
                    <div class="services__grid" role="region" aria-label="Lista de servicios">
                        <?php foreach ($services as $service): ?>
                            <?php echo $render_service_card($service); ?>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Carousel Indicators -->
                <?php if ($is_carousel): ?>
                    <div class="services__indicators" role="tablist" aria-label="Indicadores del carrousel">
                        <?php 
                        $total_slides = ceil($services_count / $items_per_row);
                        for ($i = 0; $i < $total_slides; $i++): 
                        ?>
                            <button 
                                type="button" 
                                class="services__indicator <?php echo $i === 0 ? 'services__indicator--active' : ''; ?>"
                                role="tab"
                                aria-selected="<?php echo $i === 0 ? 'true' : 'false'; ?>"
                                aria-label="Ir a la página <?php echo $i + 1; ?>"
                                data-slide="<?php echo $i; ?>">
                            </button>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            </div>
        <?php elseif ($is_block_editor): ?>
            <div class="services__empty">
                <div class="services__empty-content">
                    <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <rect x="37.5" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <rect x="65" y="20" width="25" height="35" fill="#f0f0f0" stroke="#ddd" rx="4"/>
                        <circle cx="22.5" cy="30" r="3" fill="#ccc"/>
                        <circle cx="50" cy="30" r="3" fill="#ccc"/>
                        <circle cx="77.5" cy="30" r="3" fill="#ccc"/>
                    </svg>
                    <p>Selecciona servicios para mostrar</p>
                </div>
            </div>
        <?php endif; ?>

    </div>

</section>