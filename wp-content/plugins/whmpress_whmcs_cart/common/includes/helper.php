<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_process_helper' ) ) {
	function whcom_process_helper( $args = "" ) {

		$response = [
			'status'  => 'ERROR',
			'message' => 'no proper data found in cURL',
			'data'    => []
		];
		$URL = esc_url( get_option( 'whcom_whmcs_admin_url' ) ) . "/index.php";
		$default = [
			"wcap_db_request" => "",
			"action"          => "wcap_helper_version",
			"hash"            => md5( esc_attr( get_option( 'whcom_whmcs_admin_api_key' ) ) . "creativeON" ),
			"currency"        => whcom_get_current_currency_id(),
		];
		$args    = wp_parse_args( $args, $default );
		$request_array = http_build_query( $args );

		$c = curl_init();
		if (get_option('whcom_curl_use_get_method', '') == 'yes') {
			curl_setopt( $c, CURLOPT_URL, $URL . '?' . $request_array);
			curl_setopt( $c, CURLOPT_POST, 0 );
		}
		else {
			curl_setopt( $c, CURLOPT_URL, $URL );
			curl_setopt( $c, CURLOPT_POST, 1 );
			curl_setopt( $c, CURLOPT_POSTFIELDS, $request_array );
		}
		if (get_option('whcom_curl_ssl_verify', '') == 'yes') {
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
		}
		else {
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
		}
		if (get_option('whcom_curl_use_user_agent', '') == 'yes') {
			$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';
			curl_setopt($c, CURLOPT_USERAGENT, $user_agent);
		}



		curl_setopt( $c, CURLOPT_RETURNTRANSFER, 1 );


		$res = curl_exec( $c );

		//Check response time of every request and log it into debug.log file

        if(get_option("whcom_debug_log") == "yes"){
            $pluginlog = ABSPATH.'debug.log';
            date_default_timezone_set('Australia/Melbourne');
            $date = "Current Time " . date('h:i:s a', time()) . " ";
            $info = curl_getinfo($c);
            $message = $request_array.PHP_EOL;
            error_log($date, 3, $pluginlog);
            error_log("Response Time " . $info['total_time'] . " ", 3, $pluginlog);
            error_log($message, 3, $pluginlog);
        }

		curl_close( $c );
        //== if "/" occurs in helper response before '{' then omit it.
        $res = strstr($res, '{');
        if ( whcom_is_json( $res ) ) {
			$response = json_decode( $res, true );
			if (!empty($response['status']) && $response['status'] == 'OK') {
				if (!isset($response['data'])) {
					$response['data'] = [];
				}
			}
			else {
				$response['message'] = (!empty($response['message'])) ? $response['message'] : esc_html__( "Helper data not properly formatted 1", "whcom" );
			}
		}
		else {
			$response['message'] = esc_html__( "Helper data not properly formatted 2", "whcom" );
		}
		return $response;
	}
}

if ( ! function_exists('whcom_helper_test')) {
	function whcom_helper_test () {
		$args     = [
			"wcap_helper_online" => "1",
		];
		$response = whcom_process_helper( $args );
		if ($response['status'] == 'OK') {
			return true;
		}
		else {
			return false;
		}
	}
}

if ( ! function_exists( 'whcom_get_helper_version' ) ) {
	function whcom_get_helper_version() {
		$args     = [
			"action" => "whcom_get_helper_version",
		];
		$response = whcom_process_helper( $args );
		if ($response['status'] == 'OK') {
			return $response['data'];
		}
		else {
			return $response['message'];
		}
	}
}



