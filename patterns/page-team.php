<?php
/**
 * Title: Página de equipo
 * Slug: acf-starter-theme/page-team
 * Categories: pages
 * Block Types: core/post-content
 * Post Types: page
 * Keywords: equipo, team
 * Description: Página con sección de equipo usando el bloque ACF Teams.
 */
?>

<!-- wp:group {"tagName":"section","align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"bg","layout":{"type":"constrained"}} -->
<section class="wp-block-group alignfull has-bg-background-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)">

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|8","margin":{"bottom":"var:preset|spacing|48"}}},"layout":{"type":"constrained","contentSize":"640px"}} -->
	<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--48)">
		<!-- wp:paragraph {"align":"center","style":{"typography":{"fontSize":"0.75rem","fontWeight":"600","letterSpacing":"0.1em","textTransform":"uppercase"}},"textColor":"primary"} -->
		<p class="has-text-align-center has-primary-color has-text-color" style="font-size:0.75rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase">Equipo</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"textAlign":"center","level":2,"textColor":"text-heading"} -->
		<h2 class="wp-block-heading has-text-align-center has-text-heading-color has-text-color">Conoce a nuestro equipo</h2>
		<!-- /wp:heading -->
		<!-- wp:paragraph {"align":"center","textColor":"text-muted"} -->
		<p class="has-text-align-center has-text-muted-color has-text-color">Las personas detrás de cada proyecto.</p>
		<!-- /wp:paragraph -->
	</div>
	<!-- /wp:group -->

	<!-- wp:acf/teams {"name":"acf/teams","data":{},"mode":"preview","align":"wide"} /-->

</section>
<!-- /wp:group -->
