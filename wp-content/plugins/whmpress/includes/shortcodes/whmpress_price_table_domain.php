<?php
//$html = include (WHMP_PLUGIN_DIR."/includes/shortcodes/whmpress_price_table_domain.php");
/**
 * Displays customized price table only for domain
 *
 * List of parameters
 * table_id = HTML id for HTML table.
 * html_id = HTML id for wrapper div of table.
 * html_class = HTML class for wrapper div of table.
 * currency = Set currency for prices, Leave this parameter for default currency.
 * hide_search = Yes or No for hide search
 * show_tlds = provide comma seperated tlds e.g. .com,.net,.org or leave it blank for all tlds
 * show_tlds_wildcard = provide tld search as wildcard, e.g. pk for all .pk domains or co for all com and .co domains
 * decimals = Decimals for price, default 2
 * cols = Number of columns for result in, default 1
 * show_renewel = Show domain renewal price, Yes or No
 * show_transfer = Show domain transfer price, Yes or No
 * titles = Comma separated titles for column titles
 * search_label = Set label for search
 * search_placeholder = Set placeholder for search box
 * show_disabled = Show disabled domains yes or no.. (Disabled in WHMCS)
 */


if (!isset ($atts)){$atts=[];}


$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    $html = "<div style='color: red;' '>WHMCS is not yet synced</div>";
    $html = $html . "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
    return $html;
}
else {
    $atts=shortcode_atts([
        'html_template' => '',
        'table_id' => '',
        'html_id' => '',
        'html_class' => 'whmpress whmpress_price_matrix_domain',
        'hide_search' => whmpress_get_option('pmd_hide_search'),
        'currency' => '',
        'show_tlds' => '',
        'show_tlds_wildcard' => '',
        'decimals' => whmpress_get_option('pmd_decimals'),
        'show_renewel' => whmpress_get_option('pmd_show_renewel'),
        'show_transfer' => whmpress_get_option('pmd_show_transfer'),
        'titles' => '',
        'search_label' => whmpress_get_option('pmd_search_label'),
        'search_placeholder' => whmpress_get_option('pmd_search_placeholder'),
        "show_disabled" => whmpress_get_option('pmd_show_disabled'),
        'pricing_slab' => "0",
        'combine_extension' => '',                          # Price, PriceCC
        'data_table' => '0',
        'num_of_rows' => whmpress_get_option('pmd_num_of_rows'),
        'replace_empty' => '-',
        'show_type' => '0',
        'style' => '',
        'show_addons' => 'yes',
        'style1' => '',
        'show_restore' => 'no',
    ], $atts);

    if (!defined('WCAP_VERSION')) {
        if ($atts['data_table'] == "yes") {
            //echo '<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">' . PHP_EOL;
            wp_enqueue_script('whmp_dataTables', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.js', ['jquery'], false, true);
            wp_enqueue_style('whmp_dataTables-style', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.css');
        }
    }



    //== Added by zain
    $currency = !empty($atts['currency'])? whmp_get_currency($atts["currency"]): whmp_get_current_currency_id_i();
    //$currency = whmp_get_currency($atts["currency"]);


    $combine_extension = strtolower(trim($atts["combine_extension"]));
    if ($atts["table_id"] == "") {
        $table_id = 'table' . rand(111, 999);
    }

# Getting WordPress DB object
    global $wpdb;

# Getting symbol type
    $symbol_type = strtolower(whmpress_get_option('default_currency_symbol'));

# Getting data from database
    $c = "";

    if ($atts["num_of_rows"] == "Default" || $atts["num_of_rows"] == 10) {
        $num_of_rows = whmpress_get_option('pmd_num_of_rows');
    }

    $WHMPress = new WHMPress();

    /*
    msetupfee = 1 Year
    qsetupfee = 2 Years
    ssetupfee = 3 Years
    asetupfee = 4 Years
    bsetupfee = 5 Years
    monthly = 6 Years
    quarterly = 7 Years
    semiannually = 8 Years
    annually = 9 Years
    biennially = 10 Years
    */

//Create a variable for start time
    $time_start = microtime(true);

    $Q = "SELECT dpt.`id` id, ";
    if ($combine_extension == "price" || $combine_extension == "pricecc") {
        $Q .= "GROUP_CONCAT(`extension` SEPARATOR ', ') extension";
    } else {
        $Q .= "dpt.`extension`, dpt.`dnsmanagement`, dpt.`emailforwarding`, dpt.`idprotection`, dpt.`order`, dpt.`group`";
    }
    $Q .= ", `msetupfee`, `qsetupfee` FROM `" . whmp_get_pricing_table_name() . "` pt, `" . whmp_get_domain_pricing_table_name() . "` dpt WHERE dpt.id=`relid` AND
    `type`='[[[type]]]' AND `currency`=" . $currency;
    if (strtolower($atts["show_disabled"]) == "no" || $atts["show_disabled"] == "0" || $atts["show_disabled"] == false) {
        $Q .= " AND (`msetupfee`>0 OR `qsetupfee`>0)";
    }
    if (whmp_is_table_exists(whmp_get_clientgroups_table_name()) && !empty($pricing_slab)) {
        $Q .= " AND `tsetupfee` IN (SELECT `id` tsetupfee FROM `" . whmp_get_clientgroups_table_name() . "` WHERE id='$pricing_slab' OR `groupname`='$pricing_slab')";
    } else {
        $Q .= " AND `tsetupfee`='0'";
    }


// Get Addon pricing if enabled.

    if (trim($atts["show_tlds"]) <> "") {
        $show_tlds = explode(",", $atts["show_tlds"]);
        $show_tlds = "'" . implode("','", $show_tlds) . "'";
        $Q .= " AND `extension` IN (" . $show_tlds . ")";
    } else if (trim($atts["show_tlds_wildcard"]) <> "") {
        $Q .= " AND `extension` LIKE '%" . $atts["show_tlds_wildcard"] . "%'";
    }

    if ($combine_extension == "pricecc") {
        $Q .= " AND `extension` IN (SELECT `extension` FROM `" . whmp_get_domain_pricing_table_name() . "` WHERE LENGTH(`extension`)-LENGTH(REPLACE(`extension`,'.',''))='2')";
    }

    if ($combine_extension == "price" || $combine_extension == "pricecc") {
        $Q .= " GROUP BY `msetupfee`, `qsetupfee`";
    }

    $Q .= " ORDER BY `order`";

    $type = "domainregister";
    $Q = str_replace("[[[type]]]", $type, $Q);


    $rows = $wpdb->get_results($Q, ARRAY_A);

    $type = "domainrenew";

    $rows2 = $wpdb->get_results(str_replace("[[[type]]]", $type, $Q), ARRAY_A);

    $type = "domaintransfer";

    $rows3 = $wpdb->get_results(str_replace("[[[type]]]", $type, $Q), ARRAY_A);


    /*$time_end = microtime(true);
    $time = $time_end - $time_start;
    echo "<br>query response. = ".$time;
    $time_start = microtime(true);*/


    /*
     * Add Categories
     */
//if ($show_type=='yes'  )
    {
        foreach ($rows as $k => $row) {
            $cats = $WHMPress->get_tld_categories($row['extension']);
            $rows[$k]['categories'] = implode(", ", $cats);
        }
    }

    /*$time_end = microtime(true);
    $time = $time_end - $time_start;
    echo "<br>categories. = ".$time;
    $time_start = microtime(true);*/

    /*
     * Add Addons
     */
    $tlds_data = [];

    if ($atts["show_addons"] == 'yes') {
        $tmp = $WHMPress->get_domain_addon_price();

        foreach ($rows as &$row) {
            //Check if addon is enabled, if so set its value.
            if ($row['dnsmanagement'] == "1") {
                $row['dnsmanagement'] = $tmp['msetupfee'];
            } else {
                $row['dnsmanagement'] = "-1";
            }

            if ($row['emailforwarding'] == "1") {
                $row['emailforwarding'] = $tmp['qsetupfee'];
            } else {
                $row['emailforwarding'] = -1;
            }
            if ($row['idprotection'] == "1") {
                $row['idprotection'] = $tmp['ssetupfee'];
            } else {
                $row['idprotection'] = -1;
            }
        }
    }

//$row['dnsmanagement']=$WHMPress->get_domain_adon_price();


    /*$time_end = microtime(true);
    $time = $time_end - $time_start;
    echo "<br>Addons. = ".$time;
    $time_start = microtime(true);*/

    /*
     * Add Price Info
     */
    foreach ($rows as &$row) {
        $add_data = $WHMPress->get_domain_additional_data($row['id']);


        $row = array_merge($row, $add_data);
//    ppa($row,"rowarray");

        $temp = $WHMPress->get_domain_price_bulk([
            "extension" => $row['extension'],
            "currency" => $currency,
            "pricing_slab" => $atts['pricing_slab'],
        ]);

//    ppa($temp,"temp");


        $row["registration-1"] = $temp["registration"]["1"];
        $row["registration-2"] = $temp["registration"]["2"];
//    if($pricing_slab==0){
/*        $row["registration-1"] = $row["msetupfee"];
        $row["registration-2"] = $row["qsetupfee"];

        $row["renewal-1"] = $row["msetupfee"];
        $row["renewal-2"] = $row["qsetupfee"];

        $row["transfer-1"] = $row["msetupfee"];
        $row["transfer-2"] = $row["qsetupfee"];*/
//    }else {

        $row["registration-1"] = $temp["registration"]["1"];
        $row["registration-2"] = $temp["registration"]["2"];

        $row["renewal-1"] = $temp["renewal"]["1"];
        $row["renewal-2"] = $temp["renewal"]["2"];

        $row["transfer-1"] = $temp["transfer"]["1"];
        $row["transfer-2"] = $temp["transfer"]["2"];
//    }

        $row["registration"] = $temp["registration"];
        $row["renew"] = $temp["renewal"];
        $row["transfer"] = $temp["transfer"];

        unset ($row["msetupfee"]);
        unset ($row["qsetupfee"]);
        // select minimum years
        // check if minimum is years
        if (floatval($temp["registration"]["1"]) < 0 && floatval($temp["registration"]["2"]) > 0) {
            $field = "qsetupfee";
            $row["_registration"] = $temp["registration"]["2"];;
            $row["_transfer"] = $temp["transfer"]["2"];;
            $row["_renewal"] = $temp["renewal"]["2"];;
            $row["_years"] = 2;
        // check if minimum is one year
        } elseif (floatval($temp["registration"]["1"]) > 0) {
            $field = "msetupfee";
            $row["_registration"] = $temp["registration"]["1"];
            $row["_transfer"] = $temp["transfer"]["1"];
            $row["_renewal"] = $temp["renewal"]["1"];
            $row["_years"] = 1;
        } else {
            $field = $atts["replace_empty"];
            $row["_registration"] = $atts["replace_empty"];
            $row["_transfer"] = $atts["replace_empty"];
            $row["_renewal"] = $atts["replace_empty"];
            $row["_years"] = $atts["replace_empty"];
        }
        $tlds_data[] = $row;
    }


    /*$time_end = microtime(true);
    $time = $time_end - $time_start;
    echo '<br> Price = '.$time.' seconds';
    $time_start = microtime(true);*/

//todo: leave current arrays as its and bigger array like
    /*
    extension
    dns
    email
    order
    group
    promo-text
    promo-detail
    redumption
    register
        >> years > price
    treansfer
        >> years > price
    renewal
        >> years > price

     */

# Generating output string
    $str = "";
// Adding search box if hide_search is not called

// If data_table parameter is set 1 or true then add javascript to initilize dataTable
// https://datatables.net/
    if ($atts["data_table"] == '1' || strtolower($atts["data_table"]) == 'yes') {
        $str .= "\n<script>
        jQuery(function(){
            jQuery('table#{$table_id}').DataTable({
                \"iDisplayLength\": $num_of_rows
            });
        });
        </script>\n";
    }

    if ($atts["style1"] == "style_1" || $atts["style1"] == "style_2") {
        //do nothing
    }
    else {
        if (strtolower($atts["hide_search"]) == "yes") {
            $str .= "<script>
            jQuery(function(){
                jQuery('input#search_{$table_id}').quicksearch('table#{$table_id} tbody tr');
            });
            </script>";
        }
    }

    $table = $top = $head = $trow = $trows = $tail = '';

    if ($atts["style1"] == "style_1" || $atts["style1"] == "style_2") {
        /*echo "<pre>";
        print_r( $tlds_data );
        echo "</pre>";*/

        // Resetting $str and initializing some necessary variables
        $str = $table_header = '';

        if (strtolower($atts["hide_search"]) == "yes") {

            $table_header = '<div class="whmpress_price_matrix_header"></div>';

            $top = "<script>jQuery(function(){jQuery('input#search_{$table_id}').quicksearch('table#{$table_id} tbody tr');});</script>";

            $search_form = '<div class="whmp_domain_search_container">';
            $search_form .= '<label>' . $atts["search_label"] . '</label>';
            $search_form .= '<input type="search" placeholder="' . __($atts["search_placeholder"], "whmpress") . '" id="search_' . $table_id . '">';
            $search_form .= '</div>';

            // TLD Types Toggle container
            $tld_type_toggles = "";
            if ($atts["show_type"] == 'yes') {
                $tld_types = [
                    'gTLD',
                    'Popular',
                    'ccTLD',
                    'Specialty'
                ];
                $tld_type_toggles = '<div class="whmp_domain_type_toggle_container">';
                $tld_type_toggles .= '<label>'. __("Type", "whmpress") . '</label>';
                $tld_type_toggles .= '<span class="whmp_domain_type_toggle" data-tld-type="all">' .  __("All", "whmpress") . '</span>';
                foreach ($tld_types as $tld_type) {
                    $tld_type_toggles .= '<span class="whmp_domain_type_toggle" data-tld-type="' . $tld_type . '">' . $tld_type . '</span>';
                }
                $tld_type_toggles .= '</div>';
            }

            // TLD Special Toggle Container
            $tld_specials = [
                'hot' => __("Hot", "whmpress"),
                'new' => __('New', "whmpress"),
                'sale' => __('Sale', "whmpress"),
                'promo' => __('Promo', "whmpress"),
            ];
            $tld_special_toggles = '<div class="whmp_domain_special_toggle_container">';
            $tld_special_toggles .= '<label>'.__('Sale', "whmpress").'</label>';
            $tld_special_toggles .= '<span class="whmp_domain_special_toggle" data-tld-special="all">All</span>';
            foreach ($tld_specials as $key => $tld_special) {
                $tld_special_toggles .= '<span class="whmp_domain_special_toggle" data-tld-special="' . $key . '">' . $tld_special . '</span>';
            }
            $tld_special_toggles .= '</div>';


            $table_header = '<div class="whmpress_price_matrix_header">';
            $table_header .= $top . $search_form . $tld_type_toggles . $tld_special_toggles;
            $table_header .= '<div style="clear: both"></div>';
            $table_header .= '</div>';
        }


        $head = '<div class="whmpress whmpress_price_matrix_domain style_1 multi_durations">';
        $head .= $table_header;
        $head .= '<input type="hidden" name="duration" class="duration" value="1">';
        $head .= '<table id="' . $table_id . '">';
        $head .= '<thead>';
        $head .= '<tr>';
        $head .= '<th>' . __('Domain', 'whmpress') . '</th>';
        if ($atts["show_type"] == 'yes') {
            $head .= '<th>' . __('Type', 'whmpress') . '</th>';
        }
        $head .= '<th>' . __('Years', 'whmpress');
        if ($atts["style1"] == "style_2") {
            $head .= '<span class="whmp_no_years"> (1) </span><a href="#" class="duration_minus">-</a><a href="#" class="duration_plus">+</a></th>';
        }
        $head .= '<th>' . __('Register', 'whmpress') . '</th>';
        $head .= '<th>' . __('Transfer', 'whmpress') . '</th>';
        $head .= '<th>' . __('Renew', 'whmpress') . '</th>';
        If ($atts["show_restore"] == "yes") {
            $head .= '<th>' . __('Restore', 'whmpress') . '</th>';
        }
        $head .= '</tr>';
        $head .= '</thead>';

        foreach ($tlds_data as $row) {
            $group_class = $group_span = $group_promo = $group_special = $row_specials = '';

            // build group_class & group_span if needed.
            if (!empty($row['group'])) {
                $group_class .= ' whmp_' . $row['group'];
                $group_special = '<span class="whmp_special whmp_' . $row['group'] . '">' . $row['group'] . '</span>';
                $row_specials .= $row['group'];
            }

            // Build <span> for Promo
            if ($row['promo'] == 1 && (trim($row['promo_text']) != "")) {
                $group_class .= ' whmp_promo';
                $group_promo = '<span class="whmp_promo" title="' . $row['promo_details'] . '">' . $row['promo_text'] . '</span>';
                $row_specials .= 'promo';
            }


            // if it is style_2, insert data for javascript thing.

            $data_price_register = '';
            $data_price_renew = '';
            $data_price_transfer = '';

            if ($atts["style1"] == "style_2") {
                //build data array
                // data content for registration
                foreach ($row['registration'] as $key => $price) {
                    $tmp = whmp_apply_symbol(format_price($price, false, $atts["decimals"]), $symbol_type, $currency);
                    $data_price_register .= 'data-price' . $key . ' = "' . $tmp . '" ';
                }

                // data content for renewal
                foreach ($row['renew'] as $key => $price) {
                    $tmp = whmp_apply_symbol(format_price($price, false, $atts["decimals"]), $symbol_type, $currency);
                    $data_price_renew .= 'data-price' . $key . ' = "' . $tmp . '" ';
                }

                // data content for transfer
                foreach ($row['transfer'] as $key => $price) {
                    $tmp = whmp_apply_symbol(format_price($price, false, $atts["decimals"]), $symbol_type, $currency);
                    $data_price_transfer .= 'data-price' . $key . ' = "' . $tmp . '" ';
                }
            }

            $addon_domains_html = "";
            if ($atts["show_addons"] == 'yes') {

                $addon_domains = [
                    'Domain Forwarding' => [
                        'icon' => '<i class="fa fa-share"></i> ',
                        'price' => $row['dnsmanagement']
                    ],
                    'Email Forwarding' => [
                        'icon' => '<i class="fa fa-check"></i> ',
                        'price' => $row['emailforwarding']
                    ],
                    'Privacy Protection' => [
                        'icon' => '<i class="fa fa-user-secret"></i> ',
                        'price' => $row['idprotection']
                    ]
                ];

                //unset elements that are -1
                foreach ($addon_domains as $addon_key => $addon_domain) {
                    if ($addon_domain['price'] == -1) {
                        //echo "unsetting";
                        unset($addon_domains[$addon_key]);
                    }
                }

                // do not output html if there is no addon to show.

                if ($row['dnsmanagement'] >= 0 || $row['emailforwarding'] >= 0 || $row['idprotection'] >= 0) {

                    $addon_domains_html .= '<div class="whmp_dropdown_outer">';
                    $addon_domains_html .= '<span class="whmp_dropdown_toggle">Add Ons</span>';
                    $addon_domains_html .= '<ul class="whmp_dropdown_inner whmp_domain_addons">';
                    foreach ($addon_domains as $addon_key => $addon_domain) {
                        $addon_domains_html .= '<li>';
                        $addon_domains_html .= $addon_domain['icon'];
                        $addon_domains_html .= '<span class="whmp_addon_label">' . $addon_key . '</span> ';
                        $addon_domains_html .= '<span class="whmp_addon_price">' . $addon_domain['price'] . '</span> ';
                        $addon_domains_html .= '</li>';
                    }
                    $addon_domains_html .= '</ul></div>';
                } // end if there is no addon set for todain
            }//if addon set to yes

            if ($atts["show_type"] == 'yes') {
                $type_filter = ' data-tld-types="' . $row['categories'] . '"';
            } else {
                $type_filter = "";
            }
            $special_filter = ' data-tld-specials="' . $row_specials . '"';

            $trow = '<tr class="whmp_domain_matrix_row ' . $group_class . '"' . $type_filter . $special_filter . '>';
            $trow .= '<td data-content="domain" class="whmp_domain">' . $row['extension'] . $addon_domains_html .
                $group_promo . $group_special . '</td>';
            if ($atts["show_type"] == 'yes') {
                $trow .= '<td data-content="type" class="whmp_type">' . $row['categories'] . '</td>';
            }

            $trow .= '<td data-content="Years" class="whmp_no_years">' . $row["_years"] . '</td>';

            $tmp = whmp_apply_symbol(format_price($row['_registration'], false, $atts["decimals"]), $symbol_type, $currency);
            $trow .= '<td data-content="Register" class="whmp_price whmp_register_price" ' . $data_price_register . '><span class="whmp_show_price">' . $row['promo_register_off'] . '</span><span class="whmp_actual_price">' . $tmp . '</span></td>';

            $tmp = whmp_apply_symbol(format_price($row['_transfer'], false, $atts["decimals"]), $symbol_type, $currency);
            $trow .= '<td data-content="Transfer" class="whmp_price whmp_transfer_price" ' . $data_price_transfer . '><span class="whmp_show_price">' . $row['promo_transfer_off'] . '</span><span class="whmp_actual_price">' . $tmp . '</span></td>';

            $tmp = whmp_apply_symbol(format_price($row['_renewal'], false, $atts["decimals"]), $symbol_type, $currency);
            $trow .= '<td data-content="Renew" class="whmp_price whmp_renew_price" ' . $data_price_renew . '><span class="whmp_show_price">' . $row['promo_renew_off'] . '</span><span class="whmp_actual_price">' . $tmp . '</span></td>';

            if ($atts["show_restore"] == "yes") {
                $trow .= '<td data-content="Restore" class="whmp_price whmp_restore_price"><span class="whmp_actual_price">' . $row['restore_price'] . '</span></td>';
            }

            $trow .= '</tr>';
            $trows .= $trow;
        }

        $tail = '</tbody></table></div>';

        $table = $head . $trows . $tail;


    }
    elseif
    ($atts["style1"] == "Muliti_year_register" || $atts["style1"] == "Muliti_year_transfer" || $atts["style1"] == "Muliti_year_renew")
    {
        $head = '<div class="whmpress whmpress_price_matrix_domain style_1 ">';
        $head .= '<table id="' . $table_id . '">';
        $head .= '<thead>';
        $head .= '<tr>';
        $head .= '<th>' . __('Domain', 'whmpress') . '</th>';
        $head .= '<th>' . __('1 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('2 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('3 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('4 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('5 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('6 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('7 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('8 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('9 Year', 'whmpress') . '</th>';
        $head .= '<th>' . __('10 Year', 'whmpress') . '</th>';
        $head .= '</tr>';
        $head .= '</thead>';

        foreach ($tlds_data as $row) {
            $group_class = $group_span = $group_promo = $group_special = $row_specials = '';

            // build group_class & group_span if needed.
            if (!empty($row['group'])) {
                $group_class .= ' whmp_' . $row['group'];
                $group_special = '<span class="whmp_special whmp_' . $row['group'] . '">' . $row['group'] . '</span>';
                $row_specials .= $row['group'];
            }

            // Build <span> for Promo
            if ($row['promo'] == 1 && (trim($row['promo_text']) != "")) {
                $group_class .= 'whmp_promo';
                $group_promo = '<span class="whmp_promo" title="' . $row['promo_details'] . '">' . $row['promo_text'] . '</span>';
                $row_specials .= 'promo';
            }

            $addon_domains_html = "";
            if ($atts["show_addons"] == 'yes') {

                $addon_domains = [
                    'Domain Forwarding' => [
                        'icon' => '<i class="fa fa-share"></i> ',
                        'price' => $row['dnsmanagement']
                    ],
                    'Email Forwarding' => [
                        'icon' => '<i class="fa fa-check"></i> ',
                        'price' => $row['emailforwarding']
                    ],
                    'Privacy Protection' => [
                        'icon' => '<i class="fa fa-user-secret"></i> ',
                        'price' => $row['idprotection']
                    ]
                ];

                //unset elements that are -1
                foreach ($addon_domains as $addon_key => $addon_domain) {
                    if ($addon_domain['price'] == -1) {
                        //echo "unsetting";
                        unset($addon_domains[$addon_key]);
                    }
                }

                // do not output html if there is no addon to show.

                if ($row['dnsmanagement'] >= 0 || $row['emailforwarding'] >= 0 || $row['idprotection'] >= 0) {

                    $addon_domains_html .= '<div class="whmp_dropdown_outer">';
                    $addon_domains_html .= '<span class="whmp_dropdown_toggle">Add Ons</span>';
                    $addon_domains_html .= '<ul class="whmp_dropdown_inner whmp_domain_addons">';
                    foreach ($addon_domains as $addon_key => $addon_domain) {
                        $addon_domains_html .= '<li>';
                        $addon_domains_html .= $addon_domain['icon'];
                        $addon_domains_html .= '<span class="whmp_addon_label">' . $addon_key . '</span> ';
                        $addon_domains_html .= '<span class="whmp_addon_price">' . $addon_domain['price'] . '</span> ';
                        $addon_domains_html .= '</li>';
                    }
                    $addon_domains_html .= '</ul></div>';
                } // end if there is no addon set for todain
            }//if addon set to yes

            $trow = '<tr class="whmp_domain_matrix_row ' . $group_class . '" data-tld-types="' . $row['categories'] . '" data-tld-specials="' . $row_specials . '">';
            $trow .= '<td data-content="Domain" class="whmp_domain">' . $row['extension'] . $addon_domains_html . $group_promo . $group_special . '</td>';
            $tmp = "";
            for ($x = 1; $x <= 10; $x++) {
                if ($atts["style1"] == "Muliti_year_register") {
                    $tmp .= '<td data-content="Register ' . $x . ' Year" class="whmp_price whmp_register_price"><span class="whmp_actual_price">';
                    $tmp .= whmp_apply_symbol(format_price($row['registration'][$x], false, $atts["decimals"]), $symbol_type,
                        $currency);
                    $tmp .= '</span></td>';
                } elseif ($atts["style1"] == "Muliti_year_transfer") {
                    $tmp .= '<td data-content="Transfer ' . $x . ' Year" class="whmp_price whmp_transfer_price"><span class="whmp_actual_price">';
                    $tmp .= whmp_apply_symbol(format_price($row['transfer'][$x], false, $atts["decimals"]), $symbol_type,
                        $currency);
                    $tmp .= '</span></td>';
                } elseif ($atts["style1"] == "Muliti_year_renew") {
                    $tmp .= '<td data-content="Renew ' . $x . ' Year" class="whmp_price whmp_renew_price"><span class="whmp_actual_price">';
                    $tmp .= whmp_apply_symbol(format_price($row['renew'][$x], false, $atts["decimals"]), $symbol_type,
                        $currency);
                    $tmp .= '</span></td>';
                }

            }
            $trow .= $tmp;
            $trow .= '</tr>';
            $trows .= $trow;
        }


        $tail = '</tbody></table></div>';

        $table = $head . $trows . $tail;
    }
    else {

        $str .= "<table border='1'";
        $str .= " id=\"" . $table_id . "\"";
        $str .= ">\n<thead>
	    <tr>";

        $FixTitles = [
            __("Domain", "whmpress"),
            __("Price", "whmpress"),
            __("Years", "whmpress"),
            __("Renewal Price", "whmpress"),
            __("Transfer Price", "whmpress"),
        ];
        for ($c = 1; $c <= 1; $c++) {
            $titles = explode(",", $atts["titles"]);
            if (isset($titles[0]) && $titles[0] <> "") {
                $str .= "<th>" . trim($titles[0]) . "</th>";
                $domain_title = trim($titles[0]);
            } else {
                $str .= "<th>{$FixTitles[0]}</th>";
                $domain_title = $FixTitles[0];
            }

            if (isset($titles[1])) {
                $str .= "<th>" . trim($titles[1]) . "</th>";
                $register_title = trim($titles[1]);
            } else {
                $str .= "<th>{$FixTitles[1]}</th>";
                $register_title = $FixTitles[1];
            }

            if (isset($titles[2])) {
                $str .= "<th>{$titles[2]}</th>";
                $years_title = $titles[2];
            } else {
                $str .= "<th>{$FixTitles[2]}</th>";
                $years_title = $FixTitles[2];
            }

            if ($atts["show_renewel"] == "1" || strtolower($atts["show_renewel"]) == "yes" || $atts["show_renewel"] === true) {
                if (isset($titles[3])) {
                    $str .= "<th>{$titles[3]}</th>";
                    $renewal_title = $titles[3];
                } else {
                    $str .= "<th>{$FixTitles[3]}</th>";
                    $renewal_title = $FixTitles[3];
                }
            } else {
                $renewal_title = "";
            }

            if ($atts["show_transfer"] == "1" || strtolower($atts["show_transfer"]) == "yes" || $atts["show_transfer"] === true) {
                if (isset($titles[4])) {
                    $str .= "<th>{$titles[4]}</th>";
                    $transfer_title = $titles[4];
                } else {
                    $str .= "<th>{$FixTitles[4]}</th>";
                    $transfer_title = $FixTitles[4];
                }
            } else {
                $transfer_title = "";
            }
        }
        $str .= "</tr></thead>\n";
        $str .= "<tbody>
	    <tr>";

        $smarty_array = [];
        foreach ($rows as $index => $domain) {

            //$str .= 'index+1 % cols = '.(($index+1) % $cols);
            if (!isset($titles[0])) {
                $titles[0] = "";
            }
            if (!isset($FixTitles[0])) {
                $FixTitles[0] = "";
            }
            if ($titles[0] <> "") {
                $title = $titles[0];
            } else {
                $title = $FixTitles[0];
            }

            $_registration = 0;
            $_years = 0;

            if (floatval($domain['registration-1']) < 0 && floatval($domain['registration-2']) > 0) {
                $field = "qsetupfee";
                $_registration = $domain['registration-2'];
                $_transfer = $domain["transfer-2"];
                $_renewal = $domain["renewal-2"];
                $_years = 2;
            } elseif (floatval($domain['registration-1']) > 0) {

                $_years = 1;
                $field = "msetupfee";
                $_registration = $domain['registration-1'];
                $_transfer = $domain["transfer-1"];
                $_renewal = $domain["renewal-1"];
            } else {
                $field = $atts["replace_empty"];
                $_years = $atts["replace_empty"];
                $_registration = $atts["replace_empty"];
                $_transfer = $atts["replace_empty"];
                $_renewal = $atts["replace_empty"];
            }

            $data = [];

            $data['domain'] = $domain['extension'];
            $str .= "<td data-content=\"{$title}\">" . $domain['extension'] . "</td>";

            //add symbols only if there is price.

            //replace titles if needed
            if (!isset($titles[1])) {
                $titles[1] = "";
            }
            if (!isset($FixTitles[1])) {
                $FixTitles[1] = "";
            }
            if ($titles[1] <> "") {
                $title = $titles[1];
            } else {
                $title = $FixTitles[1];
            }

            $tmp = format_price($_registration, false, $atts["decimals"]);
            $v = whmp_apply_symbol($tmp, $symbol_type, $currency);

            $data['register'] = $v;
            $str .= "<td data-content=\"{$title}\">$v</td>";

            //replace titles if needed
            if (!isset($titles[2])) {
                $titles[2] = "";
            }
            if (!isset($FixTitles[2])) {
                $FixTitles[2] = "";
            }
            if ($titles[2] <> "") {
                $title = $titles[2];
            } else {
                $title = $FixTitles[2];
            }

            $data['years'] = $_years;
            $str .= "<td data-content=\"{$title}\">$_years </td>";

            //show renewals if enabled
            if ($atts["show_renewel"] == "1" || strtolower($atts["show_renewel"]) == "yes" || $atts["show_renewel"] === true) {
                //only if combine extension with same price is enabled.
                if ($combine_extension == "price" || $combine_extension == "pricecc") {
                    $v = $atts["replace_empty"];
                } else if ($field == "") {
                    $v = $atts["replace_empty"];
                } else {
                    $v = $atts["replace_empty"];
                    foreach ($rows2 as $r2) {
                        if ($r2["extension"] == $domain["extension"]) {
                            $v = $domain["transfer-" . $_years];
                        }
                    }
                    if ($v == "-1.00" || $v == -1) {
                        $v = $atts["replace_empty"];
                    }
                }

                if (!isset($titles[3])) {
                    $titles[3] = "";
                }
                if (!isset($FixTitles[3])) {
                    $FixTitles[3] = "";
                }
                if ($titles[3] <> "") {
                    $title = $titles[3];
                } else {
                    $title = $FixTitles[3];
                }

                $tmp = format_price($_renewal, false, $atts["decimals"]);
                $v = whmp_apply_symbol($tmp, $symbol_type, $currency);
                $data['renewal'] = $v;
                $str .= "<td data-content=\"{$title}\">$v</td>";
            } else {
                $data['renewal'] = "";
            }

            //show transfers if enables
            if ($atts["show_transfer"] == "1" || strtolower($atts["show_transfer"]) == "yes" || $atts["show_transfer"] === true) {
                //only if combine extension with same price is enabled.
                /*			if ( $combine_extension == "price" || $combine_extension == "pricecc" ) {
                                $v = $replace_empty;
                            }
                            else if ( $field == "" ) {
                                $v = $replace_empty;
                            }
                            else {
                                $v = $replace_empty;
                                foreach ( $rows3 as $r2 ) {
                                    if ( $r2["extension"] == $domain["extension"] ) {
                                        $v = $_transfer;
                                    }
                                }
                                $v = whmp_domain_rep_empty($v);
                            }*/

                if (!isset($titles[4])) {
                    $titles[4] = "";
                }
                if (!isset($FixTitles[4])) {
                    $FixTitles[4] = "";
                }
                if ($titles[4] <> "") {
                    $title = $titles[4];
                } else {
                    $title = $FixTitles[4];
                }

                $tmp = format_price($_transfer, false, $atts["decimals"]);
                $v = whmp_apply_symbol($tmp, $symbol_type, $currency);
                $data['transfer'] = $v;
                $str .= "<td data-content=\"{$title}\">$v</td>";
            } else {
                $data['transfer'] = "";
            }
            //if (($index+1) % $cols==0) $str .= "</tr>\n<tr>";
            $str .= "</tr>\n<tr>";
            $smarty_array[] = $data;
        }

        # Removing extra <tr> at the end of string.
        if (substr($str, -4) == "<tr>") {
            $str = substr($str, 0, -4);
        }

        $str .= "</tbody>\n</table>";
    }
    /*$time_end = microtime(true);
    $time = $time_end - $time_start;
    echo '<br>Execution time : '.$time.' seconds';*/

    $html_template = $WHMPress->check_template_file($atts["html_template"], "whmpress_price_matrix_domain");
    $html_template = "";

    if (is_file($html_template)) {
        // If template file found then ...
        $OutputString = $WHMPress->read_local_file($html_template);
        if (strtolower($atts["hide_search"]) == "yes") {
            $SearchBox = "<input type='search' placeholder='" . __($atts["search_placeholder"], "whmpress") . "' id='search_domain_text_box' >";
        } else {
            $SearchBox = "";
        }

        $vars = [
            "search_label" => $atts["search_label"],
            "search_text_box" => $SearchBox,
            "price_matrix_table" => $str,
            "domain_title" => $domain_title,
            "register_title" => $register_title,
            "years_title" => $years_title,
            "renewal_title" => $renewal_title,
            "transfer_title" => $transfer_title,
            "data" => $smarty_array,
        ];

        # Getting custom fields and adding in output
        $TemplateArray = $WHMPress->get_template_array("whmpress_price_matrix_domain");
        foreach ($TemplateArray as $custom_field) {
            $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
        }

        $OutputString = whmp_smarty_template($html_template, $vars);

        return $OutputString;
    }
    else {


        if (strtolower($atts["hide_search"]) == "yes") {
            if ($atts["data_table"] == "1" || strtolower($atts["data_table"]) == "yes") {
                // Do not include search box
                $search_text = "";
            } else {
                $search_text = "<label>" . $atts["search_label"] . "</label>
                <input type='search' placeholder='" . __($atts["search_placeholder"], "whmpress") . "' id='search_{$table_id}' style='width:50%' >";
            }
        } else {
            $search_text = "";
        }

        $html_id=$atts["html_id"];
        $html_class=$atts["html_class"];

        # Returning output string including output wrapper div.
        $ID = !empty($html_id) ? "id='$html_id'" : "";
        $CLASS = !empty($html_class) ? "class='$html_class'" : "";


        if (
            ($atts["style1"] == "style_1") ||
            ($atts["style1"] == "style_2") ||
            ($atts["style1"] == "Muliti_year_register") ||
            ($atts["style1"] == "Muliti_year_transfer") ||
            ($atts["style1"] == "Muliti_year_renew")) {
            return $table;
        } else {
            return "<div $ID $CLASS>" . $search_text . $str . $table . "</div>";
        }
    }
}
