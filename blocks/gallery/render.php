<?php
/**
 * Gallery Block
 *
 * Responsive image grid with optional lightbox.
 * Uses wp_get_attachment_image() for automatic srcset/sizes.
 */

defined( 'ABSPATH' ) || exit;

// Header fields.
$tagline          = get_field( 'tagline' ) ?: '';
$tagline_position = get_field( 'tagline_position' ) ?: 'above';
$tagline_tag      = get_field( 'tagline_tag' ) ?: 'p';
$title            = get_field( 'title' ) ?: '';
$title_tag        = get_field( 'title_tag' ) ?: 'h2';
$description      = get_field( 'description' ) ?: '';
$header_align     = get_field( 'header_align' ) ?: 'center';
$header_width     = get_field( 'header_width' ) ?: 'narrow';

// Gallery.
$images = get_field( 'images' ) ?: [];

// Design options.
$columns       = get_field( 'columns' ) ?: '3';
$aspect_ratio  = get_field( 'aspect_ratio' ) ?: '4/3';
$gap           = get_field( 'gap' ) ?: 'sm';
$border_radius = get_field( 'border_radius' );
$lightbox      = get_field( 'lightbox' );
$bg_color      = get_field( 'bg_color' ) ?: 'dark';
$padding_y     = get_field( 'padding_y' ) ?: 'md';

$is_preview = ! empty( $is_preview );

// Bail if no images and not in editor.
if ( empty( $images ) && ! $is_preview ) {
	return;
}

// Build section classes.
$classes   = [ 'gallery' ];
$classes[] = 'gallery--py-' . sanitize_html_class( $padding_y );
$classes[] = 'gallery--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'gallery--cols-' . sanitize_html_class( $columns );
$classes[] = 'gallery--gap-' . sanitize_html_class( $gap );

if ( $aspect_ratio !== 'original' ) {
	$classes[] = 'gallery--fixed-ratio';
}
if ( $border_radius ) {
	$classes[] = 'gallery--rounded';
}
if ( $lightbox ) {
	$classes[] = 'gallery--has-lightbox';
}

// Inline custom property for aspect ratio.
$inline_style = '';
if ( $aspect_ratio !== 'original' ) {
	$inline_style = '--gallery-ratio: ' . esc_attr( $aspect_ratio ) . ';';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
	'style' => $inline_style,
] );

// Choose thumbnail size based on columns to optimize payload.
$thumb_size = 'large';
if ( (int) $columns >= 4 ) {
	$thumb_size = 'medium_large';
}
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?>>
	<div class="container">

		<?php if ( $tagline || $title || $description ) : ?>
			<?php
			echo render_component( 'header-section', [
				'tagline'          => $tagline,
				'tagline_position' => $tagline_position,
				'tagline_tag'      => $tagline_tag,
				'title'            => $title,
				'title_tag'        => $title_tag,
				'description'      => $description,
				'align'            => $header_align,
				'width'            => $header_width,
			] );
			?>
		<?php endif; ?>

		<?php if ( ! empty( $images ) ) : ?>
			<div class="gallery__grid" role="list">
				<?php foreach ( $images as $index => $image_id ) :
					$alt      = get_post_meta( $image_id, '_wp_attachment_image_alt', true ) ?: '';
					$caption  = wp_get_attachment_caption( $image_id ) ?: '';
					$full_url = wp_get_attachment_image_url( $image_id, 'full' );

					// Determine sizes attribute based on column count.
					$sizes_attr = '(min-width: 64rem) ' . round( 100 / (int) $columns ) . 'vw, (min-width: 48rem) 50vw, 100vw';

					$img_attrs = [
						'class'    => 'gallery__img',
						'loading'  => $index < (int) $columns ? 'eager' : 'lazy',
						'decoding' => 'async',
						'sizes'    => $sizes_attr,
					];
				?>
					<figure class="gallery__item" role="listitem">
						<?php if ( $lightbox && $full_url ) : ?>
							<a class="gallery__link"
							   href="<?php echo esc_url( $full_url ); ?>"
							   data-gallery-index="<?php echo (int) $index; ?>"
							   data-gallery-caption="<?php echo esc_attr( $caption ); ?>"
							   aria-label="<?php echo esc_attr( $alt ? sprintf( 'Ampliar imagen: %s', $alt ) : 'Ampliar imagen' ); ?>">
								<?php echo wp_get_attachment_image( $image_id, $thumb_size, false, $img_attrs ); ?>
							</a>
						<?php else : ?>
							<?php echo wp_get_attachment_image( $image_id, $thumb_size, false, $img_attrs ); ?>
						<?php endif; ?>

						<?php if ( $caption ) : ?>
							<figcaption class="gallery__caption"><?php echo esc_html( $caption ); ?></figcaption>
						<?php endif; ?>
					</figure>
				<?php endforeach; ?>
			</div>
		<?php elseif ( $is_preview ) : ?>
			<div class="gallery__grid">
				<div class="gallery__placeholder">
					<p>Añade imágenes desde la pestaña Galería</p>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>
