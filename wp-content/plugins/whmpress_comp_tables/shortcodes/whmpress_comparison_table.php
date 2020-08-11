<?php
/**
 * ~~ Comparision Table shortcode
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

global $WHMP_GRP;
extract(shortcode_atts([
	'html_template' => '',
	'image'         => '',
	'id'            => '0',
    'currency'      => '',
], $atts));


$group = $WHMP_GRP->whmp_get_group_full($id);


if ($currency!=""){
    $group["currency"]=$currency;
}

if (!is_array($group) && is_string($group)) {
	return $group;
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


//~~ Extract variables that are not package dependent for later use in code.
$description = $group["description"];
$name = $group["name"];
$sep = $group["description_separator"];
if (empty($sep)) {
	$sep = ":";
}
$rows = $group["rows_comparison"];
$group["have_sections"] = 0;
$group["mobile_breakpoint"] = $group['hide_width_comparison'];
$group["prefix"] = whmp_get_currency_prefix();



// If not HTML file provided in short-code, then look for setting in group.
if ($html_template == "") {
	$html_template = $group['template_file'];
}

// Get html template file
$html_template = $this->get_template_file($html_template, 'whmpress_comparison_table');
$html_table_class = str_replace(['.html', '.tpl'], '', basename($html_template));

/**~~----------------------------------------------------------------
 * If there is a template file make an array to be passed to smarty
 * --------------------------------------------------------------------*/

$html_template = wpct_select_tpl_first($html_template);

if (is_file($html_template)) {


	foreach ($group["plans"] as &$plan) {
		//~~----Price
		$price_tmp = BreakPrice($group, $plan["product_id"], $group["billingcycle"]);

		$currency_info=whmp_get_currency_info_i($currency);
		$group["prefix"] = $currency_info["prefix"];
		$group["suffix"] = $currency_info["suffix"];
		$group["currency"]=$currency_info["id"];
		$plan["decimal"] = $currency_info['decimal_separator'];

		$plan["prefix"] = $currency_info["prefix"];
		$plan["suffix"] = $currency_info["suffix"];
		$plan["currency"]=$currency_info["id"];
		$plan["price"] = $price_tmp["price"];
		$plan["amount"] = $price_tmp["amount"];
		$plan["fraction"] = $price_tmp["fraction"];

		$plan["duration"] = $price_tmp["duration"];
		$plan["billingcycle"] = ($group["billingcycle"]);
		$plan["billingcycle2"] = $group["billingcycle2"];
		//build array from both duration
		$plan["all_durations"] = AllPrices($group, $plan["product_id"], $group["currency"], [$group["billingcycle"], $group["billingcycle2"]]);

		//~~----Description
		//~~Simple Description + append long comparision description to it.
		$plan_description = $plan["description"] . $plan["comp_append"];
		//~~Description in array
		$plan["description"] = Description2Array($plan_description, $rows, $sep, 3, 1);
		//~~Description in Associative Array
		$plan["description_array"] = Description2Array($plan_description, $rows, $sep, 4, 1);

		if ($plan["product_id"] == $group["important"]) {
			$plan["featured"] = "yes";
		}
		else {
			$plan["featured"] = "no";
		}

		//~~ Description2Array >> description, rows , sep, return, strip_sections
		/** return values
		 * 0 > features;
		 * 1 > values;
		 * 3 > $simple_description;
		 * 4 > features_values;
		 * 5 > strip_section
		 */
		$tmp = Description2Array($plan_description, $rows, $sep, 3, false);

		//~~ build sections
		$section_index = 0;
		$description_section_index = 0;
		$description_section = [];
		foreach ($tmp as $line) {
			if (strpos($line, "--") !== false && strpos($line, "--", 3) == true) {
				$description_section_index = $section_index;
				$section = str_replace("--", "", $line);
				$group["section"][$section_index] = $section;
				$group["have_sections"] = 1;
				$section_index++;
			}
			else {
				$strpos = strpos($line, $sep);
				$feature = substr($line, 0, $strpos);
				$value = trim(substr($line, $strpos + 1));
				if ($strpos === false) {
					$plan["description_section"][$line] = "";
				}
				else {
					$plan["description_section"][$description_section_index][$feature] = [
						"value"   => $value,
						"tooltip" => return_tooltip($feature),
					];
				}
			}
		}

		$plan["order_url"] = wpct_order_url($plan['product_id'], $group['billingcycle'], $group['currency']);
	} //end plan loop


/*	$group["html"]["top"]= $top_header . $top_body . $top_bottom;
	$group["html"]["middle"]='none';
	$group["html"]["bottom"]='none';*/


	$vars = [
		"group" => $group,
	];
	$vars["random"] = $r = rand();

	$vars['group_new'] = wpct_prepare_html($group, $html_table_class, $r);


	$OutputString = whmp_smarty_template($html_template, $vars);
	//$OutputString=$vars['group_new'];
	//echo $OutputString;
	//return $OutputString;
	return $OutputString;


	/**~~ Custom Fields are not being Used Here
	 * # Getting custom fields and adding in output
	 * $TemplateArray = $WHMPress->get_template_array("whmpress_comparison_table");
	 * foreach($TemplateArray as $custom_field) {
	 * $vars[$custom_field] = isset($atts[$custom_field])?$atts[$custom_field]:"";
	 * }
	 */

}
/**~~----------------------------------------------------------------
 * If there is no smarty template selected, then show below text
 * --------------------------------------------------------------------*/
else {
	return "<div class='wpct_error'>No template selected or template does not exist. <br/>Please choose a template from <b>List All > Configure Option > Select Template File</b> under \"Comparison Table Options\" section.</div>";
}



