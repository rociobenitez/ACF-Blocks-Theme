<?php
/**
 * Footer Contact
 */

if (!function_exists('get_field')) return;

$is_preview = !empty($is_preview);

// Datos desde Opciones
$phone    = trim((string) get_field('phone', 'option'));
$whatsapp = trim((string) get_field('whatsapp', 'option'));
$email    = trim((string) get_field('email', 'option'));
$address  = trim((string) get_field('address', 'option'));
$city     = trim((string) get_field('city', 'option'));
$province = trim((string) get_field('province', 'option'));
$cp       = trim((string) get_field('postal_code', 'option'));
$gmap     = trim((string) get_field('google_maps_link', 'option'));
$hours    = (string) get_field('opening_hours', 'option'); // WYSIWYG

$has_any  = $phone || $whatsapp || $email || $address || $city || $province || $cp || $hours;

if (!$has_any && !$is_preview) { return; }

$norm_tel = static function ($s) {
  $s = preg_replace('/\s+/', '', (string) $s);
  $s = preg_replace('/[^0-9\+]/', '', $s);
  return ltrim($s, '0');
};

$wrapper = get_block_wrapper_attributes([ 'class' => 'footer-contact' ]);
?>
<div <?php echo $wrapper; ?>>
  <?php if ($address || $city || $province || $cp): ?>
    <p class="footer-contact__item footer-contact__address">
      <?php if ($gmap): ?><a href="<?php echo esc_url($gmap); ?>" target="_blank" rel="noopener"><?php endif; ?>
      <?php
        $linea1 = $address;
        $linea2 = trim(implode(' ', array_filter([$cp, $city, $province])));
        echo esc_html(trim($linea1 . ($linea2 ? ' · ' . $linea2 : '')));
      ?>
      <?php if ($gmap): ?></a><?php endif; ?>
    </p>
  <?php endif; ?>

  <?php if ($phone): ?>
    <p class="footer-contact__item">
      <a href="tel:<?php echo esc_attr($norm_tel($phone)); ?>"><?php echo esc_html($phone); ?></a>
    </p>
  <?php endif; ?>

  <?php if ($whatsapp): ?>
    <p class="footer-contact__item">
      <a href="https://wa.me/<?php echo esc_attr($norm_tel($whatsapp)); ?>">WhatsApp: <?php echo esc_html($whatsapp); ?></a>
    </p>
  <?php endif; ?>

  <?php if ($email): ?>
    <p class="footer-contact__item">
      <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
    </p>
  <?php endif; ?>

  <?php if ($hours): ?>
    <div class="footer-contact__hours">
      <?php echo wp_kses_post( $hours ); ?>
    </div>
  <?php endif; ?>

  <?php if ($is_preview && !$has_any): ?>
    <em class="footer-contact__placeholder"><?php esc_html_e('Configura tus datos de contacto en Opciones.', 'st-starter'); ?></em>
  <?php endif; ?>
</div>
