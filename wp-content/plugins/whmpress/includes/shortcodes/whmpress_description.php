<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
	'html_template' => '',
	'image'         => '',
	'html_id'       => '',
	'html_class'    => 'whmpress whmpress_description',
	'id'            => '0',
	'show_as'       => whmpress_get_option( 'dsc_description' ),
	'no_wrapper'    => "No",
	'with_section'    => "No",
	'split_description'    => "No",
], $atts ) );

# Getting data from mysql tables
global $wpdb;
$WHMPress = new WHMPress;

$field = "whmpress_product_" . $id . "_desc_" . $WHMPress->get_current_language();
$field2 = "whmpress_product_" . $id . "_append_desc_" . $WHMPress->get_current_language();
$v     = get_option( $field );
if ( empty( $v ) ) {
	$Q            = "SELECT `description` FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
	$ndescription = $description = $wpdb->get_var( $Q ) . "\r\n" . get_option( $field2 );
} else {
	$ndescription = $description = get_option( $field ) . "\r\n" . get_option( $field2 );
}




$ndescription = trim( strip_tags( $ndescription, '<strong><s><del><strike>' ), "\n" );
$ndescription = explode( "\n", $ndescription );

$smarty_array = [];
foreach ( $ndescription as $line ) {
	if ( trim( $line ) <> "" ) {
		$data                  = [];
		$data["feature"]       = $line;
		$totay                 = explode( ":", $line );

		$tooltip_data = $WHMPress->return_tooltip(trim( $totay[0]));
		$data["feature_title"] = trim( $totay[0] );
		$data["feature_value"] = isset( $totay[1] ) ? trim( $totay[1] ) : "";
		$data["tooltip_text"] = stripcslashes($tooltip_data['tooltip_text']);
		$data["icon_class"] = $tooltip_data['icon_class'];
		$smarty_array[] = $data;
	}
}

// Skipping lines starting with -- from description.
	if ($with_section != 'Yes') {
		$description = explode( "\n", $description );
		foreach($description as $k=>&$des) {
			if (substr(trim($des),0,2)=="--") {
				unset($description[$k]);
			}
		}
		$description = implode("\n", $description);
	}

# Checking show_as parameter

if ( strtolower( $show_as ) == "ul" || strtolower( $show_as ) == "ol" ) {
	$description = trim( strip_tags( $description, '<strong><s><del><strike>' ), "\n" );
	$description = explode( "\n", $description );
	$description = "<" . $show_as . ">\n<li>" . implode( "</li><li>", $description ) . "</li>\n</" . $show_as . ">";
}

# Generating output string
$html_template = $WHMPress->check_template_file( $html_template, "whmpress_description" );

if ( is_file( $html_template ) ) {
	$vars = [
		"product_description" => $description,
		"data"                => $smarty_array,
	];

	# Getting custom fields and adding in output
	$TemplateArray = $WHMPress->get_template_array( "whmpress_description" );
	foreach ( $TemplateArray as $custom_field ) {
		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
	}

	$OutputString = whmp_smarty_template( $html_template, $vars );

	return $OutputString;
} else {
	$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
	$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

	$no_wrapper = trim( strtolower( $no_wrapper ) );
	if ( $no_wrapper == "yes" || $no_wrapper == "1" || $no_wrapper === true || $no_wrapper == "true" ) {
		$OutputString = $description;
	} else {
		$OutputString = "<div $CLASS $ID>" . $description . "</div>";
	}
	
	if (strtolower($split_description) == 'yes'){
		$OutputString = $smarty_array;
	}

	# Returning output string
	return whmpress_encoding( $OutputString );
}