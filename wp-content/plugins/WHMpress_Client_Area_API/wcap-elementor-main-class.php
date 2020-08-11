<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 6/13/2019
 * Time: 8:02 PM
 */

final class Elementor_WCAP {
    /**
     * Plugin Version
     *
     * @since 1.2.0
     * @var string The plugin version.
     */
    const VERSION = '1.2.0';
    /**
     * Minimum Elementor Version
     *
     * @since 1.2.0
     * @var string Minimum Elementor version required to run the plugin.
     */
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
    /**
     * Minimum PHP Version
     *
     * @since 1.2.0
     * @var string Minimum PHP version required to run the plugin.
     */
    const MINIMUM_PHP_VERSION = '7.0';
    /**
     * Constructor
     *
     * @since 1.0.0
     * @access public
     */
    public function __construct() {
        // Load translation
        add_action( 'init', array( $this, 'i18n' ) );

        //== custom Category
        add_action('elementor/elements/categories_registered', array( $this, 'add_elementor_widget_categories' ) );

        // Init Plugin
        add_action( 'plugins_loaded', array( $this, 'init' ) );
    }
    /**
     * Load Textdomain
     *
     * Load plugin localization files.
     * Fired by `init` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function i18n() {
        load_plugin_textdomain( 'whcom' );
    }
    /**
     * Initialize the plugin
     *
     * Validates that Elementor is already loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed include the plugin class.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 1.2.0
     * @access public
     */
    public function init() {
        // Check if Elementor installed and activated
        if ( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
            return;
        }
        // Check for required Elementor version
        if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
            return;
        }
        // Check for required PHP version
        if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
            add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
            return;
        }
        // Once we get here, We have passed all validation checks so we can safely include our plugin
        require_once( 'e-plugin.php' );
    }
    /**
     * Admin notice
     *
     * Warning when the site doesn't have Elementor installed or activated.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_missing_main_plugin() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor */
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'whcom' ),
            '<strong>' . esc_html__( 'Elementor WCOP', 'whcom' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'whcom' ) . '</strong>'
        );
        /*printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );*/
    }
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_elementor_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-hello-world' ),
            '<strong>' . esc_html__( 'Elementor WCAP', 'whcom' ) . '</strong>',
            '<strong>' . esc_html__( 'Elementor', 'whcom' ) . '</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 1.0.0
     * @access public
     */
    public function admin_notice_minimum_php_version() {
        if ( isset( $_GET['activate'] ) ) {
            unset( $_GET['activate'] );
        }
        $message = sprintf(
        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'whcom' ),
            '<strong>' . esc_html__( 'Elementor WCAP', 'whcom' ) . '</strong>',
            '<strong>' . esc_html__( 'PHP', 'whcom' ) . '</strong>',
            self::MINIMUM_PHP_VERSION
        );
        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    public function add_elementor_widget_categories( ) {

        \Elementor\Plugin::instance()->elements_manager->add_category(
            'wcap',
            [
                'title' => __( 'WCAP', 'whcom' ),
                'icon' => 'fa fa-plug',
            ]
        );

    }



}
// Instantiate Elementor_Hello_World.
new Elementor_WCAP();