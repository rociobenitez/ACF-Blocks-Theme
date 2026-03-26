<?php
/**
 * Teams Block
 *
 * Styles: cards | round | minimal
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

// Members
$members          = get_field( 'members' ) ?: [];
$show_description = (bool) get_field( 'show_description' );
$show_contact     = (bool) get_field( 'show_contact' );

// Design
$card_align  = get_field( 'card_align' ) ?: 'center';
$card_radius = get_field( 'card_radius' ) ?: 'rounded';
$photo_ratio = get_field( 'photo_ratio' ) ?: '3/4';
$columns     = get_field( 'columns' ) ?: '3';
$grid_align  = get_field( 'grid_align' ) ?: 'center';
$bg_color    = get_field( 'bg_color' ) ?: 'light';
$padding_y   = get_field( 'padding_y' ) ?: 'md';
$grid_gap    = get_field( 'grid_gap' ) ?: 'md';
$cta         = get_field( 'cta' ) ?: null;
$cta_size    = get_field( 'cta_size' ) ?: 'md';
$cta_style   = get_field( 'cta_style' ) ?: 'primary';

$is_preview = ! empty( $is_preview );

// Bail if no members and not in editor
if ( empty( $members ) && ! $is_preview ) {
	return;
}

// Build section classes
$classes   = [ 'teams' ];
$classes[] = 'teams--py-' . sanitize_html_class( $padding_y );
$classes[] = 'teams--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'teams--cols-' . sanitize_html_class( $columns );
$classes[] = 'teams--card-' . sanitize_html_class( $card_align );
$classes[] = 'teams--radius-' . sanitize_html_class( $card_radius );
$classes[] = 'teams--grid-' . sanitize_html_class( $grid_align );
$classes[] = 'teams--gap-' . sanitize_html_class( $grid_gap );

// Validate photo_ratio
$allowed_ratios = [ '3/4', '1/1', '4/3', '16/9' ];
if ( ! in_array( $photo_ratio, $allowed_ratios, true ) ) {
	$photo_ratio = '3/4';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
	'style' => '--teams-photo-ratio: ' . esc_attr( $photo_ratio ) . ';',
] );

// Image sizes attribute based on columns
$img_sizes = '(max-width: 48rem) 50vw, 33vw';
if ( $columns === '4' ) {
	$img_sizes = '(max-width: 48rem) 50vw, 25vw';
} elseif ( $columns === '2' ) {
	$img_sizes = '(max-width: 48rem) 100vw, 50vw';
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

		<?php if ( ! empty( $members ) ) : ?>
			<div class="teams__grid">
				<?php foreach ( $members as $member ) :
					if ( ! $member || ! is_a( $member, 'WP_Post' ) ) {
						continue;
					}
					get_template_part( 'template-parts/components/team-member-card', null, [
						'post'             => $member,
						'show_description' => $show_description,
						'show_contact'     => $show_contact,
						'img_sizes'        => $img_sizes,
					] );
				endforeach; ?>
			</div>
		<?php elseif ( $is_preview ) : ?>
			<div class="teams__grid">
				<div class="teams__placeholder">
					<p>Selecciona miembros del equipo desde el panel lateral</p>
				</div>
			</div>
		<?php endif; ?>

		<?php if ( is_array( $cta ) && ! empty( $cta['url'] ) && ! empty( $cta['title'] ) ) : ?>
			<div class="teams__cta">
				<?php
				$cta_target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
				?>
				<a class="btn btn--<?php echo esc_attr( $cta_size ); ?> btn--<?php echo esc_attr( $cta_style ); ?>" href="<?php echo esc_url( $cta['url'] ); ?>"<?php echo $cta_target; // phpcs:ignore ?>><?php echo esc_html( $cta['title'] ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</section>
