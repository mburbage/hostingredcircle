<?php
/**
 * 
 * 
 * 
 */
		

		

wp_register_style('bridge-childstyle-fa-core', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/fontawesome.min.css');
wp_enqueue_style('bridge-childstyle-fa-core');
wp_register_style('bridge-childstyle-fal', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/light.min.css');
wp_enqueue_style('bridge-childstyle-fal');
wp_register_style('bridge-childstyle-fab', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/brands.min.css');
wp_enqueue_style('bridge-childstyle-fab');
wp_register_style('bridge-childstyle-far', get_stylesheet_directory_uri() . '/font-awesome-5-pro/css/regular.min.css');
wp_enqueue_style('bridge-childstyle-far');



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


function whmpress_price_matrix_domain_preloader_scripts($atts){

		wp_enqueue_script( "whmpress_preloader", get_stylesheet_directory_uri() . "/whmpress/whmpress_preloader.js", array(), false, false);
		

		wp_localize_script(	'whmpress_preloader', 'plugin_data',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'preloadernonce' => wp_create_nonce( "preloadernonce" ),
				'atts' => $atts
			)
		);
}


add_shortcode('whmpress_price_matrix_domain_preloader', 'whmpress_price_matrix_domain_preloader_scripts');

add_action('wp_ajax_nopriv_whmpress_price_table_domain_preloader_function', 'whmpress_price_table_domain_preloader_function');
add_action('wp_ajax_whmpress_price_table_domain_preloader_function', 'whmpress_price_table_domain_preloader_function');


// function new_price_promotions($allprices){
// 	echo '<script>console.log('.json_encode( $allprices ).');</script>';
// 	return $allprices;
// }
// add_filter('AllPrices', 'new_price_promotions', 10, 4);
