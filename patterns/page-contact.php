<?php
/**
 * Title: Contact Page
 * Slug: acf-starter-theme/contact-page
 * Categories: pages
 * Inserter: false
 */

// Datos globales desde la página de Opciones
$phone       = function_exists( 'get_field' ) ? get_field( 'phone', 'option' )        : '';
$email       = function_exists( 'get_field' ) ? get_field( 'email', 'option' )        : '';
$address     = function_exists( 'get_field' ) ? get_field( 'address', 'option' )      : '';
$city        = function_exists( 'get_field' ) ? get_field( 'city', 'option' )         : '';
$province    = function_exists( 'get_field' ) ? get_field( 'province', 'option' )     : '';
$postal_code = function_exists( 'get_field' ) ? get_field( 'postal_code', 'option' )  : '';
$hours       = function_exists( 'get_field' ) ? get_field( 'opening_hours', 'option' ) : '';
$maps_link   = function_exists( 'get_field' ) ? get_field( 'google_maps_link', 'option' ) : '';

// ID formulario y URL embed del mapa (editables desde Opciones)
$form_id   = function_exists( 'get_field' ) ? (int) get_field( 'contact_form_id', 'option' ) : 1;
$form_id   = $form_id > 0 ? $form_id : 1;
$map_embed = function_exists( 'get_field' ) ? get_field( 'contact_map_embed_url', 'option' ) : '';

// Formato dirección completa
$address_line2 = trim( $postal_code . ' ' . $city . ( $province ? ', ' . $province : '' ) );

// Shortcode de GF como string para el bloque wp:shortcode
$gf_shortcode = '[gravityforms id="' . $form_id . '" title="false" description="false" ajax="true"]';
?>

<!-- wp:acf/pageheader {"name":"acf/pageheader","align":"full","mode":"preview"} /-->

<!-- ================================================================
     CONTENIDO PRINCIPAL — Formulario + Mapa (2 columnas)
     ================================================================ -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

	<!-- wp:columns {"isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|64","left":"var:preset|spacing|64"}}}} -->
	<div class="wp-block-columns is-not-stacked-on-mobile">

		<!-- ————————————————————————————
		     Columna izquierda: Formulario
		     ———————————————————————————— -->
		<!-- wp:column {"width":"55%"} -->
		<div class="wp-block-column" style="flex-basis:55%">

			<!-- wp:heading {"level":2} -->
			<h2><?php esc_html_e( 'Escríbenos', 'acf-starter-theme' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:paragraph {"textColor":"neutral-600"} -->
			<p class="has-neutral-600-color has-text-color"><?php esc_html_e( 'Rellena el formulario y nos pondremos en contacto contigo en menos de 24 horas.', 'acf-starter-theme' ); ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:shortcode -->
			<?php echo $gf_shortcode; ?>
			<!-- /wp:shortcode -->

		</div>
		<!-- /wp:column -->

		<!-- ————————————————————————————
		     Columna derecha: Mapa + horario
		     Reemplaza el src del iframe con
		     tu URL de Google Maps:
		     Maps → Compartir → Insertar mapa
		     ———————————————————————————— -->
		<!-- wp:column {"width":"45%"} -->
		<div class="wp-block-column" style="flex-basis:45%">

			<!-- wp:heading {"level":2} -->
			<h2><?php esc_html_e( 'Cómo llegar', 'acf-starter-theme' ); ?></h2>
			<!-- /wp:heading -->

			<!-- wp:html -->
			<div style="border-radius:0.5rem;overflow:hidden;aspect-ratio:4/3;background:var(--wp--preset--color--neutral-100)">
				<?php if ( $map_embed ) : ?>
				<iframe
					src="<?php echo esc_url( $map_embed ); ?>"
					width="100%"
					height="100%"
					style="border:0;display:block;"
					allowfullscreen=""
					loading="lazy"
					referrerpolicy="no-referrer-when-downgrade"
					title="<?php esc_attr_e( 'Mapa de ubicación', 'acf-starter-theme' ); ?>">
				</iframe>
				<?php else : ?>
				<div style="display:flex;align-items:center;justify-content:center;height:100%;color:var(--wp--preset--color--neutral-400);font-size:0.875rem;text-align:center;padding:1rem;">
					<?php esc_html_e( 'Configura la URL del mapa en Opciones → Contacto', 'acf-starter-theme' ); ?>
				</div>
				<?php endif; ?>
			</div>
			<!-- /wp:html -->

			<!-- wp:group {"style":{"spacing":{"padding":{"top":"var:preset|spacing|32"},"blockGap":"var:preset|spacing|8"}},"layout":{"type":"flow"}} -->
			<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--32)">
				<?php if ( $address || $address_line2 ) : ?>
				<!-- wp:paragraph {"fontSize":"14"} -->
				<p class="has-14-font-size">
					<?php if ( $address ) : ?>
					<strong><?php echo esc_html( $address ); ?></strong><?php if ( $address_line2 ) : ?><br><?php endif; ?>
					<?php endif; ?>
					<?php echo esc_html( $address_line2 ); ?>
					<?php if ( $maps_link ) : ?>
					<br><a href="<?php echo esc_url( $maps_link ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Ver en Google Maps', 'acf-starter-theme' ); ?></a>
					<?php endif; ?>
				</p>
				<!-- /wp:paragraph -->
				<?php endif; ?>
				<?php if ( $hours ) : ?>
				<!-- wp:paragraph {"textColor":"neutral-600","fontSize":"14"} -->
				<p class="has-neutral-600-color has-text-color has-14-font-size"><?php echo wp_kses_post( $hours ); ?></p>
				<!-- /wp:paragraph -->
				<?php endif; ?>
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->

<!-- ================================================================
     FRANJA DE DATOS DE CONTACTO — ancho completo, fondo neutro
     ================================================================ -->
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|48","bottom":"var:preset|spacing|48"}}},"backgroundColor":"neutral-50","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-neutral-50-background-color" style="padding-top:var(--wp--preset--spacing--48);padding-bottom:var(--wp--preset--spacing--48)">

	<!-- wp:columns {"isStackedOnMobile":true,"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|32","left":"var:preset|spacing|48"}}}} -->
	<div class="wp-block-columns is-not-stacked-on-mobile">

		<!-- Dirección -->
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|16"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.75rem","lineHeight":"1"}}} -->
				<p style="font-size:1.75rem;line-height:1">📍</p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"layout":{"type":"flow"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700"}}} -->
					<p><strong><?php esc_html_e( 'Dirección', 'acf-starter-theme' ); ?></strong></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"neutral-600","fontSize":"14"} -->
					<p class="has-neutral-600-color has-text-color has-14-font-size">
						<?php echo $address ? esc_html( $address ) . '<br>' : ''; ?>
						<?php echo esc_html( $address_line2 ); ?>
					</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- Teléfono -->
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|16"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.75rem","lineHeight":"1"}}} -->
				<p style="font-size:1.75rem;line-height:1">📞</p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"layout":{"type":"flow"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700"}}} -->
					<p><strong><?php esc_html_e( 'Teléfono', 'acf-starter-theme' ); ?></strong></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"neutral-600","fontSize":"14"} -->
					<p class="has-neutral-600-color has-text-color has-14-font-size">
						<?php if ( $phone ) : ?>
						<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						<?php else : ?>
						<?php esc_html_e( '—', 'acf-starter-theme' ); ?>
						<?php endif; ?>
					</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- Email -->
		<!-- wp:column {"verticalAlignment":"center"} -->
		<div class="wp-block-column is-vertically-aligned-center">
			<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|16"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
			<div class="wp-block-group">
				<!-- wp:paragraph {"style":{"typography":{"fontSize":"1.75rem","lineHeight":"1"}}} -->
				<p style="font-size:1.75rem;line-height:1">✉️</p>
				<!-- /wp:paragraph -->
				<!-- wp:group {"layout":{"type":"flow"}} -->
				<div class="wp-block-group">
					<!-- wp:paragraph {"style":{"typography":{"fontWeight":"700"}}} -->
					<p><strong><?php esc_html_e( 'Email', 'acf-starter-theme' ); ?></strong></p>
					<!-- /wp:paragraph -->
					<!-- wp:paragraph {"textColor":"neutral-600","fontSize":"14"} -->
					<p class="has-neutral-600-color has-text-color has-14-font-size">
						<?php if ( $email ) : ?>
						<a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
						<?php else : ?>
						<?php esc_html_e( '—', 'acf-starter-theme' ); ?>
						<?php endif; ?>
					</p>
					<!-- /wp:paragraph -->
				</div>
				<!-- /wp:group -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->

