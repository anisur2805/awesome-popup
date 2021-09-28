<?php
namespace Awesome\Popup;

class Frontend {
    public function __construct() {
        add_shortcode( 'awesome_popup', [$this, 'awesome_popup_shortcode'] );
    }

    public function awesome_popup_shortcode( $atts, $content ) {
        
        wp_enqueue_script('awesome-script');
        wp_enqueue_style('awesome-style');
        
        $atts = shortcode_atts( array(
            'content' => get_option( 'awesome_popup_content' ),
        ), $atts );

        $options = get_option( 'awesome_popup_content' );
        ob_start();
        $html = '';
        $html .= '<div class="awesome_popup_wrapper"><div class="awesome_popup_content"><span class="close_awesome_popup dashicons-before dashicons-no-alt">X</span>' . $atts['content'] . '</div></div>';
        $clean_obj = ob_get_clean();
        return $html . $clean_obj;
        
    }

}
