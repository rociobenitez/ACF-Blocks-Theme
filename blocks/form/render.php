<?php 
/**
 * Dynamic Block Template.
 * @param   array $attributes - A clean associative array of block attributes.
 * @param   array $block - All the block settings and attributes.
 * @param   string $content - The block inner HTML (usually empty unless using inner blocks).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// Get ACF fields
$layout_variant = get_field('layout_variant') ?: 'background';
$image_id = get_field('image');
$heading = get_field('heading');
$heading_tag = get_field('heading_tag') ?: 'h2';
$subheading = get_field('subheading');
$body = get_field('body');
$form_id = get_field('form_id') ?: 1;

$classes = [
  'contact-cta',
  'contact-cta--' . esc_attr($layout_variant),
];

// Add container class for text-left and text-right variants
$grid_classes = ['contact-cta__grid'];
if (in_array($layout_variant, ['text-left', 'text-right'])) {
  // $grid_classes[] = 'container';
}

// Shortcode GF
$form_html = '';
if ($form_id > 0) {
  $shortcode = sprintf('[gravityform id="%d" title="false" description="false" ajax="true"]', $form_id);
  $form_html = do_shortcode($shortcode);
} else {
  $form_html = '<div class="contact-cta__form--placeholder"><em>Selecciona un formulario en el bloque</em></div>';
}

?>
<section class="<?php echo implode(' ', $classes); ?>">
  <div class="<?php echo implode(' ', $grid_classes); ?>">
    <div class="contact-cta__media">
      <?php if ($image_id) echo wp_get_attachment_image($image_id, 'large'); ?>
    </div>

    <div class="contact-cta__content">
      <div class="contact-cta__heading">
        <?php if (!empty($subheading)): ?>
          <p class="contact-cta__eyebrow"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>

        <?php if (!empty($heading)): ?>
          <<?php echo esc_attr($heading_tag); ?> class="contact-cta__title"><?php echo esc_html($heading); ?></<?php echo esc_attr($heading_tag); ?>>
        <?php endif; ?>

        <?php if (!empty($body)): ?>
          <div class="contact-cta__text"><?php echo wp_kses_post($body); ?></div>
        <?php endif; ?>
      </div>

      <div class="contact-cta__form">
        <?php echo $form_html; ?>
      </div>
    </div>
  </div>
</section>
