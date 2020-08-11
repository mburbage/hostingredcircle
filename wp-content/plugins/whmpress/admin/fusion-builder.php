<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 12/15/2018
 * Time: 12:11 PM
 */

if (!defined('WHMP_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

add_action('fusion_builder_before_init', 'WHMpress_integrateWithFB');
function WHMpress_integrateWithFB()
{

    $WHMPress = new WHMPress;
    $Products = whmp_get_products(true);

//    foreach ($Products as $key => $value){
//        $Product = $value."=>".$key;
//    }
//    die;

    $Products = array_reverse($Products, true);

    $Products["-- Select Product/Service --"] = "0";

    $Products = array_reverse($Products, true);

    $Products = array_flip($Products);

    $Slabs = whmp_get_slabs(true);

    $BillingCycles["Default"] = "annually";
    $BillingCycles["Monthly/One Time"] = "monthly";
    $BillingCycles["Quarterly"] = "quarterly";
    $BillingCycles["Semi Annually"] = "semiannually";
    $BillingCycles["Annually"] = "annually";
    $BillingCycles["Biennially"] = "biennially";
    $BillingCycles["Triennially"] = "triennially";

    $BillingCycles = array_flip($BillingCycles);

    $YesNo["Default"] = "";
    $YesNo["Yes"] = "yes";
    $YesNo["No"] = "no";

    $NoYes["Default"] = "";
    $NoYes["No"] = "no";
    $NoYes["Yes"] = "yes";

    $ProductTypes = $WHMPress->get_product_types(true);

    $Currencies = $WHMPress->get_currencies(true);
    $Currencies = array_flip($Currencies);

    $Duration_style = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Long (Year)", "whmpress") => "long",
        esc_html__("Short (Yr)", "whmpress") => "short",
        esc_html__(" Long 2 (1 Year)", "whmpress") => "duration2",
        esc_html__(" In Months (12 Months)", "whmpress") => "monthly",
    );
    $Duration_style = array_flip($Duration_style);

    $Show_duration = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Do not show duration", "whmpress") => "No",
        esc_html__("==No Tag==", "whmpress") => "-",
        esc_html__("Bold", "whmpress") => "b",
        esc_html__("Italic", "whmpress") => "i",
        esc_html__("Underline", "whmpress") => "u",
        esc_html__("Superscript", "whmpress") => "sup",
        esc_html__("Subscript", "whmpress") => "sub",
    );
    $Show_duration = array_flip($Show_duration);

    $Currency_prefix = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Do not show prefix", "whmpress") => "No",
        esc_html__("==No Tag==", "whmpress") => "-",
        esc_html__("Bold", "whmpress") => "b",
        esc_html__("Italic", "whmpress") => "i",
        esc_html__("Underline", "whmpress") => "u",
        esc_html__("Superscript", "whmpress") => "sup",
        esc_html__("Subscript", "whmpress") => "sub",
    );
    $Currency_prefix = array_flip($Currency_prefix);

    $Currency_suffix = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Do not show suffix", "whmpress") => "No",
        esc_html__("==No Tag==", "whmpress") => "-",
        esc_html__("Bold", "whmpress") => "b",
        esc_html__("Italic", "whmpress") => "i",
        esc_html__("Underline", "whmpress") => "u",
        esc_html__("Superscript", "whmpress") => "sup",
        esc_html__("Subscript", "whmpress") => "sub",
    );
    $Currency_suffix = array_flip($Currency_suffix);

    $Decimals = array(
        esc_html__("Default", 'whmpress'),
        esc_html__("1", 'whmpress'),
        esc_html__("2", 'whmpress'),
        esc_html__("3", 'whmpress'),
        esc_html__("4", 'whmpress'),
    );
//    $Decimals = array_flip($Decimals);

    $Decimals_tag = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("==No Tag==", "whmpress") => "-",
        esc_html__("Bold", "whmpress") => "b",
        esc_html__("Italic", "whmpress") => "i",
        esc_html__("Underline", "whmpress") => "u",
        esc_html__("Superscript", "whmpress") => "sup",
        esc_html__("Subscript", "whmpress") => "sub",
    );
    $Decimals_tag = array_flip($Decimals_tag);

    $Domain_decimals_tag = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Italic", "whmpress") => "i",
        esc_html__("Underline", "whmpress") => "u",
        esc_html__("Superscript", "whmpress") => "sup",
        esc_html__("Subscript", "whmpress") => "sub",
    );
    $Domain_decimals_tag = array_flip($Domain_decimals_tag);

    $Price_type = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Price", "whmpress") => "price",
        esc_html__("Setup Fee", "whmpress") => "setup",
        esc_html__("Price + Setup Fee", "whmpress") => "total",
    );
    $Price_type = array_flip($Price_type);

    $Price_tax = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("WHMCS Default", "whmpress") => "default",
        esc_html__("Inclusive Tax", "whmpress") => "inclusive",
        esc_html__("Exclusive Tax", "whmpress") => "exclusive",
        esc_html__("Tax Only", "whmpress") => "tax",
    );
    $Price_tax = array_flip($Price_tax);

    $Type = array(
        esc_html__("Product", "whmpress") => "product",
    );
    $Type = array_flip($Type);

    $Discount_type = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("%age", "whmpress") => "yearly",
        esc_html__("Calculated Monthly Price", "whmpress") => "monthly",
    );
    $Discount_type = array_flip($Discount_type);

    $Price_box_discount_type = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Yearly", "whmpress") => "yearly",
        esc_html__("Monthly", "whmpress") => "monthly",
    );
    $Price_box_discount_type = array_flip($Price_box_discount_type);

    $Domain_type = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Domain Registration", "whmpress") => "domainregister",
        esc_html__("Domain Renew", "whmpress") => "domainrenew",
        esc_html__("Domain Transfer", "whmpress") => "domaintransfer",
    );
    $Domain_type  = array_flip($Domain_type);

    $Years = array(
        esc_html__("Default", "whmpress"),
        esc_html__("1", "whmpress"),
        esc_html__("2", "whmpress"),
        esc_html__("3", "whmpress"),
        esc_html__("4", "whmpress"),
        esc_html__("5", "whmpress"),
        esc_html__("6", "whmpress"),
        esc_html__("7", "whmpress"),
        esc_html__("8", "whmpress"),
        esc_html__("9", "whmpress"),
        esc_html__("10", "whmpress"),
    );
//    $Years = array_flip($Years);

    $Domain_duratin_style = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Long (Year)", "whmpress") => "long",
        esc_html__("Short (Yr)", "whmpress") => "short",
    );
    $Domain_duratin_style = array_flip($Domain_duratin_style);

    $Order_landing_page = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Select No of years and Additional domains first", "whmpress") => "0",
        esc_html__("Go direct to domain settings", "whmpress") => "1",
    );
    $Order_landing_page  = array_flip($Order_landing_page);

    $Order_link_new_tab = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Open domain link in same tab", "whmpress") => "0",
        esc_html__("Open domain link in new tab", "whmpress") => "1",
    );
    $Order_link_new_tab = array_flip($Order_link_new_tab);

    $Search_extentions = array(
        esc_html__("Default", "whmpress") => "",
        esc_html__("Only Listed in WHMCS", "whmpress") => "1",
        esc_html__("All", "whmpress") => "0",
    );
    $Search_extentions = array_flip($Search_extentions);

    $Currency_show = array(
        esc_html__("Default", "whmpress"),
        esc_html__("Prefix", "whmpress"),
        esc_html__("Suffix", "whmpress"),
        esc_html__("Code", "whmpress"),
    );

    $Num_of_rows = array(
        esc_html__("Default", 'whmpress'),
        esc_html__("10", 'whmpress'),
        esc_html__("25", 'whmpress'),
        esc_html__("50", 'whmpress'),
        esc_html__("100", 'whmpress'),
    );

    global $whmp_shortcodes_list;

    global $donot_use;

    foreach ($donot_use as $du) {
        unset($whmp_shortcodes_list[$du]);
    }

    global $donot_include_editors;
    if (!defined('WHCOM_VERSION')) {
        $donot_include_editors[] = 'whmpress_domain_search_ajax_extended';
    }

    foreach ($whmp_shortcodes_list as $shortcode => $ff) {

        if (is_array($donot_include_editors) && in_array($shortcode, $donot_include_editors)) {
            continue;
        }

        $Files = $WHMPress->get_template_files($shortcode);

        $FilesList = $ImagesList = [];
        $FilesList["Default"] = "";
        $ImagesList["Default"] = "";

        if (get_option("load_sytle_orders") == "author" || get_option("load_sytle_orders") == "whmpress") {
            if (isset($Files["html"]) && is_array($Files["html"])) {
                foreach ($Files["html"] as $name => $filename) {
                    $FilesList["Template: " . $name] = $filename;
                }
            }
        } else {
            $AllTemplateFiles = $WHMPress->get_all_template_files($shortcode);
            foreach ($AllTemplateFiles as $FILE) {
                $FilesList[$FILE['description']] = $FILE['file_path'];
            }
        }

        if ($Files !== false) {

            foreach ($Files["images"] as $k => $v) {
                $ImagesList[$k] = $v;
            }
        }

        $short_params = $WHMPress->get_shortcode_parameters($shortcode);
        $params = [];
        $ten = 1000;

        foreach ($short_params as $key => $spm) {
            $array = [];

            ## Skip vc_type = "label" in VC.
            if (isset($spm["vc_type"]) && $spm["vc_type"] == "label") {
                continue;
            }

            if (is_array($spm)) {
                $params_name = $key;
            } else {
                $params_name = $spm;
            }

            if ($params_name == "html_template") {
                if (isset($Files["html"]) && sizeof($Files["html"]) > 0) {
                    $show = true;
                } else {
                    $show = false;
                }

                if ($show) {
                    $array["type"] = "select";
                    $array["heading"] = "Select template file";
                    $array["param_name"] = "html_template";
                    $array["value"] = array_flip($FilesList);
                    $array["description"] = "Select HTML template file";
                }
            } elseif ($params_name == "image") {
                if (isset($Files["images"]) && (sizeof($Files["images"]) > 0)) {
                    $show = true;
                } else {
                    $show = false;
                }
                if ($show) {
                    if (strtolower(@$spm["hide_if_template_file"]) <> "yes") {
                        $array["type"] = "select";
                        $array["heading"] = "Select image";
                        $array["param_name"] = "image";
                        $array["value"] = $ImagesList;
                    }
                }
            } elseif ($params_name == "html_id") {
                $show = true;
                if (isset($Files["html"]) && sizeof($Files["html"]) > 0 && isset($spm["hide_if_template_file"]) && strtolower($spm["hide_if_template_file"]) == "yes") {
                    $show = false;
                }
                if (strtolower(@$spm["hide_in_vc"]) == "yes") {
                    $show = false;
                }

                if ($show) {
                    $array["type"] = "textfield";
                    $array["heading"] = "HTML id";
                    $array["param_name"] = "html_id";
                    $array["value"] = "";
                    $array["description"] = "HTML id for container";
                }
            } elseif (is_array($spm)) {
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
                    if (isset($Files["html"]) && sizeof($Files["html"]) > 0 && isset($spm["hide_if_template_file"]) && strtolower($spm["hide_if_template_file"]) == "yes") {
                        $show = false;
                    }
                    if (isset($spm["hide_in_vc"]) && strtolower($spm["hide_in_vc"]) == "yes") {
                        $show = false;
                    }

                    if (!isset($spm["vc_type"])) {
                        $spm["vc_type"] = "textfield";
                    }
                    if ($show && isset($spm["vc_type"])) {
                        if ($spm["vc_type"] == "whmpress_icon") {
                            $array["param_name"] = $params_name;
                            $array["type"] = "whmpress_icon";
                            $array["value"] = @$spm["value"];
                        }elseif ($spm["vc_type"] == "noyes") {
                            $array["type"] = "select";
                            $array["value"] = $NoYes;
                        } elseif ($spm["vc_type"] == "checkbox") {
                            $array["type"] = "checkbox";
                            if (isset($spm["value"])) {
                                $array["value"] = $spm["value"];
                            }
                        } elseif ($spm["vc_type"] == "yesno") {
                            $array["type"] = "select";
                            $array["value"] = $YesNo;
                        } elseif ($spm["vc_type"] == "imagelist") {
                            $array["type"] = "select";
                            $array["value"] = $ImagesList;
                        } elseif ($spm["vc_type"] == "templatelist") {
                            $array["type"] = "select";
                            $array["value"] = $FilesList;
                        } elseif ($spm["vc_type"] == "productids") {
                            $array["type"] = "select";
                            $array["value"] = $Products;
                        } elseif ($spm["vc_type"] == "pricing_slabs") {
                            $array["type"] = "select";
                            $array["value"] = $Slabs;
                        } elseif ($spm["vc_type"] == "currencies") {
                            $array["type"] = "select";
                            $array["value"] = $Currencies;
                        } elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "duration_style"){
                            $array["type"] = "select";
                            $array["value"] = $Duration_style;
                        } elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "show_duration"){
                            $array["type"] = "select";
                            $array["value"] = $Show_duration;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "currency_prefix"){
                            $array["type"] = "select";
                            $array["value"] = $Currency_prefix;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "currency_sufix"){
                            $array["type"] = "select";
                            $array["value"] = $Currency_suffix;
                        }
                        elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "decimals"){
                            $array["type"] = "select";
                            $array["value"] = $Decimals;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "decimal_tag"){
                            $array["type"] = "select";
                            $array["value"] = $Decimals_tag;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "domain_decimal_tag"){
                            $array["type"] = "select";
                            $array["value"] = $Domain_decimals_tag;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "price_type"){
                            $array["type"] = "select";
                            $array["value"] = $Price_type;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "price_tax"){
                            $array["type"] = "select";
                            $array["value"] = $Price_tax;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "type"){
                            $array["type"] = "select";
                            $array["value"] = $Type;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "discount_type"){
                            $array["type"] = "select";
                            $array["value"] = $Discount_type;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "domain_type"){
                            $array["type"] = "select";
                            $array["value"] = $Domain_type;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "years"){
                            $array["type"] = "select";
                            $array["value"] = $Years;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "domain_duratin_style"){
                            $array["type"] = "select";
                            $array["value"] = $Domain_duratin_style;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "order_landing_page"){
                            $array["type"] = "select";
                            $array["value"] = $Order_landing_page;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "order_link_new_tab"){
                            $array["type"] = "select";
                            $array["value"] = $Order_link_new_tab;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "search_extensions"){
                            $array["type"] = "select";
                            $array["value"] = $Search_extentions;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "currency_show"){
                            $array["type"] = "select";
                            $array["value"] = $Currency_show;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "price_box_discount_type"){
                            $array["type"] = "select";
                            $array["value"] = $Price_box_discount_type;
                        }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "num_of_rows"){
                            $array["type"] = "select";
                            $array["value"] = $Num_of_rows;
                        }else {
                            $array["type"] = $spm["vc_type"];
                            if ($array["type"] == "") {
                                $array["type"] = "textfield";
                            }

                            if (@$spm["value"] == "currency_codes") {
                                $array["type"] = "select";
                                $array["value"] = $Currencies;
                            } elseif (@$spm["value"] == "product_ids") {
                                $array["type"] = "select";
                                $array["value"] = $Products;
                            } elseif (@$spm["value"] == "billing_cycle") {
                                $array["type"] = "select";
                                $array["value"] = $BillingCycles;
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

        if (is_array($Files["custom_fields"])) {
            foreach ($Files["custom_fields"] as $custom_field) {
                foreach ($custom_field as $k => &$cs) {
                    if (is_null($cs)) {
                        unset($custom_field[$k]);
                    } elseif ($WHMPress->is_json(str_replace("'", '"', $cs))) {
                        $cs = json_decode(str_replace("'", '"', $cs), true);
                    }
                }

                if (isset($custom_field["type"]) && $custom_field["type"] == "select" && isset($custom_field["value"]) && !is_array($custom_field["value"])) {
                    $custom_field["value"] = explode(",", $custom_field["value"]);
                    $custom_field["value"] = array_map('trim', $custom_field["value"]);
                }

                $custom_field = array_filter($custom_field);

                if (!isset($custom_field["admin_label"])) {
                    $custom_field["admin_label"] = false;
                }
                $params[] = $custom_field;
            }
        }
        $atts = array(
            "name" => $vc_shortcode_title,
            "shortcode" => $shortcode,
//            "icon" => WHMP_ADMIN_URL . "/images/logo32.png",
//            'preview'         => WP_PLUGIN_URL . '/fusion-builder/inc/templates/previews/fusion-text-preview.php',
            'preview_id' => 'fusion-builder-block-module-text-preview-template',
            'allow_generator' => true,
            'params' => $params,
        );

        fusion_builder_map($atts);
    }
}