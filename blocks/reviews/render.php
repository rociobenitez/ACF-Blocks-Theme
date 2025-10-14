<?php
/**
 * Render callback for Reviews block
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Detect if in block editor
$is_block_editor = function_exists('get_current_screen') && ( is_admin() && ( $s = get_current_screen() ) && $s->is_block_editor() );

// Get ACF fields
$tagline = get_field('tagline') ?: '';
$title = get_field('title') ?: '';
$description = get_field('description') ?: '';
$bg_color = get_field('background_color') ?: 'light';
$btn_see_all = get_field('link_reviews') ?: [];

// Get reviews shortcode
$reviews = get_field('shortcode_reviews', 'option') ?: [];

// If no reviews and not in editor, don't render the block
if ( empty($reviews) && ! $is_block_editor ) {
    return;
}
?>
<div <?php echo get_block_wrapper_attributes(["class" => 'reviews reviews--bg-' . $bg_color]); ?>>
    
    <?php if ( $is_block_editor && empty($reviews) ): ?>
        <div class="reviews__editor-help" role="note">
            <p style="padding: 2em; text-align: center; background: #f6f6f6; border: 1px dashed #ccc;">
                <?php esc_html_e( 'No hay reseñas disponibles. Edita el bloque para añadir algunas.', 'acf-starter-theme' ); ?>
            </p>
        </div>
    <?php else: ?>

    <div class="container">
        <!-- Header Section -->
        <?php if ($title): ?>
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

        <?php if ( !empty($reviews) ): ?>
            <div class="reviews__content">
                <?php echo do_shortcode( $reviews ); ?>
            </div>
        <?php endif; ?>

        <?php if ( !empty($btn_see_all) && !empty($btn_see_all['url']) ): ?>
            <div class="reviews__footer" style="text-align: center; margin-top: 2em;">
                <a target="<?php echo !empty($btn_see_all['target']) ? esc_attr($btn_see_all['target']) : '_self'; ?>" 
                   href="<?php echo esc_url($btn_see_all['url']); ?>" 
                   class="reviews__button btn btn--sm btn--outline">
                    <?php echo esc_html($btn_see_all['title'] ?: 'Ver todas las reseñas'); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

</div>
