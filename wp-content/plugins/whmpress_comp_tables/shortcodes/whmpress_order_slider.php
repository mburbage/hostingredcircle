<?php

//== Enqueue the style file which is using in pricing table shortcode
$custom_css_file = WPCT_GRP_URL . "/css/default.css";

if (is_file($custom_css_file)) {
    wp_enqueue_style('whmpress_css_file', $custom_css_file);
}

wp_enqueue_style('whmpress-temp-style', WPCT_GRP_URL . '/css/whmpress.css');

// If WHMPress settings -> Styles -> include FontAwesome selected Yes
if (get_option('include_fontawesome') == "1") {
    wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
}
extract( shortcode_atts( [
	'html_template' => '',
	'image'         => '',
	'id'            => '0',
    'currency'      => '',
], $atts ) );

$group = $this->whmp_get_group_full( $id );

if ($currency!=""){
    $group["currency"]=$currency;
}

if (count($group) == "0" || !isset($group["plans"]) || count($group["plans"]) == "0") {
	$error_heading = esc_html__('No plans selected to show', 'wpct');
	$error_instruction1 = esc_html__('Please choose plans from ', 'wpct');
	$error_instruction2 = esc_html__('"List All > Select Plans" ', 'wpct');
	$error_instruction3 = esc_html__('then select products to include.', 'wpct');
	$final_string = '<div class="wpct_error"><div><strong>';
	$final_string .= $error_heading;
	$final_string .= '</strong></div>';
	$final_string .= $error_instruction1;
	$final_string .= '<strong>' . $error_instruction2 . '</strong>';
	$final_string .= $error_instruction3;
	$final_string .= '</div>';
	return $final_string;
}
$group["mobile_breakpoint"] = $group['hide_width_slider'];

$WHMPress = new WHMPress;

// If not HTML file provided in short-code, then look for setting in group.
if ($html_template == "") {
	$html_template = $group['slider_template_file'];
}
//ppa($html_template,"1");
// Get html template file
$html_template = $this->get_template_file( $html_template, 'whmpress_order_slider' );

/**~~----------------------------------------------------------------
 * If there is a template file make an array to be passed to smarty
 * --------------------------------------------------------------------*/
$html_template = wpct_select_tpl_first($html_template);
if ( is_file( $html_template ) ) {


	//~~ Extract veriable that are not package dependent for later use in code.
	$description = $group["description"];
	$name        = $group["name"];
	$sep         = $group["description_separator"];
	if ( empty( $sep ) ) {
		$sep = ":";
	}
	$rows            = $group["rows_slider"];
	$currency_info=whmp_get_currency_info_i($currency);
	$group["prefix"] = $currency_info["prefix"];
	$group["suffix"] = $currency_info["suffix"];
	$group["currency"]=$currency_info["id"];
	foreach ( $group["plans"] as &$plan ) {
		$price_tmp = BreakPrice( $group, $plan["product_id"], $group["billingcycle"] );

		$plan["price"]         = $price_tmp["price"];
		$plan["amount"]        = $price_tmp["amount"];
		$plan["fraction"]      = $price_tmp["fraction"];

		$plan["prefix"]        = $group["prefix"];
		$plan["suffix"]        = $group["suffix"];
		$plan["decimal"]       = $price_tmp["decimal"];
		$plan["duration"]      = $price_tmp["duration"];
		$plan["billingcycle"]  = $group["billingcycle"];
		$plan["all_durations"] = AllPrices( $group, $plan["product_id"], $group["currency"], [
			$group["billingcycle"],
			$group["billingcycle2"],
		] );

		//~~----Description
		//~~Simple Description
		$plan_description = $plan["description"];
		//~~Description in array
		$plan["description"] = Description2Array( $plan_description, $rows, $sep, 3, 1 );
		//~~Description in Associative Array
		$plan["description_array"] = Description2Array( $plan_description, $rows, $sep, 4, 1 );
		
		// Plan Prices duration wise
		$plan['multi_price'] = wpct_prepare_plan_price($plan);
		
		$plan['multi_button'] = wpct_prepare_plan_button($group, $plan);
		
		$plan['multi_duration'] = wpct_prepare_plan_durations($plan);
		
		$plan['multi_discount'] = ( $group['show_discount'] != "no" ) ? wpct_prepare_plan_discounts( $plan, "", $group['show_discount_secondary'] ) : "";

		//~~ check copy to others ~~
		if ( $plan["product_id"] == $group["important"] ) {
			$plan["featured"] = "yes";
		} else {
			$plan["featured"] = "no";
		}


		if ( is_plugin_active( 'WHMpress_Client_Area/client-area.php' ) ) {
			global $WHMPress_Client_Area;
			if ( empty( $WHMPress_Client_Area ) ) {
				$WHMPress_Client_Area = new WHMPress_Client_Area;
			}
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "/pid/{$plan["product_id"]}/a/add/currency/{$group["currency"]}&billingcycle={$group["billingcycle"]}/";
			} else {
				$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
			}
		} else {
			$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
		}
	}
	
	
	// Billing Cycle toggle HTML
	$r = rand();
	$group['duration_toggle'] = wpct_prepare_duration_toggle($group, $r);

	$vars = [
		"group" => $group,
	];

	$vars["random"] = $r;

	$OutputString = whmp_smarty_template( $html_template, $vars );

	//ppa($OutputString);
	return $OutputString;

	
}

/**~~----------------------------------------------------------------
 * If there is no smarty template selected, then show below text
 * --------------------------------------------------------------------*/
else {
	wpct_pretty_print($html_template);
	return "<div class='wpct_error'>No template selected or template does not exist. <br/>Please choose a template from <b>List All > Configure Option > Select Template File</b> under \"Slider Options\" section.</div>";
}