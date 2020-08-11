<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

if ( is_admin() ) {
	add_action( 'admin_menu', 'whcom_add_pages' );
}

if (! function_exists('whcom_add_pages')) {
	function whcom_add_pages () {
		add_menu_page(
			esc_html__( 'WCOM', 'whcom' ),
			esc_html__( 'WCOM', 'whcom' ),
			'manage_options',
			'whcom',
			'whcom_main_page',
			WHCOM_URL . "/admin/assets/images/logo-alt-16.png",
			'81.0001'
		);

		add_submenu_page(
			'whcom',
			esc_html__( 'WCOM Dashboard', 'whcom' ),
			esc_html__( 'WCOM Dashboard', 'whcom' ),
			'manage_options',
			'whcom',
			'whcom_main_page'
		);

		add_submenu_page(
			'whcom',
			esc_html__( 'WHMCS Config', 'whcom' ),
			esc_html__( 'WHMCS Config', 'whcom' ),
			'manage_options',
			'whcom-settings',
			'whcom_settings_page'
		);

		add_submenu_page(
			'whcom',
			esc_html__( 'Styles', 'whcom' ),
			esc_html__( 'Styles', 'whcom' ),
			'manage_options',
			'whcom-styles',
			'whcom_styles_page'
		);

		add_submenu_page(
			'whcom',
			esc_html__( 'Advanced Settings', 'whcom' ),
			esc_html__( 'Advanced Settings', 'whcom' ),
			'manage_options',
			'whcom-advanced-settings',
			'whcom_advanced_settings_page'
		);

		add_submenu_page(
			'whcom',
			esc_html__( 'Debug Info', 'whcom' ),
			esc_html__( 'Debug Info', 'whcom' ),
			'manage_options',
			'whcom-debug',
			'whcom_debug_page'
		);
	}
}

if (! function_exists('whcom_main_page')) {
	function whcom_main_page () {
		require_once( WHCOM_PATH . "/admin/pages/main.php" );
	}
}

if (! function_exists('whcom_settings_page')) {
	function whcom_settings_page () {
		require_once( WHCOM_PATH . "/admin/pages/settings.php" );
	}
}

if (! function_exists('whcom_styles_page')) {
	function whcom_styles_page () {
		require_once( WHCOM_PATH . "/admin/pages/styles.php" );
	}
}

if (! function_exists('whcom_advanced_settings_page')) {
	function whcom_advanced_settings_page () {
		require_once( WHCOM_PATH . "/admin/pages/advanced.php" );
	}
}

if (! function_exists('whcom_debug_page')) {
	function whcom_debug_page () {
		require_once( WHCOM_PATH . "/admin/pages/debug.php" );
	}
}


