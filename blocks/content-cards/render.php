<?php
/**
 * Content Cards Block
 *
 * Styles: alternated | grid | grid-icons | text-only
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

// Cards
$cards = get_field( 'cards' ) ?: [];

// Design
$columns    = get_field( 'columns' ) ?: '3';
$link_style = get_field( 'link_style' ) ?: 'card';
$bg_color   = get_field( 'bg_color' ) ?: 'default';
$padding_y  = get_field( 'padding_y' ) ?: 'md';
$cta        = get_field( 'cta' ) ?: null;
$cta_style  = get_field( 'cta_style' ) ?: 'primary';

// Style detection
$class_name   = $block['className'] ?? '';
$active_style = 'alternated';
foreach ( [ 'grid-icons', 'grid', 'text-only', 'alternated' ] as $s ) {
	if ( str_contains( $class_name, 'is-style-' . $s ) ) {
		$active_style = $s;
		break;
	}
}

$show_images  = $active_style !== 'text-only';
$is_icon_style = $active_style === 'grid-icons';
$is_alternated = $active_style === 'alternated';

// Build section classes
$classes   = [ 'content-cards' ];
$classes[] = 'content-cards--py-' . sanitize_html_class( $padding_y );
$classes[] = 'content-cards--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'content-cards--link-' . sanitize_html_class( $link_style );

if ( ! $is_alternated ) {
	$classes[] = 'content-cards--cols-' . sanitize_html_class( $columns );
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

$is_preview = ! empty( $is_preview );

// Bail if no cards and not in editor
if ( empty( $cards ) && ! $is_preview ) {
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

		<?php if ( ! empty( $cards ) ) : ?>
			<div class="content-cards__list">
				<?php foreach ( $cards as $i => $card ) :
					$card_title = $card['title'] ?? '';
					$card_desc  = $card['description'] ?? '';
					$card_image = (int) ( $card['image'] ?? 0 );
					$card_link  = $card['link'] ?? null;

					// Skip cards without title
					if ( ! $card_title ) {
						continue;
					}

					// Link logic
					$has_link     = is_array( $card_link ) && ! empty( $card_link['url'] );
					$is_card_link = $has_link && $link_style === 'card';
					$show_link    = $has_link && $link_style === 'link';

					// Card tag
					$card_tag       = $is_card_link ? 'a' : 'div';
					$card_link_attr = '';
					if ( $is_card_link ) {
						$card_link_attr = ' href="' . esc_url( $card_link['url'] ) . '"';
						if ( ! empty( $card_link['target'] ) ) {
							$card_link_attr .= ' target="' . esc_attr( $card_link['target'] ) . '" rel="noopener noreferrer"';
						}
					}

					$card_classes = 'content-cards__card';
					if ( $is_card_link ) {
						$card_classes .= ' content-cards__card--linked';
					}

					// Image size: 'full' for alternated (cards are large),
					// 'medium_large' for grid, 'thumbnail' for icons
					$img_size = 'medium_large';
					if ( $is_alternated ) {
						$img_size = 'full';
					} elseif ( $is_icon_style ) {
						$img_size = 'thumbnail';
					}

					// Sizes attribute: tells the browser the rendered width
					// so it picks the right srcset candidate (including retina)
					$img_sizes = '(max-width: 48rem) 100vw, 50vw';
					if ( $is_alternated ) {
						$img_sizes = '(max-width: 48rem) 100vw, 50vw';
					} elseif ( $columns === '4' ) {
						$img_sizes = '(max-width: 48rem) 50vw, 25vw';
					} elseif ( $columns === '3' ) {
						$img_sizes = '(max-width: 48rem) 50vw, 33vw';
					}
				?>
					<<?php echo $card_tag; ?> class="<?php echo esc_attr( $card_classes ); ?>"<?php echo $card_link_attr; // phpcs:ignore ?>>

						<div class="content-cards__card-body">
							<h3 class="content-cards__card-title"><?php echo esc_html( $card_title ); ?></h3>

							<?php if ( $card_desc ) : ?>
								<p class="content-cards__card-desc"><?php echo wp_kses_post( $card_desc ); ?></p>
							<?php endif; ?>

							<?php if ( $show_link ) : ?>
								<span class="content-cards__card-link">
									<?php echo esc_html( $card_link['title'] ?: __( 'Saber más', 'acf-starter-theme' ) ); ?>
								</span>
							<?php endif; ?>
						</div>

						<?php if ( $show_images && $card_image ) : ?>
							<div class="content-cards__card-media">
								<?php echo wp_get_attachment_image( $card_image, $img_size, false, [
									'class'    => 'content-cards__card-img',
									'sizes'    => $img_sizes,
									'decoding' => 'async',
								] ); ?>
							</div>
						<?php endif; ?>

					</<?php echo $card_tag; ?>>
				<?php endforeach; ?>
			</div>
		<?php elseif ( $is_preview ) : ?>
			<div class="content-cards__list">
				<div class="content-cards__card content-cards__card--placeholder">
					<div class="content-cards__card-body">
						<p>Añade cards desde el panel lateral</p>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( is_array( $cta ) && ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
			<div class="content-cards__cta">
				<?php
				$cta_target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
				?>
				<a class="btn btn--lg btn--<?php echo esc_attr( $cta_style ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta_target; // phpcs:ignore ?>><?php echo esc_html( $cta['title'] ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</section>
