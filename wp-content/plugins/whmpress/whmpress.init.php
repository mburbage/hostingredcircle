<?php
/**
 * Copyright (c) 2014-2016 by creativeON.
 */

if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * WHMPress uses session variables when currency is selected
 * These hooks control session early.
 *
 * Thanks to peter at http://silvermapleweb.com/using-the-php-session-in-wordpress/
 */
add_action( 'init', 'whmpress_session_start', 1 );
add_action( 'wp_logout', 'whmpress_session_end' );
add_action( 'wp_login', 'whmpress_session_end' );
function whmpress_session_end() {
	if ( session_id() ) {
		@session_destroy();
	}
}

function whmpress_session_start() {
	if ( ! session_id() ) {
        $cacheValue = get_option('whmpress_session_cache_limiter_value');
        session_cache_limiter($cacheValue);
		@session_start();
	}
}

$whmp_submenu_pages = [];

# Getting data version from plugin file
if ( ! function_exists( 'get_plugins' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
$plugin_data = get_plugin_data( dirname( __FILE__ ) . "/whmpress.php" );

/*if ( is_dir( str_replace( DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress", DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "WHMpress_Client_Area", dirname( __FILE__ ) ) ) ) {
	$plugin_data_ca = get_plugin_data( str_replace( DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress", DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "WHMpress_Client_Area", dirname( __FILE__ ) ) . "/client-area.php" );
} else {
	$plugin_data_ca = [];
}*/

/*if ( is_dir( str_replace( DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress", DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress_comp_tables", dirname( __FILE__ ) ) ) ) {
	$plugin_data_grp = get_plugin_data( str_replace( DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress", DIRECTORY_SEPARATOR . "plugins" . DIRECTORY_SEPARATOR . "whmpress_comp_tables", dirname( __FILE__ ) ) . "/index.php" );
} else {
	$plugin_data_grp = [];
}*/

defined( 'WHMP_VERSION' )
|| define( 'WHMP_VERSION', plugin_get_version() );

defined( 'WHMP_PLUGIN_NAME' )
|| define( 'WHMP_PLUGIN_NAME', basename( dirname( __FILE__ ) ) );

define( 'WHMP_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) )
|| defined( 'WHMP_PLUGIN_DIR' );

defined( 'WHMP_PLUGIN_URL' )
|| define( 'WHMP_PLUGIN_URL', untrailingslashit( plugins_url( WHMP_PLUGIN_NAME ) ) );

defined( 'WHMP_ADMIN_DIR' )
|| define( 'WHMP_ADMIN_DIR', WHMP_PLUGIN_DIR . '/admin' );

defined( 'WHMP_ADMIN_URL' )
|| define( 'WHMP_ADMIN_URL', WHMP_PLUGIN_URL . '/admin' );


/* Setting WHMpress tables */
global $wpdb;
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
$charset_collate = $wpdb->get_charset_collate();

/*
$Q = "SELECT `button_text` FROM `{$wpdb->prefix}whmpress_groups`";
$col = $wpdb->get_row($Q);

if (!is_object($col) || is_null($col) || empty($col)) {
    $Q = "ALTER TABLE `{$wpdb->prefix}whmpress_groups` ADD `button_text` varchar(50) NOT NULL";
    $wpdb->query($Q);
}*/

// Setting SEO URLs fields
/*$whmp_seo_urls = array(
    "announcements",
    "knowledgebase",
    "serverstatus",
    "contact",
    "domainchecker",
    "cart",
    "submitticket",
    "clientarea",
    "register",
    "pwreset",
);*/