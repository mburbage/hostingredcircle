<?php



$last_synced = get_option("sync_time");
$site_url = get_site_url();
if ($last_synced == "") {
    echo "<div style='color: red;' '>WHMCS is not yet synced</div>";
    echo "<div><a href='$site_url/wp-admin/admin.php?page=whmp-sync'>Click here to Sync</a></div>";
}


/**
 * Created by PhpStorm.
 * User: fokado
 * Date: 12/30/2017
 * Time: 3:51 PM
 */

/**
 * Generates HTML form for search domains
 *
 * List of parameters
 * show_tlds = provide comma seperated tlds e.g. .com,.net,.org or leave it blank for all tlds
 * show_tlds_wildcard = provide tld search as wildcard, e.g. pk for all .pk domains or co for all com and .co domains
 * show_combo = Yes or No for display or hide combo box of tlds
 * placeholder = HTML placeholder for input search box
 * text_class = HTML class for wrapper of input search box
 * combo_class = HTML class for wrapper of combo box
 * button_class = HTML class for wrapper of submit button of form
 * action = Specify url where form will submit
 * button_text = Button text for submit button
 * html_class = HTML class for wrapper of form
 * html_id = HTML id for wrapper of form
 */

$WHMPress = new WHMpress();

$params = shortcode_atts([
    'html_template' => '',
    'image' => '',
    'show_tlds' => '',
    'show_tlds_wildcard' => '',
    'show_combo' => whmpress_get_option('ds_show_combo'), //'no',
    'show_country_combo' => whmpress_get_option('ds_show_country_combo'), //'no',
    'placeholder' => whmpress_get_option('ds_placeholder'),
    'text_class' => 'search_div',
    'combo_class' => 'select_div',
    'button_class' => 'submit_div',
    'action' => $WHMPress->get_whmcs_url("domainchecker"),
    'button_text' => whmpress_get_option('ds_button_text'), //'Search',
    'html_class' => 'whmpress whmpress_domain_search',
    'html_id' => '',
    'token' => '',
    'combo_country_class' => 'select_div',
], $atts);
extract($params);

# Getting WordPress DB object
global $wpdb;

# Generating and setting combo box if it will display
if (strtolower($show_combo) == "yes"):
    $Q = "SELECT `extension` FROM `" . whmp_get_domain_pricing_table_name() . "` WHERE 1";
    if ($show_tlds <> "") {
        $show_tlds = explode(",", $show_tlds);
        $Q .= " AND (`extension`='" . implode("' OR `extension`='", $show_tlds) . "')";
    } elseif ($show_tlds_wildcard <> "") {
        $Q .= " AND `extension` LIKE '%{$show_tlds_wildcard}%'";
    }
    $Q .= " ORDER BY `extension`";
    $rows = $wpdb->get_results($Q, ARRAY_A);
    if ($show_tlds <> "") {
        $tmps = $rows;
        $rows = array();
        foreach ($show_tlds as $show_tld) {
            foreach ($tmps as $tmp) {
                if ($tmp['extension'] == $show_tld) {
                    $rows[] = $tmp;
                }
            }
        }
    }
endif;

# Generating and setting combo box with country
if (strtolower($show_country_combo) == "yes"):
    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
endif;

# Generating output string
$ACTION = empty($action) ? "" : "action='$action'";
$str = "<form method=\"get\" id=\"searchDomainForm\" $ACTION>";
$params = parse_url($action);
if (!isset($params["query"])) {
    $params["query"] = "";
}
if ($params["query"] <> "") {
    parse_str($params["query"], $params);
    foreach ($params as $key => $val) {
        $str .= "<input type=\"hidden\" value=\"{$val}\" name=\"{$key}\">";
    }
}
if ($token != "") {
    $str .= "<input type=\"hidden\" name=\"token\" value=\"{$token}\">";
}
$str .= "<!--input type=\"hidden\" name=\"token\" value=\"24372f4f06ca835d9101d60a258c30a4c93b3bf7\">
    <input type=\"hidden\" name=\"direct\" value=\"true\"-->";
$str .= "<div class=\"{$text_class} search_div\">";
$val = isset($_GET["search_domain"]) ? $_GET["search_domain"] : "";
$str .= "<input required='required' title='" . __("Please fill out this field", "whmpress") . "' type=\"search\" name=\"sld\" id=\"search_domain\" placeholder=\"" . __($placeholder, "whmpress") . "\" value=\"{$val}\" />\n";
$str .= "</div>";

$WHMPress = new WHMPress;
$html_template = $WHMPress->check_template_file($html_template, "whmpress_domain_search");

$smarty_array = [];
$smarty_array["params"] = $params;
$smarty_array["params_encoded"] = whmpress_json_encode($params);
$smarty_array["class"] = $combo_class;
$smarty_array["rows"] = [];
if (strtolower($show_combo) == "yes") {
    $smarty_array["rows"] = $rows;
    $Combo = "<div class=\"{$combo_class} select_div\">";

    $Combo .= "<select name='tld'>";
    foreach ($rows as $row) {
        $Combo .= "<option>" . $row["extension"] . "</option>\n";
    }
    $Combo .= "</select>";
    $Combo .= "</div>";
    if (!is_file($html_template)) {
        $str .= $Combo;
    }
} else {
    $str .= "<input type='hidden' name='ext' value='' />\n";
    $Combo = "";
}
$str .= "<div class=\"{$button_class} submit_div\">";
$str .= "<input type=\"submit\" value=\"{$button_text}\">";
$str .= "</div>";
$str .= "</form>";


if (is_file($html_template)) {
    $vars = [
        "search_text_box" => "<input required='required' type=\"search\" name=\"domain\" id=\"search_domain\" placeholder=\"" . __($placeholder, "whmpress") . "\" value=\"{$val}\" />",
        "search_combo" => $Combo,
        "search_button" => "<input type=\"submit\" value=\"{$button_text}\">",
        "action_url" => $action,
        "combo_data" => $smarty_array,
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_domain_search");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;
} else {

    # Returning output string including wrapper div
    $ID = !empty($html_id) ? "id='$html_id'" : "";
    $CLASS = !empty($html_class) ? "class='$html_class'" : "";

    return "<div $CLASS $ID>" . $str . "</div>";
}
