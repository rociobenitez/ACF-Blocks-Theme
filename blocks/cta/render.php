<?php
/**
 * CTA Block — render.php
 *
 * Variantes via is-style-* (block.json):
 *   banner  – imagen de fondo + overlay, texto centrado (default)
 *   strip   – franja de color sólido, sin imagen, layout horizontal o centrado
 *   split   – imagen a un lado, contenido al otro (lado: ACF field image_side)
 *
 * Contenido global: si use_global === true, los textos y botones se leen de
 * Opciones > CTA Global. Los campos de diseño e imagen son siempre del bloque.
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

// ── Variant detection ──────────────────────────────────────────────
$cls      = $block['className'] ?? '';
$is_strip = str_contains( $cls, 'is-style-strip' );
$is_split = str_contains( $cls, 'is-style-split' );

// ── Global toggle ────────────────────────────────────────────────
$use_global = (bool) get_field( 'use_global' );

// ── Content fields (global or block) ─────────────────────────────
if ( $use_global ) {
	$kicker       = (string) ( get_field( 'cta_kicker', 'option' ) ?: '' );
	$kicker_tag   = 'p';
	$heading      = (string) ( get_field( 'cta_heading', 'option' ) ?: '' );
	$heading_tag  = 'h2';
	$subtitle     = (string) ( get_field( 'cta_subtitle', 'option' ) ?: '' );
	$subtitle_tag = 'p';
	$body         = (string) ( get_field( 'cta_body', 'option' ) ?: '' );
	$link_1       = get_field( 'cta_link_1', 'option' ) ?: [];
	$link_1_style = (string) ( get_field( 'cta_link_1_style', 'option' ) ?: 'primary' );
	$link_2       = get_field( 'cta_link_2', 'option' ) ?: [];
	$link_2_style = (string) ( get_field( 'cta_link_2_style', 'option' ) ?: 'ghost' );
} else {
	$kicker       = (string) ( get_field( 'kicker' ) ?: '' );
	$kicker_tag   = (string) ( get_field( 'kicker_tag' ) ?: 'p' );
	$heading      = (string) ( get_field( 'heading' ) ?: '' );
	$heading_tag  = (string) ( get_field( 'heading_tag' ) ?: 'h2' );
	$subtitle     = (string) ( get_field( 'subtitle' ) ?: '' );
	$subtitle_tag = (string) ( get_field( 'subtitle_tag' ) ?: 'p' );
	$body         = (string) ( get_field( 'body' ) ?: '' );
	$link_1       = get_field( 'link_1' ) ?: [];
	$link_1_style = (string) ( get_field( 'link_1_style' ) ?: 'primary' );
	$link_2       = get_field( 'link_2' ) ?: [];
	$link_2_style = (string) ( get_field( 'link_2_style' ) ?: 'ghost' );
}

// ── Image & design (always from block) ──────────────────────────
$bg_type       = (string) ( get_field( 'bg_type' ) ?: 'image' );
$bg_effect     = (string) ( get_field( 'bg_effect' ) ?: 'static' );
$image_id      = (int) get_field( 'image' );
$video_id      = (int) get_field( 'video' );
$video_poster  = (int) get_field( 'video_poster' );
$image_side    = (string) ( get_field( 'image_side' ) ?: 'right' );
$overlay       = (float) ( get_field( 'overlay_opacity' ) ?: 0.55 );
$overlay       = max( 0, min( 1, $overlay ) );
$content_align = (string) ( get_field( 'content_align' ) ?: 'center' );
$bg_color      = (string) ( get_field( 'bg_color' ) ?: 'default' );
$padding_y     = (string) ( get_field( 'padding_y' ) ?: 'md' );

// ── Image fallback hierarchy: block > options > theme default ───
if ( ! $image_id ) {
	$opt_image = (int) get_field( 'cta_image', 'option' );
	if ( $opt_image ) {
		$image_id = $opt_image;
	}
}
$fallback_img = get_template_directory_uri() . '/assets/images/bg-cta-default.avif';

// ── Video poster fallback: poster field > image_id > fallback ───
if ( $bg_type === 'video' && ! $video_poster ) {
	$video_poster = $image_id;
}

// Validate tags.
$allowed_heading = [ 'h1', 'h2', 'h3', 'p' ];
$allowed_kicker  = [ 'p', 'h2', 'h3' ];
if ( ! in_array( $heading_tag, $allowed_heading, true ) ) {
	$heading_tag = 'h2';
}
if ( ! in_array( $kicker_tag, $allowed_kicker, true ) ) {
	$kicker_tag = 'p';
}
if ( ! in_array( $subtitle_tag, $allowed_kicker, true ) ) {
	$subtitle_tag = 'p';
}

// ── Preview: sample data when empty ────────────────────────────────
if ( ! empty( $is_preview ) && ! $heading ) {
	$kicker  = 'Empieza hoy';
	$heading = '¿Listo para dar el siguiente paso?';
	$body    = 'Cuéntanos tu proyecto y te respondemos en menos de 24 horas.';
	$link_1  = [ 'url' => '#', 'title' => 'Contactar ahora', 'target' => '' ];
	$link_2  = [ 'url' => '#', 'title' => 'Saber más', 'target' => '' ];
}

// ── Wrapper classes ────────────────────────────────────────────────
$classes   = [ 'cta' ];
$classes[] = 'cta--py-' . sanitize_html_class( $padding_y );
$classes[] = 'cta--bg-' . sanitize_html_class( $bg_color );
$classes[] = 'cta--align-' . sanitize_html_class( $content_align );

if ( $is_split && $image_side === 'left' ) {
	$classes[] = 'cta--image-left';
}

// Banner-specific classes.
if ( ! $is_strip && ! $is_split ) {
	if ( $bg_type === 'video' && $video_id ) {
		$classes[] = 'cta--video';
	}
}

$wrapper_attrs = get_block_wrapper_attributes( [
	'class' => implode( ' ', $classes ),
] );

// ── Helper: render a single button ─────────────────────────────────
$render_btn = function ( $link, string $style ) : void {
	if ( ! is_array( $link ) || empty( $link['url'] ) ) {
		return;
	}
	$target = ! empty( $link['target'] )
		? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"'
		: '';
	$label = esc_html( $link['title'] ?: __( 'Saber más', 'acf-starter-theme' ) );
	echo '<a href="' . esc_url( $link['url'] ) . '" class="cta__btn cta__btn--' . esc_attr( $style ) . '"' . $target . '>' . $label . '</a>';
};

// ── Helper: render buttons group ───────────────────────────────────
$render_buttons = function () use ( $link_1, $link_1_style, $link_2, $link_2_style, $render_btn ) : void {
	$has_1 = is_array( $link_1 ) && ! empty( $link_1['url'] );
	$has_2 = is_array( $link_2 ) && ! empty( $link_2['url'] );
	if ( ! $has_1 && ! $has_2 ) {
		return;
	}
	echo '<div class="cta__buttons">';
	$render_btn( $link_1, $link_1_style );
	$render_btn( $link_2, $link_2_style );
	echo '</div>';
};

// ── Helper: render content block ───────────────────────────────────
$render_content = function () use (
	$kicker, $kicker_tag, $heading, $heading_tag,
	$subtitle, $subtitle_tag, $body, $render_buttons
) : void {
	echo '<div class="cta__content">';

	if ( $kicker ) {
		echo '<' . $kicker_tag . ' class="cta__kicker">' . esc_html( $kicker ) . '</' . $kicker_tag . '>';
	}
	if ( $heading ) {
		echo '<' . $heading_tag . ' class="cta__heading">' . esc_html( $heading ) . '</' . $heading_tag . '>';
	}
	if ( $subtitle ) {
		echo '<' . $subtitle_tag . ' class="cta__subtitle">' . esc_html( $subtitle ) . '</' . $subtitle_tag . '>';
	}
	if ( $body ) {
		echo '<div class="cta__body">' . wp_kses_post( $body ) . '</div>';
	}

	$render_buttons();

	echo '</div>';
};

// ── Helper: render image ───────────────────────────────────────────
$render_image = function ( string $size = 'large' ) use ( $image_id ) : void {
	if ( ! $image_id ) {
		return;
	}
	echo '<div class="cta__media">';
	echo wp_get_attachment_image( $image_id, $size, false, [
		'class'   => 'cta__media-img',
		'loading' => 'lazy',
	] );
	echo '</div>';
};
?>
<section <?php echo $wrapper_attrs; // phpcs:ignore ?>>

	<?php if ( $is_strip ) : ?>
		<?php // ── STRIP: solid color band, no image ──────────────── ?>
		<div class="cta__inner container">
			<?php $render_content(); ?>
		</div>

	<?php elseif ( $is_split ) : ?>
		<?php // ── SPLIT: image on one side, content on the other ──── ?>
		<?php $render_image( 'large' ); ?>
		<?php $render_content(); ?>

	<?php else : ?>
		<?php // ── BANNER: background image/video + overlay (default) ── ?>

		<?php if ( $bg_type === 'video' && $video_id ) : ?>
			<?php
			$video_url  = wp_get_attachment_url( $video_id );
			$poster_url = $video_poster
				? wp_get_attachment_image_url( $video_poster, 'full' )
				: $fallback_img;
			?>
			<div class="cta__bg" aria-hidden="true">
				<video
					class="cta__bg-video"
					autoplay muted loop playsinline
					preload="metadata"
					poster="<?php echo esc_url( $poster_url ); ?>"
					data-src="<?php echo esc_url( $video_url ); ?>"
				>
				</video>
				<?php if ( $video_poster ) : ?>
					<?php echo wp_get_attachment_image( $video_poster, 'full', false, [
						'class' => 'cta__bg-img cta__bg-img--poster',
						'loading' => 'lazy',
					] ); ?>
				<?php elseif ( ! $video_poster && ! $image_id ) : ?>
					<img class="cta__bg-img cta__bg-img--poster" src="<?php echo esc_url( $fallback_img ); ?>" alt="" loading="lazy">
				<?php else : ?>
					<?php echo wp_get_attachment_image( $image_id, 'full', false, [
						'class' => 'cta__bg-img cta__bg-img--poster',
						'loading' => 'lazy',
					] ); ?>
				<?php endif; ?>
				<div class="cta__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>

		<?php elseif ( $bg_effect === 'parallax' ) : ?>
			<?php
			$parallax_url = $image_id
				? wp_get_attachment_image_url( $image_id, 'full' )
				: $fallback_img;
			?>
			<div class="cta__bg cta__bg--parallax" aria-hidden="true" style="background-image:url('<?php echo esc_url( $parallax_url ); ?>')">
				<div class="cta__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>

		<?php elseif ( $image_id ) : ?>
			<div class="cta__bg" aria-hidden="true">
				<?php echo wp_get_attachment_image( $image_id, 'full', false, [
					'class'   => 'cta__bg-img',
					'loading' => 'lazy',
				] ); ?>
				<div class="cta__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>

		<?php elseif ( $fallback_img ) : ?>
			<div class="cta__bg" aria-hidden="true">
				<img class="cta__bg-img" src="<?php echo esc_url( $fallback_img ); ?>" alt="" loading="lazy">
				<div class="cta__overlay" style="opacity:<?php echo esc_attr( $overlay ); ?>"></div>
			</div>

		<?php endif; ?>

		<div class="cta__inner container">
			<?php $render_content(); ?>
		</div>
	<?php endif; ?>

</section>
