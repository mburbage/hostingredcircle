<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 6/13/2019
 * Time: 8:12 PM
 */

namespace ElementorWCAP;
/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {
    /**
     * Instance
     *
     * @since 1.2.0
     * @access private
     * @static
     *
     * @var Plugin The single instance of the class.
     */
    private static $_instance = null;
    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @since 1.2.0
     * @access public
     *
     * @return Plugin An instance of the class.
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * widget_scripts
     *
     * Load required plugin core files.
     *
     * @since 1.2.0
     * @access public
     */
    /*public function widget_scripts() {
        wp_register_script( 'elementor-wcop', WCOP_PATH( '/js/elementor-wcop.js', __FILE__ ), [ 'jquery' ], false, true );
    }*/
    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files() {
        require_once( __DIR__ . '/widgets/client-area.php' );
        require_once( __DIR__ . '/widgets/logged-in-content.php' );
        require_once( __DIR__ . '/widgets/logged-out-content.php' );
        require_once( __DIR__ . '/widgets/navigation-menu.php' );
        require_once( __DIR__ . '/widgets/login-form.php' );
    }
    /**
     * Register Widgets
     *
     * Register new Elementor widgets.
     *
     * @since 1.2.0
     * @access public
     */
    public function register_widgets() {
        // Its is now safe to include Widgets files
        $this->include_widgets_files();
        // Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Client_Area() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Logged_in_Content() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Logged_out_Content() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Navigation_Menu() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Log_in_Form() );
    }
    /**
     *  Plugin class constructor
     *
     * Register plugin action hooks and filters
     *
     * @since 1.2.0
     * @access public
     */
    public function __construct() {
        // Register widget scripts
        //add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

    }
}
// Instantiate Plugin Class
Plugin::instance();