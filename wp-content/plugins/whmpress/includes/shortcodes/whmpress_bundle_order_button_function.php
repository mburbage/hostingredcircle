<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
	'id'            => '',
	'itemdata'      => '0',
	'html_template' => '',
	"button_text"   => whmpress_get_option( "pt_button_text" ), //"Order",
], $atts ) );

$shortcode = str_replace( ".php", "", basename( __FILE__ ) );

global $WHMPress;
$template_file = $WHMPress->check_template_file( $html_template, $shortcode );

$bundle_data = $WHMPress->get_bundle_data( $id )['order_link'];

$vars['order_link'] = $bundle_data;
$vars['button_text'] = $button_text;
if ( is_file( $template_file && $vars['order_link'] != "" ) ) {
	$TemplateArray = $WHMPress->get_template_array( $shortcode );

	$OutputString = whmp_smarty_template( $template_file, $vars );

	return $OutputString;
} else {
	//show_array( $vars );
	if ($vars['order_link'] != "") {
		$return_html = "<a class='whmpress_order_button' href='{$vars['order_link']}'>{$vars['button_text']}</a>";
	}
	else {
		$return_html = sprintf(esc_html__('No Bundle Found for ID: %1$s', 'whmpress'), $id);
	}
	return $return_html;
}