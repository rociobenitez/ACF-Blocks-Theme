<?php
$phone   = get_field('phone', 'option');
$email   = get_field('email', 'option');
$address = get_field('address', 'option');
$hours   = get_field('opening_hours', 'option');
?>

<ul class="contact-info">
  <?php if ($phone): ?>
    <li><strong><?php esc_html_e('Teléfono:', ST_TEXT_DOMAIN); ?></strong> <?php echo esc_html($phone); ?></li>
  <?php endif; ?>

  <?php if ($email): ?>
    <li><strong><?php esc_html_e('Email:', ST_TEXT_DOMAIN); ?></strong> <?php echo esc_html($email); ?></li>
  <?php endif; ?>

  <?php if ($address): ?>
    <li><strong><?php esc_html_e('Dirección:', ST_TEXT_DOMAIN); ?></strong> <?php echo esc_html($address); ?></li>
  <?php endif; ?>

  <?php if ($hours): ?>
    <li><strong><?php esc_html_e('Horario:', ST_TEXT_DOMAIN); ?></strong> <?php echo $hours; ?></li>
  <?php endif; ?>
</ul>
