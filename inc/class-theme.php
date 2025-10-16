<?php 
namespace Starter\Theme;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Starter_Theme {

    /**
     * Init
     */
    public static function init() : void {
        self::define_constants();
        self::includes();
        
        add_action( 'after_setup_theme', [ __CLASS__, 'theme_setup' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_front_assets' ] );
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ] );

        // Initialize ACF JSON and ACF Blocks if ACF is active
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_JSON' ) ) {
            \Starter\Theme\Starter_ACF_JSON::init();
        }
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_Blocks' ) ) {
            \Starter\Theme\Starter_ACF_Blocks::init();
        }
    }

    /**
     * Constants
     */
    public static function define_constants() : void {
        if ( ! defined( 'ST_THEME_VERSION' ) ) {
            define( 'ST_THEME_VERSION', '0.1.0' );
        }
        if ( ! defined( 'ST_THEME_NAME' ) ) {
            $theme = wp_get_theme();
            define( 'ST_THEME_NAME', $theme->get( 'Name' ) ? $theme->get( 'Name' ) : 'Starter Theme' );
        }
        if ( ! defined( 'ST_TEXT_DOMAIN' ) ) {
            define( 'ST_TEXT_DOMAIN', 'st-starter' );
        }
        if ( ! defined( 'ST_THEME_DIR' ) ) {
            define( 'ST_THEME_DIR', get_template_directory() );
        }
        if ( ! defined( 'ST_THEME_URI' ) ) {
            define( 'ST_THEME_URI', get_template_directory_uri() );
        }
    }

    /**
     * Includes
     */
    public static function includes() : void {
        $files = [
            'inc/class-acf-json.php',
            'inc/class-acf-blocks.php',
            'inc/helpers.php',
            'inc/team-helpers.php',
        ];
        foreach ( $files as $file ) {
            $path = ST_THEME_DIR . '/' . $file;
            if ( file_exists( $path ) ) {
                require_once $path;
            }
        }
    }

    /**
     * Setup theme features
     */
    public static function theme_setup() : void {
        // Make theme available for translation
        load_theme_textdomain( ST_TEXT_DOMAIN, ST_THEME_DIR . '/languages' );

        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption', 'comment-form', 'style', 'script' ] );

        // Block Editor Support
		add_theme_support( 'wp-block-styles' );   // block styles
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );     // editor styles

        // Add more styles if needed
        add_editor_style( [
            get_theme_file_uri( 'assets/css/main.css?ver=' . filemtime( get_theme_file_path('assets/css/main.css') ) ),
            get_theme_file_uri( 'assets/css/editor.css?ver=' . filemtime( get_theme_file_path('assets/css/editor.css') ) ),
        ] );

        // WooCommerce support
        add_theme_support( 'woocommerce' );
    }

    /**
     * Enqueue theme assets
     */
    public static function enqueue_front_assets() {

        $front_css = ST_THEME_DIR . '/assets/css/main.css';
        if ( file_exists( $front_css ) ) {
            wp_enqueue_style(
                'st-starter-main',
                ST_THEME_URI . '/assets/css/main.css',
                [],
                ST_THEME_VERSION
            );
        }

        $front_js = ST_THEME_DIR . '/assets/js/main.js';
		if ( file_exists( $front_js ) ) {
			wp_enqueue_script(
				'starter-theme-frontend',
				ST_THEME_URI . '/assets/js/main.js',
				[],
				ST_THEME_VERSION,
				true
			);
		}
    }

    /**
     * Enqueue editor assets
     */
    public static function enqueue_editor_assets() {
        $editor_css = ST_THEME_DIR . '/assets/css/editor.css';
        if ( file_exists( $editor_css ) ) {
            wp_enqueue_style(
                'st-starter-editor',
                ST_THEME_URI . '/assets/css/editor.css',
                [],
                ST_THEME_VERSION
            );
        }

        $main_css = ST_THEME_DIR . '/assets/css/main.css';
        if ( file_exists( $main_css ) ) {
            wp_enqueue_style(
                'st-starter-main',
                ST_THEME_URI . '/assets/css/main.css',
                [],
                ST_THEME_VERSION
            );
        }
    }
}