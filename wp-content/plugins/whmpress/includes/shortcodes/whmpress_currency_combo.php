<?php
/**
 * Generate a currency combo and will change currency for prices
 *
 * List of parameters
 * combo_name = HTML name for combo
 * combo_class = HTML class for combo
 * prefix = Display or not prefix with currency, e.g. $
 * html_id = HTML id for wrapper of combo
 * html_class = HTML class for wrapper of combo
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
    'combo_name' => '',
    'combo_class' => '',
    'prefix' => 'yes',
    'html_id' => '',
    'html_class' => 'whmpress whmpress_currency_combo',
    'append_type' => 'numeric'
], $atts));
$name = $combo_name;
$class = $combo_class;

# Getting WordPress DB object
global $wpdb;

# Checking currency
if (!session_id()) {
    $cacheValue = get_option('whmpress_session_cache_limiter_value');
    session_cache_limiter($cacheValue);
    session_start();
}

/*$CSC = whmp_tf(get_option("whmpress_auto_change_currency_according_to_country"));



if ($CSC) {
    //get current user country
    $country_code = whmp_ip_to_country();
    $currency = whmp_country_to_currency($country_code);

}
elseif (isset($_SESSION["whcom_current_currency_id"]) && $_SESSION["whcom_current_currency_id"] != '') {
    $currency = $_SESSION["whcom_current_currency_id"];
} else {
    $currency = whmp_get_default_currency_id();
}
if(isset($_GET['cur']))
{
    $currency = $_SESSION["whcom_current_currency_id"];
}*/

$currency = whmp_get_current_currency_id_i();

/*if (isset($_SESSION["whcom_current_currency_id"])) {
    $currency = $_SESSION["whcom_currency"];
    $currency = $_SESSION["whcom_current_currency_id"];
} else {
    $currency = whmp_get_default_currency_id();
}*/

# getting ajax url which will change currency in session
#$ajaxFile = WHMP_PLUGIN_URL."/includes/set_currency.php";

# Generating random HTML id for combo
$myID = "S" . rand();

# Generating Output HTML
$js_code = "
    <script>
        jQuery(function(){
        jQuery(\"#{$myID}\").change(function(){
        document.cookie='combo_hit=1';
            val = jQuery(this).val();
        console.log(val);
            jQuery.post(WHMPAjax.ajaxurl + '?setCurrency',{'curency': val,'action':'whmpress_action'},function(data){
                if (data=='OK')
                    if (val == '2' || val == 'USD'){
                        var currentURL = window.location.href ;
                        location.href = currentURL.substring(0, currentURL.indexOf('?'));
                    }else{
                      location.href += '?cur=' + val;
                    }
                else
                    alert(data);
            });
        });
    });
    </script>
    ";

//$js_code = "
//    <script>
//        jQuery(function(){
//        jQuery(\"#{$myID}\").change(function(){
//            val = jQuery(this).val();
//        console.log(val);
//            jQuery.post(WHMPAjax.ajaxurl + '?setCurrency',{'curency': val,'action':'whmpress_action'},function(data){
//                if (data=='OK')
//                    window.location.reload();
//
//                else
//                    alert(data);
//            });
//        });
//    });
//    </script>
//    ";

$combo_hit = isset($_COOKIE['combo_hit'])?$_COOKIE['combo_hit']:"";
$_SESSION['combo_hit_rate'] = isset($combo_hit) ? $combo_hit : "";

$str = $js_code;
$str .= "<select id='$myID'";
$str .= ' class="' . $class . '"';
$str .= ' name="' . $name . '"';
$str .= ">\n";



$C = $currency;
$Q = "SELECT `id`, `prefix`, `code` FROM `" . whmp_get_currencies_table_name() . "` ORDER BY `id`";
$rows = $wpdb->get_results($Q);
$smarty_array = [];
$default_id = whmp_get_default_currency_id();

foreach ($rows as $row) {
    $data = [];
    $S = $C == $row->id ? "selected=selected" : "";
    if ($append_type == 'numeric') {
        $str .= "<option $S value='{$row->id}'>{$row->code}";
    } elseif ($append_type == 'descriptive') {
        $str .= "<option $S value='{$row->code}'>{$row->code}";
    }
    /*if (strtolower($prefix) == "yes") {
        $str .= " ({$row->prefix})";
    }*/
    $str .= "</option>";

    $data["prefix"] = $row->prefix;
    $data["code"] = $row->code;
    $data["id"] = $row->id;
    if ($C == $row->id) {
        $data["selected"] = "1";

        $selected = $data;

    } else {
        $data["selected"] = "0";
    }

    if ($row->id == $default_id) {
        $data["default"] = "1";
    } else {
        $data["default"] = "0";
    }

    $smarty_array[] = $data;
}

$str .= "</select>";

# Generating output string
$WHMPress = new WHMPress;

# Returning combo output string including wrapper div
//$decimal_sperator = get_option( 'decimal_replacement', "." );
$decimal_sperator = $WHMPress->get_currency_decimal_separator($currency);

$html_template = $WHMPress->check_template_file($html_template, "whmpress_currency_combo");

if (is_file($html_template)) {

    $OutputString = $WHMPress->read_local_file($html_template);
    $vars = [
        "currency_combo" => $str,
        "js_code" => $js_code,
        "data" => $smarty_array,
        "unique_id" => $myID,
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_currency_combo");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;
} else {
    return "<div id='$html_id' class='$html_class'>" . $str . "</div>";
}
