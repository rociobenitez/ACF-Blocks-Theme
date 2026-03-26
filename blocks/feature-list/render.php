<?php
/**
 * Feature List Block
 *
 * Styles: split | cards
 */

defined( 'ABSPATH' ) || exit;

// Header
$tagline          = get_field( 'tagline' ) ?: '';
$tagline_position = get_field( 'tagline_position' ) ?: 'above';
$tagline_tag      = get_field( 'tagline_tag' ) ?: 'p';
$title            = get_field( 'title' ) ?: '';
$title_tag        = get_field( 'title_tag' ) ?: 'h2';
$description      = get_field( 'description' ) ?: '';
$header_align     = get_field( 'header_align' ) ?: 'left';
$header_width     = get_field( 'header_width' ) ?: 'full';

// Items
$items = get_field( 'items' ) ?: [];

// Design
$columns   = get_field( 'columns' ) ?: '3';
$bg_color  = get_field( 'bg_color' ) ?: 'light';
$padding_y = get_field( 'padding_y' ) ?: 'md';
$cta       = get_field( 'cta' ) ?: null;
$cta_size  = get_field( 'cta_size' ) ?: 'md';
$cta_style = get_field( 'cta_style' ) ?: 'primary';

// Style detection
$class_name   = $block['className'] ?? '';
$active_style = 'split';
if ( str_contains( $class_name, 'is-style-cards' ) ) {
	$active_style = 'cards';
}

$is_split = $active_style === 'split';

// Build section classes
$classes   = [ 'feature-list' ];
$classes[] = 'feature-list--py-' . sanitize_html_class( $padding_y );
$classes[] = 'feature-list--bg-' . sanitize_html_class( $bg_color );

if ( ! $is_split ) {
	$classes[] = 'feature-list--cols-' . sanitize_html_class( $columns );
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

$is_preview = ! empty( $is_preview );

// Bail if no items and not in editor
if ( empty( $items ) && ! $is_preview ) {
	return;
}

// Validate allowed item title tags
$allowed_item_tags = [ 'p', 'h3' ];
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?>>
	<div class="container">

		<?php if ( $is_split ) : ?>
			<!-- Split layout: header left + items right -->
			<div class="feature-list__split">

				<?php if ( $tagline || $title || $description ) : ?>
					<div class="feature-list__header">
						<?php
						echo render_component( 'header-section', [
							'tagline'          => $tagline,
							'tagline_position' => $tagline_position,
							'tagline_tag'      => $tagline_tag,
							'title'            => $title,
							'title_tag'        => $title_tag,
							'description'      => $description,
							'align'            => 'left',
							'width'            => 'full',
						] );
						?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $items ) ) : ?>
					<div class="feature-list__items">
						<?php foreach ( $items as $item ) :
							$item_title   = $item['title'] ?? '';
							$item_tag     = $item['title_tag'] ?? 'p';
							$item_content = $item['content'] ?? '';
							$item_link    = $item['link'] ?? null;

							if ( ! $item_title ) {
								continue;
							}
							if ( ! in_array( $item_tag, $allowed_item_tags, true ) ) {
								$item_tag = 'p';
							}

							$has_link = is_array( $item_link ) && ! empty( $item_link['url'] );
						?>
							<article class="feature-list__item">
								<<?php echo $item_tag; ?> class="feature-list__item-title"><?php echo esc_html( $item_title ); ?></<?php echo $item_tag; ?>>

								<?php if ( $item_content ) : ?>
									<div class="feature-list__item-content"><?php echo wp_kses_post( $item_content ); ?></div>
								<?php endif; ?>

								<?php if ( $has_link ) : ?>
									<div class="feature-list__item-link-wrap">
										<a class="feature-list__item-link"
										   href="<?php echo esc_url( $item_link['url'] ); ?>"
										   <?php echo ! empty( $item_link['target'] ) ? 'target="' . esc_attr( $item_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
											<?php echo esc_html( $item_link['title'] ?: __( 'Saber más', 'acf-starter-theme' ) ); ?>
										</a>
									</div>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php elseif ( $is_preview ) : ?>
					<div class="feature-list__items">
						<div class="feature-list__placeholder">
							<p>Añade items desde el panel lateral</p>
						</div>
					</div>
				<?php endif; ?>

			</div>

		<?php else : ?>
			<!-- Cards layout: header top + grid below -->

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

			<?php if ( ! empty( $items ) ) : ?>
				<div class="feature-list__grid">
					<?php foreach ( $items as $item ) :
						$item_title   = $item['title'] ?? '';
						$item_tag     = $item['title_tag'] ?? 'p';
						$item_content = $item['content'] ?? '';
						$item_link    = $item['link'] ?? null;

						if ( ! $item_title ) {
							continue;
						}
						if ( ! in_array( $item_tag, $allowed_item_tags, true ) ) {
							$item_tag = 'p';
						}

						$has_link = is_array( $item_link ) && ! empty( $item_link['url'] );
					?>
						<article class="feature-list__card">
							<<?php echo $item_tag; ?> class="feature-list__item-title"><?php echo esc_html( $item_title ); ?></<?php echo $item_tag; ?>>

							<?php if ( $item_content ) : ?>
								<div class="feature-list__item-content"><?php echo wp_kses_post( $item_content ); ?></div>
							<?php endif; ?>

							<?php if ( $has_link ) : ?>
								<div class="feature-list__item-link-wrap">
									<a class="feature-list__item-link"
									   href="<?php echo esc_url( $item_link['url'] ); ?>"
									   <?php echo ! empty( $item_link['target'] ) ? 'target="' . esc_attr( $item_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>>
										<?php echo esc_html( $item_link['title'] ?: __( 'Saber más', 'acf-starter-theme' ) ); ?>
									</a>
								</div>
							<?php endif; ?>
						</article>
					<?php endforeach; ?>
				</div>
			<?php elseif ( $is_preview ) : ?>
				<div class="feature-list__grid">
					<div class="feature-list__placeholder">
						<p>Añade items desde el panel lateral</p>
					</div>
				</div>
			<?php endif; ?>

		<?php endif; ?>

		<?php if ( is_array( $cta ) && ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
			<div class="feature-list__cta">
				<?php
				$cta_target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
				?>
				<a class="btn btn--<?php echo esc_attr( $cta_size ); ?> btn--<?php echo esc_attr( $cta_style ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta_target; // phpcs:ignore ?>><?php echo esc_html( $cta['title'] ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</section>
