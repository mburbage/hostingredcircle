<?php
/**
* Shows price box
*
* List of parameters
* html_class = HTML class for wrapper
* html_id = HTML id for wrapper
* id = relid match from whmcs mysql table
* billingcycle = Billing cycle e.g. annually, monthly etc.
* show_price = Display price or not.
* show_combo = Show combo or not, No, Yes
* show_button = Show submit button or not
* currency = Currency for price
*/

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract( shortcode_atts( [
'html_template'    => '',
'image'            => '',
'id'               => '0',
'billingcycle'     => whmpress_get_option( "pt_billingcycle" ),
'show_price'       => whmpress_get_option( "pt_show_price" ),
'process_description'       => whmpress_get_option( "pt_process_description" ),
'show_description_icon'       => whmpress_get_option( "pt_show_description_icon" ),
'show_description_tooltip'       => whmpress_get_option( "pt_show_description_tooltip" ),
'show_combo'       => whmpress_get_option( "pt_show_combo" ),
'show_button'      => whmpress_get_option( "pt_show_button" ),
'currency'         => '0',
"button_text"      => whmpress_get_option( "pt_button_text" ),
"show_description" => "yes",
'html_id'          => '',
'html_class'       => 'whmpress whmpress_price_box',
'show_discount'    => whmpress_get_option( 'combo_show_discount' ),
'discount_type'    => whmpress_get_option( 'combo_discount_type' ),
//"button_html_template" => "",
], $atts ) );
$currency    = whmp_get_currency( $currency );
$button_text = __( $button_text, "whmpress" );

# Getting data from MySQL
global $wpdb;
$Q   = "SELECT `name`,`description` FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
$row = $wpdb->get_row( $Q, ARRAY_A );
if ( isset( $row["name"] ) ) {
$row["name"] = whmpress_encoding( $row["name"] );
}

# Check if price is requested or not
if ( strtolower( $show_price ) == "yes" ) {
$price = whmpress_price_function( [ "id" => $id, "billingcycle" => $billingcycle, "currency" => $currency ] );
} else {
$price = "";
}
$simple_price = $price;


# Setting up description
$description = trim( strip_tags( $row["description"], '<strong><s><del><strike>' ), "\n" );
$description = explode( "\n", $description );
$description = "<ul>\n<li>" . implode( "</li><li>", $description ) . "</li>\n</ul>";
$description = whmpress_encoding( $description );

# Check if combo is requested or not
if ( strtolower( $show_combo ) == "yes" ) {
$combo = whmpress_order_combo_function( [
"id"            => $id,
"show_button"   => "No",
"currency"      => $currency,
"discount_type" => $discount_type,
"show_discount" => $show_discount,
] );
} else {
$combo = "";
}

# Check if button is requested or not
if ( strtolower( $show_button ) == "yes" ) {
$button = whmpress_order_button_function( [
"id"          => $id,
"button_text" => $button_text,
] );   // "html_template"=>$button_html_template
} else {
$button = "";
}

# Generating OutputString
$WHMPress = new WHMPress;

$html_template = $WHMPress->check_template_file( $html_template, "whmpress_price_box" );

if ( is_file( $html_template ) ) {
//$decimal_sperator = get_option( 'decimal_replacement', "." );
$decimal_sperator = $WHMPress->get_currency_decimal_separator( $currency );
$price1           = whmpress_price_function( [
"show_duration" => "no",
"id"            => $id,
"billingcycle"  => $billingcycle,
"currency"      => $currency,
"prefix"        => "",
"suffix"        => "",
] );
$totay            = explode( $decimal_sperator, strip_tags( $price1 ) );
$fraction         = isset( $totay[1] ) ? $totay[1] : "";
$amount1          = $totay[0];

$duration = explode( "/", strip_tags( $simple_price ) );
$duration = isset( $duration[1] ) ? $duration[1] : "";

$vars = [
"product_name"        => $row["name"],
"product_price"       => $price1,
"product_description" => $description,
"order_combo"         => $combo,
"order_button"        => $button,
"button_text"         => $button_text,
"order_button_text"   => $button_text,
"image"               => $image,
"prefix"              => whmp_get_currency_prefix( $currency ),
"suffix"              => whmp_get_currency_suffix( $currency ),
"amount"              => $amount1,
"fraction"            => $fraction,
"decimal"             => $decimal_sperator,
"duration"            => $duration,
];

# Getting custom fields and adding in output
$TemplateArray = $WHMPress->get_template_array( "whmpress_price_box" );
foreach ( $TemplateArray as $custom_field ) {
$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
}

$OutputString = whmp_smarty_template( $html_template, $vars );

return $OutputString;
} else {
$OutputString = "<h3>" . $row["name"] . "</h3>";

$OutputString .= "<div class='style1_wrapper'>";
	if ( strtolower( $show_description ) == "yes" ) {
	$OutputString .= "<div style='float:left' class='style1_left'>
		$description
	</div>";
	}
	$OutputString .= "
	<div style='float:right' class='style1_right'>
		<h2>$price</h2>
		$combo
		$button
	</div>
	<div style='clear:both'></div>
</div>";

# Returning output string with wrapper div
$ID    = ! empty( $html_id ) ? "id='$html_id'" : "";
$CLASS = ! empty( $html_class ) ? "class='$html_class'" : "";

return "<div $CLASS $ID>" . $OutputString . "</div>";
}
