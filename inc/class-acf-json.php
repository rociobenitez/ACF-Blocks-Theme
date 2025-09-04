<?php
namespace Starter\Theme;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Starter_ACF_JSON {

    /**
     * Initialize ACF JSON functionality
     */
    public static function init() {

        add_action( 'admin_notices', [ __CLASS__, 'acf_admin_notice' ] );

        if ( ! class_exists( 'ACF' ) ) {
            return; // ACF is not active
        }

        if ( function_exists( 'acf_add_options_page' ) ) {
            acf_add_options_page( [
                'page_title' => esc_html__( 'Opciones Generales', ST_TEXT_DOMAIN ),
                'menu_title' => esc_html__( 'Opciones', ST_TEXT_DOMAIN ),
                'menu_slug'  => 'theme-general-settings',
                'capability' => 'manage_options',
                'redirect'   => false,
            ] );
        }

        // Hook into ACF save and load JSON actions
        add_filter( 'acf/settings/save_json', [ __CLASS__, 'save_json' ] );
        add_filter( 'acf/settings/load_json', [ __CLASS__, 'load_json' ] );

    }

    /**
     * Set the path to save ACF JSON files
     *
     * @param string $path The current path.
     * @return string The modified path.
     */
    public static function save_json( $path ) {
        $path = get_template_directory() . '/acf-json';
        return $path;
    }

    /**
     * Set the path to load ACF JSON files
     *
     * @param array $paths The current paths.
     * @return array The modified paths.
     */
    public static function load_json( $paths ) {
        // Remove original path (optional)
        unset( $paths[0] );
        // Add custom path
        $paths[] = get_template_directory() . '/acf-json';
        return $paths;
    }


    /**
     * Display admin notices for ACF-related issues:
     *  - ACF is not active
     *  - ACF Pro is not active
     *  - Options are saved
     */
    public static function acf_admin_notice() {
        if ( ! current_user_can( 'activate_plugins' ) ) {
            return;
        }

        if ( ! function_exists( 'acf_register_block_type' ) ) {
            printf(
                '<div class="notice notice-error"><p>%s</p></div>',
                esc_html__( sprintf( 'Se requiere ACF Pro para que el tema %s funcione correctamente. Por favor, instala y activa ACF Pro.', ST_THEME_NAME ), ST_TEXT_DOMAIN )
            );
            return;
        }

        $page = isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';
        $updated = isset( $_GET['settings-updated'] ) ? sanitize_text_field( wp_unslash( $_GET['settings-updated'] ) ) : '';
        if ( 'theme-general-settings' === $page && 'true' === $updated ) {
            printf(
                '<div class="notice notice-success is-dismissible"><p>%s</p></div>',
                esc_html__( 'Opciones guardadas correctamente.', ST_TEXT_DOMAIN )
            );
            return;
        }
    }
}