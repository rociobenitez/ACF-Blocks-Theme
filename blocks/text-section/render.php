<?php
/**
 * Sección de Texto — render.php
 *
 * Variantes via block className (is-style-*):
 *   centered  – texto centrado, ancho constrained (default)
 *   split     – tagline/título a la izq., cuerpo a la der. (editorial)
 *   highlight – fondo de color, texto centrado
 *   large     – heading oversize como elemento gráfico
 *   list      – listado de features con icono y descripción
 *
 * @package Starter\Theme
 */

namespace Starter\Theme;

defined( 'ABSPATH' ) || exit;

// ── Detección de variante ──────────────────────────────────────────
$cls          = $block['className'] ?? '';
$is_split     = str_contains( $cls, 'is-style-split' );
$is_highlight = str_contains( $cls, 'is-style-highlight' );
$is_large     = str_contains( $cls, 'is-style-large' );
$is_list      = str_contains( $cls, 'is-style-list' );
// default = centered

// ── Campos comunes ────────────────────────────────────────────────
$tagline     = (string) ( get_field( 'ts_tagline' )   ?: '' );
$heading     = (string) ( get_field( 'ts_heading' )  ?: '' );
$heading_tag = (string) ( get_field( 'ts_heading_tag' ) ?: 'h2' );
$heading_tag = in_array( $heading_tag, [ 'h1', 'h2', 'h3', 'p' ], true ) ? $heading_tag : 'h2';
$body        = (string) ( get_field( 'ts_body' )     ?: '' );
$cta_label   = (string) ( get_field( 'ts_cta_label' ) ?: '' );
$cta_url     = (string) ( get_field( 'ts_cta_url' )   ?: '' );
$cta_style   = (string) ( get_field( 'ts_cta_style' ) ?: 'primary' ); // primary | secondary | ghost

// Exclusivo de variante list
$items = $is_list ? ( (array) get_field( 'ts_items' ) ?: [] ) : [];

// Preview: datos de ejemplo si no hay contenido
if ( ! empty( $is_preview ) && ! $heading && ! $body ) {
    $tagline  = 'Por qué elegirnos';
    $body    = 'Aquí va el cuerpo de texto de la sección.';
    if ( $is_list ) {
        $heading = 'Nuestras ventajas';
        $items   = [
            [ 'ts_item_icon' => '✦', 'ts_item_title' => 'Diseño a medida',   'ts_item_body' => 'Cada proyecto es único y lo tratamos como tal.' ],
            [ 'ts_item_icon' => '✦', 'ts_item_title' => 'Soporte continuo',  'ts_item_body' => 'Estamos contigo después del lanzamiento.' ],
            [ 'ts_item_icon' => '✦', 'ts_item_title' => 'Resultados reales', 'ts_item_body' => 'Métricas claras desde el primer día.' ],
        ];
    } elseif ( $is_large ) {
        $heading = 'Creamos experiencias digitales que funcionan.';
    } elseif ( $is_split ) {
        $heading = 'Una forma diferente de hacer las cosas';
    } else {
        $heading = 'Trabajamos contigo, no para ti';
    }
}

// ── Clases BEM del wrapper ────────────────────────────────────────
$block_classes = [ 'text-section' ];
if ( $cls ) {
    foreach ( array_filter( explode( ' ', $cls ) ) as $c ) {
        if ( ! in_array( $c, $block_classes, true ) ) {
            $block_classes[] = $c;
        }
    }
}

$anchor = ! empty( $block['anchor'] ) ? ' id="' . esc_attr( $block['anchor'] ) . '"' : '';

if ( ! $heading && ! $body && empty( $items ) ) {
    return; // No renderizar nada si no hay contenido (excepto en preview, donde se muestra contenido de ejemplo)
}
?>
<section class="<?php echo esc_attr( implode( ' ', array_unique( $block_classes ) ) ); ?>"<?php echo $anchor; ?>>
    <div class="container text-section__inner">

        <?php if ( $is_split ) : ?>
            <?php // ── VARIANTE SPLIT ─────────────────────────────────── ?>
            <div class="text-section__split-left">
                <div class="text-section__split-header">
                    <?php if ( $tagline ) : ?>
                        <p class="text-section__tagline"><?php echo esc_html( $tagline ); ?></p>
                    <?php endif; ?>
                    <?php if ( $heading ) : ?>
                        <<?php echo $heading_tag; ?> class="text-section__heading">
                            <?php echo esc_html( $heading ); ?>
                        </<?php echo $heading_tag; ?>>
                    <?php endif; ?>
                </div>
                <?php if ( $cta_label && $cta_url ) : ?>
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="text-section__cta text-section__cta--<?php echo esc_attr( $cta_style ); ?>">
                        <?php echo esc_html( $cta_label ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="text-section__split-right">
                <?php if ( $body ) : ?>
                    <div class="text-section__body"><?php echo wp_kses_post( $body ); ?></div>
                <?php endif; ?>
            </div>

        <?php elseif ( $is_list ) : ?>
            <?php // ── VARIANTE LIST ──────────────────────────────────── ?>
            <?php if ( $tagline ) : ?>
                <p class="text-section__tagline"><?php echo esc_html( $tagline ); ?></p>
            <?php endif; ?>
            <?php if ( $heading ) : ?>
                <<?php echo $heading_tag; ?> class="text-section__heading">
                    <?php echo esc_html( $heading ); ?>
                </<?php echo $heading_tag; ?>>
            <?php endif; ?>
            <?php if ( $body ) : ?>
                <div class="text-section__body text-section__body--lead"><?php echo wp_kses_post( $body ); ?></div>
            <?php endif; ?>
            <?php if ( $items ) : ?>
                <ul class="text-section__list">
                    <?php foreach ( $items as $item ) : ?>
                        <li class="text-section__list-item">
                            <?php if ( ! empty( $item['ts_item_icon'] ) ) : ?>
                                <span class="text-section__list-icon" aria-hidden="true">
                                    <?php echo esc_html( $item['ts_item_icon'] ); ?>
                                </span>
                            <?php endif; ?>
                            <div class="text-section__list-content">
                                <?php if ( ! empty( $item['ts_item_title'] ) ) : ?>
                                    <strong class="text-section__list-title">
                                        <?php echo esc_html( $item['ts_item_title'] ); ?>
                                    </strong>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['ts_item_body'] ) ) : ?>
                                    <p class="text-section__list-body">
                                        <?php echo wp_kses_post( $item['ts_item_body'] ); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

        <?php else : ?>
            <?php // ── VARIANTES: centered · highlight · large ────────── ?>
            <div class="text-section__header">
                <?php if ( $tagline ) : ?>
                    <p class="text-section__tagline"><?php echo esc_html( $tagline ); ?></p>
                <?php endif; ?>
                <?php if ( $heading ) : ?>
                    <<?php echo $heading_tag; ?> class="text-section__heading">
                        <?php echo esc_html( $heading ); ?>
                    </<?php echo $heading_tag; ?>>
                <?php endif; ?>
            </div>
            <?php if ( $body && ! $is_large ) : ?>
                <div class="text-section__body"><?php echo wp_kses_post( $body ); ?></div>
            <?php endif; ?>
            <?php if ( $cta_label && $cta_url ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="text-section__cta text-section__cta--<?php echo esc_attr( $cta_style ); ?>">
                    <?php echo esc_html( $cta_label ); ?>
                </a>
            <?php endif; ?>
        <?php endif; ?>

    </div>
</section>
