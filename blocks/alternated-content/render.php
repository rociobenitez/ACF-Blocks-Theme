<?php
/**
 * Alternated Content Block
 *
 * Layouts: contained (inside container) | edge (image to viewport edge)
 * Image widths: narrow (33%) | medium (42%) | half (50%)
 */

defined( 'ABSPATH' ) || exit;

// Content
$tagline          = get_field( 'tagline' ) ?: '';
$tagline_position = get_field( 'tagline_position' ) ?: 'above';
$title            = get_field( 'title' ) ?: '';
$content          = get_field( 'content' ) ?: '';

// CTA
$btn_1       = get_field( 'primary_button' ) ?: null;
$btn_2       = get_field( 'secondary_button' ) ?: null;
$btn_1_style = get_field( 'primary_button_style' ) ?: 'primary';
$btn_2_style = get_field( 'secondary_button_style' ) ?: 'link';

// Image
$image          = (int) get_field( 'image' );
$image_position = get_field( 'image_position' ) ?: 'right';
$image_width    = get_field( 'image_width' ) ?: 'medium';
$image_layout   = get_field( 'image_layout' ) ?: 'contained';
$image_fit      = get_field( 'image_fit' ) ?: 'cover';

// Design
$bg_color       = get_field( 'bg_color' ) ?: 'default';
$padding_y      = get_field( 'padding_y' ) ?: 'md';
$vertical_align = get_field( 'vertical_align' ) ?: 'center';

// Text color logic
$is_dark_bg = $bg_color === 'dark';

// Build classes
$classes   = [ 'alternated-content' ];
$classes[] = 'alternated-content--py-' . sanitize_html_class( $padding_y );
$classes[] = 'alternated-content--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'alternated-content--valign-' . sanitize_html_class( $vertical_align );
$classes[] = 'alternated-content--img-' . sanitize_html_class( $image_position );
$classes[] = 'alternated-content--imgw-' . sanitize_html_class( $image_width );
$classes[] = 'alternated-content--layout-' . sanitize_html_class( $image_layout );
$classes[] = 'alternated-content--fit-' . sanitize_html_class( $image_fit );

if ( $is_dark_bg ) {
	$classes[] = 'alternated-content--text-light';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

// Button helper
$render_btn = static function ( $link, $style = 'primary' ) {
	if ( ! is_array( $link ) ) {
		return '';
	}
	$label = $link['title'] ?? '';
	$url   = $link['url'] ?? '';
	if ( ! $label || ! $url ) {
		return '';
	}
	$target = ! empty( $link['target'] ) ? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"' : '';

	if ( $style === 'link' ) {
		return sprintf(
			'<a class="alternated-content__link" href="%1$s"%2$s>%3$s</a>',
			esc_url( $url ),
			$target,
			esc_html( $label )
		);
	}

	return sprintf(
		'<a class="btn btn--md btn--%1$s" href="%2$s"%3$s>%4$s</a>',
		esc_attr( $style ),
		esc_url( $url ),
		$target,
		esc_html( $label )
	);
};

$is_preview = ! empty( $is_preview );
$is_edge    = $image_layout === 'edge';

// Image size: use 'large' (1024px) for narrow, '1536x1536' for medium/half/edge
$img_size = $image_width === 'narrow' && ! $is_edge ? 'large' : '1536x1536';

// Responsive sizes attribute — tells the browser the actual rendered width
$sizes_map = [
	'narrow' => '(max-width: 48rem) 100vw, 33vw',
	'medium' => '(max-width: 48rem) 100vw, 42vw',
	'half'   => '(max-width: 48rem) 100vw, 50vw',
];
$img_sizes = $sizes_map[ $image_width ] ?? $sizes_map['medium'];

// --- Render content (reused in both layouts) ---
$render_content = static function () use ( $tagline, $tagline_position, $title, $content, $btn_1, $btn_2, $btn_1_style, $btn_2_style, $render_btn ) {
	if ( $tagline && $tagline_position === 'above' ) : ?>
		<p class="alternated-content__tagline"><?php echo esc_html( $tagline ); ?></p>
	<?php endif;

	if ( $title ) : ?>
		<h2 class="alternated-content__title"><?php echo esc_html( $title ); ?></h2>
	<?php endif;

	if ( $tagline && $tagline_position === 'below' ) : ?>
		<p class="alternated-content__tagline"><?php echo esc_html( $tagline ); ?></p>
	<?php endif;

	if ( $content ) : ?>
		<div class="alternated-content__text"><?php echo wp_kses_post( $content ); ?></div>
	<?php endif;

	if ( $btn_1 || $btn_2 ) : ?>
		<div class="alternated-content__actions">
			<?php if ( $btn_1 ) : ?>
				<?php echo $render_btn( $btn_1, $btn_1_style ); // phpcs:ignore ?>
			<?php endif; ?>
			<?php if ( $btn_2 ) : ?>
				<?php echo $render_btn( $btn_2, $btn_2_style ); // phpcs:ignore ?>
			<?php endif; ?>
		</div>
	<?php endif;
};

// --- Render media ---
$render_media = static function () use ( $image, $img_size, $img_sizes, $is_preview ) {
	if ( $image ) : ?>
		<div class="alternated-content__media">
			<?php
			// Don't force loading="lazy" — let WordPress handle LCP detection (6.3+).
			// Provide accurate 'sizes' so the browser picks the right srcset candidate.
			echo wp_get_attachment_image( $image, $img_size, false, [
				'class'   => 'alternated-content__image',
				'sizes'   => $img_sizes,
				'decoding' => 'async',
			] );
			?>
		</div>
	<?php elseif ( $is_preview ) : ?>
		<div class="alternated-content__media alternated-content__media--placeholder">
			<p>Selecciona una imagen</p>
		</div>
	<?php endif;
};
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?>>

	<?php if ( $is_edge ) : ?>
		<div class="alternated-content__grid">
			<div class="alternated-content__content">
				<div class="alternated-content__inner">
					<?php $render_content(); ?>
				</div>
			</div>
			<?php $render_media(); ?>
		</div>

	<?php else : ?>
		<div class="container">
			<div class="alternated-content__grid">
				<div class="alternated-content__content">
					<?php $render_content(); ?>
				</div>
				<?php $render_media(); ?>
			</div>
		</div>
	<?php endif; ?>

</section>