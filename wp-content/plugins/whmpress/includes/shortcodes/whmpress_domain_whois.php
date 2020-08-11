<?php
/**
 * Displays a form for getting whois info of multiple line provided domains
 *
 * List of parameters
 * text_class = HTML class for input search text box
 * button_class = HTML class for submit button of form
 * html_class = HTML class for wrapper
 * html_id = HTML id for wrapper
 * placeholder = placeholder text for input search textbox
 * button_text = Search button text
 * result_text = HTML class for output result
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
    'text_class' => '',
    'button_class' => '',
    'html_class' => 'whmpress whmpress_domain_whois',
    'html_id' => '',
    'placeholder' => whmpress_get_option('dw_placeholder'),
    'button_text' => whmpress_get_option('dw_button_text'), //'Get Whois',
    'result_text_class' => '',
    'action'        => ''
], $atts));

$action = str_replace('{wp-path}', get_home_url(), $action);

# Generating output result
if (isset($_POST["whois_domain"])) {
    include_once(WHMP_PLUGIN_DIR . "/includes/whois.class.php");
    $whois = new Whois;
    $given_domain = $_POST["whois_domain"];

    $d_whois = whmp_get_domain_clean($given_domain);
    $tld = strstr($d_whois["host"], '.');

    $result = "<div class='whmpress_whois_results'><pre class='$result_text_class'>"
        . $whois->whoislookup($d_whois["host"], $tld, true)
        . "</pre></div>";
} else {
    $result = __("No domain selected", "whmpress");
}

$WHMPress = new WHMPress;

$html_template = $WHMPress->check_template_file($html_template, "whmpress_domain_whois");

if (is_file($html_template)) {
    $whois_domain = isset($_POST["whois_domain"]) ? $_POST["whois_domain"] : "";
    $vars = [
        "search_text_box" => '<input required="required" class="' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" name="whois_domain" value="' . $whois_domain . '">',
        "search_button" => '<button class="search_btn ' . $button_class . '">' . __($button_text, "whmpress") . '</button>',
        "whois_output" => $result,
    ];

    # Getting custom fields and adding in output
    $TemplateArray = $WHMPress->get_template_array("whmpress_domain_whois");
    foreach ($TemplateArray as $custom_field) {
        $vars[$custom_field] = isset($atts[$custom_field]) ? $atts[$custom_field] : "";
    }

    $OutputString = whmp_smarty_template($html_template, $vars);

    return $OutputString;
} else {
    $str = "<form action='$action' method='post'>" . "\n";
    $whois_domain = isset($_POST["whois_domain"]) ? $_POST["whois_domain"] : "";
    $str .= '<input required="required" class="search-input ' . $text_class . '" placeholder="' . __($placeholder, "whmpress") . '" name="whois_domain" value="' . $whois_domain . '">' . "\n";
    $str .= '<button class="search_btn ' . $button_class . '">' . $button_text . '</button>' . "\n";
    $str .= "</form>\n";

    $ID = !empty($html_id) ? "id='$html_id'" : "";
    $CLASS = !empty($html_class) ? "class='$html_class'" : "";

    return "<div $CLASS $ID>" . $str . $result . "</div>";
}


?>