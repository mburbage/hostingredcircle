<?php
/**
 * Displays price table of all services including domain
 *
 * name = Matching service name
 * groups = comma seperated group names
 * billingcycles = Billing cycle names
 * decimals = number of decimals with price
 * type = type of product. e.g. product
 * table_id = HTML id for table
 * currency = Currency id for prices
 * show_hidden = provide yes if you want to show hidden products
 * replace_zero = replace zero with specific character, default is -
 * replace_empty = replace empty with specific character, default is x
 * html_id = HTML id for div wrapper
 * html_class = HTML class for div wrapper
 * hide_search = Yes or No for hide search
 * titles = Comman seprated titles for column titles
 * search_label = Set label for search
 * search_placeholder = Set placeholder for search box
 */


// If WHMPress settings -> Styles -> include FontAwesome selected Yes
if (get_option('include_fontawesome') == "1") {
    wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
}

if (!isset($atts)) {
    $atts = [];
}

$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    $html = "<div style='color: red;' '>WHMCS is not yet synced</div>";
    $html = $html . "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
    return $html;
} else {
    $atts = shortcode_atts([
        'html_template' => '',
        'name' => '',
        'groups' => '',
        'show_price' => '',
        'billingcycles' => '',
        'hide_columns' => '',
        'decimals' => whmpress_get_option('pm_decimals'),
        'show_hidden' => whmpress_get_option('pm_show_hidden'),
        'replace_zero' => whmpress_get_option('pm_replace_zero'),
        'replace_empty' => whmpress_get_option('pm_replace_empty'),
        'table_id' => '',
        'type' => 'product',
        'html_id' => '',
        'html_class' => 'whmpress whmpress_price_matrix',
        'hide_search' => whmpress_get_option('pm_hide_search'),
        'currency' => '',
        'titles' => '',
        'search_label' => whmpress_get_option('pm_search_label'),
        'search_placeholder' => whmpress_get_option('pm_search_placeholder'),
        'order_link' => '1',
        'data_table' => '0',
        'append_order_url' => '',
        'detail_page_billing_cycle' => '',
        'description_columns' => ''
    ], $atts);

    //Enqueue libraries for dataTables
    if (!defined('WCAP_VERSION')) {
        if ($atts['data_table'] == "yes") {
            //echo '<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">' . PHP_EOL;
            wp_enqueue_script('whmp_dataTables', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.js', ['jquery'], false, true);
            wp_enqueue_style('whmp_dataTables-style', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.css');
        }
    }

    $WHMPress = new WHMPress;

    $ShowPrice = $atts["show_price"];
    $cols = $atts["billingcycles"];
    $showhidden = $atts["show_hidden"];

    if (!isset($currency)) {
        $currency = "";
    }
    //== Make currency compatible if country currency is On
    $currency = whmp_get_current_currency_id_i();
    //$currency = whmp_get_currency($currency);
    $currency_prefix = whmp_get_currency_prefix($currency);
# Checking parameters

# Getting WordPress DB object
    global $wpdb;

# Getting symbol type
    $symbol_type = strtolower(whmpress_get_option('default_currency_symbol'));

# Setting fields/columns for Table
    $fieldss = [
        "sr" => __("Sr", "whmpress"),
        "id" => __("ID", "whmpress"),
        "name" => __("Name", "whmpress"),
        "groupn" => __("Group", "whmpress"),
        "monthly" => __("Monthly", "whmpress"),
        "quarterly" => __("3 Months", "whmpress"),
        "semiannually" => __("6 Months", "whmpress"),
        "annually" => __("Yearly", "whmpress"),
        "biennially" => __("2 Years", "whmpress"),
        "triennially" => __("3 Years", "whmpress"),
    ];

    $hide_columns = explode(",", $atts["hide_columns"]);
    foreach ($hide_columns as $hd) {
        if (strtolower($hd) == "group") {
            $hd = "groupn";
        }
        $hd = strtolower($hd) == 'name' ? "" : trim($hd);
        if (isset($fieldss[$hd])) {
            unset($fieldss[$hd]);
        }
    }

    $dfieldss = [          // Deletable fields
        "monthly" => __("Monthly", "whmpress"),
        "quarterly" => __("3 Months", "whmpress"),
        "semiannually" => __("6 Months", "whmpress"),
        "annually" => __("Yearly", "whmpress"),
        "biennially" => __("2 Years", "whmpress"),
        "triennially" => __("3 Years", "whmpress"),
    ];
    $fields = "pd.`id`,pd.`name`,pr.`monthly`,pr.`quarterly`,pr.`semiannually`,pr.`annually`,pr.`biennially`,pr.`triennially`,`gid`";
    if ($atts["table_id"] == "") {
        $table_id = uniqid();
    }


## Getting groups
    $Q = "SELECT `id`,`name`,`hidden` FROM `" . whmp_get_product_group_table_name() . "` WHERE 1";

    if ($atts["groups"] <> "") {
        $group = explode(",", $atts["groups"]);
        $Q .= " AND (";
        foreach ($group as $g) {
            if (is_numeric($g)) {
                $Q .= "`id`='" . $g . "' OR ";
            } else {
                $Q .= "`name`='" . $g . "' OR ";
            }
        }
        $Q = substr($Q, 0, -4) . ")";
        //$Q .= " g.`name`='".implode("' OR g.`name`='",$group)."')";
    }
    $Q .= " ORDER BY `order`";

    $Groups = $wpdb->get_results($Q, ARRAY_A);


    $rows = [];
    foreach ($Groups as $group) {
        $Q = "SELECT $fields, pd.`description`,pd.`hidden`,pd.`paytype` FROM `" . whmp_get_products_table_name() . "` pd,
	`" . whmp_get_pricing_table_name() . "` pr
	WHERE pd.`gid`='{$group["id"]}' AND pr.`relid`=pd.`id` AND pr.`currency`='$currency' AND pr.`type`='{$atts["type"]}'";

        if (strtolower($showhidden) == "no") {
            $Q .= " AND `hidden`='0' ";
        }
        if ($atts["name"] <> "") {
            $Q .= " AND `name` LIKE '%{$atts["name"]}%'";
        }
        $Q .= " GROUP BY pr.relid ORDER BY pd.`gid`, pd.`name`";
        $result = $wpdb->get_results($Q, ARRAY_A);

        foreach ($result as $row) {
            $row["groupn"] = $group["name"];
            $rows[] = $row;
            $All_simple_descriptions[] = $WHMPress->Description2Array($row['description'], $atts['description_columns'], ':', '4', '1');
        }
    }
    foreach ($All_simple_descriptions[0] as $feature => $value) {
        $labelfields[] = $feature;
    }

    $decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);


    if (isset($_GET['product_id'])) {
        ?>
        <?php
        $rows = [];
        $pid = $_GET['product_id'];
        foreach ($Groups as $group) {
            $Q = "SELECT $fields, pd.`description`,pd.`hidden`,pd.`paytype` FROM `" . whmp_get_products_table_name() . "` pd,
	`" . whmp_get_pricing_table_name() . "` pr
	WHERE pd.`id`=$pid AND pd.`gid`='{$group["id"]}' AND pr.`relid`=pd.`id` AND pr.`currency`='$currency' AND pr.`type`='{$atts["type"]}'";

            if (strtolower($showhidden) == "no") {
                $Q .= " AND `hidden`='0' ";
            }
            if ($atts["name"] <> "") {
                $Q .= " AND `name` LIKE '%{$atts["name"]}%'";
            }
            $Q .= " GROUP BY pr.relid ORDER BY pd.`gid`, pd.`name`";
            $result = $wpdb->get_results($Q, ARRAY_A);

            foreach ($result as $row) {
            }
        }
        $detail_cols = $atts['detail_page_billing_cycle'];
        $detail_dfields = "monthly,quarterly,semiannually,annually,biennially,triennially";
        $detail_page_billing_cycle = !empty($detail_cols) ? explode(',', $detail_cols) : explode(',', $detail_dfields);
        foreach ($detail_page_billing_cycle as $dtp) {
            $detail_billing_array[ucfirst($dtp)] = $row[$dtp];
        }

        $detail_page_billing_for_order_button = isset($_COOKIE['detail_page_billing_for_order_button']) ? $_COOKIE['detail_page_billing_for_order_button'] : '';
        ob_start(); ?>
        <div class="whcom_row row-content">
            <div class="whcom_col_6 right-side-border">
                <ul class="list-items side-barleft">
                    <?php foreach ($detail_billing_array as $billing_label => $billing_value) { ?>
                        <li>
                            <label class="detail_billing_radio <?php echo $detail_page_billing_for_order_button == lcfirst($billing_label) ? "detail_billing_radio_checked" : ""; ?>"><input
                                        class="detail_billing_radio" type='radio' name="detailed_billing_cycle"
                                        value="<?php echo lcfirst($billing_label) ?>"> <?php echo $billing_label ?>
                            </label></li>
                    <?php } ?>

                </ul>
            </div>
            <div class="whcom_col_6">
                <ul class="list-unstyled list-items side-baright" style="text-align: center;">
                    <?php foreach ($detail_billing_array as $billing_label => $billing_value) { ?>
                        <li><b> <?php echo $currency_prefix . " " . $billing_value ?></b></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <?php

        $detail_section_summary_area = ob_get_clean();
        $append_order_url = $atts["append_order_url"];
        $order_button = whmpress_order_button_function(["id" => $row["id"], "currency" => $currency, "params" => "$append_order_url"]);
        $data["order_url"] = $order_button;

        $detail_order_button = whmpress_order_button_function(["id" => $row["id"], "currency" => $currency, "params" => "$append_order_url", "billingcycle" => "$detail_page_billing_for_order_button"]);


        $description = $row['description'];
        $description = trim(strip_tags($description, '<strong><s><del><strike>'), "\n");
        $description = explode("\n", $description);
        $section_index = 0;
        $description_section_index = 0;
        $description_section = [];
        $plan = array();
        foreach ($description as $line) {
            if (strpos($line, "--") !== false && strpos($line, "--", 3) == true) {
                $description_section_index = $section_index;
                $section = str_replace("--", "", $line);
                $group_para["section"][$section_index] = $section;
                $section_index++;
            } else {
                $strpos = strpos($line, ":");
                $feature = substr($line, 0, $strpos);
                $value = trim(substr($line, $strpos + 1));

                $plan["description_section"][$description_section_index][$feature] = [
                    "feature" => $feature,
                    "value" => $value,
                ];

            }
        }
        if (isset($group_para)) {
            $all_array = array_merge($description, $group_para, $plan);
            $WHMPress = new WHMPress;
            $x = 0;
            $section = '';
            $group = $all_array;
            $dec_array = $description;
            $section_features = [];


            ## if description is not extis
            if (strtolower(trim($group['section'][0])) != "description") {
                array_unshift($group["section"], "");
                array_unshift($group['description_section'], []);
            }

            ## if Highlights is not extis
            if (strtolower(trim($group['section'][1])) != "highlights") {
                array_unshift($group["section"], "");
                array_unshift($group['description_section'], []);
            }

            foreach ($group["section"] as $title) {
                $section_title = $title . "\n";

                $features_set = false;
                $section_values = '';

                foreach ($group["description_section"] as $plan) {

                    if ($features_set == false) {
                        $value = whmpress_feature_row_html($group['description_section'][$x]);
                        array_push($section_features, $value);
                        $features_set = true;
                    }
                }


                $section .= $section_title;
                $x++;
            }
            $call_back_func = true;
        }
        ?>

        <!-- HTML -->
        <style>
            .wpb_wrapper {
                display: none;
            }
        </style>
        <?php
        if (isset($call_back_func)) {

            $WHMPress = new WHMPress;
            $html_template = $WHMPress->check_template_file($atts["html_template"], "whmpress_price_matrix_extended");
            $html_template = substr($html_template, 0, strpos($html_template, "."));
            $html_template = $html_template . "_details_section.tpl";

            foreach ($description as $line) {
                if (trim($line) <> "") {
                    $data = [];
                    $data["feature"] = $line;
                    $totay = explode(":", $line);

                    $tooltip_data = $WHMPress->return_tooltip(trim($totay[0]));
                    $data["feature_title"] = trim($totay[0]);
                    $data["feature_value"] = isset($totay[1]) ? trim($totay[1]) : "";
                    $data["tooltip_text"] = stripcslashes($tooltip_data['tooltip_text']);
                    $data["icon_class"] = $tooltip_data['icon_class'];
                }
                $product_title[] = !empty($data["feature_title"]);
                $product_value[] = !empty($data["feature_value"]);
                $compl_product[] = !empty($data["feature_title"]) . ": " . !empty($data["feature_value"]);
                $product_tooptip[] = !empty($data["tooltip_text"]);
            }

            $vars = [
                "product_headings" => $group['section'],
                "product_headings_desc" => $section_features,
                "product_name" => $row["name"],
                "currency_prefix" => $currency_prefix,
                "product_tooptip" => $product_tooptip,
                "product_prices" => $detail_billing_array,
                "detail_section_summary_area" => $detail_section_summary_area,
                "order_button" => $order_button,
                "detail_order_button" => $detail_order_button,
                "complete_product" => '',
                "whmpress_path" => WHMP_PLUGIN_URL,
            ];
            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_price_matrix_extended");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            echo $OutputString;

        } else {

            # Check if template file exists in theme folder
            $WHMPress = new WHMPress;
            $html_template = $WHMPress->check_template_file($atts["html_template"], "whmpress_price_matrix_extended");
            $html_template = substr($html_template, 0, strpos($html_template, "."));
            $html_template = $html_template . "_details.tpl";
            foreach ($description as $line) {
                if (trim($line) <> "") {
                    $data = [];
                    $data["feature"] = $line;
                    $totay = explode(":", $line);

                    $tooltip_data = $WHMPress->return_tooltip(trim($totay[0]));
                    $data["feature_title"] = trim($totay[0]);
                    $data["feature_value"] = isset($totay[1]) ? trim($totay[1]) : "";
                    $data["tooltip_text"] = stripcslashes($tooltip_data['tooltip_text']);
                    $data["icon_class"] = $tooltip_data['icon_class'];
                }
                $product_title[] = $data["feature_title"];
                $product_value[] = $data["feature_value"];
                $compl_product[] = $data["feature_title"] . ": " . $data["feature_value"];
                $product_tooptip[] = $data["tooltip_text"];
            }
            $vars = [
                "product_name" => $row["name"],
                "product_title" => $product_title,
                "product_value" => $product_value,
                "complete_product" => $compl_product,
                "product_tooptip" => $product_tooptip,
                "currency_prefix" => $currency_prefix,
                "product_prices" => $detail_billing_array,
                "detail_order_button" => $detail_order_button,
                "detail_section_summary_area" => $detail_section_summary_area,
                "product_annual_price" => number_format($row['annually'], 0, '.', ''),
                "product_biennially_price" => number_format($row['biennially'], 0, '.', ''),
                "product_triennially_price" => number_format($row['triennially'], 0, '.', ''),
                "order_button" => $order_button,
            ];
            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_price_matrix_extended");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            echo $OutputString;
        }
        ?>
    <?php } else {

# Generating output string
        if ($cols <> "") {
            unset($fieldss["monthly"], $fieldss["quarterly"], $fieldss["semiannually"], $fieldss["annually"], $fieldss["biennially"], $fieldss["triennially"]);
            $cols = explode(",", $cols);
            foreach ($cols as $col) {
                $fieldss[trim($col)] = $dfieldss[trim($col)];
            }
        }
        if (strtolower($ShowPrice) == "no") {
            unset($fieldss["monthly"], $fieldss["quarterly"], $fieldss["semiannually"], $fieldss["annually"], $fieldss["biennially"], $fieldss["triennially"]);
        }

        if ($atts["data_table"] == '1' || strtolower($atts["data_table"]) == 'yes') {
            $str = "<script>
	jQuery(function(){
		jQuery('table#{$table_id}').DataTable();
	});
</script>\n";
        } else {
            $str = "<script>
	jQuery(function(){
		jQuery('input#search_price_table').quicksearch('table#{$table_id} tbody tr');
	});
</script>\n";
        }

        $str .= "<table style='width:100%' border='1' id='{$table_id}'>
	<thead>
	<tr>";
        if ($atts["titles"] == "") {
            $titles = [];
        } else {
            $titles = explode(",", $atts["titles"]);
        }
        $x = 0;
        foreach ($fieldss as $k => $field) {
            if (isset($titles[$x])) {
                $t = trim($titles[$x]);
            } else {
                $t = trim($field, "`");
            }
            //$t = trim($field,"`");
            if ($k == "groupn") {
                $k = "group";
            }
            $smarty_title = $k . "_title";
            $$smarty_title = $t;

            $str .= "<th>" . $t . "</th>";

            $x++;
        }
// Show order link column
        if ($atts["order_link"] == "1" || strtolower($atts["order_link"]) == "yes") {
            $str .= "<th></th>";
        }
        $str .= "<th></th>";
        $str .= "</tr>
	</thead>
	<tbody>\n";

        $smarty2["table_id"] = $table_id;
        $smarty2["data_table"] = $atts["data_table"];
        $smarty2["total_records"] = count($rows);
        $smarty2["hide_search"] = $atts["hide_search"];
        $smarty_array = [];
        $description_extended_array = [];
        foreach ($rows as $key => $row) {
            foreach ($row as &$kr) {
                $kr = whmpress_encoding($kr);
            }
            $data = [];
            $str .= "<tr>";
            if (!in_array("sr", $hide_columns)) {
                $str .= "<td data-content=\"Sr\">" . ($key + 1) . "</td>";
                $data["sr"] = $key + 1;
            } else {
                $data["sr"] = "";
            }

            $x = 0;
            foreach ($fieldss as $k => $field) {
                if ($k <> "sr") {
                    if (isset($titles[$x])) {
                        $t = trim($titles[$x]);
                    } else {
                        $t = trim($field, "`");
                    }
                    if ($k == "id" || $k == "name" || $k == "groupn") {
                        $str .= "<td data-content=\"{$t}\">" . $row[$k] . "</td>";

                        if ($k == "groupn") {
                            $data["group"] = $row[$k];
                        } else {
                            $data[$k] = $row[$k];
                        }
                    } else {
                        $v = $row[$k];

                        $tmp1 = whmp_price_i(
                            [
                                'id' => $row["id"],
                                'billingcycle' => $k,
                                'currency_id' => $currency,
                            ]
                        );

                        $tmp2 = whmp_format_price_i(
                            [
                                'price' => $tmp1['price'],
                                'paytype' => $tmp1['paytype'],
                            ]
                        );

                        $tmp3 = whmp_format_price_essentials_i(
                            [
                                'price' => $tmp2,
                                'paytype' => $tmp1['paytype'],
                                'billingcycle' => $k,
                                'duration_connector' => "",
                                'duration_style' => 'none',
                                'currency_id' => $currency,
                            ]
                        );

                        $price = $tmp3;
                        $v = $price['price'];
                        $str .= "<td data-content=\"{$t}\">" . $v . "</td>";
                        $data[$k] = $v;
                    }
                }
                $x++;
            }

            $append_order_url = $atts["append_order_url"];
            $order_button = whmpress_order_button_function(["id" => $row["id"], "currency" => $currency, "params" => "$append_order_url"]);
            $data["order_url"] = $order_button;
            $data["description"] = whmpress_description_function([
                "id" => $row["id"],
                "no_wrapper" => "1",
                "show_as" => "1",
            ]);

            $data["description_extended"] = whmpress_description_extended_function([
                "id" => $row["id"],
                "no_wrapper" => "1",
                "show_as" => "1",
            ]);

            if ($atts["order_link"] == "1" || strtolower($atts["order_link"]) == "yes") {
                $str .= "<td>" . $order_button . "</td>";
            }
            $detailr_button = whmpress_order_button_function(["id" => $row["id"], "currency" => $currency, "params" => "$append_order_url"]);
            $pid = $row['id'];
            $str .= "<td>" . "<button class='whmpress whmpress_order_button' type='button' onclick=\"window.location.href = '?product_id=$pid';\">Details</button>" . "</td>";
            $str .= "</tr>\n";
            $data["detail_url"] = "<button class='whmpress whmpress_order_button' type='button' onclick=\"window.location.href = '?product_id=$pid';\">Details</button>";
            $smarty_array[] = $data;
            $description_extended_array[] = $data["description_extended"];
        }
        $str .= "
	</tbody>
</table>";

        $html_template = $WHMPress->check_template_file($atts['html_template'], "whmpress_price_matrix_extended");

        if (is_file($html_template)) {
            $sr_title = (in_array("Sr", $fieldss)) ? $sr_title : "";
            $id_title = (in_array("ID", $fieldss)) ? $id_title : "";
            $name_title = (in_array("Name", $fieldss)) ? $name_title : "";
            $group_title = (in_array("Group", $fieldss)) ? $group_title : "";
            $monthly_title = (in_array("Monthly", $fieldss)) ? $monthly_title : "";
            $quarterly_title = (in_array("3 Months", $fieldss)) ? $quarterly_title : "";
            $semiannually_title = (in_array("6 Months", $fieldss)) ? $semiannually_title : "";
            $annually_title = (in_array("Yearly", $fieldss)) ? $annually_title : "";
            $biennially_title = (in_array("2 Years", $fieldss)) ? $biennially_title : "";
            $triennially_title = (in_array("3 Years", $fieldss)) ? $triennially_title : "";


            $template_name = explode('/', $html_template);
            $template_name = end($template_name);
            if ($template_name == 'creativeon-dedicated-sale.html') {
                $hardcoded_features_array = array(
                    array(
                        "feature" => "Data Transfer: 50 TB",
                        "feature_title" => "Data Transfer",
                        "feature_value" => "50 TB"
                    ),
                    array(
                        "feature" => "Free Internal Transfers: Yes",
                        "feature_title" => "Free Internal Transfers",
                        "feature_value" => "Yes"
                    ),
                    array(
                        "feature" => "Free Unlimited Inward Transfer: Yes",
                        "feature_title" => "Free Unlimited Inward Transfer",
                        "feature_value" => "Yes"
                    ),
                    array(
                        "feature" => "IPv4 Address: 1",
                        "feature_title" => "IPv4 Address",
                        "feature_value" => "1"
                    ),
                    array(
                        "feature" => "IPv6 Address: Complete /64 subnet",
                        "feature_title" => "IPv6 Address",
                        "feature_value" => "Complete /64 subnet"
                    ),
                    array(
                        "feature" => "Reverse DNS: Yes",
                        "feature_title" => "Reverse DNS",
                        "feature_value" => "Yes"
                    ),
                    array(
                        "feature" => "Free Basic Support: Yes",
                        "feature_title" => "Free Basic Support",
                        "feature_value" => "Yes"
                    ),
                );
                foreach ($smarty_array as $single_array) {

                    $count = 0;
                    foreach ($single_array['description_extended'] as $single_desc){
                        if($count == 3){ break; }
                        $single_array['description_extended'][1][] = $single_desc;
                        $count++;
                    }
                    $single_array['description_extended'][0] = array();
                    $single_array['description_extended'][2] = $hardcoded_features_array;
                    unset($single_array['description_extended'][1]['feature']);
                    unset($single_array['description_extended'][1]['feature_title']);
                    unset($single_array['description_extended'][1]['feature_value']);
                    unset($single_array['description_extended'][1]['tooltip_text']);
                    unset($single_array['description_extended'][1]['icon_class']);
                    unset($single_array['description_extended'][3]);
                    unset($single_array['description_extended'][4]);
                   //$appended_array = array_merge($single_array['description_extended'][2],$hardcoded_features_array);
                   //$single_array['description_extended'][2] = $appended_array;
                   $smarty_appended_array[] = $single_array;
                }
                $smarty_array = $smarty_appended_array;
            }

            //ppa($smarty_array);
            $vars = [
                "search_label" => $atts["search_label"],
                "search_text_box" => "<input id='whmpress_text_box' type='search' placeholder='" . __($atts["search_placeholder"], "whmpress") . "'>",
                "price_matrix_table" => $str,
                "sr_title" => $sr_title,
                "id_title" => $id_title,
                "name_title" => $name_title,
                "group_title" => $group_title,
                "custom_description_label" => $labelfields,
                "description_column" => $atts['description_columns'],
                "monthly_title" => $monthly_title,
                "quarterly_title" => $quarterly_title,
                "semiannually_title" => $semiannually_title,
                "annually_title" => $annually_title,
                "biennially_title" => $biennially_title,
                "triennially_title" => $triennially_title,
                "currency_prefix" => $currency_prefix,
                "data" => $smarty_array,
                "description_extended" => $description_extended_array,
                "params" => $smarty2,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_price_matrix_extended");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            # Adding search box if hide_search is not called
            $search_box = "";
            if (strtolower($atts["hide_search"]) <> "yes") {
                if ($atts["data_table"] == '1' || strtolower($atts["data_table"]) == 'yes') {
                    // Do not include search box
                } else {
                    $search_box = "
<label>{$atts["search_label"]}</label>
<input type='search' placeholder='" . __($atts["search_placeholder"], "whmpress") . "' id='search_price_table' style='width:50%' >";
                }
            }

            # Returning output string including wrapper div
            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $html_class = $atts['html_class'];
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            return "<div $CLASS $ID>" . $search_box . $str . "</div>";
        }
    }
} ?>
<script>
    jQuery('input.detail_billing_radio').on('change', function () {
        jQuery('li label.detail_billing_radio_checked').removeClass('detail_billing_radio_checked');
        jQuery(this).closest('label').addClass("detail_billing_radio_checked");
        var value = jQuery(this).val();
        document.cookie = 'detail_page_billing_for_order_button=' + value;
        window.location.reload();
    });
</script>