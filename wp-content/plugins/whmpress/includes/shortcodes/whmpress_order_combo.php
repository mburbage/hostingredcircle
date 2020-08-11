<?php

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

extract(shortcode_atts([
    'html_template' => '',
    'image' => '',
    'decimals' => whmpress_get_option("combo_decimals"),
    'currency' => '0',
    'id' => (isset($_REQUEST['id'])) ? $_REQUEST['id'] : '0',
    'rows' => whmpress_get_option("combo_rows"),
    'show_discount' => whmpress_get_option("combo_show_discount"),
    'show_button' => whmpress_get_option("combo_show_button"),
    'button_text' => whmpress_get_option("combo_button_text"),
    'combo_class' => '',
    'button_class' => '',
    'html_id' => '',
    'html_class' => 'whmpress whmpress_order_combo',
    'discount_type' => whmpress_get_option('combo_discount_type'),
    'billingcycles' => whmpress_get_option("combo_billingcycles"),
    'prefix' => whmpress_get_option("combo_prefix"),
    'suffix' => whmpress_get_option("combo_suffix"),
    "params" => '',
], $atts));

$decimal = $decimals;
if (!is_numeric($decimal)) {
    $decimal = "0";
}
$currency = whmp_get_currency($currency);
$showdiscount = $show_discount;
$showbutton = $show_button;
$buttontext = $button_text;

$WHMPress = new WHMpress();

# Getting WordPress DB variable for communicating with DB.
global $wpdb;
$smarty_array = [];

# Getting currency symbol
$suffcursymbol = "";
$prefcursymbol = "";
if (strtolower($prefix) == "yes") {
    $prefcursymbol = whmp_get_currency_prefix($currency);
}
if (strtolower($suffix) == "yes") {
    $suffcursymbol = whmp_get_currency_suffix($currency);
}

/*
 * if billing cycles are provided, turn them in array and fetch billing details of only those
 */

# Getting data from DB.
if (is_array($billingcycles)) {
    $billingcycles = trim(implode(",", $billingcycles));
}
if (trim($billingcycles) <> "") {
    # Setting up billing cycles
    $billingcycles = explode(",", $billingcycles);
    $billingcycles = array_map('trim', $billingcycles);
    $billingcycles = array_map('strtolower', $billingcycles);
    $Q = "SELECT `paytype`," . implode(",", $billingcycles) . " FROM `" . whmp_get_pricing_table_name() . "` pri,
        `" . get_mysql_table_name("products") . "` prd WHERE pri.`type`='product' AND prd.id=pri.relid";
} else {
    $Q = "SELECT prd.`paytype`, prd.`name`,pri.`triennially`,pri.`biennially`,pri.`annually`,pri.`semiannually`,pri.`quarterly`,pri.`monthly` FROM `" . whmp_get_pricing_table_name() . "` pri,
        `" . get_mysql_table_name("tblproducts") . "` prd WHERE pri.`type`='product' AND prd.id=pri.relid";
}
if (isset($id)) {
    $Q .= " AND `relid`=" . $id;
}

$Q .= " AND `currency`=" . $currency;

$row = $wpdb->get_row($Q, ARRAY_A);
/*echo "<pre>";
print_r ($row);
echo "</pre>";*/

# Checking that provided ID is valid
if ($row === false || !is_array($row)) {
    return __('Invalid ID', 'whmpress');
}

# Generating string for output
if (!empty($atts['override_order_combo_url'])) {
    $action_url = $atts['override_order_combo_url'];
} else {
    $action_url = $WHMPress->get_whmcs_url("order");
}
if ($params <> "") {
    $action_url .= "&" . $params;
}
$string = "<!--whmpress-combo-start-->";
$string .= "<form action='" . $action_url . "'>\n";

## Checking/Adding parameters if found in URL
$params = parse_url($action_url);
if (!isset($params["query"])) {
    $params["query"] = "";
}
if ($params["query"] <> "") {
    parse_str($params["query"], $params);
    foreach ($params as $key => $val) {
        $string .= "<input type=\"hidden\" value=\"{$val}\" name=\"{$key}\">\n";
    }
}

$string .= "<input type=\"hidden\" value=\"add\" name=\"a\">    
    <input type=\"hidden\" value=\"{$id}\" name=\"pid\">
    <input type=\"hidden\" value=\"{$currency}\" name=\"currency\"> 
    <select name=\"billingcycle\" class=\"{$combo_class}\">\n";
if (get_option("show_trailing_zeros") == "yes") {
    $CurrencyFunction = "number_format";
} else {
    $CurrencyFunction = "round";
}
if (!isset($row["monthly"])) {
    $row["monthly"] = "0";
}

$decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);

//== one time and monthly discount calculation starts
if ($row["paytype"] == "onetime") {
    $process_price = process_price($row["monthly"]);
    $string .= "<option value=\"\">{$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol} " . __("One Time", "whmpress") . "</option>\n";
} else if ($row["monthly"] > 0) {
    if (is_array($billingcycles) && in_array("monthly", $billingcycles)) {
        $process_price = process_price($row["monthly"]);
        if ($row["paytype"] == "onetime") {
            $string .= "<option value=\"monthly\">{$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        } else {
            $string .= "<option value=\"monthly\">" . __("1 Month", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["monthly"], $decimal),
            "sudo_product_price" =>'',
            "discount" => "",
            'total_monthly_amount' => "",
            'is_free_domain' => $WHMPress->detect_free_domain($id,'monthly'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "monthly",
            "num_duration" => "1 month",
            "paytype" => $row["paytype"]
        ];
    } else if ((strtolower($discount_type) == "yearly" || "annually" == strtolower($discount_type))) {
        $process_price = process_price($row["monthly"]);
        if ($row["paytype"] == "onetime") {
            $string .= "<option value=\"monthly\">{$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        } else {
            $string .= "<option value=\"monthly\">" . __("1 Month", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["monthly"], $decimal),
            "sudo_product_price" =>'',
            "discount" => "",
            'total_monthly_amount' => "",
            'is_free_domain' => $WHMPress->detect_free_domain($id,'monthly'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "monthly",
            "num_duration" => "1 month",
            "paytype" => $row["paytype"]
        ];
    } else if (strtolower($discount_type) == "monthly") {
        $process_price = process_price($row["monthly"]);
        if ($row["paytype"] == "onetime") {
            $string .= "<option value=\"monthly\">{$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        } else {
            $string .= "<option value=\"monthly\">" . __("1 Month", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["monthly"], $decimal),
            "sudo_product_price" =>'',
            "discount" => "",
            'is_free_domain' => $WHMPress->detect_free_domain($id,'monthly'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "monthly",
            "num_duration" => "1 month",
            "paytype" => $row["paytype"]
        ];
    }
}

//== Quarterly discount calculation starts
if (!isset($row["quarterly"])) {
    $row["quarterly"] = "0";
}
if ($row["quarterly"] > 0 && $row["paytype"] <> "onetime") {
    if ($row["monthly"] > 0) {
        //== if paid monthly then total amount which will be payed
        $total_monthly_amount = $row["monthly"] * 3;
        $per = round(100 - ($row["quarterly"] / ($row["monthly"] * 3) * 100), 0);
    } else {
        $total_monthly_amount = "";
        $per = "";
    }
    if (is_array($billingcycles) && in_array("quarterly", $billingcycles)) {
        $process_price = process_price($row["quarterly"]);

        $string .= "<option value=\"quarterly\">" . __('3 Months', 'whmpress') . "- {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["quarterly"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'quarterly','sudo_monthly' => 'yes']),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            'is_free_domain' => $WHMPress->detect_free_domain($id,'quarterly'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "quarterly",
            "num_duration" => "3 months",
            "paytype" => $row["paytype"]
        ];
    } else if (strtolower($discount_type) == "yearly") {
        $process_price = process_price($row["quarterly"]);

        $string .= "<option value='quarterly'>" . __('3 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["quarterly"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'quarterly','sudo_monthly' => 'yes']),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            'is_free_domain' => $WHMPress->detect_free_domain($id,'quarterly'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "quarterly",
            "num_duration" => "3 months",
        ];
    } else {
        $process_price = process_price($row["quarterly"]);
        $monthly = $CurrencyFunction($row["quarterly"] / 3, $decimal);
        $string .= "<option value=\"quarterly\">" . __('3 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol} @ {$monthly}/" . __("mo", "whmpress") . "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["quarterly"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'quarterly','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'quarterly'),
            "discount" => $monthly,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "quarterly",
            "num_duration" => "3 months",
        ];
    }
}

//== Semi-annually discount calculation starts
if (!isset($row["semiannually"])) {
    $row["semiannually"] = "0";
}
if ($row["semiannually"] > 0 && $row["paytype"] <> "onetime") {
    if ($row["monthly"] > 0) {
        $total_monthly_amount = $row["monthly"] * 6;
        $per = round(100 - ($row["semiannually"] / ($row["monthly"] * 6) * 100), 0);
    } else if ($row["quarterly"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["semiannually"] / ($row["quarterly"] * 2) * 100), 0);
    } else {
        $total_monthly_amount = "";
        $per = "";
    }
    if (is_array($billingcycles) && in_array("semiannually", $billingcycles)) {
        $process_price = process_price($row["semiannually"]);
        $string .= "<option value=\"semiannually\">" . __("6 Months", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["semiannually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'semiannually','sudo_monthly' => 'yes']),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            'is_free_domain' => $WHMPress->detect_free_domain($id,'semiannually'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "semiannually",
            "num_duration" => "6 months",
        ];
    } else if (strtolower($discount_type) == "yearly") {
        $process_price = process_price($row["semiannually"]);
        $string .= "<option value=\"semiannually\">" . __("6 Months", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["semiannually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'semiannually','sudo_monthly' => 'yes']),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            'is_free_domain' => $WHMPress->detect_free_domain($id,'semiannually'),
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "semiannually",
            "num_duration" => "6 months",
        ];
    } else {
        $process_price = process_price($row["semiannually"]);
        $monthly = $CurrencyFunction($row["semiannually"] / 6, $decimal);
        $string .= "<option value=\"semiannually\">" . __("6 Months", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol} @ {$monthly}/" . __("mo", "whmpress") . "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["semiannually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'semiannually','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'semiannually'),
            "discount" => $monthly,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "semiannually",
            "num_duration" => "6 months",
        ];
    }
}

//== Annually discount calculation starts
if (!isset($row["annually"])) {
    $row["annually"] = "0";
}
if ($row["annually"] > 0 && $row["paytype"] <> "onetime") {
    if ($row["monthly"] > 0) {
        $total_monthly_amount = $row["monthly"] * 12;
        $per = round(100 - ($row["annually"] / ($row["monthly"] * 12) * 100), 0);
    } else if ($row["quarterly"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["annually"] / ($row["quarterly"] * 4) * 100), 0);
    } else if ($row["semiannually"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["annually"] / ($row["semiannually"] * 2) * 100), 0);
    } else {
        $total_monthly_amount = "";
        $per = "0";
    }

    if (is_array($billingcycles) && in_array("annually", $billingcycles)) {
        $process_price = process_price($row["annually"]);
        $monthly = $CurrencyFunction($row["annually"] / 12, $decimal);
        $string .= "<option value=\"annually\">" . __('12 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["annually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'annually','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'annually'),
            "discount" => "",
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "annually",
            "num_duration" => "1 year",
        ];
    } else if (strtolower($discount_type) == "yearly") {
        $process_price = process_price($row["annually"]);
        $string .= "<option value=\"annually\">" . __("1 Year", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%</option>\n";
        }

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["annually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'annually','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'annually'),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "annually",
            "num_duration" => "1 year",
        ];
    } else {
        $monthly = $CurrencyFunction($row["annually"] / 12, $decimal);
        $process_price = process_price($row["annually"]);
        $string .= "<option value=\"annually\">" . __('12 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        if (strtolower($showdiscount) == "yes") {
            $string .= " @ {$monthly}/" . __("mo", "whmpress");
        }
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["annually"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'annually','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'annually'),
            "discount" => $monthly,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "annually",
            "num_duration" => "1 year",
        ];
    }
}

//== Bi-Anually discount calculation starts
if (!isset($row["biennially"])) {
    $row["biennially"] = "0";
}
if ($row["biennially"] > 0 && $row["paytype"] <> "onetime") {
    if ($row["monthly"] > 0) {
        $total_monthly_amount = $row["monthly"] * 24;
        $per = round(100 - ($row["biennially"] / ($row["monthly"] * 24) * 100), 0);
    } else if ($row["quarterly"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["biennially"] / ($row["quarterly"] * 8) * 100), 0);
    } else if ($row["semiannually"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["biennially"] / ($row["semiannually"] * 4) * 100), 0);
    } else if ($row["annually"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["biennially"] / ($row["annually"] * 2) * 100), 0);
    } else {
        $total_monthly_amount = "";
        $per = "";
    }
    if (is_array($billingcycles) && in_array("biennially", $billingcycles)) {
        $process_price = process_price($row["biennially"]);
        $monthly = $CurrencyFunction($row["biennially"] / 24, $decimal);
        $string .= "<option value=\"biennially\">" . __('24 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["biennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'biennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'biennially'),
            "discount" => "",
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "biennially",
            "num_duration" => "2 years",
        ];
    } else if (strtolower($discount_type) == "yearly") {

        $process_price = process_price($row["biennially"]);
        $string .= "<option value=\"biennially\">" . __("2 Years", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";

        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%";
            esc_html__("", "", "");
        }
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["biennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'biennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'biennially'),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "biennially",
            "num_duration" => "2 years",
        ];
    } else {
        $monthly = $CurrencyFunction($row["biennially"] / 24, $decimal);
        $process_price = process_price($row["biennially"]);
        $string .= "<option value=\"biennially\">" . __('24 Months', 'whmpress') . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        if (strtolower($showdiscount) == "yes") {
            $string .= " @ {$monthly}/" . __("mo", "whmpress");
        }
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["biennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'biennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'biennially'),
            "discount" => $monthly,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "biennially",
            "num_duration" => "2 years",
        ];
    }
}

//== Tri-Annually discount calculation starts
if (!isset($row["triennially"])) {
    $row["triennially"] = "0";
}
if ($row["triennially"] > 0 && $row["paytype"] <> "onetime") {
    if ($row["monthly"] > 0) {
        $total_monthly_amount = $row["monthly"] * 36;
        $per = round(100 - ($row["triennially"] / ($row["monthly"] * 36) * 100), 0);
    } else if ($row["quarterly"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["triennially"] / ($row["quarterly"] * 12) * 100), 0);
    } else if ($row["semiannually"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["triennially"] / ($row["semiannually"] * 6) * 100), 0);
    } else if ($row["annually"] > 0) {
        $total_monthly_amount = "";
        $per = round(100 - ($row["triennially"] / ($row["annually"] * 3) * 100), 0);
    } else {
        $total_monthly_amount = "";
        $per = "";
    }

    if (is_array($billingcycles) && in_array("triennially", $billingcycles)) {
        $monthly = $CurrencyFunction($row["triennially"] / 36, $decimal);
        $process_price = process_price($row["triennially"]);
        $string .= "<option value=\"triennially\">" . __("36 Months", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["triennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'triennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'triennially'),
            "discount" => "",
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "triennially",
            "num_duration" => "3 years",
        ];
    } else if (strtolower($discount_type) == "yearly") {

        $process_price = process_price($row["triennially"]);
        $string .= "<option value=\"triennially\"> " . __("3 Years", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . "{$suffcursymbol}";
        if (strtolower($showdiscount) == "yes" && $per <> "") {
            $string .= " " . _x("Save", "discount", "whmpress") . " {$per}%";
        }
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["triennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'triennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'triennially'),
            "discount" => $per,
            'total_monthly_amount' => $total_monthly_amount,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "triennially",
            "num_duration" => "3 years",
        ];
    } else {
        $monthly = $CurrencyFunction($row["triennially"] / 36, $decimal);

        $process_price = process_price($row["triennially"]);
        $string .= "<option value=\"triennially\">" . __("36 Months", "whmpress") . " - {$prefcursymbol}" . ($process_price["amount"] . $decimal_sperator . $process_price["fraction"]) . $suffcursymbol;
        if (strtolower($showdiscount) == "yes") {
            $string .= " @ {$monthly}/" . __("mo", "whmpress");
        }
        $string .= "</option>\n";

        $smarty_array[] = [
            "prefix" => $prefcursymbol,
            "suffix" => $suffcursymbol,
            "product_price" => $CurrencyFunction($row["triennially"], $decimal),
            'sudo_product_price' => whmp_price_i(['id'=> $id, 'currency_id'=> $currency, 'billingcycle'=> 'triennially','sudo_monthly' => 'yes']),
            'is_free_domain' => $WHMPress->detect_free_domain($id,'triennially'),
            "discount" => $monthly,
            "amount" => $process_price["amount"],
            "fraction" => $process_price["fraction"],
            "decimal" => $decimal_sperator,
            "duration" => "triennially",
            "num_duration" => "3 years",
        ];
    }
}

$WHMPress = new WHMPress;
$html_template = $WHMPress->check_template_file($html_template, "whmpress_order_combo");
$description     = whmpress_description_function(["id" => $id]);
$highlighted_description = $WHMPress->Description2Array($description,'3',':','3','0');
$string .= "</select>\n";

#echo nl2br(htmlentities($string));

$button = "<button class=\"{$button_class}\">{$buttontext}</button>";

if ($rows == "2") {
    $string .= "<br />";
}

if (strtolower($showbutton) == "yes") {
    $string .= $button;
}
$string .= "</form>";
#echo $html_template."<br />";
if (is_file($html_template)) {
    #echo "Yes<br />";
    $vars = [
        "product_order_combo" => $string,
        "product_order_button" => $button,
        "order_button_text" => $buttontext,
        "data" => $smarty_array,
        "reverse_data" => array_reverse($smarty_array),
        "product_name" => $row['name'],
        "highlighted_description" => $highlighted_description,
        "pid" => $id,
        "product_id" => $id,
        "currency_id" => $currency,
        "action_url" => $action_url,
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_order_combo");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);
} else {
    # Returning output string including HTML wrapper with ID
    $OutputString = "<div id='$html_id' class='$html_class'>" . $string . "</div>";
}
return $OutputString;