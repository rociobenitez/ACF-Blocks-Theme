<?php
/**
 * Alternated Content block template.
 * 
 * @param array $block The block settings and attributes.
 * @see https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Block ID and classes
$id  = $block['anchor'] ?? ('alternated-content-' . $block['id']);
$cls = 'alternated-content' . (!empty($block['className']) ? ' ' . $block['className'] : '');

// Detectar si estamos en el editor de bloques
$is_block_editor = is_admin() && function_exists('get_current_screen') && ( get_current_screen() && get_current_screen()->is_block_editor() );

// Content fields
$tagline = get_field('tagline');
$title = get_field('title');
$content = get_field('content');
$image = get_field('image');
$image_position = get_field('image_position') ?: 'right';

// Button fields
$primary_button = get_field('primary_button');
$secondary_button = get_field('secondary_button');
$primary_button_style = get_field('primary_button_style') ?: 'default';
$secondary_button_style = get_field('secondary_button_style') ?: 'outline';

// Layout options
$padding_y = get_field('padding_y') ?: 'lg';
$vertical_align = get_field('vertical_align') ?: 'center';

// Build BEM classes based on options
$classes = [
    'alternated-content',
    'alternated-content--py-' . sanitize_html_class($padding_y),
    'alternated-content--valign-' . sanitize_html_class($vertical_align),
    'alternated-content--img-' . sanitize_html_class($image_position),
];

// Build wrapper attributes
$wrapper_attrs = get_block_wrapper_attributes([
    'class' => implode(' ', $classes),
    'id' => $id,
]);

// Helper function for buttons
$render_button = function($link, $style = 'primary') {
    if (!$link || !isset($link['url']) || !isset($link['title'])) {
        return '';
    }
    
    $url = esc_url($link['url']);
    $title = esc_html($link['title']);
    $target = isset($link['target']) && $link['target'] === '_blank' ? ' target="_blank" rel="noopener"' : '';
    
    return sprintf(
        '<a class="btn btn--md btn--%s" href="%s"%s>%s</a>',
        esc_attr($style),
        $url,
        $target,
        $title
    );
};

?>
<section <?php echo $wrapper_attrs; ?>>
    
    <?php if ($is_block_editor): ?>
        <div class="alternated-content__editor-help">
            <p><strong>Contenido Alternado:</strong> Sección con imagen y texto. La imagen puede posicionarse a la izquierda o derecha del contenido.</p>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="alternated-content__grid">
            
            <!-- Content Column -->
            <div class="alternated-content__content">
                <div class="alternated-content__heading">
                    <?php if ($tagline): ?>
                        <p class="alternated-content__tagline"><?php echo esc_html($tagline); ?></p>
                    <?php endif; ?>

                    <?php if ($title): ?>
                        <h2 class="alternated-content__title"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                </div>

                <?php if ($content): ?>
                    <div class="alternated-content__text">
                        <?php echo wp_kses_post($content); ?>
                    </div>
                <?php endif; ?>

                <?php if ($primary_button || $secondary_button): ?>
                    <div class="alternated-content__actions">
                        <?php if ($primary_button): ?>
                            <?php echo $render_button($primary_button, $primary_button_style); ?>
                        <?php endif; ?>
                        
                        <?php if ($secondary_button): ?>
                            <?php echo $render_button($secondary_button, $secondary_button_style); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Image Column -->
            <?php if ($image): ?>
                <div class="alternated-content__media">
                    <?php 
                    echo wp_get_attachment_image(
                        $image, 
                        'large', 
                        false, 
                        [
                            'class' => 'alternated-content__image',
                            'loading' => 'lazy'
                        ]
                    ); 
                    ?>
                </div>
            <?php elseif ($is_block_editor): ?>
                <div class="alternated-content__media alternated-content__media--placeholder">
                    <div class="alternated-content__placeholder">
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="100" height="100" fill="#f0f0f0"/>
                            <path d="M30 40L50 20L70 40M30 60L50 40L70 60" stroke="#ccc" stroke-width="2" fill="none"/>
                        </svg>
                        <p>Selecciona una imagen</p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

</section>