<?php
/**
 * FAQs (ACF Block)
 * Variantes: simple | with-media-left | with-media-right
 * Acordeón accesible (solo una abierta). Reutiliza el componente header-section.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
if ( ! function_exists( 'get_field' ) ) return;

$td = 'acf-starter';
$block_id = isset( $block['id'] ) ? sanitize_html_class( $block['id'] ) : uniqid('faqs-');
$is_editor = ! empty( $is_preview );

$block_classes = isset( $block['className'] ) ? (string) $block['className'] : '';
$has_media_variant = (
	strpos( $block_classes, 'is-style-faqs-media-left' ) !== false
	|| strpos( $block_classes, 'is-style-faqs-media-right' ) !== false
);

// ACF fields
$media_id    = (int) ( get_field('media') ?: 0 );
$tagline     = (string) ( get_field('tagline') ?: '' );
$title       = (string) ( get_field('title') ?: '' );
$tag_title   = (string) ( get_field('tag_title') ?: 'h2' );
$tag_faq     = (string) ( get_field('tag_faq') ?: 'h3' );
$description = (string) ( get_field('description') ?: '' );
$items       = (array)  ( get_field('items') ?: [] );

// Media
$media_html = '';
if ( $has_media_variant && $media_id  ) {
	$media_html = wp_get_attachment_image( $media_id, 'large', false, [
		'class' => 'faq__media-img',
		'loading' => 'lazy',
		'decoding' => 'async',
		'fetchpriority' => 'low',
	] );
}

// Wrapper attributes
$wrapper_attributes = get_block_wrapper_attributes( [
	'class' => 'faq',
	'data-faqs' => $block_id,
] );

?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>

    <?php
    // Header section (reutiliza tu componente)
    if ( function_exists('render_component') && ( $title ) ) {
        echo render_component( 'header-section', [
            'tagline'         => $tagline,
            'title'           => $title,
            'tag_title'       => $tag_title,
            'description'     => $description,
            'is_block_editor' => $is_editor,
            'extra_cls'       => 'faq__header',
        ] );
    }
    ?>
    
	<div class="faq__inner">

		<?php if (  $has_media_variant && $media_html ) : ?>
			<figure class="faq__media">
				<?php echo $media_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</figure>
		<?php endif; ?>

		<?php
		// Items
		$has_items = ! empty( $items );
		if ( ! $has_items && $is_editor ) :
		?>
			<div class="faq__notice">
				<?php echo esc_html__( 'Añade preguntas frecuentes en el panel de campos del bloque.', $td ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $has_items ) : ?>
			<div class="faq__items" role="list">
				<?php foreach ( $items as $i => $row ) :
					$q = isset( $row['question'] ) ? (string) $row['question'] : '';
					$a = isset( $row['answer'] ) ? (string) $row['answer'] : '';

					// NUEVO: tag por pregunta (por defecto h3)
					// Acepta varias convenciones de nombre por si el campo se llama distinto.
					$raw_tag = '';
					if ( isset( $row['heading_tag'] ) )        $raw_tag = (string) $row['heading_tag'];
					elseif ( isset( $row['faq_heading_tag'] ) ) $raw_tag = (string) $row['faq_heading_tag'];
					elseif ( isset( $row['tag'] ) )            $raw_tag = (string) $row['tag'];

					$allowed_tags = [ 'h2', 'h3', 'h4', 'p' ];
					$h_tag = in_array( strtolower( $raw_tag ), $allowed_tags, true ) ? strtolower( $raw_tag ) : 'h3';

					if ( $q === '' && $a === '' ) continue;

					$item_id   = $block_id . '-' . ( $i + 1 );
					$panel_id  = 'faq-panel-' . $item_id;
					$button_id = 'faq-button-' . $item_id;
				?>
				<article class="faq__item" role="listitem">
					<<?php echo esc_attr( $h_tag ); ?> class="faq__heading">
						<button
							id="<?php echo esc_attr( $button_id ); ?>"
							class="faq__trigger"
							type="button"
							aria-expanded="false"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						>
							<span class="faq__icon" aria-hidden="true"></span>
							<span class="faq__question"><?php echo esc_html( $q ?: __( 'Pregunta', $td ) ); ?></span>
						</button>
					</<?php echo esc_attr( $h_tag ); ?>>
					<div
						id="<?php echo esc_attr( $panel_id ); ?>"
						class="faq__panel"
						role="region"
						aria-labelledby="<?php echo esc_attr( $button_id ); ?>"
						hidden
					>
						<div class="faq__answer">
							<?php
							// HTML básico permitido
							$allowed = [
								'p' => [], 'ul' => [], 'ol' => [], 'li' => [],
								'strong' => [], 'em' => [], 'br' => [],
								'a' => [ 'href' => [], 'target' => [], 'rel' => [] ],
							];
							echo wp_kses( $a ?: __( 'Respuesta…', $td ), $allowed );
							?>
						</div>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

	</div>
</div>

<?php
// Script mínimo (una sola vez por petición) para acordeón exclusivo
static $faq_script_printed = false;
if ( ! $faq_script_printed ) :
	$faq_script_printed = true;
?>
<script>
document.addEventListener('click', function(e){
	const btn = e.target.closest('.faq__trigger');
	if(!btn) return;

	const container = btn.closest('[data-faqs]');
	if(!container) return;

	const expanded = btn.getAttribute('aria-expanded') === 'true';
	// Cerrar todos
	container.querySelectorAll('.faq__trigger[aria-expanded="true"]').forEach(function(openBtn){
		openBtn.setAttribute('aria-expanded', 'false');
		const pid = openBtn.getAttribute('aria-controls');
		const panel = pid ? document.getElementById(pid) : null;
		if(panel){ panel.hidden = true; }
	});
	// Abrir actual si estaba cerrado
	if(!expanded){
		btn.setAttribute('aria-expanded','true');
		const pid = btn.getAttribute('aria-controls');
		const panel = pid ? document.getElementById(pid) : null;
		if(panel){ panel.hidden = false; }
	}
});
</script>
<?php endif; ?>