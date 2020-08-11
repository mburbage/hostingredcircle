<?php
include_once( "../../../../wp-load.php" );

# If admin user is not logged in then redirect back.
if ( ! current_user_can( 'manage_options' ) ) {
	wp_redirect( get_admin_url() . "admin.php?page=whmp-settings" );
	exit;
}

/*
 * Only added field names in this array will apply in ini settings.
 */
$allowed_settings = [
	"load_sytle_orders"
];

if ( isset( $_POST["import_settings"] ) && isset( $_POST["file"] ) && is_file( $_POST["file"] ) ) {
	
	if ( $_POST["import_settings"] == "" ) {
		$settings = parse_ini_file( $_POST["file"] );
	} else {
		$settings = parse_ini_file( $_POST["file"], true );
		if ( isset( $settings[ $_POST["import_settings"] ] ) ) {
			$settings = $settings[ $_POST["import_settings"] ];
		} else {
			$settings = [];
		}
	}
	
	if ( ! is_array( $settings ) ) {
		wp_redirect( get_admin_url() . "admin.php?page=whmp-settings&settings-updated=false" );
		exit;
	}
	
	foreach ( $settings as $k => $v ) {
		if ( in_array( $k, $allowed_settings ) ) {
			update_option( $k, $v );
		}
	}
	
	# Redirect back with true message.
	
	wp_redirect( get_admin_url() . "admin.php?page=whmp-settings&settings-updated=true" );
	exit;
}

wp_redirect( get_admin_url() . "admin.php?page=whmp-settings&settings-updated=false" );
exit;