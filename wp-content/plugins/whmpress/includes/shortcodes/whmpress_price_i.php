<?php
//todo: simplyfy to return to numeric price

/**
 * Shows currency with prefix and suffix
 *
 * List of parameters
 * currency = provide currency code
 * id = relid from mysql pricing table
 * html_class = html class name for wrapper
 * html_id = html id name for wrapper
 * billingcycle = select this column name from mysql pricing table
 * decimals = round number of decimals for price/amount
 * decimals_tag = html tag name for wrap decimals only
 * hide_decimal = yes for hide decimal symbol
 * prefix = show currency prefix, yes for show without any tag aur tag name to wrap.
 * suffix = show currency suffix, yes for show without any tag aur tag name to wrap.
 * show_duration = yes for show duration with price > Yes, No or tagname e.g. i
 * show_duration_as = long or short duration (year or yr)
 * convert_monthly = convert price into monthly price (yes or no)
 */

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$args = (shortcode_atts([
    'html_template' => '',
    'image' => '',
    'currency' => whmpress_get_option("price_currency"),
    'id' => '0',
    'billingcycle' => whmpress_get_option("billingcycle"),
    'price_type' => whmpress_get_option('price_type'),
    # price, setup, both or total

    'decimals' => whmpress_get_option("decimals"),
    'decimals_tag' => whmpress_get_option("decimals_tag"),
    'hide_decimal' => whmpress_get_option("hide_decimal"),

    'prefix' => whmpress_get_option("prefix"), //
    'suffix' => whmpress_get_option("suffix"), //

    'show_duration' => whmpress_get_option("show_duration"), //
    'show_duration_as' => whmpress_get_option("show_duration_as"), //
    'duration_style' => whmpress_get_option("show_duration_as"), //

    'duration_connector' => whmpress_get_option("duration_connector"), //
    'convert_monthly' => whmpress_get_option("convert_monthly"), //
    "config_option_string" => whmpress_get_option("config_option_string"), //
    "configureable_options" => whmpress_get_option("configureable_options"), //

    "price_tax" => whmpress_get_option("price_tax"),

    "no_wrapper" => "",  //
    "do_not_show_config_option_string" => "",

    "return_array" => "",

    "simple" => "0", // If simple is provided as 1 then extra calculations will not be applied like thousand separator etc.
    'html_id' => '',    //
    'html_class' => 'whmpress whmpress_price', //

], $atts));
//$args["$currency_id"]=$args["$currency"];

extract($args);

$currency_ = (empty($currency)) ? whmp_get_current_currency_id_i() : $currency;

$currency_array = whmp_get_currency_info_i($currency_);
//definging, cleaning paramters here for clarity
/*value="">Default
    value="No">Do not show duration
    value="-">==No Tag==
    value="b">Bold
    value="i">Italic
    value="u">Underline
    value="sup">Superscript
    value="sub">Subscript*/

$billingcycle_ = $billingcycle;

$show_duration_ = ((strtolower(trim($show_duration))) == "no") ? FALSE : TRUE;
$duration_tag = ($show_duration_) ? $show_duration : "";
$duration_tag = (strtolower($duration_tag) == "yes") ? "-" : $duration_tag;

$duration_style_ = (trim($show_duration_as) != "") ? $show_duration_as : $duration_style;
$duration_connector_ = $duration_connector;

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

$convert_monthly_ = whmp_tfc($convert_monthly);
$sudo_monthly_ = trim(strtolower($convert_monthly));


$hide_decimal_ = whmp_tfc($hide_decimal);

$simple_ = whmp_tfc($simple);

$html_id_ = $html_id;
$html_class_ = $html_class;
$no_wrapper_ = whmp_tfc($no_wrapper);

# Generating string for output

$class = $html_class;

//1.Get Basic Price

$args["sudo_monthly"] = $sudo_monthly_;


$price_array = whmp_price_i($args);

//1.a. Calculate Tax
$tax_settings = whmpress_get_whmcs_setting_i();
$tax_array = whmpress_calculate_tax_i($price_array["price"], $tax_settings);

$price_array["price"] = $tax_array["final_price"];
$price_array["base_price"] = $tax_array["base_price"];
$price_array["tax_amount"] = $tax_array["l1_amount"] + $tax_array["l2_amount"];
$price_array["l1_amount"] = $tax_array["l1_amount"];
$price_array["l2_amount"] = $tax_array["l2_amount"];

if (strtolower($price_tax) == "default") {
    $price_tax = $tax_settings['TaxType'];
}

if (strtolower($price_tax) == "exclusive") {
    $price_array["price"] = $price_array["base_price"];
} elseif (strtolower($price_tax) == "inclusive") {
    //do nothing
} elseif (strtolower($price_tax) == "tax") {
    $price_array["price"] = $price_array["tax_amount"];
}

//2.Get Price Parts
$price_array["decimals"] = $decimals_points_;

$price_parts_array = whmp_format_price_i($price_array);

if ($convert_monthly_) {
    $tmp = [
        'price' => $price_array["sudo_price"],
        'billingcycle' => "monthly",
    ];
    $price_parts_array = whmp_format_price_i($tmp);
    $billingcycle_ = "monthly";
}


//ppa($price_parts_array);
$price_numeric = $price_array["price"];
$paytype = $price_array["paytype"];

//3.Get formated Price
$args = [
    'price' => $price_parts_array,
    'numeric_price' => $price_numeric,
    'paytype' => $paytype,
    'billingcycle' => $billingcycle_,
    'duration_connector' => $duration_connector_,
    'duration_style' => $duration_style_,
];

$formated_price_array = whmp_format_price_essentials_i($args);


if ($simple_) {
//let function take optional paramters of no of decimals, symbol
    $price = $price_array["price"];
    return $price;
}


global $WHMPress;

$html_template = $WHMPress->check_template_file($html_template, "whmpress_price");
$tempate_exist = is_file($html_template);

//build shortcode output
$return_string = "";
if (!$tempate_exist) {

    if (!($no_wrapper_)) {
        $wraper_start = "<span class='$class' id='{$html_id}'>";
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

    $fraction_p = ($hide_decimal_) ? $fraction_p : $decimal_p . $fraction_p;


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

    $return_string = $wraper_start . $prefix_s . $price_s . $suffix_s . $duration_s . $wraper_end;

    return $return_string;
    # Returning output string
    //$decimal_sperator = get_option( 'decimal_replacement', "." );
    //var_dump($config_price);
    if (!is_null($config_price)) {
        //$config_option_string
    } else {
        $config_option_string = "";
    }

    if (trim($config_option_string) == "") {
        if ($return_array == "1") {
            return [
                "decimal_sperator" => $decimal_sperator,
                "return_string" => $return_string,
                "paytype" => $row["paytype"],
            ];
        } else {
            return trim($return_string);
        }
    } else {
        if ($return_array == "1") {
            return [
                "do_not_show_config_option_string" => $do_not_show_config_option_string,
                "config_option_string" => $config_option_string,
                "decimal_sperator" => $decimal_sperator,
                "return_string" => $return_string,
                "paytype" => $row["paytype"],
            ];
        } else {
            if ($do_not_show_config_option_string == "1") {
                return trim($config_option_string . " " . $return_string);
            } else {
                return trim($return_string);
            }
        }
    }
}


/*if ($tempate_exist) {
    //$decimal_sperator = get_option( 'decimal_replacement', "." );
    $totay = explode($decimal_sperator, strip_tags($simple_price));
    $amount1 = $totay[0];
    $fraction = isset($totay[1]) ? $totay[1] : "";
    $totay = explode("/", strip_tags($price));
    $duration = @$totay[1];

    if (strtolower($show_duration_as) == "short") {
        if ($row["paytype"] == "recurring") {
            $duration = str_replace($BillingCycles, $ReplaceShortBillingCycles, $billingcycle);
        } elseif ($row["paytype"] == "free") {
            $duration = "";
        } elseif ($row["paytype"] == "onetime") {
            $duration = __("OT", "whmpress");
        }
    } else {
        if ($row["paytype"] == "recurring") {
            $duration = str_replace($BillingCycles, $ReplaceLongBillingCycles, $billingcycle);
        } elseif ($row["paytype"] == "free") {
            $duration = __("Free", 'whmpress');
        } elseif ($row["paytype"] == "onetime") {
            $duration = __("One Time", 'whmpress');
        }
    }

    // If paytype is onetime then add space as prefix otherwise add /
    if ($row["paytype"] == "onetime") {
        $ShowedBillingCycle = "&nbsp;" . $ShowedBillingCycle;
    } else {
        $ShowedBillingCycle = "/" . $ShowedBillingCycle;
    }

    if (strtolower($show_duration) == "-") {
        $return_string = $return_string . "{$ShowedBillingCycle}";
    } elseif (strtolower($show_duration) == "no") {
        //$return_string = $return_string;
        // Do nothing.
    } elseif (strtolower($show_duration) <> "no" && $show_duration <> "") {
        $return_string = $return_string . "<{$show_duration}>{$ShowedBillingCycle}</{$show_duration}>";
    }

    $vars = [
        "product_price" => $return_string,
        "prefix" => whmp_get_currency_prefix($currency),
        "suffix" => whmp_get_currency_suffix($currency),
        "amount" => $amount1,
        "fraction" => $fraction,
        "decimal" => $decimal_sperator,
        "duration" => $duration,
        "config_option_string" => $config_option_string,
        "paytype" => $row["paytype"],
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_price");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;
}*/

?>


