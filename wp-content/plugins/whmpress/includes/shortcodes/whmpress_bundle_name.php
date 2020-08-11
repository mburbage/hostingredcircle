<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
	'id'            => '',
], $atts ) );

$shortcode = str_replace( ".php", "", basename( __FILE__ ) );

global $WHMPress;

$bundle_data = $WHMPress->get_bundle_data( $id )['name'];

	//show_array( $vars );
	if ($bundle_data != "") {
		$return_html = $bundle_data;
	}
	else {
		$return_html = sprintf(esc_html__('No Bundle Found for ID: %1$s', 'whmpress'), $id);
	}
	return $return_html;