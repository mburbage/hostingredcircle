<?php
/**
 * Created by PhpStorm.
 * User: fokado
 * Date: 05/12/2017
 * Time: 1:05 PM
 */


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

extract(shortcode_atts([
    'html_template' => '',
    'image' => '',
    'currency' => whmpress_get_option("price_currency"),
    'html_class' => 'whmpress whmpress_price',
    'id' => '0',
    'billingcycle' => whmpress_get_option("billingcycle"),
    'price_type' => whmpress_get_option('price_type'),
    # price, setup, both or total
    'decimals' => whmpress_get_option("decimals"),
    'decimals_tag' => whmpress_get_option("decimals_tag"),
    'hide_decimal' => whmpress_get_option("hide_decimal"),
    'prefix' => whmpress_get_option("prefix"),
    'suffix' => whmpress_get_option("suffix"),
    'html_id' => '',
    'show_duration' => whmpress_get_option("show_duration"),
    'show_duration_as' => whmpress_get_option("show_duration_as"),
    'convert_monthly' => whmpress_get_option("convert_monthly"),
    "config_option_string" => whmpress_get_option("config_option_string"),
    "configureable_options" => whmpress_get_option("configureable_options"),
    "round_price" => whmpress_get_option("round_price"),
    "price_tax" => whmpress_get_option("price_tax"),
    "no_wrapper" => "",
    "do_not_show_config_option_string" => "",
    "return_array" => "",
    "simple" => "0",
    /// If simple is provided as 1 then extra calculations will not be applied like thousand separator etc.
], $atts));
# Generating string for output
$WHMPress = new WHMPress;
$WHMPress->update_db();

if (empty($currency)) {
    $currency = whmp_get_currency($currency);
}
$class = $html_class;

# Getting WordPress DB variable for communicating with DB.
global $wpdb;

# Getting price from DB
$Q = "SELECT `{$billingcycle}`,`paytype`,`monthly`, `msetupfee`, `qsetupfee`, `ssetupfee`, `asetupfee`, `bsetupfee`, `tsetupfee`, `tax` FROM `" . whmp_get_pricing_table_name() . "` prc,`" . whmp_get_products_table_name() . "` prds WHERE prds.`id`='{$id}' AND prc.`relid`='{$id}' AND prc.`currency`='{$currency}' AND prc.`type`='product'";
$row = $wpdb->get_row($Q, ARRAY_A);
if ($row["paytype"] == "free") {
    $price = "-";
} else if ($row["paytype"] == "onetime") {
    $price = $row["monthly"];
} else {
    $price = $row[$billingcycle];
}

if (strtolower(trim($price_type)) == "setup") {
    $price = $row[substr($billingcycle, 0, 1) . "setupfee"];
} elseif (strtolower(trim($price_type)) == "total" || strtolower(trim($price_type)) == "both") {
    $price += $row[substr($billingcycle, 0, 1) . "setupfee"];
}

# Checking that ID is valid or not
if ($price === null || is_null($price)) {
    return sprintf(_e("Invalid ID (%1s) or Invalid Currency (%2s)", 'whmpress'), $id, $currency);
}

# Getting price from configureable options.
$config_price = null;
if (whmp_is_table_exists(get_mysql_table_name("tblpricing")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfiglinks")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfigoptions")) && whmp_is_table_exists(get_mysql_table_name("tblproductconfigoptionssub")) && ($configureable_options == "1" OR strtolower($configureable_options) == "yes")) {
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

    $price += $config_price;
}

# Calculating tax.
$TaxEnabled = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxEnabled'");
$tax_amount = $base_price = 0;
// If product tax is enabled and Configuration tax is enabled then execute these codes.
if (strtolower($TaxEnabled) == "on" && $row["tax"] == "1") {
    $TaxType = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxType'");
    $TaxL2Compound = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxL2Compound'");

    $level1_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='1' AND `country`='' ORDER BY `id`");
    $level2_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='2' AND `country`='' ORDER BY `id`");

    $taxes = whmpress_calculate_tax($price);
    $base_price = $taxes["base_price"];
    $tax_amount = $taxes["tax_amount"];
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
} else {
    $tax_amount = 0;
    $base_price = $price;
}

if ($price_tax == "default") {
    $price_tax = "";
}
$price_tax = trim(strtolower($price_tax));
if ($price_tax == "exclusive") {
    $price = $base_price;
} elseif ($price_tax == "inclusive") {
    $price = $base_price + $tax_amount;
} elseif ($price_tax == "tax") {
    $price = $tax_amount;
}

$simple_price = $price;

//todo: convert logic using duration array
# Converting price into monthly price if required
if ($row["paytype"] == "recurring") {
    if (strtolower($convert_monthly) == "yes" && $billingcycle == "annually") {
        $price = $price / 12;
    } elseif (strtolower($convert_monthly) == "yes" && $billingcycle == "quarterly") {
        $price = $price / 3;
    } elseif (strtolower($convert_monthly) == "yes" && $billingcycle == "semiannually") {
        $price = $price / 6;
    } elseif (strtolower($convert_monthly) == "yes" && $billingcycle == "biennially") {
        $price = $price / 24;
    } elseif (strtolower($convert_monthly) == "yes" && $billingcycle == "triennially") {
        $price = $price / 36;
    }
}
if ($round_price == "Yes") {
    $price = round($price, 1, PHP_ROUND_HALF_UP);
}
$decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);
$thousand_sperator = $WHMPress->get_currency_thousand_separator($currency);

if ($simple <> "1") {
//let function take optional paramters of no of decimals, symbol
    $price = format_price($price, false);
} else {  //todo: thousand seprtor is not needed in simple
    $decimal_sperator = ".";
//	$thousand_sperator = ",";
}

//todo: recheck with shakeel, replace "." with decimal separator veriabale
$parts = explode($decimal_sperator, $price);
if ($decimals > 0) {
    $pt1 = isset($parts[1]) ? $parts[1] : "";
    if ($decimals_tag == "-" || trim($decimals_tag) == "") {
        $parts[1] = $decimal_sperator . ($pt1);
    } else {
        $parts[1] = "<{$decimals_tag}>" . $decimal_sperator . ($pt1) . "</{$decimals_tag}>";
    }
} else {
    $parts[1] = "";
}
$price = (isset($parts[0]) ? $parts[0] : "") . (isset($parts[1]) ? $parts[1] : "");
$price = rtrim($price, $decimal_sperator);

//echo "after conversion:".$price;


# Remove decimal symbol if requested
if (strtolower($hide_decimal) == "yes") {
    $price = str_replace($decimal_sperator, "", $price);
}

# Check show duration parameter check
$BillingCycles = ["annually", "monthly", "free", "onetime"];
$ReplaceLongBillingCycles = [
    esc_html__('Year', 'whmpress'),
    esc_html__('Month', 'whmpress'),
    esc_html__('Free', 'whmpress'),
    esc_html__('Onetime', 'whmpress')
];
$ReplaceShortBillingCycles = [
    esc_html__('Yr', 'whmpress'),
    esc_html__('Mo', 'whmpress'),
    esc_html__('Fe', 'whmpress'),
    esc_html__('Ot', 'whmpress')
];

$return_string = "";
// Addprefix if select
if (strtolower($prefix) == "-") {
    $return_string .= whmp_get_currency_prefix($currency);
} elseif (strtolower($prefix) <> "" && strtolower($prefix) <> "no") {
    $return_string .= "<{$prefix}>" . whmp_get_currency_prefix($currency) . "</{$prefix}>";
}
$return_string .= $price;
// Add suffix
if (strtolower($suffix) == "-") {
    $return_string .= whmp_get_currency_suffix($currency);
} elseif (strtolower($suffix) <> "" && strtolower($suffix) <> "no") {
    $return_string .= "<{$suffix}>" . whmp_get_currency_suffix($currency) . "</{$suffix}>";
}

// Add duration
if (strtolower($show_duration_as) == "short") {
    if ($row["paytype"] == "recurring") {
        $ShowedBillingCycle = str_replace($BillingCycles, $ReplaceShortBillingCycles, $billingcycle);
    } elseif ($row["paytype"] == "free") {
        $ShowedBillingCycle = "";
    } elseif ($row["paytype"] == "onetime") {
        $ShowedBillingCycle = __('Ot', 'whmpress');
    }
} else {

    if ($row["paytype"] == "recurring") {
        $ShowedBillingCycle = str_replace($BillingCycles, $ReplaceLongBillingCycles, $billingcycle);
    } elseif ($row["paytype"] == "free") {
        $ShowedBillingCycle = __("Free", "whmpress");
    } elseif ($row["paytype"] == "onetime") {
        $ShowedBillingCycle = __("One Time", "whmpress");
    }
}

if ($row["paytype"] == "recurring") {
    if (strtolower($convert_monthly) == "yes" && $show_duration_as == "short") {
        $ShowedBillingCycle = __("mo", 'whmpress');
    } elseif (strtolower($convert_monthly) == "yes") {
        $ShowedBillingCycle = __("month", 'whmpress');
    }
} elseif ($row["paytype"] == "onetime") {
    $ShowedBillingCycle = __("One Time", "whmpress");
}

if ($ShowedBillingCycle == "") {
    $show_duration = "no";
}
//if ($row["paytype"]=="onetime") $show_duration = "no";

#
if ($row["paytype"] == "free") {
    $billingcycle = __("free", 'whmpress');
} else if ($row["paytype"] == "onetime") {
    $billingcycle = __("onetime", 'whmpress');
}

// All done, translate billing cycle veriable
$ShowedBillingCycle = __($ShowedBillingCycle, 'whmpress');



$html_template = $WHMPress->check_template_file($html_template, "whmpress_price");

if (is_file($html_template)) {
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
} else {
    if (strtolower($show_duration) == "-") {
        if ($row["paytype"] == "onetime") {
            if ($no_wrapper == "1" || strtolower($no_wrapper) == "yes") {
                $return_string = $return_string . "&nbsp;{$ShowedBillingCycle}";
            } else {
                $return_string = "<span class='$class' id='{$html_id}'>" . $return_string . "&nbsp;{$ShowedBillingCycle}</span>";
            }
        } else {
            if ($no_wrapper == "1" || strtolower($no_wrapper) == "yes") {
                $return_string = $return_string . " /{$ShowedBillingCycle}";
            } else {
                $return_string = "<span class='$class' id='{$html_id}'>" . $return_string . " /{$ShowedBillingCycle}</span>";
            }
        }
    } elseif (strtolower($show_duration) == "no") {
        if ($no_wrapper == "1" || strtolower($no_wrapper) == "yes") {
            $return_string = $return_string;
        } else {
            $return_string = "<span class='$class' id='{$html_id}'>" . $return_string . "</span>";
        }
    } elseif (strtolower($show_duration) <> "no" && $show_duration <> "") {
        if ($row["paytype"] == "onetime") {
            if ($no_wrapper == "1" || strtolower($no_wrapper) == "yes") {
                $return_string = $return_string . "&nbsp;<{$show_duration}>{$ShowedBillingCycle}</{$show_duration}>";
            } else {
                $return_string = "<span class='$class' id='{$html_id}'>" . $return_string . "&nbsp;<{$show_duration}>{$ShowedBillingCycle}</{$show_duration}></span>";
            }
        } else {
            if ($no_wrapper == "1" || strtolower($no_wrapper) == "yes") {
                $return_string = $return_string . " <{$show_duration}>/{$ShowedBillingCycle}</{$show_duration}>";
            } else {
                $return_string = "<span class='$class' id='{$html_id}'>" . $return_string . " <{$show_duration}>/{$ShowedBillingCycle}</{$show_duration}></span>";
            }
        }
    }

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

if (!function_exists('dummy_to_delete')) {


    function dummy_to_delete()
    {

        /* todo: remove
         * following logic handles things
         * if decimal separator is ","  and php is showing "."
         *  First determine if number is float or integer, if it is float
         *  change "." back to ","
         * */
        if ($decimal_sperator == ",") {
            if (whmp_is_trailing_zeros($sprice, $decimals)) {
                $num = -1 * abs($decimals + 1);

                /*
                 * if it had a trailing zero, then it is an int and does not have decimals.
                 * so only "." in it would be for thousand separators. so nothing to do here.
                */
            } else {
                /*
                 * Remove first occurance of "." from right.
                 * */
                $num = -1 * abs($decimals + 1);
                $dprice = substr($price, $num);
                $cprice = substr($price, 0, $num);
                echo "<br/>dstring:" . $dprice;
                echo "<br/>cstring:" . $cprice;
                $price = $cprice . $dprice;
            }
        }

    }
}