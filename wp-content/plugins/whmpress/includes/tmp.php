<?php
// domains in whmcs only
if ( isset( $_REQUEST["skip_extra"] ) && $_REQUEST["skip_extra"] == "1" ) {
$extensions=whmp_get_domains_searchable("whmcs");

}
// all domains in whois db
elseif ( is_string( $searchonly ) && $searchonly == "*" ) {
$extensions=whmp_get_domains_searchable("all");

}
// search given extensions only
else {
$extensions = $searchonly;
if ( ! is_array( $searchonly ) && is_string( $searchonly ) ) {
$extensions = str_replace( " ", "", $extensions );
$extensions = explode( ",", $extensions );
}
}
//----skip-extra-end---


$smarty_domains = [];
$HTML .= "<div class='result-div'>";

	foreach ( $extensions as $x => $ext ) {
	$ext = ltrim( $ext, "." );
	if ( $ext == $domain["extension"] ) { //if it was the first domain, skip it
	continue;
	}
	//--------------------------
	$smarty_domain              = [];
	$smarty_domain["extension"] = $ext;

	$newDomain = $domain_short . "." . $ext;
	$smarty_domain["domain"] = $newDomain;

	$result = $whois->whoislookup( $newDomain, $ext );


	if ( $result )
	{
	//-1-Available
	$smarty_domain["available"] = "1";

	//-2-Message
	whmp_get_domain_message("og_a",$newDomain,$domain_short,$ext);
	$smarty_domain["message"] = $Message;

	//-3-Duration
	$durations=get_min_years($ext);
	$year=$durations["years"];
	$smarty_domain["duration"] = $year;

	//-4-Price
	$year_num=$durations["y"];
	if ($year_num>0){
	$pricef = whmpress_domain_price_function(
	[
	"years"         => $year_num,
	"tld"           => $ext,
	"html_class"    => "",
	"html_id"       => "",
	"show_duration" => "no",
	"type"          => "domainregister",
	"no_wrapper"    => "1",
	]
	);
	}
	else {          //todo: this list is already sorted, so this part is not requried
	$pricef = "";
	$year   = "";
	}
	$smarty_domain["price"]    = $pricef;

	//-5-Order URL
	$arr=array(
	"domain_full"=>$newDomain,
	"domain_short"=>$domain_short,
	"ext"=>$ext,
	"type"=>"register",
	"order_landing_page"=>$order_landing_page,
	"order_link_new_tab"=>$order_link_new_tab
	);
	$orders=whmp_get_domain_order_urls($arr);
	$smarty_domain=array_merge($smarty_domain,$orders);

	//-9-Other
	$smarty_domain["order_button_text"] = $register_text;
	$smarty_domain["whois_link"] = "";
	$_insert_data["domain_available"] = "1";

	$HTML .= "
	<div class='found-div'>
		<div class=\"domain-name\">$Message</div>";

		if ( $show_price == "1" || strtoupper( $show_price ) == "YES" ) {
		$HTML .= "<div class=\"rate\">$pricef</div>";
		}

		if ( ( $show_years == "1" || strtoupper( $show_years ) == "YES" ) && $pricef <> "" ) {
		$HTML .= "<div class=\"year\">$year</div>";
		}

		$HTML .= "<div class=\"select-box\">
			$button
		</div>
		<div style=\"clear:both\"></div>
	</div>\n";
	}
	else
	{
	//-1-Available
	$smarty_domain["available"]          = "0";

	//-2-Message
	$Message=whmp_get_domain_message("og_na",$newDomain,$domain_short,$ext);
	$smarty_domain["message"] = $Message;

	//-3-Duration
	$durations=get_min_years($ext);
	$year=$durations["years"];
	$smarty_domain["duration"] = $year;

	//-4-Price
	$year_num=$durations["y"];
	if ($year_num>0){
	$pricef = whmpress_domain_price_function(
	[
	"years"         => $year_num,
	"tld"           => $ext,
	"html_class"    => "",
	"html_id"       => "",
	"show_duration" => "no",
	"type"          => "domaintransfer",
	"no_wrapper"    => "1",
	]
	);
	}
	else {          //todo: this list is already sorted, so this part is not requried
	$pricef = "";
	$year   = "";
	}
	$smarty_domain["price"]    = $pricef;

	//-5-Order
	if ( $enable_transfer_link == "1" || strtolower( $enable_transfer_link ) == "yes" || $enable_transfer_link === true ) {
	$arr=array(
	"domain_full"=>$domain_full,
	"domain_short"=>$domain_short,
	"ext"=>$ext,
	"type"=>"transfer",
	"order_landing_page"=>$order_landing_page,
	"order_link_new_tab"=>$order_link_new_tab,
	);
	$orders=whmp_get_domain_order_urls($arr);
	$smarty_domain=array_merge($smarty_domain,$orders);

	$transfer_link = "<a class='www-button' href='".$orders["order_url"]."'>" . __( "Transfer", "whmpress"
		) . "</a>";
	}
	else
	{
	$transfer_link = "";
	}

	//-6-WWW
	$www_link=whmp_get_domain_www_link($_POST["www_link"],$newDomain);
	$smarty_domain["www_link"]=$www_link;

	//-7-WhoIs
	$whois_link=whmp_get_domain_whois($_POST["whois_link"],$newDomain);
	$smarty_domain["whois_link"]=$whois_link;

	//-9-other
	$smarty_domain["order_landing_page"] = "-1"; //why not $order_landing_page;
	$smarty_domain["order_button_text"]  = "";

	$HTML .= "<div class='not-found-div'>";
		$HTML .= '<div class="domain-name">' . $Message . '</div>';

		if ( $show_price == "1" || strtoupper( $show_price ) == "YES" ) {
		$HTML .= "<div class=\"rate\"></div>";
		}

		if ( $show_years == "1" || strtoupper( $show_years ) == "YES" ) {
		$HTML .= "<div class=\"year\"></div>";
		}

		$HTML .= "<div class=\"select-box\">
			$www_link
			$whois_link
			$transfer_link
		</div>";
		$HTML .= "<div style=\"clear:both\"></div>
	</div>\n";
	}
	$smarty_domains[] = $smarty_domain;
	}
?>

<form name="whmpress_domain_form_com.au"  action="https://whmcs2.whmpress.com/cart.php?a=add&amp;domain=register&amp;sld=creativeon&amp;tld=.com.au">
    <input id="whmpress_domain_form_com_au" type="submit">
    <input name="domainsregperiod[creativeon]" value="1" type="hidden">
    <input name="domains[]" value="creativeon" type="hidden">
</form>

<form name="whmpress_domain_form_org"  action="https://whmcs2.whmpress.com/cart.php?a=add&amp;domain=register&amp;sld=creativeon&amp;tld=.org">
    <input id="whmpress_domain_form_org" type="submit">
    <input name="domainsregperiod[creativeon.org]" value="1" type="hidden">
    <input name="domains[]" value="creativeon.org" type="hidden">
</form>