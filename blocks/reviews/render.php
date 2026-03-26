<?php
/**
 * Reviews Block
 *
 * Styles: google (default) | testimonials | cards
 */

defined( 'ABSPATH' ) || exit;

// Header
$tagline          = get_field( 'tagline' ) ?: '';
$tagline_position = get_field( 'tagline_position' ) ?: 'above';
$tagline_tag      = get_field( 'tagline_tag' ) ?: 'p';
$title            = get_field( 'title' ) ?: '';
$title_tag        = get_field( 'title_tag' ) ?: 'h2';
$description      = get_field( 'description' ) ?: '';
$header_align     = get_field( 'header_align' ) ?: 'center';
$header_width     = get_field( 'header_width' ) ?: 'narrow';

// Items (manual reviews)
$items = get_field( 'items' ) ?: [];

// Design
$columns            = get_field( 'columns' ) ?: '2';
$testimonial_accent = get_field( 'testimonial_accent' ) ?: 'alternate';
$card_align         = get_field( 'card_align' ) ?: 'left';
$card_radius        = get_field( 'card_radius' ) ?: 'rounded';
$bg_color           = get_field( 'bg_color' ) ?: 'default';
$padding_y          = get_field( 'padding_y' ) ?: 'md';
$cta                = get_field( 'cta' ) ?: null;
$cta_size           = get_field( 'cta_size' ) ?: 'md';
$cta_style          = get_field( 'cta_style' ) ?: 'primary';

// Style detection
$class_name   = $block['className'] ?? '';
$active_style = 'google';
if ( str_contains( $class_name, 'is-style-testimonials' ) ) {
	$active_style = 'testimonials';
} elseif ( str_contains( $class_name, 'is-style-cards' ) ) {
	$active_style = 'cards';
}

$is_google = $active_style === 'google';
$is_manual = ! $is_google;

// Google data from options
$shortcode_reviews = '';
$link_reviews      = '';
if ( $is_google ) {
	$shortcode_reviews = get_field( 'shortcode_reviews', 'option' ) ?: '';
	$link_reviews      = get_field( 'link_reviews', 'option' ) ?: '';
}

// Build section classes
$classes   = [ 'reviews' ];
$classes[] = 'reviews--py-' . sanitize_html_class( $padding_y );
$classes[] = 'reviews--bg-' . sanitize_html_class( $bg_color );

if ( $is_manual ) {
	$classes[] = 'reviews--cols-' . sanitize_html_class( $columns );
}
if ( $is_manual ) {
	$classes[] = 'reviews--card-' . sanitize_html_class( $card_align );
	$classes[] = 'reviews--radius-' . sanitize_html_class( $card_radius );
}
if ( $active_style === 'testimonials' ) {
	$classes[] = 'reviews--accent-' . sanitize_html_class( $testimonial_accent );
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

$is_preview = ! empty( $is_preview );

// Bail if nothing to show
if ( $is_google && empty( $shortcode_reviews ) && ! $is_preview ) {
	return;
}
if ( $is_manual && empty( $items ) && ! $is_preview ) {
	return;
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

		<?php if ( $is_google ) : ?>
			<!-- Google reviews (shortcode) -->
			<?php if ( ! empty( $shortcode_reviews ) ) : ?>
				<div class="reviews__shortcode">
					<?php echo do_shortcode( $shortcode_reviews ); ?>
				</div>
			<?php elseif ( $is_preview ) : ?>
				<div class="reviews__placeholder">
					<p>Configura el shortcode de reseñas en la página de opciones</p>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $link_reviews ) ) : ?>
				<div class="reviews__cta">
					<a class="btn btn--sm btn--outline"
					   href="<?php echo esc_url( $link_reviews ); ?>"
					   target="_blank"
					   rel="noopener noreferrer">
						<?php esc_html_e( 'Ver todas las resenas', 'acf-starter-theme' ); ?>
					</a>
				</div>
			<?php endif; ?>

		<?php elseif ( $active_style === 'testimonials' ) : ?>
			<!-- Testimonials: photo + quote panel -->
			<?php if ( ! empty( $items ) ) : ?>
				<div class="reviews__testimonials">
					<?php foreach ( $items as $i => $item ) :
						$quote  = $item['quote'] ?? '';
						$author = $item['author'] ?? '';
						$role   = $item['role'] ?? '';
						$photo  = $item['photo'] ?? 0;

						if ( ! $quote || ! $author ) {
							continue;
						}
					?>
						<article class="reviews__testimonial <?php echo $i % 2 !== 0 ? 'reviews__testimonial--reversed' : ''; ?>">
							<?php if ( $photo ) : ?>
								<div class="reviews__testimonial-photo">
									<?php echo wp_get_attachment_image( $photo, 'medium_large', false, [
										'class'    => 'reviews__testimonial-image',
										'decoding' => 'async',
									] ); ?>
								</div>
							<?php endif; ?>

							<div class="reviews__testimonial-body">
								<blockquote class="reviews__testimonial-quote">
									<p>&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
								</blockquote>
								<footer class="reviews__testimonial-footer">
									<cite class="reviews__testimonial-author"><?php echo esc_html( $author ); ?></cite>
									<?php if ( $role ) : ?>
										<span class="reviews__testimonial-role"><?php echo esc_html( $role ); ?></span>
									<?php endif; ?>
								</footer>
							</div>
						</article>
					<?php endforeach; ?>
				</div>
			<?php elseif ( $is_preview ) : ?>
				<div class="reviews__placeholder">
					<p>Anade resenas desde el panel lateral</p>
				</div>
			<?php endif; ?>

		<?php elseif ( $active_style === 'cards' ) : ?>
			<!-- Cards: simple quote cards in grid -->
			<?php if ( ! empty( $items ) ) : ?>
				<div class="reviews__cards">
					<?php foreach ( $items as $item ) :
						$quote  = $item['quote'] ?? '';
						$author = $item['author'] ?? '';
						$role   = $item['role'] ?? '';
						$photo  = $item['photo'] ?? 0;

						if ( ! $quote || ! $author ) {
							continue;
						}
					?>
						<article class="reviews__card">
							<blockquote class="reviews__card-quote">
								<p>&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p>
							</blockquote>
							<footer class="reviews__card-footer">
								<?php if ( $photo ) : ?>
									<?php echo wp_get_attachment_image( $photo, 'thumbnail', false, [
										'class'    => 'reviews__card-avatar',
										'decoding' => 'async',
									] ); ?>
								<?php endif; ?>
								<div class="reviews__card-meta">
									<cite class="reviews__card-author"><?php echo esc_html( $author ); ?></cite>
									<?php if ( $role ) : ?>
										<span class="reviews__card-role"><?php echo esc_html( $role ); ?></span>
									<?php endif; ?>
								</div>
							</footer>
						</article>
					<?php endforeach; ?>
				</div>
			<?php elseif ( $is_preview ) : ?>
				<div class="reviews__placeholder">
					<p>Anade resenas desde el panel lateral</p>
				</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php
		// CTA: manual mode uses the block's CTA field; Google mode uses options link (already rendered above)
		if ( $is_manual && is_array( $cta ) && ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) :
			$cta_target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
		?>
			<div class="reviews__cta">
				<a class="btn btn--<?php echo esc_attr( $cta_size ); ?> btn--<?php echo esc_attr( $cta_style ); ?>"
				   href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta_target; // phpcs:ignore ?>>
					<?php echo esc_html( $cta['title'] ); ?>
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>
