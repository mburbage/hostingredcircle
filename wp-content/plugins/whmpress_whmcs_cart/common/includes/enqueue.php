<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_enqueues' ) ) {
	function whcom_enqueues() {
		add_thickbox();
		wp_enqueue_style( 'whcom_styles', WHCOM_URL . '/assets/css/whcom.css', false, WHCOM_VERSION );
		wp_add_inline_style( 'whcom_styles', whcom_css_overrides() );

		wp_enqueue_script( 'whcom_scripts', WHCOM_URL . '/assets/js/whcom.js', [ 'jquery' ], WHCOM_VERSION, false );
		$localized_array = [
			'ajax_url'                    => admin_url( 'admin-ajax.php' ),
			'whcom_loading_text'          => esc_html__( 'Loading...', 'whcom' ),
			'whcom_working_text'          => esc_html__( 'Working...', 'whcom' ),
			'whcom_redirecting_text'      => esc_html__( 'Redirecting...', 'whcom' ),
			'whcom_delete_cart_item_text' => esc_html__( 'Are you sure you want to remove this item from cart', 'whcom' ) . '?',
			'whcom_no_domain_added_text'  => esc_html__( 'Select at least one domain to continue.', 'whcom' ),
			'whcom_all_currencies'        => $_SESSION['whcom_all_currencies'],
			'whcom_current_currency'      => $_SESSION['whcom_current_currency'],
			'whcom_current_currency_id'   => $_SESSION['whcom_current_currency_id'],
		];
		wp_localize_script( 'whcom_scripts', 'whcom_ajax', $localized_array );
	}
}

if ( ! function_exists( 'whcom_admin_enqueues' ) ) {
	function whcom_admin_enqueues() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'whcom_admin_styles', WHCOM_URL . '/admin/assets/css/whcom_admin.css', false, WHCOM_VERSION );
		wp_enqueue_script( 'whcom_admin_scripts', WHCOM_URL . '/admin/assets/js/whcom_admin.js', [
			'wp-color-picker',
			'jquery'
		], WHCOM_VERSION, true );
		wp_enqueue_script( 'whcom_scripts', WHCOM_URL . '/assets/js/whcom.js', [ 'jquery' ], WHCOM_VERSION, false );
		$localized_array = [
			'ajax_url'                  => admin_url( 'admin-ajax.php' ),
			'whcom_loading_text'        => esc_html__( 'Loading...', 'whcom' ),
			'whcom_working_text'        => esc_html__( 'Working...', 'whcom' ),
			'whcom_redirecting_text'    => esc_html__( 'Redirecting...', 'whcom' ),
			'whcom_all_currencies'      => $_SESSION['whcom_all_currencies'],
			'whcom_current_currency'    => $_SESSION['whcom_current_currency'],
			'whcom_current_currency_id' => $_SESSION['whcom_current_currency_id'],
		];
		wp_localize_script( 'whcom_scripts', 'whcom_ajax', $localized_array );
	}
}
if ( ! is_admin() ) {
	add_action( 'wp_enqueue_scripts', 'whcom_enqueues' );
}
if ( is_admin() ) {
	add_action( 'admin_enqueue_scripts', 'whcom_admin_enqueues' );
}

if ( ! function_exists( 'whcom_css_overrides' ) ) {
	function whcom_css_overrides() {

		ob_start();
		include_once WHCOM_PATH . "/assets/css/overrides.less";

		global $whcom_style_overrides;
		foreach ( $whcom_style_overrides as $style ) {
			$fld = $style['key'];
			$val = esc_attr( get_option( 'whcom_st' . $fld, $style['value'] ) );
			if ( ( $val != "" ) && ( $val != $style['value'] ) ) {
				echo '@' . $style['key'] . ': ' . $val . ';';
			}
		}

		$less_code = ob_get_clean();
		require WHCOM_PATH . "/assets/libs/lessphp/lessc.inc.php";

		$less = new whcom_lessc();

		try {
			$css = $less->compile( $less_code );
		} catch ( exception $e ) {
			$css = "/**== fatal error: " . $e->getMessage() . " ==**/";
		}


		return $css;
	}
}

