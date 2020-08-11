<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_log_in_out_link_render' ) ) {
	function whcom_log_in_out_link_render( $atts ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/log_in_out_link.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'wcap_log_in_out_link', 'whcom_log_in_out_link_render' );
add_shortcode( 'whcom_log_in_out_link', 'whcom_log_in_out_link_render' );

if ( ! function_exists( 'whcom_currency_updater_render' ) ) {
	function whcom_currency_updater_render() {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/currency_updater.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_currency_updater', 'whcom_currency_updater_render' );

if ( ! function_exists( 'whcom_client_login_form_render' ) ) {
	function whcom_client_login_form_render( $atts ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/client_login.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_client_login_form', 'whcom_client_login_form_render' );

if ( ! function_exists( 'whcom_client_logout_render' ) ) {
	function whcom_client_logout_render() {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/client_logout.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_client_logout', 'whcom_client_logout_render' );

if ( ! function_exists( 'whcom_client_register_render' ) ) {
	function whcom_client_register_render() {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/client_register.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_client_register', 'whcom_client_register_render' );

if ( ! function_exists( 'whcom_client_update_render' ) ) {
	function whcom_client_update_render() {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/client_update.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_client_update', 'whcom_client_update_render' );

if ( ! function_exists( 'whcom_components_render' ) ) {
	function whcom_components_render() {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/components.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_components', 'whcom_components_render' );

if ( ! function_exists( 'whcom_order_process_render' ) ) {
	function whcom_order_process_render( $atts, $content, $tag ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/order_process.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_order_process', 'whcom_order_process_render' );

if ( ! function_exists( 'whcom_order_list_products_render' ) ) {
	function whcom_order_list_products_render( $atts, $content, $tag ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/list_products.php" );
		}
		else {
			echo '<div class="whcom_alert whcom_alert_danger">' . esc_html__( 'Ordering is not configured properly, kindly contact site owner', 'whcom' ) . '</div>';
		}

		return ob_get_clean();
	}
}
add_shortcode( 'whcom_list_products', 'whcom_order_list_products_render' );

if ( ! function_exists( 'whcom_op_cart_summary_render' ) ) {
	function whcom_op_cart_summary_render( $atts ) {
		ob_start();
		if ( whcom_api_test() && whcom_helper_test() ) {
			include( WHCOM_PATH . "/shortcodes/summary_universal.php" );
		}
		return ob_get_clean();
	}
}
add_shortcode( 'whcom_op_cart_summary', 'whcom_op_cart_summary_render' );

