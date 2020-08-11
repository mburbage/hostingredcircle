<?php
if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
	$the_lang = ICL_LANGUAGE_CODE;
} else {
	$the_lang = get_locale();
}

// All shortcodes and their functions are defined in array to recognise
$whmp_shortcodes_list = [
	"whmpress_price"                => "whmpress_price_function",
	"whmpress_price_i"              => "whmpress_price_function_i",
	"whmpress_domain_price"         => "whmpress_domain_price_function",
	//"whmpress_price_table"          => "whmpress_price_table_function",
	"whmpress_price_matrix"         => "whmpress_price_table_function",
	"whmpress_price_matrix_extended"         => "whmpress_price_table_extended_function",
	"whmpress_price_table_domain"   => "whmpress_price_table_domain_function",
	"whmpress_price_matrix_domain"  => "whmpress_price_table_domain_function",
	"whmpress_price_domain_list"    => "whmpress_price_domain_list_function",
	"whmpress_order_combo"          => "whmpress_order_combo_function",
	"whmpress_order_button"         => "whmpress_order_button_function",
	"whmpress_order_link"           => "whmpress_order_link_function",
	"whmpress_order_url"            => "whmpress_order_url_function",
	"whmpress_currency"             => "whmpress_currency_function",
	"whmpress_currency_combo"       => "whmpress_currency_combo_function",
	"whmpress_currency_combo_fancy" => "whmpress_currency_combo_fancy_function",
	"whmpress_name"                 => "whmpress_name_function",
	"whmpress_description"          => "whmpress_description_function",
	"whmpress_cdescription"         => "whmpress_cdescription_function",
	"whmpress_price_box"            => "whmpress_pricing_table_horizontal_function",
	"whmpress_pricing_table"        => "whmpress_pricing_table_function",
	"whmpress_domain_search"        => "whmpress_domain_search_function",
	"whmpress_domain_search_ajax"   => "whmpress_domain_search_ajax_function",
	"whmpress_domain_search_ajax_extended"  => "whmpress_domain_search_ajax_extended_function",
	//"whmpress_domain_search_ajax_results" => "whmpress_domain_search_ajax_results_function",
	/*"whmpress_domain_search_extended_ajax" => "whmpress_domain_search_extended_ajax_function",
    "whmpress_domain_search_extended_ajax_results" => "whmpress_domain_search_extended_ajax_results_function",*/
	"whmpress_domain_search_bulk"   => "whmpress_domain_search_bulk_function",
	"whmpress_domain_whois"         => "whmpress_whois_function",
	"whmpress_login_form"           => "whmpress_login_form_function",
	"whmpress_url"                  => "whmpress_url_function",
	"whmpress_announcements"        => "whmpress_announcements_function",
	"whmpress_bundle_price"         => "whmpress_bundle_price_function",
	"whmpress_bundle_name"          => "whmpress_bundle_name_function",
	"whmpress_bundle_description"   => "whmpress_bundle_description_function",
	"whmpress_bundle_order_button"  => "whmpress_bundle_order_button_function",
	"whmpress_bundle_pricing_table" => "whmpress_bundle_pricing_table_function",


	#"whmpress_geek" => "whmpress_geek_function",
	#"whmpress_cyearly" => "whmp_shortcode_yearly",
	#"whmpress_cmonthly" => "whmp_shortcode_cmonthly",
];
$whmp_shortcodes_list_title = [
	"whmpress_price"                => esc_html__("Price","whmpress"),
	"whmpress_domain_price"         => esc_html__("Domain Price","whmpress"),
	"whmpress_price_table"          => esc_html__("Price Matrix","whmpress"),
	"whmpress_price_matrix"         => esc_html__("Price Matrix","whmpress"),
	"whmpress_price_table_domain"   => esc_html__("Price Matrix Domain","whmpress"),
	"whmpress_price_matrix_domain"  => esc_html__("Price Matrix Domain","whmpress"),
	"whmpress_price_domain_list"    => esc_html__("Domain Price List","whmpress"),
	"whmpress_order_combo"          => esc_html__("Order Combo","whmpress"),
	"whmpress_order_button"         => esc_html__("Order Button","whmpress"),
	"whmpress_order_link"           => esc_html__("Order Link","whmpress"),
	"whmpress_order_url"            => esc_html__("Order URL","whmpress"),
	"whmpress_currency"             => esc_html__("Currency","whmpress"),
	"whmpress_currency_combo"       => esc_html__("Currency Combo","whmpress"),
	"whmpress_currency_combo_fancy" => esc_html__("Fancy Currency Combo","whmpress"),
	"whmpress_name"                 => esc_html__("Name","whmpress"),
	"whmpress_description"          => esc_html__("Description","whmpress"),
	"whmpress_price_box"            => esc_html__("Price Box","whmpress"),
	"whmpress_pricing_table"        => esc_html__("Pricing Table","whmpress"),
	"whmpress_domain_search"        => esc_html__("Domain Search","whmpress"),
	"whmpress_domain_search_ajax"   => esc_html__("Domain Search Ajax","whmpress"),
	"whmpress_domain_search_ajax_extended"  => esc_html__("Domain Search AJAX Extended","whmpress"),
	//"whmpress_domain_search_ajax_results" => "whmpress_domain_search_ajax_results_function",
	/*"whmpress_domain_search_extended_ajax" => "whmpress_domain_search_extended_ajax_function",
    "whmpress_domain_search_extended_ajax_results" => "whmpress_domain_search_extended_ajax_results_function",*/
	"whmpress_domain_search_bulk"   => esc_html__("Domain Search Bulk","whmpress"),
	"whmpress_domain_whois"         => esc_html__("Domain Whois","whmpress"),
	"whmpress_login_form"           => esc_html__("Login Form","whmpress"),
	"whmpress_url"                  => esc_html__("WHMPress URL","whmpress"),
	"whmpress_announcements"        => esc_html__("Announcements","whmpress"),
	"whmpress_bundle_price"         => esc_html__("Bundle Price","whmpress"),
	"whmpress_bundle_name"          => esc_html__("Bundle Name","whmpress"),
	"whmpress_bundle_description"   => esc_html__("Bundle Description","whmpress"),
	"whmpress_bundle_order_button"  => esc_html__("Bundle Order Button","whmpress"),
	"whmpress_bundle_pricing_table" => esc_html__("Bundle Pricing Table","whmpress"),


	#"whmpress_geek" => "whmpress_geek_function",
	#"whmpress_cyearly" => "whmp_shortcode_yearly",
	#"whmpress_cmonthly" => "whmp_shortcode_cmonthly",
];


## Do not use these shortcodes in VC integration, Text editor and this shortcode will also disabled.
$donot_use = [
	"whmpress_price_table",
	"whmpress_price_table_domain",
	"whmpress_currency_combo_fancy",
	"whmpress_cdescription",
	"whmpress_bundle_description",
	"whmpress_bundle_price",
	"whmpress_login_form", // TODO: Remove in future,
];

## These shortcodes will work in background but will not include in VC integration and Text editor.
$donot_include_editors = [
	"whmpress_price_i",
	//"whmpress_domain_search_ajax_extended",
];

// Adding all shortcodes mentioned in array above
foreach ( $whmp_shortcodes_list as $shortcode => $func ) {
	add_shortcode( $shortcode, $func );
}

if (!function_exists("whmpress_bundle_pricing_table_function")) {
    function whmpress_bundle_pricing_table_function($atts, $content = null)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_bundle_pricing_table.php");
    }
}

if (!function_exists("whmpress_bundle_price_function")) {
    function whmpress_bundle_price_function($atts, $content = null)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_bundle_price.php");
    }
}

if (!function_exists("whmpress_bundle_name_function")) {
    function whmpress_bundle_name_function($atts, $content = null)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_bundle_name.php");
    }
}

if (!function_exists("whmpress_bundle_description_function")) {
    function whmpress_bundle_description_function($atts, $content = null)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_bundle_description.php");
    }
}

if (!function_exists("whmpress_bundle_order_button_function")) {
    function whmpress_bundle_order_button_function($atts, $content = null)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_bundle_order_button_function.php");
    }
}

if (!function_exists("whmpress_announcements_function")) {
    function whmpress_announcements_function($atts, $content = null)
    {
        extract(shortcode_atts([
            'count' => '3',
            'words' => '25',
        ], $atts));

        if (!is_numeric($count)) {
            $count = "3";
        }
        if ($count < 1) {
            $count = "3";
        }

        if (!is_numeric($words)) {
            $words = "25";
        }
        if ($words < 1) {
            $words = "25";
        }

        global $wpdb;
        $table_name = $wpdb->prefix . "whmpress_announcements";
        $Q = "SELECT * FROM `{$table_name}` WHERE (published='1' OR published='on') ORDER BY date DESC LIMIT 0,{$count}";
        $rows = $wpdb->get_results($Q);

        if (is_active_cap()) {
            //todo: client_area announcements url here
            $url = rtrim(get_option("whmcs_url"), "/") . "/announcements.php?id={{id}}";
        } else {
            $url = rtrim(get_option("whmcs_url"), "/") . "/announcements.php?id={{id}}";
        }

        $return_string = "";
        foreach ($rows as $row) {
            $row->announcement = explode(" ", $row->announcement);
            array_splice($row->announcement, $words);
            $row->announcement = implode(" ", $row->announcement);

            $url = str_replace("{{id}}", $row->id, $url);

            $return_string .= "<div class=\"whmpress_announcements\">
          <span class=\"announcement-date\">" . mysql2date(get_option('date_format'), $row->date) . " - </span>
          <a class=\"announcement-id\" href=\"{$url}\"><b>{$row->title}</b></a>
          <p class=\"announcement-summary\">" . $row->announcement . "</p>
        </div>\n";
        }

        return $return_string;
    }
}

if (!function_exists("whmpress_domain_price_function")) {
    function whmpress_domain_price_function($atts, $content = null)
    {
        $OutputString = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_price.php");

        return $OutputString;
    }
}

if (!function_exists("whmpress_url_function")) {
    function whmpress_url_function($atts, $content = null)
    {
        extract(shortcode_atts([
            'type' => 'client_area',
        ], $atts));


        if ($type == "") {
            $type = "client_area";
        }
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_url.php");

        return $html;
    }
}

if (!function_exists("whmpress_login_form_function")) {
    function whmpress_login_form_function($atts, $content = null)
    {
        /**
         * Return WHMCS registration form
         *
         * List of parameters
         * html_class = HTML class for container
         * html_id = HTML id for container
         * button_class = HTML class for button
         * button_text = Button text
         */

        // If WHMPress settings -> Styles -> include FontAwesome selected Yes
        if (get_option('include_fontawesome') == "1") {
            wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
        }

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'button_class' => '',
            'button_text' => "Login",
            'html_id' => '',
            'html_class' => 'whmpress whmpress_login_form',
        ], $atts));

        # Checking parameters
        #$button_class = isset($atts["button_class"])?$atts["button_class"]:"";
        #$html_class = isset($atts["html_class"])?$atts["html_class"]:""; if ($html_class=="") $html_class = "whmpress whmpress_login_form";
        #$html_id = isset($atts["html_id"])?$atts["html_id"]:"";
        #$button_text = !empty($atts["button_text"])?$atts["button_text"]:"Login";

        # Generating output form
        $WHMPress = new WHMpress();

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_login_form");

        if (is_file($html_template)) {
            $vars = [
                "action_url" => $WHMPress->get_whmcs_url("loginurl"),
                "username_field" => "<label>Username:</lable> <input type='text' name='username' >",
                "password_field" => "<label>Password:</lable> <input type='password' name='password' >",
                "button" => "<input type='submit' value='" . __($button_text, "whmpress") . "'>",
                "button_text" => __($button_text, "whmpress"),
            ];


            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_login_form");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            $str = '<form method="post" action="' . $WHMPress->get_whmcs_url("loginurl") . '">' . "\n";
            $str .= '<div><label>' . __("Email address", 'whmpress') . '</label><input placeholder="' . __("Email address", 'whmpress') . '" type="text" name="username" /></div>' . "\n";
            $str .= '<div><label>' . __("Password", 'whmpress') . '</label><input placeholder="' . __("Password", 'whmpress') . '" type="password" name="password" /></div>' . "\n";
            $str .= '<button class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>' . "\n";
            $str .= "</form>\n";

            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            return "<div $CLASS $ID>" . $str . "</div>";
        }
    }
}

if (!function_exists("whmpress_whois_function")) {
    function whmpress_whois_function($atts)
    {
        $OutputString = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_whois.php");

        return $OutputString;
    }
}

if (!function_exists("whmpress_domain_search_bulk_function")) {
    function whmpress_domain_search_bulk_function($atts)
    {
        $OutputString = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_search_bulk.php");

        return $OutputString;
    }
}

if (!function_exists("whmpress_domain_search_extended_ajax_function")) {
    function whmpress_domain_search_extended_ajax_function($atts)
    {
        /**
         * Displays a form for getting whois info of domains
         *
         * List of parameters
         * action = Action url for form. Form will submit on this url
         * text_class = HTML class for input search text box
         * button_class = HTML class for submit button of form
         * html_class = HTML class for wrapper
         * html_id = HTML id for wrapper
         * placeholder = placeholder text for input search textbox
         * button_text = Search button text
         */

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'text_class' => '',
            'button_class' => '',
            'action' => '',
            'html_class' => 'whmpress whmpress_domain_search_ajax',
            'html_id' => '',
            'placeholder' => 'Search',
            'button_text' => 'Search',
            "whois_link" => "yes",
            "www_link" => "yes",
            "disable_domain_spinning" => whmpress_get_option("dsa_disable_domain_spinning"),
            "order_landing_page" => whmpress_get_option("dsa_order_landing_page"),
            "order_link_new_tab" => whmpress_get_option("dsa_order_link_new_tab"),
            "show_price" => whmpress_get_option("dsa_show_price"),
            "show_years" => whmpress_get_option("dsa_show_years"),
        ], $atts));

        # Generating output form
        $WHMPress = new WHMPress;

        if (strtoupper($order_landing_page) == "YES" || $order_landing_page == "1") {
            $order_landing_page = "1";
        } else {
            $order_landing_page = "0";
        }
        if (strtoupper($order_link_new_tab) == "YES" || $order_link_new_tab == "1") {
            $order_link_new_tab = "1";
        } else {
            $order_link_new_tab = "0";
        }
        if (strtoupper($disable_domain_spinning) == "YES" || $disable_domain_spinning == "1") {
            $disable_domain_spinning = "1";
        } else {
            $disable_domain_spinning = "0";
        }
        if (strtoupper($show_price) == "NO" || $show_price == "0") {
            $show_price = "0";
        } else {
            $show_price = "1";
        }
        if (strtoupper($show_years) == "NO" || $show_years == "0") {
            $show_years = "0";
        } else {
            $show_years = "1";
        }

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_domain_search_extended_ajax");

        if (is_file($html_template)) {
            $search_domain = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";
            $vars = [
                "search_text_box" => '<input required="required" class="' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" value="' . $search_domain . '" type="search" name="search_domain" />',
                "search_button" => '<button class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>',
                "action" => $action,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_domain_search_extended_ajax");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            $ajaxID = uniqid("ajaxForm");
            $ACTION = empty($action) ? "" : "action='$action'";
            $str = "<form $ACTION method='get' id='form{$ajaxID}'";
            if ($action == "") {
                $str .= " onsubmit='return Search{$ajaxID}(this);'";
            }
            $str .= '>' . "\n";
            if ($action == "") {
                foreach ($_GET as $k => $v) {
                    if ($k <> "search_domain") {
                        $str .= "<input type='hidden' name='$k' value=\"$v\" />\n";
                    }
                }
            }
            $str .= '<input type="hidden" name="skip_extra" value="0" />';
            $search_domain = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";
            $str .= '<input required="required" class="' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" value="' . $search_domain . '" type="search" id="search_box" name="search_domain" />' . "\n";
            $str .= '<button class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>' . "\n";
            $str .= "<div class='clear:both'></div>";
            $str .= "</form>\n";

            $str .= "<script>
            jQuery(function(){
                /*jQuery.post(WHMPAjax.ajaxurl, {'domain':jQuery('#search_box').val(),'action':'whmpress_action','do':'getDomainData','skip_extra':'0','searchonly':'{$searchonly}','lang':'" . $the_lang . "'}, function(data){
                    jQuery(\"#search_result_div\").html(data);
                });*/
                jQuery(document).on('click', \"#load-more-div button\", function () {
                    jQuery(\"#load-more-div\").remove();
                    //jQuery(\"#search_result_div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"icon-spinner fa-spin\"></i></div>');
                    jQuery(\".result-div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner\"></i></div>');
                    whmp_page++;
                    jQuery.post(WHMPAjax.ajaxurl, {'domain':jQuery('#search_box').val(),'action':'whmpress_action','do':'loadWhoisPage','skip_extra':'0','page':whmp_page,'searchonly':'{$searchonly}','lang':'" . $the_lang . "'}, function(data){
                        jQuery(\"#waiting_div\").remove();
                        jQuery(\".result-div\").append(data);
                    });
                });
            });
            </script>\n";

            if ($action == "") {
                $str .= "<div id='$ajaxID'>";
                $str .= whmpress_domain_search_extended_ajax_results_function([
                    "searchonly" => "*",
                    'html_class' => 'whmpress whmpress_domain_search_ajax_results',
                    'html_id' => "{$ajaxID}2",
                    'whois_link' => $whois_link,
                    "www_link" => $www_link,
                    "disable_domain_spinning" => $disable_domain_spinning,
                ]);
                $str .= "</div>";
                $str .= "<script>
            function Search{$ajaxID}(form) {
                whmp_page=1;
                jQuery('#{$ajaxID}2').html('<div class=\"whmpress_loading_div\"><i class=\"fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner\"></i> Loading .....</div>');
                jQuery.post(WHMPAjax.ajaxurl,{'show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','domain':jQuery('#form{$ajaxID} input[type=search]').val(),'action':'whmpress_action','do':'getDomainData','www_link':'$www_link','whois_link':'$whois_link','searchonly':'*','skip_extra':'0','page':'1','lang':'" . $the_lang . "'},function(data){
                    jQuery('#{$ajaxID}2').html(data);
                });
                return false;
            }
            </script>";
            }

            # Returning output form
            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            return "<div $CLASS $ID>" . $str . "</div>";
        }
    }
}

if (!function_exists("whmpress_domain_search_ajax_function")) {
    function whmpress_domain_search_ajax_function($atts)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_search_ajax.php");
    }
}

if (!function_exists("whmpress_domain_search_ajax_extended_function")) {
    function whmpress_domain_search_ajax_extended_function($atts)
    {
        ob_start();
        include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_search_ajax_extended.php");
        return ob_get_clean();
    }
}

if (!function_exists("whmpress_domain_search_extended_ajax_results_function")) {
    function whmpress_domain_search_extended_ajax_results_function($atts)
    {
        /**
         * Displays whois search result submitted by whmpress_domain_search_extended_ajax form
         *
         * List of parameters
         * searchonly = * for all domain or get result only for specific extensions comma seperated
         * html_class = HTML class for wrapper
         */

        $params = shortcode_atts([
            'html_template' => '',
            'images' => '',
            'searchonly' => '*',
            'html_class' => 'whmpress whmpress_domain_search_ajax_results',
            'html_id' => '',
        ], $atts);
        extract($params);

        $WHMPress = new WHMPress;

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_domain_search_extended_ajax_results");

        # Instructions: creative a div with ID search_result_div in HTML template file
        if (is_file($html_template)) {
            $vars = [];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_domain_search_extended_ajax_results");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            if (isset($_GET["search_domain"])) {
                $str = '<div id="search_result_div">' . "\n";
                $str .= '<div style="font-size:30px;text-align: center;">' . "\n";
                $str .= '<i class="fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner"></i>' . "\n";
                $str .= "</div>\n";
                $str .= "</div>\n";

                if (isset($_GET["ext"])) {
                    $_GET["search_domain"] .= $_GET["ext"];
                }

                $str .= "<script>
            jQuery(function(){
                /*jQuery.post(WHMPAjax.ajaxurl, {'domain':'{$_GET["search_domain"]}','action':'whmpress_action','do':'getDomainData','skip_extra':'$search_extensions','searchonly':'{$searchonly}','lang':'" . $the_lang . "'}, function(data){
                    jQuery(\"#search_result_div\").html(data);
                });*/
                jQuery(document).on('click', \"#load-more-div button\", function () {
                    jQuery(\"#load-more-div\").remove();
                    //jQuery(\"#search_result_div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"icon-spinner fa-spin\"></i></div>');
                    jQuery(\".result-div\").append('<div id=\"waiting_div\" style=\"font-size:30px;text-align: center;\"><i class=\"fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner\"></i></div>');
                    whmp_page++;
                    jQuery.post(WHMPAjax.ajaxurl, {'params':" . whmpress_json_encode($params) . ",'domain':'{$_GET["search_domain"]}','action':'whmpress_action','do':'loadWhoisPage','skip_extra':'$search_extensions','page':whmp_page,'searchonly':'{$searchonly}','lang':'" . $the_lang . "'}, function(data){
                        jQuery(\"#waiting_div\").remove();
                        jQuery(\".result-div\").append(data);
                    });
                });
            });
            </script>\n";
            } else {
                $str = "";
            }

            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            return "<div $CLASS $ID>" . $str . "</div>";
        }
    }
}

if (!function_exists("whmpress_domain_search_ajax_results_function")) {
    function whmpress_domain_search_ajax_results_function($atts)
    {
        return include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_search_ajax_results.php");
    }
}

if (!function_exists("whmpress_pricing_table_function")) {
    function whmpress_pricing_table_function($atts, $content = null)
    {
        /**
         * Shows pricing table
         *
         * List of parameters
         * html_template = HTML template file path
         * html_class = HTML class for wrapper
         * html_id = HTML id for wrapper
         * id = relid match from whmcs mysql table
         * billingcycle = Billing cycle e.g. annually, monthly etc.
         * show_price = Display price or not.
         * show_combo = Show combo or not, No, Yes
         * show_button = Show submit button or not
         * currency = Currency for price
         */
        $result = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_pricing_table.php");

        return $result;
    }
}

if (!function_exists("whmpress_pricing_table_horizontal_function")) {
    function whmpress_pricing_table_horizontal_function($atts, $content = null)
    {
        $result = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_pricing_table_horizontal.php");

        return $result;
    }
}

if (!function_exists("whmpress_price_box_function")) {
    function whmpress_price_box_function($atts)
    {

    }
}

/**
 * @param $atts
 *
 * @return mixed|null|string|void
 *
 * Shows service description
 * List of parameters
 * html_class = HTML class for wrapper
 * html_id = HTML id for wrapper
 * id = relid match from whmcs mysql table
 * show_as = display result in ul, ol
 */
if (!function_exists("whmpress_description_function")) {
    function whmpress_description_function($atts)
    {
        $OutputString = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_description.php");

        return $OutputString;
    }
}

if (!function_exists("whmpress_description_extended_function")) {
    function whmpress_description_extended_function($atts)
    {
        $OutputString = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_description_extended.php");

        return $OutputString;
    }
}

if (!function_exists("whmpress_cdescription_function")) {
    function whmpress_cdescription_function($atts)
    {
        /**
         * Shows service description
         *
         * List of parameters
         * html_class = HTML class for wrapper
         * html_id = HTML id for wrapper
         * id = relid match from whmcs mysql table
         * show_as = display result in ul, ol
         */

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'html_id' => '',
            'html_class' => 'whmpress whmpress_description',
            'id' => '0',
            'show_as' => whmpress_get_option('dsc_description'),
            "no_wrapper" => "yes",
            "strip_sections" => "yes",
        ], $atts));

        # Getting data from mysql tables
        $WHMPress = new WHMPress;

        $field = "whmpress_product_" . $id . "_custom_desc_" . $WHMPress->get_current_language();
        $ndescription = $description = get_option($field);

        $ndescription = trim(strip_tags($ndescription), "\n");
        $ndescription = explode("\n", $ndescription);

        $smarty_array = [];
        foreach ($ndescription as $line) {
            if (trim($line) <> "") {
                $data = [];
                $data["feature"] = $line;
                $totay = explode(":", $line);
                $data["feature_title"] = trim($totay[0]);
                $data["feature_value"] = isset($totay[1]) ? trim($totay[1]) : "";

                $smarty_array[] = $data;
            }
        }

        $no_wrapper = trim(strtolower($no_wrapper));
        # Checking show_as parameter
        if ($no_wrapper == "yes" || $no_wrapper == "1" || $no_wrapper === true || $no_wrapper == "true") {
            // No wrapper arround description text.
        } else {
            if (strtolower($show_as) == "ul" || strtolower($show_as) == "ol") {
                $description = trim(strip_tags($description), "\n");
                $description = explode("\n", $description);
                $description = "<" . $show_as . ">\n<li>" . implode("</li><li>", $description) . "</li>\n</" . $show_as . ">";
            }
        }

        # Generating output string
        $html_template = $WHMPress->check_template_file($html_template, "whmpress_description");

        if (is_file($html_template)) {
            $vars = [
                "product_description" => $description,
                "data" => $smarty_array,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_description");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            if ($no_wrapper == "yes" || $no_wrapper == "1" || $no_wrapper === true || $no_wrapper == "true") {
                $OutputString = $description;
            } else {
                $OutputString = "<div $CLASS $ID>" . $description . "</div>";
            }

            # Returning output string
            return whmpress_encoding($OutputString);
        }
    }
}

if (!function_exists("whmpress_name_function")) {
    function whmpress_name_function($atts)
    {
        /**
         * Shows service name
         *
         * List of parameters
         * html_class = HTML class for wrapper
         * html_id = HTML id for wrapper
         * id = relid match from whmcs mysql table
         */

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'html_id' => '',
            'html_class' => '',
            'id' => '',
            'no_wrapper' => '',
        ], $atts));

        $WHMPress = new WHMPress;

        global $wpdb;
        if (strtolower(get_option("whmpress_use_package_details_from_whmpress")) == "yes") {
            $name = get_option("whmpress_product_" . $id . "_name_" . $WHMPress->get_current_language());
            if (empty($name)) {
                $Q = "SELECT `name` FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
                $name = $wpdb->get_var($Q);
            }
        } else {
            # Getting data from mysql tables
            $Q = "SELECT `name` FROM `" . whmp_get_products_table_name() . "` WHERE `id`=$id";
            $name = $wpdb->get_var($Q);
        }

        # Generating output string

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_name");

        if (is_file($html_template)) {
            $vars = [
                "product_name" => $name,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_name");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            $ID = !empty($html_id) ? "id='$html_id'" : "";
            $CLASS = !empty($html_class) ? "class='$html_class'" : "";

            $no_wrapper = trim(strtolower($no_wrapper));
            if ($no_wrapper == "yes" || $no_wrapper == "1" || $no_wrapper === true) {
                $OutputString = $name;
            } else {
                $OutputString = "<div $CLASS $ID>" . $name . "</div>";
            }

            # Returning output string
            return whmpress_encoding($OutputString);
        }
    }
}

if (!function_exists("whmpress_price_function")) {
    function whmpress_price_function($atts, $content = null)
    {
        $OutputString = include WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price.php";
        return $OutputString;
    }
}

if (!function_exists("whmpress_price_function_i")) {
    function whmpress_price_function_i($atts, $content = null)
    {
        $OutputString = include WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price_i.php";
        return $OutputString;
    }
}

if (!function_exists("whmpress_order_combo_function")) {
    function whmpress_order_combo_function($atts, $content = null)
    {
        /**
         * Displays price of a WHMCS Service (Hosting Plan) for all billing cycle in dropdown list along with optional order button. Service id is the only required parameters
         *
         * List of parameters
         * decimals = round number of decimals for price/amount
         * id = relid from mysql pricing table
         * currency = provide currency code
         * rows = How many rows for combo and button 1 or 2
         * show_discount = Whether to show discount or not
         * show_button = Show HTML button or not yes or no
         * button_text = HTML button text
         * combo_class = HTML class name for combo
         * button_class = HTML class for button
         * html_id = html id name for wrapper
         * html_class = HTML class name for wrapper
         * discount_type = What discout type required. yearly, monthly, quarterly etc.
         * billingcycles = What columns will display in combo e.g. yearly,monthly,biennially,semiannually,quarterly
         * prefix = show currency prefix, yes for show prefix
         * suffix = show currency suffix, yes for show suffix
         */

        $OutputString = include WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_order_combo.php";

        return $OutputString;
    }
}

if (!function_exists("whmpress_order_button_function")) {
    function whmpress_order_button_function($atts)
    {
        $OutputString = include WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_order_button.php";

        return $OutputString;
    }
}

if (!function_exists("whmpress_order_link_function")) {
    function whmpress_order_link_function($atts)
    {
        /**
         * Displays order link
         *
         * List of parameters
         * link_text = Link text
         * html_class = HTML class for link
         * id = WHMCS product ID from mysql table
         * billingcycle = Billing cycle e.g. annually
         * html_id = HTML id for link
         * currency = Currency ID
         */

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'link_text' => whmpress_get_option("ol_link_text"),
            'html_class' => 'whmpress_order_link',
            'id' => '0',
            'billingcycle' => 'annually',
            'html_id' => '',
            'currency' => '',
        ], $atts));
        $value = $link_text;
        $class = $html_class;
        $currency = whmp_get_currency($currency);

        $WHMPress = new WHMpress();

        # Generating URL.
        $url = $WHMPress->get_whmcs_url("order") . "pid={$id}&a=add&currency={$currency}&billingcycle={$billingcycle}";


        # Generating output string.
        $WHMPress = new WHMPress;

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_order_link");

        if (is_file($html_template)) {

            $vars = [
                "product_order_url" => $url,
                "product_link_text" => $link_text,
                "product_order_link" => "<a href=\"{$url}\">{$link_text}</a>",
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_order_link");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            $str = "<a id='$html_id' class=\"{$class}\" href=\"{$url}\">{$value}</a>";

            # Returning output string
            return $str;
        }
    }
}

if (!function_exists("whmpress_order_url_function")) {
    function whmpress_order_url_function($atts)
    {
        /**
         * Display/Generate order url
         *
         * List of parameters
         * id = WHMCS product ID from mysql table
         * billingcycle = Billing cycle e.g. annually
         * currency = Currency ID
         */
        extract(shortcode_atts([
            'html_template' => '',
            'id' => whmp_get_installation_url(),
            'billingcycle' => 'annually',
            'currency' => '',
        ], $atts));
        $currency = whmp_get_currency($currency);

        $WHMPress = new WHMpress();

        # Generating order url and making output string
        $str = $WHMPress->get_whmcs_url("order") . "&a=add&pid=" . $id . "&currency=" . $currency . "&billingcycle={$billingcycle}";

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_order_url");
        if (is_file($html_template)) {
            $vars = [
                "product_order_url" => $str,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_order_url");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            return $str;
        }

        # Returning output string
    }
}

if (!function_exists("whmpress_currency_function")) {
    function whmpress_currency_function($atts)
    {
        /**
         * Display currency symbol
         *
         * List of attributes/parameters
         * html_id = HTML id for wrapper span
         * html_class = HTML class for wrapper span
         * show = suffix,prefix,code    (default prefix)
         */

        extract(shortcode_atts([
            'html_template' => '',
            'image' => '',
            'html_id' => '',
            'html_class' => 'whmpress_currency',
            'show' => 'prefix',
            'currency' => '',
        ], $atts));

        if (empty($curency)){
            $currency = whmp_get_current_currency_id_i();
        }
        # Getting currency
        $func = "whmp_get_currency_" . strtolower($show);
        $currency = $func($currency);
        /*
        if (!isset($_SESSION["currency"])) {
            $func = "whmp_get_default_currency_".strtolower($show);
            $currency = $func();
        } else {
            $func = "whmp_get_currency_".strtolower($show);
            $currency = $func($_SESSION["currency"]);
        }*/

        # Returning output including wrapper
        $WHMPress = new WHMPress;

        $html_template = $WHMPress->check_template_file($html_template, "whmpress_currency");

        if (is_file($html_template)) {
            $vars = [
                "current_currency" => $currency,
            ];

            # Getting custom fields and adding in output
            $TemplateArray = $WHMPress->get_template_array("whmpress_currency");
            foreach ($TemplateArray as $custom_field) {
                $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
            }

            $OutputString = whmp_smarty_template($html_template, $vars);

            return $OutputString;
        } else {
            return "<span id='$html_id' class='$html_class'>" . $currency . "</span>";
        }
    }
}

if (!function_exists("whmpress_currency_combo_function")) {
    function whmpress_currency_combo_function($atts)
    {
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_currency_combo.php");

        return $html;
    }
}

if (!function_exists("whmpress_currency_combo_fancy_function")) {
    function whmpress_currency_combo_fancy_function()
    {
        if (!session_id()) {
            $cacheValue = get_option('whmpress_session_cache_limiter_value');
            session_cache_limiter($cacheValue);
            session_start();
        }
        if (isset($_SESSION["whcom_currency"])) {
            $currency = $_SESSION["whcom_currency"];
        } else {
            $currency = whmp_get_default_currency_id();
        }

        // Getting currencies
        global $wpdb;
        $Q = "SELECT `id`, `prefix`, `code` FROM `" . whmp_get_currencies_table_name() . "` ORDER BY `id`";
        $rows = $wpdb->get_results($Q, ARRAY_A);
        #print_r ($rows);

        // Adding flag if flag png available in extra folder
        foreach ($rows as &$row) {
            if (is_file(WHMP_PLUGIN_DIR . "/extras/" . $row["code"] . ".png")) {
                $row["flag"] = WHMP_PLUGIN_URL . "/extras/" . $row["code"] . ".png";
            } else {
                $row["flag"] = WHMP_PLUGIN_URL . "/extras/noflag.png";
            }
        }

        // Setting current selected currency
        $topurl = "";
        foreach ($rows as $r) {
            #print_r ($row);
            if ($currency == $r["id"]) {
                $topurl = '<a class="lang_sel_sel icl-en" href="#" onclick="return false;"><img title="' . $r["code"] . ' (' . $r["prefix"] . ')" alt="en" src="' . $r["flag"] . '" class="iclflag">&nbsp;<span class="icl_lang_sel_current">' . $r["code"] . ' (' . $r["prefix"] . ')</span></a>';
                #break;
            }
        }

        $func_name = uniqid('func_');
        $str = '
    <div id="lang_sel">
        <ul>
            <li>
                ' . $topurl . '
                <ul>';
        foreach ($rows as $row1) {
            $str .= "<li class=\"icl-pl\"><a href=\"#\" onclick=\"return " . $func_name . "(" . $row1["id"] . ");\" hreflang=\"pkr\" rel=\"alternate\"><img title=\"{$row1["code"]}\" alt=\"{$row1["code"]}\" src=\"" . $row1["flag"] . "\" class=\"iclflag\">&nbsp; <span class=\"icl_lang_sel_native\">{$row1["code"]} ({$row1["prefix"]})</span> <span class=\"icl_lang_sel_translated\"><span class=\"icl_lang_sel_native\">(</span>{$row["code"]}<span class=\"icl_lang_sel_native\">)</span></span></a></li>\n";
        }
        $str .= '</ul>
            </li>
        </ul>
    </div>
    
    <script>
        function ' . $func_name . '(cur) {
            jQuery.post(WHMPAjax.ajaxurl + "?setCurrency",{curency:cur,action:"whmpress_action"},function(data){
                if (data=="OK") window.location.reload();
                else alert(data);
            });
            return false;
        }
    </script>
    ';

        return $str;
    }
}

if (!function_exists("whmpress_domain_search_function")) {
    function whmpress_domain_search_function($atts)
    {

        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_domain_search.php");

        return $html;

    }
}

if (!function_exists("whmpress_price_table_domain_function")) {
    function whmpress_price_table_domain_function($atts = "")
    {
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price_table_domain.php");

        return $html;
    }
}

if (!function_exists("whmpress_price_domain_list_function")) {
    function whmpress_price_domain_list_function($atts = "")
    {
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price_domain_list.php");

        return $html;
    }
}

if (!function_exists("whmpress_price_table_function")) {
    function whmpress_price_table_function($atts)
    {
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price_table.php");

        return $html;
    }
}

if (!function_exists("whmpress_price_table_extended_function")) {
    function whmpress_price_table_extended_function($atts)
    {
        $html = include(WHMP_PLUGIN_DIR . "/includes/shortcodes/whmpress_price_table_extended.php");

        return $html;
    }
}