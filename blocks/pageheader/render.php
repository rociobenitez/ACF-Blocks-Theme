<?php
/**
 * Cabecera de Página — render.php
 *
 * Variantes via is-style-* (block.json):
 *   cover   – imagen de fondo + overlay (default)
 *   split   – texto a un lado, imagen al otro
 *   minimal – sin imagen, fondo sólido, compacto
 *
 * @package Starter\Theme
 */

namespace Starter\Theme;

defined( 'ABSPATH' ) || exit;

// ── Home guard: never render on front page ──────────────────────
if ( ! is_admin() && is_front_page() ) {
	return;
}

// ── Enable toggle (null = never saved = default ON) ────────────
$enabled = get_field( 'ph_enable' );
if ( $enabled === null ) {
	$enabled = true;
}
if ( ! $enabled && empty( $is_preview ) ) {
	return;
}

// ── Variant detection ───────────────────────────────────────────
$cls        = $block['className'] ?? '';
$is_split   = str_contains( $cls, 'is-style-split' );
$is_minimal = str_contains( $cls, 'is-style-minimal' );

// ── Content fields ──────────────────────────────────────────────
$kicker     = (string) ( get_field( 'ph_kicker' ) ?: '' );
$title      = (string) ( get_field( 'ph_title' ) ?: '' );
$title_tag  = (string) ( get_field( 'ph_title_tag' ) ?: 'h1' );
$subtitle   = (string) ( get_field( 'ph_subtitle' ) ?: '' );
$body       = (string) ( get_field( 'ph_body' ) ?: '' );
$cta        = get_field( 'ph_cta' ) ?: [];

// Fallback to page title (works in both frontend and editor).
if ( ! $title ) {
	$post_id = $block['postId'] ?? get_the_ID();
	$title   = $post_id ? get_the_title( $post_id ) : '';
}

// Validate title tag.
if ( ! in_array( $title_tag, [ 'h1', 'h2', 'h3' ], true ) ) {
	$title_tag = 'h1';
}

// ── Image fields ────────────────────────────────────────────────
$image_id   = (int) get_field( 'ph_image' );
$image_side = (string) ( get_field( 'ph_image_side' ) ?: 'right' );
$overlay    = (float) ( get_field( 'ph_overlay' ) ?: 0.55 );
$overlay    = max( 0, min( 1, $overlay ) );

// Image fallback: block field > featured image > theme default.
if ( ! $image_id ) {
	$post_id  = $block['postId'] ?? get_the_ID();
	$thumb_id = $post_id ? get_post_thumbnail_id( $post_id ) : 0;
	if ( $thumb_id ) {
		$image_id = (int) $thumb_id;
	}
}
$fallback_img = get_template_directory_uri() . '/assets/images/bg-pageheader-default.avif';

// ── Design fields ───────────────────────────────────────────────
$text_align  = (string) ( get_field( 'ph_text_align' ) ?: 'center' );
$size        = (string) ( get_field( 'ph_size' ) ?: 'md' );
$bg_color    = (string) ( get_field( 'ph_bg_color' ) ?: 'light' );
$breadcrumbs = (bool) get_field( 'ph_breadcrumbs' );

// ── Form fields ─────────────────────────────────────────────────
$show_form = (bool) get_field( 'ph_show_form' );
$form_id   = trim( (string) ( get_field( 'ph_form_id' ) ?: '' ) );

// ── Determine text color scheme ─────────────────────────────────
$dark_text = $is_split || $is_minimal;
if ( ! $is_split && ! $is_minimal && ! $image_id ) {
	$dark_text = ! in_array( $bg_color, [ 'primary', 'dark' ], true );
}

// ── Preview: sample data ────────────────────────────────────────
if ( ! empty( $is_preview ) && ! get_field( 'ph_title' ) && ! $title ) {
	$kicker   = 'Medicina estética';
	$title    = 'Tratamientos faciales en Madrid';
	$subtitle = 'Armonización facial personalizada con técnicas avanzadas y resultados naturales.';
	$body     = '<p>En Beauty Lab Clinic ofrecemos tratamientos de medicina estética facial con las técnicas más avanzadas.</p>';
}

// ── Wrapper classes ─────────────────────────────────────────────
$classes   = [ 'pageheader' ];
$classes[] = 'pageheader--' . sanitize_html_class( $size );
$classes[] = 'pageheader--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'pageheader--align-' . sanitize_html_class( $text_align );

if ( $dark_text ) {
	$classes[] = 'pageheader--dark-text';
}
if ( $is_split && $image_side === 'left' ) {
	$classes[] = 'pageheader--image-left';
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

// ── Helper: render content ──────────────────────────────────────
$render_content = function () use (
	$kicker, $title, $title_tag, $subtitle, $body, $cta,
	$breadcrumbs, $show_form, $form_id, $is_split
) : void {
	if ( $kicker ) {
		echo '<p class="pageheader__kicker">' . esc_html( $kicker ) . '</p>';
	}

	echo '<' . $title_tag . ' class="pageheader__title">' . esc_html( $title ) . '</' . $title_tag . '>';

	if ( $is_split && ( $subtitle || $body ) ) {
		echo '<div class="pageheader__separator" aria-hidden="true"></div>';
	}

	if ( $subtitle ) {
		echo '<p class="pageheader__subtitle">' . wp_kses_post( $subtitle ) . '</p>';
	}

	if ( $body ) {
		echo '<div class="pageheader__body">' . wp_kses_post( $body ) . '</div>';
	}

	if ( is_array( $cta ) && ! empty( $cta['url'] ) ) {
		$target = ! empty( $cta['target'] )
			? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"'
			: '';
		$label = esc_html( $cta['title'] ?: __( 'Saber más', 'acf-starter-theme' ) );
		echo '<div class="pageheader__cta">';
		echo '<a href="' . esc_url( $cta['url'] ) . '" class="btn btn--primary pageheader__cta-link"' . $target . '>' . $label . '</a>';
		echo '</div>';
	}

	if ( $breadcrumbs && function_exists( 'Starter\Theme\render_breadcrumbs' ) ) {
		echo '<div class="pageheader__breadcrumbs">';
		render_breadcrumbs();
		echo '</div>';
	}

	if ( $show_form && $form_id ) {
		echo '<div class="pageheader__form">';
		echo do_shortcode( '[gravityform id="' . esc_attr( $form_id ) . '" title="false" description="false" ajax="true"]' );
		echo '</div>';
	}
};
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?>>

	<?php if ( $is_minimal ) : ?>
		<div class="container pageheader__inner">
			<?php $render_content(); ?>
		</div>

	<?php elseif ( $is_split ) : ?>
		<?php // HTML order: inner (left) + media (right).
		      // With --image-left class, CSS swaps them via order. ?>
		<div class="pageheader__inner">
			<?php $render_content(); ?>
		</div>
		<div class="pageheader__media" aria-hidden="true">
			<?php if ( $image_id ) : ?>
				<?php echo wp_get_attachment_image( $image_id, 'large', false, [
					'class'   => 'pageheader__media-img',
					'loading' => 'eager',
				] ); ?>
			<?php else : ?>
				<img class="pageheader__media-img" src="<?php echo esc_url( $fallback_img ); ?>" alt="" loading="eager">
			<?php endif; ?>
		</div>

	<?php else : ?>
		<?php if ( $image_id ) : ?>
			<div class="pageheader__bg" aria-hidden="true">
				<?php echo wp_get_attachment_image( $image_id, 'full', false, [
					'class'   => 'pageheader__bg-img',
					'loading' => 'eager',
				] ); ?>
				<div class="pageheader__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>
		<?php elseif ( ! in_array( $bg_color, [ 'primary', 'dark' ], true ) ) : ?>
			<div class="pageheader__bg" aria-hidden="true">
				<img class="pageheader__bg-img" src="<?php echo esc_url( $fallback_img ); ?>" alt="" loading="eager">
				<div class="pageheader__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>
		<?php endif; ?>
		<div class="container pageheader__inner">
			<?php $render_content(); ?>
		</div>
	<?php endif; ?>

</section>
