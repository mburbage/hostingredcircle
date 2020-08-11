<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/19/2019
 * Time: 12:34 PM
 */

add_action('vc_before_init', 'WCAP_integrateWithVC');
function WCAP_integrateWithVC()
{
    $shorcodes = [
        "whmcs_client_area",
        "wcap_logged_in_content",
        "wcap_logged_out_content",
        "wcap_whmcs_nav_menu",
        "wcap_login_form",
    ];
    $icon = WCAP_ADMIN_URL . "/assets/images/logo32.png";


    foreach ($shorcodes as $SHORTCODES) {

        $shortcodeParams = get_shortcode_parameters($SHORTCODES);
        $params = [];

        foreach ($shortcodeParams as $key => $spm) {

            if (is_array($spm)) {

                if ($key == "vc_options") {
                    $vc_shortcode_title = $spm["title"];
                }

                if ($key == "params") {
                    $params = $spm;
                }
            }
        }
        $args = array(
            "name" => $vc_shortcode_title,
            "description" => "", // will get from array
            "base" => $SHORTCODES, //'vc_row', //$shortcode,
            "category" => "WCAP",
            "icon" => $icon,
            "params" => $params,
        );

        vc_map($args);
    }

}