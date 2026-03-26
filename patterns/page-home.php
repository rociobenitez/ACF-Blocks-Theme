<?php
/**
 * Title: Página de inicio
 * Slug: acf-starter-theme/page-home
 * Categories: pages, featured
 * Block Types: core/post-content
 * Post Types: page
 * Keywords: inicio, home, landing, portada
 * Description: Página de inicio con hero, servicios, sobre nosotros, estadísticas y CTA. Todo editable desde aquí.
 */
?>

<!-- wp:acf/hero {"name":"acf/hero","data":{"tagline":"Bienvenidos","title":"Tu título principal aquí","subtitle":"Una frase que describa lo que haces y por qué eres diferente","bg_color":"primary","bg_mode":"none","padding_y":"lg","content_align":"center","title_tag":"h1","cta":{"title":"Contactar","url":"/contacto"},"cta_style":"default","cta_2":{"title":"Saber más","url":"#servicios"},"cta_2_style":"transparent"},"mode":"preview","align":"full","className":"is-style-centered"} /-->


<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"bg","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|8","margin":{"bottom":"var:preset|spacing|48"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--48)">
		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.75rem","fontWeight":"600","letterSpacing":"0.1em","textTransform":"uppercase"}},"textColor":"primary"} -->
		<p class="has-text-align-center has-primary-color has-text-color" style="font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase">Servicios</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":2,"textColor":"text-heading"} -->
		<h2 class="wp-block-heading has-text-align-center has-text-heading-color has-text-color">Lo que ofrecemos</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center","textColor":"text-muted"} -->
		<p class="has-text-align-center has-text-muted-color has-text-color">Soluciones adaptadas a las necesidades de tu negocio.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|24"}}} -->
	<div class="wp-block-columns alignwide">

		<!-- wp:column {"style":{"border":{"radius":"var:preset|custom|radius|8","width":"1px","style":"solid"},"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|32","left":"var:preset|spacing|32","right":"var:preset|spacing|32"}}},"borderColor":"border","backgroundColor":"bg"} -->
		<div class="wp-block-column has-border-border-color has-border-color has-bg-background-color has-background" style="border-radius:var(--wp--custom--radius--8);border-width:1px;border-style:solid;padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--32);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--32)">
			<!-- wp:heading {"level":3,"textColor":"text-heading","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|8"}}}} -->
			<h3 class="wp-block-heading has-text-heading-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--8)">Servicio uno</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-muted","fontSize":"14"} -->
			<p class="has-text-muted-color has-text-color has-14-font-size">Descripción breve del servicio. Explica el valor que aporta al cliente.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"style":{"border":{"radius":"var:preset|custom|radius|8","width":"1px","style":"solid"},"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|32","left":"var:preset|spacing|32","right":"var:preset|spacing|32"}}},"borderColor":"border","backgroundColor":"bg"} -->
		<div class="wp-block-column has-border-border-color has-border-color has-bg-background-color has-background" style="border-radius:var(--wp--custom--radius--8);border-width:1px;border-style:solid;padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--32);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--32)">
			<!-- wp:heading {"level":3,"textColor":"text-heading","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|8"}}}} -->
			<h3 class="wp-block-heading has-text-heading-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--8)">Servicio dos</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-muted","fontSize":"14"} -->
			<p class="has-text-muted-color has-text-color has-14-font-size">Descripción breve del servicio. Explica el valor que aporta al cliente.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"style":{"border":{"radius":"var:preset|custom|radius|8","width":"1px","style":"solid"},"spacing":{"padding":{"top":"var:preset|spacing|32","bottom":"var:preset|spacing|32","left":"var:preset|spacing|32","right":"var:preset|spacing|32"}}},"borderColor":"border","backgroundColor":"bg"} -->
		<div class="wp-block-column has-border-border-color has-border-color has-bg-background-color has-background" style="border-radius:var(--wp--custom--radius--8);border-width:1px;border-style:solid;padding-top:var(--wp--preset--spacing--32);padding-right:var(--wp--preset--spacing--32);padding-bottom:var(--wp--preset--spacing--32);padding-left:var(--wp--preset--spacing--32)">
			<!-- wp:heading {"level":3,"textColor":"text-heading","style":{"spacing":{"margin":{"bottom":"var:preset|spacing|8"}}}} -->
			<h3 class="wp-block-heading has-text-heading-color has-text-color" style="margin-bottom:var(--wp--preset--spacing--8)">Servicio tres</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-muted","fontSize":"14"} -->
			<p class="has-text-muted-color has-text-color has-14-font-size">Descripción breve del servicio. Explica el valor que aporta al cliente.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</section>
<!-- /wp:group -->


<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"bg-secondary","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-bg-secondary-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

	<!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"blockGap":"var:preset|spacing|48"}}} -->
	<div class="wp-block-columns alignwide are-vertically-aligned-center">

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:image {"sizeSlug":"large","aspectRatio":"4/3","scale":"cover","style":{"border":{"radius":"var:preset|custom|radius|8"}}} -->
			<figure class="wp-block-image size-large" style="border-radius:var(--wp--custom--radius--8)"><img src="" alt="Sobre nosotros" style="aspect-ratio:4/3;object-fit:cover"/></figure>
			<!-- /wp:image -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
		<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%">
			<!-- wp:paragraph {"style":{"typography":{"fontSize":"0.75rem","fontWeight":"600","letterSpacing":"0.1em","textTransform":"uppercase"}},"textColor":"primary"} -->
			<p class="has-primary-color has-text-color" style="font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase">Sobre nosotros</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":2,"textColor":"text-heading","style":{"spacing":{"margin":{"top":"var:preset|spacing|8","bottom":"var:preset|spacing|16"}}}} -->
			<h2 class="wp-block-heading has-text-heading-color has-text-color" style="margin-top:var(--wp--preset--spacing--8);margin-bottom:var(--wp--preset--spacing--16)">Tu historia aquí</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"textColor":"text-body"} -->
			<p class="has-text-body-color has-text-color">Cuenta quién eres, qué haces y por qué lo haces. Dos o tres párrafos breves que conecten con tu cliente ideal.</p>
			<!-- /wp:paragraph -->
			<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|24"}}}} -->
			<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--24)">
				<!-- wp:button -->
				<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Conoce más</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</section>
<!-- /wp:group -->


<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|64","bottom":"var:preset|spacing|64"}}},"backgroundColor":"primary","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-primary-background-color has-background" style="padding-top:var(--wp--preset--spacing--64);padding-bottom:var(--wp--preset--spacing--64)">

	<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|32"}}} -->
	<div class="wp-block-columns alignwide">

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"textAlign":"center","level":3,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 3.5rem)","fontWeight":"700","lineHeight":"1"},"spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
			<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:clamp(2.5rem, 5vw, 3.5rem);font-weight:700;line-height:1;margin-bottom:var(--wp--preset--spacing--4)">+100</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","textColor":"accent","fontSize":"14"} -->
			<p class="has-text-align-center has-accent-color has-text-color has-14-font-size">Clientes</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"textAlign":"center","level":3,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 3.5rem)","fontWeight":"700","lineHeight":"1"},"spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
			<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:clamp(2.5rem, 5vw, 3.5rem);font-weight:700;line-height:1;margin-bottom:var(--wp--preset--spacing--4)">98%</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","textColor":"accent","fontSize":"14"} -->
			<p class="has-text-align-center has-accent-color has-text-color has-14-font-size">Satisfacción</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"textAlign":"center","level":3,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 3.5rem)","fontWeight":"700","lineHeight":"1"},"spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
			<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:clamp(2.5rem, 5vw, 3.5rem);font-weight:700;line-height:1;margin-bottom:var(--wp--preset--spacing--4)">+50</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","textColor":"accent","fontSize":"14"} -->
			<p class="has-text-align-center has-accent-color has-text-color has-14-font-size">Proyectos</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"textAlign":"center","level":3,"textColor":"white","style":{"typography":{"fontSize":"clamp(2.5rem, 5vw, 3.5rem)","fontWeight":"700","lineHeight":"1"},"spacing":{"margin":{"bottom":"var:preset|spacing|4"}}}} -->
			<h3 class="wp-block-heading has-text-align-center has-white-color has-text-color" style="font-size:clamp(2.5rem, 5vw, 3.5rem);font-weight:700;line-height:1;margin-bottom:var(--wp--preset--spacing--4)">10+</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"align":"center","textColor":"accent","fontSize":"14"} -->
			<p class="has-text-align-center has-accent-color has-text-color has-14-font-size">Años</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</section>
<!-- /wp:group -->


<!-- wp:acf/cta {"name":"acf/cta","data":{},"mode":"preview","align":"full"} /-->
