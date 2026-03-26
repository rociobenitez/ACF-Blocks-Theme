<?php
/**
 * Formulario de contacto — render.php
 *
 * Prioridad del ID de formulario:
 *   1. Campo ACF de la página: page_form_id (post meta)
 *   2. Campo global de Opciones: contact_form_id
 *   3. Fallback: 1
 *
 * @package Starter\Theme
 */

$post_id = get_the_ID();
$form_id = (int) ( get_field( 'page_form_id', $post_id )
                ?: get_field( 'contact_form_id', 'option' )
                ?: 1 );

if ( ! function_exists( 'gravity_form' ) ) {
    if ( ! empty( $is_preview ) ) {
        echo '<p style="font-family:sans-serif;font-size:.875rem;color:#666;">Gravity Forms no está activo.</p>';
    }
    return;
}
?>
<div class="contact-form">
    <?php echo do_shortcode( '[gravityforms id="' . $form_id . '" title="false" description="false" ajax="true"]' ); ?>
</div>