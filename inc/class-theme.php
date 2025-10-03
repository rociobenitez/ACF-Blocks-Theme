<?php 
namespace Starter\Theme;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Starter_Theme {

    /**
     * Initialize the theme
     */
    public static function init() {
        self::define_constants();
        self::includes();
        
        add_action( 'after_setup_theme', [ __CLASS__, 'theme_setup' ] );
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ] );
        add_filter( 'upload_mimes', [ __CLASS__, 'allow_svg_upload' ] );

        // Initialize ACF JSON and ACF Blocks if ACF is active
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_JSON' ) ) {
            \Starter\Theme\Starter_ACF_JSON::init();
        }
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_Blocks' ) ) {
            \Starter\Theme\Starter_ACF_Blocks::init();
        }
    }

    /**
     * Define theme constants
     */
    public static function define_constants() {
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
        if ( ! defined( 'ST_COMPANY_NAME' ) ) {
            define( 'ST_COMPANY_NAME', 'Nombre de la empresa' );
        }
        if ( ! defined( 'ST_API_GOOGLE_MAPS' ) ) {
            define( 'ST_API_GOOGLE_MAPS', 'YOUR_API_KEY' );
        }
    }

    /**
     * Include necessary files
     */
    public static function includes() {
        $files = [
            'inc/class-assets.php',
            'inc/class-acf-json.php',
            'inc/class-acf-blocks.php',
        ];
        foreach ( $files as $file ) {
            $path = get_template_directory() . '/' . $file;
            if ( file_exists( $path ) ) {
                require_once $path;
            }
        }
    }

    /**
     * Setup theme features
     */
    public static function theme_setup() {
        // Make theme available for translation
        load_theme_textdomain( ST_TEXT_DOMAIN, get_template_directory() . '/languages' );

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'comment-form' ) );
        add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery', 'status' ) );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'custom-background' );

        // Add support for editor styles
        add_theme_support( 'editor-styles' );
        add_editor_style([
            'assets/css/editor.css'
        ]);

        // Add support for block styles
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'widgets-block-editor' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );

        // WooCommerce support
        add_theme_support( 'woocommerce' );
    }

    /**
     * Enqueue theme assets
     */
    public static function enqueue_assets() {
        // Bootstrap CSS from CDN
        wp_enqueue_style( 
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            '5.3.3'
        );

        // Enqueue fonts and main styles
        wp_enqueue_style(
            'st-starter-fonts',
            get_theme_file_uri('/assets/css/fonts.css'),
            ['bootstrap'],
            ST_THEME_VERSION
        );

        wp_enqueue_style(
            'st-starter-main',
            get_theme_file_uri('/assets/css/main.css'),
            ['bootstrap','st-starter-fonts','global-styles'],
            ST_THEME_VERSION
        );

        // Enqueue scripts
        wp_enqueue_script(
            'st-starter-script',
            get_template_directory_uri() . '/assets/js/main.js',
            [],
            ST_THEME_VERSION,
            true
        );
        wp_enqueue_script(
            'st-starter-editor-script',
            get_template_directory_uri() . '/assets/js/editor.js',
            ['wp-blocks','wp-dom-ready','wp-edit-post'],
            ST_THEME_VERSION,
            true
        );

        if ( theme_vite_is_dev_server() ) {
            $dev_url = 'http://localhost:5173';
            // If dev server is running, enqueue Vite dev script
            // termina el codigo
        } else {
            // Enqueue production assets
            // termina el codigo
        }
    }

    /**
     * Detect if dev server is running and use dev version of assets
     * If not, use the production version
     */
    public static function is_dev_server( $port = 5173) {
        $dev_server_url = 'http://localhost:' . intval( $port );
        $args = [
            'timeout'   => 1,
            'redirection' => 0,
            'httpversion' => '1.1',
        ];
        $response = wp_remote_head( $dev_server_url, $args );
        if ( is_wp_error( $response ) ) {
            return false;
        }
        $code = wp_remote_retrieve_response_code( $response );
        return (int) $code === 200;
    }

    /**
     * Allow SVG file uploads
     */
    public static function allow_svg_upload( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
}