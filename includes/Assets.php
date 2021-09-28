<?php
namespace Awesome\Popup;

class Assets {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_assets'] );
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue_assets'] );
    }

    public function get_scripts() {
        return [
            'awesome-script' => [
                'src'     => AWESOME_POPUP_ASSETS . '/js/frontend.js',
                'version' => filemtime( AWESOME_POPUP_PATH . '/assets/js/frontend.js' ),
                'deps'    => ['jquery'],
            ],
        ];
    }

    public function get_styles() {
        return [
            'awesome-style' => [
                'src'     => AWESOME_POPUP_ASSETS . '/css/frontend.css',
                'version' => filemtime( AWESOME_POPUP_PATH . '/assets/css/frontend.css' ),
            ],
            'admin-style' => [
                'src'     => AWESOME_POPUP_ASSETS . '/css/admin.css',
                'version' => filemtime( AWESOME_POPUP_PATH . '/assets/css/admin.css' ),
            ],
        ];
    }

    public function enqueue_assets() {
        $scripts = $this->get_scripts();

        foreach ( $scripts as $handle => $script ) {
            $deps = isset( $script['deps'] ) ? $script['deps'] : false;
            wp_register_script( $handle, $script['src'], $deps, $script['version'], true );
        }

        $styles = $this->get_styles();

        foreach ( $styles as $handle => $style ) {
            $deps = isset( $style['deps'] ) ? $style['deps'] : false;
            wp_register_style( $handle, $style['src'], $deps, $style['version'] );
        }

    }

}
