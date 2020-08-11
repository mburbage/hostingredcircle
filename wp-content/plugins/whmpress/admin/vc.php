<?php
/**
 * @package Admin
 * @todo    Visual composer plugin integration
 * @since   1.3.0
 */

if (!defined('WHMP_VERSION')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

//add_shortcode_param( 'whmpress_icon', 'whmpress_vc_icon', WHMP_PLUGIN_URL.'/admin/js/new_vc_param.js' );
vc_add_shortcode_param('whmpress_icon', 'whmpress_vc_icon', WHMP_PLUGIN_URL . '/admin/js/new_vc_param.js');
function whmpress_vc_icon($settings, $value)
{
    //$dependency = vc_generate_dependencies_attributes( $settings );

    $pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
    //read_local_file
    $w = new WHMPress;
    $fa_icons = $w->font_awesome_icons();
    #file_put_contents("D:\abc.txt", $value."\n", FILE_APPEND);

    $icons = "";
    foreach ($fa_icons as $icon) {
        $icons .= "<i data-id='whmp_vc_" . esc_attr($settings['param_name']) . "' class='fa $icon'></i>";
    }

    return '<div class="my_param_block">' . '<style>.whmpress_select_window i {' . 'display:inline-block;height:40px;min-width:40px;text-align:center;padding:5px;vertical-align:middle;border:1px solid #ddd;margin:2px;cursor:pointer;box-sizing:content-box' . '}
            .whmpress_select_window i:hover {background:#000000;color:#FFFFFF}
            </style>' . '<div class="whmp_icon_preview" style="display: inline-block;
					margin-right: 10px;
					height: 60px;
					width: 90px;
					text-align: center;
					background: #FAFAFA;
					font-size: 60px;
					padding: 15px 0;
					margin-bottom: 10px;
					border: 1px solid #DDD;
					float: left;
					box-sizing: content-box;"></div>' . '<input
                style="width: 230px; margin-right: 10px; vertical-align: top; float: left; margin-bottom: 10px" name="' . esc_attr($settings['param_name']) . '"
                id="whmp_vc_' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput ' . esc_attr($settings['param_name']) . ' textfield ' . esc_attr($settings['type']) . '_field" type="text" value="' . esc_attr($value) . '" />
            <div class="whmpress_select_window" style="font-size: 40px; width: 100%; padding: 8px;
					box-sizing: border-box;
					-moz-box-sizing: border-box;
					background: #FAFAFA;
					height: 250px;
					overflow-y: scroll;
					border: 1px solid #DDD;
					clear: both">' . $icons . '</div>' . '</div>';
}


add_action('vc_before_init', 'WHMPress_integrateWithVC');
function WHMPress_integrateWithVC()
{
    $WHMPress = new WHMPress;
    $Products = whmp_get_products(true);
    $Products = array_reverse($Products, true);
    $Products["-- Select Product/Service --"] = "0";
    $Products = array_reverse($Products, true);

    //$Slabs = whmp_get_slabs(true);

    $BillingCycles["Default"] = "";
    $BillingCycles["Monthly/One Time"] = "monthly";
    $BillingCycles["Quarterly"] = "quarterly";
    $BillingCycles["Semi Annually"] = "semiannually";
    $BillingCycles["Annually"] = "annually";
    $BillingCycles["Biennially"] = "biennially";
    $BillingCycles["Triennially"] = "triennially";

    $YesNo["Default"] = "";
    $YesNo["Yes"] = "yes";
    $YesNo["No"] = "no";

    $NoYes["Default"] = "";
    $NoYes["No"] = "no";
    $NoYes["Yes"] = "yes";

    $ProductTypes = $WHMPress->get_product_types(true);

    $Currencies = $WHMPress->get_currencies(true);

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

        ## If current shortcode is skipped for Editor integration.
        ## in includes/shortcodes.php
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
            /*foreach ( $Files["html"] as $k => $v ) {
                //if( strtolower($k)<>"default" ) $FilesList[$k] = $v;
                if ( strtolower( $k ) == "default" ) {
                    unset( $Files["html"][ $k ] );
                } else {
                    $FilesList[ $k ] = $v;
                }
            }*/
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
                if(isset($Files["html"]) && sizeof($Files["html"]) > 0 ){
                    $show = true;
                }else{
                    $show = false;
                }
                #if ($show) reset($Files["html"]);
                #if ($show && sizeof($Files["html"]=="1") && ( strtolower(key($Files["html"]))=="default" ) ) $show = false;

                /*if ( $shortcode == "whmpress_pricing_table" ) {
                    show_array($FilesList); die;
                }*/

                if ($show) {
                    $array["type"] = "dropdown";
                    $array["heading"] = "Select template file";
                    $array["param_name"] = "html_template";
                    $array["value"] = $FilesList;
                    $array["description"] = "Select HTML template file";
                }
            } elseif ($params_name == "image") {
                if (isset($Files["images"]) && (sizeof($Files["images"]) > 0)){
                    $show = true;
                }else{
                    $show = false;
                }

                if ($show) {
                    if (strtolower(@$spm["hide_if_template_file"]) <> "yes") {
                        $array["type"] = "dropdown";
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
                @$spm["hide_in_vc"] = array_key_exists("hide_in_vc", $spm) ? @$spm["hide_in_vc"] : "";
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
                //==if value index exist in array then assign value otherwise not
                @$spm["value"] = array_key_exists("value", $spm) ? @$spm["value"] : "";
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
                        } elseif ($spm["vc_type"] == "imagelist") {
                            $array["type"] = "dropdown";
                            $array["value"] = $ImagesList;
                        } elseif ($spm["vc_type"] == "templatelist") {
                            $array["type"] = "dropdown";
                            $array["value"] = $FilesList;
                        } elseif ($spm["vc_type"] == "productids") {
                            $array["type"] = "dropdown";
                            $array["value"] = $Products;
                        } /*elseif ($spm["vc_type"] == "pricing_slabs") {
                            $array["type"] = "dropdown";
                            $array["value"] = $Slabs;
                        }*/ elseif ($spm["vc_type"] == "currencies") {
                            $array["type"] = "dropdown";
                            $array["value"] = $Currencies;
                        } else {
                            $array["type"] = $spm["vc_type"];
                            if ($array["type"] == "") {
                                $array["type"] = "textfield";
                            }

                            if (@$spm["value"] == "currency_codes") {
                                $array["value"] = $Currencies;
                            } elseif (@$spm["value"] == "product_ids") {
                                $array["value"] = $Products;
                            } elseif (@$spm["value"] == "billing_cycle") {
                                $array["value"] = $BillingCycles;
                            } else {
                                $array["value"] = @$spm["value"];
                            }
                        }

                        $array['heading'] = array_key_exists("heading", $spm) ? @$spm["heading"] : "";
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

                        if (isset($spm["dependency"])) {
                            $array["dependency"] = $spm["dependency"];
                        }

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
            /*if (isset($array["description"]))
                $array["description"] .= " ($ten)";
            else
                $array["description"] = $ten;*/
            /*if ( ! isset( $array["weight"] ) || empty( $array["weight"] ) ) {
                $array["weight"] = $ten -= 10;
            }*/
            //if (!isset($array["admin_label"])) $array["admin_label"] = false;

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

                if (isset($custom_field["type"]) && $custom_field["type"] == "dropdown" && isset($custom_field["value"]) && !is_array($custom_field["value"])) {
                    $custom_field["value"] = explode(",", $custom_field["value"]);
                    $custom_field["value"] = array_map('trim', $custom_field["value"]);
                }

                $custom_field = array_filter($custom_field);

                if (!isset($custom_field["admin_label"])) {
                    $custom_field["admin_label"] = false;
                }
                $params[] = $custom_field;

                /*if ($shortcode=="whmpress_domain_price") {
                    echo "<pre>";
                    print_r ($custom_field)."<br />";
                    echo "</pre>";
                }*/
            }
        }


        #file_put_contents("D:\abc.txt", print_r($params,true)."\n", FILE_APPEND);
        //if (!isset($params["default"])) $params["default"] = "";


        $args = array(
            "name" => $vc_shortcode_title,
            "description" => "", // will get from array
            "base" => $shortcode, //'vc_row', //$shortcode,
            "category" => "WHMPress",
            "icon" => WHMP_ADMIN_URL . "/images/logo32.png",
            "params" => $params,
        );


        //show_array($args);
        vc_map($args);

        #break;
    }
}