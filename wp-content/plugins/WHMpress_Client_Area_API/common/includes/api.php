<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_process_api' ) ) {
	function whcom_process_api( $array = [ 'action' => 'GetCurrencies' ] ) {

	    $whmcs_url     = esc_url( get_option( 'whcom_whmcs_admin_url' ) );
		$auth_array    = [
			'username'     => esc_attr( get_option( 'whcom_whmcs_admin_user' ) ),
			'password'     => md5( esc_attr( get_option( 'whcom_whmcs_admin_pass' ) ) ),
			'accesskey'    => esc_attr( get_option( 'whcom_whmcs_admin_api_key' ) ),
			'responsetype' => 'json',
		];
		$whmcs_path    = $whmcs_url . '/includes/api.php';
		$request_array = array_merge( $auth_array, $array );

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $whmcs_path );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS,
			http_build_query( $request_array )
		);
		if (get_option('whcom_curl_ssl_verify', '') == 'yes') {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		}
		else {
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		if (get_option('whcom_curl_use_user_agent', '') == 'yes') {
			$user_agent = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36';
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		}

		$res_raw = curl_exec( $ch );
		$res = json_decode( $res_raw, true );
		curl_close( $ch );

		$whcom_whmcs_known_api_actions = [
//			'GetClientsDetails' => [
//				'style' => '1',
//			]
		];
		if (array_key_exists($array['action'], $whcom_whmcs_known_api_actions)) {
			$response = [
				'status'  => 'ERROR',
				'message' => 'no proper data found in cURL',
				'data'    => []
			];
			if ( whcom_is_json( $res_raw ) ) {
				$api_res = json_decode( $res_raw, true );
				$action_type = $whcom_whmcs_known_api_actions[$array['action']];
				switch ($action_type['style']) {
					case '1' : {
						if (!empty($api_res['result'])) {
							if ($api_res['result'] == 'success') {
								$response['status'] = 'OK';
								$response['message'] = 'Proper data found,';
								$response['data'] = $api_res;
							}
							else {
								$response['message'] = $api_res['message'];
							}
						}
						else {
							$response['message'] = esc_html__( "API data is not formatted properly", "whcom" );
						}
						break;
					}
					default : {

					}
				}
			}
			else {
				$response['message'] = esc_html__( "API data is not formatted properly", "whcom" );
			}
		}
		else {
			$response = $res;
		}


		return $response;
	}
}

if ( ! function_exists( 'whcom_api_test' ) ) {
	function whcom_api_test() {

		$res = whcom_process_api();

		if (!empty($res['result']) && $res['result'] == 'error' ) {
			whcom_ppa($res);
		}

		$api_test = ( (!empty ($res['result'])) &&  $res['result'] == 'success' ) ? true : false;

		return $api_test;
	}
}
