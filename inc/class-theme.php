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
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_assets' ], 20 );
        add_action( 'enqueue_block_editor_assets', [ __CLASS__, 'enqueue_editor_assets' ], 20 );
        
        add_filter( 'upload_mimes', [ __CLASS__, 'allow_svg_upload' ] );

        // Initialize ACF helpers if included
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_JSON' ) && method_exists( __NAMESPACE__ . '\\Starter_ACF_JSON', 'init' ) ) {
            \Starter\Theme\Starter_ACF_JSON::init();
        }
        if ( class_exists( __NAMESPACE__ . '\\Starter_ACF_Blocks' ) && method_exists( __NAMESPACE__ . '\\Starter_ACF_Blocks', 'init' ) ) {
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
        if ( ! defined( 'VITE_DEV_SERVER_PORT' ) ) {
            define( 'VITE_DEV_SERVER_PORT', '5173' ); // Change to your Vite dev server port if needed
        }
        if ( ! defined( 'VITE_DEV_SERVER_URL') ) {
            define( 'VITE_DEV_SERVER_URL', 'http://localhost:' . VITE_DEV_SERVER_PORT );
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

        // Basic theme supports
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'comment-form' ) );
        add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link', 'audio', 'gallery', 'status' ) );
        add_theme_support( 'custom-logo' );
        add_theme_support( 'custom-background' );

        // Editor styles
        add_theme_support( 'editor-styles' );
        add_editor_style([
            'assets/css/editor.css'
        ]);

        // Block and widget supports
        add_theme_support( 'wp-block-styles' );
        add_theme_support( 'widgets-block-editor' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );

        // WooCommerce
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

        // If Vite dev server is running, enqueue the module served by Vite.
        if ( self::is_dev_server() ) {
            // Vite serves module at /assets/js/main.js according to your config
            $dev_url = self::get_vite_dev_url();
            $dev_entry = rtrim( $dev_url, '/' ) . '/assets/js/main.js';
            self::enqueue_module_script( 'st-vite-dev-main', $dev_entry, [], null, true );

            // Vite injects CSS in dev automatically, so do not enqueue main.css here.
            return;
        }

        // Production: try manifest
        $manifest = self::get_manifest();
        error_log( 'VITE MANIFEST: ' . ( $manifest ? json_encode( array_keys( $manifest ) ) : 'no manifest' ) );
        if ( $manifest ) {
            // The manifest key is the input path used in rollup (e.g. "assets/js/main.js")
            $entry_key = 'assets/js/main.js';
            if ( isset( $manifest[ $entry_key ] ) ) {
                $entry = $manifest[ $entry_key ];

                // Enqueue JS module (use helper to set type=module)
                if ( ! empty( $entry['file'] ) ) {
                    $js_url = get_stylesheet_directory_uri() . '/dist/' . ltrim( $entry['file'], '/' );
                    $ver = file_exists( get_stylesheet_directory() . '/dist/' . $entry['file'] ) ? filemtime( get_stylesheet_directory() . '/dist/' . $entry['file'] ) : ST_THEME_VERSION;
                    self::enqueue_module_script( 'st-main', $js_url, [], $ver, true );
                }

                // Enqueue any CSS emitted by the build for this entry
                if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
                    foreach ( $entry['css'] as $index => $css_file ) {
                        // Usar la ruta exacta del manifest sin asumir subcarpeta
                        $css_url = get_stylesheet_directory_uri() . '/dist/' . ltrim( $css_file, '/' );
                        $css_path = get_stylesheet_directory() . '/dist/' . ltrim( $css_file, '/' );
                        $css_ver = file_exists( $css_path ) ? filemtime( $css_path ) : ST_THEME_VERSION;
                        
                        wp_enqueue_style( 
                            'st-main-css-' . $index, 
                            $css_url, 
                            [ 'bootstrap' ], // Cambiar dependencia
                            $css_ver 
                        );
                    }
                }

                return; // we've enqueued production assets
            }
        }

        // Fallback: enqueue compiled assets directly from theme (non-hashed)
        wp_enqueue_style(
            'st-starter-fonts',
            get_stylesheet_directory_uri() . '/assets/css/fonts.css',
            [ 'bootstrap' ],
            ST_THEME_VERSION
        );

        wp_enqueue_style(
            'st-starter-main',
            get_stylesheet_directory_uri() . '/assets/css/main.css',
            [ 'st-starter-fonts' ],
            ST_THEME_VERSION
        );

        wp_enqueue_script(
            'st-starter-script',
            get_stylesheet_directory_uri() . '/assets/js/main.js',
            [],
            ST_THEME_VERSION,
            true
        );
    }

    /**
     * Enqueue a script as type=module (for browsers that support it)
     * Fallbacks to normal script enqueue if module support is not available (pre WP 6.5)
     */
    protected static function enqueue_module_script( string $handle, string $src, array $deps = [], $ver = null, $in_footer = true ) {
        // Usa las APIs modernas si existen (WordPress 6.5+)
        if ( function_exists( 'wp_register_script_module' ) && function_exists( 'wp_enqueue_script_module' ) ) {
            // Si aún no está registrado, registramos
            if ( ! wp_script_is( $handle, 'registered' ) ) {
                wp_register_script_module( $handle, $src, $deps, $ver );
            }
            wp_enqueue_script_module( $handle );
            return;
        }

        // Fallback para versiones antiguas: registramos con wp_register_script y marcamos type=module
        if ( ! wp_script_is( $handle, 'registered' ) ) {
            wp_register_script( $handle, $src, $deps, $ver, $in_footer );
        }
        // marcamos el tag como tipo module para que el navegador pueda ejecutar import/export
        wp_script_add_data( $handle, 'type', 'module' );
        wp_enqueue_script( $handle );
    }

    /**
     * Enqueue editor (Gutenberg) assets (dev or prod)
     */
    public static function enqueue_editor_assets() {
        // If dev server is running, use Vite editor entry
        if ( self::is_dev_server() ) {
            $dev_url = self::get_vite_dev_url();
            $dev_entry = rtrim( $dev_url, '/' ) . '/assets/js/editor.js';
            self::enqueue_module_script( 'st-vite-dev-editor', $dev_entry, [], null, true );

            // Vite injects editor CSS in dev
            return;
        }

        // Production: manifest entry for editor
        $manifest = self::get_manifest();
        if ( $manifest && isset( $manifest['assets/js/editor.js'] ) ) {
            $entry = $manifest['assets/js/editor.js'];

            if ( ! empty( $entry['file'] ) ) {
                $js_url = get_stylesheet_directory_uri() . '/dist/' . ltrim( $entry['file'], '/' );
                $ver = file_exists( get_stylesheet_directory() . '/dist/' . $entry['file'] ) ? filemtime( get_stylesheet_directory() . '/dist/' . $entry['file'] ) : ST_THEME_VERSION;
                self::enqueue_module_script( 'st-editor', $js_url, [ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ], $ver, true );
            }

            if ( ! empty( $entry['css'] ) && is_array( $entry['css'] ) ) {
                foreach ( $entry['css'] as $css_file ) {
                    $css_url = get_stylesheet_directory_uri() . '/dist/' . ltrim( $css_file, '/' );
                    $css_ver = file_exists( get_stylesheet_directory() . '/dist/' . $css_file ) ? filemtime( get_stylesheet_directory() . '/dist/' . $css_file ) : ST_THEME_VERSION;
                    wp_enqueue_style( 'st-editor-' . sanitize_title( $css_file ), $css_url, [], $css_ver );
                }
            }

            return;
        }

        // Fallback editor CSS/JS (non-hashed)
        wp_enqueue_style( 'st-starter-editor', get_stylesheet_directory_uri() . '/assets/css/editor.css', [], ST_THEME_VERSION );
        wp_enqueue_script( 'st-starter-editor-script', get_stylesheet_directory_uri() . '/assets/js/editor.js', [ 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' ], ST_THEME_VERSION, true );
    }

    /**
     * Get Vite dev server URL (read from constant or fallback)
     *
     * @return string
     */
    protected static function get_vite_dev_url(): string {
        if ( defined( 'VITE_DEV_SERVER_URL' ) && filter_var( VITE_DEV_SERVER_URL, FILTER_VALIDATE_URL ) ) {
            return rtrim( VITE_DEV_SERVER_URL, '/' );
        }

        $port = defined( 'VITE_DEV_SERVER_PORT' ) ? intval( VITE_DEV_SERVER_PORT ) : 5173;
        return 'http://localhost:' . $port;
    }

    /**
     * Check if Vite dev server is running (quick HEAD request)
     *
     * @param int $port
     * @return bool
     */
    public static function is_dev_server( $timeout = 1.0 ): bool {
        $url = self::get_vite_dev_url() . '/assets/js/main.js';
        $args = [
            'timeout'     => $timeout,
            'redirection' => 0,
            'httpversion' => '1.1',
        ];
        $response = wp_remote_head( $url, $args );
        if ( is_wp_error( $response ) ) {
            return false;
        }
        $code = wp_remote_retrieve_response_code( $response );
        return (int) $code === 200;
    }

    /**
     * Read and parse Vite manifest.json (cached statically during the request)
     *
     * @return array|null
     */
    protected static function get_manifest(): ?array {
        static $manifest = null;
        if ( $manifest !== null ) {
            return $manifest;
        }

        $paths = [
            get_stylesheet_directory() . '/dist/manifest.json',
            get_stylesheet_directory() . '/dist/.vite/manifest.json',
        ];

        foreach ( $paths as $p ) {
            if ( file_exists( $p ) ) {
                $data = json_decode( file_get_contents( $p ), true );
                // desenvuelve array->obj si Vite creó wrapper
                if ( is_array( $data ) && array_keys( $data ) === range(0, count($data)-1) && isset($data[0]) && is_array($data[0]) ) {
                    $data = $data[0];
                }
                $manifest = is_array( $data ) ? $data : null;
                return $manifest;
            }
        }
        $manifest = null;
        return null;
    }


    /**
     * Allow SVG file uploads (simple, no sanitization)
     */
    public static function allow_svg_upload( $mimes ) {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }
}