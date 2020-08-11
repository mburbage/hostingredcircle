<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

require_once( WCOP_PATH . '/inc/cart-functions.php' );
require_once( WCOP_PATH . '/inc/ajax-functions.php' );

if ( ! function_exists( 'wcop_use_merchant_gateway' ) ) {
	function wcop_use_merchant_gateway() {
		$response = false;
		if ( get_option( 'use_merchant_gateway', '' ) == 'yes' ) {
			$response = true;
		}

		return $response;
	}
}

if ( ! function_exists( 'is_wcop_verified' ) ) {
	function is_wcop_verified() {
		//echo get_option( "wcop_registration_status", 'no' );
		return strtolower( get_option( "wcop_registration_status", 'no' ) ) == "yes";
	}
}

if ( ! function_exists( 'wcop_verify_purchase_function' ) ) {
	function wcop_verify_purchase_function( $vars = [] ) {
		$url = "http://plugins.creativeon.com/envato/";

		$vars["registered_url"] = parse_url( get_bloginfo( "url" ), PHP_URL_HOST );
		if ( $vars["registered_url"] == "" ) {
			$vars["registered_url"] = parse_url( get_bloginfo( "url" ), PHP_URL_PATH );
		}
		$vars["registered_url"] = str_replace( "www.", "", $vars["registered_url"] );

		$vars["item_name"] = "WHMCS Cart & Order Pages - One Page Checkout";

		$vars["version"] = WHCOM_VERSION;

		if ( ! isset( $vars["email"] ) ) {
			$vars["email"] = get_option( "wcop_registration_email" );
		}
		if ( $vars["email"] == "" ) {
			$vars["email"] = get_option( "admin_email" );
		}

		if ( ! isset( $vars["purchase_code"] ) ) {
			$vars["purchase_code"] = get_option( "wcop_registration_code" );
		}
		$vars["registered_url"] = 'wordpress.dev';
		$ch                     = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_VERBOSE, false );
		curl_setopt( $ch, CURLOPT_POST, count( $vars ) );
		#curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		#curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = $vars;
		if ( is_array( $vars ) ) {
			$vars = http_build_query( $vars );
		}
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
		$output = curl_exec( $ch );

		if ( $errno = curl_errno( $ch ) ) {
			$error_message = curl_error( $ch );

			return "cURL error:\n {$error_message}<br />Fetching: $url";
		}

		if ( $output == "OK" ) {
			update_option( "wcop_registration_code", $data["purchase_code"] );
			update_option( "wcop_registration_email", $data["email"] );
			update_option( "wcop_registration_status", "yes" );
		}
		else {
			update_option( "wcop_registration_status", "no" );
		}

		return $output;
	}
}

if ( ! function_exists( 'wcop_un_verify_purchase_function' ) ) {
	function wcop_un_verify_purchase_function( $vars = [] ) {
		$url                    = "http://plugins.creativeon.com/envato/unverify.php";
		$vars["purchase_code"]  = get_option( "wcop_registration_code" );
		$vars["email2"]         = get_option( "wcop_registration_email" );
		$vars["registered_url"] = parse_url( get_bloginfo( "url" ), PHP_URL_HOST );
		$vars["registered_url"] = str_replace( "www.", "", $vars["registered_url"] );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_HEADER, false );
		curl_setopt( $ch, CURLOPT_VERBOSE, false );
		#curl_setopt($ch, CURLOPT_COOKIE, $cookies);
		curl_setopt( $ch, CURLOPT_POST, count( $vars ) );
		#curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		#curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$data = $vars;
		if ( is_array( $vars ) ) {
			$vars = http_build_query( $vars );
		}
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $vars );
		curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13' );
		$output = curl_exec( $ch );

		if ( $output == "OK" ) {
			update_option( "wcop_registration_code", '' );
			update_option( "wcop_registration_email", '' );
			update_option( "wcop_registration_status", "no" );
		}

		return $output;
	}
}

if ( ! function_exists( 'wcop_verification_notice' ) ) {
	function wcop_verification_notice() {
		if ( ! is_wcop_verified() ) {
			$class   = 'notice notice-error';
			$message = esc_html__( 'Your copy of WHMCS Cart & Order Pages (WCOP) is not verified.', 'whcom' );
			$link    = esc_html__( 'Please verify your copy of WCOP', 'whcom' );
			$url     = admin_url( 'admin.php?page=wcop' );

			printf( '<div class="%1$s"><p>%2$s <a href="%3$s">%4$s</a></p></div>', $class, $message, $url, $link );
		}
	}

	add_action( 'admin_notices', 'wcop_verification_notice' );
}

if ( ! function_exists( 'wcop_get_template_directory' ) ) {
	function wcop_get_template_directory( $style = 'single_page' ) {
		$file = '/whmpress_whmcs_cart/templates/' . $style . '/01_default/01_main.php';
		if ( file_exists( get_stylesheet_directory() . $file ) ) {
			$path = get_stylesheet_directory() . '/whmpress_whmcs_cart/';
		}
		else if ( file_exists( get_template_directory() . $file ) ) {
			$path = get_template_directory() . '/whmpress_whmcs_cart/';
		}
		else {
			$path = WCOP_PATH . '/';
		}

		return $path;
	}

	function get_singlePageTemplates_list() {
		$allTemplates  = [];
		$templatesPath = WCOP_PATH . '/templates/single_page/*';
		$directories   = glob( $templatesPath, GLOB_ONLYDIR );
		foreach ( $directories as $file ) {
			$allTemplates[basename( $file )] = basename( $file );
		}

		return $allTemplates;
	}

	function get_shortcode_parameters_wcop( $shortcode ) {

		switch ( $shortcode ) {

			case "whmpress_store":
				return [
					"vc_options"      => [
						"title" => esc_html__( "WCOP Store", "whcom" ),
					],
					'no_param'        => [
						"type"        => "textfield",
						"heading"     => __( "No mandatory parameters", "whcom" ),
						"param_name"  => "01_default",
						"value"       => __( "", "whcom" ),
						"description" => __( "There are no mandatory parameters for this shortcode, optional parameters are set in the advanced tab.", "whcom" )
					],
					'currency_id'     => [
						"type"        => "textfield",
						"group"       => "Advance",
						"heading"     => __( "Currency ID", "whcom" ),
						"param_name"  => "currency_id",
						"value"       => __( "", "whcom" ),
						"description" => __( "Used with multi-currency, set the Currency in which price is displayed, if not mentioned session currency is used (which user have selected), if no session is found, currency set as default in WHMCS is used.", "whcom" )
					],
					'group_id'        => [
						"type"        => "textfield",
						"group"       => "Advance",
						"heading"     => __( "Group ID", "whcom" ),
						"param_name"  => "gids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma separated list of WHMCS Product Groups (all groups will be shown if not provided or empty).", "whcom" )
					],
					'product_id'      => [
						"type"        => "textfield",
						"group"       => "Advance",
						"heading"     => __( "Product ID", "whcom" ),
						"param_name"  => "pids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma Separated list of Product IDs (all products will be shown if not provided or empty).", "whcom" )
					],
					'domain_products' => [
						"vc_type"     => "noyes",
						"group"       => "Advance",
						"heading"     => __( "Domain Products", "whcom" ),
						"param_name"  => "domain_products",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set this to ‘yes’ (lowercase) if you want to show only the products which require a domain or have show domain options set in WHMCS..", "whcom" )
					],
				];
				break;

			case "whmpress_cart_config_product":
				return [
					"vc_options"      => [
						"title" => esc_html__( "WCOP Standerd Order Process", "whcom" ),
					],
					'domain_products' => [
						"type"        => "textfield",
						"heading"     => __( "Domain Products", "whcom" ),
						"param_name"  => "domain_products",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set this to ‘yes’ (lowercase) if you want to show only the products which require a domain or have show domain options set in WHMCS.", "whcom" )
					],
					'currency_id'     => [
						"type"        => "textfield",
						"heading"     => __( "Currency ID", "whcom" ),
						"param_name"  => "currency",
						"value"       => __( "", "whcom" ),
						"description" => __( "Used with multi-currency, set the Currency in which price is displayed, if not mentioned session currency is used (which user have selected), if no session is found, currency set as default in WHMCS is used.", "whcom" )
					],
					'promocode'       => [
						"type"        => "textfield",
						"heading"     => __( "Promocode", "whcom" ),
						"param_name"  => "promocode",
						"value"       => __( "", "whcom" ),
						"description" => __( "This will take promocode and apply on final invoice automatically.", "whcom" )
					],
					'group_id'        => [
						"type"        => "textfield",
						"heading"     => __( "Group ID", "whcom" ),
						"param_name"  => "gids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma separated list of WHMCS Product Groups (all groups will be shown if not provided or empty).", "whcom" )
					],
					'product_id'      => [
						"type"        => "textfield",
						"heading"     => __( "Product ID", "whcom" ),
						"param_name"  => "pids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma Separated list of Product IDs (all products will be shown if not provided or empty).", "whcom" )
					],
				];
				break;

			case "whmpress_cart_single_page":
				return [
					"vc_options"               => [
						"title" => esc_html__( "WCOP One Page Checkout", "whcom" ),
					],
					'style'                    => [
						"fb_type"     => "style",
						"vc_type"     => "dropdown",
						"heading"     => __( "Style", "whcom" ),
						"param_name"  => "style",
						"value"       => get_singlePageTemplates_list(),
						"description" => __( "WCOP offers different styles if no syle is passed default style will be served. default (this is default style if no style is mentioned it is used)", "whcom" )
					],
					'hide_navigation'          => [
						"vc_type"     => "noyes",
						"heading"     => __( "Hide Navigation", "whcom" ),
						"param_name"  => "hide_navigation",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set to ‘yes’ if you want to hide top navigation.", "whcom" )
					],
					'hide_domain'              => [
						"vc_type"     => "noyes",
						"heading"     => __( "Hide Domain", "whcom" ),
						"param_name"  => "hide_domain",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set to ‘yes’ if you want to hide domain registration section.", "whcom" )
					],
					'hide_product'             => [
						"vc_type"     => "noyes",
						"heading"     => __( "Hide Product", "whcom" ),
						"param_name"  => "hide_product",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set to ‘yes’ if you want to hide products/ services selection section.", "whcom" )
					],
					'hide_additional_services' => [
						"vc_type"     => "noyes",
						"heading"     => __( "Hide Additional Services", "whcom" ),
						"param_name"  => "hide_additional_services",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set to ‘yes’ if you want to hide product configuration/add-ons sections.", "whcom" )
					],
					'hide_promo'               => [
						"vc_type"     => "noyes",
						"heading"     => __( "Hide Promo", "whcom" ),
						"param_name"  => "hide_promo",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set to ‘yes’ if you want do not want to use promotions.", "whcom" )
					],
					'gids'                     => [
						"type"        => "textfield",
						"group"       => "Advance",
						"heading"     => __( "Group ID", "whcom" ),
						"param_name"  => "gids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma separated list of WHMCS Product Groups (all groups will be shown if not provided or empty).", "whcom" )
					],
					'pids'                     => [
						"type"        => "textfield",
						"group"       => "Advance",
						"heading"     => __( "Product ID", "whcom" ),
						"param_name"  => "pids",
						"value"       => __( "", "whcom" ),
						"description" => __( "Comma Separated list of Product IDs (all products will be shown if not provided or empty).", "whcom" )
					],
					'domain_products'          => [
						"vc_type"     => "noyes",
						"group"       => "Advance",
						"heading"     => __( "Domain Products", "whcom" ),
						"param_name"  => "domain_products",
						"value"       => __( "", "whcom" ),
						"description" => __( "Set this to ‘yes’ (lowercase) if you want to show only the products which require a domain or have show domain options set in WHMCS.", "whcom" )
					],
				];
				break;
//
//            case "whmpress_cart_domain_first":
//                return array(
//                    "vc_options" => array(
//                        "title" => esc_html__("WCOP Domain First", "whcom"),
//                    ),
//                    'group_id' => array(
//                        "type" => "textfield",
//                        "heading" => __("Group ID", "whcom"),
//                        "param_name" => "gids",
//                        "value" => __("", "whcom"),
//                        "description" => __("Comma separated list of WHMCS Product Groups (all groups will be shown if not provided or empty).", "whcom")
//                    ),
//                    'product_id' => array(
//                        "type" => "textfield",
//                        "heading" => __("Product ID", "whcom"),
//                        "param_name" => "pids",
//                        "value" => __("", "whcom"),
//                        "description" => __("Comma Separated list of Product IDs (all products will be shown if not provided or empty).", "whcom")
//                    ),
//                );
				break;
			default:
				return [];
		}
	}
}

