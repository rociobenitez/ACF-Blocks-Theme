<?php
/**
 * Title: Contact Page
 * Slug: acf-starter-theme/contact-page
 * Categories: pages
 * Inserter: false
 */
?>

<!-- wp:group {"tagName":"section","layout":{"type":"flow"}} -->
<section class="contact-page container">
  <!-- wp:heading {"level":1} -->
  <h1><?php echo esc_html__( 'Contacta con nosotros', 'acf-starter-theme' ); ?></h1>
  <!-- /wp:heading -->

  <!-- wp:paragraph -->
  <p><?php echo esc_html__( 'Estamos aquí para ayudarte. Rellena el formulario o usa los datos de contacto.', 'acf-starter-theme' ); ?></p>
  <!-- /wp:paragraph -->

  <!-- wp:columns -->
  <div class="wp-block-columns">
    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:acf/contact-form {"name":"acf/contact-form"} /-->
    </div>
    <!-- /wp:column -->

    <!-- wp:column -->
    <div class="wp-block-column">
      <!-- wp:acf/contact-info {"name":"acf/contact-info"} /-->
    </div>
    <!-- /wp:column -->
  </div>
  <!-- /wp:columns -->
</section>
<!-- /wp:group -->
