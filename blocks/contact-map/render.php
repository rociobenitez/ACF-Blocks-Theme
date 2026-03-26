<?php
/**
 * Mapa de Contacto — render.php
 *
 * Prioridad de la URL del iframe:
 *   1. Campo ACF de la página: page_map_embed_url (post meta)
 *   2. Campo global de Opciones: contact_map_embed_url
 *
 * @package Starter\Theme
 */

namespace Starter\Theme;

defined( 'ABSPATH' ) || exit;

$post_id   = get_the_ID();
$embed_url = get_field( 'page_map_embed_url', $post_id )
           ?: get_field( 'contact_map_embed_url', 'option' );

if ( ! $embed_url ) {
    if ( ! empty( $is_preview ) ) {
        echo '<div style="display:flex;align-items:center;justify-content:center;aspect-ratio:4/3;background:var(--wp--preset--color--neutral-100);border-radius:0.5rem;font-family:sans-serif;font-size:.875rem;color:var(--wp--preset--color--neutral-400);text-align:center;padding:1rem;">';
        echo '<span>Configura la URL del mapa en la página (campo «URL Embed Mapa») o en <strong>Opciones → Contacto</strong></span>';
        echo '</div>';
    }
    return;
}
?>
<div style="border-radius:0.5rem;overflow:hidden;aspect-ratio:4/3;background:var(--wp--preset--color--neutral-100)">
    <iframe
        src="<?php echo esc_url( $embed_url ); ?>"
        width="100%"
        height="100%"
        style="border:0;display:block;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        title="<?php esc_attr_e( 'Mapa de ubicación', 'acf-starter-theme' ); ?>">
    </iframe>
</div>
