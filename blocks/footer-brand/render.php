<?php
/**
 * Footer Brand Block — render.php
 *
 * Renders tagline, CTA button and social links for the footer.
 * All data comes from ACF Options.
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$tagline      = trim( (string) get_field( 'footer_tagline', 'option' ) );
$cta          = get_field( 'footer_cta', 'option' ) ?: [];
$show_social  = (bool) get_field( 'footer_show_social', 'option' );
$social       = get_field( 'social_links', 'option' );
$has_social   = $show_social && ! empty( $social ) && is_array( $social );

$has_cta = is_array( $cta ) && ! empty( $cta['url'] );

if ( ! $tagline && ! $has_cta && ! $has_social ) {
	return;
}

// Icon map (same as topbar).
$icon_for = static function ( string $network ) : string {
	$map = [
		'linkedin'  => 'assets/icons/social/linkedin.svg',
		'facebook'  => 'assets/icons/social/facebook.svg',
		'x'         => 'assets/icons/social/twitter-x.svg',
		'instagram' => 'assets/icons/social/instagram.svg',
		'youtube'   => 'assets/icons/social/youtube.svg',
		'tiktok'    => 'assets/icons/social/tiktok.svg',
		'pinterest' => 'assets/icons/social/pinterest.svg',
		'twitch'    => 'assets/icons/social/twitch.svg',
		'behance'   => 'assets/icons/social/behance.svg',
	];
	return $map[ $network ] ?? 'assets/icons/link.svg';
};
?>
<div class="footer-brand">

	<?php if ( $tagline ) : ?>
		<p class="footer-brand__tagline"><?php echo esc_html( $tagline ); ?></p>
	<?php endif; ?>

	<?php if ( $has_cta ) : ?>
		<?php
		$target = ! empty( $cta['target'] ) ? ' target="' . esc_attr( $cta['target'] ) . '" rel="noopener noreferrer"' : '';
		$label  = esc_html( $cta['title'] ?: __( 'Saber más', 'acf-starter-theme' ) );
		?>
		<a href="<?php echo esc_url( $cta['url'] ); ?>" class="footer-brand__cta"<?php echo $target; // phpcs:ignore ?>><?php echo $label; ?></a>
	<?php endif; ?>

	<?php if ( $has_social ) : ?>
		<div class="footer-brand__social" role="list">
			<?php foreach ( $social as $row ) :
				$net = isset( $row['social_network'] ) ? (string) $row['social_network'] : '';
				$url = isset( $row['social_url'] ) ? (string) $row['social_url'] : '';
				if ( ! $url ) { continue; }
				$icon  = $icon_for( $net );
				$label = $net ? ucfirst( sanitize_text_field( $net ) ) : __( 'Social', 'acf-starter-theme' );
			?>
				<a href="<?php echo esc_url( $url ); ?>" class="footer-brand__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $label ); ?>" role="listitem">
					<span class="footer-brand__icon" aria-hidden="true"><?php include get_template_directory() . '/' . $icon; ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

</div>
