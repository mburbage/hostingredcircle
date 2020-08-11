<?php
/**
 * Displays customized price list only for domain
 *
 * List of parameters
 * html_id = HTML id for wrapper div of table.
 * html_class = HTML class for wrapper div of table.
 * currency = Set currency for prices, Leave this parameter for default currency.
 * show_tlds = provide comma seperated tlds e.g. .com,.net,.org or leave it blank for all tlds
 * show_tlds_wildcard = provide tld search as wildcard, e.g. pk for all .pk domains or co for all com and .co domains
 * decimals = Decimals for price, default 2
 * cols = Number of columns for result in, default 1
 * show_renewel = Show domain renewal price, Yes or No
 * show_transfer = Show domain transfer price, Yes or No
 * titles = Comma separated titles for column titles
 */



$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$atts = shortcode_atts( [
	'html_template'      => 'default.tpl',
	'html_id'            => '',
	'html_class'         => 'whmpress_domain_price_list whmpress simple-01',
	'currency'           => whmp_get_current_currency_id_i(),
	'show_tlds'          => '',
	'show_tlds_wildcard' => '',
	'show_renewal'       => whmpress_get_option( 'pmd_show_renewel' ),
	'show_transfer'      => whmpress_get_option( 'pmd_show_transfer' ),
	'show_promotions'    => 'yes',
	'action_url'         => '',
	'return_type'        => ''
], $atts );
extract( $atts );


global $WHMPress;
$lang     = $WHMPress->get_current_language();
$extend   = empty( $lang ) ? "" : "_" . $lang;
$zero_override_string           = esc_attr( get_option( 'zero_override' . $extend, "Free" ) );
$not_configured_override_string = esc_attr( get_option( 'not_configured_override' . $extend, "N/A" ) );


# Getting WordPress DB object

/*
msetupfee = 1 Year
qsetupfee = 2 Years
ssetupfee = 3 Years
asetupfee = 4 Years
bsetupfee = 5 Years
monthly = 6 Years
quarterly = 7 Years
semiannually = 8 Years
annually = 9 Years
biennially = 10 Years
*/
$args['show_tlds'] = $show_tlds;
$args['show_tlds_wildcard'] = $show_tlds_wildcard;
$args['currency'] = $currency;

$tlds_data = whmpress_tlds_i($args);

$rows = $tlds_data['rows'];
$tlds_array = $tlds_data['tlds_array'];

$new_output = [];
$counter    = 0;
foreach ( $tlds_array as $tld ) {
	$new_output[ $counter ]['tld'] = $tld;
	
	$new_output[ $counter ]['register_price'] = '';
	$new_output[ $counter ]['transfer_price'] = '';
	$new_output[ $counter ]['renewal_price']  = '';
	
	
	foreach ( $rows as $row ) {
		if ( $row['extension'] == $tld ) {
			$new_output[$counter]['id'] = $row['id'];
			$new_output[$counter]['details'] = $row['details'];
			if ( $row['type'] == 'domainregister' ) {
				$temp_num_years = '';
				if ( $row['msetupfee'] < 0 && $row['qsetupfee'] > 0 ) {
					$raw_price = $row['qsetupfee'];
					$duration  = 'biennially';
				}
				elseif ( $row['msetupfee'] > 0 ) {
					$raw_price = $row['msetupfee'];
					$duration  = 'annually';
					$temp_num_years = '1 ';
				}
				elseif ( $row['msetupfee'] == 0 && $row['qsetupfee'] == 0 ) {
					$raw_price = $zero_override_string;
					$duration  = '';
					$years = '';
				}
				else {
					$raw_price = $not_configured_override_string;
					$duration  = '';
					$years = '';
				}
				if ( $duration != '' ) {
					$raw_price2  = whmp_format_price_i( [
						'price' => $raw_price,
					]);
					$final_price = whmp_format_domain_price_essentials_i( [
						'price' => $raw_price2['price'],
						'billingcycle' => $duration,
						'duration_style' => 'long',
						'duration_connector' => '/ ',
					]);
					$years = $temp_num_years . whmp_convert_billingcycle_i($duration, 'long');
				}
				else {
					$final_price = [];
					$final_price['price'] = $raw_price;
					$final_price['duration'] = $years;
				}
				
				$new_output[ $counter ]['register_price'] = $final_price['price'];
				$new_output[ $counter ]['years'] = $years;
			}
			if ( $row['type'] == 'domainrenew' && strtolower($show_renewal) == 'yes' ) {
				if ( $row['msetupfee'] < 0 && $row['qsetupfee'] > 0 ) {
					$raw_price = $row['qsetupfee'];
					$duration  = 'biennially';
				}
				elseif ( $row['msetupfee'] > 0 ) {
					$raw_price = $row['msetupfee'];
					$duration  = 'annually';
				}
				elseif ( $row['msetupfee'] == 0 && $row['qsetupfee'] == 0 ) {
					$raw_price = $zero_override_string;
					$duration  = '';
				}
				else {
					$raw_price = $not_configured_override_string;
					$duration  = '';
				}
				if ( $duration != '' ) {
					$raw_price2  = whmp_format_price_i( [
						'price' => $raw_price,
					]);
					$final_price = whmp_format_domain_price_essentials_i( [
						'price' => $raw_price2['price'],
						'billingcycle' => $duration,
						'duration_style' => 'long',
						'duration_connector' => '/ ',
					])['price'];
				}
				else {
					$final_price = $raw_price;
				}
				$new_output[ $counter ]['renewal_price'] = $final_price;
			}
			if ( $row['type'] == 'domaintransfer' && strtolower($show_transfer) == 'yes' ) {
				if ( $row['msetupfee'] < 0 && $row['qsetupfee'] > 0 ) {
					$raw_price = $row['qsetupfee'];
					$duration  = 'biennially';
				}
				elseif ( $row['msetupfee'] > 0 ) {
					$raw_price = $row['msetupfee'];
					$duration  = 'annually';
				}
				elseif ( $row['msetupfee'] == 0 && $row['qsetupfee'] == 0 ) {
					$raw_price = $zero_override_string;
					$duration  = '';
				}
				else {
					$raw_price = $not_configured_override_string;
					$duration  = '';
				}
				if ( $duration != '' ) {
					$raw_price2  = whmp_format_price_i( [
						'price' => $raw_price,
					]);
					$final_price = whmp_format_domain_price_essentials_i( [
						'price' => $raw_price2['price'],
						'billingcycle' => $duration,
						'duration_style' => 'long',
						'duration_connector' => '/ ',
					])['price'];
				}
				else {
					$final_price = $raw_price;
				}
				$new_output[ $counter ]['transfer_price'] = $final_price;
			}
		}
	}
	
	$counter++;
}



$smarty_array = [];
$data = [];
foreach ( $new_output as $domain ) {
	$data = [];
	$data['tld'] = $domain['tld'];
	$data['register'] = $domain['register_price'];
	$data['years'] = $domain['years'];
	$data['transfer'] = $domain['transfer_price'];
	$data['renewal'] = $domain['renewal_price'];
	$data['details'] = $domain['details'];
	$smarty_array[] = $data;
}
global $WHMPress;

$html_template = $WHMPress->check_template_file( $html_template, "whmpress_price_domain_list" );


if ($return_type == 'array') {
	return $smarty_array;
}
elseif ( is_file( $html_template ) ) {
	$OutputString = $WHMPress->read_local_file( $html_template );
	
	$vars = [
		"params" => $atts,
		"data"   => $smarty_array,
	];
	
	# Getting custom fields and adding in output
	$TemplateArray = $WHMPress->get_template_array( "whmpress_price_matrix_domain" );
	foreach ( $TemplateArray as $custom_field ) {
		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
	}
	
	$OutputString = whmp_smarty_template( $html_template, $vars );
	
	return $OutputString;
}
else {
	# Returning output string including output wrapper div.
}