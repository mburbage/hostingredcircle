<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_format_amount' ) ) {
	function whcom_format_amount( $args ) {
		$prefix     = $suffix = $decimal = $dec_sep = $tho_sep = $amount = $fraction = '';
		$add_prefix = $add_suffix = $return_format = $currency = $format = $decimal_places = '';

		if ( ( ! is_array( $args ) ) && ( $args >= 0 ) ) {
			$args = [
				'amount' => $args
			];
		}
		$default = [
			'amount'         => 0.00,
			'return_format'  => 'string',
			'add_prefix'     => 'yes',
			'add_suffix'     => 'no',
			'decimal_places' => 2,
			'currency'       => whcom_get_current_currency_id(),
		];
		$args    = wp_parse_args( $args, $default );
		extract( $args );
		$currency       = whcom_validate_currency_id( $currency );
		$all_currencies = ( ! empty( $_SESSION['whcom_all_currencies'] ) && is_array( $_SESSION['whcom_all_currencies'] ) ) ? $_SESSION['whcom_all_currencies'] : [];
		foreach ( $all_currencies as $curr ) {
			if ( $curr['id'] == $currency ) {
				$prefix = $curr['prefix'];
				$suffix = $curr['suffix'];
				$format = $curr['format'];
				$code   = $curr['code'];
				break;
			}
		}
		switch ( $format ) {
			case '1':
			case '2':
			{
				$dec_sep = '.';
				$tho_sep = ',';
				break;
			}
			case '3':
			{
				$dec_sep = ',';
				$tho_sep = '.';
				break;
			}
			case '4':
			{
				$dec_sep = '.';
				$tho_sep = '';
				break;
			}
			default:
			{
				$dec_sep = '.';
				$tho_sep = ',';
			}
		}


		$amount_raw = $amount;
		if ( empty( $_SESSION['whcom_current_currency'] ) || ! is_array( $_SESSION['whcom_current_currency'] ) ) {
			return $amount;
		}
		if ($code == "PKR"){
		    $decimal_places = 0;
        }


		$amount_raw = (float) $amount_raw;

//		whcom_ppa($amount_raw);
		if ( $return_format == 'string' ) {
			//$decimal_places = 0;
			$amount_raw     = number_format( $amount_raw, $decimal_places, $dec_sep, $tho_sep );
			if ( $add_prefix == 'yes' ) {
				$amount_raw = $prefix . $amount_raw;
			}
			if ( $add_suffix != 'no' ) {
				$amount_raw = $amount_raw . ' ' . $suffix;
			}
		}
		else {
			$amount_parts = explode( '.', $amount_raw );
			$amount_raw   = [
				'prefix'   => $prefix,
				'suffix'   => $suffix,
				'decimal'  => $add_suffix,
				'dec_sep'  => $prefix,
				'tho_sep'  => $prefix,
				'amount'   => $amount_parts[0],
				'fraction' => $amount_parts[1],
			];
		}

		return $amount_raw;
	}
}
if ( ! function_exists( 'whcom_update_currencies' ) ) {
	function whcom_update_currencies() {
		$new_currencies = whcom_process_helper( [ 'action' => 'whcom_all_currencies' ] )['data'];
		if ( ! empty( $new_currencies['all'] ) && is_array( $new_currencies['all'] ) ) {
			$_SESSION['whcom_all_currencies']      = $new_currencies['all'];
			$_SESSION['whcom_current_currency']    = $new_currencies['default'];
			$_SESSION['whcom_current_currency_id'] = $new_currencies['default']['id'];
			$_SESSION['currency']                  = $new_currencies['default']['id'];
			$_SESSION['whcom_currencies_updated']  = 'yes';
		}
	}
}
if ( ! function_exists( 'whcom_get_all_currencies' ) ) {
	function whcom_get_all_currencies() {
		if ( ! empty( $_SESSION['whcom_all_currencies'] ) && is_array( $_SESSION['whcom_all_currencies'] ) ) {
			$currency = $_SESSION['whcom_all_currencies'];
		}
		else {
			$currency = [];
		}

		return $currency;
	}
}
if ( ! function_exists( 'whcom_get_current_currency' ) ) {
	function whcom_get_current_currency() {
		if ( ! empty( $_SESSION['whcom_current_currency'] ) && is_array( $_SESSION['whcom_current_currency'] ) ) {
			$currency = $_SESSION['whcom_current_currency'];
		}
		else {
			$currency = [];
		}

		return $currency;
	}
}
if ( ! function_exists( 'whcom_get_current_currency_id' ) ) {
	function whcom_get_current_currency_id() {
		if ( isset( $_SESSION['whcom_current_currency_id'] ) && $_SESSION['whcom_current_currency_id'] != "0" ) {
			$currency = $_SESSION['whcom_current_currency_id'];
		}
		else {
			$currency = '1';
		}

		return $currency;
	}
}
if ( ! function_exists( 'whcom_validate_currency_id' ) ) {
	function whcom_validate_currency_id( $currency_id = 0 ) {
		$all_currencies  = whcom_get_all_currencies();
		$new_currency_id = whcom_get_current_currency_id();
		if ( $currency_id > 0 ) {
			foreach ( $all_currencies as $currency ) {
				if ( $currency_id == $currency['id'] ) {
					$new_currency_id = $currency_id;
					break;
				}
			}
		}

		return $new_currency_id;
	}
}
if ( ! function_exists( 'whcom_update_current_currency' ) ) {
	function whcom_update_current_currency( $currency_id ) {
		$new_currencies = ( ! empty( $_SESSION['whcom_all_currencies'] ) && is_array( $_SESSION['whcom_all_currencies'] ) ) ? $_SESSION['whcom_all_currencies'] : [];
		$status         = '';
		if ( whcom_is_client_logged_in() ) {
			return $status;
		}
		foreach ( $new_currencies as $currency ) {
			if ( $currency['id'] == (int) $currency_id ) {
				$_SESSION['whcom_current_currency']    = $currency;
				$_SESSION['whcom_current_currency_id'] = $currency['id'];
				$_SESSION['currency']                  = $currency['id'];
				$status                                = 'OK';


				// resetting products and tlds
				$_SESSION['whcom_all_tlds']              = [];
				$_SESSION['whcom_all_products']          = [];
				$_SESSION['whcom_cart']['cart_domains']  = [];
				$_SESSION['whcom_cart']['cart_products'] = [];

				// updating cart items
				$cart_items = whcom_get_cart()['all_items'];
				foreach ( $cart_items as $cart_index => $cart_item ) {
					$updated_item = [
						'cid' => $currency['id']
					];
					whcom_add_update_cart_item( $updated_item, $cart_index );
				}

				break;
			}
		}

		return $status;
	}
}
if ( ! function_exists( 'whcom_get_payment_gateways' ) ) {
	function whcom_get_payment_gateways( $show_visible_only = 'yes' ) {
		$response = [];
		if ( ! empty( $_SESSION['whcom_payment_gateways'] ) && is_array( $_SESSION['whcom_payment_gateways'] ) ) {
			$response['message']          = esc_html__( 'Payment gateways are found', 'whcom' );
			$response['status']           = 'OK';
			$response['payment_gateways'] = $_SESSION['whcom_payment_gateways'];
		}
		else {
			$request = [
				'action' => 'GetPaymentMethods',
			];

			$res = whcom_process_api( $request );
			if ( $res['result'] != 'success' ) {
				$response['message']          = esc_html__( 'Something went wrong...', 'whcom' );
				$response['status']           = 'ERROR';
				$response['payment_gateways'] = [];
			}
			else {
				$response['message']          = esc_html__( 'Payment gateways are found', 'whcom' );
				$response['status']           = 'OK';
				$response['payment_gateways'] = $res['paymentmethods']['paymentmethod'];
				if ( $show_visible_only == 'yes' ) {
					$payment_gateways             = $response['payment_gateways'];
					$response['payment_gateways'] = [];
					if(!empty($_SESSION['whcom_visible_gateways'])){
					    $visible_gateways = $_SESSION['whcom_visible_gateways'];
                    }else {
                        $visible_gateways = $_SESSION['whcom_visible_gateways'] = whcom_process_helper(['action' => 'whcom_visible_payment_gateways'])['data'];
                    }
					if ( is_array( $payment_gateways ) || is_object( $payment_gateways ) ) {
						foreach ( $payment_gateways as $payment_gateway ) {
							if ( (string) in_array( $payment_gateway['module'], $visible_gateways ) ) {
								$response['payment_gateways'][] = $payment_gateway;
							}
						}
					}
				}
				$_SESSION['whcom_payment_gateways'] = $response['payment_gateways'];
			}
		}

		return $response;
	}
}



