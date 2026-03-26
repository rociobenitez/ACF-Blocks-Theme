<?php
/**
 * Header CTA Buttons — render.php
 *
 * Reads button data from ACF Options (Header tab).
 * Only visible on layout "centered" (controlled by CSS via body class).
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$cta_1       = get_field( 'header_cta_1', 'option' ) ?: [];
$cta_1_style = (string) ( get_field( 'header_cta_1_style', 'option' ) ?: 'primary' );
$cta_2       = get_field( 'header_cta_2', 'option' ) ?: [];
$cta_2_style = (string) ( get_field( 'header_cta_2_style', 'option' ) ?: 'ghost' );

$has_1 = is_array( $cta_1 ) && ! empty( $cta_1['url'] );
$has_2 = is_array( $cta_2 ) && ! empty( $cta_2['url'] );

if ( ! $has_1 && ! $has_2 ) {
	return;
}

$render_btn = function ( array $link, string $style ) : void {
	if ( empty( $link['url'] ) ) {
		return;
	}
	$target = ! empty( $link['target'] )
		? ' target="' . esc_attr( $link['target'] ) . '" rel="noopener noreferrer"'
		: '';
	$label = esc_html( $link['title'] ?: __( 'Saber más', 'acf-starter-theme' ) );
	echo '<a href="' . esc_url( $link['url'] ) . '" class="header-cta__btn header-cta__btn--' . esc_attr( $style ) . '"' . $target . '>' . $label . '</a>';
};
?>
<div class="header-cta">
	<?php
	$render_btn( $cta_1, $cta_1_style );
	$render_btn( $cta_2, $cta_2_style );
	?>
</div>
