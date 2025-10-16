<?php
/**
 * Helper functions for the theme.
 *
 * @package Starter\Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if ( ! function_exists( __NAMESPACE__ . '\\render_component' ) ) :
    /**
     * Render a component and return the HTML.
     *
     * @param string $slug Relative path in /components without extension (e.g. 'services/card')
     * @param array  $args Variables available as $args within the component
     * @return string
     */
    function render_component( string $slug, array $args = [] ) : string {
        ob_start();
        get_template_part( 'template-parts/components/' . $slug, null, $args );
        return (string) ob_get_clean();
    }
endif;

if ( ! function_exists( __NAMESPACE__ . '\\tag_title' ) ) :
    /**
     * Render a title with dynamic tag level and classes.
     *
     * @param int    $level Heading level (0 = p, 1 = h1, 2 = h2, 3 = h3)
     * @param string $text The text content of the title
     * @param string $class Main CSS class for the element
     * @param string $class2 Optional secondary CSS class
     * @return string The HTML string for the title
     */
    function tag_title( $level, $text, $class, $class2 = '' ) {
        $tags = [ 'h1', 'h2', 'h3', 'p' ];
        $level = ( is_numeric( $level ) && $level >= 0 && $level <= 3 ) ? intval( $level ) : 2;
        $tag   = $tags[ $level ];
        return sprintf(
            '<%1$s class="%2$s %3$s">%4$s</%1$s>',
            $tag,
            esc_attr( $class ),
            esc_attr( $class2 ),
            esc_html( $text )
        );
    }
endif;

/**
 * Generar TOC automáticamente a partir de los encabezados en el contenido en la single de post.
 * 
 * @return string HTML del TOC
 */
if ( ! function_exists( __NAMESPACE__ . '\\generate_toc' ) ) :
    function generate_toc() {
        global $post;

        if ( ! $post ) {
            return '';
        }

        $content = $post->post_content;

        // Buscar todos los encabezados h2 y h3 en el contenido
        preg_match_all( '/<h([23])>(.*?)<\/h[23]>/', $content, $matches, PREG_SET_ORDER );

        if ( empty( $matches ) ) {
            return '';
        }

        $toc = '<nav class="toc"><ul>';
        foreach ( $matches as $match ) {
            $level = $match[1];
            $title = strip_tags( $match[2] );
            $slug  = sanitize_title( $title );

            // Añadir un ID al encabezado en el contenido para el enlace
            $content = str_replace( $match[0], sprintf( '<h%1$s id="%2$s">%3$s</h%1$s>', $level, esc_attr( $slug ), $match[2] ), $content );

            // Añadir al TOC
            if ( $level == '2' ) {
                $toc .= sprintf( '<li class="toc-item toc-item-level-2"><a href="#%1$s">%2$s</a></li>', esc_attr( $slug ), esc_html( $title ) );
            } elseif ( $level == '3' ) {
                $toc .= sprintf( '<li class="toc-item toc-item-level-3"><a href="#%1$s">%2$s</a></li>', esc_attr( $slug ), esc_html( $title ) );
            }
        }
        $toc .= '</ul></nav>';

        // Actualizar el contenido del post con los IDs añadidos
        remove_filter( 'the_content', 'wpautop' ); // Evitar que wpautop interfiera
        add_filter( 'the_content', function() use ( $content ) {
            return $content;
        }, 20 );

        return $toc;
    }
endif;