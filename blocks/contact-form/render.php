<?php
/**
 * Formulario de contacto de Gravity Forms
 */

$id_form = get_field('form_id') ?? 1;

// Verificar si Gravity Forms está activo
if ( ! function_exists( 'gravity_form' ) ) {
    echo '<p>' . esc_html__( 'Gravity Forms no está activo. Por favor, instala y activa el plugin.', ST_TEXT_DOMAIN ) . '</p>';
    return;
}
?>
<div class="contact-form">
  <?php // Shortcode de Gravity Forms
    echo do_shortcode( '[gravityform id="' . esc_attr( $id_form ) . '" title="false" description="false" ajax="true"]' );
  ?>
</div>