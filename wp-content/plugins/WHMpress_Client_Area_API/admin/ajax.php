<?php

switch ($_POST['what']) {
	case "verify_whmcs":
		echo $this->whmcs_autenticated($_POST);

		break;
	case "update_settings":
		$ignore_keys=["action", "what", "pll_ajax_backend"];
		print_r ($_POST);
		foreach($_POST as $key=>$value) {
			if ( !in_array( $key, $ignore_keys) ) {
				$response = update_option($key, $value);
				echo "Saving $key .";
			}
		}
		if(!array_key_exists('wcapfield_enable_sync', $_POST)) {
			update_option('wcapfield_enable_sync', false);
		}

		break;
}

wp_die();