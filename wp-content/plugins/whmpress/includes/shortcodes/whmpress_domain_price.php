<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$atts= shortcode_atts( [
	'html_template' => '',
	'type'          => whmpress_get_option( "dp_type" ),
	'years'         => whmpress_get_option( "dp_years" ),
	'tld'           => '.com',
	'currency'      => whmpress_get_option( "price_currency" ),
	"decimals"      => whmpress_get_option( "dp_decimals" ),
	"hide_decimal"  => whmpress_get_option( "dp_hide_decimal" ),

    "decimals_tag"  => whmpress_get_option( "dp_decimals_tag" ),
    "prefix"        => whmpress_get_option( "dp_prefix" ),
	"suffix"        => whmpress_get_option( "dp_suffix" ),
	"show_duration" => whmpress_get_option( "dp_show_duration" ),

    "duration_style"=> 'long',
	"price_tax"     => whmpress_get_option( "dp_price_tax" ),
	"html_class"    => "whmpress whmpress_domain_price",
	"simple"        => "",
	"html_id"       => "",
	"no_wrapper"    => "",
], $atts );

$currency = $atts['currency'];
/*$currency_ = (empty($currency)) ? whmp_get_current_currency_id_i() : $currency;*/
if(empty($currency)) {
    $currency_ = whmp_get_current_currency_id_i();
}
else{
    $currency_  = $currency;
}



$currency_array = whmp_get_currency_info_i($currency_);





extract($atts);
//== Add by zain
if(empty($currency)){
    $currency = whmp_get_current_currency_id_i();
}

//== End
$show_duration_ = ((strtolower(trim($show_duration))) == "no") ? FALSE : TRUE;
$duration_tag = ($show_duration_) ? $show_duration : "";
$duration_tag = (strtolower($duration_tag) == "yes") ? "-" : $duration_tag;


$duration_style_ = $duration_style;

//$duration_connector_ = "";

$show_prefix_ = ((strtolower(trim($prefix))) == "no") ? FALSE : TRUE;
$prefix_tag = ($show_prefix_) ? $prefix : "";
$prefix_tag = (strtolower($prefix_tag) == "yes") ? "-" : $prefix_tag;

$show_suffix_ = ((strtolower(trim($suffix))) == "no") ? FALSE : TRUE;
$suffix_tag = ($show_suffix_) ? $suffix : "";
$suffix_tag = ($suffix_tag == "yes") ? "-" : $suffix_tag;

$decimals_tag = (trim($decimals_tag) == "") ? "-" : $decimals_tag;
$show_decimals_ = ((strtolower(trim($decimals_tag))) == "no") ? FALSE : TRUE;
$decimals_tag = ($show_decimals_) ? $decimals_tag : "";

$decimals_points_ = $decimals;

$hide_decimal_ = whmp_tfc($hide_decimal);

$simple_ = whmp_tfc($simple);

$html_class_ =$html_class;

$html_id_ = $html_id;
$html_class_ = $html_class;
$no_wrapper_ = whmp_tfc($no_wrapper);



$tld      = "." . ltrim( $tld, "." );

$AvailableTypes = [
	"domainregister",
	"domainrenew",
	"domaintransfer",
];


if ( ! in_array( $type, $AvailableTypes ) ) {
	$OutputString = __( 'Invalid type', 'whmpress' );
	return $OutputString;
}

$YearColumn = [
	"1"  => "msetupfee",
	"2"  => "qsetupfee",
	"3"  => "ssetupfee",
	"4"  => "asetupfee",
	"5"  => "bsetupfee",
	"6"  => "monthly",
	"7"  => "quarterly",
	"8"  => "semiannually",
	"9"  => "annually",
	"10" => "biennially",
];
if ( ! array_key_exists( $years, $YearColumn ) ) {
	$OutputString = __( "Invalid year", "whmpress" );
	return $OutputString;
}

if ( empty( $currency ) ) {

    //==Edit by zain
	/*$currency = whmp_get_currency();*/

    $currency = whmp_get_current_currency_id_i();
}

$price = whmp_domain_price_i( [
    "extension"   => $tld,
    "price_type"  => $type,
    "years"        => $years,
    "currency"    => $currency,
    "process_tax" => "1",
] );

$price_parts_array = whmp_format_price_i(
    [
        'price'       => $price,
        'paytype'     => 'recurring',
        'currency_id' => $currency,
        'decimals'    => whmpress_get_option('default_decimal_places')
    ]
);


$formated_price_array = whmp_format_domain_price_essentials_i( [
    'price' => $price_parts_array['price'],
    'billingcycle' => "annually",
    'years' => $years,
    'currency_id' => $currency,
    'duration_style' => $duration_style,
    'duration_connector' => whmpress_get_option( "default_currency_duration_connector" ),
]);


if (!($no_wrapper_)) {
    $wraper_start = "<span class='$html_class_' id='{$html_id}'>";
    $wraper_end = "</span>";
} else {
    $wraper_start = "";
    $wraper_end = "";
}


//make a function, flag, tag, string
if ($show_prefix_) {
    $prefix_s = ($prefix_tag != "-") ? "<" . $prefix_tag . ">" : "";
    $prefix_s .= $currency_array["prefix"];
    $prefix_s .= ($prefix_tag != "-") ? "</" . $prefix_tag . ">" : "";
} else {
    $prefix_s = "";
}

if ($show_suffix_) {
    $suffix_s = ($suffix_tag != "-") ? "<" . $suffix_tag . ">" : "";
    $suffix_s .= $currency_array["suffix"];
    $suffix_s .= ($suffix_tag != "-") ? "</" . $suffix_tag . ">" : "";
} else {
    $suffix_s = "";
}


/*<span class="whmpress whmpress_price" id="">2.85<sup>GBP</sup> <yes>/Mo </yes></span>*/

$decimal_p = $price_parts_array["decimal_separator"];
$amount_p = $price_parts_array["amount"];
$fraction_p = $price_parts_array["fraction"];
//$fraction_p = ($hide_decimal_) ? $fraction_p : $decimal_p . $fraction_p;
if(empty($hide_decimal_)  && !empty($fraction_p))
{
    $fraction_p = $decimal_p . $fraction_p;
}


if ($show_decimals_) {
    $fraction_s = ($decimals_tag != "-") ? "<" . $decimals_tag . ">" : "";
    $fraction_s .= $fraction_p;
    $fraction_s .= ($decimals_tag != "-") ? "</" . $decimals_tag . ">" : "";
}


$price_s = $amount_p . $fraction_s;


if ($show_duration_) {
    $duration_s = ($duration_tag != "-") ? "<" . $duration_tag . ">" : "";
    $duration_s .= $formated_price_array["duration"];
    $duration_s .= ($duration_tag != "-") ? "</" . $duration_tag . ">" : "";
} else {
    $duration_s = "";
}

/*ppa($price_parts_array);

ppa($formated_price_array);*/

$OutputString = $wraper_start . $prefix_s . $price_s . $suffix_s . $duration_s . $wraper_end;

return $OutputString;

/*$Q = "SELECT `{$YearColumn[$years]}` FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid`
AND `extension`='$tld'
AND `type`='$type' AND `currency`='$currency'";
$price = $wpdb->get_var( $Q );*/

/*if ( is_null( $price ) || $price === false ) {
	$OutputString = __( "Invalid TLD", "whmpress" );

	return $OutputString;
} else {
	# Calculating tax.
	$TaxEnabled = $wpdb->get_var( "SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'" );
	$TaxDomains = $wpdb->get_var( "SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxDomains'" );

	#var_dump($TaxDomains);
	#var_dump($TaxEnabled);

	$tax_amount = $base_price = $price;
	if ( strtolower( $TaxEnabled ) == "on" && strtolower( $TaxDomains ) == "on" ) {
		$taxes      = whmpress_calculate_tax( $price );
		$base_price = $taxes["base_price"];
		$tax_amount = $taxes["tax_amount"];

		if ( $price_tax == "default" ) {
			$price_tax = "";
		}
		$price_tax = trim( strtolower( $price_tax ) );

		if ( $price_tax == "exclusive" ) {
			$price = $base_price;
		} elseif ( $price_tax == "inclusive" ) {
			$price = $base_price + $tax_amount;
		} elseif ( $price_tax == "tax" ) {
			$price = $tax_amount;
		}
	}
}*/
//
//
//$simple_price = $price;
//
//ppa($simple_price, "simple price");
//
//if ( strtolower( $hide_decimal ) <> "yes" ) {
//	if ( get_option( "show_trailing_zeros" ) == "yes" ) {
//		$CurrencyFormatFunction = "number_format";
//	} else {
//		$CurrencyFormatFunction = "round";
//	}
//
//	$price = $CurrencyFormatFunction( $price, $decimals );
//}
//
//// Removing decimal symbol
//if ( strtolower( $hide_decimal ) == "yes" ) {
//	$price = str_replace( ".", "", $price );
//}
//
//if ( $decimals_tag <> "" && strtolower( $hide_decimal ) <> "yes" ) {
//	$parts = explode( ".", $price );
//	if ( $decimals > 0 ) {
//		$parts[1] = "<{$decimals_tag}>." . ( @$parts[1] ) . "</{$decimals_tag}>";
//	} else {
//		$parts[1] = "";
//	}
//	$price = @$parts[0] . @$parts[1];
//	$price = rtrim( $price, "." );
//}
//
//if ( strtolower( $prefix ) <> "no" ) {
//	$prefix_symbol = whmp_get_currency_prefix( $currency );
//	if ( strtolower( $prefix ) <> "yes" ) {
//		$prefix_symbol = "<{$prefix}>" . $prefix_symbol . "</{$prefix}>";
//	}
//} else {
//	$prefix_symbol = "";
//}
//
//if ( strtolower( $suffix ) <> "no" ) {
//	$suffix_symbol = whmp_get_currency_suffix( $currency );
//	if ( strtolower( $suffix ) <> "yes" ) {
//		$suffix_symbol = "<{$suffix}>" . $suffix_symbol . "</{$suffix}>";
//	}
//} else {
//	$suffix_symbol = "";
//}
//
//if ( strtolower( $show_duration ) <> "no" ) {
//	if ( strtolower( $show_duration ) == "yes" ) {
//		$duration = "/" . $years . __( " Years", "whmpress" );
//	} else {
//		$duration = "<$show_duration>/";
//		if ( $years == "1" ) {
//			$duration .= __( "Year", "whmpress" );
//		} else {
//			$duration .= "$years " . __( "Years", "whmpress" );
//		}
//		$duration .= "</$show_duration>";
//	}
//} else {
//	$duration = "";
//}

//$html_template = $WHMPress->check_template_file( $html_template, "whmpress_domain_price" );
//if ( is_file( $html_template ) ) {
//	$decimal_sperator  = $WHMPress->get_currency_decimal_separator( $currency );
//	$totay            = explode( $decimal_sperator, strip_tags( $simple_price ) );
//	$amount1          = $totay[0];
//	$fraction         = isset( $totay[1] ) ? $totay[1] : "";
//	$totay            = explode( "/", strip_tags( $price ) );
//	$duration         = @$totay[1];
//
//	if ( $years == "1" ) {
//		$duration .= __( 'Year', 'whmpress' );
//	} else {
//		$duration .= $years . __( 'Years', 'whmpress' );
//	}
//
//	$vars                 = $atts;
//	$vars["domain_price"] = $prefix_symbol . $price . $suffix_symbol . $duration;
//	$vars["prefix"]       = whmp_get_currency_prefix( $currency );
//	$vars["suffix"]       = whmp_get_currency_suffix( $currency );
//	$vars["amount"]       = $amount1;
//	$vars["fraction"]     = $fraction;
//	$vars["decimal"]      = $decimal_sperator;
//	$vars["duration"]     = $duration;
//
//	# Getting custom fields and adding in output
//	$TemplateArray = $WHMPress->get_template_array( "whmpress_domain_price" );
//	foreach ( $TemplateArray as $custom_field ) {
//		$vars[ $custom_field ] = isset( $atts[ $custom_field ] ) ? $atts[ $custom_field ] : "";
//	}
//
//	$OutputString = whmp_smarty_template( $html_template, $vars );
//} else {
//	if ( $no_wrapper == "1" ) {
//		$OutputString = $prefix_symbol . $price . $suffix_symbol . $duration;
//	} else {
//		$OutputString = "<span class='$html_class' id='$html_id'>";
//		$OutputString .= $prefix_symbol . $price . $suffix_symbol . $duration;
//		$OutputString .= "</span>";
//	}
//}
//return $OutputString;