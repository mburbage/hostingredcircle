<?php

/*
 * Plugin Name: WHMpress - Slider and Comparison Tables
 * Plugin URI: http://WHMpress.com
 * Description: Adds comparison table and sliders to WHMpress, with options to select different templates.
 * Version: 4.5.9
 * Text Domain: wpct
 * Domain Path:       /languages
 * Author: creativeON
 * Author URI: http://creativeon.com
*/

define( 'WPCT_GRP_FILE', __FILE__ );
define( 'WPCT_GRP_PATH', dirname( __FILE__ ) );
define( 'WPCT_GRP_URL', untrailingslashit( plugins_url( basename( dirname( __FILE__ ) ) ) ) );


function wpct_load_textdomain() {

    load_plugin_textdomain( 'wpct', false, basename( dirname( __FILE__ ) ) . '/languages/' );
/*    if ($tmp==false){
        wpct_ppa("not loaded");
    }*/
}
add_action( 'plugins_loaded', 'wpct_load_textdomain' );


/**
 * Some more Constants
 */
if ( ! defined( 'WPCT_GRP_VERSION' ) ) {
	define( 'WPCT_GRP_VERSION', '4.5.9' );
}
if ( ! defined( 'WPCT_GRP_NAME' ) ) {
	define( 'WPCT_GRP_NAME', 'WPCT' );
}


## Initilalizing WHMPress group class.
//require_once(  wpct_get_admin_path() . 'includes/plugin.php' );
include_once( WPCT_GRP_PATH . "/class/whmp_grp_class.php" );
$WHMP_GRP = new WHMPress_Group_Class;

/**
 * Check if WHMPress is activated or not...
 */
register_activation_hook( __FILE__, [ $WHMP_GRP, 'activation_check' ] );

//todo:move to a proper place.
function wpct_get_admin_path() {
	// Replace the site base URL with the absolute path to its installation directory.
	$admin_path = str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, get_admin_url() );

	// Make it filterable, so other plugins can hook into it.
	//$admin_path = apply_filters( 'my_plugin_get_admin_path', $admin_path );
	return $admin_path;
}

