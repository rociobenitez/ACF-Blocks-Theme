<?php
/**
 * Hero block template.
 * 
 * @param array $block The block settings and attributes.
 * @see https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Block ID and classes
$id  = $block['anchor'] ?? ('hero-' . $block['id']);
$cls = 'hero' . (!empty($block['className']) ? ' ' . $block['className'] : '');

// Styles
$sty_centered = str_contains($cls, 'is-style-centered');
$sty_split    = str_contains($cls, 'is-style-split');
$sty_overlay  = str_contains($cls, 'is-style-overlay');

// Detectar si estamos en el editor de bloques
$is_block_editor = is_admin() && function_exists('get_current_screen') && ( get_current_screen() && get_current_screen()->is_block_editor() );

// Content
$tagline      = get_field( 'tagline' ) ?: '';
$title        = get_field( 'title' ) ?: '';
$tag_title    = get_field( 'tag_title' ) ?: 'h1';
$subtitle     = get_field( 'subtitle' ) ?: '';
$text         = get_field( 'text' ) ?: '';

// Global
$padding_y    = get_field( 'padding_y' ) ?: 'md';   // 'sm'|'md'|'lg'
$valign       = get_field( 'valign' ) ?: 'center';  // 'top'|'center'|'bottom'

// Media
$bg_mode         = get_field( 'bg_mode' ) ?: 'none';          // 'none'|'image'|'video'   
$image_position  = get_field( 'image_position' ) ?: 'right';  // 'left'|'right' (solo para 'image')
$image           = (int) get_field( 'image' );                // attachment ID
$video_url       = get_field( 'video_url' );                  // oEmbed/URL

// Overlay (solo overlay)
$ov_on     = (bool) (get_field('overlay_enabled') ?? true);
$ov_op     = (float) (get_field('overlay_opacity') ?? 0.35);
$ov_align  = get_field('overlay_content_align') ?: 'left';    // 'left'|'center'

// Buttons
$cta_1        = (array) get_field( 'cta' );
$cta_2        = (array) get_field( 'cta_2' );
$cta_1_style  = get_field( 'cta_style' ) ?? 'default';
$cta_2_style  = get_field( 'cta_2_style' ) ?: 'secondary';

// Validate title and subtitle tags
$allowed_tags = ['h1', 'h2', 'h3', 'p'];
$title_tag    = strtolower( (string) get_field( 'title_tag' ) );
$subtitle_tag = strtolower( (string) get_field( 'subtitle_tag' ) );
$title_tag    = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h1';
$subtitle_tag = in_array( $subtitle_tag, $allowed_tags, true ) ? $subtitle_tag : 'p';

// Build BEM classes based on options
$classes = [
    'hero',
    'hero--valign-' . sanitize_html_class( $valign ),
    'hero--py-' . sanitize_html_class( $padding_y ),
    'hero--bg-' . sanitize_html_class( $bg_mode ),
    'hero--text-' . sanitize_html_class( $ov_align ),
];

if ( $sty_split ) {
    if ( $image_position === 'left' ) {
        $classes[] = 'hero--img-left';
    } else {
        $classes[] = 'hero--img-right';
    }
}

// Build wrapper attributes
$wrapper_attrs = get_block_wrapper_attributes( [
    'class' => implode( ' ', $classes ),
] );

// Inline background-image style if needed
$bg_style = '';
if ( $bg_mode === 'image' && !$sty_split ) {
    $img_url = wp_get_attachment_image_url( $image, 'full' );
    if ( $img_url ) {
        $bg_style = ' style="background-image:url(' . esc_url( $img_url ) . ');"';
    }
}

// Prepare background video for centered/overlay styles
$has_bg_video = false;
$video_file_url = '';
if ( $bg_mode === 'video' && !$sty_split && $video_url && ( $sty_centered || $sty_overlay ) ) {
    $video_file_url = wp_get_attachment_url( $video_url );
    if ( $video_file_url ) {
        $has_bg_video = true;
    }
}

// Botón helper
$btn = function($link, $variant = 'primary') {
  $label = $link['title'] ?? '';
  $url   = $link['url'] ?? '';
  if (!$label || !$url) return '';
  return sprintf('<a class="btn btn--lg btn--%1$s" href="%2$s">%3$s</a>',
    esc_attr($variant), esc_url($url), esc_html($label)
  );
};

?>
<section <?php echo $wrapper_attrs; ?><?php echo $bg_style; ?>>

    <?php if ( $has_bg_video ) : ?>
        <div class="hero__bg-video">
            <?php if ( $is_block_editor ) : ?>
                <!-- Placeholder for editor -->
                <div class="hero__bg-video-placeholder">
                    <span>Vídeo de fondo: <?php echo esc_html( get_the_title( $video_url ) ); ?></span>
                </div>
            <?php else : ?>
                <!-- Background video with native HTML5 video tag -->
                <div class="hero__bg-video-embed">
                    <video 
                        class="hero__bg-video-element"
                        autoplay 
                        muted 
                        loop 
                        playsinline
                        aria-hidden="true"
                        preload="metadata"
                        poster="<?php echo esc_url( wp_get_attachment_image_url( $video_url, 'large' ) ); ?>">
                        <source src="<?php echo esc_url( $video_file_url ); ?>" type="<?php echo esc_attr( get_post_mime_type( $video_url ) ); ?>">
                        Su navegador no soporta la reproducción de vídeo.
                    </video>
                    <!-- Screen reader text for accessibility -->
                    <span class="screen-reader-text">Vídeo decorativo de fondo, sin audio</span>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ( ($sty_overlay && $ov_on ) ||  ( $sty_centered && $ov_on ) ) : ?>
        <div class="hero__overlay" style="opacity: <?php echo esc_attr( $ov_op ); ?>"></div>
    <?php endif; ?>

    <div class="container">
        <div class="hero__grid">
            <div class="hero__content">
                <?php if ( $tagline ) : ?>
                    <p class="hero__tagline"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <?php echo tag_title( $tag_title, $title, 'hero__title' ); ?>
                <?php endif; ?>

                <?php if ( $subtitle ) : ?>
                    <p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="hero__text">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $cta_1 ) : ?>
                    <div class="hero__actions">
                        <?php echo $btn($cta_1, $cta_1_style); // phpcs:ignore ?>

                        <?php if ( $cta_2 ) : ?>
                            <?php echo $btn($cta_2, $cta_2_style); // phpcs:ignore ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $sty_split ) : ?>
                <div class="hero__media">
                    <?php if ( $image ) : ?>
                        <?php echo wp_get_attachment_image( $image, 'large', false, [ 'class' => 'hero__img' ] ); ?>
                    <?php elseif ( $video_url ) : ?>
                        <div class="hero__video">
                            <?php echo wp_oembed_get( esc_url( $video_url ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</section>
