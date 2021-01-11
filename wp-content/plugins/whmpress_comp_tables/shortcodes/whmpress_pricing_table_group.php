<?php
/**
 * Pricing Group Shortcode
 */
		

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
?>

<?php
extract( shortcode_atts( [
	'html_template' => '',
	'image'         => '',
	'id'            => '0',
    'currency'      => '',
], $atts ) );

//~~ Get services in group along with groupid, product-id, orderby, name and description
$group = $this->whmp_get_group_full( $id );

if ($currency!=""){
    $group["currency"]=$currency;
}

if ( ! is_array( $group ) && is_string( $group ) ) {
	return $group;
}

//~~ If there is no plans in this group, break and return.
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
$group["mobile_breakpoint"] = $group['hide_width_table'];

//~~ Count width of column as per no of plans.
if ( count( $group["plans"] ) == "1" ) {
	$cols         = "12";
	$column_class = "one_cols";
}
elseif ( count( $group["plans"] ) == "2" ) {
	$cols         = "9";
	$column_class = "two_cols";
}
elseif ( count( $group["plans"] ) == "3" ) {
	$cols         = "4";
	$column_class = "three_cols";
}
elseif ( count( $group["plans"] ) == "4" ) {
	$cols         = "3";
	$column_class = "four_cols";
}
elseif ( count( $group["plans"] ) == "5" ) {
	$cols         = "2";
	$column_class = "five_cols";
}
elseif ( count( $group["plans"] ) == "6" ) {
	$cols         = "2";
	$column_class = "six_cols";
}
else {
	$cols         = "3";
	$column_class = "three_cols";
}
$color = $group["color"];
$sep   = $group["description_separator"];
if ( empty( $sep ) ) {
	$sep = ":";
}

//~~ create a new WHMPress instance s
$WHMPress = new WHMPress;

// If not HTML file provided in short-code, then look for setting in group.
if ($html_template == "") {
	$html_template = $group['pricing_table_template_file'];
}

// Get html template file

$html_template = $this->get_template_file($html_template, 'whmpress_pricing_table_group');


/**~~----------------------------------------------------------------
 * If there is a template file make an array to be passed to smarty
 * --------------------------------------------------------------------*/
$WHMPress = new WHMPress();
$html_template = wpct_select_tpl_first($html_template);
if ( is_file( $html_template ) ) {
	
	//~~ Extract veriable that are not package dependent for later use in code.
	$description = $group["description"];
	$name        = $group["name"];
	$sep         = $group["description_separator"];
	if ( empty( $sep ) ) {
		$sep = ":";
	}
	$rows            = $group["rows_table"];
	$currency_info=whmp_get_currency_info_i($currency);
	$group["prefix"] = $currency_info["prefix"];
	$group["suffix"] = $currency_info["suffix"];
	$group["currency"]=$currency_info["id"];

	$group_saved=$group;

	foreach ( $group["plans"] as &$plan ) {

		
		$currency='';
		if (isset ($group["currency"])) $currency=$group["currency"];

		$get_price_raw = whmp_price_i(
			[
				"id" => $plan["product_id"],
				"billingcycle" => $group["billingcycle"],
				"configurable_options" => 'yes',
				"currency_id" =>$currency,
			]
		);

		$billing_cycle = $get_price_raw['price'] == '-1' ? 'annually' : $group["billingcycle"];

		//~~----Price
		$price_tmp = BreakPrice( $group_saved, $plan["product_id"], $billing_cycle );

		$plan["price"]         = $price_tmp["price"];
		$plan["amount"]        = $price_tmp["amount"];
		$plan["fraction"]      = $price_tmp["fraction"];
		$plan["decimal"]       = $price_tmp["decimal"];
		$plan["prefix"]        = $group["prefix"];
		$plan["suffix"]        = $group["suffix"];
		$plan["duration"]      = $price_tmp["duration"];
		$plan["billingcycle"]  = $group["billingcycle"];
		
		//Get plan promotion and add to smarty array

		$promotions = whcom_get_promotion();

		foreach ( $promotions as $promo ) {

			//$plan["promotions"] = $plan["product_id"] . ' - ' . $promo["appliesto"];

			if ( in_array( $plan['product_id'], explode( ',', $promo['appliesto'] ), true ) ) {
				$months = array(
					'monthly' => 1,
					'quarterly' => 3,
					'semi-annually' => 6,
					'annually' => 12,
					'biennially' => 24,
					'triennially' => 36,
				);
				$plan['promotions'] = $promo;
				$plan['promotions-months'] = $months;
			}
		}

		$product_details = whcom_get_product_details( $plan['product_id'] );

		$plan['productfeatured'] = $product_details['is_featured'];

		$plan["all_durations"] = AllPrices($group, $plan["product_id"], $currency, [$group["billingcycle"], $group["billingcycle2"]] );
		//$group['billingcycle'] = ltrim($plan["duration"]) == 'OneTime' ? "" : $group['billingcycle'];

		//~~----Description
		//~~Simple Description
		$plan_description = $plan["description"];
		//~~Description in array
		$plan["description"] = Description2Array( $plan_description, $rows, $sep, 3, 1 );
		//~~Description in Associative Array
		$plan["description_array"] = Description2Array( $plan_description, $rows, $sep, 4, 1 );
		
		if ( $plan["product_id"] == $group["important"] ) {
			$plan["featured"] = "yes";
		}
		else {
			$plan["featured"] = "no";
		}
		
		//~~ Check if WHMpress is active TODO:do we really need to check it here?

		if ( is_plugin_active( 'WHMpress_Client_Area/client-area.php' ) ) {
			global $WHMPress_Client_Area;
			if ( empty( $WHMPress_Client_Area ) ) {
				$WHMPress_Client_Area = new WHMPress_Client_Area;
			}
			
			//~~ Get Order URL based on perma links
			if ( $WHMPress_Client_Area->is_permalink() ) {
				$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "/pid/{$plan["product_id"]}/a/add/currency/{$group["currency"]}&billingcycle={$group["billingcycle"]}/";
			}
			else {
				$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
			}
		}
		else {//~~ Direct Order URL
			$plan["order_url"] = $WHMPress->get_whmcs_url( "order" ) . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
		}
		
	} //~~End Loop
	
	
	$vars           = [
		"group" => $group,
	];
	$vars["random"] = rand();
	
	
	/** // Getting custom fields and adding in output
	 * //~~ TODO:Are these custom fields defined in VC? Are these needed here?
	 * $TemplateArray = $WHMPress->get_template_array("whmpress_pricing_table_group");
	 * foreach($TemplateArray as $custom_field) {
	 * $vars[$custom_field] = isset($atts[$custom_field])?$atts[$custom_field]:"";
	 * }
	 */
	//~~ Final string to match the smarty
	$OutputString = whmp_smarty_template( $html_template, $vars );
	//echo $OutputString;
	return $OutputString;
}
/**~~----------------------------------------------------------------
 * If there is no smarty template selected, then show below text
 * --------------------------------------------------------------------*/

else {
	return "<div class='wpct_error'>No template selected or template does not exist. <br/>Please choose a template from <b>List All > Configure Option > Select Template File</b> under \"Pricing Table Options\" section.</div>";
}

