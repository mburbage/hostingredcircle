<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class WCOP_CLASS {

	function __construct() {


		if ( is_admin() ) {
			add_action( 'admin_menu', [ $this, 'whmp_add_pages' ] );
		}

		// Adding shortcodes.
		$this->shortcodes();

		// Add styles and scripts on front-end only.
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'styles_scripts' ] );
		}

		// Add Styles and Scripts on admin-pages
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles_scripts' ] );
		}

		## Add functions.php
		require_once( WCOP_PATH . '/inc/functions.php' );

		add_action( 'admin_init', [ $this, 'register_setting' ] );

	}

	/**
	 * Set all fields used in Settings page in Admin panel.
	 */
	public function register_setting() {

		register_setting( 'wcop', 'include_domain_with_hosting' );
		register_setting( 'wcop', 'use_merchant_gateway' );
		register_setting( 'wcop', 'merchant_gateway_key' );
		register_setting( 'wcop', 'wcop_show_invoice_as' );
		register_setting( 'wcop', 'cart_listing_page' . whcom_get_current_language() );
		register_setting( 'wcop', 'configure_product' . whcom_get_current_language() );
		register_setting( 'wcop', 'continue_shopping' . whcom_get_current_language() );
		register_setting( 'wcop', 'order_complete_redirect' . whcom_get_current_language() );

		register_setting( 'wcop_templates', 'wcop_sp_nav_offset' );
		register_setting( 'wcop_templates', 'wcop_sp_scroll_offset' );

        register_setting( 'wcop_misc', 'wcop_show_register_form' );

		register_setting( 'wcop_registration', 'wcop_registration_email' );
		register_setting( 'wcop_registration', 'wcop_registration_code' );
		register_setting( 'wcop_registration', 'wcop_registration_status' );
	}

	// Register and enqueue a custom stylesheet in the front-end.
	function styles_scripts() {
		add_thickbox();

		// Enqueue Plugins Styles and Scripts
		wp_enqueue_style( 'wcop_styles', WCOP_URL . '/assets/css/styles.css', false, WCOP_VERSION );
		wp_enqueue_script( 'wcop_libs', WCOP_URL . '/assets/js/libs.js', 'jquery', WCOP_VERSION, true );
		wp_enqueue_script( 'wcop_scripts', WCOP_URL . '/assets/js/scripts.js', 'jquery', WCOP_VERSION, true );

		$localized_array = [
			'ajax_url'                  => admin_url( 'admin-ajax.php' ),
			'whcom_all_currencies'      => $_SESSION['whcom_all_currencies'],
			'whcom_current_currency'    => $_SESSION['whcom_current_currency'],
			'whcom_current_currency_id' => $_SESSION['whcom_current_currency_id'],
		];
		wp_localize_script( 'wcop_scripts', 'wcop_ajax', $localized_array );
	}

	// Register and enqueue a custom stylesheet in the WordPress admin.
	function admin_styles_scripts() {
		wp_enqueue_script( 'wcop_admin_scripts', WCOP_URL . '/admin/js/admin.js', 'jquery', WCOP_VERSION, true );
        wp_enqueue_style( 'wcop_admin_style', WCOP_URL . '/admin/css/style-admin.css', false, WCOP_VERSION );
	}


	// Register Short-Codes for plugin
	function shortcodes() {
		$wcop_op = 'yes';
		add_shortcode( 'whmpress_store', 'whcom_order_list_products_render' );
		add_shortcode( 'whmpress_cart_list_products', 'whcom_order_list_products_render' );
		add_shortcode( 'whmpress_cart_config_product', 'whcom_order_process_render' );

		add_shortcode( 'whmpress_cart_domain_first', [ $this, 'wcop_domain_first_op_function' ] );
		add_shortcode( 'whmpress_cart_single_page', [ $this, 'wcop_single_page_op_function' ] );
	}

	// Function for Domain First order process
	function wcop_domain_first_op_function( $atts ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WCOP_PATH . "/shortcodes/wcop_domain_first.php" );
		}
		else {
			echo '<div class="wcop_notice">Ordering is not configured properly, kindly contact site owner</div>';
		}
		$OutputString = ob_get_clean();

		return $OutputString;
	}

	// Function for Single Page order process
	function wcop_single_page_op_function( $atts ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WCOP_PATH . "/shortcodes/wcop_single_page.php" );
		}
		else {
			echo '<div class="wcop_notice">Ordering is not configured properly, kindly contact site owner</div>';
		}
		$OutputString = ob_get_clean();

		return $OutputString;
	}


	// Function(s) for adding Admin menu and pages in wp-admin
	function whmp_add_pages() {
		add_menu_page(
			esc_html__( 'WCOP', "whcom" ),
			esc_html__( 'WCOP', "whcom" ),
			'manage_options',
			'wcop',
			[ $this, 'load_plugin_page' ],
			WCOP_URL . "/common/admin/assets/images/logo-alt-16.png", '81.89856'
		);

		add_submenu_page(
			'wcop',
			esc_html__( 'WCOP Dashboard', "whcom" ),
			esc_html__( 'WCOP Dashboard', "whcom" ),
			'manage_options',
			'wcop',
			[ $this, 'load_plugin_page' ]
		);
		
		add_submenu_page( 'wcop', esc_html__( 'WHMCS Config', "whcom" ), esc_html__( 'WHMCS Config', "whcom" ), 'manage_options', 'whcom-settings',
			[ $this, 'load_dummy_admin_page' ] );
		
		add_submenu_page(
			'wcop',
			esc_html__( 'Settings', "whcom" ),
			esc_html__( 'Settings', "whcom" ),
			'manage_options',
			'wcop-settings',
			[ $this, 'load_settings_page' ]
		);

		add_submenu_page(
			'wcop',
			esc_html__( 'Advanced Settings', "whcom" ),
			esc_html__( 'Advanced Settings', "whcom" ),
			'manage_options',
			'wcop-advanced-settings',
			[ $this, 'load_advanced_settings_page' ]
		);

//        add_submenu_page(
//            'wcop',
//            esc_html__( 'Template Style', "whcom" ),
//            esc_html__( 'Template Style', "whcom" ),
//            'manage_options',
//            'wcop-template-style',
//            [ $this, 'load_template_style_page' ]
//        );


		
		
		add_submenu_page( 'wcop', esc_html__( 'Debug Info', "whcom" ), esc_html__( 'Debug Info', "whcom" ), 'manage_options', 'whcom-debug',
			[ $this, 'load_dummy_admin_page' ] );
	}

	function load_plugin_page() {
		require_once( WCOP_PATH . "/admin/admin-pages/main.php" );
	}

	function load_settings_page() {
		require_once( WCOP_PATH . "/admin/admin-pages/settings.php" );
	}

	function load_advanced_settings_page() {
		require_once( WCOP_PATH . "/admin/admin-pages/advanced.php" );
	}

	function load_products_page() {
		require_once( WCOP_PATH . "/admin/admin-pages/products.php" );
	}

	function load_dummy_admin_page() {
	}

	function activation_check() {

	}

}