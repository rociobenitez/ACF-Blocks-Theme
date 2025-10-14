<?php
/**
 * Theme functions and definitions
 *
 * @package Starter\Theme
 */

defined( 'ABSPATH' ) || exit;

// Include necessary files
require_once get_template_directory() . '/inc/class-theme.php';
require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/team-helpers.php';

// Initialize the theme
if ( class_exists( 'Starter\Theme\\Starter_Theme' ) ) {
    add_action( 'after_setup_theme', [ 'Starter\Theme\\Starter_Theme', 'init' ] );
}