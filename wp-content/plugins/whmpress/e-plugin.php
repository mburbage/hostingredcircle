<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 6/13/2019
 * Time: 8:12 PM
 */

namespace ElementorWhmpress;
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
    public function widget_scripts() {
        wp_register_script( 'elementor-whmpress', plugins_url( '/js/elementor-whmpress.js', __FILE__ ), [ 'jquery' ], false, true );
    }
    /**
     * Include Widgets files
     *
     * Load widgets files
     *
     * @since 1.2.0
     * @access private
     */
    private function include_widgets_files() {
        require_once( __DIR__ . '/widgets/order-button.php' );
        require_once( __DIR__ . '/widgets/price.php' );

        require_once( __DIR__ . '/widgets/domain-search.php' );
        require_once( __DIR__ . '/widgets/pricing-table.php' );
        require_once( __DIR__ . '/widgets/currency.php' );
        require_once( __DIR__ . '/widgets/currency-combo.php' );
        require_once( __DIR__ . '/widgets/domain-search-ajax.php' );
        require_once( __DIR__ . '/widgets/domain-whois.php' );
        require_once( __DIR__ . '/widgets/announcements.php' );

        require_once( __DIR__ . '/widgets/bundle-pricing.php' );
        require_once( __DIR__ . '/widgets/bundle-order-button.php' );
        require_once( __DIR__ . '/widgets/bundle-name.php' );
        require_once( __DIR__ . '/widgets/domain-search-bulk.php' );
        require_once( __DIR__ . '/widgets/domain-search-extended.php' );
        require_once( __DIR__ . '/widgets/description.php' );
        require_once( __DIR__ . '/widgets/url.php' );
        require_once( __DIR__ . '/widgets/domain-price.php' );
        require_once( __DIR__ . '/widgets/price-matrix.php' );
        require_once( __DIR__ . '/widgets/price-matrix-extended.php' );
        require_once( __DIR__ . '/widgets/domain-price-list.php' );
        require_once( __DIR__ . '/widgets/order-combo.php' );

        require_once( __DIR__ . '/widgets/order-link.php' );
        require_once( __DIR__ . '/widgets/order-url.php' );
        require_once( __DIR__ . '/widgets/price-matrix-domain.php' );
        require_once( __DIR__ . '/widgets/name.php' );
        require_once( __DIR__ . '/widgets/pricing-table-horizontal.php' );
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
        $this->include_widgets_files();

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Order_Button() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price() );

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Search() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Currency() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Currency_Combo() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Search_Ajax() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Whois() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Announcements() );

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Table() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Bundle_Pricing() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Bundle_Order_Button() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Bundle_Name() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Search_Bulk() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Search_Extended() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Description() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\URL() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Price() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price_Matrix() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price_Matrix_Exended() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Domain_Price_List() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Order_Combo() );

        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Order_Link() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Order_Url() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Price_Matrix_Domain() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Name() );


        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Table() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Pricing_Table_Horizontal() );
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
        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );
        // Register widgets
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );

    }
}
// Instantiate Plugin Class
Plugin::instance();