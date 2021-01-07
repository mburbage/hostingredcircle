<?php
## Pretty Print, only for debugging purpose
function wpct_pretty_print($var)
{
	echo "<pre>" . print_r($var, true) . "</pre>";
}

function wppa($var)
{
	echo "<pre>" . print_r($var, true) . "</pre>";
}
//~~-------------------------------------------------------------
//~~----------Functions moved from class-------------------------
//~~-------------------------------------------------------------

/* -----------------(1)-------------------
 * Function to convert description to array,
 * if ($return==0) return $features;
 * if ($return==1) return $values;
 * if ($return==3) return $simple_description;
 * if ($return==4) return $features_values;
 */
function Description2Array($description, $rows, $sep, $return, $strip_sections = false)
{

	if (isset($description)) {
		$description = preg_split("/\r\n|\n|\r/", strip_tags($description));
		//$description = explode( "\n", strip_tags( $description ) );
	} else {
		$description = [];
	}


	//~~if there are empty elements in array, remove those.
	$description = array_diff($description, ['']);

	//~~ define array to convert current array into associatve array
	$features = [];
	$values = [];
	$simple_description = [];
	$features_values = [];
	$section_features_values = [];

	$x = 0;
	$rows_c = 0;
	foreach ($description as $line) {
		if ($strip_sections == 1 && strpos($line, "--") !== false && strpos($line, "--", 3) == true) {
		} else {

			$simple_description[$x] = $line;

			$strpos = strpos($line, $sep);
			if ($strpos === false) {
				$description[$line] = "";
			} else {
				$features[$x] = trim(substr($line, 0, $strpos));
				$values[$x] = trim(substr($line, $strpos + 1));
				$features_values[$features[$x]] = [
					"value" => $values[$x],
					"tooltip" => return_tooltip($features[$x])
				];
				$rows_c++;
			}

			$x++;
			if ($rows_c == $rows) {
				break;
			}
		}
	}


	if ($return == 0) {
		return $features;
	}
	if ($return == 1) {
		return $values;
	}
	if ($return == 3) {
		return $simple_description;
	}
	if ($return == 4) {
		return $features_values;
	}
}

/* -----------------(2)-------------------
 * Retrun prices for all durations including setup
 * monthly", "quarterly", "semiannually", "annually", "biennially", "triennially"
 */
function AllPrices($price_info_array, $product_id, $currency, array $billing_cycles = ['monthly', 'annually'])
{
	//$all_billing_cycles = [ "monthly", "quarterly", "semiannually", "annually", "biennially", "triennially" ];

	$billing_cycles = array_diff($billing_cycles, ["none"]);

	// calculate discounts if there are more than two durations
	if ((count($billing_cycles) > 1) && ("no" != strtolower($price_info_array["show_discount"]))) {
		$discount_input = [
			"product_id" => $product_id,
			"currency" => $currency,
			"billing_cycle_1" => $billing_cycles[0],
			"billing_cycle_2" => $billing_cycles[1],
			"discount_type" => $price_info_array["show_discount"],
			"decimals" => $price_info_array["decimals"],
			"show_duration_as" => $price_info_array["show_duration_as"],
		];
		$discount_figure = wpct_calculate_discount($discount_input);
	}


	$all_prices = [];
	$counter = 0;
	foreach ($billing_cycles as $billing_cycle) {

		//~~ Get package price
		$price = BreakPrice($price_info_array, $product_id, $billing_cycle);
		$order_url = wpct_order_url($product_id, $billing_cycle, $currency);

		$all_prices[$billing_cycle]["Price"] = [
			"price" => $price['price'],
			"amount" => $price['amount'],
			"fraction" => $price['fraction'],
			"duration" => $price['duration'],
			"order_url" => $order_url,
		];

		//~~ Get setup price (if any)
		$setup = whmp_price_i([
			"id" => $product_id,
			"billingcycle" => $billing_cycle,
			"currency" => $currency,
			"price_type" => "setup"
		]);
		//~~ Split up price in amount, fraction and durataion
		$tmp = whmp_format_price_i(
			[
				'price' => $setup["price"],
			]
		);
		$setup_amount = $tmp['amount'];
		$setup_fraction = $tmp['fraction'];

		$all_prices[$billing_cycle]["setup"] = [
			"price" => $setup,
			"amount" => $setup_amount,
			"fraction" => $setup_fraction,
			"duration" => "One Time",
		];

		if (count($billing_cycles) > 1 && ("no" != strtolower($price_info_array["show_discount"]))) {

			$all_prices[$billing_cycle]["discount"] = $discount_figure[$counter];
		}
		$counter++;
	}


	return $all_prices;
}

/* -----------------(3)-------------------
 * Break Price into pieces
 * returns array with amount,fraction,decimal, prefix, suffix, billing cycle, duration
 * Return setup
 * & Duration
 */
function BreakPrice($group_info, $product_id, $billing_cycle)
{

	/*echo "<pre>";
    print_r($group_info);
    echo "<pre>";*/
	$decimals = '';
	$duration_style = '';
	$duation_connector = '';

	if (isset($group_info["currency"])) {
		$currency = $group_info["currency"];
	}

	if ($currency == "") {
		$currency = whmp_get_current_currency_id_i();
	}

	if (isset($group_info["decimals"])) {
		$decimals = $group_info["decimals"];
	}

	$duration_style = (isset($group_info['duration_style'])) ? $group_info['duration_style'] : whmpress_get_option('duration_style');
	$duration_connector = (isset($group_info['duration_connector'])) ? $group_info['duration_connector']
		: whmpress_get_option('duration_connector');

	$raw = whmp_price_i(
		[
			"id" => $product_id,
			"billingcycle" => $billing_cycle,
			"configurable_options" => 'yes',
			"currency_id" => $currency,
		]
	);


	$formated = whmp_format_price_i(
		[
			"price" => $raw['price'],
			"decimals" => $decimals,
		]
	);

	$complete = whmp_format_price_essentials_i(
		[
			'price' => $formated,
			'numeric_price' => $raw['price'],
			'currency_id' => $currency,
			'billingcycle' => $raw['billingcycle'],
			'duration_style' => $duration_style,
			'duration_connector' => $duration_connector,
		]
	);


	$price_info = [];

	$price_info["price"] = $formated['price'];
	$price_info["amount"] = $formated["amount"];
	$price_info["fraction"] = $formated["fraction"];
	$price_info["decimal"] = $formated["decimal_separator"];
	$price_info["prefix"] = $complete['prefix'];
	$price_info["suffix"] = $complete['suffix'];
	$price_info["billingcycle"] = $raw['billingcycle'];
	$price_info["duration"] = $complete['duration'];
	//ppa($price_info);
	return $price_info;
}

/* -----------------(4)-------------------
 * Returns a tooltip, if match string is found
 * Used in Description2Array Function
 */
function return_tooltip($match_string)
{
	global $wpdb;
	$row = $wpdb->get_row("SELECT * FROM `" . whmp_get_group_tooltips_table_name() . "` WHERE `match_string` LIKE '%" . $match_string . "%'");

	if (isset($row)) {
		return $row->tooltip_text;
	} else {
		return null;
	}
}

if (!function_exists('whmp_get_group_table_name')) {
	function whmp_get_group_table_name()
	{
		global $wpdb;

		return $wpdb->prefix . "whmpress_groups";
	}
}

if (!function_exists('whmp_get_group_detail_table_name')) {
	function whmp_get_group_detail_table_name()
	{
		global $wpdb;

		return $wpdb->prefix . "whmpress_groups_details";
	}
}

if (!function_exists('whmp_get_group_tooltips_table_name')) {
	function whmp_get_group_tooltips_table_name()
	{
		global $wpdb;

		return $wpdb->prefix . "whmpress_groups_tooltips";
	}
}


## Add VC Short-Codes Mapping
require_once('vc.php');

## Get all groups
function wpct_get_all_groups($ids = false)
{
	global $wpdb;
	$Q = "SELECT * FROM `" . whmp_get_group_table_name() . "`";
	$groups = $wpdb->get_results($Q, ARRAY_A);
	if ($ids == true) {
		$ids_array = [];
		if (is_array($groups) && sizeof($groups) > 0) {
			foreach ($groups as $group) {
				$ids_array[] = $group['id'];
			}
		} else {
			$ids_array[0] = __("No Group Created", "wpct");
		}

		return $ids_array;
	} else {
		if (is_array($groups) && sizeof($groups) > 0) {
			$groups = $groups;
		} else {
			$groups[0] = __("No Group Created", "wpct");
		}

		return $groups;
	}
}

## Get all templates for a groups
function wpct_get_shortcode_templates($shortcode)
{
	$files_names = [];
	$files_html = glob(WPCT_GRP_PATH . "/templates/" . $shortcode . "/*.html");
	$files_tpl = glob(WPCT_GRP_PATH . "/templates/" . $shortcode . "/*.html");
	$files = array_merge($files_html, $files_tpl);
	foreach ($files as $file) {
		$files_names[] = basename($file);
	}

	return $files_names;
}

//~~ get order URL
//todo: convert pats to constants
function wpct_order_url($id, $billing_cycle, $currency)
{


	$order_url = '';
	$WHMPress = new WHMPress();
	$order_base = $WHMPress->get_whmcs_url("order");
	if (is_plugin_active('WHMpress_Client_Area/client-area.php')) {
		global $WHMPress_Client_Area;
		if (empty($WHMPress_Client_Area)) {
			$WHMPress_Client_Area = new WHMPress_Client_Area;
		}

		if ($WHMPress_Client_Area->is_permalink()) {
			$order_url = $order_base . '/pid/' . $id . '/a/add/currency/' . $currency . '&billingcycle=' . $billing_cycle . '/';
		} else {
			$order_url = $order_base . 'pid=' . $id . '&a=add&currency=' . $currency . '&billingcycle=' . $billing_cycle;
		}
	} else {
		$order_url = $order_base . 'pid=' . $id . '&a=add&currency=' . $currency . '&billingcycle=' . $billing_cycle;
	}

	return $order_url;
}


// Functions moved from whmpress_comparison_table.php

if (!function_exists('wpct_prepare_html')) {
	function wpct_prepare_html($group, $html_table_class, $r)
	{
		$style_2 = [
			'comparison-02',
			'comparison-04',
			'comparison-05',
			'comparison-06',
			'comparison-07',
		];

		$style_3 = [
			/*				'comparison-02',*/];


		/********** First Column of Top Row ***********/
		$important = 0;
		$i = 0;
		foreach ($group['plans'] as $plan) {
			if ($plan['product_id'] == $group['important']) {
				$important = $i;
			}
			$i++;
		}


		if (($group['show_discount'] != "no") && ($group['show_discount_banner'] == "yes")) {
			$discount_container = wpct_prepare_plan_discounts($group['plans'][$important], "", $group['show_discount_secondary']);
		} else {
			$discount_container = "";
		}
		$toggle_container = wpct_prepare_duration_toggle($group, $r);

		//{if $group.alternate_rows eq "0"}
		//{foreach $group.plans[0].all_durations as $dur}
		//<label><input type="radio" name="duration" data-duration="{$dur.Price.duration}"><span>{$dur.Price.duration}</span></label>
		//{/foreach}
		//{/if}
		$heading_column_top = '
				<div class="wpct_comparison_table_col wpct_comparison_table_titles_col">
					' . $discount_container . '
					<div class="wpct_price_toggle">' . $toggle_container . '</div>
				</div>';

		/********** Top Header Start ***********/
		$counter = 0;
		$tables = '';
		foreach ($group["plans"] as $plan) {

			// Breaking loop if number of plans exceeds 4
			//todo: there should be a message to display here.
			/*			if ( $counter > 5 ) {
                            break;
                        }*/

			// Current Table Promo Text
			$featured = $promo = '';
			if ($plan["featured"] == "yes") {
				$featured = "featured";
				$promo =
					'<div class="wpct_promo-text">
							<div class="wpct_holder">
								<span>' . $group["ribbon_text"] . '</span>
							</div>
						</div> <!-- /.wpct_promo-text -->';
			}

			// Current Table Heading
			$heading =
				'<div class="wpct_heading">
						<div class="wpct_holder">
							<h2>' . $plan['name'] . '</h2>
						</div>
					</div> <!-- /.wpct_heading -->';

			// Current Table Text
			if ($plan['cdescription'] == '') {
				$text = '';
			} else {
				$text =
					'<div class="whmp_text">
					<div class="whmp_holder">
						<p>' . $plan['cdescription'] . '</p>
					</div>
				</div> <!-- /.whmp_text -->';
			}

			// Current Table Price
			$price = wpct_prepare_plan_price($plan);

			// Current Table Discount Text and Value
			$discount = ($group['show_discount'] != "no") ? wpct_prepare_plan_discounts($plan, "table", $group['show_discount_secondary']) : "";


			// Current Table Features
			$args = [
				'description_array' => $plan["description_array"],
				'section' => "top",
				'return_rows' => -1,
				'convert_fa' => $group['convert_to_symbol'],
				'convert_fa_no' => $group['convert_no_with'],
				'convert_fa_yes' => $group['convert_yes_with'],
			];
			$features = wpct_prepare_plan_features_list($args);

			// Current Table Buttons
			$button = wpct_prepare_plan_button($group, $plan);

			// Compiling Current Table Column
			if (in_array($html_table_class, $style_2)) {
				$table_html = $promo . $heading . $price . $discount . $text . $features . $button;
			} else {
				$table_html = $promo . $heading . $text . $price . $discount . $features . $button;
			}
			$table =
				'<div class="wpct_comparison_table_col">
						<div class="wpct_pricing_table  ' . $featured . ' ' . $html_table_class . ' ">
							' . $table_html . '
						</div><!-- /.wpct_pricing_table -->
					</div>';

			$tables .= $table;
			$counter++;
		}

		$parts = array();

		$parts['top'] = '<div class="wpct_comparison_table_row wpct_comparison_table_section_tables">';
		$parts['top'] .= $heading_column_top;
		$parts['top'] .= $tables;
		$parts['top'] .= '</div>';

		/********** Top Header end ***********/

		/********** Middle Start ***********/
		// call to function to build middle part without section

		if ($group["have_sections"] == false) {
			$parts["middle"] = wpct_prepare_html_middle($group);
		} else {
			$parts["middle"] = wpct_prepare_html_middle_sections($group);
		}

		/********** Middle end ***********/

		/********** Summary Start ***********/
		$counter = 0;
		$tables = '';
		foreach ($group["plans"] as $plan) {

			// Breaking loop if number of plans exceeds 4
			/*			if ( $counter == 4 ) {
                            break;
                        }*/


			$featured = '';
			if ($plan["featured"] == "yes") {
				$featured = "featured";
			}

			// Current Table Heading
			$heading =
				'<div class="wpct_heading">
						<div class="wpct_holder">
							<h2>' . $plan['name'] . '</h2>
						</div>
					</div> <!-- /.wpct_heading -->';

			// Current Table Price
			$price = wpct_prepare_plan_price($plan);

			// Current Table Buttons
			$button = wpct_prepare_plan_button($group, $plan);

			// Compiling Current Table Column
			$table =
				'<div class="wpct_comparison_table_col">
						<div class="wpct_pricing_table  ' . $featured . ' ' . $html_table_class . ' ">
							' . $heading . $price . $button . '
						</div><!-- /.wpct_pricing_table -->
					</div>';

			$tables .= $table;
			$counter++;
		}

		$parts['bottom'] = '<div class="wpct_comparison_table_row wpct_comparison_table_section_summary">';
		$parts['bottom'] .= '<div class="wpct_comparison_table_col wpct_comparison_table_titles_col"></div>';
		$parts['bottom'] .= $tables;
		$parts['bottom'] .= '</div>';


		/********** Summary  end ***********/

		return $parts;
	}
}

if (!function_exists('wpct_prepare_html_middle')) {
	function wpct_prepare_html_middle($group)
	{
		$convert_fa = ($group['convert_to_symbol'] == "1") ? "yes" : "no";


		$mid1 = '<!--**** middle start ***-->';
		$mid1 .= '<div class="wpct_comparison_table_row wpct_comparison_table_section_heading">';
		$mid1 .= '<span>' . esc_html__("COMPARISON TABLE INCLUDES", "wpct") . '</span>';
		$mid1 .= '</div>';

		$mid1 .= '<div class="wpct_comparison_table_row wpct_comparison_table_section_content">';
		$mid1 .= '<div class="wpct_comparison_table_col wpct_comparison_table_titles_col">';
		$mid1 .= '<!--first column, with feature title starts-->';
		$mid1 .= '<ul class="wpct_comparison_table_feature_titles">';
		$tmp = '';
		foreach ($group["plans"] as $plan) {
			foreach ($plan["description_array"] as $key => $pair) {
				$tooltip_text = $tooltip_class = "";
				if ($group['enable_tooltips'] == 1) {
					$tooltip_class = ($pair['tooltip'] == "") ? '' : ' wpct_has_tooltip';
					$tooltip_text = ($pair['tooltip'] == "") ? '' : '<div class="wpct_tooltip">' . $pair['tooltip'] . '</div>';
				}
				$tmp .= '<li class="' . $tooltip_class . '">';
				$tmp .= '<span class="wpct_feature_title_text">' . $key . ':</span>';
				$tmp .= $tooltip_text;
				$tmp .= '</li>';
			}
			break; // we only need titles from first one.
		}
		$mid1 .= $tmp;
		$mid1 .= '</ul>';
		$mid1 .= '<!--feature title end-->';
		$mid1 .= '</div>';

		$mid2 = '';
		$counter = 0;
		$return_row = count($group["plans"][0]["description_array"]);
		foreach ($group["plans"] as $plan) {
			// Breaking loop if number of plans exceeds 4
			/*			if ( $counter == 4 ) {
                            break;
                        }*/
			$featured = '';
			if ($plan["featured"] == "yes") {
				$featured = "featured";
			}

			$mid2 .= '<!-- Column (' . $counter . ') START -->';
			$mid2 .= '<div class="wpct_comparison_table_col">';
			$mid2 .= '<ul class="wpct_comparison_table_feature_values ' . $featured . '">';

			$args = [
				'description_array' => $plan["description_array"],
				'section' => "middle",
				'return_rows' => -1,
				'convert_fa' => $group['convert_to_symbol'],
				'convert_fa_no' => $group['convert_no_with'],
				'convert_fa_yes' => $group['convert_yes_with'],
			];
			$mid2 .= wpct_prepare_plan_features_list($args);
			$mid2 .= '</ul>';
			$mid2 .= '</div>';
			$mid2 .= '<!-- column (' . $counter . ') END -->';
			$counter++;
		}
		$mid3 = '</div>';
		$mid3 .= '<!--**** middle end ***-->';

		$mid = $mid1 . $mid2 . $mid3;

		$parts["middle"] = $mid;

		return $parts["middle"];
	}
}

if (!function_exists('wpct_prepare_html_middle_sections')) {
	function wpct_prepare_html_middle_sections($group)
	{
		$x = 0;
		$section = '';
		$convert_fa = ($group['convert_to_symbol'] == "1") ? "yes" : "no";

		foreach ($group["section"] as $title) {
			$section_title = '<!--**** start section title (' . $x . ') ***-->';
			$section_title .= '<div class="wpct_comparison_table_row wpct_comparison_table_section_heading">';
			$section_title .= '<span>' . $title . '</span>';
			$section_title .= '</div>';
			$section_title .= '<!--**** end section title ***-->';

			$section_details = '<div class="wpct_comparison_table_row wpct_comparison_table_section_content">';

			$features_set = false;
			$section_features = '';
			$section_values = '';
			//todo: impliment beelow functions in wpct_prepare_html_middle too.
			if (is_array($group['plans']) && !empty($group['plans'])) {
				foreach ($group["plans"] as $plan) {
					$featured = '';
					if ($plan["featured"] == "yes") {
						$featured = "featured";
					}


					//todo: maybe we could check total groups at first and escape the loop when needed.

					// only pass the first section of plan to get features and values
					// get features only for once

					// note: consider plans as columns, on each foreach, we get next plan/column and
					//for that plans/column we only fetch values of required section.

					$tooltip_status = $group['enable_tooltips'];
					if ($features_set == false) {
						$section_features .= wpct_feature_row_html($plan['description_section'][$x], $tooltip_status);
						$features_set = true;
					}
					if (isset($plan['description_section']) && is_array($plan['description_section']) && (count($plan['description_section']) > $x)) {
						$section_values .= wpct_values_row_html($plan['description_section'][$x], $featured, $group);
					}
				}
			}
			$section_details .= $section_features . $section_values;
			$section_details .= '</div>';

			$section .= $section_title . $section_details;
			$x++;
		}

		$parts["middle"] = $section;

		return $parts["middle"];
	}
}

if (!function_exists('wpct_feature_row_html')) {
	function wpct_feature_row_html($plans, $tooltip_status = 1)
	{
		$tmp = "";
		$mid1 = '';
		$mid1 .= '<!--first column, with feature title starts-->';
		$mid1 .= '<div class="wpct_comparison_table_col wpct_comparison_table_titles_col">';
		$mid1 .= '<ul class="wpct_comparison_table_feature_titles">';
		if (is_array($plans) && !empty($plans)) {
			foreach ($plans as $key => $pair) {
				$tooltip_text = $tooltip_class = "";
				if ($tooltip_status == 1) {
					$tooltip_class = ($pair['tooltip'] == "") ? '' : ' wpct_has_tooltip';
					$tooltip_text = ($pair['tooltip'] == "") ? '' : '<div class="wpct_tooltip">' . $pair['tooltip'] . '</div>';
				}
				$tmp .= '<li class="' . $tooltip_class . '">';
				$tmp .= '<span class="wpct_feature_title_text">' . $key . ':</span>';
				$tmp .= $tooltip_text;
				$tmp .= '</li>';
			}
		}
		$mid1 .= $tmp;
		$mid1 .= '</ul>';
		$mid1 .= '</div>';
		$mid1 .= '<!-- end features column -->';

		return $mid1;
	}
}

if (!function_exists('wpct_values_row_html')) {
	function wpct_values_row_html($plans, $featured = '', $group)
	{
		$mid2 = '';
		$mid2 .= '<!-- value column start -->';
		$mid2 .= '<div class="wpct_comparison_table_col">';
		$mid2 .= '<ul class="wpct_comparison_table_feature_values ' . $featured . ' ">';

		$args = [
			'description_array' => $plans,
			'section' => "middle",
			'return_rows' => -1,
			'convert_fa' => $group['convert_to_symbol'],
			'convert_fa_no' => $group['convert_no_with'],
			'convert_fa_yes' => $group['convert_yes_with'],
		];
		$mid2 .= wpct_prepare_plan_features_list($args);
		$mid2 .= '</ul>';
		$mid2 .= '</div>';
		$mid2 .= '<!-- value column end -->';

		return $mid2;
	}
}
		
if (!function_exists('wpct_prepare_plan_price')) {
	function wpct_prepare_plan_price($plan)
	{
		$price = "";
		$c = 0;
		if (is_array($plan['all_durations']) && !empty($plan['all_durations'])) {
			foreach ($plan['all_durations'] as $key => $dur) {
				// Current Table Price
				$display = ($c == 0) ? '' : 'style="display: none;"';
				$prefix = '<span class="wpct_unit">' . $plan['prefix'] . '</span>';
				$amount = '<span class="wpct_amount">' . $dur['Price']['amount'] . '</span>';
				$fraction = ($dur['Price']['fraction'] == '') ? '' : '<span class="wpct_fraction">' . $dur['Price']['fraction'] . '</span>';
				$decimal = ($dur['Price']['fraction'] == '') ? '' : '<span class="wpct_decimal">' . $plan['decimal'] . '</span>';
				$duration = '<span class="wpct_period">' . $dur['Price']['duration'] . '</span>';
				$price .=
					'<div class="wpct_holder ' . $key . '" ' . $display . ' >
							' . $prefix . $amount . $decimal . $fraction . $duration . '
						</div>';
				$c++;
			}
			$price = '<div class="wpct_price">' . $price . '</div> <!-- /.wpct_price -->';
		}

		//wpct_ppa($price);

		return $price;
	}
}

if (!function_exists('wpct_prepare_duration_toggle')) {
	function wpct_prepare_duration_toggle($group, $r)
	{
		$toggle_container = '';
		$dur_array = $group["plans"][0]['all_durations'];

		//wpct_ppa(($dur_array));
		if (is_array($dur_array) && (!empty($dur_array) && count($dur_array) > 1)) {
			$c = 0;
			foreach ($group["plans"][0]['all_durations'] as $key => $dur) {
				$active = ($c == 0) ? 'active' : '';
				$checked = ($c == 0) ? 'checked="checked"' : '';
				$toggle_container .= '<label><input type="radio" name="duration_' . $r . '" data-orderurl="' . $dur['Price']['order_url'] . '" data-duration="' . $key . '" class="' . $active . '" ' . $checked . '><span>' . wpct_convert_billingcycle($key, "duration") . '</span></label>';
				$c++;
			}
		}

		return $toggle_container;
	}
}

if (!function_exists('wpct_prepare_plan_discounts')) {
	function wpct_prepare_plan_discounts($plan, $table = "", $show_secondary = "no")
	{
		$price = "";
		$c = 0;
		if (is_array($plan['all_durations']) && !empty($plan['all_durations'])) {
			foreach ($plan['all_durations'] as $key => $dur) {

				// Current Table Price
				$display = ($c == 0) ? '' : 'style="display: none;"';
				//$discount      = '<span class="wpct_discount_text">' . $dur['discount']['feature_string'] . '</span>';
				$feature_string = isset($dur['discount']['feature_string']) ? $dur['discount']['feature_string'] : '';
				$discount_string = "";
				if (isset($dur['discount']['discount_string']) && $dur['discount']['discount_string'] != "") {
					$discount_string = '<span class="wpct_discount_string">' . $dur['discount']['discount_string'] . '</span>';
				}
				if ($show_secondary == "no" && $c == 1) {
					$price .= '<div class="wpct_holder ' . $key . '" ' . $display . ' ></div>';
				} else {
					if ($table == "table") {
						$price .=
							'<div class="wpct_holder ' . $key . '" ' . $display . ' >'
							. $discount_string .
							'</div>';
					} else {
						$price .=
							'<div class="wpct_holder ' . $key . '" ' . $display . ' >'
							. $feature_string .
							'</div>';
					}
				}
				$c++;
			}
			$price = '<div class="wpct_discounts_container">' . $price . '</div> <!-- /.wpct_price -->';
		}

		return $price;
	}
}

if (!function_exists('wpct_prepare_plan_durations')) {
	function wpct_prepare_plan_durations($plan)
	{
		$price = "";
		$c = 0;
		if (is_array($plan['all_durations']) && !empty($plan['all_durations'])) {
			foreach ($plan['all_durations'] as $key => $dur) {
				// Current Table Price
				$display = ($c == 0) ? '' : 'style="display: none;"';
				$duration = $dur['Price']['duration'];
				$price .=
					'<span class="wpct_holder ' . $key . '" ' . $display . ' >
							' . $duration . '
						</span>';
				$c++;
			}
		}

		return $price;
	}
}

if (!function_exists('wpct_prepare_plan_button')) {
	function wpct_prepare_plan_button($group, $plan)
	{


		$button = "";
		$c = 0;
		if (is_array($plan['all_durations']) && !empty($plan['all_durations'])) {
			foreach ($plan['all_durations'] as $key => $dur) {
				// Current Table Price
				$display = ($c == 0) ? '' : 'style="display: none;"';
				$duration = $dur['Price']['order_url'];
				$button .=
					'<div class="wpct_holder ' . $key . '" ' . $display . ' >
							<a type="button" class="wpct_submit-button wpct_submit" href="' . $duration . '">' . $group["button_text"] . '</a>
						</div>';
				$c++;
			}
			$button = '<div class="wpct_button">' . $button . '</div> <!-- /.wpct_button -->';
		}

		return $button;
	}
}

if (!function_exists('wpct_prepare_plan_features_list')) {
	function wpct_prepare_plan_features_list($args = [])
	{
		$description_array = (isset($args['description_array'])) ? $args['description_array'] : "";
		$section = (isset($args['section'])) ? $args['section'] : "";
		$return_rows = (isset($args['return_rows'])) ? $args['return_rows'] : -1;
		$convert_fa = (isset($args['convert_fa'])) ? $args['convert_fa'] : 1;
		$convert_fa_no = ($args['convert_fa_no'] != "") ? $args['convert_fa_no'] : "fa-close";
		$convert_fa_yes = ($args['convert_fa_yes'] != "") ? $args['convert_fa_yes'] : "fa-check";


		$feature_array = '';
		if (is_array($description_array) && !empty($description_array)) {
			$counter = 1;
			foreach ($description_array as $key => $pair) {
				$tooltip_text = $tooltip_class = "";
				$tooltip_class = ($pair['tooltip'] == "") ? '' : ' wpct_has_tooltip';
				$tooltip_text = ($pair['tooltip'] == "") ? '' : '<div class="wpct_tooltip">' . $pair['tooltip'] . '</div>';

				$temp_val = strtolower($pair["value"]);
				switch ($temp_val) {
					case 'yes': {
							if (strtolower($convert_fa) == 1) {
								$pair["value"] = '<i class="fa wpct_icon_yes ' . $convert_fa_yes . '"></i>';
							} else {
								$pair["value"] = $pair["value"];
							}
							break;
						}
					case 'no': {
							if (strtolower($convert_fa) == 1) {
								$pair["value"] = '<i class="fa wpct_icon_no ' . $convert_fa_no . '"></i>';
							} else {
								$pair["value"] = $pair["value"];
							}
							break;
						}
					case '': {
							$pair["value"] = '-';
							break;
						}
					default: {
							$pair["value"] = $pair["value"];
						}
				}
				$feature_array .= '<li class="' . $tooltip_class . '" >';
				if ($section == 'top') {
					$feature_array .= '<strong>' . $key . ':</strong>';
				} else {
					$feature_array .= '<span class="wpct_comp_feature_title_responsive">' . $key . ':</span>';
				}
				$feature_array .= $pair["value"];
				$feature_array .= $tooltip_text;
				$feature_array .= '</li>';

				if ($counter == $return_rows) {
					break;
				}
				$counter++;
			}
		}
		$features = '
					<div class="whmp_features wpct_plan_description_responsive">
						<div class="whmp_holder">
							<ul class="wpct_comparison_table_feature_values">
								' . $feature_array . '
							</ul>
						</div>
					</div> <!-- /.whmp_features -->';

		if ($section == 'top') {
			return $features;
		} else {
			return $feature_array;
		}
	}
}

if (!function_exists("wpct_calculate_discount")) {
	function wpct_calculate_discount($discount_array)
	{
		$billing1 = $discount_array["billing_cycle_1"];
		$billing2 = $discount_array["billing_cycle_2"];
		$currency = $discount_array["currency"];
		$product_id = $discount_array["product_id"];
		$type = $discount_array["discount_type"];
		$decimals = $discount_array["decimals"];
		$duration_as = $discount_array["show_duration_as"];		

		$currency_prefix = whmp_get_currency_prefix($currency);

		$tmp = whmp_price_i([
			"billingcycle" => $billing1,
			"id" => $product_id,
			"currency" => $currency,
		]);
		$price1 = $tmp["price"];

		$tmp = whmp_price_i([
			"billingcycle" => $billing2,
			"id" => $product_id,
			"currency" => $currency,

		]);
		$price2 = $tmp["price"];
		// calculates /month price from price2
		$months1 = wpct_convert_billingcycle($billing1, "months");

		$monthly_price1 = number_format(($price1 / $months1), $decimals);
		$monthly_prce_string1 = $monthly_price1 . wpct_convert_billingcycle("monthly", $duration_as, "per") . " when paid " . wpct_convert_billingcycle($billing2, "duration");

		$months2 = wpct_convert_billingcycle($billing2, "months");
		$monthly_price2 = number_format(($price2 / $months2), $decimals);
		$monthly_prce_string2 = $monthly_price2 . wpct_convert_billingcycle("monthly", $duration_as, "per") . " when paid " . wpct_convert_billingcycle($billing2, "duration");
		//echo "months=". $months;

		$discount1 = $discount2 = 0;

		$discount_string = "";
		$lang = wpct_get_current_language();
		$discount_string1 = get_option("wpct_discount_string1_" . $lang);
		$discount_string2 = get_option("wpct_discount_string2_" . $lang);

		$feature_string1 = get_option("wpct_feature_string1_" . $lang);
		$feature_string2 = get_option("wpct_feature_string2_" . $lang);

		if ($type == "amount") {
			// this was being calculated for monthly, we need to show discount for yearly
			$cost1 = $price1;
			//$cost2 = number_format(($price2 / $months2), $decimals);
			$cost2 = $price1 * $months2;

			$discount1 = 0;
			$discount2 = $cost2 - $price2;

			//---- discount 1 -----//
			$dur = wpct_convert_billingcycle($billing2);


			//$dis = $discount2 . wpct_convert_billingcycle($billing1, "$duration_as", "per");
			// this was adding monthly
			$dis = $currency_prefix . $discount2;
			$discount_string1 = str_replace("{duration}", $dur, $discount_string1);
			$discount_string1 = str_replace("{discount}", $dis, $discount_string1);

			//---- discount 2 -----//

			$dur = wpct_convert_billingcycle($billing2);
			//$dis = $discount2 . " " . wpct_convert_billingcycle($billing1, "$duration_as", "per");

			$discount_string2 = str_replace("{duration}", $dur, $discount_string2);
			$discount_string2 = str_replace("{discount}", $dis, $discount_string2);


			$cost_string1 = "Switch " . wpct_convert_billingcycle($billing2) . $cost2 . wpct_convert_billingcycle($billing1, "$duration_as", "per");
			$cost_string2 = "costs " . $cost2 . wpct_convert_billingcycle($billing1, $duration_as, "per");


			//---- Feature 1 -----//
			$dur = wpct_convert_billingcycle($billing2);
			//$dis = $discount2 . wpct_convert_billingcycle($billing1, "$duration_as", "per");
			$temp_array = explode("<br>", $feature_string1);
			$temp = "";
			if (is_array($temp_array) && count($temp_array) > 1) {
				$temp .= '<span class="wpct_discount_text">' . $temp_array[0] . '</span>';
				$temp .= '<span class="wpct_discount_value">' . $temp_array[1] . '</span>';
				$feature_string1 = $temp;
			}
			$feature_string1 = str_replace("{duration}", $dur, $feature_string1);
			$feature_string1 = str_replace("{discount}", $dis, $feature_string1);

			//---- Feature 2 -----//
			$dur = wpct_convert_billingcycle($billing2);
			//$dis = $discount2 . " " . wpct_convert_billingcycle($billing1, "$duration_as", "per");


			$temp_array = explode("<br>", $feature_string2);
			$temp = "";
			if (is_array($temp_array) && count($temp_array) > 1) {
				$temp .= '<span class="wpct_discount_text">' . $temp_array[0] . '</span>';
				$temp .= '<span class="wpct_discount_value">' . $temp_array[1] . '</span>';
				$feature_string2 = $temp;
			}
			$feature_string2 = str_replace("{duration}", $dur, $feature_string2);
			$feature_string2 = str_replace("{discount}", $dis, $feature_string2);
		}

		if ($type == "percentage") {
			$cost1 = $price1;
			//$cost2 = number_format(($price2 / $months2), $decimals);
			// instead of calculating monthly price from yearly, caclulate yearly price from monthly
			$cost2 = $price1 * $months2;

			$cost_string1 = "Switch " . wpct_convert_billingcycle($billing2) . $cost2 . wpct_convert_billingcycle($billing1, "$duration_as", "per2");
			$cost_string2 = "costs " . $cost2 . wpct_convert_billingcycle($billing1, "$duration_as", "per2");

			if ($price1 == 0) {
				$discount2 = "100%";
			} else {
				//$discount2 = round(100 - ($price2 / ($price1 * $months2) * 100), 0) . "%";
				if($months2 === 12) {
					$discount2 = round(100 - ($price2 / ($price1 * $months2))*100) . "%";
				}else{
					$discount2 = round(100 - ($price2 / ($price1 * 2))*100) . "%";
				}
				
			}


			$discount1 = $discount2;

			//---- discount 1 -----//
			$dur = wpct_convert_billingcycle($billing2);
			$dis = $discount2;
			$discount_string1 = str_replace("{duration}", $dur, $discount_string1);
			$discount_string1 = str_replace("{discount}", $dis, $discount_string1);

			//---- discount 2 -----//

			$dur = wpct_convert_billingcycle($billing2);
			$dis = $discount2;
			$discount_string2 = str_replace("{duration}", $dur, $discount_string2);
			$discount_string2 = str_replace("{discount}", $dis, $discount_string2);


			//---- Feature 1 -----//
			$dur = wpct_convert_billingcycle($billing2);
			$dis = $discount2;
			$temp_array = explode("<br>", $feature_string1);
			$temp = "";
			if (is_array($temp_array) && count($temp_array) > 1) {
				$temp .= '<span class="wpct_discount_text">' . $temp_array[0] . '</span>';
				$temp .= '<span class="wpct_discount_value">' . $temp_array[1] . '</span>';
				$feature_string1 = $temp;
			}
			$feature_string1 = str_replace("{duration}", $dur, $feature_string1);
			$feature_string1 = str_replace("{discount}", $dis, $feature_string1);

			//---- Feature 2 -----//
			$dur = wpct_convert_billingcycle($billing2);
			$dis = $discount2;
			$temp_array = explode("<br>", $feature_string2);
			$temp = "";
			if (is_array($temp_array) && count($temp_array) > 1) {
				$temp .= '<span class="wpct_discount_text">' . $temp_array[0] . '</span>';
				$temp .= '<span class="wpct_discount_value">' . $temp_array[1] . '</span>';
				$feature_string2 = $temp;
			}
			$feature_string2 = str_replace("{duration}", $dur, $feature_string2);
			$feature_string2 = str_replace("{discount}", $dis, $feature_string2);


			//echo "per month=" . $discount2;
		}


		$discount_array = [
			[
				"billingcycle" => $billing1,
				"discount" => $discount1,
				"discount_string" => $discount_string1,
				"cost" => $cost1,
				"cost_string" => $cost_string1,
				"montly_price" => $monthly_price1,
				"monthly_price_string" => $monthly_prce_string1,
				"feature_string" => $feature_string1,

			],

			[
				"billing_cycle" => $billing2,
				"discount" => $discount2,
				"discount_string" => $discount_string2,
				"cost" => $cost2,
				"cost_string" => $cost_string2,
				"montly_price" => $monthly_price2,
				"monthly_price_string" => $monthly_prce_string2,
				"feature_string" => $feature_string2,
			],
		];


		return $discount_array;
	}
}

// todo: update to new version from WHMCS
if (!function_exists("wpct_convert_billingcycle")) {
	function wpct_convert_billingcycle($billingcycle, $convert_to = "duration", $style = "blank")
	{

		$map = [
			"monthly" => [
				"months" => 1,
				"duration" => esc_html__("monthly", "wpct"),
				"long" => [
					"blank" => esc_html__("Month", "wpct"),
					"per" => esc_html__("/Month", "wpct"),
					"per2" => esc_html__("per Month", "wpct"),
				],

				"short" => [
					"blank" => esc_html__("mo", "wpct"),
					"per" => esc_html__("/mo", "wpct"),
					"per2" => esc_html__("per mo", "wpct"),
				],

				"monthly" => [
					"blank" => esc_html__("1 Month", "wpct"),
					"per" => esc_html__("/ Month", "wpct"),
					"per2" => esc_html__("per Month", "wpct"),
				],
			],

			"quarterly" => [
				"months" => 3,
				"duration" => esc_html__("quarterly", "wpct"),

				"long" => [
					"blank" => esc_html__("Quarter", "wpct"),
					"per" => esc_html__("/Quarter", "wpct"),
					"per2" => esc_html__("per Quarter", "wpct"),
				],
				"short" => [
					"blank" => esc_html__("qu", "wpct"),
					"per" => esc_html__("/qu", "wpct"),
					"per2" => esc_html__("per qu", "wpct"),
				],

				"monthly" => [
					"blank" => esc_html__("3 Months", "wpct"),
					"per" => esc_html__("/3 Months", "wpct"),
					"per2" => esc_html__("per 3 Months", "wpct"),
				],
			],

			"semiannually" => [
				"months" => 6,
				"duration" => esc_html__("semiannually", "wpct"),
				"long" => [
					"blank" => esc_html__("Half Year", "wpct"),
					"per" => esc_html__("/Half year", "wpct"),
					"per2" => esc_html__("per Half year", "wpct"),
				],
				"short" => [
					"blank" => esc_html__("sa", "wpct"),
					"per" => esc_html__("/sa", "wpct"),
					"pers" => esc_html__("per sa", "wpct"),
				],
				"monthly" => [
					"blank" => esc_html__("6 Months", "wpct"),
					"per" => esc_html__("/6 Months", "wpct"),
					"per2" => esc_html__("per 6 Months", "wpct"),
				]
			],

			"annually" => [
				"months" => 12,
				"duration" => esc_html__("Yearly", "wpct"),
				"long" => [
					"blank" => esc_html__("Year", "wpct"),
					"per" => esc_html__("/Year", "wpct"),
					"per2" => esc_html__("per Year", "wpct"),
				],
				"short" => [
					"blank" => esc_html__("yr", "wpct"),
					"per" => esc_html__("/yr", "wpct"),
					"per2" => esc_html__("per yr", "wpct"),
				],
				"monthly" => [
					"blank" => esc_html__("12 Months", "wpct"),
					"per" => esc_html__("/12 Months", "wpct"),
					"per2" => esc_html__("per 12 Months", "wpct"),
				],
			],

			"biennially" => [
				"months" => 24,
				"duration" => esc_html__("Biennially", "wpct"),
				"long" => [
					"blank" => esc_html__("2 Years", "wpct"),
					"per" => esc_html__("/2 Years", "wpct"),
					"per2" => esc_html__("per 2 Years", "wpct"),
				],

				"short" => [
					"blank" => esc_html__("2 yrs", "wpct"),
					"per" => esc_html__("/2 yrs", "wpct"),
					"per2" => esc_html__("per 2 yrs", "wpct"),
				],

				"monthly" => [
					"blank" => esc_html__("24 Months", "wpct"),
					"per" => esc_html__("/24 Months", "wpct"),
					"per2" => esc_html__("per 24 Months", "wpct"),
				],
			],

			"triennially" => [
				"months" => 36,
				"duration" => esc_html__("Triennially", "wpct"),

				"long" => [
					"blank" => esc_html__("3 Years", "wpct"),
					"per" => esc_html__("/3 years", "wpct"),
					"per2" => esc_html__("per 3 years", "wpct"),
				],

				"short" => [
					"blank" => esc_html__("3 yrs", "wpct"),
					"per" => esc_html__("/3 yrs", "wpct"),
					"per2" => esc_html__("per 3 yrs", "wpct"),
				],

				"monthly" => [
					"blank" => esc_html__("36 Months", "wpct"),
					"per" => esc_html__("/36 Months", "wpct"),
					"per2" => esc_html__("per 36 Months", "wpct"),
				],
			]
		];


		if ($convert_to == "months" || $convert_to == "duration") {
			return $map[$billingcycle][$convert_to];
		} else {
			return $map[$billingcycle][$convert_to][$style];
		}
	}
}

if (!function_exists('wpct_get_current_language')) {
	function wpct_get_current_language()
	{
		if (defined('ICL_LANGUAGE_CODE')) {
			return ICL_LANGUAGE_CODE;
		} elseif (function_exists('pll_current_language')) {
			return pll_current_language();
		} elseif (isset($_GET["lang"])) {
			return $_GET["lang"];
		} else {
			return get_locale();
		}
	}
}

if (!function_exists("wpct_select_tpl_first")) {
	function wpct_select_tpl_first($html_template)
	{
		$html_template = str_replace(['.html', '.tpl'], ['', ''], $html_template);
		if (is_file($html_template . '.tpl')) {
			$html_template = $html_template . '.tpl';
		} elseif (is_file($html_template . '.html')) {
			$html_template = $html_template . '.tpl';
		}

		return $html_template;
	}
}


if (!function_exists('wpct_ppa')) {
	function wpct_ppa($mr, $str = "")
	{
		echo "<pre>";
		echo $str . "<br>";
		print_r($mr);
		echo "</pre>";
	}
}
