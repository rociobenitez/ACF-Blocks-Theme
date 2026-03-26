<?php
/**
 * Topbar Block — render.php
 *
 * Layout (ACF block field):
 *   off              – No render
 *   promo            – Promo text centered (from Options)
 *   contact          – Contact left + Social right
 *   address-contact  – Address left + Contact right
 *   social-contact   – Social left + Contact right
 *
 * Color via block styles (block.json):
 *   light | dark | primary | transparent | divider
 *
 * All data comes from ACF Options Page except the layout field.
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'get_field' ) ) {
	return;
}

$td = ST_TEXT_DOMAIN;

// ── Layout (block-level field) ─────────────────────────────────────
$layout = (string) ( get_field( 'topbar_layout' ) ?: 'contact' );

if ( 'off' === $layout ) {
	if ( ! empty( $is_preview ) ) {
		echo '<div class="topbar__notice">' . esc_html__( 'Topbar desactivado. Cambia el layout para activarlo.', $td ) . '</div>';
	}
	return;
}

// ── Options data ───────────────────────────────────────────────────
$phone      = trim( (string) get_field( 'phone', 'option' ) );
$whatsapp   = trim( (string) get_field( 'whatsapp', 'option' ) );
$email      = trim( (string) get_field( 'email', 'option' ) );
$address    = trim( (string) get_field( 'address', 'option' ) );
$city       = trim( (string) get_field( 'city', 'option' ) );
$social     = get_field( 'social_links', 'option' );
$promo_text = trim( (string) get_field( 'promo_text', 'option' ) );
$promo_link = get_field( 'promo_link', 'option' );

// Full address string.
$full_address = $address;
if ( $city && $address ) {
	$full_address .= ', ' . $city;
} elseif ( $city ) {
	$full_address = $city;
}

$has_contact = ( $phone || $whatsapp || $email );
$has_social  = ! empty( $social ) && is_array( $social );

// ── Normalizers ────────────────────────────────────────────────────
$normalize_tel = static function ( string $s ) : string {
	$s = preg_replace( '/\s+/', '', $s );
	return preg_replace( '/[^0-9\+]/', '', $s );
};
$normalize_wa = static function ( string $s ) : string {
	$s = preg_replace( '/\s+/', '', $s );
	$s = preg_replace( '/[^0-9\+]/', '', $s );
	return ltrim( $s, '+' );
};

// ── Icon map ───────────────────────────────────────────────────────
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

// ── Render helpers ─────────────────────────────────────────────────

/** Contact links (phone + whatsapp + email) */
$render_contact = function () use ( $phone, $whatsapp, $email, $normalize_tel, $normalize_wa, $td ) : void {
	if ( ! $phone && ! $whatsapp && ! $email ) {
		return;
	}
	echo '<div class="topbar__group topbar__contact">';

	if ( $phone ) :
		?>
		<a href="tel:<?php echo esc_attr( $normalize_tel( $phone ) ); ?>" class="topbar__link">
			<span class="topbar__icon" aria-hidden="true"><?php include get_template_directory() . '/assets/icons/phone.svg'; ?></span>
			<span class="topbar__value"><?php echo esc_html( $phone ); ?></span>
		</a>
		<?php
	endif;

	if ( $whatsapp ) :
		?>
		<a href="https://wa.me/<?php echo esc_attr( $normalize_wa( $whatsapp ) ); ?>" class="topbar__link" target="_blank" rel="noopener noreferrer">
			<span class="topbar__icon" aria-hidden="true"><?php include get_template_directory() . '/assets/icons/whatsapp.svg'; ?></span>
			<span class="topbar__value"><?php echo esc_html( $whatsapp ); ?></span>
		</a>
		<?php
	endif;

	if ( $email ) :
		?>
		<a href="mailto:<?php echo esc_attr( $email ); ?>" class="topbar__link">
			<span class="topbar__icon" aria-hidden="true"><?php include get_template_directory() . '/assets/icons/mail.svg'; ?></span>
			<span class="topbar__value"><?php echo esc_html( $email ); ?></span>
		</a>
		<?php
	endif;

	echo '</div>';
};

/** Social links */
$render_social = function () use ( $social, $has_social, $icon_for, $td ) : void {
	if ( ! $has_social ) {
		return;
	}
	echo '<div class="topbar__group topbar__social" role="list">';
	foreach ( $social as $row ) {
		$net = isset( $row['social_network'] ) ? (string) $row['social_network'] : '';
		$url = isset( $row['social_url'] ) ? (string) $row['social_url'] : '';
		if ( ! $url ) {
			continue;
		}
		$icon  = $icon_for( $net );
		$label = $net ? ucfirst( sanitize_text_field( $net ) ) : __( 'Social', $td );
		?>
		<a href="<?php echo esc_url( $url ); ?>" class="topbar__link topbar__social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $label ); ?>" role="listitem">
			<span class="topbar__icon" aria-hidden="true"><?php include get_template_directory() . '/' . $icon; ?></span>
			<span class="screen-reader-text"><?php echo esc_html( $label ); ?></span>
		</a>
		<?php
	}
	echo '</div>';
};

/** Address */
$render_address = function () use ( $full_address ) : void {
	if ( ! $full_address ) {
		return;
	}
	echo '<div class="topbar__group topbar__address">';
	echo '<span class="topbar__icon" aria-hidden="true">';
	include get_template_directory() . '/assets/icons/map-pin.svg';
	echo '</span>';
	echo '<span class="topbar__value">' . esc_html( $full_address ) . '</span>';
	echo '</div>';
};

/** Promo text */
$render_promo = function () use ( $promo_text, $promo_link ) : void {
	if ( ! $promo_text ) {
		return;
	}
	$is_link = is_array( $promo_link ) && ! empty( $promo_link['url'] );

	echo '<div class="topbar__group topbar__promo">';
	if ( $is_link ) {
		$target = ! empty( $promo_link['target'] ) ? ' target="' . esc_attr( $promo_link['target'] ) . '" rel="noopener noreferrer"' : '';
		echo '<a href="' . esc_url( $promo_link['url'] ) . '" class="topbar__promo-link"' . $target . '>';
	}
	echo '<span class="topbar__promo-text">' . esc_html( $promo_text ) . '</span>';
	if ( $is_link ) {
		echo '</a>';
	}
	echo '</div>';
};

// ── Check if there's anything to show for the selected layout ──────
$can_render = false;
switch ( $layout ) {
	case 'promo':
		$can_render = (bool) $promo_text;
		break;
	case 'contact':
		$can_render = $has_contact || $has_social;
		break;
	case 'address-contact':
		$can_render = (bool) $full_address || $has_contact;
		break;
	case 'social-contact':
		$can_render = $has_social || $has_contact;
		break;
}

if ( ! $can_render && empty( $is_preview ) ) {
	return;
}

// ── Wrapper ────────────────────────────────────────────────────────
$classes = [ 'topbar', 'topbar--' . sanitize_html_class( $layout ) ];

$wrapper_attrs = get_block_wrapper_attributes( [
	'class'      => implode( ' ', $classes ),
	'role'       => 'banner',
	'aria-label' => esc_attr__( 'Barra superior', $td ),
] );
?>
<div <?php echo $wrapper_attrs; // phpcs:ignore ?>>
	<div class="topbar__container container">

		<?php if ( 'promo' === $layout ) : ?>
			<?php $render_promo(); ?>

		<?php elseif ( 'contact' === $layout ) : ?>
			<?php $render_contact(); ?>
			<?php $render_social(); ?>

		<?php elseif ( 'address-contact' === $layout ) : ?>
			<?php $render_address(); ?>
			<?php $render_contact(); ?>

		<?php elseif ( 'social-contact' === $layout ) : ?>
			<?php $render_social(); ?>
			<?php $render_contact(); ?>

		<?php endif; ?>

		<?php if ( ! $can_render && ! empty( $is_preview ) ) : ?>
			<div class="topbar__notice" role="note">
				<?php echo esc_html__( 'No hay datos para este layout. Completa los campos en Opciones Generales.', $td ); ?>
			</div>
		<?php endif; ?>

	</div>
</div>
