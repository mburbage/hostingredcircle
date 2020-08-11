<?php
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

if (get_option('include_fontawesome') == "1") {
        wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
    }


$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}

$params = shortcode_atts([
    'html_template' => '',
    'image' => '',
    'text_class' => '',
    'button_class' => '',
    'action' => '',
    'style' => '',
    'html_class' => 'whmpress whmpress_domain_search_ajax',
    'html_id' => '',
    'placeholder' => whmpress_get_option("dsa_placeholder"),  // "Search"
    'button_text' => whmpress_get_option("dsa_button_text"), //'Search',
    "whois_link" => whmpress_get_option("dsa_whois_link"), //"yes",
    "www_link" => whmpress_get_option("dsa_www_link"), //"yes",
    "disable_domain_spinning" => whmpress_get_option("dsa_disable_domain_spinning"), //"0",
    "order_landing_page" => whmpress_get_option("dsa_order_landing_page"), //"0",
    "order_link_new_tab" => whmpress_get_option("dsa_order_link_new_tab"), //"0",
    "show_price" => whmpress_get_option("dsa_show_price"),
    "show_years" => whmpress_get_option("dsa_show_years"),
    "search_extensions" => whmpress_get_option("dsa_search_extensions"),
    "enable_transfer_link" => whmpress_get_option("dsa_transfer_link"),
    "append_url" => ''
], $atts);
extract($params);

// replacing {wp-path} placeholder with website's homepage url
$action = str_replace('{wp-path}', get_home_url(), $action);
# Generating output form
$WHMPress = new WHMPress;
if ($order_landing_page == "Go direct to domain settings" || strtoupper($order_landing_page) == "YES" || $order_landing_page == "1") {
    $order_landing_page = "1";
} else {
    $order_landing_page = "0";
}

if (strtolower($order_link_new_tab) == "yes" || strtolower($order_link_new_tab) == "1") {
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

$html_template = $WHMPress->check_template_file($html_template, "whmpress_domain_search_ajax");
global $wpdb;
$extensions = $wpdb->get_results("SELECT `extension` FROM `" . whmp_get_domain_pricing_table_name() . "` ORDER BY `order`");

$smarty_extensions = [];

foreach ($extensions as $ext) {
    $smarty_extensions[] = $ext->extension;
}

$ajaxID = uniqid("ajaxForm");
$ACTION = empty($action) ? "" : "action='$action'";
if (substr($action, 0, 1) == "#") {
    $htmlID = $action;
} else {
    $htmlID = "#{$ajaxID}2";
}

$loading_text = __("Loading", "whmpress");
$the_lang = "";

$javascript_function = "
function Search{$ajaxID}(form) {
            whmp_page=1;
            jQuery('$htmlID').html(\"<div class='whmp_loading_div'><i class='fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner'></i> $loading_text</div>\");
            
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"action\" value=\"whmpress_action\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"params\" value=\"" . whmpress_json_encode($params) . "\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"show_price\" value=\"$show_price\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"show_years\" value=\"$show_years\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"whmpress_json_encode\" value=\"$order_landing_page\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"order_link_new_tab\" value=\"$order_link_new_tab\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"disable_domain_spinning\" value=\"$disable_domain_spinning\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"do\" value=\"getDomainData\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"www_link\" value=\"$www_link\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"whois_link\" value=\"$whois_link\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"enable_transfer_link\" value=\"$enable_transfer_link\" />');
            
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"append_url\" value=\"$append_url\" />');

            //jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"skip_extra\" value=\"$search_extensions\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"page\" value=\"1\" />');
            jQuery('#form{$ajaxID}').prepend('<input type=\"hidden\" name=\"lang\" value=\"$the_lang\" />');
            k = jQuery('#form{$ajaxID}').serialize();
           
            //jQuery.post(WHMPAjax.ajaxurl,{'params':" . whmpress_json_encode($params) . ",'style':'$style','show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','action':'whmpress_action','do':'getDomainData','www_link':'$www_link','whois_link':'$whois_link','enable_transfer_link':'$enable_transfer_link','searchonly':'*','skip_extra':'$search_extensions','page':'1','lang':'" . $the_lang . "',k},function(data){
            jQuery.post(WHMPAjax.ajaxurl, k, function(data){
                jQuery('{$htmlID}').html(data);
            });
            return false;
        }";


if (is_file($html_template)) {
    $search_domain = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";
    $vars = [
        "search_text_box" => '<input required="required" class="' . $text_class . '" placeholder="' . $placeholder . '" value="' . $search_domain . '" type="search" name="search_domain" />',
        "search_button" => '<button class="search_btn ' . $button_class . '">' . $button_text . '</button>',
        //"params" => $params,
        "params_encoded" => whmpress_json_encode($params, JSON_UNESCAPED_UNICODE),
        "extensions" => $smarty_extensions,
        "ajax_id" => $ajaxID,
        "action" => $ACTION,
        "html_id" => substr($htmlID, 1),
        "js_function" => $javascript_function
    ];


    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_domain_search_ajax");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;

} else {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
    if ($style == 'cart_df_1' && is_active_cop()) {
        $str = '';
        $str .= '<div class="wcop_df_domain_search wcop_df_page">';
        $str .= '<div class="wcop_df_page_header">';
        $str .= '<div class="wcop_df_page_header_content">';
        $str .= '<div class="whcom_row">';
        $str .= '<div class="whcom_col_sm_3">';
        $str .= '<span class="wcop_df_page_header_step">';
        $str .= '<span class="wcop_df_page_header_step_icon">';
        $str .= '<i class="whcom_icon_user-2"></i>';
        $str .= '</span>';
        $str .= '<span class="wcop_df_page_header_step_text">';
        $str .= esc_html__('Step', 'wcop') . '<sup>1</sup><br>' . esc_html__('Search', 'wcop');
        $str .= '</span>';
        $str .= '</span>';
        $str .= '</div>';
        $str .= '<div class="whcom_col_sm_6 whcom_text_center_xs">';
        $str .= esc_html__('Search for your dream domain below', 'wcop');
        $str .= '</div>';
        $str .= '<div class="whcom_col_sm_3"></div>';
        $str .= '</div>';
        $str .= '</div>';
        $str .= '</div>';


        $str .= '<div class="wcop_df_domain_search_form wcop_df_page_header_2">';
        $str .= '<div class="wcop_df_domain_search_form_kangaroo"></div>';

        $str .= "<form $ACTION method='get' id='form{$ajaxID}'";
        if ($action == "" || substr($action, 0, 1) == "#") {
            $str .= " onsubmit='return Search{$ajaxID}(this);'";
        }
        $str .= '>' . "\n";
        if ($action == "" || substr($action, 0, 1) == "#") {
            foreach ($_GET as $k => $v) {
                if ($k <> "search_domain") {
                    $str .= "<input type='hidden' name='$k' value=\"$v\" />\n";
                }
            }
        }

        $str .= '<input type="hidden" name="skip_extra" value="' . $search_extensions . '" />';
        $search_domain = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";
        $str .= '<label for="search_box">' . esc_html__('Search Domain', 'wcop') . '</label>';
        $str .= '<div class="wcop_df_domain_search_form_input">';
        $str .= '<input required="required" class="' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" value="' . $search_domain . '" type="search" id="search_box" name="search_domain" />' . "\n";
        $str .= '<button type="submit" class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>' . "\n";
        $str .= "</div>";
        $str .= "</form>\n";
        $str .= '</div>';


        if ($action == "" || substr($action, 0, 1) == "#") {
            $str .= "<div id='$ajaxID'> <!-- Before -->";

            $str .= whmpress_domain_search_ajax_results_function([
                'html_template' => '',
                'image' => '',
                'searchonly' => '*',
                'html_class' => '',
                'style' => $style,
                'html_id' => "{$ajaxID}2",
                "whois_link" => $whois_link,
                "www_link" => $www_link,
                "disable_domain_spinning" => $disable_domain_spinning,
                "order_landing_page" => $order_landing_page,
                "order_link_new_tab" => $order_link_new_tab,
                "show_years" => $show_years,
                "show_price" => $show_price,
                "search_extensions" => $search_extensions,
                "enable_transfer_link" => $enable_transfer_link,
                "append_url" => $append_url,
                "target_div" => "$htmlID",
                //"append_url"=>$append_url
            ]);

            $str .= "</div>";

            $str .= "
            <!-- Before -->
            <script>";

            if (!empty($_GET['search_domain'])) {
                $str .= "
            jQuery(function(){
                jQuery('#form{$ajaxID}').submit();
            });";
            }

            $str .= "
        function Search{$ajaxID}(form) {
            whmp_page=1;
            jQuery('$htmlID').html(\"<div class='whmp_loading_div'><i class='fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner'></i> $loading_text</div>\");
            jQuery.post(WHMPAjax.ajaxurl,{'params':" . whmpress_json_encode($params) . ",'style':'$style','show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','domain':jQuery('#form{$ajaxID} input[type=search]').val(),'action':'whmpress_action','do':'getDomainData','www_link':'$www_link','whois_link':'$whois_link','enable_transfer_link':'$enable_transfer_link','searchonly':'*','skip_extra':'$search_extensions','page':'1','lang':'" . $the_lang . "'},function(data){
                jQuery('{$htmlID}').html(data);
            });
            return false;
        }
        </script>";
        }

        $str .= '</div>';
        $str .= '';
        $str .= '';

        # Returning output form
        $ID = 'id="wcop_df_container"';
        $CLASS = 'class="wcop_df_container wcop_main wcop_df_style1 whcom_main"';
    } else {
        $str = "<form $ACTION method='get' id='form{$ajaxID}'";
        if ($action == "" || substr($action, 0, 1) == "#") {
            $str .= " onsubmit='return Search{$ajaxID}(this);'";
        }
        $str .= '>' . "\n";
        if ($action == "" || substr($action, 0, 1) == "#") {
            foreach ($_GET as $k => $v) {
                if ($k <> "search_domain") {
                    $str .= "<input type='hidden' name='$k' value=\"$v\" />\n";
                }
            }
        }

        $str .= '<input type="hidden" name="skip_extra" value="' . $search_extensions . '" />';
        $search_domain = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";

        //$str .= '<input type="hidden" name="search_domain" value="'.$search_domain.'" />';
        //$str .= '<input type="hidden" name="params" value='.json_encode($params).'>';
        //$str .= '<input type="hidden" name="order_landing_page" value="'.$order_landing_page.'" />';
        //$str .= '<input type="hidden" name="order_link_new_tab" value="'.$order_link_new_tab.'" />';
        //$str .= '<input type="hidden" name="show_price" value="'.$show_price.'" />';
        //$str .= '<input type="hidden" name="show_years" value="'.$show_years.'" />';
        $str .= '<input required="required" class="' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" value="' . $search_domain . '" type="search" id="search_box" name="search_domain" />' . "\n";
        $str .= '<button class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>' . "\n";
        $str .= "<div class='clear:both'></div>";
        $str .= "</form>\n";
        if ($action == "" || substr($action, 0, 1) == "#") {
            $str .= "<div id='$ajaxID'> <!-- Before -->";

            $str .= whmpress_domain_search_ajax_results_function([
                'html_template' => '',
                'image' => '',
                'searchonly' => '*',
                'html_class' => 'whmpress whmpress_domain_search_ajax_results',
                'html_id' => "{$ajaxID}2",
                "whois_link" => $whois_link,
                "www_link" => $www_link,
                "disable_domain_spinning" => $disable_domain_spinning,
                "order_landing_page" => $order_landing_page,
                "order_link_new_tab" => $order_link_new_tab,
                "show_years" => $show_years,
                "show_price" => $show_price,
                "search_extensions" => $search_extensions,
                "enable_transfer_link" => $enable_transfer_link,
                "append_url" => $append_url,
                "target_div" => "$htmlID",
                //"append_url"=>$append_url
            ]);

            $str .= "</div>";

            $str .= "
            <!-- Before -->
            <script>";

            if (!empty($_GET['search_domain'])) {
                $str .= "
            jQuery(function(){
                jQuery('#form{$ajaxID}').submit();
            });";
            }

            $str .= "
        function Search{$ajaxID}(form) {
            whmp_page=1;
            jQuery('$htmlID').html(\"<div class='whmp_loading_div'><i class='fa fa-spinner fa-spin whmp_domain_search_ajax_results_spinner'></i> $loading_text</div>\");
            jQuery.post(WHMPAjax.ajaxurl,{'params':" . whmpress_json_encode($params) . ",'show_price':'$show_price','show_years':'$show_years','order_landing_page':'$order_landing_page','order_link_new_tab':'$order_link_new_tab','disable_domain_spinning':'$disable_domain_spinning','domain':jQuery('#form{$ajaxID} input[type=search]').val(),'action':'whmpress_action','do':'getDomainData','www_link':'$www_link','whois_link':'$whois_link','enable_transfer_link':'$enable_transfer_link','searchonly':'*','skip_extra':'$search_extensions','page':'1','lang':'" . $the_lang . "'},function(data){
                jQuery('{$htmlID}').html(data);
            });
            return false;
        }
        </script>";
        }

        # Returning output form
        $ID = !empty($html_id) ? "id='$html_id'" : "";
        $CLASS = !empty($html_class) ? "class='$html_class'" : "";
    }

    return "<div $CLASS $ID>" . $str . "</div>";

}