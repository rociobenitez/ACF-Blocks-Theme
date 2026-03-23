<?php
/**
 * Hero Block
 *
 * Styles:  Centrado | Texto + Imagen (split) | Cover + Overlay
 * Backgrounds: color (5 presets) + optional image/video
 */

defined( 'ABSPATH' ) || exit;

// Content
$tagline   = get_field( 'tagline' ) ?: '';
$title     = get_field( 'title' ) ?: '';
$title_tag = get_field( 'title_tag' ) ?: 'h1';
$subtitle  = get_field( 'subtitle' ) ?: '';
$text      = get_field( 'text' ) ?: '';

// CTA
$cta_1       = get_field( 'cta' ) ?: null;
$cta_2       = get_field( 'cta_2' ) ?: null;
$cta_1_style = get_field( 'cta_style' ) ?: 'default';
$cta_2_style = get_field( 'cta_2_style' ) ?: 'transparent';

// Layout
$padding_y     = get_field( 'padding_y' ) ?: 'md';
$valign        = get_field( 'valign' ) ?: 'center';
$content_align = get_field( 'content_align' ) ?: 'left';

// Background
$bg_color       = get_field( 'bg_color' ) ?: 'default';
$bg_mode        = get_field( 'bg_mode' ) ?: 'none';
$image          = (int) get_field( 'image' );
$video_url      = get_field( 'video_url' );
$image_position = get_field( 'image_position' ) ?: 'right';

// Overlay
$overlay_on      = (bool) get_field( 'overlay_enabled' );
$overlay_opacity = (float) ( get_field( 'overlay_opacity' ) ?: 0.35 );

// Style detection
$class_name  = $block['className'] ?? '';
$is_centered = str_contains( $class_name, 'is-style-centered' );
$is_split    = str_contains( $class_name, 'is-style-split' );
$is_overlay  = str_contains( $class_name, 'is-style-overlay' );

// Text color logic
$has_media_bg = $bg_mode !== 'none';
$is_dark_bg   = in_array( $bg_color, [ 'dark', 'primary' ], true );
$text_light   = $has_media_bg || $is_dark_bg;

// Build classes
$classes   = [ 'hero' ];
$classes[] = 'hero--py-' . sanitize_html_class( $padding_y );
$classes[] = 'hero--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'hero--valign-' . sanitize_html_class( $valign );

if ( $text_light ) {
	$classes[] = 'hero--text-light';
}

// Content align: centered style always centers via CSS, so skip for centered
if ( ! $is_centered && $content_align === 'center' ) {
	$classes[] = 'hero--text-center';
}

// Split: image position
if ( $is_split && $image_position === 'left' ) {
	$classes[] = 'hero--img-left';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

// Background image (inline style)
$bg_style = '';
if ( $bg_mode === 'image' && ! $is_split && $image ) {
	$img_url = wp_get_attachment_image_url( $image, 'full' );
	if ( $img_url ) {
		$bg_style = ' style="background-image:url(' . esc_url( $img_url ) . ');"';
	}
}

// Background video
$has_bg_video   = false;
$video_file_url = '';
if ( $bg_mode === 'video' && ! $is_split && $video_url ) {
	$video_file_url = wp_get_attachment_url( $video_url );
	if ( $video_file_url ) {
		$has_bg_video = true;
	}
}

// Helpers
$render_btn = static function ( $link, $variant = 'primary' ) {
	if ( ! is_array( $link ) ) {
		return '';
	}
	$label = $link['title'] ?? '';
	$url   = $link['url'] ?? '';
	if ( ! $label || ! $url ) {
		return '';
	}
	$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';
	return sprintf(
		'<a class="btn btn--lg btn--%1$s" href="%2$s"%3$s>%4$s</a>',
		esc_attr( $variant ),
		esc_url( $url ),
		$target,
		esc_html( $label )
	);
};

$allowed_tags = [ 'h1', 'h2' ];
$title_tag    = in_array( $title_tag, $allowed_tags, true ) ? $title_tag : 'h1';

$is_preview = ! empty( $is_preview );
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?><?php echo $bg_style; ?>>

	<?php if ( $has_bg_video ) : ?>
		<div class="hero__bg-video">
			<?php if ( $is_preview ) : ?>
				<div class="hero__bg-video-placeholder">
					<span><?php esc_html_e( 'Vídeo de fondo', 'st-starter' ); ?></span>
				</div>
			<?php else : ?>
				<video
					class="hero__bg-video-element"
					autoplay muted loop playsinline
					aria-hidden="true"
					preload="metadata">
					<source src="<?php echo esc_url( $video_file_url ); ?>" type="<?php echo esc_attr( get_post_mime_type( $video_url ) ); ?>">
				</video>
				<span class="screen-reader-text"><?php esc_html_e( 'Vídeo decorativo de fondo', 'st-starter' ); ?></span>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<?php if ( $has_media_bg && $overlay_on ) : ?>
		<div class="hero__overlay" style="opacity:<?php echo esc_attr( $overlay_opacity ); ?>"></div>
	<?php endif; ?>

	<div class="hero__container container">
		<div class="hero__grid">

			<div class="hero__content">
				<?php if ( $tagline ) : ?>
					<p class="hero__tagline"><?php echo esc_html( $tagline ); ?></p>
				<?php endif; ?>

				<?php if ( $title ) : ?>
					<<?php echo $title_tag; ?> class="hero__title"><?php echo esc_html( $title ); ?></<?php echo $title_tag; ?>>
				<?php endif; ?>

				<?php if ( $subtitle ) : ?>
					<p class="hero__subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>

				<?php if ( $text ) : ?>
					<div class="hero__text"><?php echo wp_kses_post( $text ); ?></div>
				<?php endif; ?>

				<?php if ( $cta_1 ) : ?>
					<div class="hero__actions">
						<?php echo $render_btn( $cta_1, $cta_1_style ); // phpcs:ignore ?>
						<?php if ( $cta_2 ) : ?>
							<?php echo $render_btn( $cta_2, $cta_2_style ); // phpcs:ignore ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $is_split && $image ) : ?>
				<div class="hero__media">
					<?php echo wp_get_attachment_image( $image, 'large', false, [ 'class' => 'hero__img' ] ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>

</section>
