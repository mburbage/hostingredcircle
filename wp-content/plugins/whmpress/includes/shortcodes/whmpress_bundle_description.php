<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}
extract( shortcode_atts( [
	'id'       => '',
	'itemdata' => '0',
], $atts ) );


global $WHMPress;

$bundle_data = $WHMPress->get_bundle_data( $id );
if ( ! $bundle_data ) {
	return __( "No bundle found in database", "whmpress" );
}

if ( $itemdata == "1" || strtolower( $itemdata ) == "yes" || $itemdata === true ) {
	return $bundle_data['description'] . "<br>" . $bundle_data['itemdata'];
} else {
	return $bundle_data['description'];
}