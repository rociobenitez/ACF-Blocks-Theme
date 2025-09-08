<?php
namespace Starter\Theme;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Registers custom ACF blocks
 */
class Starter_ACF_Blocks {

    /**
     * Initialize ACF Blocks functionality
     */
    public static function init() {

        add_action( 'acf/init', [ __CLASS__, 'register_blocks' ] );
        add_action( 'init', [ __CLASS__, 'register_block_styles' ] );
    }

    public static function register_categories( $categories ) {
        $slug = 'starter-blocks';
        // Check if the category already exists
        foreach ( $categories as $cat ) {
            if ( isset( $cat['slug'] ) && $cat['slug'] === $slug ) {
                return $categories;
            }
        }

        $categories[] = [
            'slug'  => $slug,
            'title' => __( 'Starter Blocks', ST_TEXT_DOMAIN ),
            'icon'  => 'admin-comments',
        ];

        return $categories;
    }

    /**
     * Auto-register ACF blocks
     *
     * Detect any block folder under /blocks containing a block.json file
     * and register it with ACF.
     */
    public static function register_blocks() {
        $blocks_dir = get_template_directory() . '/blocks';
        if ( ! is_dir( $blocks_dir ) ) {
            return; // No blocks directory found
        }

        $iterator = new \DirectoryIterator( $blocks_dir );

        foreach ( $iterator as $fileinfo ) {
            if ( $fileinfo->isDot() && ! $fileinfo->isDir() ) {
                continue;
            }

            $block_dir = $fileinfo->getPathname();
            $block_json = $block_dir . '/block.json';

            if ( file_exists( $block_json ) ) {
                register_block_type( $block_dir );
            }
        }
    }

    /**
     * Register custom block styles
     */
    public static function register_block_styles() {
        // Topbar styles
        register_block_style('acf/topbar', [
            'name'  => 'topbar-light',
            'label' => __('Light', 'acf-starter'),
        ]);
        register_block_style('acf/topbar', [
            'name'  => 'topbar-dark',
            'label' => __('Dark', 'acf-starter'),
        ]);
        register_block_style('acf/topbar', [
            'name'  => 'topbar-primary',
            'label' => __('Primary', 'acf-starter'),
        ]);
        register_block_style('acf/topbar', [
            'name'  => 'topbar-transparent',
            'label' => __('Transparent', 'acf-starter'),
        ]);
        register_block_style('acf/topbar', [
            'name'  => 'topbar-divider',
            'label' => __('Bottom divider', 'acf-starter'),
        ]);
        register_block_style('acf/topbar', [
            'name'  => 'topbar-deactivated',
            'label' => __('Desactivado', 'acf-starter'),
        ]);
    }
}