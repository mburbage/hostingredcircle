<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if (! function_exists('whcom_get_whmcs_setting')) {
	function whcom_get_whmcs_setting ($setting_name = '') {
		$setting_name = (string)$setting_name;
		
		$whmcs_settings = (!empty($_SESSION) && !empty($_SESSION['whcom_whmcs_settings']) && is_array($_SESSION['whcom_whmcs_settings'])) ? $_SESSION['whcom_whmcs_settings'] : false;
		if (!$whmcs_settings) {
			$args = [
				'action' => 'configurations',
				//'setting' => $setting_name,
			];
			$whmcs_settings = whcom_process_helper( $args )['data'];
			$_SESSION['whcom_whmcs_settings'] = $whmcs_settings;
		}
		
		
		if ($setting_name == '') {
			$response = $whmcs_settings;
		}
		else {
			$response = (!empty($whmcs_settings[$setting_name])) ? $whmcs_settings[$setting_name] : '';
		}

		return $response;
	}
}

if ( ! function_exists( 'whcom_get_whmcs_version' ) ) {
	function whcom_get_whmcs_version() {
		$args     = [
			"action" => "whcom_get_whmcs_version",
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







