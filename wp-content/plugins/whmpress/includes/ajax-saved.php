<?php
/*
* use for all ajax related functions
*/

global $wpdb;

global $WHMPress;
if (!$WHMPress) {
    $WHMPress = new WHMpress();
}

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
    echo "OK";
    exit;
}

if (isset($_REQUEST["show_price"])) {
    $show_price = $_REQUEST["show_price"];
} else {
    $show_price = "1";
}

if (isset($_REQUEST["show_years"])) {
    $show_years = $_REQUEST["show_years"];
} else {
    $show_years = "1";
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

$_show_price = FALSE;
if ($show_price == "1" || strtoupper($show_price) == "YES") {
    $_show_price = TRUE;
}

$_show_years = FALSE;
if ($show_years == "1" || strtoupper($show_years) == "YES") {
    $_show_years = TRUE;
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


$register_text = $register_text = whmp_get_domain_message("register_text", "", "", "");
$recommended_text = whmp_get_domain_message("recommended", "", "", "");
$order_landing_page = isset($_REQUEST["order_landing_page"]) ? $_REQUEST["order_landing_page"] : "";
$order_link_new_tab = isset($_REQUEST["order_link_new_tab"]) ? $_REQUEST["order_link_new_tab"] : "";

$_REQUEST["params"]["register_text"] = $register_text;

//todo: add in documentation
$append_url = $_REQUEST["params"]["append_url"];

switch ($_POST["do"]) {
    case "getDomainData":
        if (!isset($_POST["domain"]) && isset($_POST["search_domain"])) {
            $_POST["domain"] = $_POST["search_domain"];
        }

        if (@$_POST["domain"] == "") {
            echo "<div class='whmp-domain-required'>" . __("Domain name required.", "whmpress") . "</div>";
            exit;
        }
        if (!$WHMPress->is_valid_domain_name(@$_POST["domain"])) {
            echo "<div class='whmp-not-valid-name'>" . __("Domain <span>" . $_POST["domain"] . "</span> is not a valid domain name.", "whmpress") . "</div>";
            exit;
        }

        include_once(WHMP_PLUGIN_DIR . "/includes/whois.class.php");
        $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/first.tpl";
        if (!is_file($html_template)) {
            $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/first.html";
        }
        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/" . $style . "/first.tpl";
        }
        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/first.html";
        }


        $_insert_data = [
            "search_term" => $_REQUEST["domain"],
            "search_ip" => $WHMPress->ip_address(),
            "search_time" => current_time('mysql'),
        ];

        // Record search logs if "Enable logs for searches" is enabled.
        if (get_option('enable_logs') == "1" && $_insert_data["search_term"] <> "") {
            $wpdb->insert(whmp_get_logs_table_name(), $_insert_data);
        }


        $whois = new Whois();

        if (isset($_REQUEST["domain"])) {
            $domain = $_REQUEST["domain"];
        } else if (isset($_REQUEST["search_domain"])) {
            $domain = $_REQUEST["search_domain"];
        } else {
            $domain = "";
        }

        //--------cleanup domain name--------
        $domain = whmp_get_domain_clean($domain);
        if (!isset($domain["host"])) {
            $domain["host"] = "";
        }

        //--------get tld from domain name, if none get from db--------
        $domain["extension"] = whmp_get_domain_extension($domain["host"]);
        if ($domain["extension"] == "") {
            $domain["extension"] = whmp_get_domain_extension_db();
        }

        $ext = $domain["extension"];          //for historical reasons
        $domain_short = str_replace("." . $domain["extension"], "", $domain["host"]);
        $domain_full = $domain_short . "." . $ext;
        $domain["host"] = $domain_full;      //for historical reasons

        //Below this point, use following veriables please
        $dom = [];
        $dom["ext"] = $dom_ext = $ext;
        $dom["full"] = $dom_full = $domain_full;
        $dom["short"] = $dom_short = $domain_short;

        $searchonly = isset($_POST["searchonly"]) ? $_POST["searchonly"] : "*";
        if (isset($_POST['extensions']) && !empty($_POST['extensions'])) {
            $searchonly = $_POST['extensions'];
        }

        if (empty($searchonly)) {
            $searchonly = "*";
        }


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

            //----------initialize HTML variable--------

            $result = $whois->whoislookup($dom["full"], $dom["ext"]);
            $dom["og"] = FALSE;

            //All printing, smarty task will go into a single function of print row

            $__smarty = whmp_domain_search_smarty($dom, $params, $result);
            $smarty_array = array_merge($smarty_array, $__smarty);

            // if domain spinnnig is disabled, no need to enter loop
            if ($disable_domain_spinning == "1") {
                //do nothing
            } else {
                $smarty_array["recommended_domains_text"] = $recommended_text;
            }
            $smarty_array["order_button_text"] = $register_text;

        }
        /*-2-********************************************-*
        *-----------------first-loop
        *-*************************************************/
        if (TRUE) {
            /*
 * Sortout which domains to search
 */
            // domains in whmcs only
            if (isset($_REQUEST["skip_extra"]) && $_REQUEST["skip_extra"] == "1") {
                $extensions = whmp_get_domains_searchable("whmcs");

            } // all domains in whois db
            elseif (is_string($searchonly) && $searchonly == "*") {
                $extensions = whmp_get_domains_searchable("all");

            } // search given extensions only
            else {
                $extensions = $searchonly;
                if (!is_array($searchonly) && is_string($searchonly)) {
                    $extensions = str_replace(" ", "", $extensions);
                    $extensions = explode(",", $extensions);
                }
            }
            //----skip-extra-end---
            $smarty_domains = [];

            foreach ($extensions as $x => $ext) {

                if ($disable_domain_spinning == "1") {
                    break;
                }


                $ext = ltrim($ext, ".");
                if ($ext == $dom_ext) { //if it was the first domain, skip it
                    continue;
                }
                //--------------------------
                $dom["ext"] = $ext;
                $dom["short"] = $dom_short;
                $dom["full"] = $dom["short"] . "." . $dom["ext"];
                $dom["og"] = TRUE;

                /*                    $smarty_domain = [];
                                    $smarty_domain["extension"] = $ext;
                                    $newDomain = $domain_short . "." . $ext;
                                    $smarty_domain["domain"] = $newDomain;*/

                $result = $whois->whoislookup($dom["full"], $dom["ext"]);

                $__smarty = whmp_domain_search_smarty($dom, $params, $result);

                $smarty_domains[] = $__smarty;
            }

            /*
             * --------Load more---------
             */

            if (is_string($searchonly) && $searchonly == "*" && $disable_domain_spinning == "0") {

                $smarty_load_more = "<div id='load-more-div' class='load-more-div'><button type='button'>$load_more</button></div>";
            } else {
                $smarty_load_more = "";
            }

            $smarty_load_more .= "
            <script>
                function load_more() {
                    jQuery(\"#load-more-div\").remove();
                    jQuery(\".result-div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner\"></i></div>');
                    whmp_page++;
                    jQuery.post(WHMPAjax.ajaxurl, {'domain':jQuery('#domain_{$ajax_id}').val(),'action':'whmpress_action','do':'loadWhoisPage','skip_extra':'0','page':whmp_page,'searchonly':'{$searchonly}','lang':''}, function(data){
                        jQuery(\"#waiting_div\").remove();
                        jQuery(\".result-div\").append(data);
                    });
                };
            </script>
            ";

            if (is_file($html_template)) {
                $vars = [
                    "data" => $smarty_array,
                    "domains" => $smarty_domains,
                    "load_more" => $smarty_load_more,
                    "form_url" => esc_url($WHMPress->get_whmcs_url("domainchecker"))
                ];

                $OutputString = whmp_smarty_template($html_template, $vars);
                echo $OutputString;
            } else {
                $HTML .= "</div>";
                echo $HTML;
            }

        }


        break;

    /*-3-********************************************-*
    *-----------------2nd-loop
    *-*************************************************/

    case
    "loadWhoisPage":

        $params = $_REQUEST["params"];
        $dom_short = $_REQUEST["domain"];

        include_once(WHMP_PLUGIN_DIR . "/includes/whois.class.php");

        $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/more.tpl";
        if (!is_file($html_template)) {
            $html_template = $WHMPress->whmp_get_template_directory() . "/whmpress/ajax/more.html";
        }
        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/" . $style . "/more.tpl";
        }
        if (!is_file($html_template)) {
            $html_template = WHMP_PLUGIN_DIR . "/templates/ajax/more.html";
        }


        //------

        //whmp_get_searchable_extensions($whois,$args)

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

        # creating pagination
        $PageSize = get_option('no_of_domains_to_show', '2');
        #echo "Page: ".$_REQUEST["page"]." ";
        $start = ($_REQUEST["page"] - 1) * ($PageSize);
        #echo "Start: ".$start." PageSize: $PageSize";
        $WhoIS = array_slice($WhoIS, $start, $PageSize);

        $smarty_domains = [];
        //process all domains available in whois

        $whois = new Whois;
        //foreach ($extensions as $x => $ext) {
        foreach ($WhoIS as $line) {

            $ar = explode("|", $line);
            if (!isset($ar[0])) {
                $ar[0] = "";
            }

            $ext = ltrim($ar[0], ".");
            if ($ext == $dom_ext) { //if it was the first domain, skip it
                continue;
            }

            //--------------------------
            $dom["ext"] = $ext;
            $dom["short"] = $dom_short;
            $dom["full"] = $dom["short"] . "." . $dom["ext"];
            $dom["og"] = TRUE;


            $result = $whois->whoislookup($dom["full"], $dom["ext"]);

            $__smarty = whmp_domain_search_smarty($dom, $params, $result);

            $smarty_domains[] = $__smarty;
        }


        $load_more = whmpress_get_option('load_more_button_text');
        if ($load_more == "") {
            $load_more = __("Load More", "whmpress");
        }
        if (sizeof($WhoIS) >= $PageSize) {
            $HTML .= "<div class='load-more-div' id='load-more-div'><button type='button'>$load_more</button></div>";
            $smarty_load_more = "<div Class='load-more-div' id='load-more-div'><button type='button'>$load_more</button></div>";
        } else {
            $smarty_load_more = "";
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
        } else {
            echo $HTML;
        }
        break;
}
exit;
wp_die(); // this is required to return a proper result