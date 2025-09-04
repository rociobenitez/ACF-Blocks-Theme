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

// ACF context
$tagline         = get_field( 'tagline' );                        // string
$title           = get_field( 'title' );                          // string
$subtitle        = get_field( 'subtitle' );                       // string
$text            = get_field( 'text' );                           // WYSIWYG / text
$layout          = get_field( 'layout' ) ?: 'contained';          // 'full' | 'contained'
$text_align      = get_field( 'text_alignment' ) ?: 'left';       // 'left'|'center'|'right'
$valign          = get_field( 'vertical_alignment' ) ?: 'center'; // 'top'|'center'|'bottom'
$bg_preset       = get_field( 'background_preset' ) ?: 'default'; // tokens preset
$padding_y       = get_field( 'padding_y' ) ?: 'md';              // 'sm'|'md'|'lg'

$image_mode      = get_field( 'image_mode' ) ?: 'none';           // 'none'|'background'|'media'
$image_position  = get_field( 'image_position' ) ?: 'right';      // 'left'|'right' (solo para media)
$media_type      = get_field( 'media_type' ) ?: 'image';          // 'image'|'video'
$image_id        = (int) get_field( 'image' );                    // attachment ID
$video_url       = get_field( 'video_url' );                      // oEmbed/URL

$overlay_enabled = (bool) get_field( 'overlay_enabled' );
$overlay_opacity = (float) get_field( 'overlay_opacity' );        // 0..1

$cta_1_btn       = (array) get_field( 'cta_1_btn' );
$cta_1_style     = get_field( 'cta_1_style' ) ?? 'default';
$cta_1_label     = $cta_1_btn['title'] ?? '';
$cta_1_url       = $cta_1_btn['url'] ?? '';

$cta_2_btn       = (array) get_field( 'cta_2_btn' );
$cta_2_style     = get_field( 'cta_2_style' ) ?: 'secondary';
$cta_2_label     = $cta_2_btn['title'] ?? '';
$cta_2_url       = $cta_2_btn['url'] ?? '';

// Validate title and subtitle tags
$allowed_tags = ['h1', 'h2', 'h3', 'p'];
$title_tag    = strtolower( (string) get_field( 'title_tag' ) );
$subtitle_tag = strtolower( (string) get_field( 'subtitle_tag' ) );
$title_tag    = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h1';
$subtitle_tag = in_array( $subtitle_tag, $allowed_tags, true ) ? $subtitle_tag : 'p';

// Build BEM classes based on options
$classes = [
    'hero',
    'hero--layout-' . sanitize_html_class( $layout ),
    'hero--valign-' . sanitize_html_class( $valign ),
    'hero--bg-' . sanitize_html_class( $bg_preset ),
    'hero--py-' . sanitize_html_class( $padding_y ),
    'hero--text-' . sanitize_html_class( $text_align ),
];

if ( $image_mode === 'background' ) {
    $classes[] = 'hero--with-bg';
} elseif ( $image_mode === 'media' ) {
    $classes[] = 'hero--with-media';
    $classes[] = 'hero--media-' . sanitize_html_class( $image_position );
}

// Build wrapper attributes (align/anchor + extra classes)
$wrapper_attrs = get_block_wrapper_attributes( [
    'class' => implode( ' ', $classes ),
] );

// Inline background-image style if needed
$bg_style = '';
if ( $image_mode === 'background' && $image_id ) {
    $img_url = wp_get_attachment_image_url( $image_id, 'full' );
    if ( $img_url ) {
        $bg_style = ' style="background-image:url(' . esc_url( $img_url ) . ');"';
    }
}

?>
<section <?php echo $wrapper_attrs; ?><?php echo $bg_style; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <?php if ( $overlay_enabled ) : ?>
        <div class="hero__overlay" style="opacity: <?php echo esc_attr( $overlay_opacity ); ?>"></div>
    <?php endif; ?>

    <div class="<?php echo $layout === 'contained' ? 'container' : 'hero__inner'; ?>">
        <div class="hero__grid">
            <div class="hero__content">
                <?php if ( $tagline ) : ?>
                    <p class="hero__tagline"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="hero__title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <?php if ( $subtitle ) : ?>
                    <p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>

                <?php if ( $text ) : ?>
                    <div class="hero__text">
                        <?php echo wp_kses_post( $text ); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $cta_1_label && $cta_1_url ) : ?>
                    <div class="hero__actions">
                        <a class="btn btn--<?php echo esc_attr( $cta_1_style ); ?>" href="<?php echo esc_url( $cta_1_url ); ?>">
                            <?php echo esc_html( $cta_1_label ); ?>
                        </a>
                        <?php if ( $cta_2_label && $cta_2_url ) : ?>
                            <a class="btn btn--<?php echo esc_attr( $cta_2_style ); ?>" href="<?php echo esc_url( $cta_2_url ); ?>">
                                <?php echo esc_html( $cta_2_label ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ( $image_mode === 'media' ) : ?>
                <div class="hero__media">
                    <?php if ( $media_type === 'image' && $image_id ) : ?>
                        <?php echo wp_get_attachment_image( $image_id, 'large', false, [ 'class' => 'hero__img' ] ); ?>
                    <?php elseif ( $media_type === 'video' && $video_url ) : ?>
                        <div class="hero__video">
                            <?php echo wp_oembed_get( esc_url( $video_url ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
