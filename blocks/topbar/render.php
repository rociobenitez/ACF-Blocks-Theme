<?php
/**
 * Topbar (ACF Block)
 * Reads global Options and prints a compact top bar with contact + social.
 *
 * Required ACF Options (Options Page):
 * - show_topbar (true_false)
 * - show_social_links (radio: topbar|navbar|none)
 * - phone (text), whatsapp (text), email (email)
 * - social_links (repeater: social_network select, social_url url)
 *
 * Accessibility: visible text for contact links; social links get aria-label.
 */

defined( 'ABSPATH' ) || exit;

if (!function_exists('get_field')) {
  return;
}

$td = ST_TEXT_DOMAIN; // Text domain

// Options
$social_position = (string) get_field('show_social_links', 'option'); // 'topbar' | 'navbar' | 'none'
$phone           = trim((string) get_field('phone', 'option'));
$whatsapp        = trim((string) get_field('whatsapp', 'option'));
$email           = trim((string) get_field('email', 'option'));
$social          = get_field('social_links', 'option');

// Block settings
$wrapper_attributes = get_block_wrapper_attributes( [
	'class'       => 'topbar',
	'role'        => 'navigation',
	'aria-label'  => esc_attr__( 'Top bar', $td ),
] );

// Normalizers
$normalize_tel = static function ( $s ) {
	// Keep + and digits only; keep leading zeros as dial plans may require them
	$s = preg_replace( '/\s+/', '', (string) $s );
	return preg_replace( '/[^0-9\+]/', '', $s );
};
$normalize_wa = static function ( $s ) {
	// WhatsApp wa.me requires international format without '+'
	$s = preg_replace( '/\s+/', '', (string) $s );
	$s = preg_replace( '/[^0-9\+]/', '', $s );
	return ltrim( $s, '+' );
};

// Icon map (local SVGs in theme)
$icon_for = static function ($network) {
  $map = [
    'linkedin'  => 'assets/icons/social/linkedin.svg',
    'facebook'  => 'assets/icons/social/facebook.svg',
    'x'         => 'assets/icons/social/twitter-x.svg',
    'instagram' => 'assets/icons/social/instagram.svg',
    'youtube'   => 'assets/icons/social/youtube.svg',
    'tiktok'    => 'assets/icons/social/tiktok.svg',
    'pinterest' => 'assets/icons/social/pinterest.svg',
    'twitch'    => 'assets/icons/social/twitch.svg',
    'behance'   => 'assets/icons/social/behance.svg'
  ];
  return $map[$network] ?? 'assets/icons/link.svg';
};

$has_contact = ($phone !== '') || ($whatsapp !== '') || ($email !== '');
$has_socials_topbar = $social_position === 'topbar' && !empty($social) && is_array($social);

// If nothing to show on frontend, don't render; show placeholder in editor preview
if ( ! $has_contact && ! $has_socials_topbar && empty( $is_preview ) ) {
	return;
}
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
  <div class="topbar__container container">

		<?php if ( $has_contact ) : ?>
			<div class="topbar__contact">
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( $normalize_tel( $phone ) ); ?>" class="topbar__contact-link">
						<span class="topbar__icon" aria-hidden="true">
							<?php include get_template_directory() . '/assets/icons/phone.svg'; ?>
						</span>
						<span class="topbar__label"><?php echo esc_html__( 'Teléfono:', $td ); ?></span>
						<span class="topbar__value"><?php echo esc_html( $phone ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $whatsapp ) : ?>
					<a href="https://wa.me/<?php echo esc_attr( $normalize_wa( $whatsapp ) ); ?>" class="topbar__contact-link" target="_blank" rel="noopener noreferrer">
						<span class="topbar__icon" aria-hidden="true">
							<?php include get_template_directory() . '/assets/icons/whatsapp.svg'; ?>
						</span>
						<span class="topbar__label"><?php echo esc_html__( 'WhatsApp:', $td ); ?></span>
						<span class="topbar__value"><?php echo esc_html( $whatsapp ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( $email ); ?>" class="topbar__contact-link">
						<span class="topbar__icon" aria-hidden="true">
							<?php include get_template_directory() . '/assets/icons/mail.svg'; ?>
						</span>
						<span class="topbar__label"><?php echo esc_html__( 'Email:', $td ); ?></span>
						<span class="topbar__value"><?php echo esc_html( $email ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $has_socials_topbar ) : ?>
			<div class="topbar__social" role="list">
				<?php foreach ( $social as $row ) :
					$net = isset( $row['social_network'] ) ? (string) $row['social_network'] : '';
					$url = isset( $row['social_url'] ) ? (string) $row['social_url'] : '';
					if ( ! $url ) {
						continue;
					}
					$icon = $icon_for( $net );
					$label = $net ? ucfirst( sanitize_text_field( $net ) ) : __( 'Social', $td );
					?>
					<a href="<?php echo esc_url( $url ); ?>" class="topbar__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $label ); ?>">
						<span class="topbar__icon" aria-hidden="true">
							<?php include get_template_directory() . '/' . $icon; ?>
						</span>
						<span class="screen-reader-text"><?php echo esc_html( $label ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( ! $has_socials_topbar && ! $has_contact && ! empty( $is_preview ) ) : ?>
			<div class="topbar__notice" role="note">
				<?php echo esc_html__( '(No hay datos para mostrar: complete Teléfono/WhatsApp/Email o agregue enlaces sociales en Opciones)', $td ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>