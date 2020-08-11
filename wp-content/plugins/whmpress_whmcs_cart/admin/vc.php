<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/19/2019
 * Time: 4:53 PM
 */

add_action('vc_before_init', 'WCOP_integrateWithVC');
function WCOP_integrateWithVC()
{
    $shortcodes = [
        'whmpress_store',
        'whmpress_cart_config_product',
        'whmpress_cart_single_page',
//        'whmpress_cart_domain_first',
    ];
    $icon = WCOP_ADMIN_URL . "/images/logo32.png";

    $YesNo["Default"] = "";
    $YesNo["Yes"] = "yes";
    $YesNo["No"] = "no";

    $NoYes["Default"] = "";
    $NoYes["No"] = "no";
    $NoYes["Yes"] = "yes";

    $templates = get_singlePageTemplates_list();

    foreach ($shortcodes as $SHORTCODES) {

        $shortcodeParams = get_shortcode_parameters_wcop($SHORTCODES);
        $params = [];

        foreach ($shortcodeParams as $key => $spm) {
            $array = [];
            if (isset($spm["vc_type"]) && $spm["vc_type"] == "label") {
                continue;
            }

            if (is_array($spm)) {
                $params_name = $key;
            } else {
                $params_name = $spm;
            }

            if (is_array($spm)) {
                if (!isset($spm["type"])) {
                    $spm["type"] = "textbox";
                }
                if ($key == "vc_options") {
                    //NOTE:this is being added to avoid duplicate shortcode that occurs with @refrence for announcement
                    // when $_TITLE veriable is used
                    $vc_shortcode_title = $spm["title"];
                    $_TITLE = @$spm["title"];
                } else {
                    $show = true;

                    if (!isset($spm["vc_type"])) {
                        $spm["vc_type"] = "textfield";
                    }
                    if ($show && isset($spm["vc_type"])) {
                        if ($spm["vc_type"] == "wcop_icon") {
                            $array["param_name"] = $params_name;
                            $array["type"] = "wcop_icon";
                            $array["value"] = @$spm["value"];
                        } elseif ($spm["vc_type"] == "noyes") {
                            $array["type"] = "dropdown";
                            $array["value"] = $NoYes;
                        } elseif ($spm["vc_type"] == "checkbox") {
                            $array["type"] = "checkbox";
                            if (isset($spm["value"])) {
                                $array["value"] = $spm["value"];
                            }
                        } elseif ($spm["vc_type"] == "yesno") {
                            $array["type"] = "dropdown";
                            $array["value"] = $YesNo;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "style"){
                            $array["type"] = "dropdown";
                            $array["value"] = $templates;
                            $array["std"] = '0';
                        } else {
                            $array["type"] = $spm["vc_type"];
                            if ($array["type"] == "") {
                                $array["type"] = "textfield";
                            } else {
                                $array["value"] = @$spm["value"];
                            }
                        }

                        $array["heading"] = @$spm["heading"];
                        if ($array["heading"] == "") {
                            $array["heading"] = ucwords(str_replace("_", " ", $key));
                        }

                        $array["param_name"] = $key;
                        if (isset($spm["description"])) {
                            $array["description"] = $spm["description"];
                        }

                        // If admin_label is provided then it will pass to vc_map.
                        if (isset($spm["admin_label"])) {
                            $array["admin_label"] = $spm["admin_label"];
                        }

                        if (isset($spm["group"])) {
                            $array["group"] = $spm["group"];
                        }

//                        if (isset($spm["dependency"])) {
//                            $array["dependency"] = $spm["dependency"];
//                        }

                        if (isset($spm["weight"])) {
                            $array["weight"] = $spm["weight"];
                        }
                    }

                }
            } else {
                $array["type"] = "textbox";
                $array["heading"] = ucwords(str_replace("_", " ", $spm));
                $array["param_name"] = $spm;
                $array["value"] = "";
            }
            if (!isset($array["type"])) {
                $array["type"] = "textbox";
            }

            if (sizeof($array) > 0 && isset($array["heading"])) {
                $params[] = $array;
            }
        }

        $args = array(
            "name" => $vc_shortcode_title,
            "description" => "", // will get from array
            "base" => $SHORTCODES, //'vc_row', //$shortcode,
            "category" => "WCOP",
            "icon" => $icon,
            "params" => $params,
        );

        vc_map($args);
    }
}