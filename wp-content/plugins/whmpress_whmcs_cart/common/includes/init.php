<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

if ( ! function_exists( 'whcom_init' ) ) {
	function whcom_init() {
		if ( ! session_id() ) {
			session_start();
		}
		if ( ! isset( $_SESSION['whcom_cart'] ) ) {
			$_SESSION['whcom_cart'] = [];
		}
		if ( ! isset( $_SESSION['whcom_cart']['current_item'] ) ) {
			$_SESSION['whcom_cart']['current_item'] = - 1;
		}
		if ( ! isset( $_SESSION['whcom_cart']['all_items'] ) ) {
			$_SESSION['whcom_cart']['all_items'] = [];
		}
		if ( ! isset( $_SESSION['whcom_cart']['all_items_view'] ) ) {
			$_SESSION['whcom_cart']['all_items_view'] = [];
		}
		if ( ! isset( $_SESSION['whcom_cart']['order_specific'] ) ) {
			$_SESSION['whcom_cart']['order_specific'] = [];
		}

		if ( ! isset( $_SESSION['whcom_cart']['cart_domains'] ) ) {
			$_SESSION['whcom_cart']['cart_domains'] = [];
		}
		if ( ! isset( $_SESSION['whcom_cart']['cart_products'] ) ) {
			$_SESSION['whcom_cart']['cart_products'] = [];
		}
		if ( ! isset( $_SESSION['whcom_whmcs_settings'] ) ) {
			$_SESSION['whcom_whmcs_settings'] = [];
		}
		if ( ! isset( $_SESSION['whcom_user'] ) ) {
			$_SESSION['whcom_user'] = [];
		}
		if ( ! isset( $_SESSION['whcom_payment_gateways'] ) ) {
			$_SESSION['whcom_payment_gateways'] = [];
		}
		if ( ! isset( $_SESSION['whcom_tax_default_country'] ) ) {
			$_SESSION['whcom_tax_default_country'] = whcom_get_whmcs_setting('DefaultCountry');
		}
		if ( ! isset( $_SESSION['whcom_tax_default_state'] ) ) {
			$_SESSION['whcom_tax_default_state'] = '';
		}

		if ( ! isset( $_SESSION['whcom_currencies_updated'] ) ) {
			$_SESSION['whcom_current_currency_id'] = '1';
			$_SESSION['currency']                  = '1';
			$_SESSION['whcom_current_currency']    = [
				'id'      => '1',
				'code'    => 'USD',
				'prefix'  => '$',
				'suffix'  => 'USD',
				'format'  => '1',
				'rate'    => '1.0000',
				'default' => '1',
			];
			$_SESSION['whcom_all_currencies']      = [
				[
					'id'      => '1',
					'code'    => 'USD',
					'prefix'  => '$',
					'suffix'  => 'USD',
					'format'  => '1',
					'rate'    => '1.0000',
					'default' => '1',
				]
			];
			whcom_update_currencies();
		}

		if (!isset($_SESSION['whcom_product_count'])){
            $_SESSION['whcom_product_count'] = '';
        }
		if (!isset($_SESSION['whcom_security_questions']))
        {
            $_SESSION['whcom_security_questions'] = [];
        }
		if (!isset($_SESSION['whcom_client_custom_fields']))
		{
            $_SESSION['whcom_client_custom_fields'] = [];
        }
		if (!isset($_SESSION['whcom_visible_gateways']))
        {
            $_SESSION['whcom_visible_gateways'] = [];
        }
        if (!isset($_SESSION['whcom_taxes']))
        {
            $_SESSION['whcom_taxes'] = [];
        }
        if (!isset($_SESSION['whcom_tax_status']))
        {
            $_SESSION['whcom_tax_status'] = [];
        }
        if (!isset($_SESSION['whcom_promotions']))
        {
            $_SESSION['whcom_promotions'] = [];
        }
        if (!isset($_SESSION['whcom_domain_addons']))
        {
            $_SESSION['whcom_domain_addons'] = [];
        }
        if (!isset($_SESSION['whcom_tld_count']))
        {
            $_SESSION['whcom_tld_count'] = [];
        }
        if (!isset($_SESSION['whcom_single_product']))
        {
            $_SESSION['whcom_single_product'] = [];
        }
	}
}
add_action( 'init', 'whcom_init' );



