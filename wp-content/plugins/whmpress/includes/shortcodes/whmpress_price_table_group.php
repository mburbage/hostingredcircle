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
    'id' => '0',
], $atts));

$group = whmp_get_group_full($id);

if (count($group["plans"]) == "1") {
    $cols = "12";
} elseif (count($group["plans"]) == "2") {
    $cols = "9";
} elseif (count($group["plans"]) == "3") {
    $cols = "4";
} elseif (count($group["plans"]) == "4") {
    $cols = "3";
} elseif (count($group["plans"]) == "5") {
    $cols = "2";
} elseif (count($group["plans"]) == "6") {
    $cols = "2";
} else {
    $cols = "3";
}
$color = $group["color"];

$WHMPress = new WHMPress;
if ($html_template == "") {
    $html_template = $group["template_file"];
}
$html_template = $WHMPress->check_template_file($html_template, "whmpress_price_table_group");

if (is_file($html_template)) {
    $group["prefix"] = whmp_get_currency_prefix();
    foreach ($group["plans"] as &$plan) {
        $price = whmpress_price_function([
            "billingcycle" => $group["billingcycle"],
            "id" => $plan["product_id"],
            "currency" => $group["currency"],
            "decimals" => $group["decimals"],
            "decimals_tag" => $group["decimals_tag"],
            "hide_decimal" => $group["hide_decimal"],
            "prefix" => '-',
            "suffix" => $group["suffix"],
            "show_duration" => $group["show_duration"],
            "show_duration_as" => $group["show_duration_as"],
            "convert_monthly" => $group["convert_monthly"],
            "no_wrapper" => "1",
        ]);
        $plan["price"] = ltrim($price, $group["prefix"]);
        $pprice = process_price(ltrim($price, $group["prefix"]));
        $plan["amount"] = $pprice["amount"];
        $plan["fraction"] = $pprice["fraction"];
        $plan["prefix"] = $group["prefix"];
        $plan["suffix"] = $group["suffix"];
        $plan["billingcycle"] = $group["billingcycle"];
        if (isset($plan["description"])) {
            $plan["description"] = explode("\n", strip_tags($plan["description"], '<strong><s><del><strike>'));
        } else {
            $plan["description"] = [];
        }


        if ($plan["product_id"] == $group["important"]) {
            $plan["featured"] = "yes";
        } else {
            $plan["featured"] = "no";
        }

        $plan["order_url"] = $WHMPress->get_whmcs_url("order") . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
    }

    $vars = [
        "group" => $group,
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_price_table_group");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }


    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;
} else {
    $HTML = '<div class="pt-container">';
    foreach ($group["plans"] as $plan) {
        # Getting price
        $price = whmpress_price_function([
            "billingcycle" => $group["billingcycle"],
            "id" => $plan["product_id"],
            "currency" => $group["currency"],
            //"html_id"=>$group["html_id"],
            //"html_class"=>$group["html_class"],
            "decimals" => $group["decimals"],
            "decimals_tag" => $group["decimals_tag"],
            "hide_decimal" => $group["hide_decimal"],
            "prefix" => $group["prefix"],
            "suffix" => $group["suffix"],
            "show_duration" => $group["show_duration"],
            "show_duration_as" => $group["show_duration_as"],
            "convert_monthly" => $group["convert_monthly"],
        ]);

        if ($group["important"] == $plan["product_id"]) {
            $active = "active";
            if ($group["ribbon_text"] <> "") {
                $ribon_text =
                    '<div class="pt-ribbon-wrapper">
                        <div class="pt-ribbon">
                             ' . $group["ribbon_text"] . '
                        </div>
                    </div>';
            }
        } else {
            $active = "";
            $ribon_text = "";
        }
        $description = explode("\n", $plan["description"]);

        $rows = $group["rows"];
        if ($rows == 0 || $rows > sizeof($description)) {
            $rows = sizeof($description);
        }
        $Desc = "";
        for ($x = 0; $x < $rows; $x++) {
            if (trim($description[$x]) <> "") {
                $Desc .= "
                    <div class=\"pt-row\" style='text-align:left'>
                        <i class=\"pt-row-icon ok fa fa-check\"></i> {$description[$x]}
                    </div>
                ";
            }
        }

        $striped = $group["alternate_rows"] == "1" ? "striped hover" : "";

        //$price = '<span class="pt-currency">'.whmp_get_default_currency_prefix()."<span>";
        $button_text = $group["button_text"] == "" ? "Buy Now" : $group["button_text"];
        $url = $WHMPress->get_whmcs_url("order") . "pid={$plan["product_id"]}&a=add&currency={$group["currency"]}&billingcycle={$group["billingcycle"]}";
        //var_dump($price);
        $HTML .= <<<EOT
        <div class="col-md-{$cols}">
            <div class="pricing-table {$active} {$color}">
                <div class="pt-header">
                    {$ribon_text}
                    <h3 class="pt-title">{$plan["name"]}</h3>
                    <h4 class="pt-price">$price</h4>
                    <!--p class="pt-description"></p-->
                </div>   <!-- end .pt-header -->
                <div class="pt-body {$striped}">
                    $Desc
                </div>   <!-- end .pt-body -->
                <div class="pt-footer">
                    <button onclick='window.location.href="{$url}"' type="button" class="pt-button">{$button_text}</button>
                </div>   <!-- end .pt-footer -->
            </div>   <!-- end .pricing-table -->
        </div>   <!-- end .col-md-3 -->
EOT;
    }
    $HTML .= "</div>";

    return $HTML;
}