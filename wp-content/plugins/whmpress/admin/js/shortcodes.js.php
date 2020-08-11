<?php
$realpath = realpath( "../../../../../wp-load.php" );
if ( ! is_file( $realpath ) ) {
	echo "File '" . $realpath . "Not found.<br>Can't load WordPress Library.";
	exit;
}

include_once( $realpath );
if ( ! is_user_logged_in() ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}
header( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );
header( 'Content-Type: application/javascript' ); ?>

function wis_null( mixed_var ) {
	//  discuss at: http://phpjs.org/functions/is_null/
	// original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	//   example 1: is_null('23');
	//   returns 1: false
	//   example 2: is_null(null);
	//   returns 2: true

	return (mixed_var === null);
}
function wempty( mixed_var ) {
	//  discuss at: http://phpjs.org/functions/empty/
	// original by: Philippe Baumann
	//    input by: Onno Marsman
	//    input by: LH
	//    input by: Stoyan Kyosev (http://www.svest.org/)
	// bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	// improved by: Onno Marsman
	// improved by: Francesco
	// improved by: Marc Jansen
	// improved by: Rafal Kukawski
	//   example 1: empty(null);
	//   returns 1: true
	//   example 2: empty(undefined);
	//   returns 2: true
	//   example 3: empty([]);
	//   returns 3: true
	//   example 4: empty({});
	//   returns 4: true
	//   example 5: empty({'aFunc' : function () { alert('humpty'); } });
	//   returns 5: false

	var undef, key, i, len;
	var emptyValues = [ undef, null, false, 0, '', '0' ];

	for ( i = 0, len = emptyValues.length; i < len; i++ ) {
		if ( mixed_var === emptyValues[ i ] ) {
			return true;
		}
	}

	if ( typeof mixed_var === 'object' ) {
		for ( key in mixed_var ) {
			// TODO: should we check for own properties only?
			//if (mixed_var.hasOwnProperty(key)) {
			return false;
			//}
		}
		return true;
	}

	return false;
}


// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons#tmce-section-1
(function() {
	tinymce.PluginManager.add( 'whmpress_tc_button', function( editor, url ) {
		editor.addButton( 'whmpress_tc_button', {
			title: 'WHMpress ShortCodes',
			type: 'menubutton',
			icon: 'icon whmpress-own-icon',
			// Types, textbox, checkbox, listbox, container
			menu: [
					<?php
					global $whmp_shortcodes_list;
					global $donot_use;

					foreach ( $donot_use as $du ) {
						unset( $whmp_shortcodes_list[ $du ] );
					}

					global $WHMPress;
					if ( ! $WHMPress ) {
						$WHMPress = new WHMPress();
					}

					$Products = whmp_get_products( true );
					$Products = array_reverse( $Products, true );
					$Products["-- Select Produt/Service --"] = "0";
					$Products = array_reverse( $Products, true );

					$Slabs = whmp_get_slabs( true );

					$BillingCycles["Default"] = "";
					$BillingCycles["Monthly/One Time"] = "monthly";
					$BillingCycles["Quarterly"] = "quarterly";
					$BillingCycles["Annually"] = "annually";
					$BillingCycles["Semi Annually"] = "semiannually";
					$BillingCycles["Biennially"] = "biennially";
					$BillingCycles["Triennially"] = "triennially";

					$YesNo["Default"] = "";
					$YesNo["Yes"] = "yes";
					$YesNo["No"] = "no";

					$NoYes["Default"] = "";
					$NoYes["No"] = "no";
					$NoYes["Yes"] = "yes";

					$ProductTypes = $WHMPress->get_product_types( true );

					$Currencies = $WHMPress->get_currencies( true );

					global $donot_include_editors;
					if (!defined('WHCOM_VERSION')) {
						$donot_include_editors[] = 'whmpress_domain_search_ajax_extended';
					}
					foreach($whmp_shortcodes_list as $shortcode=>$ff):

					$short_params = $WHMPress->get_shortcode_parameters( $shortcode );
					if ( empty( $short_params ) ) {
						continue;
					}

					## If current shortcode is skipped for Editor integration.
					## in includes/shortcodes.php
					if ( is_array( $donot_include_editors ) && in_array( $shortcode, $donot_include_editors ) ) {
						continue;
					}

					$Files = $WHMPress->get_template_files( $shortcode );
					$FilesList = $ImagesList = [];
					$FilesList["Default"] = "";
					$ImagesList["Default"] = "";

					if ( get_option( "load_sytle_orders" ) == "author" || get_option( "load_sytle_orders" ) == "whmpress" ) {
						if ( isset( $Files["html"] ) && is_array( $Files["html"] ) ) {
							foreach ( $Files["html"] as $name => $filename ) {
								$FilesList[ $name ] = $filename;
							}
						}
					} else {
						$AllTemplateFiles = $WHMPress->get_all_template_files( $shortcode );
						foreach ( $AllTemplateFiles as $FILE ) {
							$FilesList[ $FILE['description'] ] = $FILE['file_path'];
						}
					}

					if ( $Files !== false ) {
						foreach ( $Files["images"] as $k => $v ) {
							if ( strtolower( $k ) <> "default" ) {
								$ImagesList[ $k ] = $v;
							}
						}
					}

					$params = [];
					foreach ( $short_params as $key => $spm ) {
						$array = [];
						if ( is_array( $spm ) ) {
							$params_name = $key;
						} else {
							$params_name = $spm;
						}

						if ( $params_name == "html_template" ) {
							$show = (!empty($Files["html"]) && is_array($Files["html"])) ? true : false;
							if ( strtolower( @$spm["hide_in_editor"] ) == "yes" ) {
								$show = false;
							}

							if ( $show ) {
								$array["type"]        = "dropdown";
								$array["heading"]     = "Select template file";
								$array["param_name"]  = "html_template";
								$array["value"]       = $FilesList;
								$array["description"] = "Select HTML template file";
							}
						} elseif ( $params_name == "image" ) {
							$show = (!empty($Files["html"]) && is_array($Files["images"])) ? true : false;
							if ( strtolower( @$spm["hide_in_editor"] ) == "yes" ) {
								$show = false;
							}

							if ( $show ) {
								$array["type"]       = "dropdown";
								$array["heading"]    = "Select image";
								$array["param_name"] = "image";
								$array["value"]      = $ImagesList;
							}
						} elseif ( $params_name == "html_id" ) {
							$show = true;
							if ( is_array($Files["html"]) && sizeof( $Files["html"] ) > 0 && strtolower( @$spm["hide_if_template_file"] ) == "yes" ) {
								$show = false;
							}
							if ( strtolower( @$spm["hide_in_editor"] ) == "yes" ) {
								$show = false;
							}

							if ( $show ) {
								$array["type"]        = "textfield";
								$array["heading"]     = "HTML id";
								$array["param_name"]  = "html_id";
								$array["value"]       = "";
								$array["description"] = "HTML id for container";
							}
						} elseif ( is_array( $spm ) ) {
							if ( $key == "vc_options" ) {
								$_TITLE = @$spm["title"];
								//$_TITLE = "Farooq";$whmp_shortcodes_list_title[$key];
								if ( substr( $_TITLE, 0, 9 ) == "WHMPress " ) {
									$_TITLE = substr( $_TITLE, 9 );
								}
							} else {
								$show = true;
								if ( is_array($Files["html"]) && sizeof( $Files["html"] ) > 0 && strtolower( @$spm["hide_if_template_file"] ) == "yes" ) {
									$show = false;
								}
								if ( strtolower( @$spm["hide_in_editor"] ) == "yes" ) {
									$show = false;
								}

								if ( $show ) {
									if ( @$spm["vc_type"] == "noyes" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $NoYes;
									} elseif ( @$spm["vc_type"] == "yesno" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $YesNo;
									} elseif ( @$spm["vc_type"] == "imagelist" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $ImagesList;
									} elseif ( @$spm["vc_type"] == "templatelist" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $FilesList;
									} elseif ( @$spm["vc_type"] == "productids" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $Products;
									} elseif ( @$spm["vc_type"] == "pricing_slabs" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $Slabs;
									} elseif ( @$spm["vc_type"] == "currencies" ) {
										$array["type"]  = "dropdown";
										$array["value"] = $Currencies;
									} else {
										$array["type"] = @$spm["vc_type"];
										if ( $array["type"] == "" ) {
											$array["type"] = "textfield";
										}

										if ( @$spm["value"] == "currency_codes" ) {
											$array["value"] = $Currencies;
										} elseif ( @$spm["value"] == "product_ids" ) {
											$array["value"] = $Products;
										} elseif ( @$spm["value"] == "billing_cycle" ) {
											$array["value"] = $BillingCycles;
										} else {
											$array["value"] = @$spm["value"];
										}
									}

									$array["heading"] = @$spm["heading"];
									if ( $array["heading"] == "" ) {
										$array["heading"] = ucwords( str_replace( "_", " ", $key ) );
									}

									$array["param_name"] = $key;
									if ( isset( $spm["description"] ) ) {
										$array["description"] = $spm["description"];
									}
								}
							}
						} else {
							$array["type"]       = "textfield";
							$array["heading"]    = ucwords( str_replace( "_", " ", $spm ) );
							$array["param_name"] = $spm;
							$array["value"]      = "";
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
					} ?>{
					text: '<?php echo $_TITLE ?>',
					value: 'Display <?php echo $_TITLE ?>',
					onclick: function( e ) {
						var whmpRawData = [];
						var bodyType = '';
						var whmpProcessedData = [
							{
								title: '<?php echo esc_html_x( 'General','admin', 'whmpress' )?>',
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
							classes: 'whmpress-short-code',
							bodyType: bodyType,
							body: whmpProcessedData,
							onsubmit: function( e ) {
								e = dummy.toJSON();
								if ( "<?php echo $shortcode ?>" == "whmpress_whmcs_if_loggedin" ) {
									data = '[<?php echo $shortcode ?>]';
									data += "I am logged in text - <strong>Replace me</strong>";
									data += '[/<?php echo $shortcode ?>]';
								}
								else if ( "<?php echo $shortcode ?>" == "whmpress_whmcs_if_not_loggedin" ) {
									data = '[<?php echo $shortcode ?>]';
									data += "I am not logged in text - <strong>Replace me</strong>";
									data += '[/<?php echo $shortcode ?>]';
								}
								else {
									data = '[<?php echo $shortcode ?>';
									<?php unset( $short_params["vc_options"] );
									foreach($short_params as $key=>$val):
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
								}
								editor.insertContent( data );
							}
						} );
					}
				},
				<?php endforeach; ?>
			]
		} )
	} );
})( jQuery );