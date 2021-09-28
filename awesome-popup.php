<?Php
/**
 * Plugin Name: Awesome Popup
 * Description: An OOP based Awesome Popup
 * Plugin URI:  https:github.com/anisur2805/awesome-popup
 * Version:     1.0.0
 * Author:      Anisur Rahman
 * Author URI:  https:github.com/anisur2805
 * Text Domain: awesome-popup
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

use Awesome\Popup\Assets;

defined( 'ABSPATH' ) or die( 'No Cheating!' );

require_once __DIR__ . "/vendor/autoload.php";

/**
 * The main plugin class
 */
final class Awesome_Popup {
    private $awesome_popup_options;

    /**
     * plugin version
     */
    const version = '1.0';

    /**
     * class constructor
     */
    private function __construct() {
        $this->define_constants();

        add_action( 'admin_menu', array( $this, 'awesome_popup_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'awesome_popup_page_init' ) );
        add_action( 'admin_init', array( $this, 'awesome_popup_settings_save' ) );

        register_uninstall_hook( __FILE__, 'uninstall' );

        add_action( 'plugins_loaded', [$this, 'init_plugin'] );
    }

    public function uninstall() {
        delete_option( 'awesome_popup_content' );
    }

    /**
     * Initialize a singleton instance
     *
     * @return \Awesome_Popup
     */
    public static function init() {
        static $instance = false;
        if ( !$instance ) {
            $instance = new self();
        }

        return $instance;
    }

    public function define_constants() {
        define( 'AWESOME_POPUP_VERSION', self::version );
        define( 'AWESOME_POPUP_FILE', __FILE__ );
        define( 'AWESOME_POPUP_PATH', __DIR__ );
        define( 'AWESOME_POPUP_URL', plugins_url( '', AWESOME_POPUP_FILE ) );
        define( 'AWESOME_POPUP_ASSETS', AWESOME_POPUP_URL . '/assets' );
    }

    public function awesome_popup_add_plugin_page() {
        add_menu_page(
            'Awesome Popup',
            'Awesome Popup',
            'manage_options',
            'awesome-popup',
            array( $this, 'awesome_popup_create_admin_page' ),
            'dashicons-admin-generic',
            59
        );
    }

    public function awesome_popup_create_admin_page() {
        $this->awesome_popup_options = get_option( 'awesome_popup_option_name' );?>

		<div class="wrap">
			<h2>Awesome Popup</h2>
			<p></p>
			<?php settings_errors();?>

			<form method="post" action="options.php">
				<?php
                    settings_fields( 'awesome_popup_option_group' );
                    do_settings_sections( 'awesome-popup-admin' );
                    submit_button();
                ?>
			</form>
		</div>
	<?php }

    public function awesome_popup_page_init() {
        register_setting(
            'awesome_popup_option_group',
            'awesome_popup_option_name',
            array( $this, 'awesome_popup_sanitize' )
        );

        add_settings_section(
            'awesome_popup_setting_section',
            'Settings',
            array( $this, 'awesome_popup_section_info' ),
            'awesome-popup-admin'
        );

        add_settings_field(
            'popup_content_0',
            'Popup Content',
            array( $this, 'popup_content_0_callback' ),
            'awesome-popup-admin',
            'awesome_popup_setting_section'
        );
        
        add_settings_field(
            'shortcode',
            'Shortcode',
            array( $this, 'shortcode_callback' ),
            'awesome-popup-admin',
            'awesome_popup_setting_section'
        );
        
    }

    public function awesome_popup_sanitize( $input ) {
        $sanitary_values = array();
        if ( isset( $input['popup_content_0'] ) ) {
            $sanitary_values['popup_content_0'] = esc_textarea( $input['popup_content_0'] );
        }

        return $sanitary_values;
    }

    public function awesome_popup_section_info() {}

    public function popup_content_0_callback() {
        wp_nonce_field( 'nonce_action', 'nonce_field' );
        $content = get_option( 'awesome_popup_content' );
        wp_editor( $content, 'awesome_popup_settings_wpeditor' );
    }
    
    public function shortcode_callback() {
        echo "<p><code>[awesome_popup]</code></p>";
        echo '<i style="margin-top: 10px;display: block;">Copy and pest the shortcode where you want to use.</i>';
    }

    public function awesome_popup_settings_save() {
        if ( isset( $_POST['awesome_popup_settings_wpeditor'] ) &&
            isset( $_POST['nonce_field'] ) &&
            wp_verify_nonce( $_POST['nonce_field'], 'nonce_action' ) ) {
            update_option( 'awesome_popup_content', wp_kses_post( $_POST['awesome_popup_settings_wpeditor'] ) );
        }
    }

    public function init_plugin() {

        new Awesome\Popup\Assets();

        if ( is_admin() ) {
        } else {
            new \Awesome\Popup\Frontend();
        }
    }

}

/**
 * Initialize the main plugin
 *
 * @return \Awesome_Popup
 */
function awesome_popup() {
    return Awesome_Popup::init();
}

awesome_popup();
