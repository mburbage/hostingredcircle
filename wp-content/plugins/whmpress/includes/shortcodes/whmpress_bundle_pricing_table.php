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

$bundle_data = $WHMPress->get_bundle_data( $id );


if ( $bundle_data == "" ) {
	return sprintf( esc_html__( 'No Bundle Found for ID: %1$s', 'whmpress' ), $id );
}

if ( isset( $bundle_data["itemdata"] ) ) {
	$bundle_data["itemdata"] = unserialize( $bundle_data["itemdata"] );
	$counter                 = 0;
	foreach ( $bundle_data["itemdata"] as $itemdata ) {
		$bundle_data['itemdata'][ $counter ]['item_name'] = whmpress_name_function( [ "id"         => $itemdata['pid'],
		                                                                              "no_wrapper" => "1"
		] );
		$counter ++;
	}
}
else {
	esc_html_e( "Bundle data not found", "whmpress" );
}
$vars = $bundle_data;


$vars['button_text'] = $button_text;
if ( is_file( $template_file ) && $bundle_data != "" ) {
	$TemplateArray = $WHMPress->get_template_array( $shortcode );
	foreach ( $TemplateArray as $custom_field ) {
		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
	}
	$OutputString = whmp_smarty_template( $template_file, $vars );

	return $OutputString;
}
else {
	//show_array( $vars );
	return esc_html__( 'No Template file selected or selected file is not available', 'whmpress' );
}