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