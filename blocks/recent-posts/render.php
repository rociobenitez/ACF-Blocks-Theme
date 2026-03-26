<?php
/**
 * Recent Posts Block
 *
 * Styles: cards (default) | minimal | overlay
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

// ── Header fields ──────────────────────────────────────────────────
$tagline          = get_field( 'tagline' ) ?: '';
$tagline_position = get_field( 'tagline_position' ) ?: 'below';
$tagline_tag      = get_field( 'tagline_tag' ) ?: 'p';
$title            = get_field( 'title' ) ?: '';
$title_tag        = get_field( 'title_tag' ) ?: 'h2';
$description      = get_field( 'description' ) ?: '';
$header_align     = get_field( 'header_align' ) ?: 'center';
$header_width     = get_field( 'header_width' ) ?: 'narrow';

// ── Posts settings ─────────────────────────────────────────────────
$posts_count    = get_field( 'posts_count' ) ?: '3';
$card_title_tag = get_field( 'card_title_tag' ) ?: 'h3';
$cta            = get_field( 'cta' ) ?: null;
$cta_style      = get_field( 'cta_style' ) ?: 'link';

// ── Design ─────────────────────────────────────────────────────────
$aspect_ratio  = get_field( 'aspect_ratio' ) ?: 'auto';
$border_radius = get_field( 'border_radius' ) ?: 'md';
$shadow        = get_field( 'shadow' );
$bg_color      = get_field( 'bg_color' ) ?: 'light';
$padding_y     = get_field( 'padding_y' ) ?: 'md';

// ── Variant detection ──────────────────────────────────────────────
$class_name = $block['className'] ?? '';
$is_minimal = str_contains( $class_name, 'is-style-minimal' );
$is_overlay = str_contains( $class_name, 'is-style-overlay' );

// Validate card title tag.
$allowed_card_tags = [ 'h3', 'h4', 'p' ];
if ( ! in_array( $card_title_tag, $allowed_card_tags, true ) ) {
	$card_title_tag = 'h3';
}

// ── Query ──────────────────────────────────────────────────────────
$recent_posts = new WP_Query( [
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => (int) $posts_count,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'no_found_rows'  => true,
] );

$is_preview = ! empty( $is_preview );

if ( ! $recent_posts->have_posts() && ! $is_preview ) {
	return;
}

// ── Wrapper classes ────────────────────────────────────────────────
$classes   = [ 'recent-posts' ];
$classes[] = 'recent-posts--py-' . sanitize_html_class( $padding_y );
$classes[] = 'recent-posts--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'recent-posts--cols-' . sanitize_html_class( $posts_count );
$classes[] = 'recent-posts--radius-' . sanitize_html_class( $border_radius );

if ( $shadow ) {
	$classes[] = 'recent-posts--shadow';
}

// When user picks a custom ratio, override the variant default via custom property.
// Each variant sets its own --rp-ratio default; this inline style wins by cascade.
$inline_style = '';
if ( $aspect_ratio !== 'auto' ) {
	$inline_style = '--rp-ratio: ' . esc_attr( $aspect_ratio ) . ';';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
	'style' => $inline_style,
] );

// ── Image size per variant ─────────────────────────────────────────
$thumb_size = 'medium_large';
if ( $is_overlay ) {
	$thumb_size = 'large';
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

		<?php if ( $recent_posts->have_posts() ) : ?>
			<div class="recent-posts__grid">
				<?php while ( $recent_posts->have_posts() ) : $recent_posts->the_post(); ?>
					<article class="recent-posts__card">
						<a href="<?php the_permalink(); ?>" class="recent-posts__link">

							<div class="recent-posts__media">
								<?php if ( has_post_thumbnail() ) : ?>
									<?php the_post_thumbnail( $thumb_size, [
										'class'   => 'recent-posts__img',
										'loading' => 'lazy',
										'alt'     => get_the_title(),
									] ); ?>
								<?php endif; ?>

								<?php if ( $is_overlay ) : ?>
									<div class="recent-posts__gradient" aria-hidden="true"></div>
								<?php endif; ?>
							</div>

							<div class="recent-posts__body">
								<?php if ( ! $is_minimal ) :
									$categories = get_the_category();
								?>
									<div class="recent-posts__meta">
										<time class="recent-posts__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
											<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
										</time>
										<?php if ( ! empty( $categories ) ) : ?>
											<span class="recent-posts__category"><?php echo esc_html( $categories[0]->name ); ?></span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<<?php echo $card_title_tag; ?> class="recent-posts__title">
									<?php the_title(); ?>
								</<?php echo $card_title_tag; ?>>

								<?php if ( ! $is_minimal && ! $is_overlay ) : ?>
									<p class="recent-posts__excerpt">
										<?php echo esc_html( wp_trim_words( get_the_excerpt(), 15, '…' ) ); ?>
									</p>
								<?php endif; ?>
							</div>

						</a>
					</article>
				<?php endwhile; ?>
			</div>
		<?php elseif ( $is_preview ) : ?>
			<div class="recent-posts__grid">
				<div class="recent-posts__placeholder">
					<p>No se encontraron posts publicados.</p>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( is_array( $cta ) && ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
			<div class="recent-posts__cta">
				<?php
				$cta_target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
				$cta_cls    = $cta_style === 'link' ? 'recent-posts__cta-link' : 'btn btn--md btn--' . esc_attr( $cta_style );
				?>
				<a class="<?php echo esc_attr( $cta_cls ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta_target; // phpcs:ignore ?>><?php echo esc_html( $cta['title'] ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</section>
<?php wp_reset_postdata(); ?>
