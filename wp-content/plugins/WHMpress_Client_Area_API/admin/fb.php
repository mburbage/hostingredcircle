<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/20/2019
 * Time: 10:54 AM
 */

add_action('fusion_builder_before_init', 'WCAP_integrateWithFB');
function WCAP_integrateWithFB(){
    $shorcodes = [
        "whmcs_client_area",
        "wcap_logged_in_content",
        "wcap_logged_out_content",
        "wcap_whmcs_nav_menu",
        "wcap_login_form",
    ];

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
        $atts = array(
            "name" => $vc_shortcode_title,
            "shortcode" => $SHORTCODES,
            'preview_id' => 'fusion-builder-block-module-text-preview-template',
            'allow_generator' => true,
            "params" => $params,
        );

        fusion_builder_map($atts);
    }
}