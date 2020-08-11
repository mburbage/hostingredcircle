<?php
/**
 * Created by PhpStorm.
 * User: Fakhir
 * Date: 2/25/2019
 * Time: 12:10 PM
 */
$realpath = realpath("../../../../../wp-load.php");
if (!is_file($realpath)) {
    echo "File '" . $realpath . "Not found.<br>Can't load WordPress Library.";
    exit;
}

include_once($realpath);
if (!is_user_logged_in()) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header('Content-Type: application/javascript');

?>

(function() {
    tinymce.PluginManager.add('wcop_tc_button', function( editor, url ) {
        editor.addButton( 'wcop_tc_button', {
            title: 'WCOP ShortCodes',
            type: 'menubutton',
            icon: 'icon wcop-own-icon',
            menu: [
                <?php
                $shortcodes = [
                    'whmpress_store',
                    'whmpress_cart_config_product',
                    'whmpress_cart_single_page',
                ];

                $YesNo["Default"] = "";
                $YesNo["Yes"] = "yes";
                $YesNo["No"] = "no";

                $NoYes["Default"] = "";
                $NoYes["No"] = "no";
                $NoYes["Yes"] = "yes";
                $templates = get_singlePageTemplates_list();
                foreach ($shortcodes as $SHORTCODES):
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
                                $spm["vc_type"] = "textbox";
                            }
                            if ($show && isset($spm["vc_type"])) {
                                if ($spm["vc_type"] == "wcop_icon") {
                                    $array["param_name"] = $params_name;
                                    $array["type"] = "wcop_icon";
                                    $array["value"] = @$spm["value"];
                                } elseif ($spm["vc_type"] == "noyes") {
                                    $array["type"] = "listbox";
                                    $array["value"] = $NoYes;
                                } elseif ($spm["vc_type"] == "checkbox") {
                                    $array["type"] = "checkbox";
                                    if (isset($spm["value"])) {
                                        $array["value"] = $spm["value"];
                                    }
                                } elseif ($spm["vc_type"] == "yesno") {
                                    $array["type"] = "listbox";
                                    $array["value"] = $YesNo;
                                }elseif (isset($spm["fb_type"]) && $spm["fb_type"] == "style"){
                                    $array["type"] = "listbox";
                                    $array["value"] = $templates;
                                } else {
                                    $array["type"] = $spm["vc_type"];
                                    if ($array["type"] == "") {
                                        $array["type"] = "textbox";
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

                    if ( sizeof( $array ) > 0 ) {
                        foreach ( $array as $key => $val ) {
                            if ( isset( $spm["description"] ) ) {
                                $array["tooltip"] = strip_tags( $spm["description"] );
                            } elseif ( isset( $spm["heading"] ) ) {
                                $array["tooltip"] = strip_tags( $spm["heading"] );
                            } elseif ( isset( $spm["label"] ) ) {
                                $array["tooltip"] = strip_tags( $spm["label"] );
                            } else {
                                $array["tooltip"] = "-- No Tip --";
                            }

                            if ( ! empty( $spm['classes'] ) ) {
                                $array['classes'] = $spm['classes'];
                            }
                            if ( ! empty( $spm['style'] ) ) {
                                $array['style'] = $spm['style'];
                            }

                            if ( $key == "type" && $val == "textfield" ) {
                                $array[ $key ] = "textbox";
                                if ( isset( $spm["description"] ) ) {
                                    $array["tooltip"] = $spm["description"];
                                }
                            }
                            if ( $key == "type" && $val == "dropdown" ) {
                                $array[ $key ] = "listbox";
                                if ( isset( $spm["description"] ) ) {
                                    $array["tooltip"] = $spm["description"];
                                }
                            }

                            if ( $key == "heading" ) {
                                $array["label"] = $val;
                                unset( $array["heading"] );
                            }

                            if ( $key == "classes" ) {
                                $array["classes"] = $val;
                            }

                            if ( $key == "param_name" ) {
                                $array["name"] = $val;
                                unset( $array["param_name"] );
                            }

                            if ( $key == "value" && is_array( $val ) ) {
                                $Out = [];
                                if ( array_keys( $val ) !== range( 0, count( $val ) - 1 ) ) {
                                    foreach ( $val as $k => $v ) {
                                        $k     = utf8_encode( $k );
                                        $Out[] = [ "text" => $k, "value" => $v ];
                                    }
                                } else {
                                    foreach ( $val as $k => $v ) {
                                        $v     = utf8_encode( $v );
                                        $Out[] = [ "text" => $v, "value" => $v ];
                                    }
                                }
                                $array["values"] = $Out;
                                unset( $array["value"] );
                            } else if ( $key == "value" && is_null( $val ) ) {
                                $array["value"] = "";
                            }
                        }
                        unset( $array["description"] );
                        $params[] = $array;
                    }
                }
                ?>
                {
                    text: '<?php echo $_TITLE ?>',
                    value: 'Display <?php echo $_TITLE ?>',
                    onclick: function() {
                        var whmpRawData = [];
                        var bodyType = '';
                        var whmpProcessedData = [
                            {
                                title: '<?php echo esc_html_x( 'General','admin', 'whcom' )?>',
                                type: 'form',
                                items: []
                            }
                        ];
                        whmpRawData = <?php echo json_encode( $params );?>;
                        var sectionCounter = 0;
                        jQuery.each( whmpRawData, function( i, data ) {
                            if ( data.classes ) {
                                var sectionData = {
                                    title: data.label,
                                    type: 'form',
                                    items: []
                                };
                                whmpProcessedData.push( sectionData );
                                sectionCounter++;
                                bodyType = 'tabpanel';
                            } else {
                                whmpProcessedData[ sectionCounter ].items.push( data );
                            }
                        } );

                        if ( whmpProcessedData.length < 2 ) {
                            whmpProcessedData = whmpRawData;
                        }
                        var dummy = editor.windowManager.open( {
                            title: 'Insert <?php echo $_TITLE ?> shortcode',
                            classes: 'wcop-short-code',
                            bodyType: bodyType,
                            body: whmpProcessedData,
                            onsubmit: function( e ) {
                                e = dummy.toJSON();
                                    data = '[<?php echo $SHORTCODES ?>';
                                    <?php unset( $shortcodeParams["vc_options"] );
                                    foreach($shortcodeParams as $key=>$val):
                                    if ( is_array( $val ) ) {
                                        $field = $key;
                                    } else {
                                        $field = $val;
                                    } ?>
                                    if ( !wempty( e.<?php echo $field ?>) && e.<?php echo $field ?>!= "Default" ) {
                                        data += ' <?php echo $field ?>="' + e.<?php echo $field ?> + '"';
                                    }
                                    <?php endforeach; ?>
                                    data += "]";
                                editor.insertContent( data );
                            }
                        } );
                    }
                },
                <?php endforeach; ?>
            ]
        });
    });
})( jQuery );

