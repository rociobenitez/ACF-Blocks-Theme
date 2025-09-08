<?php
/**
 * Footer Credits
 * Muestra © {year} {empresa}. Fallback si no hay constante.
 */

$year    = (string) wp_date('Y');
$company = defined('ST_COMPANY_NAME') ? ST_COMPANY_NAME : get_bloginfo('name');

$wrapper = get_block_wrapper_attributes([ 'class' => 'footer-credits' ]);
?>
<p <?php echo $wrapper; ?>>
  &copy; <?php echo esc_html($year); ?> <?php echo esc_html($company); ?>. <?php esc_html_e('Todos los derechos reservados.', 'st-starter'); ?>
</p>
