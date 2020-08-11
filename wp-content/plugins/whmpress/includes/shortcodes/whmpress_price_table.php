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



$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    $html= "<div style='color: red;' '>WHMCS is not yet synced</div>";
    $html=$html. "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
    return $html;
}
else {

    extract(shortcode_atts([
        'html_template' => '',
        'name' => '',
        'groups' => '',
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
    ], $atts));

    if (!defined('WCAP_VERSION')) {
        if ($data_table == "yes") {
            //echo '<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">' . PHP_EOL;
            wp_enqueue_script('whmp_dataTables', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.js', ['jquery'], false, true);
            wp_enqueue_style('whmp_dataTables-style', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.css');
        }
    }

    $WHMPress = new WHMPress;

    $cols = $billingcycles;
    $showhidden = $show_hidden;

    if (!isset($currency)) {
        $currency = "";
    }
    $currency = whmp_get_currency($currency);

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

    $hide_columns = explode(",", $hide_columns);
    foreach ($hide_columns as $hd) {
        if (strtolower($hd) == "group") {
            $hd = "groupn";
        }
        $hd = trim($hd);
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
    if ($table_id == "") {
        $table_id = uniqid();
    }

## Getting groups
    $Q = "SELECT `id`,`name`,`hidden` FROM `" . whmp_get_product_group_table_name() . "` WHERE 1";

    if ($groups <> "") {
        $group = explode(",", $groups);
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
	WHERE pd.`gid`='{$group["id"]}' AND pr.`relid`=pd.`id` AND pr.`currency`='$currency' AND pr.`type`='{$type}'";

        if (strtolower($showhidden) == "no") {
            $Q .= " AND `hidden`='0' ";
        }
        if ($name <> "") {
            $Q .= " AND `name` LIKE '%{$name}%'";
        }
        $Q .= " GROUP BY pr.relid ORDER BY pd.`gid`, pd.`name`";
        $result = $wpdb->get_results($Q, ARRAY_A);

        foreach ($result as $row) {
            $row["groupn"] = $group["name"];
            $rows[] = $row;
        }
    }


    $decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);

# Generating output string
    if ($cols <> "") {
        unset($fieldss["monthly"], $fieldss["quarterly"], $fieldss["semiannually"], $fieldss["annually"], $fieldss["biennially"], $fieldss["triennially"]);
        $cols = explode(",", $cols);
        foreach ($cols as $col) {
            $fieldss[trim($col)] = $dfieldss[trim($col)];
        }
    }

    if ( $data_table == '1' || strtolower( $data_table ) == 'yes' ) {
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
    if ($titles == "") {
        $titles = [];
    } else {
        $titles = explode(",", $titles);
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
    if ($order_link == "1" || strtolower($order_link) == "yes") {
        $str .= "<th></th>";
    }
    $str .= "</tr>
	</thead>
	<tbody>\n";

    $smarty2["table_id"] = $table_id;
    $smarty2["data_table"] = $data_table;
    $smarty2["total_records"] = count($rows);
    $smarty_array = [];
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

        $order_button = whmpress_order_button_function(["id" => $row["id"], "currency" => $currency]);
        $data["order_url"] = $order_button;
        $data["description"] = whmpress_description_function([
            "id" => $row["id"],
            "no_wrapper" => "1",
            "show_as" => "1",
        ]);

        if ($order_link == "1" || strtolower($order_link) == "yes") {
            $str .= "<td>" . $order_button . "</td>";
        }
        $str .= "</tr>\n";
        $smarty_array[] = $data;
    }
    $str .= "
	</tbody>
</table>";

    $html_template = $WHMPress->check_template_file($html_template, "whmpress_price_matrix");

    if (is_file($html_template)) {
        $vars = [
            "search_label" => $search_label,
            "search_text_box" => "<input id='whmpress_text_box' type='search' placeholder='" . __($search_placeholder, "whmpress") . "'>",
            "price_matrix_table" => $str,
            "sr_title" => $sr_title,
            "id_title" => $id_title,
            "name_title" => $name_title,
            "group_title" => $group_title,
            "monthly_title" => $monthly_title,
            "quarterly_title" => $quarterly_title,
            "semiannually_title" => $semiannually_title,
            "annually_title" => $annually_title,
            "biennially_title" => $biennially_title,
            "triennially_title" => $triennially_title,
            "data" => $smarty_array,
            "params" => $smarty2,
        ];

        # Getting custom fields and adding in output
        $TemplateArray = $WHMPress->get_template_array("whmpress_price_matrix");
        foreach ($TemplateArray as $custom_field) {
            $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
        }

        $OutputString = whmp_smarty_template($html_template, $vars);

        return $OutputString;
    } else {
        # Adding search box if hide_search is not called
        $search_box = "";
        if (strtolower($hide_search) <> "yes") {
            if ($data_table == '1' || strtolower($data_table) == 'yes') {
                // Do not include search box
            } else {
                $search_box = "
<label>{$search_label}</label>
<input type='search' placeholder='" . __($search_placeholder, "whmpress") . "' id='search_price_table' style='width:50%' >";
            }
        }

        # Returning output string including wrapper div
        $ID = !empty($html_id) ? "id='$html_id'" : "";
        $CLASS = !empty($html_class) ? "class='$html_class'" : "";

        return "<div $CLASS $ID>" . $search_box . $str . "</div>";
    }
}