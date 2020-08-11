<?php
// todo: check formatting function
// todo: check currency changes
// get price formats
/**
 * Created by PhpStorm.
 * User: fokado
 * Date: 3/11/2017
 * Time: 7:17 PM
 */

/*
 * returns: raw price + billingcycle from database in array
 * if duration is not provided, returns minimum configured price
 * function fetches price direct from db, without involving short-code and any existing functions
 * points
 * - return string where price is not set.
 * - Return string for "zero" price
 * - return _monthly price in price function.
 * ---- if billing cycle is all, return all durations with prices.
 * //$all_billing_cycles = [ "monthly", "quarterly", "semiannually", "annually", "biennially", "triennially" ];
 */

$WHMPress = new WHMPress();
$lang = $WHMPress->get_current_language();
$extend = empty($lang) ? "" : "_" . $lang;

$zero_override_string = esc_attr(get_option('zero_override' . $extend, "Free"));
$not_configured_override_string = esc_attr(get_option('not_configured_override' . $extend, "N/A"));
$onetime_override_string = esc_attr(get_option('onetime_override' . $extend, "One Time"));


if (!function_exists("whmp_price_i")) {
    function whmp_price_i($args = [])
    {

        global $wpdb;
        global $zero_override_string;
        global $not_configured_override_string;

        $id = (isset($args['id'])) ? $args['id'] : '0';
        $billingcycle = (isset($args['billingcycle'])) ? $args['billingcycle'] : '0';
        $currency_id = (isset($args['currency_id'])) ? $args['currency_id'] : whmp_get_current_currency_id_i();
        $include_setup = (isset($args['include_setup'])) ? $args['include_setup'] : get_option('include_setup_price', 'no');
        $price_type = (isset($args['price_type'])) ? $args['price_type'] : get_option('price_type', 'no');
        $configurable_options = (isset($args['configurable_options'])) ? $args['configurable_options'] : get_option("calculate_configurable_price", 'no');
        $price_tax = (isset($args['price_tax'])) ? $args['price_tax'] : get_option('price_tax', 'default');
        $decimals = (isset($args['decimals'])) ? $args['decimals'] : intval(esc_attr(get_option('default_decimal_places', "2")));

        $sudo_monthly = (isset($args['sudo_monthly'])) ? $args['sudo_monthly'] : "no";

        $message = $sudo_monthly_price = "";
        $price = -1;
        $product_exist = false;

        if (strtolower($include_setup) == 'yes') {
            $price_type = 'total';
        }

        $currency_info = whmp_get_currency_info_i();

        if ($id == '' || $id == '0')                        //return minimum available price
        {
            $price = null;
            $message = __("Service/Product id not provided", "whmpress");
        } else {
            // check if id exists in products table
            $Q = "SELECT `id` FROM `" . whmp_get_products_table_name() . "` WHERE `id`='{$id}' ";
            $myid = $wpdb->get_var($Q);
            if (isset($myid)) {
                $product_exist = true;
            } else {
                $price = null;
                $message = __("Product with this ID does not exist.", "whmpress");
            }
        }


        if ($product_exist == true) {
            if ($billingcycle == '' || $billingcycle == '0')    //return minimum available price
            {
                $billingcycle = "min";
            }

            // lets get all durations for this id
            $Q = "SELECT `paytype`,`monthly`, `quarterly`, `semiannually`, `annually`, `biennially`, `triennially`,`msetupfee`, `qsetupfee`, `ssetupfee`, `asetupfee`, `bsetupfee`, `tsetupfee`, `tax` FROM `" . whmp_get_pricing_table_name() . "` prc,`" . whmp_get_products_table_name() . "` prds WHERE prds.`id`='{$id}' AND prc.`relid`='{$id}' AND prc.`currency`='{$currency_id}' AND prc.`type`='product'";
            $row = $wpdb->get_row($Q, ARRAY_A);


            if (strtolower($row["paytype"]) == "free") {      // Free
                $price = $zero_override_string;
                $message = "1";
            } else if ($row["paytype"] == "onetime") {
                $price = $row["monthly"];           // it is one time

                $message = "1";
            } else {                                      // recurring
                // it is recurring amount, calculate according to billing "min", "all" or "billingcycle" below
            }


            $paytype = $row["paytype"];

            /*
             * --- MIN billingcycle
             */
            $tmp = $row;
            unset($tmp['paytype']);
            unset($tmp['msetupfee']);
            unset($tmp['qsetupfee']);
            unset($tmp['ssetupfee']);
            unset($tmp['asetupfee']);
            unset($tmp['bsetupfee']);
            unset($tmp['tsetupfee']);
            unset($tmp['tax']);
            $just_price = $tmp;

            if ($billingcycle == "min" && $row["paytype"] == "recurring") {
                foreach ($just_price as $value) {
                    if ($value > 0) {
                        $billingcycle = key($just_price); // it is return key for next element.
                        $price = $value;
                        $message = "1";
                        break;
                    }
                }
                if ($billingcycle == 'min') {
                    $billingcycle = 'monthly';
                }
                if (floatval($price) < 0) {
                    $message = "Price is not configured for any billing cycle for currency:";
                }
            } /*
		 * ALL billingcycles
		 */
            else if ($billingcycle == "all" && $row["paytype"] == "recurring") {
                $price = $just_price;
                $message = "1";
            } /*
	 * Given billingcycle
	 */
            else if ($row["paytype"] == "recurring") {
                $price = $row[$billingcycle];
                if (floatval($price) >= 0) {
                    $message = "1";
                } else {
                    $message = "Price not configured for currency:" . $currency_info["code"] . " billing cycle:" . $billingcycle;
                }

            }
            //ppa( $billingcycle );
            if ($billingcycle != "all")
                //~---- Three steps to perform before returning price
                // 1. adjust price-type
            {
                $sudo_price["sudo_price"] = 0;
                $sudo_price["sudo_price_reason"] = "";

                if ($sudo_monthly == "yes") {
                    $sudo_price = whmp_sudo_monthly_price_i($price, $billingcycle);

                    //process desimals accordingly just for sudo price here, why?

                    /*                $tmp = whmp_format_price_i(
                                        [
                                            'price' => $sudo_price["sudo_price"],
                                            'currency_id' => $currency_id,
                                        ]
                                    );*/
                    $billingcycle = whmp_convert_billingcycle_i($billingcycle);
                    //$sudo_price["sudo_price"]        = number_format( $sudo_price["sudo_price"], $decimals );
                    $sudo_price["sudo_price_reason"] = esc_html__("*when ordered ", "whmpress") . " " . $billingcycle;

                }

                if (strtolower(trim($price_type)) == "setup") {
                    $price = $row[substr($billingcycle, 0, 1) . "setupfee"];
                } else if (strtolower(trim($price_type)) == "total" || strtolower(trim($price_type)) == "both") {
                    //== convert string into lower string as Asetupfee is not defined but asetupfee
                    $price += $row[strtolower(substr($billingcycle, 0, 1)) . "setupfee"];
                }


                // 2. calculate configurable options
                if ($configurable_options == "yes") {
                    $config_options_price = whmp_configurable_price_i($id, $billingcycle, $currency_id);
                    $price = (float)$price + (float)$config_options_price;
                }

                // 3. calculate tax
                if ($price_tax == "default") {
                    //default=WHMCS default, so price will be returned as its.
                } else {
                    //Do Tax claculations
                    $TaxEnabled = false;
                    # Calculating tax.
                    $TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");
                    $tax_amount = $base_price = 0;
// If product tax is enabled and Configuration tax is enabled then execute these codes.
                    if (strtolower($TaxEnabled) == "on" && $row["tax"] == "1") {
                        $TaxType = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxType'");
                        $TaxL2Compound = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxL2Compound'");

                        $level1_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='1' AND `country`='' ORDER BY `id`");
                        $level1_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='2' AND `country`='' ORDER BY `id`");

                        $tmp = whmpress_calculate_tax($price);
                        $price = $tmp['base_price'] + $tmp['tax_amount'];
                    }


                    /*if ( $TaxType=="Exclusive") {
            $tax_amount = $price * ($level1_rate / 100);
            $base_price = $price;
            } elseif ( $TaxType=="Inclusive") {
            $tax_amount = ($price / (100 + $level1_rate )) * $level1_rate;
            $base_price = $price - $tax_amount;
            }

            if (!empty($level2_rate)) {
            if ( strtolower($TaxL2Compound)=="on")
                $price2 = $tax_amount + $base_price;
            else
                $price2 = $base_price;

            $tax2_amount = 0;
            if ( $TaxType=="Exclusive") {
                $tax2_amount = $price2 * ($level2_rate / 100);
            } elseif ( $TaxType=="Inclusive") {
                $tax2_amount = ($price2 / (100 + $level2_rate )) * $level2_rate;
            }
            $tax_amount += $tax2_amount;
            }*/


                }

                //4. Set billing cycle
                if ($paytype == "onetime") {
                    $billingcycle = "onetime";
                }
            }


        }   //--end valid product
        $output = [
            'id' => $id,               //service id
            'price' => $price,            //raw price
            'currency_id' => $currency_id,
            'paytype' => $paytype,    //
            'billingcycle' => $billingcycle,     //billingcycle
            'message' => $message,  //return 1 in case of success
        ];
        if (isset($sudo_price)) {
            $output = array_merge($output, $sudo_price);
        }
        return $output;
    }
}
/*
 * Format raw price based on currency
 * returns, formated price and its parts
 */

if (!function_exists("whmp_format_price_i")) {
    function whmp_format_price_i($args = [])
    {

        global $WHMPress;
        global $wpdb;
        global $zero_override_string;
        global $not_configured_override_string;
        $price = (isset($args['price'])) ? ($args['price']) : '0';
        $numeric_price = $price;
        $paytype = (isset($args['paytype'])) ? $args['paytype'] : 'recurring';
        $currency_id = (isset($args['currency_id'])) ? $args['currency_id'] : whmp_get_current_currency_id_i();

        $decimals = (!empty($args['decimals'])) ? $args['decimals'] : intval(esc_attr(get_option('default_decimal_places', "2")));
        $decimals = (int)$decimals;

        //$no_of_months = (isset($args['no_of_months'])) ? $args['no_of_months'] : "";

        $decimal_separator = (isset($args['decimal_separator'])) ? $args['decimal_separator'] : $WHMPress->get_currency_decimal_separator($currency_id);
        $thousand_separator = (isset($args['thousand_separator'])) ? $args['thousand_separator'] : $WHMPress->get_currency_thousand_separator($currency_id);

        $message = "0";
        # Setting decimals for price
        if (get_option("show_trailing_zeros") == "yes") {
            if (is_numeric($price)) {
                $price = number_format($price, $decimals, $decimal_separator, $thousand_separator);
                $message = "1";
            }
        } else {
            //echo "trailing no".$price;
            $sprice = $price;
            $price = round($price, $decimals);
            $price = number_format($price, $decimals, $decimal_separator, $thousand_separator);

            if (whmp_is_trailing_zeros($sprice, $decimals)) {
                if ($decimals > 0) {
                    $num = -1 * ($decimals + 1);
                    $price = substr($price, 0, $num);         //remove trailing zeros
                    $message = '1';
                }
            }
        }

        $tmp = explode((string)$decimal_separator, $price);
        $amount = $tmp[0];
        $fraction = isset($tmp[1]) ? $tmp[1] : "";


        if ($price < 0) {
            $amount = $not_configured_override_string;
            $fraction = '';
            $decimal_separator = '';
        }
        if ($paytype == 'free') {
            $amount = $zero_override_string;
            $fraction = '';
            $decimal_separator = '';
        }

        $output = [
            'price' => $price,            //formated price
            'numeric_price' => $numeric_price,
            'amount' => $amount,           //formated amount
            'fraction' => $fraction,         //fraction
            'decimal_separator' => $decimal_separator,
            'thousand_separator' => $thousand_separator,
            'message' => $message,  //return 1 in case of success
        ];


        return $output;
    }
}
/*
 * Adds currency symbol and duration
 * * - consider starting from, how to handle it, may be in a function.
 *
 */

if (!function_exists("whmp_format_price_essentials_i")) {
    function whmp_format_price_essentials_i($args = [])
    {

        global $zero_override_string;
        global $onetime_override_string;
        global $not_configured_override_string;

        $sudo_monthly = false;
        if (isset($args['no_of_months'])) {
            if ($args['no_of_months'] == "yes") {
                $sudo_monthly = true;
            }
        }


        $price = $args['price']['price'];

        if ($sudo_monthly) {
            $billingcycle = "monthly";
        } else {
            $billingcycle = (isset($args['billingcycle'])) ? $args['billingcycle'] : '0';
        }


        $paytype = (isset($args['paytype'])) ? $args['paytype'] : 'recurring';
        $currency_id = (isset($args['currency_id'])) ? $args['currency_id'] : whmp_get_current_currency_id_i();
        $currency_symbol = (isset($args['currency_symbol'])) ? $args['currency_symbol'] : whmpress_get_option("default_currency_symbol");

        $duration_connector = (isset($args['duration_connector'])) ? $args['duration_connector'] : esc_attr(get_option('default_currency_duration_connector', "/"));
        $duration_style = (isset($args['duration_style'])) ? $args['duration_style'] : esc_attr(get_option('default_currency_duration_style'));
        $message = "0";

        /** todo: We have 6 function,
         * whmp_get_default_currency_preffix x 3
         * whmp_get_currency_preffix x3
         * These are redundent, and should be moved into 1
         */
        $numeric_price = isset($args['price']['numeric_price']) ? $args['price']['numeric_price'] : numeric($price);
        $prefix = $suffix = "";
        $currency_info = whmp_get_currency_info_i($currency_id);

        if ($currency_symbol == "prefix") {
            $prefix = $currency_info['prefix'];
        } else if ($currency_symbol == "suffix") {
            $suffix = $currency_info['suffix'];
        } else if ($currency_symbol == "code") {
            $prefix = $currency_info['code'];
        } else if ($currency_symbol == "both") {
            $prefix = $currency_info['prefix'];
            $suffix = $currency_info['suffix'];
        }


        $price = $prefix . $price . $suffix;
        if ($duration_style == 'none') {
            $duration = '';
        } else {
            $duration = whmp_convert_billingcycle_i($billingcycle, $duration_style);

        }

        if ($duration_style == "duration") {
            $duration = " " . $duration;
        } else {
            $duration = " " . $duration_connector . $duration;
        }

        if (strtolower($paytype) == 'free' || $price == '0') {
            $prefix = '';
            $suffix = '';
            $duration = '';
            $price = $zero_override_string;
        }
        if ($numeric_price < 0) {
            $prefix = '';
            $suffix = '';
            $duration = '';
            $price = $not_configured_override_string;
        }
        if ($paytype == 'onetime' && $duration_style != 'none') {
            $duration = ' ' . $onetime_override_string;
        }

        $price = $price . $duration;

        $output = [
            'price' => $price,            //price with symbol and duration
            'prefix' => $prefix,
            'suffix' => $suffix,
            'duration' => $duration,         //duration
            'message' => '1'  //return 1 in case of success
        ];

        return $output;
    }
}
if (!function_exists("whmp_format_price_essentials_specific")) {
    function whmp_format_price_essentials_specific($args = [])
    {

        global $zero_override_string;
        global $onetime_override_string;
        global $not_configured_override_string;

        $sudo_monthly = false;
        if (isset($args['no_of_months'])) {
            if ($args['no_of_months'] == "yes") {
                $sudo_monthly = true;
            }
        }


        $price = $args['price']['price'];

        if ($sudo_monthly) {
            $billingcycle = "monthly";
        } else {
            $billingcycle = (isset($args['billingcycle'])) ? $args['billingcycle'] : '0';
        }


        $paytype = (isset($args['paytype'])) ? $args['paytype'] : 'recurring';
        $currency_id = (isset($args['currency_id'])) ? $args['currency_id'] : whmp_get_current_currency_id_i();
        $currency_symbol = (isset($args['currency_symbol'])) ? $args['currency_symbol'] : whmpress_get_option("default_currency_symbol");

        $duration_connector = (isset($args['duration_connector'])) ? $args['duration_connector'] : esc_attr(get_option('default_currency_duration_connector', "/"));
        $duration_style = (isset($args['duration_style'])) ? $args['duration_style'] : esc_attr(get_option('default_currency_duration_style'));
        $message = "0";

        /** todo: We have 6 function,
         * whmp_get_default_currency_preffix x 3
         * whmp_get_currency_preffix x3
         * These are redundent, and should be moved into 1
         */
        $numeric_price = isset($args['price']['numeric_price']) ? $args['price']['numeric_price'] : numeric($price);
        $prefix = $suffix = "";
        $currency_info = whmp_get_currency_info_i($currency_id);

        if ($currency_symbol == "prefix") {
            $prefix = $currency_info['prefix'];
        } else if ($currency_symbol == "suffix") {
            $suffix = $currency_info['suffix'];
        } else if ($currency_symbol == "code") {
            $prefix = $currency_info['code'];
        } else if ($currency_symbol == "both") {
            $prefix = $currency_info['prefix'];
            $suffix = $currency_info['suffix'];
        }


        $price = $price;
        if ($duration_style == 'none') {
            $duration = '';
        } else {
            $duration = whmp_convert_billingcycle_i($billingcycle, $duration_style);

        }

        if ($duration_style == "duration") {
            $duration = " " . $duration;
        } else {
            $duration = " " . $duration_connector . $duration;
        }

        if (strtolower($paytype) == 'free' || $price == '0') {
            $prefix = '';
            $suffix = '';
            $duration = '';
            $price = $zero_override_string;
        }
        if ($numeric_price < 0) {
            $prefix = '';
            $suffix = '';
            $duration = '';
            $price = $not_configured_override_string;
        }
        if ($paytype == 'onetime' && $duration_style != 'none') {
            $duration = ' ' . $onetime_override_string;
        }

        $price = $price;

        $output = [
            'price' => $price,            //price with symbol and duration
            'prefix' => $prefix,
            'suffix' => $suffix,
            'duration' => $duration,         //duration
            'message' => '1'  //return 1 in case of success
        ];

        return $output;
    }
}

if (!function_exists("whmp_convert_billingcycle_i")) {
    function whmp_convert_billingcycle_i($billingcycle, $style = "duration", $connector = "")
    {
        /**todo: take duration style in settings, suggested
         * duration connector:
         * none=blank
         * / = per
         * per = per2
         *
         * duration style:
         * Default = duration
         * Long (year) = long
         * Short (yr) = short
         * Convert to Months (12 month) = monthly
         */

        $valid_billing_cycles = [
            "onetime",
            "monthly",
            "quarterly",
            "semiannually",
            "annually",
            "biennially",
            "triennially"
        ];

        $valid_styles = ["months", "duration", "duration2", "long", "short", "monthly"];
        $style = (in_array($style, $valid_styles)) ? $style : "duration";

        if (in_array($billingcycle, $valid_billing_cycles) == true) {

            $map = [
                "onetime" => [
                    "months" => 0,
                    "duration" => esc_html__("OneTime", "whmpress"),
                    "duration2" => esc_html__("Pay Once", "whmpress"),
                    "long" => esc_html__("One Time", "whmpress"),
                    "short" => esc_html__("OT", "whmpress"),
                    "monthly" => esc_html__("One Time", "whmpress"),
                ],

                "monthly" => [
                    "months" => 1,
                    "duration" => esc_html__("Monthly", "whmpress"),
                    "duration2" => esc_html__("1 month", "whmpress"),
                    "long" => esc_html__("Month", "whmpress"),
                    "short" => esc_html__("mo", "whmpress"),
                    "monthly" => esc_html__("1 Month", "whmpress"),
                ],

                "quarterly" => [
                    "months" => 3,
                    "duration" => esc_html__("Quarterly", "whmpress"),
                    "duration2" => esc_html__("3 month", "whmpress"),
                    "long" => esc_html__("Quarter", "whmpress"),
                    "short" => esc_html__("qu", "whmpress"),
                    "monthly" => esc_html__("3 Months", "whmpress"),
                ],

                "semiannually" => [
                    "months" => 6,
                    "duration" => esc_html__("Semi Annually", "whmpress"),
                    "duration2" => esc_html__("6 month", "whmpress"),
                    "long" => esc_html__("Half year", "whmpress"),
                    "short" => esc_html__("sa", "whmpress"),
                    "monthly" => esc_html__("6 Months", "whmpress"),
                ],

                "annually" => [
                    "months" => 12,
                    "duration" => esc_html__("Annually", "whmpress"),
                    "duration2" => esc_html__("1 year", "whmpress"),
                    "long" => esc_html__("Year", "whmpress"),
                    "short" => esc_html__("yr", "whmpress"),
                    "monthly" => esc_html__("12 Months", "whmpress"),
                ],

                "biennially" => [
                    "months" => 24,
                    "duration" => esc_html__("Biennially", "whmpress"),
                    "duration2" => esc_html__("2 Year", "whmpress"),
                    "long" => esc_html__("2 Years", "whmpress"),
                    "short" => esc_html__("2 yrs", "whmpress"),
                    "monthly" => esc_html__("24 Months", "whmpress"),
                ],

                "triennially" => [
                    "months" => 36,
                    "duration" => esc_html__("Triennially", "whmpress"),
                    "duration2" => esc_html__("3 Year", "whmpress"),
                    "long" => esc_html__("3 Years", "whmpress"),
                    "short" => esc_html__("3 yrs", "whmpress"),
                    "monthly" => esc_html__("36 Months", "whmpress"),
                ]
            ];

            return $map[$billingcycle][$style];

        } else {

            $error_message = esc_html__('Invalid billing cycle', "whmpress");

            return $error_message;
        }
    }
}

if (!function_exists("whmp_get_currency_info_i")) {
    function whmp_get_currency_info_i($id = "", $type = "all")
    {
        global $wpdb;
        global $WHMPress;

        if (!$WHMPress->WHMpress_synced()) {
            return '';
        }
        if ($id == "" || $id == "0" || $id == 0) {
            $id = whmp_get_current_currency_id_i();
        }
        $Q = "SELECT * FROM `" . whmp_get_currencies_table_name() . "` WHERE (`id`='$id' OR `code`='$id')";
        $row = $wpdb->get_row($Q, ARRAY_A);

        if (empty($row)) {
            //some thing very wrong
        }

        $prefix = $row['prefix'];
        //if there is a lungage base overide, get it.
        $alter = get_option("whmpress_currencies_" . trim($prefix) . "_prefix_" . $WHMPress->get_current_language());
        if (empty($alter)) {

        } else {
            return $prefix = $alter;
        }

        $suffix = $row['suffix'];
        $code = $row['code'];
        $decimal_separator = $WHMPress->get_currency_decimal_separator($id);
        $thousand_separator = $WHMPress->get_currency_thousand_separator($id);

        $output = [
            'id' => $id,
            'prefix' => $prefix,
            'suffix' => $suffix,
            'code' => $code,
            'decimal_separator' => $decimal_separator,
            'thousand_separator' => $thousand_separator
        ];

        if ($type == "all") {
            return $output;
        } else {
            return $output[$type];
        }

    }
}

if (!function_exists("wwhmp_configurable_price_i")) {
    function whmp_configurable_price_i($id, $billingcycle, $currency)
    {
        global $wpdb;
        # Getting price from configureable options.
        if ($billingcycle == 'min') {
            $billingcycle = 'monthly';
        }
        $config_price = null;
        if (whmp_is_table_exists(get_mysql_table_name("tblpricing")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfiglinks")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfigoptions")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfigoptionssub"))) {
            $Q = "SELECT SUM(`price`) FROM
        (SELECT MIN(`{$billingcycle}`) price, abc.configid  FROM `" . get_mysql_table_name("tblpricing") . "`,
        
        
        (SELECT tpcos.`configid`, tpcos.id id FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, 
        `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE 
        (tpco.optiontype='1' OR tpco.optiontype='2') AND
        p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}') abc
        
        WHERE `type`='configoptions' AND `currency`='{$currency}' AND `relid` IN
        (SELECT tpcos.id relid FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE `relid`='{$id}' AND p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}')
        
        AND abc.id=`relid`
        GROUP BY `configid`) theR";

            $config_price1 = $wpdb->get_var($Q);

            $Q = "SELECT SUM(`price`*qtyminimum ) FROM
        (SELECT MIN(`{$billingcycle}`) price, abc.configid, abc.qtyminimum FROM `" . get_mysql_table_name("tblpricing") . "`,
        
        (SELECT tpco.qtyminimum, tpcos.`configid`, tpcos.id id FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, 
        `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE 
        p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}' AND `optiontype`='4') abc
        
        WHERE `type`='configoptions' AND `currency`='{$currency}' AND `relid` IN
        (SELECT tpcos.id relid FROM `" . get_mysql_table_name("tblpricing") . "` p, `" . get_mysql_table_name("tblproductconfiglinks") . "` pcl, `" . get_mysql_table_name("tblproductconfigoptions") . "` tpco, `" . get_mysql_table_name("tblproductconfigoptionssub") . "` tpcos WHERE `relid`='{$id}' AND p.`type`='product' AND p.relid=pid AND pcl.gid=tpco.gid AND tpco.id=tpcos.configid AND p.currency='{$currency}' AND `optiontype`='4')
        
        AND abc.id=`relid`
        GROUP BY `configid`) theR";

            $config_price2 = $wpdb->get_var($Q);

            $config_price = $config_price1 + $config_price2;

            return $config_price;
        }
    }
}

if (!function_exists("whmp_sudo_monthly_price_i")) {
    function whmp_sudo_monthly_price_i($price, $billingcycle)
    {
        // get months in this billing cycle
        $months = whmp_convert_billingcycle_i($billingcycle, "months");
        $price = $price / $months;
        $sudo_monthly = [
            "no_of_months" => $months,
            "sudo_price" => $price,
        ];

        return $sudo_monthly;
    }
}

if (!function_exists("whmp_get_current_currency_id_i")) {
    function whmp_get_current_currency_id_i()
    {
        global $wpdb;
        $CSC = whmp_tf(get_option("whmpress_auto_change_currency_according_to_country"));

        $combo_hit_flag = isset($_SESSION["combo_hit_rate"]) ? $_SESSION["combo_hit_rate"] : "";
        if (!empty($_SESSION["whcom_current_currency_id"])) {
            if ($CSC) {
                //get current user country
                if ($combo_hit_flag == 1) {
                    $currency = $_SESSION["whcom_current_currency_id"];
                } else {
                    $country_code = whmp_ip_to_country();
                    $currency = whmp_country_to_currency($country_code);
                }
            } else {
                $currency = $_SESSION["whcom_current_currency_id"];
            }

            $currency = isset($_GET['cur']) ? $_GET['cur'] : $currency;
            if (!(is_numeric($currency))) {
                $Q = "SELECT `id` FROM `" . whmp_get_currencies_table_name() . "` WHERE `code`= '$currency'";
                $currency = $wpdb->get_results($Q);
                $currency = $currency[0]->id;
            }
        } else {
            if ($CSC) {
                //get current user country
                $country_code = whmp_ip_to_country();
                $currency = whmp_country_to_currency($country_code);

            } else {
                if (isset($_SESSION["whcom_current_currency_id"]) && $_SESSION["whcom_current_currency_id"] != '') {
                    $currency = $_SESSION["whcom_current_currency_id"];
                    if (!(is_numeric($currency))) {
                        $Q = "SELECT `id` FROM `" . whmp_get_currencies_table_name() . "` WHERE `code`=" . $currency;
                        $currency = $wpdb->get_results($Q);
                        /*ppa($currency);*/
                    }
                } else {
                    $currency = whmp_get_default_currency_id();
                }

            }

            if (isset ($_GET['cur'])) {
                $currency = $_GET['cur'];
                if (!(is_numeric($currency))) {
                    $Q = "SELECT `id` FROM `" . whmp_get_currencies_table_name() . "` WHERE `code`= '$currency'";
                    $currency = $wpdb->get_results($Q);
                    $currency = $currency[0]->id;
                }
            }

            $_SESSION["whcom_current_currency_id"] = $currency;
            $_SESSION["whcom_currency"] = $currency;;

        }

        return $currency;

    }
}

if (!function_exists("whmp_domain_price_i")) {
    function whmp_domain_price_i($args)
    {

        $defaults = [
            "extension" => "",
            "years" => "1",
            "price_type" => "register",
            "currency" => "",
            "process_tax" => "0",
            "slabs" => "0"
        ];
        $tmp = wp_parse_args($args, $defaults);
        extract($tmp);

        $years = (int)$years;

        if ($years > 10) {
            $years = 10;
        }

        $currency = $tmp['currency'];
        //== commented because currency was no switching when changing from shortcode parameter
        //$currency = whmp_get_current_currency_id_i();


        if (empty($currency)) {
            $currency = whmp_get_current_currency_id_i();
        }


        $price_type = strtolower($price_type);
        if ($price_type == "renew" || $price_type == "domainrenew" || $price_type == "new") {
            $price_type = "domainrenew";
        } else if ($price_type == "transfer" || $price_type == "domaintransfer") {
            $price_type = "domaintransfer";
        } else {
            $price_type = "domainregister";
        }


        $YearColumn = [
            "1" => "msetupfee",
            "2" => "qsetupfee",
            "3" => "ssetupfee",
            "4" => "asetupfee",
            "5" => "bsetupfee",
            "6" => "monthly",
            "7" => "quarterly",
            "8" => "semiannually",
            "9" => "annually",
            "10" => "biennially",
        ];

        //== Important note
        $slabs = 'tsetupfee';


        global $wpdb;

        $extension = "." . (ltrim($extension, "."));


        $Q = "SELECT * FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid`
			AND `extension`='$extension'
			AND `type`='$price_type' AND `currency`='$currency' AND `tsetupfee`='$slabs'";


        $price_all = $wpdb->get_row($Q, ARRAY_A);


        If ($years > 0) {

            $price = $price_all[$YearColumn[$years]];


            if (is_null($price) || $price === false) {
                return "0";                 // return N/A stuff here.
            }

            if (!isset($price_tax)) {
                $price_tax = "";
            }

            if ($process_tax == "1" || $process_tax === true || strtolower($process_tax) == "yes") {
                # Calculating tax.
                $TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");
                $TaxDomains = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxDomains'");

                $tax_amount = $base_price = $price;
                if (strtolower($TaxEnabled) == "on" && strtolower($TaxDomains) == "on") {
                    $taxes = whmpress_calculate_tax($price);
                    $base_price = $taxes["base_price"];
                    $tax_amount = $taxes["tax_amount"];

                    if ($price_tax == "default") {
                        $price_tax = "";
                    }
                    $price_tax = trim(strtolower($price_tax));

                    if ($price_tax == "exclusive") {
                        $price = $base_price;
                    } else if ($price_tax == "inclusive") {
                        $price = $base_price + $tax_amount;
                    } else if ($price_tax == "tax") {
                        $price = $tax_amount;
                    }
                }
            }

            return $price;
        } else if ($years == 0) {
            $price_years =
                [
                    "1" => $price = $price_all[$YearColumn['1']],
                    "2" => $price = $price_all[$YearColumn['2']],
                    "3" => $price = $price_all[$YearColumn['3']],
                    "4" => $price = $price_all[$YearColumn['4']],
                    "5" => $price = $price_all[$YearColumn['5']],
                    "6" => $price = $price_all[$YearColumn['6']],
                    "7" => $price = $price_all[$YearColumn['7']],
                    "8" => $price = $price_all[$YearColumn['8']],
                    "9" => $price = $price_all[$YearColumn['9']],
                    "10" => $price = $price_all[$YearColumn['10']],
                ];

            foreach ($price_years as $key => $p) {
                if (empty($p) || ($p < 0)) {
                    unset($price_years[$key]);
                } else {
                    if ($key == 1) {
                        $duration = 'for ' . $key . ' Year';
                    } else {
                        $duration = 'for ' . $key . ' Years';
                    }
                    $price_years[$key] = [
                        'price' => $p,
                        'duration' => $duration,
                    ];
                }
            }

            return $price_years;
        }

    }
}

if (!function_exists("whmp_is_tax_enabled")) {
    function whmp_is_tax_enabled()
    {
        global $wpdb;
        $TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");

        return ($TaxEnabled == "on") ? true : false;

    }
}

if (!function_exists("whmp_tfc")) {
    function whmp_tfc($param)
    {
        //function return true for 1, YES, TRUE

        $value = false;
        if (isset($param)) {
            $param = strtolower(trim($param));
            if ($param == "1" || $param == "yes" || $param == "true") {
                $value = true;
            }
        }

        return $value;
    }
}
/*$defaults = [
	"extension"   => "com.pk",
	"years"       => "0",
	"price_type"  => "register",
	"currency"    => "1",
	"process_tax" => "0",
];
*/

if (!function_exists("whmp_format_domain_price_essentials_i")) {
    function whmp_format_domain_price_essentials_i($args = [])
    {


        $price = (isset($args['price'])) ? $args['price'] : '0'; //todo: floatval is not returing good price
        $years = (isset($args['years'])) ? $args['years'] : '1';
        $currency_id = (isset($args['currency_id'])) ? $args['currency_id'] : whmp_get_current_currency_id_i();
        $currency_symbol = (isset($args['currency_symbol'])) ? $args['currency_symbol'] : whmpress_get_option("default_currency_symbol");
        $billingcycle = (isset($args['billingcycle'])) ? $args['billingcycle'] : '0';
        $duration_connector = (isset($args['duration_connector'])) ? $args['duration_connector'] : esc_attr(get_option('default_currency_duration_connector', "/"));
        $duration_style = (isset($args['duration_style'])) ? $args['duration_style'] : esc_attr(get_option('default_currency_duration_style'));
        $message = "0";

        $duration_style = ($duration_style == "long") ? $duration_style : "short";

        /** todo: We have 6 function,
         * whmp_get_default_currency_preffix x 3
         * whmp_get_currency_preffix x3
         * These are redundent, and should be moved into 1
         */
        $prefix = $suffix = "";
        $currency_info = whmp_get_currency_info_i($currency_id);

        if ($currency_symbol == "prefix") {
            $prefix = $currency_info['prefix'];
        } else if ($currency_symbol == "suffix") {
            $suffix = $currency_info['suffix'];
        } else if ($currency_symbol == "code") {
            $prefix = $currency_info['code'];
        } else if ($currency_symbol == "both") {
            $prefix = $currency_info['prefix'];
            $suffix = $currency_info['suffix'];
        }


        $price = $prefix . $price . $suffix;
        $duration = whmp_convert_billingcycle_i($billingcycle, $duration_style);

        //$s_string = ( $years == "1" ) ? "" : "s";
        $s_string = "";


        if ($duration_style == "duration") {
            $duration = " " . $duration;
        } else {
            $duration = " " . $duration_connector . $years . " " . $duration . $s_string;
        }


        $price = $price . $duration;

        $output = [
            'price' => $price,            //price with symbol and duration
            'prefix' => $prefix,
            'suffix' => $suffix,
            'duration' => $duration,         //duration
            'message' => '1'  //return 1 in case of success
        ];

        return $output;
    }
}

/*
 * Adds currency symbol and duration
 * * - consider starting from, how to handle it, may be in a function.
 *
 */

if (!function_exists("whmpress_tlds_i")) {
    function whmpress_tlds_i($args)
    {
        $show_tlds = ($args['show_tlds'] == '') ? '' : $args['show_tlds'];
        $show_tlds_wildcard = (isset($args['show_tlds_wildcard'])) ? $args['show_tlds_wildcard'] : '';
        $currency = ($args['currency'] == '') ? whmp_get_current_currency_id_i() : $args['currency'];

        global $wpdb;
        global $WHMPress;
        $return_data = [];

        $Q = "SELECT `dpt`.id, `extension`";
        $Q .= ", `msetupfee`, `qsetupfee`, `type` FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid` AND
    ((`type`='domainregister') OR (`type`='domainrenew') OR (`type`='domaintransfer')) AND `currency`=" . $currency;

        if (trim($show_tlds) <> "") {
            $show_tlds = $show_tlds_bk = explode(",", $show_tlds);
            $show_tlds = "'" . implode("','", $show_tlds) . "'";
            $Q .= " AND `extension` IN (" . $show_tlds . ")";
        } else if (trim($show_tlds_wildcard) <> "") {
            $Q .= " AND `extension` LIKE '%" . $show_tlds_wildcard . "%'";
        }

        $Q .= " ORDER BY `order`";

        $rows = $wpdb->get_results($Q, ARRAY_A);
        $c = 0;
        foreach ($rows as $row) {
            $rows[$c]['details'] = $WHMPress->get_domain_additional_data($row['id']);
            $c++;
        }
        unset($c);

        $tlds_array = array_column($rows, 'extension');
        $tlds_array = array_unique($tlds_array);


        if ($show_tlds <> "") {
            $tmp_tlds = $tlds_array;
            $tlds_array = [];
            foreach ($show_tlds_bk as $show_tld) {
                foreach ($tmp_tlds as $tmp_tld) {
                    if ($tmp_tld == $show_tld) {
                        $tlds_array[] = $tmp_tld;
                    }
                }
            }

            $tmp_rows = $rows;
            $rows = [];
            foreach ($show_tlds_bk as $show_tld) {
                foreach ($tmp_rows as $tmp_row) {
                    if ($tmp_row['extension'] == $show_tld) {
                        $rows[] = $tmp_row;
                    }
                }
            }
        }

        $return_data['rows'] = $rows;
        $return_data['tlds_array'] = $tlds_array;

        return $return_data;

    }
}

if (!function_exists("whmp_domain_price_restore_i")) {
    function whmp_domain_price_restore_i($id)
    {
        global $wpdb;
        $tbl = whmp_get_domainpricing_table_name();

        $Q = "SELECT * FROM `$tbl` WHERE id=$id";
        $row = $wpdb->get_results($Q, ARRAY_A);

        $tmp = [
            "grace_period" => $row[0]["grace_period"],
            "grace_period_fee" => $row[0]["grace_period_fee"],
            "redemption_grace_period" => $row[0]["redemption_grace_period"],
            "redemption_grace_period_fee" => $row[0]["redemption_grace_period_fee"]
        ];

        return $tmp;
    }
}

if (!function_exists("whmpress_calculate_discount")) {
    function whmpress_calculate_discount($discount_array)
    {
        $billing1 = $discount_array["billing_cycle_1"];
        $billing2 = $discount_array["billing_cycle_2"];
        $currency = $discount_array["currency"];
        $product_id = $discount_array["product_id"];
        $type = $discount_array["discount_type"];
        $decimals = $discount_array["decimals"];
        $duration_as = $discount_array["show_duration_as"];

        $discount_string = "";
        $lang = whmpress_get_current_language();
        $discount_string1 = get_option("whmpress_discount_string1_" . $lang);
        $discount_string2 = get_option("whmpress_discount_string2_" . $lang);

        $feature_string1 = get_option("whmpress_feature_string1_" . $lang);
        $feature_string2 = get_option("whmpress_feature_string2_" . $lang);


        // change these to new price functions
        $price1 = whmpress_price_function_i([
            "billingcycle" => $billing1,
            "id" => $product_id,
            "currency" => $currency,
            "no_wrapper" => "1",
            "show_duration" => "no",
            "simple" => "1",
            "prefix" => "no",
            "suffix" => "no"
        ]);


        $price2 = whmpress_price_function_i([
            "billingcycle" => $billing2,
            "id" => $product_id,
            "currency" => $currency,
            "no_wrapper" => "1",
            "show_duration" => "no",
            "simple" => "1",
            "prefix" => "no",
            "suffix" => "no"


        ]);


        $months1 = whmpress_convert_billingcycle($billing1, "months");

        //calculates per month price from price2
        $monthly_price1 = number_format(($price1 / $months1), $decimals);
        $monthly_prce_string1 = $monthly_price1 . whmpress_convert_billingcycle("monthly", $duration_as, "per") . " when paid " . whmpress_convert_billingcycle($billing2, "duration");

        $months2 = whmpress_convert_billingcycle($billing2, "months");
        $monthly_price2 = number_format(($price2 / $months2), $decimals);
        $monthly_prce_string2 = $monthly_price2 . whmpress_convert_billingcycle("monthly", $duration_as, "per") . " when paid " . whmpress_convert_billingcycle($billing2, "duration");
        //echo "months=". $months;

        $discount1 = $discount2 = 0;

        if ($type == "amount") {
            $cost1 = $price1;
            $cost2 = number_format(($price2 / $months2), $decimals);

            $discount1 = 0;
            $discount2 = $cost1 - $cost2;

            //---- discount 1 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2 . whmpress_convert_billingcycle($billing1, "$duration_as", "per");
            $discount_string1 = str_replace("{duration}", $dur, $discount_string1);
            $discount_string1 = str_replace("{discount}", $dis, $discount_string1);

            //---- discount 2 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2 . " " . whmpress_convert_billingcycle($billing1, "$duration_as", "per");
            $discount_string2 = str_replace("{duration}", $dur, $discount_string2);
            $discount_string2 = str_replace("{discount}", $dis, $discount_string2);


            $cost_string1 = "Switch " . whmpress_convert_billingcycle($billing2) . $cost2 . whmpress_convert_billingcycle($billing1, "$duration_as", "per");
            $cost_string2 = "costs " . $cost2 . whmpress_convert_billingcycle($billing1, $duration_as, "per");


            //---- Feature 1 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2 . whmpress_convert_billingcycle($billing1, "$duration_as", "per");
            $temp_array = explode("<br>", $feature_string1);
            $temp = "";
            if (is_array($temp_array) && count($temp_array) > 1) {
                $temp .= '<span class="whmpress_discount_text">' . $temp_array[0] . '</span>';
                $temp .= '<span class="whmpress_discount_value">' . $temp_array[1] . '</span>';
                $feature_string1 = $temp;
            }
            $feature_string1 = str_replace("{duration}", $dur, $feature_string1);
            $feature_string1 = str_replace("{discount}", $dis, $feature_string1);

            //---- Feature 2 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2 . " " . whmpress_convert_billingcycle($billing1, "$duration_as", "per");


            $temp_array = explode("<br>", $feature_string2);
            $temp = "";
            if (is_array($temp_array) && count($temp_array) > 1) {
                $temp .= '<span class="whmpress_discount_text">' . $temp_array[0] . '</span>';
                $temp .= '<span class="whmpress_discount_value">' . $temp_array[1] . '</span>';
                $feature_string2 = $temp;
            }
            $feature_string2 = str_replace("{duration}", $dur, $feature_string2);
            $feature_string2 = str_replace("{discount}", $dis, $feature_string2);


        }

        if ($type == "percentage") {
            $cost1 = $price1;
            $cost2 = number_format(($price2 / $months2), $decimals);


            $cost_string1 = "Switch " . whmpress_convert_billingcycle($billing2) . $cost2 . whmpress_convert_billingcycle($billing1, "$duration_as", "per2");
            $cost_string2 = "costs " . $cost2 . whmpress_convert_billingcycle($billing1, "$duration_as", "per2");

            if ($price1 == 0) {
                $discount2 = "100%";
            } else {
                $discount2 = round(100 - ($price2 / ($price1 * $months2) * 100), 0) . "%";
            }


            $discount1 = $discount2;

            //---- discount 1 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2;
            $discount_string1 = str_replace("{duration}", $dur, $discount_string1);
            $discount_string1 = str_replace("{discount}", $dis, $discount_string1);

            //---- discount 2 -----//

            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2;
            $discount_string2 = str_replace("{duration}", $dur, $discount_string2);
            $discount_string2 = str_replace("{discount}", $dis, $discount_string2);


            //---- Feature 1 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2;
            $temp_array = explode("<br>", $feature_string1);
            $temp = "";
            if (is_array($temp_array) && count($temp_array) > 1) {
                $temp .= '<span class="whmpress_discount_text">' . $temp_array[0] . '</span>';
                $temp .= '<span class="whmpress_discount_value">' . $temp_array[1] . '</span>';
                $feature_string1 = $temp;
            }
            $feature_string1 = str_replace("{duration}", $dur, $feature_string1);
            $feature_string1 = str_replace("{discount}", $dis, $feature_string1);

            //---- Feature 2 -----//
            $dur = whmpress_convert_billingcycle($billing2);
            $dis = $discount2;
            $temp_array = explode("<br>", $feature_string2);
            $temp = "";
            if (is_array($temp_array) && count($temp_array) > 1) {
                $temp .= '<span class="whmpress_discount_text">' . $temp_array[0] . '</span>';
                $temp .= '<span class="whmpress_discount_value">' . $temp_array[1] . '</span>';
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


if (!function_exists("whmpress_get_domain_search_template")) {
    function whmpress_get_domain_search_template($name, $style = "")
    {

        global $WHMPress;

        $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/" . $name . ".tpl";

        if (!is_file($html_template)) {
            $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/" . $name . ".html";
        }

        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/" . $style . "/" . $name . ".tpl";
        }

        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/" . $name . ".html";
        }

        return $html_template;

    }
}

if (!function_exists("whmp_get_whois_servers")) {
    function whmp_get_whois_servers($tld = "")
    {
        $whois_servers = whmpress_get_option("whois_db");
        $whois_servers = explode("\n", $whois_servers);
        $whois_array = [];
        foreach ($whois_servers as $server) {

            $tmp = explode("|", trim($server));
            if (is_array($tmp) && count($tmp) > 2) {
                $tmp[0] = ltrim($tmp[0], ".");
                $whois_array[$tmp[0]] = [
                    "server" => $tmp[1],
                    "match" => $tmp[2]
                ];
            }
        }
        if (trim($tld <> "")) {
            foreach ($whois_array as $key => $info) {
                if ($tld <> $key) {
                    unset ($whois_array[$key]);
                }

            }
        }

        return $whois_array;

    }
}

if (!function_exists("D:\whmpress\whmpress\includes\functions_i.php")) {
    function whmp_filter_whois_servers($whois_servers, $action)
    {

        if (is_array($action)) {
            foreach ($whois_servers as $ext => $server) {

                if (!in_array($ext, $action)) {
                    unset($whois_servers[$ext]);
                }
            }


        } else {
            if ($action == "remove_extra") {
                global $wpdb;
                foreach ($whois_servers as $ext => $server) {
                    $ext_with_dot = "." . $ext;
                    if ($wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "` WHERE `extension`='$ext_with_dot'") == 0) {
                        unset($whois_servers[$ext]);
                    }
                }
            }
        }

        return $whois_servers;

    }
}

if (!function_exists('whmp_get_whmcs_tlds')) {
    function whmp_get_whmcs_tlds()
    {
        $raw_tlds = whmp_get_whois_servers();
        $whmcs_tlds = whmp_filter_whois_servers($raw_tlds, 'remove_extra');

        return $whmcs_tlds;
    }
}


/*if (! function_exists("whmp_print_domain_search_result_a")){
    function whmp_print_domain_search_result_a($smarty_array){
        $Class = "found";
        $HTML = $orders["hidden_form"];
        $HTML .= "
            <div class=\"found-title\">
              <div class=\"domain-name\">$smarty_array['message']</div>";

        if ($_show_price) {
            $HTML .= "<div class=\"rate\">$pricef</div>";
        }

        if ( ($_show_years) && $pricef <> "") {
            $HTML .= "<div class=\"year\">$year</div>";
        }


        $HTML .= "<div class=\"select-box\">
                <a" . $orders["button_action"] . "class=\"buy-button\" href='" . $orders["order_url"] . "'>$register_text</a>
              </div>
              <div style=\"clear:both\"></div>
            </div>";
        return $HTML;

    }
}

if (! function_exists("whmp_print_domain_search_result_na")){
    function whmp_print_domain_search_result_row($smarty_array){
        if ($_transfer_enabled == "yes"){
        $transfer_link = "<a class='www-button' href='" . $orders["order_url"] . "'>";
        $transfer_link .= __("Transfer", "whmpress") . "</a>";
        $transfer_link = "";
    }

        $HTML .= "
            <div class=\"not-found-title\">
              <div class=\"domain-name\">$Message</div>";
        if ($show_price == "1" || strtoupper($show_price) == "YES") {
            $HTML .= "<div class=\"rate\"></div>";
        }

        if ($show_years == "1" || strtoupper($show_years) == "YES") {
            $HTML .= "<div class=\"year\"></div>";
        }

        $HTML .= "<div class=\"select-box\">
                $www_link
                $whois_link
                $transfer_link
              </div>
              <div style='clear:both'></div>
            </div>";
        //-9-Others
        $_insert_data["domain_available"] = "0";

    }
}*/

if (!function_exists("whmp_domain_search_smarty")) {

    function whmp_domain_search_smarty($dom, $params, $result)
    {

        $__smarty["extension"] = $dom["ext"];
        $__smarty["domain_short"] = $dom["short"];
        $__smarty["domain"] = $dom["full"];

        //**-1-Available
        $available = ($result) ? "1" : "0";
        $__smarty["available"] = $available;

        //**-2-Message
        $message_type = ($result) ? "a" : "na";
        $message_type = ($dom["og"]) ? "og_" . $message_type : $message_type;
        $Message = whmp_get_domain_message($message_type, $dom["full"], $dom["short"], $dom["ext"]);
        $__smarty["message"] = $Message;

        //**-3-Price
        $price_type = ($result) ? "domainregister" : "domaintransfer";

        $durations = get_min_years($dom["ext"]);    //minimum Years

        $year = $durations["years"];
        $year_num = $durations["y"];

        if ($year_num > 0) {
            $pm = [
                'extension' => $dom["ext"],
                'years' => $year_num,
            ];

            $pricef = whmp_domain_price_i($pm);

            $temp = whmp_format_price_i([
                'price' => $pricef,
            ]);

            $pricef = $temp["price"];

            $price_essentials = whmp_format_domain_price_essentials_i([
                'price' => $pricef,
                'billingcycle' => "annually",
                'years' => $year_num,
            ]);


            $pricef = $price_essentials["prefix"] . $pricef . " " . $price_essentials["suffix"];


        } else {
            $pricef = "";
            $year = "";
        }
        $__smarty["price"] = $pricef;

        // Price Single


        // Price Multi
        $pm = [
            'extension' => $dom["ext"],
            'years' => 0,
        ];
        $__smarty['multi_price'] = whmp_domain_price_i($pm);

        //-4-Duration
        $__smarty["duration"] = $year;


        //-5-Order URL
        //------array for domain order urls function
        $link_type = ($result) ? "register" : "transfer";
        $arr = [
            "domain_full" => $dom["full"],
            "domain_short" => $dom["short"],
            "extension" => $dom["ext"],
            "type" => $link_type,
            "order_landing_page" => $params["order_landing_page"],
            "order_link_new_tab" => $params["order_link_new_tab"],
            "append_url" => $params["append_url"],
        ];

        //todo:transfer link is broken
        $orders = whmp_get_domain_order_urls($arr);
        $__smarty = array_merge($__smarty, $orders);

        // ---domain is available---
        if ($available) {

            //== Add text of order button for available domains.
            $params['register_text'] = whmpress_get_option('register_domain_button_text');
            if ($params['register_text'] == "") {
                $params['register_text'] = __("Select", "whmpress");
            }
            //-9-Other variables for smarty
            $__smarty["order_landing_page"] = $params["order_landing_page"];
            $__smarty["order_link_new_tab"] = $params["order_link_new_tab"];
            $__smarty["whois_link"] = "";
            $__smarty["order_button_text"] = $params["register_text"];
            $_insert_data["domain_available"] = "1";

            //HTML FUNCTIONS > whmp_print_domain_search_result_available($orders,);

        }

        if (!($available)) {
            //-6-WWW
            if (isset($_POST["www_link"])) {
                $www_link = whmp_get_domain_www_link($_POST["www_link"], $dom["full"]);
            }

            if (isset($_POST["whois_link"])) {
                //-7-WhoIs
                $whois_link = whmp_get_domain_whois($_POST["whois_link"], $dom["full"]);
                $__smarty["whois_link"] = $whois_link;
            }
        }

        return $__smarty;

    }

}

if (!function_exists('whmpress_domain_search_ajax_extended_search_result_details')) {
    function whmpress_domain_search_ajax_extended_search_result_details($dom, $params, $result)
    {
        $__smarty["extension"] = $dom["ext"];
        $__smarty["domain_short"] = $dom["short"];
        $__smarty["domain"] = $dom["full"];

        //**-1-Available
        $available = ($result) ? "1" : "0";
        $__smarty["available"] = $available;

        //**-2-Message
        $message_type = ($result) ? "a" : "na";
        $message_type = ($dom["og"]) ? "og_" . $message_type : $message_type;
        $Message = whmp_get_domain_message($message_type, $dom["full"], $dom["short"], $dom["ext"]);
        $__smarty["message"] = $Message;

        //**-3-Price
        $price_type = ($result) ? "domainregister" : "domaintransfer";
        $durations = get_min_years($dom["ext"]);    //minimum Years

        $year = $durations["years"];
        $year_num = $durations["y"];

        if ($year_num > 0) {
            $pricef = whmpress_domain_price_function(
                [
                    "years" => $year_num,
                    "tld" => $dom["ext"],
                    "html_class" => "",
                    "html_id" => "",
                    "show_duration" => "no",
                    "type" => $price_type,
                    "no_wrapper" => "1",
                ]
            );
        } else {
            $pricef = "";
            $year = "";
        }
        $__smarty["price"] = $pricef;

        // Price Multi
        $pm = [
            'extension' => $dom["ext"],
            'years' => 0,
        ];
        $__smarty['multi_price'] = whmp_domain_price_i($pm);

        //-4-Duration
        $__smarty["duration"] = $year;


        //-5-Order URL
        //------array for domain order urls function
        $link_type = ($result) ? "register" : "transfer";
        $arr = [
            "domain_full" => $dom["full"],
            "domain_short" => $dom["short"],
            "extension" => $dom["ext"],
            "type" => $link_type,
            "order_landing_page" => $params["order_landing_page"],
            "order_link_new_tab" => $params["order_link_new_tab"],
            "append_url" => $params["append_url"],
        ];

        //todo:transfer link is broken
        $orders = whmp_get_domain_order_urls($arr);
        $__smarty = array_merge($__smarty, $orders);

        //serving no purpose, dont know why it was here** todo: remove it
        /*        if ($params["enable_transfer_link"] == "yes" && ($available == "0")) {
            $__smarty["order_url"] = "";
            $__smarty["order_landing_page"] = "-1";
            $__smarty["whois_link"] = "";
        }*/


        // ---domain is available---
        if ($available) {
            //-9-Other variables for smarty
            $__smarty["order_landing_page"] = $params["order_landing_page"];
            $__smarty["order_link_new_tab"] = $params["order_link_new_tab"];
            $__smarty["whois_link"] = "";
            $__smarty["order_button_text"] = $params["register_text"];
            $_insert_data["domain_available"] = "1";

            //HTML FUNCTIONS > whmp_print_domain_search_result_available($orders,);

        }

        if (!($available)) {
            //-6-WWW
            $www_link = whmp_get_domain_www_link($params["www_link"], $dom["full"]);

            //-7-WhoIs
            $whois_link = whmp_get_domain_whois('yes', $dom["full"]);
            $__smarty["whois_link"] = $whois_link;
        }

        return $__smarty;
    }
}

/*whmp_get_searchable_extension(){
$WhoIS = whmpress_get_option("whois_db");
$WhoIS = explode("\n", $WhoIS);
foreach ($WhoIS as $k => $ext) {
    if (trim($ext) == "") {
        unset($WhoIS[$k]);
    }
}

# Removing domains from WhoIs DB if not found in your WHMCS data.
# If extended domain ajax call then it will true
global $wpdb;

if (isset($_REQUEST["skip_extra"]) && $_REQUEST["skip_extra"] == "1") {
    foreach ($WhoIS as $x => $line) {
        $ar = explode("|", $line);
        if (!isset($ar[0])) {
            $ar[0] = "";
        }
        $ext = $ar[0];
        if ($wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "` WHERE `extension`='$ext'") == 0) {
            #echo "SELECT COUNT(*) FROM `".whmp_get_domain_pricing_table_name()."` WHERE `extension`='$ext'"; die;
            unset($WhoIS[$x]);
        }
    }
    $WhoIS = array_values($WhoIS);
}

# Removing domains from WhoIs DB who are in backend settings
$extensions = get_option("tld_order");
$extensions = str_replace(" ", "", $extensions);
$extensions = explode(",", $extensions);

if (count($extensions) > 0) {
    foreach ($WhoIS as $x => $line) {
        $ar = explode("|", $line);
        if (!isset($ar[0])) {
            $ar[0] = "";
        }
        $ext = $ar[0];
        if (in_array($ext, $extensions)) {
            unset($WhoIS[$x]);
        }
    }
    $WhoIS = array_values($WhoIS);
}

}*/

if (!function_exists('whmp_is_valid_color')) {
    function whmp_is_valid_color($color_code = '')
    {
        $re = '/^(\#[\da-f]{3}|\#[\da-f]{6})$/imx';
        if (preg_match_all($re, $color_code) == 1) {
            return true;
        }

        return false;
    }
}


/*
 * This function is replicated frm whcom
 */

if (!function_exists('whmpress_get_whmcs_setting_i')) {
    function whmpress_get_whmcs_setting_i($setting_name = '')
    {
        $setting_name = (string)$setting_name;

        $whmcs_settings = (!empty($_SESSION) && !empty($_SESSION['whmpress_whmcs_settings']) && is_array($_SESSION['whmpress_whmcs_settings'])) ? $_SESSION['whmpress_whmcs_settings'] : false;
        if (!$whmcs_settings) {

            global $wpdb;
            $sql = "SELECT `setting`,`value` FROM " . whmp_get_configuration_table_name();
            $tmps = $wpdb->get_results($sql, ARRAY_A);
            $whmcs_settings = [];
            foreach ($tmps as $tmp) {
                $whmcs_settings[$tmp["setting"]] = $tmp["value"];
            }

            $_SESSION['whpress_whmcs_settings'] = $whmcs_settings;
        }

        if ($setting_name == '') {
            $response = $whmcs_settings;
        } else {
            $response = (!empty($whmcs_settings[$setting_name])) ? $whmcs_settings[$setting_name] : '';
        }

        return $response;
    }
}


if (!function_exists('whmpress_get_tax_levels_i')) {
    function whmpress_get_tax_levels_i()
    {

        $response = [
            'level1_rate' => whmpress_get_whmcs_setting_i('level1_rate'),
            'level1_title' => whmpress_get_whmcs_setting_i('level1_title'),
            'level2_rate' => whmpress_get_whmcs_setting_i('level2_rate'),
            'level2_title' => whmpress_get_whmcs_setting_i('level2_title'),
        ];

        if (!empty($taxes) && is_array($taxes)) {
            foreach ($taxes as $tax) {
                if (!empty($tax['taxrate']) && (float)$tax['taxrate'] > 0) {
                    if ($tax['level'] == '1') {
                        $response['level1_rate'] = (!empty($tax['taxrate'])) ? (float)$tax['taxrate'] : 0.00;
                        $response['level1_title'] = (!empty($tax['name'])) ? (string)$tax['name'] : '';
                    }
                    if ($tax['level'] == '2') {
                        $response['level2_rate'] = (!empty($tax['taxrate'])) ? (float)$tax['taxrate'] : 0.00;
                        $response['level2_title'] = (!empty($tax['name'])) ? (string)$tax['name'] : '';
                    }
                }
            }
        }

        return $response;
    }
}


if (!function_exists('whmpress_calculate_tax_i')) {
    function whmpress_calculate_tax_i($price = 0.00, $tax_settings = [])
    {
        $base_price = $final_price = $price = (float)$price;
        $level1_amount = $level2_amount = false;


        $tax_settings = (empty($tax_settings)) ? whcom_get_whmcs_setting() : $tax_settings;

        $TaxType = $tax_settings['TaxType'];
        $TaxL2Compound = $tax_settings['TaxL2Compound'];
        $tax_levels = whmpress_get_tax_levels_i();

        $level1_rate = (float)$tax_levels['level1_rate'];
        $level2_rate = (float)$tax_levels['level2_rate'];

        if ($tax_settings['TaxEnabled'] == 'on') {
            if (!empty($level1_rate)) {
                if ($TaxType == "Exclusive") {
                    $level1_amount = $price * ($level1_rate / 100);
                    $final_price = $price + $level1_amount;
                } else if ($TaxType == "Inclusive") {
                    // Inclusive Tax > Tax Amount = ( Item Price / ( 100 + Tax Rate ) ) x Tax Rate

                    $level1_amount = ($price / (100 + $level1_rate)) * $level1_rate;
                    $base_price = $price - $level1_amount;
                    $final_price = $price;
                }
            }
            if (!empty($level2_rate) && ($level1_amount)) {
                if (strtolower($TaxL2Compound) == "on") {
                    $price = $level1_amount + $price;
                }

                $level2_amount = 0;
                if ($TaxType == "Exclusive") {
                    $level2_amount = $price * ($level2_rate / 100);
                    $final_price = $final_price + $level2_amount;
                } else if ($TaxType == "Inclusive") {
                    $level2_amount = ($price / (100 + $level2_rate)) * $level2_rate;
                    $base_price = $final_price - $level2_amount;
                }
            }
        }


        $response = [
            'base_price' => (float)$base_price,
            'l1_amount' => (float)$level1_amount,
            'l2_amount' => (float)$level2_amount,
            'final_price' => (float)$final_price,
        ];

        return $response;
    }
}


if (!function_exists('whmp_ip_to_country')) {
    function whmp_ip_to_country()
    {


        global $wpdb;
        /*        if (getenv(HTTP_X_FORWARDED_FOR)) {
                    $ipaddress = getenv(HTTP_X_FORWARDED_FOR);
                } else {
                    $ipaddress = getenv(REMOTE_ADDR);
                }*/

        $ip_address = whmp_user_ip();
        $ip_address = ip2long($ip_address);
        $table_name = whmp_get_ip2country_table_name();

        $sql = "SELECT country_code FROM `" . $table_name . "` WHERE " . $ip_address . " BETWEEN ip_from AND ip_to LIMIT 1";

        $row = $wpdb->get_row($sql, ARRAY_A);

        $country_code = (!empty($row['country_code'])) ? $row['country_code'] : '';

        return $country_code;
    }
}

if (!function_exists('whmp_country_to_currency')) {
    function whmp_country_to_currency($country_code)
    {

        $country_currency = get_option("whmpress_default_currency");
        $whmp_countries_currencies = get_option("whmp_countries_currencies");

        if (!is_array($whmp_countries_currencies)) {
            $whmp_countries_currencies = [];
        }

        if (count($whmp_countries_currencies) > 0) {
            for ($x = 0; $x < count($whmp_countries_currencies["country"]); $x++) {
                if ($whmp_countries_currencies["country"][$x] == $country_code) {
                    $country_currency = $whmp_countries_currencies["currency"][$x];
                }
            }

        }

        return $country_currency;
    }
}

if (!function_exists('whmp_user_ip')) {
    function whmp_user_ip()
    {
        return $_SERVER["REMOTE_ADDR"];
    }
}

if (!function_exists('whmpress_feature_row_html')) {
    function whmpress_feature_row_html($plans)
    {
        $WHMPress = new WHMPress;
        $tmp = "";
        $mid1 = '';
        $smarty_array = [];
        if (is_array($plans) && !empty($plans)) {
            foreach ($plans as $key => $pair) {
                $line = $pair['feature'] . ": " . $pair['value'];
                if (trim($line) <> "") {
                    $data = [];
                    $data["feature"] = $line;
                    $totay = explode(":", $line);

                    $tooltip_data = $WHMPress->return_tooltip(trim($totay[0]));
                    $data["feature_title"] = trim($totay[0]);
                    $data["feature_value"] = isset($totay[1]) ? trim($totay[1]) : "";
                    $data["tooltip_text"] = stripcslashes($tooltip_data['tooltip_text']);
                    $tooltip_desc = $data["tooltip_text"];
                    $data["icon_class"] = $tooltip_data['icon_class'];
                    $smarty_array[] = $data;
                }
                //$tmp not in use
                $tmp .= $key . ": " . $pair['value'] . "\n";
                if (!empty($data['tooltip_text'])) {
                    $tmp .= $tooltip_desc;
                }
            }
        }
        $mid1 .= $tmp;

        return $smarty_array;

    }
}
