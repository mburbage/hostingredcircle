<?php


//get table names functions
if (true)
{
    if (!function_exists("whmp_get_announcements_table_name")) {
        function whmp_get_announcements_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_announcements";
        }
    }

    if (!function_exists("whmp_get_productconfigoptions_table_name")) {
        function whmp_get_productconfigoptions_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_productconfigoptions";
        }
    }

    if (!function_exists("whmp_get_productconfiglinks_table_name")) {
        function whmp_get_productconfiglinks_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_productconfiglinks";
        }
    }

    if (!function_exists("whmp_get_productconfigoptionssub_table_name")) {
        function whmp_get_productconfigoptionssub_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_productconfigoptionssub";
        }
    }

    if (!function_exists("whmp_get_clientgroups_table_name")) {
        function whmp_get_clientgroups_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_clientgroups";
        }
    }

    if (!function_exists("whmp_is_table_exists")) {
        function whmp_is_table_exists($table_name)
        {
            global $wpdb;

            return ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") == $table_name);
        }
    }

    if (!function_exists("get_mysql_table_name")) {
        function get_mysql_table_name($table = "")
        {
            global $wpdb;
            global $Tables;

            if (isset($Tables[$table])) {
                $table_name = $Tables[$table];
            } else {
                $table_name = "";
                foreach ($Tables as $k => $v) {
                    if ($table == $v) {
                        $table_name = $v;
                        break;
                    }
                }
            }

            return $wpdb->prefix . "whmpress_" . $table_name;
        }
    }

    if (!function_exists("whmp_get_tax_table_name")) {
        function whmp_get_tax_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_tax";
        }
    }

    if (!function_exists("whmp_get_pricing_table_name")) {
        function whmp_get_pricing_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_pricing";
        }
    }

    if (!function_exists("whmp_get_domainpricing_table_name")) {
        function whmp_get_domainpricing_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_domainpricing";
        }
    }

    if (!function_exists("whmp_get_domain_pricing_table_name")) {
        function whmp_get_domain_pricing_table_name()
        {
            global $wpdb;
            return $wpdb->prefix . "whmpress_domainpricing";

        }
    }

    if (!function_exists("whmp_get_products_table_name")) {
        function whmp_get_products_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_products";
        }
    }

    if (!function_exists("whmp_get_productgroups_table_name")) {
        function whmp_get_productgroups_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_productgroups";
        }
    }

    if (!function_exists("whmp_get_product_group_table_name")) {
        function whmp_get_product_group_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_productgroups";
        }
    }

    if (!function_exists("whmp_get_countries_table_name")) {
        function whmp_get_countries_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_countries";
        }
    }

    if (!function_exists("whmp_get_currencies_table_name")) {
        function whmp_get_currencies_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_currencies";
        }
    }

    if (!function_exists("whmp_get_configuration_table_name")) {
        function whmp_get_configuration_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_configuration";
        }
    }

    if (!function_exists("whmp_get_addons_table_name")) {
        function whmp_get_addons_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_addons";
        }
    }

    if (!function_exists("whmp_get_group_table_name")) {
        function whmp_get_group_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_groups";
        }
    }

    if (!function_exists("whmp_get_group_detail_table_name")) {
        function whmp_get_group_detail_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_groups_details";
        }
    }

    if (!function_exists("whmp_get_logs_table_name")) {
        function whmp_get_logs_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_search_logs";
        }
    }

    if (!function_exists("whmp_get_tooltips_table_name")) {
        function whmp_get_tooltips_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_tooltips";
        }
    }


    if (!function_exists("whmp_get_ip2country_table_name")) {
        function whmp_get_ip2country_table_name()
        {
            global $wpdb;

            return $wpdb->prefix . "whmpress_ip2location_db1";
        }
    }

}


//Currency Functions
if (true)
{

    if (!function_exists('whmp_get_default_currency_id')) {
        function whmp_get_default_currency_id()
        {
            global $WHMPress;
            if (!$WHMPress) {
                $WHMPress = new WHMpress();
            }
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }

            $currency = get_option("whmpress_default_currency");
            if (!empty($currency) && is_numeric($currency)) {
                return $currency;
            }

            global $wpdb;
            $Q = "SELECT `id` FROM `" . whmp_get_currencies_table_name() . "` WHERE `default`='1'";

            return $wpdb->get_var($Q);
        }
    }

    if (!function_exists("whmp_get_default_currency_code")) {
        function whmp_get_default_currency_code()
        {

            $id= whmp_get_default_currency_id();

            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }

            $currency = get_option("whmpress_default_currency");

            global $wpdb;
            if (!empty($currency)) {
                $Q = "SELECT `code` FROM `" . whmp_get_currencies_table_name() . "` WHERE `id`='$currency'";
            } else {
                $Q = "SELECT `code` FROM `" . whmp_get_currencies_table_name() . "` WHERE `default`='1'";
            }

            return $wpdb->get_var($Q);
        }
    }

    if (!function_exists("whmp_get_default_currency_prefix")) {
        function whmp_get_default_currency_prefix()
        {
            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }

            $currency = get_option("whmpress_default_currency");

            global $wpdb;
            if (!empty($currency)) {
                $Q = "SELECT `prefix` FROM `" . whmp_get_currencies_table_name() . "` WHERE `id`='$currency'";
            } else {
                $Q = "SELECT `prefix` FROM `" . whmp_get_currencies_table_name() . "` WHERE `default`='1'";
            }

            return $wpdb->get_var($Q);
        }
    }

    if (!function_exists("whmp_get_default_currency_suffix")) {
        function whmp_get_default_currency_suffix()
        {
            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }

            $currency = get_option("whmpress_default_currency");

            global $wpdb;
            if (!empty($currency)) {
                $Q = "SELECT `suffix` FROM `" . whmp_get_currencies_table_name() . "` WHERE `id`='$currency'";
            } else {
                $Q = "SELECT `suffix` FROM `" . whmp_get_currencies_table_name() . "` WHERE `default`='1'";
            }

            return $wpdb->get_var($Q);
        }
    }

    if (!function_exists('whmp_get_currency')) {
        function whmp_get_currency($curency_id = "0")
        {
            $curency_id = (int)$curency_id;

            if (empty($curency_id)) {

                if (!session_id()) {
                    $cacheValue = get_option('whmpress_session_cache_limiter_value');
                    session_cache_limiter($cacheValue);
                    session_start();
                }

                if (isset($_SESSION["whcom_currency"]) && !empty($_SESSION["whcom_currency"])) {
                    return $_SESSION["whcom_currency"];
                }
                return whmp_get_default_currency_id();
            } else {
                return $curency_id;
            }
        }
    }

    if (!function_exists('whmp_get_currency_code')) {
        function whmp_get_currency_code($id = "")
        {
            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }
            if ($id == "") {
                return whmp_get_default_currency_code();
            }
            global $wpdb;
            $Q = "SELECT `code` FROM `" . whmp_get_currencies_table_name() . "` WHERE `id`='$id'";
            $currency_code = $wpdb->get_var($Q);
            if (empty($currency_code)) {
                $currency_code = whmp_get_default_currency_code();
            }
            $WHMP = new WHMPress();
            $alter = get_option("whmpress_currencies_" . trim($currency_code) . "_code_" . $WHMP->get_current_language());
            if (empty($alter)) {
                return $currency_code;
            } else {
                return $alter;
            }
        }
    }

    if (!function_exists("whmp_get_currency_prefix")) {
        function whmp_get_currency_prefix($id = "")
        {
            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }
            if ($id == "") {
                $currency_prefix = whmp_get_default_currency_prefix();
            } else {
                global $wpdb;
                $Q = "SELECT `prefix` FROM `" . whmp_get_currencies_table_name() . "` WHERE (`id`='$id' OR `code`='$id')";
                $currency_prefix = $wpdb->get_var($Q);
                if (empty($currency_prefix)) {
                    $currency_prefix = whmp_get_default_currency_prefix();
                }
            }

            $alter = get_option("whmpress_currencies_" . trim($currency_prefix) . "_prefix_" . $WHMPress->get_current_language());
            if (empty($alter)) {
                return $currency_prefix;
            } else {
                return $alter;
            }
        }
    }

    if (!function_exists("whmp_get_currency_suffix")) {
        function whmp_get_currency_suffix($id = "")
        {
            $WHMPress = new WHMpress();
            if (!$WHMPress->WHMpress_synced()) {
                return '';
            }
            if ($id == "") {
                $currency_suffix = whmp_get_default_currency_suffix();;
            } else {
                global $wpdb;
                $Q = "SELECT `suffix` FROM `" . whmp_get_currencies_table_name() . "` WHERE `id`='$id'";
                $currency_suffix = $wpdb->get_var($Q);
                if ($currency_suffix == "") {
                    $currency_suffix = whmp_get_default_currency_suffix();
                }
            }

            $alter = get_option("whmpress_currencies_" . trim($currency_suffix) . "_suffix_" . $WHMPress->get_current_language());
            if (empty($alter)) {
                return $currency_suffix;
            } else {
                return $alter;
            }
        }
    }

}



if (!function_exists("whmp_get_installation_url")) {
    function whmp_get_installation_url()
    {
        global $wpdb;
        $whmcs_url = esc_attr(get_option("whmcs_url"));
        if ($whmcs_url == "") {
            $Q = "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='SystemURL' OR `setting`='SystemSSLURL' ORDER BY `setting`";
            $urls = $wpdb->get_results($Q);
            foreach ($urls as $url) {
                if ($url->value <> "") {
                    return rtrim($url->value, "/") . "/";
                }
            }

            return "";
        } else {
            return $whmcs_url;
        }
    }
}


if (!function_exists("whmpress_draw_combo")) {
    function whmpress_draw_combo($dataArray, $selected = "", $name = "")
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return '';
        }
        $OutputString = "<select name='$name'>\n";
        if (whmpress_is_assoc_array($dataArray)) {
            foreach ($dataArray as $key => $val) {
                $S = $key == $selected ? "selected=selected" : "";
                $OutputString .= "<option $S value=\"$key\">{$val}</option>\n";
            }
        } else {
            foreach ($dataArray as $val) {
                $S = $val == $selected ? "selected=selected" : "";
                $OutputString .= "<option $S>{$val}</option>\n";
            }
        }
        $OutputString .= "</select>\n";

        return $OutputString;
    }
}

if (!function_exists("whmpress_draw_combo_multiple")) {
    function whmpress_draw_combo_multiple($dataArray, $selected = [], $name)
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return '';
        }
        $OutputString = "<select name='{$name}[]' multiple='multiple'>\n";
        if (!is_array($selected)) {
            $selected = explode(",", $selected);
        }
        $selected = array_map('trim', $selected);
        if (whmpress_is_assoc_array($dataArray)) {
            foreach ($dataArray as $key => $val) {
                $S = in_array($key, $selected) ? "selected=selected" : "";
                $OutputString .= "<option $S value=\"$key\">{$val}</option>\n";
            }
        } else {
            foreach ($dataArray as $val) {
                $S = in_array($key, $selected) ? "selected=selected" : "";
                $OutputString .= "<option $S>{$val}</option>\n";
            }
        }
        $OutputString .= "</select>\n";

        return $OutputString;
    }

}

if (!function_exists("whmpress_is_assoc_array")) {
    function whmpress_is_assoc_array($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}

if (!function_exists("whmpress_get_option")) {
    function whmpress_get_option($key_name, $default = "")
    {
        $DefaultValues = [
            "whmp_custom_css" => "default.css",
            "decimals" => "0",
            "billingcycle" => "annually",
            "hide_decimal" => "No",
            "decimals_tag" => "",
            "prefix" => "",
            "suffix" => "",
            "show_duration" => "Yes",
            "show_duration_as" => "",
            "duration_type" => "long",
            "combo_billingcycles" => "",
            "combo_decimals" => "0",
            "combo_show_button" => "Yes",
            "round_price" => "0",
            //"combo_rows" => "1",
            "combo_button_text" => "Order Now",
            "combo_show_discount" => "Yes",
            "combo_discount_type" => "yearly",
            "combo_prefix" => "Yes",
            "combo_suffix" => "No",
            "default_currency_symbol" => "prefix",

            "domain_available_message" => "Domain is available",
            "domain_not_available_message" => "Domain is not available",
            "domain_recommended_list" => "Recommended domains list",
            "ongoing_domain_available_message" => "[domain-name] is available",
            "ongoing_domain_not_available_message" => "[domain-name] is not available",
            "register_domain_button_text" => "Select",
            "load_more_button_text" => "Load more",

            "curl_timeout_whmp" => "20",
            "cache_enabled_whmp" => "0",
            "configureable_options" => "0",
            "price_tax" => "",
            "price_currency" => "0",
            "price_type" => "price",
            "convert_monthly" => "no",
            "config_option_string" => "Starting from",

            "jquery_source" => "wordpres",

            # Domain Price
            "dp_type" => "domainregister",
            "dp_years" => "1",
            "dp_decimals" => "1",
            "dp_hide_decimal" => "no",
            "dp_decimals_tag" => "",
            "dp_prefix" => "Yes",
            "dp_suffix" => "No",
            "dp_show_duration" => "Yes",
            "dp_price_tax" => "",

            # Price Matrix
            "pm_decimals" => "0",
            "pm_show_hidden" => "No",
            "pm_replace_zero" => "x",
            "pm_replace_empty" => "-",
            //"pm_type" => "product",
            "pm_hide_search" => "No",
            "pm_search_label" => esc_html__("Search:", "whmpress"),
            "pm_search_placeholder" => esc_html__("Search", "whmpress"),

            # Price Matrix Domain
            "pmd_decimals" => "0",
            "pmd_show_renewel" => "Yes",
            "pmd_show_transfer" => "Yes",
            "pmd_hide_search" => "No",
            "pmd_search_label" => esc_html__("Search", "whmpress"),
            "pmd_search_placeholder" => esc_html__("Type Extension to search a domain", "whmpress"),
            "pmd_show_disabled" => "No",
            "pmd_num_of_rows" => "10",

            # Order Button
            "ob_button_text" => esc_html__("Order", "whmpress"),
            "ob_billingcycle" => "annually",

            # Pricing Table
            "pt_billingcycle" => "annually",
            "pt_show_price" => "Yes",
            "pt_process_description" => "Yes",
            "pt_show_description_icon" => "Yes",
            "pt_show_description_tooltip" => "Yes",
            "pt_show_combo" => "No",
            "pt_show_button" => "Yes",
            "pt_button_text" => esc_html__("Order", "whmpress"),

            # Domain Search
            "ds_show_combo" => "No",
            "ds_show_country_combo" => "No",
            "ds_placeholder" => esc_html__("Search", "whmpress"),
            "ds_button_text" => esc_html__("Search", "whmpress"),

            # Domain Search Ajax
            "dsa_placeholder" => esc_html__("Search", "whmpress"),
            "dsa_button_text" => esc_html__("Search", "whmpress"),
            "dsa_whois_link" => "Yes",
            "dsa_www_link" => "Yes",
            "dsa_transfer_link" => "Yes",
            "dsa_disable_domain_spinning" => "0",
            "dsa_order_landing_page" => "0",
            "dsa_order_link_new_tab" => "0",
            "dsa_show_price" => "1",
            "dsa_show_years" => "1",
            "dsa_search_extensions" => "1",

            # Domain Search Ajaz Result
            "dsar_whois_link" => "Yes",
            "dsar_www_link" => "Yes",
            "dsar_show_price" => "1",
            "dsar_show_years" => "1",

            # Domain Search Bulk
            "dsb_placeholder" => "",
            "dsb_button_text" => esc_html__("Search", "whmpress"),

            # Domain WhoIS
            "dw_placeholder" => "",
            "dw_button_text" => esc_html__("Get WhoIs", "whmpress"),

            # Order Link
            "ol_link_text" => esc_html__("Link Text", "whmpress"),

            # Description
            "dsc_description" => "ul",

            "whmp_follow_lang" => "yes",
        ];

        if ($default == "") {
            if (isset($DefaultValues[$key_name])) {
                $default = $DefaultValues[$key_name];
            }
        }

        $old_key_name = $key_name;
        $key_name = whmpress_process_key_name($key_name);

        $value = get_option($key_name, __($default, "whmpress"));
        if ($value == "") {
            if (isset($DefaultValues[$old_key_name])) {
                $value = $DefaultValues[$old_key_name];
            }
        }

        if ($key_name == "whois_db" && trim($value) == "") {
            $value = whmp_read_local_file(WHMP_PLUGIN_DIR . "/includes/whoisdb");
        }

        if (is_array($value)) {
            return array_map('trim', $value);
        } else {
            return trim($value);
        }
    }
}

if (!function_exists("whmpress_process_key_name")) {
    function whmpress_process_key_name($key_name)
    {
        global $WHMP_Settings;
        $WHMP = new WHMPress();
        $lang = $WHMP->get_current_language();
        $extend = empty($lang) ? "" : "_" . $lang;

        if (in_array($key_name, $WHMP_Settings)) {
            $key_name .= $extend;
        }

        return $key_name;
    }
}

/**
 * @param array $data
 * @param bool $show_full_result
 *
 * @return string
 *
 * Sync data from WHMCS into WHMPress
 */

if (!function_exists("whmp_fetch_data")) {
    function whmp_fetch_data($data = [], $show_full_result = true)
    {
        // Connecting to WHMCS db    for fetching data.
        if (!isset($data["db_server"])) {
            $data["db_server"] = get_option("db_server");
        }
        if (!isset($data["db_user"])) {
            $data["db_user"] = get_option("db_user");
        }
        if (!isset($data["db_pass"])) {
            $data["db_pass"] = get_option("db_pass");
        }
        if (!isset($data["db_name"])) {
            $data["db_name"] = get_option("db_name");
        }

        $str=explode(":",$data["db_server"]);
        //ppa($str);
        $server=$str[0];
        if (isset($str[1])){
            $port=$str[1];
        }else
        {$port="3306";}



        if (get_option("whmp_save_pwd") <> "1") {
            update_option("db_pass", "");
        }

        if (!function_exists('mysqli_connect')) {
            return "<div class='error'><p style='color:#ff0000;font-weight:bold'>MySQLi not installed on your server, WHMpress required MySQLi</p></div>";
        }

        $conn = mysqli_init();
        if (!$conn) {
            die('mysqli_init failed');
        }

        if (!$conn->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
            die('Setting MYSQLI_INIT_COMMAND failed');
        }

        if (!$conn->options(MYSQLI_OPT_CONNECT_TIMEOUT, 10)) {
            die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
        }

        if (!$conn->real_connect($server, $data["db_user"], $data["db_pass"], $data["db_name"],$port)) {

            $error_string1 = '<div class="error"><p><strong>Connect Error (' . mysqli_connect_errno() . ')</strong><br>';
            $error_string1 .= mysqli_connect_error() . '</p></div>';
            $error_string2 = '<div class="error">';
            $error_string2 .= '<p><strong>Message:</strong><br>';
            $error_string2 .= 'It seems WHMpress is not able to connect with WHMCS, Here are the things you can do.</p>';
            $error_string2 .= '<ol>';
            $error_string2 .= '<li>if WP and WHMCS are on different servers, check if mysql is allowing remote connections from WHMCS server.</li>';
            $error_string2 .= '<li>Check if database info is correct.</li>';
            $error_string2 .= '</ol>';
            $error_string2 .= '</div>';

            die($error_string2 . $error_string1);
        }

        if ($conn->connect_error) {
            if ($show_full_result) {
                return "<h1>Unable to connect with WHMCS server: " . $conn->connect_error . "</h1>";
            } else {
                return "Unable to connect with WHMCS server: \n" . $conn->connect_error;
            }
        }

        if (!$conn->set_charset("utf8")) {
            return "<div class='error'><p style='color:#ff0000;font-weight:bold'>Error loading character set utf8: " . $conn->error . "</p></div>";
        }

        // Getting list of WHMPress decided tables
        global $Tables;

        global $wpdb;
        $Out = "";
        $charset_collate = $wpdb->get_charset_collate();
        foreach ($Tables as $table => $newTable) {
            /**
             * Check if MySQL table exists
             * Added in 2.4.2
             */
            $Q = "SELECT * FROM information_schema.tables WHERE table_schema = '{$data["db_name"]}' AND table_name = '{$table}' LIMIT 1;";
            $is_table = $conn->query($Q);
            if ($is_table->num_rows == "0") {
                $Out .= "<span style='color:#CC0000;'>Table <b>$table</b> doesn't exists in database <b>{$data["db_name"]}</b>. Please ask your administrator.</span><br />";
            } else {
                $newTableName = $wpdb->prefix . "whmpress_" . $newTable;

                $Q = "SHOW CREATE TABLE `" . $table . "`";
                $result = $conn->query($Q);
                if (!$result) {
                    if ($show_full_result) {
                        return "<h1>Can't get data from table " . $table . "</h1>";
                    } else {
                        return "Can't get data from table " . $table;
                    }
                }

                $row = $result->fetch_assoc();
                $newTableQ = $row["Create Table"];
                $newTableQ = substr($newTableQ, 0, strrpos($newTableQ, ")") + 2);
                $newTableQ .= $charset_collate;

                $result = $conn->query("SELECT * FROM `$table`");

                $newTableQ = str_replace("`$table`", "`" . $newTableName . "`", $newTableQ);

                $Q = "DROP TABLE IF EXISTS `$newTableName`";
                $r = $wpdb->query($Q);
                $wpdb->query($newTableQ);
                $wpdb->query("TRUNCATE `$newTableName`");
                $s = 0;
                $f = 0;
                while ($row = $result->fetch_assoc()) {
                    $response = $wpdb->insert($newTableName, $row);
                    if ($response === false) {
                        $f++;
                    } else {
                        $s++;
                    }
                }
                if ($f == 0) {
                    $Out .= "<p style='color: green;'><b>Caching $newTable:</b> <i>Successfully cached:</i> $s </p>";
                } else {
                    $Out .= "<b>Caching $newTable:</b> <i>Successfully cached:</i> $s, <i>Failed:</i> $f<br />";
                }
            }
        }
        update_option('sync_time', date("F, d Y - H:i"));
        if ($show_full_result) {
            return $Out;
        } else {
            update_option('sync_time', date("F, d Y - H:i"));
            //todo: cross check
            update_option('sync_run', '1');
            return "OK";
        }


        $mysqli->close();
    }
}

/**
 * Check whether file editing is allowed for the .htaccess and robots.txt files
 *
 * @internal current_user_can() checks internally whether a user is on wp-ms and adjusts accordingly.
 *
 * @return bool
 */

if (!function_exists("whmp_allow_system_file_edit")) {
    function whmp_allow_system_file_edit()
    {
        $allowed = true;

        if (current_user_can('edit_files') === false) {
            $allowed = false;
        }

        /**
         * Filter: 'whmp_allow_system_file_edit' - Allow developers to change whether the editing of
         * .htaccess and robots.txt is allowed
         *
         * @api bool $allowed Whether file editing is allowed
         */

        return apply_filters('whmp_allow_system_file_edit', $allowed);
    }
}
/**
 * Check if string is a valid utf8 or not
 *
 */
if (!function_exists('is_utf8')) {
    function is_utf8($string)
    {
        return (mb_detect_encoding($string, 'UTF-8', true) == 'UTF-8');
    }
}

if (!function_exists("whmp_get_service_types")) {
    function whmp_get_service_types()
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return [];
        }
        global $wpdb;
        $Q = "SELECT DISTINCT `type` FROM `" . whmp_get_products_table_name() . "` WHERE `type`<>''";
        $rows = $wpdb->get_results($Q, ARRAY_A);
        $realNames = [
            "hostingaccount",
            "reselleraccount",
            "server",
            "other",
        ];
        $changedNames = [
            "Hosting Plans",
            "Reseller Plans",
            "VPS/Servers",
            "Other",
        ];
        $Out = [];
        foreach ($rows as $row) {
            $Out[$row["type"]] = str_replace($realNames, $changedNames, $row["type"]);
        }

        return $Out;
    }
}

if (!function_exists("whmp_get_type_groups")) {
    function whmp_get_type_groups($type)
    {
        $Q = "SELECT DISTINCT grps.`id`,grps.`name`,grps.`hidden` FROM `" . whmp_get_product_group_table_name() . "` grps, `" . whmp_get_products_table_name() . "` prds WHERE 
    prds.type='$type' AND prds.gid=grps.id ORDER BY grps.`order`";
        global $wpdb;

        return $wpdb->get_results($Q, ARRAY_A);
    }
}

if (!function_exists("whmp_get_products_by_group")) {
    function whmp_get_products_by_group($group)
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return [];
        }
        $Q = "SELECT * FROM `" . whmp_get_products_table_name() . "` WHERE 1";
        if (is_numeric($group)) {
            $group = (int)$group;
            $Q .= " AND `gid`='$group'";
        } else {
            $Q .= " AND `gid` IN (SELECT `id` gid FROM `" . whmp_get_product_group_table_name() . "` WHERE `name`='$group')";
        }
        global $wpdb;

        return $wpdb->get_results($Q, ARRAY_A);
    }
}

if (!function_exists("whmp_get_domain_extension_price")) {
    function whmp_get_domain_extension_price($ext, $currency = "")
    {
        global $wpdb;
        $ext = "." . ltrim($ext, ".");
        if ($currency == "") {
            $currency = whmp_get_currency_code();
        }
        $Q = "SELECT d.id, d.extension 'tld', t.type, c.code, c.suffix, c.prefix, t.msetupfee, t.qsetupfee
    FROM `" . whmp_get_domain_pricing_table_name() . "` AS d
    INNER JOIN `" . whmp_get_pricing_table_name() . "` AS t ON t.relid = d.id
    INNER JOIN `" . whmp_get_currencies_table_name() . "` AS c ON c.id = t.currency
    WHERE t.type
    IN (
    'domainregister'
    ) AND d.extension IN ('{$ext}')
    AND c.code='$currency' 
    ORDER BY d.id ASC 
    LIMIT 0 , 30";

        return $wpdb->get_row($Q, ARRAY_A);
    }
}

if (!function_exists("whmp_get_products")) {
    function whmp_get_products($add = false)
    {
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return [];
        }
        global $wpdb;
        #$Q = "SELECT `id`, `name`, `type` FROM `".whmp_get_products_table_name()."` WHERE `type`<>'' ORDER BY `type`";
        #$rows = $wpdb->get_results($Q,ARRAY_A);

        $services = whmp_get_service_types();
        $groups = $wpdb->get_results("SELECT `id`,`name`,`hidden` FROM `" . whmp_get_product_group_table_name() . "` ORDER BY `order`", ARRAY_A);
        $Out = [];
        foreach ($services as $key => $service) {
            foreach ($groups as $group) {
                $rows = $wpdb->get_results("SELECT `id`, `name`,`description`,`hidden` FROM `" . whmp_get_products_table_name() . "` WHERE `gid`='{$group["id"]}' AND `type`='{$key}' ORDER BY `name`");
                foreach ($rows as $row) {
                    $Out[$key . " >> " . whmpress_encoding($row->name) . " (" . $row->id . ")"] = $row->id;
                }
            }
        }

        return $Out;
    }
}

if (!function_exists("whmp_get_slabs")) {
    function whmp_get_slabs($add = false)
    {
        $Out = ["Default" => "0"];
        $WHMPress = new WHMpress();
        if (!$WHMPress->WHMpress_synced()) {
            return $Out;
        }
        if (!whmp_is_table_exists(whmp_get_clientgroups_table_name())) {
            return $Out;
        }
        global $wpdb;
        $Q = "SELECT `id`, `groupname` FROM `" . whmp_get_clientgroups_table_name() . "` ORDER BY `groupname`";
        $rows = $wpdb->get_results($Q);

        foreach ($rows as $row) {
            $Out[$row->groupname] = $row->id;
        }

        return $Out;
    }
}

if (!function_exists("whmp_smarty_template")) {
    function whmp_smarty_template($filename, $vars)
    {
        if (!class_exists('Smarty')) {
            require_once WHMP_PLUGIN_PATH . "/includes/smarty/libs/Smarty.class.php";
        }
        $smarty = new Smarty();
        $smarty->setTemplateDir(dirname($filename));
        $smarty->setCompileDir(WHMP_PLUGIN_PATH . '/includes/smarty/data/templates_c/');
        $smarty->setCacheDir(WHMP_PLUGIN_PATH . '/includes/smarty/data/cache/');
        $smarty->setConfigDir(WHMP_PLUGIN_PATH . '/includes/smarty/data/configs/');;

        #$smarty->left_delimiter = "{{";
        #$smarty->right_delimiter = "}}";

        foreach ($vars as $key => $val) {
            if (substr($key, -6) == "_image" && is_numeric($val)) {
                $img = wp_get_attachment_image_src($val);
                $val = $img[0];

            }
            $smarty->assign($key, $val);
        }

        #$smarty->debugging = true;
        return $smarty->fetch(basename($filename));
    }
}

if (!function_exists("process_price")) {
    function process_price($price, $decimal_sperator = "na")
    {
        global $WHMPress;
        if (isset($_SESSION["whcom_currency"])) {
            $currency = $_SESSION["whcom_currency"];
        } else {
            $currency = whmp_get_default_currency_id();
        }

        if ($decimal_sperator == "na") {
            // get default decimal separator
            $decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);
        }
        if ($decimal_sperator == "") {
            $decimal_sperator = ".";
        }
        $price = strip_tags($price);
        $totay = explode($decimal_sperator, $price);
        $out["amount"] = $totay[0];
        $out["fraction"] = isset($totay[1]) ? $totay[1] : "";

        return $out;
    }
}

//formats a given price according to format, and adds currency symbol
if (!function_exists("format_price")) {
    function format_price($price, $show_currency = TRUE, $decimals = "na")
    {
        global $WHMPress;

        if ($decimals == "na") {
            $decimals = get_option("decimals");
            if ($decimals == "") {
                $decimals = 2;
            }
        }

        if (isset($_SESSION["whcom_currency"])) {
            $currency = $_SESSION["whcom_currency"];
        } else {
            $currency = whmp_get_default_currency_id();
        }
        $decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);
        $thousand_sperator = $WHMPress->get_currency_thousand_separator($currency);

        $currency_sybmol = "";
        if ($show_currency == true) {
            $currency_sybmol = whmp_get_currency_prefix($currency);
        }

        $price = strip_tags($price);
        if (get_option("show_trailing_zeros") == "yes") {

            $sprice = $price;
            if (is_numeric($price)) {
                $decimals = (int)$decimals;
                $price = number_format($price, $decimals, strval($decimal_sperator), strval($thousand_sperator));
            }

        } else {
            //echo "trailing no".$price;
            $decimals = (int)$decimals;
            $sprice = $price;
            $price = round($price, $decimals);
            $price = number_format($price, $decimals, strval($decimal_sperator), strval($thousand_sperator));

            if (whmp_is_trailing_zeros($sprice, $decimals)) {
                if ($decimals > 0) {
                    $num = -1 * ($decimals + 1);
                    $price = substr($price, 0, $num);         //remove trailing zeros
                }
            }
        }

        $formated_price = $currency_sybmol . $price;
        return $formated_price;
    }
}

if (!function_exists("whmp_read_local_file")) {
    function whmp_read_local_file($filepath)
    {
        if (!is_file($filepath)) {
            return false;
        }
        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
        }

        $content = $wp_filesystem->get_contents($filepath);
        if (empty($content)) {
            $content = file_get_contents($filepath);
        }

        return $content;
    }
}

if (!function_exists("whmpress_calculate_tax")) {
    function whmpress_calculate_tax($price)
    {
        global $wpdb;
        $tax_amount = $base_price = 0;
        $TaxType = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxType'");
        $TaxL2Compound = $wpdb->get_var("SELECT `value` FROM " . whmp_get_configuration_table_name() . " WHERE `setting`='TaxL2Compound'");

        $level1_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='1' AND `country`='' ORDER BY `id`");
        $level2_rate = $wpdb->get_var("SELECT `taxrate` FROM `" . whmp_get_tax_table_name() . "` WHERE `level`='2' AND `country`='' ORDER BY `id`");

        if ($TaxType == "Exclusive") {
            $tax_amount = $price * ($level1_rate / 100);
            $base_price = $price;
        } elseif ($TaxType == "Inclusive") {
            $tax_amount = ($price / (100 + $level1_rate)) * $level1_rate;
            $base_price = $price - $tax_amount;
        }
        if (!empty($level2_rate)) {
            if (strtolower($TaxL2Compound) == "on") {
                $price2 = $tax_amount + $base_price;
            } else {
                $price2 = $base_price;
            }

            $tax2_amount = 0;
            if ($TaxType == "Exclusive") {
                $tax2_amount = $price2 * ($level2_rate / 100);
            } elseif ($TaxType == "Inclusive") {
                $tax2_amount = ($price2 / (100 + $level2_rate)) * $level2_rate;
            }
            $tax_amount += $tax2_amount;
        }
        if ($TaxType == "Inclusive") {
            $base_price = $price - $tax_amount;
        }

        return ["original_price" => $price, "tax_amount" => $tax_amount, "base_price" => $base_price];
    }
}

if (!function_exists("whmpress_encoding")) {
    function whmpress_encoding($string)
    {
        if (whmpress_get_option('whmpress_utf_encode_decode') == "utf_encode") {
            if (is_array($string)) {
                return whmp_utf8_array_encode($string);
            }
            return utf8_encode($string);

        } elseif (whmpress_get_option('whmpress_utf_encode_decode') == "utf_decode") {
            if (is_array($string)) {
                return whmp_utf8_array_encode($string);
            }
            return utf8_decode($string);
        } else {
            return $string;
        }

        /*if (preg_match('!!u', $string)) {
            return utf8_decode($string);
        } else {
            return $string;
        }*/

        /*if (!function_exists("mb_check_encoding")) return $string;

        if (mb_check_encoding($string, mb_internal_encoding())) return utf8_decode($string);
        return $string;*/
    }
}

if (!function_exists("whmp_utf8_array_encode")) {
    function whmp_utf8_array_encode(&$array)
    {
        $funct = function (&$key, &$value) {
            if (is_string($value)) {
                $value = utf8_encode($value);
            }
            if (is_string($key)) {
                $value = utf8_encode($key);
            }
            if (is_array($value)) {
                utf8_array_encode($value);
            }
        };

        array_walk($array, $funct);
        return $array;
    }
}

if (!function_exists("whmp_utf8_array_decode")) {
    function whmp_utf8_array_decode(&$array)
    {
        $funct = function (&$key, &$value) {
            if (is_string($value)) {
                $value = utf8_decode($value);
            }
            if (is_string($key)) {
                $value = utf8_decode($key);
            }
            if (is_array($value)) {
                utf8_array_decode($value);
            }
        };

        array_walk($array, $funct);
        return $array;
    }
}

if (!function_exists("whmpress_json_encode")) {
    function whmpress_json_encode($arr)
    {
        //convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
        array_walk_recursive($arr, function (&$item, $key) {
            if (is_string($item)) {
                //$item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
                $item = utf8_encode($item);
            }
        });

        //return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode($arr, JSON_PRETTY_PRINT);
        } else {
            return json_encode($arr);
        }
    }
}


if (!function_exists('count_folders')) {
    function count_folders($path)
    {
        $path = rtrim($path, "/");

        return count(glob("$path/*", GLOB_ONLYDIR));
    }
}

if (!function_exists('show_array')) {
    function show_array($ar)
    {
        if (is_array($ar) || is_object($ar)) {
            echo "<pre>";
            print_r($ar);
            echo "</pre>";
        } elseif (is_bool($ar)) {
            if ($ar) {
                return "TRUE";
            } else {
                return "FALSE";
            }
        } else {
            print_r($ar);
        }
    }
}

if (!function_exists('whmp_is_trailing_zeros')) {
    function whmp_is_trailing_zeros($price, $decimals)
    {
        $fprice = (float)$price;
        $iprice = (int)$price;

        if ($iprice == $fprice) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists("get_min_years")) {
    function get_min_years($tld)
    {
        $year = $_y = "";
        global $wpdb;
        ### Getting price
        $Q = "SELECT d.id, d.extension 'tld', t.type, c.code, c.suffix, c.prefix, t.msetupfee, t.qsetupfee
	            FROM `" . whmp_get_domain_pricing_table_name() . "` AS d
	            INNER JOIN `" . whmp_get_pricing_table_name() . "` AS t ON t.relid = d.id
	            INNER JOIN `" . whmp_get_currencies_table_name() . "` AS c ON c.id = t.currency
	            WHERE t.type
	            IN (
	            'domainregister'
	            ) AND d.extension IN ('.{$tld}')
	            AND c.code='" . whmp_get_currency_code(whmp_get_currency()) . "' 
	            ORDER BY d.id ASC 
	            LIMIT 0 , 30";

        $price = $wpdb->get_row($Q, ARRAY_A);
        if (isset($price['code'])) {
            if (isset($price['prefix'])) {
                $price['prefix'] = whmp_get_currency_prefix($price['code']);
            }
            if (isset($price['suffix'])) {
                $price['suffix'] = whmp_get_currency_suffix($price['code']);
            }
        }

        if (isset($price["msetupfee"])) {
            # if tld found in DB then calculate price.
            if ($price["msetupfee"] > 0) {
                $year = "1 " . __("Year", "whmpress");
                $_y = "1";
            } else if ($price["qsetupfee"] > 0) {
                $year = "2 " . __("Years", "whmpress");
                $_y = "2";
            } else {
                $year = "";
                $_y = "";
            }
        }

        $durations = array();
        $durations["years"] = $year;
        $durations["y"] = $_y;
        $durations["tld"] = $tld;

        return $durations;

    }
}

if (!function_exists("get_domain_link")) {
    function get_domain_link($domain, $extension, $type)
    {

        global $WHMPress;

        // Code for our plugins
        if (is_active_cap() || is_active_cop()) {
            $_url = $WHMPress->get_whmcs_url("domainchecker") . "&a=add&domain={$type}&sld={$domain}&tld=.{$extension}";
        }


        // WHMCS URL
        if (!(is_active_cap()) && !(is_active_cop())) {
            $_url = $WHMPress->get_whmcs_url("domainchecker") . "&a=add&domain={$type}&sld={$domain}&tld=.{$extension}";
        }

        return $_url;


    }
}

if (!function_exists("whmp_get_domain_clean")) {
    function whmp_get_domain_clean($domain)
    {
        $domain = ltrim($domain, '//');

        if (substr(strtolower($domain), 0, 7) == "http://") {
            $domain = substr($domain, 7);
        }
        if (substr(strtolower($domain), 0, 8) == "https://") {
            $domain = substr($domain, 8);
        }
        $domain = "http://" . $domain;
        $domain = parse_url($domain);
        if (strtolower(substr($domain["host"], 0, 4)) == "www.") {
            $domain["host"] = substr($domain["host"], 4);
        }
        if (strtolower(substr($domain["host"], 0, 3)) == "ww.") {
            $domain["host"] = substr($domain["host"], 3);
        }

        if (strtolower(substr($domain["host"], 0, 2)) == "w.") {
            $domain["host"] = substr($domain["host"], 2);
        }

        if (strtolower(substr($domain["host"], 0, 1)) == ".") {
            $domain["host"] = substr($domain["host"], 1);
        }

        $domain["full"] = $domain["host"];
        $tmp = explode(".", $domain["host"]);
        $domain["short"] = $tmp[0];
        $domain["ext"] = $tmp[1];
        if(isset($tmp[2])){
            $domain["ext"] = $tmp[1] . "." . $tmp[2];

        }

        return $domain;
    }
}

if (!function_exists("whmp_get_domain_order_urls")) {
    function whmp_get_domain_order_urls($domain_info)
    {

        $defaults = array(
            "order_landing_page" => 0,
            "order_link_new_tab" => 0,
        );

        $domain_info = wp_parse_args($domain_info, $defaults);
        extract($domain_info);

        $orders = array();

        if ($type == "register") {
            $_url = get_domain_link($domain_short, $extension, $type);
            $_url = $_url . $append_url;
            $domain_form_name = str_replace(".", "_", $extension);

            // go direct to domain settings
            if ($order_landing_page == "1") {
                $hidden_form = "<form name='whmpress_domain_form_{$domain_form_name}' style='display:none' method='post' action='{$_url}'>
            <input type='submit' id='whmpress_domain_form_{$domain_form_name}'>
            <input type='hidden' name='domainsregperiod[{$domain_full}]' value='1'>
            <input type='hidden' name='domains[]' value='{$domain_full}'>
            </form>\n";


                $button_action = "onclick=\"jQuery('#whmpress_domain_form_{$domain_form_name}').click();\"";
                $href = "javascript:;";
                $orders["order_url"] = $href;
                $orders["button_action"] = $button_action;
                $orders["hidden_form1"] = $orders["hidden_form"] = $hidden_form;

            } else {
                $button_action = "";
                $href = $_url;
                $orders["order_url"] = $_url;
                $orders["button_action"] = "";
                $orders["hidden_form1"] = $orders["hidden_form"] = "";
            }
        }

        if ($type == "transfer") {

            $_url = get_domain_link($domain_short, $extension, $type);


            $order_landing_page = isset($_REQUEST["order_landing_page"]) ? $_REQUEST["order_landing_page"] : "";
            $order_link_new_tab = isset($_REQUEST["order_link_new_tab"]) ? $_REQUEST["order_link_new_tab"] : "";

            $domain_form_name = str_replace(".", "_", $extension);
            if ($order_landing_page == "1") {

                $hidden_form = "<form name='whmpress_domain_form_{$domain_form_name}' style='display:none' method='post' action='$_url'>
                    <input type='submit' id='whmpress_domain_form_{$domain_form_name}'>
                    <input type='hidden' name='domainsregperiod[{$domain_full}' value='1'>
                    <input type='hidden' name='domains[]' value='{$domain_full}'>
                    </form>\n";
                //todo: why value is not saving in $hidden_from;
                $button_action = "onclick=\"jQuery('#whmpress_domain_form_{$domain_form_name}').click();\"";
                $href = "javascript:;";
                $orders["order_url"] = $href;
                $orders["button_action"] = $button_action;
                $orders["hidden_form1"] = $orders["hidden_form"] = $hidden_form;
            } else {
                $button_action = "";
                $href = $_url;
                $orders["order_url"] = $_url;
                $orders["button_action"] = "";
                $orders["hidden_form1"] = $orders["hidden_form"] = "";
            }
        }

        return $orders;

    }
}
// $price, $show_currency = TRUE,$decimals="na"
// this function is same as format_price except it works with array rather than arguments

if (!function_exists("whmp_format_price")) {
    function whmp_format_price($price_array)
    {
        global $WHMPress;
        $defalts = array(
            'decimals' => whmpress_get_option("decimals"),
            'prefix' => whmpress_get_option("dp_prefix"),
            'suffix' => whmpress_get_option("dp_suffix"),
            'currency' => whmpress_get_option("price_currency"),
        );
        $price_array = wp_parse_args($price_array, $defalts);
        extract($price_array);

        # This value was coming from currency settings but it will delete.
        $decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);
        $thousand_sperator = $WHMPress->get_currency_thousand_separator($currency);

        # Setting decimals for price
        if (get_option("show_trailing_zeros") == "yes") {
            $sprice = $price;
            if (is_numeric($price)) {
                $decimals = (int)$decimals;
                $price = number_format($price, $decimals, $decimal_sperator, $thousand_sperator);
            }

        } else {
            //echo "trailing no".$price;
            $sprice = $price;

            $price = round($price, $decimals);

            $price = number_format($price, $decimals, $decimal_sperator, $thousand_sperator);

            if (whmp_is_trailing_zeros($sprice, $decimals)) {
                if ($decimals > 0) {
                    $num = -1 * ($decimals + 1);
                    $price = substr($price, 0, $num);         //remove trailing zeros
                }
            }
            //		echo "clean price:".$cprice;
        }

        if ((get_option('default_currency_symbol', "prefix") == "code" ||
                get_option('default_currency_symbol', "prefix") == "prefix")
            && isset($price[get_option('default_currency_symbol', "prefix")])
        ) {
            $pricef = $price[get_option('default_currency_symbol', "prefix")] . $pricef;
        } else if (get_option('default_currency_symbol') == "suffix" && isset($price[get_option('default_currency_symbol')])) {
            $pricef = $pricef . $price[get_option('default_currency_symbol')];
        }


    }
}


if (!function_exists("whmp_get_domain_extension")) {
    function whmp_get_domain_extension($domain)
    {
        $domain = str_replace("\n", "", $domain);
        $domain = str_replace(chr(10), "", $domain);
        $tmp = strstr($domain, '.');
        $ext = trim(ltrim($tmp, "."));
        return $ext;
    }
}


if (!function_exists("whmp_get_domain_extension_db")) {
    function whmp_get_domain_extension_db()
    {
        $domain = [];
        $extensions = whmpress_get_option('whois_db');
        $ext = explode("|", $extensions);
        $ext = $ext[0];                          //get first extension
        $domain["host"] = $ext;
        $domain["extension"] = ltrim($ext, ".");
        return $domain["extension"];
    }
}


if (!function_exists("whmp_get_domains_searchable")) {
    function whmp_get_domains_searchable($sort_domains)
    {
        global $wpdb;

        if ($sort_domains == "whmcs") {
            $extensions = whmpress_get_option('whois_db');
            $extensions = explode("\n", $extensions);
            foreach ($extensions as $k => $ext) {
                if (trim($ext) == "") {
                    unset($extensions[$k]);
                }
            }

            foreach ($extensions as $y => &$ext) {
                if (trim($ext <> "")) {
                    $E = explode("|", $ext);
                    if (!isset($E[0])) {
                        $E[0] = "";
                    }
                    $ext = $E[0];
                    if ($wpdb->get_var("SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "` WHERE `extension`='$ext'") == 0) {
                        unset($extensions[$y]);
                    }
                }
            }
            $PageSize = get_option('no_of_domains_to_show', '2');
            $extensions = array_slice($extensions, 0, $PageSize);
            $extensions = array_values($extensions);

        } elseif ($sort_domains == "all") {
            $extensions = get_option("tld_order");
            if (trim($extensions) == "") {
                $extensions = whmpress_get_option('whois_db');
                $extensions = explode("\n", $extensions);
                foreach ($extensions as $k => $ext) {
                    if (trim($ext) == "") {
                        unset($extensions[$k]);
                    }
                }

                $PageSize = get_option('no_of_domains_to_show', '2');
                $extensions = array_slice($extensions, 0, $PageSize);
                foreach ($extensions as &$ext) {
                    $E = explode("|", $ext);
                    if (!isset($E[0])) {
                        $E[0] = "";
                    }
                    $ext = $E[0];
                }
            } else {
                $extensions = str_replace(" ", "", $extensions);
                $extensions = explode(",", $extensions);
            }
        }
        return $extensions;
    }
}

if (!function_exists("whmp_get_domain_whois")) {
    function whmp_get_domain_whois($whois_link, $domain)
    {
        if (isset($whois_link) && strtolower($whois_link) == "yes") {
            $whois_link = WHMP_PLUGIN_URL . "/whois.php?domain={$domain}";
            //$whois_link = "<a class=\"whois-button\" href='javascript:;' onclick='window.open(\"" . WHMP_PLUGIN_URL . "/whois.php?domain={$domain}\",\"whmpwin\",\"width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0\")'>" . __("WHOIS", "whmpress") . "</a>";

        } else {
            $whois_link = "";
        }
        return $whois_link;


    }
}

if (!function_exists("whmp_get_domain_www_link")) {
    function whmp_get_domain_www_link($www_link, $domain)
    {
        if (isset($www_link) && strtolower($_POST["www_link"]) == "yes") {
            $www_link = "<a class='www-button' href='http://{$domain}' target='_blank'>" . __("WWW", "whmpress") . "</a>";
        } else {
            $www_link = "";
        }

        return $www_link;
    }
}

if (!function_exists("whmp_get_domain_message")) {
    function whmp_get_domain_message($type, $domain_full, $domain_short, $ext)
    {
        if ($type == "na") {
            $message = whmpress_get_option("domain_not_available_message");
            if ($message == "") {
                $message = __("[domain-name] is not available", "whmpress");
            }
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        if ($type == "a") {
            $message = whmpress_get_option("domain_available_message");
            if ($message == "") {
                $message = __("[domain-name] is available", "whmpress");
            }
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        if ($type == "og_na") {
            $message = whmpress_get_option('ongoing_domain_not_available_message');
            if ($message == "") {
                $message = __("[domain-name] is not available", "whmpress");
            }
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        if ($type == "og_a") {
            $message = whmpress_get_option('ongoing_domain_available_message');
            if ($message == "") {
                $message = __("[domain-name] is available", "whmpress");
            }
            $message = __($message, "whmpress");
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        if ($type == "register_text") {
            $register_text = whmpress_get_option('register_domain_button_text');
            if ($register_text == "") {
                $register_text = __("Select", "whmpress");
            }
            $message = $register_text;
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        if ($type == "recommended") {
            $message = whmpress_get_option("domain_recommended_list");
            if ($message == "") {
                $message = __("Recommended domains list", "whmpress");
            }
            $message = str_replace("[domain-name]", $domain_full, $message);
            $message = str_replace("[domain-short]", $domain_short, $message);
            $message = str_replace("[tld]", $ext, $message);
        }

        return $message;
    }
}

if (!function_exists("whmp_domain_rep_empty")) {
    function whmp_domain_rep_empty($price)
    {

        if (floatval($price) < 0) {
            return "-";
        } else {
            return $price;
        }
    }
}

if (!function_exists("whmp_apply_symbol")) {
    function whmp_apply_symbol($price, $symbol_type = "prefix", $currency)
    {

        if (floatval($price) < 0) {
            return "-";
        } else {
            if ($symbol_type == "prefix") {
                $price = whmp_get_currency_prefix($currency) . $price;
            } elseif ($symbol_type == "suffix") {
                $price = $price . whmp_get_currency_suffix($currency);
            } elseif ($symbol_type == "code") {
                $price = whmp_get_currency_code($currency) . " $price";
            } elseif ($symbol_type == "both") {
                $price = whmp_get_currency_prefix($currency) . $price . whmp_get_currency_suffix($currency);
            }
            return $price;
        }
    }
}


if (!function_exists('ppa')) {
    function ppa($mr, $str = "")
    {

    	ob_start();
        echo "<pre>";
        echo $str . "<br>";
        echo print_r($mr, true);
        echo "</pre>";


        echo ob_get_clean();
    }

}

if (!function_exists('whmp_tf')) {
    function whmp_tf($val)
    {
        $val = strtolower(trim($val));
        if ($val == "yes" || $val == "enabled") {
            return true;
        } else {
            return false;
        }

    }

}


if (!function_exists("is_active_cap")) {
    function is_active_cap()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (is_plugin_active("WHMpress_Client_Area_API/index.php")) {
            return 1;
        } else
            return 0;
    }
}

if (!function_exists("is_active_cop")) {
    function is_active_cop()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (is_plugin_active("whmpress_whmcs_cart/whmpress_whmcs_cart.php")) {
            return 1;
        } else
            return 0;
    }
}

if (!function_exists("is_active_wpct")) {
    function is_active_wpct()
    {
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        if (is_plugin_active('whmpress_comp_tables/index.php')) {
            return 1;
        } else
            return 0;
    }
}

if (!function_exists("whmpress_cron_function")) {
    function whmpress_cron_function()
    {
        //whmpress_write_log("corn was executed.");
        echo "Starting WHMPress cron job.<br>";
        echo "===========================<br>";
        echo whmp_fetch_data();
        echo "============================<br>";
        echo "WHMPress cron job completed.<br>";
    }
}

if (!function_exists('whmpress_write_log')) {
    function whmpress_write_log($log)
    {
        if (is_array($log) || is_object($log)) {
            error_log(print_r($log, true));
        } else {
            error_log($log);
        }
    }
}

