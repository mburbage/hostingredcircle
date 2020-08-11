<?php
/*
* use for all ajax related functions
*/


if (isset($_GET["set_default_currency"])) {
    $Wp_load = realpath(dirname(__FILE__) . '/../../../../wp-load.php');
    if (!is_file($Wp_load)) {
        die("WordPress library not found.");
    }
    require_once($Wp_load);

    $new_curr = isset($_POST["new_curr"]) ? $_POST["new_curr"] : "";
    update_option("whmpress_default_currency", $new_curr);
    echo "OK";
    exit;
}

if (isset($_GET["setCurrency"])) {
    $Wp_load = realpath(dirname(__FILE__) . '/../../../../wp-load.php');
    if (!is_file($Wp_load)) {
        die("WordPress library not found.");
    }
    if (!session_id()) {
        $cacheValue = get_option('whmpress_session_cache_limiter_value');
        session_cache_limiter($cacheValue);
        session_start();
    }
    $_SESSION["whcom_currency"] = $_POST["curency"];
    $_SESSION["whcom_current_currency_id"] = $_POST["curency"];

    echo "OK";
    exit;
}


if (isset($_REQUEST["show_price"])) {
    $show_price = strtolower($_REQUEST["show_price"]);
    if ($show_price == "1" || $show_price == "yes" || $show_price = "true") {
        $_REQUEST["show_price"] = "yes";
    }

} else {
    $_REQUEST["show_price"] = "no";
}


if (isset($_REQUEST["show_years"])) {
    $show_years = strtolower($_REQUEST["show_years"]);
} else {
    $show_years = "no";
}

if ($show_years == "1" || $show_years == "yes" || $show_years == "true") {
    $show_years = "yes";
}


$_transfer_enabled = "no";

if (isset($_REQUEST["enable_transfer_link"])) {
    $enable_transfer_link = $_REQUEST["enable_transfer_link"];
} else {
    $enable_transfer_link = "no";
}

if ($enable_transfer_link == "1" || strtolower($enable_transfer_link) == "yes" || $enable_transfer_link === true) {
    $_transfer_enabled = "yes";
}


if (isset($_REQUEST["disable_domain_spinning"])) {
    $disable_domain_spinning = $_REQUEST["disable_domain_spinning"];
} else {
    $disable_domain_spinning = "0";
}

$style = (!empty($_REQUEST["style"])) ? strtolower(esc_attr($_REQUEST["style"])) : '';


$load_more = whmpress_get_option('load_more_button_text');
if ($load_more == "") {
    $load_more = __("Load More", "whmpress");
}


$register_text = whmp_get_domain_message("register_text", "", "", "");
$recommended_text = whmp_get_domain_message("recommended", "", "", "");
$order_landing_page = isset($_REQUEST["order_landing_page"]) ? $_REQUEST["order_landing_page"] : "";
$order_link_new_tab = isset($_REQUEST["order_link_new_tab"]) ? $_REQUEST["order_link_new_tab"] : "";

$_REQUEST["params"]["register_text"] = $register_text;

include_once(WHMP_PLUGIN_DIR . "/includes/whois.class.php");


//------------ Domain related Ajax Functions ----------
global $wpdb;
global $WHMPress;
$whois = new Whois();


switch ($_POST["do"]) {

    case "getDomainDataBulk":

        //todo: improve code to get parameters, it is not in concise
        $append_url = $_REQUEST["params"]["append_url"];
        $skip_extra = whmp_tfc($_REQUEST["skip_extra"]);

        $searchonly = isset($_POST["searchonly"]) ? $_POST["searchonly"] : "*";
        if (isset($_POST['extensions']) && !empty($_POST['extensions'])) {
            $searchonly = $_POST['extensions'];
        }

        if (!isset($_POST["domain"]) && isset($_POST["search_domain"])) {
            $_POST["domain"] = $_POST["search_domain"];
        }

        //--messages for invalid domain
        if (isset($_REQUEST["domain"])) {
            $domain = $_REQUEST["domain"];
        } else if (isset($_REQUEST["search_domain"])) {
            $domain = $_REQUEST["search_domain"];
        } else {
            $domain = "";
        }

        if ($domain == "") {
            echo "<div class='whmp-domain-required'>" . __("Domain name required.", "whmpress") . "</div>";
            exit;
        }

        if (!$WHMPress->is_valid_domain_name($domain)) {
            echo "<div class='whmp-not-valid-name'>" . __("Domain <span>" . $domain . "</span> is not a valid domain name.", "whmpress") . "</div>";
            exit;
        }


        // Record search logs if "Enable logs for searches" is enabled.
        if (get_option('enable_logs') == "1") {
            $_insert_data = [
                "search_term" => $_REQUEST["domain"],
                "search_ip" => $WHMPress->ip_address(),
                "search_time" => current_time('mysql'),
            ];

            if ($_insert_data["search_term"] <> "") {
                global $wpdb;
                $wpdb->insert(whmp_get_logs_table_name(), $_insert_data);
            }

        }


        //--------make domain array--------
        $domain = whmp_get_domain_clean($domain);
        $dom_ext = whmp_get_domain_extension($domain["full"]);

        $dom = [];
        $dom["ext"] = ($dom_ext == "") ? whmp_get_domain_extension_db() : $dom_ext;
        $dom["short"] = $domain["short"];
        $dom["full"] = $dom["short"] . "." . $dom["ext"];

        $dom_ext = $dom["ext"]; //save first searched extension



        /*-1-********************************************-*
        *-----------------top-part
        *-*************************************************/

        if (true) {
            //--------build smarty array with what ever information we have
            $_REQUEST["params"]["www_text"] = __("WWW", "whmpress");
            $_REQUEST["params"]["whois_text"] = __("WHOIS", "whmpress");
            $_REQUEST["params"]["transfer_text"] = __("Transfer", "whmpress");
            if (isset($_REQUEST["params"])) {
                $smarty_array["params"] = $_REQUEST["params"];
                $params = $_REQUEST["params"];
            }

            //---Get whois info
            $whois_server = whmp_get_whois_servers($dom["ext"]);

            //---Append whois server info to domain
            $dom["info"] = $whois_server[$dom["ext"]];


            //---check availability

            $result = $whois->whoislookup_i($dom);


            $dom["og"] = false;


            //---build top result

            $__smarty = whmp_domain_search_smarty($dom, $params, $result);


            //---add to smarty domain array
            $smarty_array = array_merge($smarty_array, $__smarty);

            /*            // if domain spinnnig is disabled, no need to enter loop
                        if ($disable_domain_spinning <> "1")
                            {
                                $smarty_array["recommended_domains_text"] = $recommended_text;
                            }*/
            //todo: check if it is already being added by whmp_domain_search_smarty

            $smarty_array["order_button_text"] = $register_text;


        }

        /*-2-********************************************-*
        *-----------------first-loop
        *-*************************************************/
        if ($disable_domain_spinning <> "1") {
            $smarty_array["recommended_domains_text"] = $recommended_text;


            $whois_servers = whmp_get_whois_servers();
            if ($skip_extra) {
                $whois_servers = whmp_filter_whois_servers($whois_servers, "remove_extra");
            }

            if (is_string($searchonly) && $searchonly == "*") {
                //already have full domains

            } elseif (!is_array($searchonly) && is_string($searchonly)) {
                $searchonly = str_replace(" ", "", $searchonly);
                $searchonly = explode(",", $searchonly);
                if (count($searchonly) > 1) {
                    $whois_servers = whmp_filter_whois_servers($whois_servers, $searchonly);
                }
            }

            $PageSize = get_option('no_of_domains_to_show', '2');
            $whois_servers = array_slice($whois_servers, 0, $PageSize);

            //----skip-extra-end---
            $smarty_domains = [];


            foreach ($whois_servers as $ext => $info) {

                if (ltrim($ext, ".") == $dom_ext) { //if it was the first domain, skip it
                    continue;
                }
                //--------------------------
                $dom["ext"] = $ext;
                $dom["full"] = $dom["short"] . "." . $dom["ext"];
                $dom["info"] = $info;
                $dom["og"] = true;

                $result = $whois->whoislookup_i($dom);

                $__smarty = whmp_domain_search_smarty($dom, $params, $result);

                $smarty_domains[] = $__smarty;
            }


            /*
             * --------Load more---------
             */

            if (is_string($searchonly) && $searchonly == "*" && $disable_domain_spinning == "0") {

                $smarty_load_more = "<div id='load-more-div' class='load-more-div'><button type='button'>$load_more</button></div>";
            }

        }

        $html_template = whmpress_get_domain_search_template("first", $style);
        if (is_file($html_template)) {
            $vars = [
                "data" => $smarty_array,
                "domains" => $smarty_domains,
                "load_more" => $smarty_load_more,
                "form_url" => esc_url($WHMPress->get_whmcs_url("domainchecker"))
            ];

            $OutputString = whmp_smarty_template($html_template, $vars);
            echo $OutputString;
        }

        break;

    case "getDomainData":

        //todo: improve code to get parameters, it is not in concise
        $append_url = $_REQUEST["params"]["append_url"];
        $skip_extra = whmp_tfc($_REQUEST["skip_extra"]);

        $searchonly = isset($_POST["searchonly"]) ? $_POST["searchonly"] : "*";
        if (isset($_POST['extensions']) && !empty($_POST['extensions'])) {
            $searchonly = $_POST['extensions'];
        }

        if (!isset($_POST["domain"]) && isset($_POST["search_domain"])) {
            $_POST["domain"] = $_POST["search_domain"];
        }

        //--messages for invalid domain
        if (isset($_REQUEST["domain"])) {
            $domain = $_REQUEST["domain"];
        } else if (isset($_REQUEST["search_domain"])) {
            $domain = $_REQUEST["search_domain"];
        } else {
            $domain = "";
        }

        if ($domain == "") {
            echo "<div class='whmp-domain-required'>" . __("Domain name required.", "whmpress") . "</div>";
            exit;
        }

        if (!$WHMPress->is_valid_domain_name($domain)) {
            echo "<div class='whmp-not-valid-name'>" . __("Domain <span>" . $domain . "</span> is not a valid domain name.", "whmpress") . "</div>";
            exit;
        }
        if (!$WHMPress->is_valid_domain_pk($domain)) {
            echo "<div class='whmp-not-valid-name'>" . __("PKNIC is not offering 3 character domain names with “.pk”. Although names will appear as available on PKNIC website but they cannot be registered.", "whmpress") . "</div>";
            exit;
        }

        // Record search logs if "Enable logs for searches" is enabled.
        if (get_option('enable_logs') == "1") {
            $_insert_data = [
                "search_term" => $_REQUEST["domain"],
                "search_ip" => $WHMPress->ip_address(),
                "search_time" => current_time('mysql'),
            ];

            if ($_insert_data["search_term"] <> "") {
                global $wpdb;
                $wpdb->insert(whmp_get_logs_table_name(), $_insert_data);
            }

        }


        //--------make domain array--------
        $domain = whmp_get_domain_clean($domain);
        $dom_ext = whmp_get_domain_extension($domain["full"]);

        $dom = [];
        $dom["ext"] = ($dom_ext == "") ? whmp_get_domain_extension_db() : $dom_ext;
        $dom["short"] = $domain["short"];
        $dom["full"] = $dom["short"] . "." . $dom["ext"];

        $dom_ext = $dom["ext"]; //save first searched extension

        /*-1-********************************************-*
        *-----------------top-part
        *-*************************************************/

        //if (true) {
            //--------build smarty array with what ever information we have
            $_REQUEST["params"]["www_text"] = __("WWW", "whmpress");
            $_REQUEST["params"]["whois_text"] = __("WHOIS", "whmpress");
            $_REQUEST["params"]["transfer_text"] = __("Transfer", "whmpress");
            if (isset($_REQUEST["params"])) {
                $smarty_array["params"] = $_REQUEST["params"];
                $params = $_REQUEST["params"];
            }

            //---Get whois info
            $whois_server = whmp_get_whois_servers($dom["ext"]);

            //---Append whois server info to domain
            $dom["info"] = $whois_server[$dom["ext"]];

            //---check availability
            $result = $whois->whoislookup_i($dom);
            $dom["og"] = false;

            //---build top result
            $__smarty = whmp_domain_search_smarty($dom, $params, $result);

            //---add to smarty domain array
            $smarty_array = array_merge($smarty_array, $__smarty);

            /*            // if domain spinnnig is disabled, no need to enter loop
                        if ($disable_domain_spinning <> "1")
                            {
                                $smarty_array["recommended_domains_text"] = $recommended_text;
                            }*/
            //todo: check if it is already being added by whmp_domain_search_smarty
            $smarty_array["order_button_text"] = $register_text;

        //}
        /*-2-********************************************-*
        *-----------------first-loop
        *-*************************************************/
        if ($disable_domain_spinning <> "1") {
            $smarty_array["recommended_domains_text"] = $recommended_text;


            $whois_servers = whmp_get_whois_servers();
            if ($skip_extra) {
                $whois_servers = whmp_filter_whois_servers($whois_servers, "remove_extra");
            }

            if (is_string($searchonly) && $searchonly == "*") {
                //already have full domains

            } elseif (!is_array($searchonly) && is_string($searchonly)) {
                $searchonly = str_replace(" ", "", $searchonly);
                $searchonly = explode(",", $searchonly);
                if (count($searchonly) > 1) {
                    $whois_servers = whmp_filter_whois_servers($whois_servers, $searchonly);
                }
            }

            $PageSize = get_option('no_of_domains_to_show', '2');
            $whois_servers = array_slice($whois_servers, 0, $PageSize);

            //----skip-extra-end---
            $smarty_domains = [];


            foreach ($whois_servers as $ext => $info) {

                if (ltrim($ext, ".") == $dom_ext) { //if it was the first domain, skip it
                    continue;
                }
                //--------------------------
                $dom["ext"] = $ext;
                $dom["full"] = $dom["short"] . "." . $dom["ext"];
                $dom["info"] = $info;
                $dom["og"] = true;

                $result = $whois->whoislookup_i($dom);

                $__smarty = whmp_domain_search_smarty($dom, $params, $result);

                $smarty_domains[] = $__smarty;
            }


            /*
             * --------Load more---------
             */

            if (is_string($searchonly) && $searchonly == "*" && $disable_domain_spinning == "0") {

                $smarty_load_more = "<div id='load-more-div' class='load-more-div'><button type='button'>$load_more</button></div>";
            }

        }

        $html_template = whmpress_get_domain_search_template("first", $style);
        if (is_file($html_template)) {
            $vars = [
                "data" => $smarty_array,
                "domains" => $smarty_domains,
                "load_more" => $smarty_load_more,
                "form_url" => esc_url($WHMPress->get_whmcs_url("domainchecker"))
            ];

            $OutputString = whmp_smarty_template($html_template, $vars);
            echo $OutputString;
        }

        break;

    case "loadWhoisPage": {

        $append_url = $_REQUEST["params"]["append_url"];
        $smarty_load_more = "";

        $skip_extra = whmp_tfc($_REQUEST["skip_extra"]);

        $domain = whmp_get_domain_clean($_REQUEST["domain"]);
        $dom["short"] = $domain["short"];

        $params = $_REQUEST["params"];


        $html_template = whmpress_get_domain_search_template("more");

        //---1. Get whois servers
        $whois_servers = whmp_get_whois_servers();

        //---2. Filter domains, as per shortcode parameters,  get only that we need to search
        if ($skip_extra) {
            $whois_servers = whmp_filter_whois_servers($whois_servers, "remove_extra");
        }

        if (is_string($searchonly) && $searchonly == "*") {
            //already have full domains

        } elseif (!is_array($searchonly) && is_string($searchonly)) {
            $searchonly = str_replace(" ", "", $searchonly);
            $searchonly = explode(",", $searchonly);
            if (count($searchonly) > 1) {
                $whois_servers = whmp_filter_whois_servers($whois_servers, $searchonly);
            }
        }


        //----2. creating pagination
        $PageSize = get_option('no_of_domains_to_show', '2');
        $start = ($_REQUEST["page"] - 1) * ($PageSize);
        $whois_servers = array_slice($whois_servers, $start, $PageSize);

        $smarty_domains = [];

        $whois = new Whois;
        foreach ($whois_servers as $ext => $info) {

            //---domain array for whois server
            $dom["ext"] = $ext;
            $dom["full"] = $dom["short"] . "." . $dom["ext"];
            $dom["info"] = $info;
            $dom["og"] = true;

            //---check availability
            $result = $whois->whoislookup_i($dom);

            //---build smarty veriables for this domain

            $__smarty = whmp_domain_search_smarty($dom, $params, $result);

            //---append to smarty domain array
            $smarty_domains[] = $__smarty;
        }


        $load_more = whmpress_get_option('load_more_button_text');
        $load_more = ($load_more == "") ? esc_html__("Load More", "whmpress") : $load_more;

        if (sizeof($whois_servers) >= $PageSize) {
            $smarty_load_more = "<div Class='load-more-div' id='load-more-div'>";
            $smarty_load_more .= "<button type = 'button' >" . $load_more . " </button >";
            $smarty_load_more .= "</div > ";
        }
        if (is_file($html_template)) {
            $vars = [
                "domains" => $smarty_domains,
                "load_more" => $smarty_load_more
            ];

            $_REQUEST["params"]["www_text"] = __("WWW", "whmpress");
            $_REQUEST["params"]["whois_text"] = __("WHOIS", "whmpress");
            $_REQUEST["params"]["transfer_text"] = __("Transfer", "whmpress");
            if (isset($_REQUEST["params"])) {
                $vars["params"] = $_REQUEST["params"];
            }
            if (!is_array($vars["params"])) {
                $vars["params"] = json_decode($vars["params"], true);
            }

            $OutputString = whmp_smarty_template($html_template, $vars);
            echo $OutputString;
        }
        break;
    }
    case 'whmpress_domain_search_ajax_extended_results' : {
        $response = [];

        $response['status'] = 'OK';
        $response['post'] = $_POST;
        $sld = (!empty(esc_attr($_POST['sld']))) ? esc_attr($_POST['sld']) : '';
        $tld = (!empty(esc_attr($_POST['tld']))) ? esc_attr($_POST['tld']) : '';
        $is_title = (!empty(esc_attr($_POST['is_title']))) ? esc_attr($_POST['is_title']) : false;
        $response['title_val'] = $is_title;

        $params = (!empty($_POST['params']) && is_array($_POST['params'])) ? $_POST['params'] : [];


        $dom["ext"] = $tld;
        $dom["short"] = $sld;
        $dom["full"] = $sld . "." . $tld;
        $dom["info"] = whmp_get_whois_servers($tld)[$tld];
        $dom["og"] = true;

        $result = $whois->whoislookup_i($dom);


        $result_details = whmpress_domain_search_ajax_extended_search_result_details($dom, $params, $result);

        ob_start();
        $style = (string)$params['style'];
        $file = WHMP_PLUGIN_PATH . '/includes/shortcodes/domain_search_ajax_extended_parts/results/' . $style . '.php';

        if (is_file($file)) {
            include $file;
        } else {
            //todo: to be replaced with actual message
            ?>
            Invalid Style
        <?php }

        $response['response_html'] = ob_get_clean();

        echo json_encode($response, JSON_FORCE_OBJECT);

        break;
    }


}

wp_die(); // this is required to return a proper result