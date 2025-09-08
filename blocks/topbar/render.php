<?php
/**
 * Topbar (ACF Block)
 * Lee opciones globales y muestra logo + contacto + redes sociales en barra superior.
 *
 * Requiere en Opciones:
 * - show_topbar (true_false)
 * - show_social_links (radio: topbar|navbar|none)
 * - bg_color_topbar (radio con clases Bootstrap)
 * - border_topbar (radio con clases Bootstrap)
 * - phone (text), whatsapp (text), email (email)
 * - social_links (repeater: social_network select, social_url url)
 */

if (!function_exists('get_field')) {
  return;
}

// Opciones
$social_position = (string) get_field('show_social_links', 'option'); // 'topbar' | 'navbar' | 'none'
$phone           = trim((string) get_field('phone', 'option'));
$whatsapp        = trim((string) get_field('whatsapp', 'option'));
$email           = trim((string) get_field('email', 'option'));
$social          = get_field('social_links', 'option');

// Normalizadores y utilidades
$normalize_tel = static function ($s) {
  // Mantener + y dígitos; quitar espacios y signos
  $s = preg_replace('/\s+/', '', (string) $s);
  $s = preg_replace('/[^0-9\+]/', '', $s);
  // Evitar ceros a la izquierda no deseados
  return ltrim($s, '0');
};

// Mapa de iconos Bootstrap por red
$icon_for = static function ($network) {
  $map = [
    'linkedin'  => 'bi-linkedin',
    'facebook'  => 'bi-facebook',
    'x'         => 'bi-twitter-x', // Bootstrap Icons >= 1.11
    'instagram' => 'bi-instagram',
    'youtube'   => 'bi-youtube',
    'tiktok'    => 'bi-tiktok',
    'pinterest' => 'bi-pinterest',
    'twitch'    => 'bi-twitch',
    'dribbble'  => 'bi-dribbble',
    'behance'   => 'bi-behance'
  ];
  return $map[$network] ?? 'bi-link-45deg';
};

// ¿Hay algo que mostrar?
$has_contact = ($phone !== '') || ($whatsapp !== '') || ($email !== '');
$has_socials_topbar = $social_position === 'topbar' && !empty($social) && is_array($social);

// Si no hay nada y no es preview, no renderizamos
if (!$has_contact && !$has_socials_topbar) {
  return;
}

?>
<div class="topbar py-2" role="navigation" aria-label="<?php echo esc_attr__('Barra superior', ST_THEME_NAME); ?>">
  <div class="container d-flex justify-content-between align-items-center">

    <?php if ($has_contact): ?>
      <div class="topbar-contact d-flex gap-3">
        <?php if ($phone): ?>
          <a href="tel:<?php echo esc_attr($normalize_tel($phone)); ?>">
            <i class="bi bi-telephone me-1" aria-hidden="true"></i>
            <span class="visually-hidden"><?php echo esc_html__('Teléfono:', ST_THEME_NAME); ?></span>
            <?php echo esc_html($phone); ?>
          </a>
        <?php endif; ?>

        <?php if ($whatsapp): ?>
          <a href="https://wa.me/<?php echo esc_attr($normalize_tel($whatsapp)); ?>">
            <i class="bi bi-whatsapp me-1" aria-hidden="true"></i>
            <span class="visually-hidden"><?php echo esc_html__('WhatsApp:', ST_THEME_NAME); ?></span>
            <?php echo esc_html($whatsapp); ?>
          </a>
        <?php endif; ?>

        <?php if ($email): ?>
          <a href="mailto:<?php echo esc_attr($email); ?>">
            <i class="bi bi-envelope me-1" aria-hidden="true"></i>
            <span class="visually-hidden"><?php echo esc_html__('Email:', ST_THEME_NAME); ?></span>
            <?php echo esc_html($email); ?>
          </a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($has_socials_topbar): ?>
      <div class="topbar-social d-flex gap-2">
        <?php foreach ($social as $row):
          $net = isset($row['social_network']) ? (string) $row['social_network'] : '';
          $url = isset($row['social_url']) ? (string) $row['social_url'] : '';
          if (!$url) { continue; }
          $icon = $icon_for($net);
        ?>
          <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener">
            <i class="bi <?php echo esc_attr($icon); ?>" aria-hidden="true"></i>
            <span class="visually-hidden"><?php echo esc_html(ucfirst($net ?: 'social')); ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!$has_socials_topbar && !$has_contact): ?>
      <div class="topbar-notice">
        <?php echo esc_html__('(No hay datos que mostrar: completa Teléfono/WhatsApp/Email o añade Redes en Opciones → Redes)', ST_THEME_NAME); ?>
      </div>
    <?php endif; ?>

  </div>
</div>
