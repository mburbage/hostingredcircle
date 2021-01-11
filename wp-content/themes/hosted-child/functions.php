<?php

/**
 * 
 * 
 * 
 */
wp_deregister_script('jquery');
wp_deregister_script('revmin');
wp_deregister_style('rs-frontend-settings');
wp_deregister_style('js_composer_front');
wp_deregister_style('vc_tta_style');

wp_register_script( 'hosted-child-js', get_stylesheet_directory_uri() . '/js/hosted-child.js', '', '1.0', true );
wp_enqueue_script( 'hosted-child-js' );
$params_array = array(
	'ajaxurl' => admin_url( 'admin-ajax.php' ),
	'nonce'   => wp_create_nonce( 'hosted-child' ),
);
wp_localize_script( 'hosted-child-js', 'params', $params_array );


wp_register_style('bridge-childstyle-fa-core', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/fontawesome.min.css');
wp_enqueue_style('bridge-childstyle-fa-core');
wp_register_style('bridge-childstyle-fal', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/light.min.css');
wp_enqueue_style('bridge-childstyle-fal');
// wp_register_style('bridge-childstyle-far', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/regular.min.css');
// wp_enqueue_style('bridge-childstyle-far');
//wp_register_style('bridge-childstyle-fab', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/brands.min.css');
//wp_enqueue_style('bridge-childstyle-fab');



wp_enqueue_style('bridge-childstyle-far');

/**
 * Load WHMPress group table on tab click with unique tab id ex. whmpress_pricing_table_group-16
 */

add_action('wp_ajax_nopriv_load_group_table', 'load_group_table', 10, 1);
add_action('wp_ajax_load_group_table', 'load_group_table', 10, 1);

/**
 * Load WHMPress group table on tab click with unique tab id ex. whmpress_pricing_table_group-16
 */
function load_group_table() {
	if ( wp_verify_nonce( $_POST['nonce'], 'hosted-child' ) && isset( $_POST['groupid'] ) ) {
		$groupid = wp_unslash( $_POST['groupid'] );
		echo do_shortcode( '[whmpress_pricing_table_group id="' . $groupid . '"]' );
	}

	wp_die();
}

/**
 * Load domain price matrix after page load
 * 
 */

add_shortcode('whmpress_price_matrix_domain_preloader', 'whmpress_price_matrix_domain_preloader_scripts');

add_action('wp_ajax_nopriv_whmpress_price_table_domain_preloader_function', 'whmpress_price_table_domain_preloader_function');
add_action('wp_ajax_whmpress_price_table_domain_preloader_function', 'whmpress_price_table_domain_preloader_function');

function whmpress_price_table_domain_preloader_function($atts)
{
	$atts = array(
		'data_table' => 'yes',
		'num_of_rows' => 10,
		'html_id' => 'tld_domains'
	);

	$html = include WHMP_PLUGIN_DIR . '/includes/shortcodes/whmpress_price_table_domain.php';

	echo $html;

	wp_die();
}


function whmpress_price_matrix_domain_preloader_scripts($atts)
{

	wp_enqueue_script("whmpress_preloader", get_stylesheet_directory_uri() . "/whmpress/whmpress_preloader.js", array(), false, false);


	wp_localize_script(
		'whmpress_preloader',
		'plugin_data',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'preloadernonce' => wp_create_nonce("preloadernonce"),
			'atts' => $atts
		)
	);
}






