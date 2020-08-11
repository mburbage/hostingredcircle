<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

if ( ! function_exists( 'whcom_render_nameservers' ) ) {
	function whcom_render_nameservers() {
		$nameservers = whcom_get_nameservers();
		ob_start(); ?>
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e( 'Nameservers', 'whcom' ); ?></span>
        </div>
        <div class="whcom_margin_bottom_15">
			<?php esc_html_e( "If you want to use custom nameservers then enter them below. By default, new domains will use our nameservers for hosting on our network.", "whcom" ) ?>
        </div>
        <div class="whcom_op_domain_nameservers whcom_row">
            <div class="whcom_col_sm_4" id="NS1_container">
                <div class="whcom_form_field">
                    <label for="inputNs1" class="main_label"><?php esc_html_e( 'Nameserver 1', 'whcom' ); ?></label>
                    <input type="text"
                           class=""
                           id="inputNs1"
                           name="domainns1"
                           value="<?php echo $nameservers['ns1']; ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4" id="NS2_container">
                <div class="whcom_form_field">
                    <label for="inputNs2" class="main_label"><?php esc_html_e( 'Nameserver 2', 'whcom' ); ?></label>
                    <input type="text"
                           class=""
                           id="inputNs2"
                           name="domainns2"
                           value="<?php echo $nameservers['ns2']; ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4" id="NS3_container">
                <div class="whcom_form_field">
                    <label for="inputNs3" class="main_label"><?php esc_html_e( 'Nameserver 3', 'whcom' ); ?></label>
                    <input type="text"
                           class=""
                           id="inputNs3"
                           name="domainns3"
                           value="<?php echo $nameservers['ns3']; ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4" id="NS4_container">
                <div class="whcom_form_field">
                    <label for="inputNs4" class="main_label"><?php esc_html_e( 'Nameserver 4', 'whcom' ); ?></label>
                    <input type="text"
                           class=""
                           id="inputNs4"
                           name="domainns4"
                           value="<?php echo $nameservers['ns4']; ?>">
                </div>
            </div>
            <div class="whcom_col_sm_4" id="NS5_container">
                <div class="whcom_form_field">
                    <label for="inputNs5" class="main_label"><?php esc_html_e( 'Nameserver 5', 'whcom' ); ?></label>
                    <input type="text"
                           class=""
                           id="inputNs5"
                           name="domainns5"
                           value="<?php echo $nameservers['ns5']; ?>">
                </div>
            </div>
        </div>

		<?php return ob_get_clean();
	}
}

if ( ! function_exists( 'whcom_get_tld_count' ) ) {
	function whcom_get_tld_count() {
	    if(!empty($_SESSION['whcom_tld_count'])){
	        $response = $_SESSION['whcom_tld_count'];
        }else {
            $args = [
                "action" => "whcom_get_tld_count",
            ];
            $response = $_SESSION['whcom_tld_count'] = whcom_process_helper($args)['data'];
        }

		return $response;
	}
}

if ( ! function_exists( 'whcom_get_all_tlds' ) ) {
	function whcom_get_all_tlds() {
		$tld_count = whcom_get_tld_count();
		if ( ( ! empty( $_SESSION['whcom_all_tlds'] ) ) && ( count( $_SESSION['whcom_all_tlds'] ) == (int) $tld_count ) ) {
			$response = $_SESSION['whcom_all_tlds'];
		}
		else {
			$args     = [
				"action" => "whcom_get_all_tlds",
			];
			$response = $_SESSION['whcom_all_tlds'] = whcom_process_helper( $args )['data'];
		}

		return $response;
	}
}

if ( ! function_exists( 'whcom_get_tld_details' ) ) {
	function whcom_get_tld_details( $tld ) {
		$tld = "." . ( ltrim( $tld, "." ) );
		if ( ! empty( $_SESSION['whcom_cart']['cart_domains'][ $tld ] ) ) {
			$response = $_SESSION['whcom_cart']['cart_domains'][ $tld ];
		}
		else {
			$all_tlds                                       = whcom_get_all_tlds();
			$response                                       = ( ! empty( $all_tlds[ $tld ] ) ) ? $all_tlds[ $tld ] : [];
			$_SESSION['whcom_cart']['cart_domains'][ $tld ] = $response;
		}

		return $response;
	}
}

if ( ! function_exists( 'whcom_get_tld_from_domain' ) ) {
	function whcom_get_tld_from_domain( $domain ) {
		$tld = strstr( $domain, '.' );

		return $tld;
	}
}

if ( ! function_exists( 'whcom_get_domain_addons' ) ) {
	function whcom_get_domain_addons() {
	    if(!empty($_SESSION['whcom_domain_addons']))
        {
            $response = $_SESSION['whcom_domain_addons'];
        }else {
            $args = [
                "action" => "whcom_get_domain_addons",
            ];
            $response = $_SESSION['whcom_domain_addons'] = whcom_process_helper($args);
        }

		return $response['data'];
	}
}

if ( ! function_exists( 'whcom_get_nameservers' ) ) {
	function whcom_get_nameservers() {
		$nameservers = [
			'ns1' => '',
			'ns2' => '',
			'ns3' => '',
			'ns4' => '',
			'ns5' => '',
		];
		$all_config  = whcom_process_helper( [ "action" => "configurations" ] )['data'];

		if ( ! empty( $all_config ) && is_array( $all_config ) ) {
			$nameservers['ns1'] = $all_config["DefaultNameserver1"];
			$nameservers['ns2'] = $all_config["DefaultNameserver2"];
			$nameservers['ns3'] = $all_config["DefaultNameserver3"];
			$nameservers['ns4'] = $all_config["DefaultNameserver4"];
			$nameservers['ns5'] = $all_config["DefaultNameserver5"];
		}
		$current_cart       = whcom_get_cart();
		$nameservers['ns1'] = ( ! empty( $current_cart ) && ! empty( $current_cart['order_specific']['nameserver1'] ) ) ? $current_cart['order_specific']['nameserver1'] : $nameservers['ns1'];
		$nameservers['ns2'] = ( ! empty( $current_cart ) && ! empty( $current_cart['order_specific']['nameserver2'] ) ) ? $current_cart['order_specific']['nameserver2'] : $nameservers['ns2'];
		$nameservers['ns3'] = ( ! empty( $current_cart ) && ! empty( $current_cart['order_specific']['nameserver3'] ) ) ? $current_cart['order_specific']['nameserver3'] : $nameservers['ns3'];
		$nameservers['ns4'] = ( ! empty( $current_cart ) && ! empty( $current_cart['order_specific']['nameserver4'] ) ) ? $current_cart['order_specific']['nameserver4'] : $nameservers['ns4'];
		$nameservers['ns5'] = ( ! empty( $current_cart ) && ! empty( $current_cart['order_specific']['nameserver5'] ) ) ? $current_cart['order_specific']['nameserver5'] : $nameservers['ns5'];


		return $nameservers;
	}
}

if ( ! function_exists( 'whcom_get_domain_fields' ) ) {
	function whcom_get_domain_fields( $tld ) {
		$tld                    = "." . ( ltrim( $tld, "." ) );
		$additionaldomainfields = [];
		include WHCOM_PATH . '/includes/external/whmcs_lang.php';
		include WHCOM_PATH . '/includes/external/domain_fields.php';
		$hidden_domain_fields = get_option( 'whcom_hide_domain_fields', [] );

		$domain_fields = ( ! empty( $additionaldomainfields[ $tld ] ) && is_array( $additionaldomainfields[ $tld ] ) ) ? $additionaldomainfields[ $tld ] : [];

		if ( ! empty( $domain_fields ) ) {
			foreach ( $domain_fields as $key => $domain_field ) {
				$fld_name = str_replace( '.', '_', $tld ) . '_' . $key;
				if ( ! empty( $hidden_domain_fields[ $fld_name ] ) && ( $hidden_domain_fields[ $fld_name ] == 'hide' ) ) {
					unset( $domain_fields[ $key ] );
				}
			}
		}

		return $domain_fields;

	}
}

if ( ! function_exists( 'whcom_render_product_domain_form' ) ) {
	function whcom_render_product_domain_form() {

		$domaintype      = ( ! empty( $_REQUEST['domain'] ) ) ? strtolower( $_REQUEST['domain'] ) : 'register';
		$sld             = ( ! empty( $_REQUEST['sld'] ) ) ? strtolower( $_REQUEST['sld'] ) : '';
		$tld_req         = ( ! empty( $_REQUEST['tld'] ) ) ? strtolower( $_REQUEST['tld'] ) : '';
		$register_class  = $transfer_class = $existing_class = $register_form_class = $transfer_form_class = $existing_form_class = '';
		$domain_provided = ( ! empty( $tld_req ) && ! empty( $sld ) ) ? true : false;
		$on_load_class   = ( ! empty( $tld_req ) && ! empty( $sld ) ) ? 'whcom_op_submit_on_load' : '';
		$whmcs_settings  = whcom_get_whmcs_setting();

		// Getting domains already in cart
		$domains_list = whcom_get_all_tlds();
		$curr_domains = [];
		$curr_cart    = whcom_get_cart()['all_items'];

		foreach ( $curr_cart as $index => $item ) {
			if ( ! empty( $item['domain'] ) && ! empty( $item['domaintype'] ) ) {
				if ( ! empty( $item['pid'] ) && $item['pid'] > 0 ) {
					continue;
				}
				$item_ext       = whcom_get_tld_from_domain( $item['domain'] );
				$item_domain    = str_replace( $item_ext, '', $item['domain'] );
				$curr_domains[] = [
					'cart_index'     => $index,
					'domain_name'    => $item_domain,
					'domain_ext'     => $item_ext,
					'domain_type'    => $item['domaintype'],
					'domain_product' => $item['pid']
				];
			}
		}

		if ( $domaintype == 'register' ) {
			$register_class      = 'active';
			$register_form_class = $on_load_class;
		}
		if ( $domaintype == 'register' ) {
			$transfer_class      = 'active';
			$transfer_form_class = $on_load_class;
		}
		if ( $domaintype == 'existing' ) {
			$existing_class      = 'active';
			$existing_form_class = $on_load_class;
		}


		ob_start(); ?>

        <div class="whcom_op_product_domain_container">
            <div class="whcom_page_heading ">
				<?php esc_html_e( 'Choose a Domain', 'whcom' ) ?>
            </div>
            <div class="whcom_op_product_domain_options">
				<?php if ( ! empty( $curr_domains ) ) { ?>
                    <div class="whcom_op_product_domain_option">
                        <div class="whcom_form_field">
                            <label class="whcom_radio <?php echo ( $domain_provided ) ? '' : 'whcom_checked'; ?>">
                                <input type="radio" value="domain_already_in_cart"
                                       name="whcom_op_product_domain_option_selector" <?php echo ( $domain_provided ) ? '' : 'checked="checked"'; ?>>
								<?php esc_html_e( 'Already in Cart', 'whcom' ) ?>
                            </label>
                        </div>
                        <div class="whcom_op_product_domain_option_form"
                             id="domain_already_in_cart" <?php echo ( $domain_provided ) ? 'style="display: none;"' : 'style="display: block;"'; ?>>
                            <form class="whcom_op_check_product_domain domain_already_in_cart" method="post">
                                <input type="hidden" name="check_domain" value="1">
                                <input type="hidden" name="action" value="whcom_op">
                                <input type="hidden" name="whcom_op_what" value="check_product_domain">
                                <div class="whcom_row whcom_row_no_gap">
                                    <div class="whcom_col_sm_9">
                                        <div class="whcom_form_field">
                                            <select name="domain"
                                                    title="<?php esc_html_e( 'Select a domain', 'whcom' ) ?>">
												<?php foreach ( $curr_domains as $curr_domain ) {
													if ( ! empty( $curr_domain['domain_product'] ) && $curr_domain['domain_product'] > 0 ) {
														continue;
													} ?>
                                                    <option value="<?php echo $curr_domain['domain_name']; ?>"
                                                            data-cart-index="<?php echo $curr_domain['cart_index'] ?>"
                                                            data-domain-tld="<?php echo $curr_domain['domain_ext'] ?>"
                                                            data-domain-type="<?php echo $curr_domain['domain_type'] ?>"
                                                    ><?php echo $curr_domain['domain_name'] ?><?php echo $curr_domain['domain_ext'] ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_3">
                                        <div class="whcom_form_field">
                                            <button type="submit"
                                                    class="whcom_button whcom_button_block"><?php esc_html_e( 'Use', 'whcom' ) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $whmcs_settings ) && ! empty( $whmcs_settings['AllowRegister'] ) && strtolower( $whmcs_settings['AllowRegister'] ) == 'on' ) { ?>
                    <div class="whcom_op_product_domain_option">
                        <div class="whcom_form_field">
                            <label class="whcom_radio <?php echo ( $domaintype == 'register' && empty( $curr_domains ) ) ? 'whcom_checked' : ''; ?>">
                                <input type="radio" value="domain_register"
                                       name="whcom_op_product_domain_option_selector" <?php echo ( $domaintype == 'register' && empty( $curr_domains ) ) ? 'checked="checked"' : ''; ?>>
								<?php esc_html_e( 'Register a new domain', 'whcom' ) ?>
                            </label>
                        </div>
                        <div class="whcom_op_product_domain_option_form" id="domain_register"
                             style="display: <?php echo ( $domaintype == 'register' && empty( $curr_domains ) ) ? 'block' : 'none'; ?>;">
                            <form class="whcom_op_check_product_domain <?php echo ( $domaintype == 'register' && $domain_provided ) ? 'whcom_op_submit_on_load' : ''; ?>"
                                  method="post">
                                <input type="hidden" name="check_domain" value="1">
                                <input type="hidden" name="domaintype" value="register">
                                <input type="hidden" name="action" value="whcom_op">
                                <input type="hidden" name="whcom_op_what" value="check_product_domain">
                                <div class="whcom_row whcom_row_no_gap">
                                    <div class="whcom_col_sm_7">
                                        <div class="whcom_form_field">
	                                        <span class="whcom_form_field_addon">www.</span>
                                            <input required="required" type="search" name="domain"
                                                   title="<?php esc_html_e( 'Domain Name', 'whcom' ) ?>"
                                                   value="<?php echo $sld; ?>" placeholder="<?php esc_html_e('example', 'whcom')?>">
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_form_field">
                                            <select name="ext" title="Select TLD">
												<?php
												if ( ! empty ( $domains_list ) && is_array( $domains_list ) ) {
													foreach ( $domains_list as $tld => $det ) {
														$selected = ( $tld == $tld_req ) ? 'selected' : '';
														echo '<option value="' . $tld . '" ' . $selected . '>' . $tld . '</option>';
													}
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_3">
                                        <div class="whcom_form_field">
                                            <button type="submit"
                                                    class="whcom_button whcom_button_block"><?php esc_html_e( 'Check', 'whcom' ) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $whmcs_settings ) && ! empty( $whmcs_settings['AllowTransfer'] ) && strtolower( $whmcs_settings['AllowTransfer'] ) == 'on' ) { ?>
                    <div class="whcom_op_product_domain_option">
                        <div class="whcom_form_field">
                            <label class="whcom_radio <?php echo ( $domaintype == 'transfer' && empty( $curr_domains ) ) ? 'whcom_checked' : ''; ?>">
                                <input type="radio" value="domain_transfer"
                                       name="whcom_op_product_domain_option_selector" <?php echo ( $domaintype == 'transfer' && empty( $curr_domains ) ) ? 'checked="checked"' : ''; ?>>
								<?php esc_html_e( 'Transfer your domain from another registrar', 'whcom' ) ?>
                            </label>
                        </div>
                        <div class="whcom_op_product_domain_option_form" id="domain_transfer"
                             style="display: <?php echo ( $domaintype == 'transfer' && empty( $curr_domains ) ) ? 'block' : 'none'; ?>;">
                            <form class="whcom_op_check_product_domain <?php echo ( $domaintype == 'transfer' && $domain_provided ) ? 'whcom_op_submit_on_load' : ''; ?>"
                                  method="post">
                                <input type="hidden" name="check_domain" value="1">
                                <input type="hidden" name="domaintype" value="transfer">
                                <input type="hidden" name="action" value="whcom_op">
                                <input type="hidden" name="whcom_op_what" value="check_product_domain">
                                <div class="whcom_row whcom_row_no_gap">
                                    <div class="whcom_col_sm_7">
                                        <div class="whcom_form_field">
	                                        <span class="whcom_form_field_addon">www.</span>
                                            <input required="required" type="search" name="domain" id="search_domain"
                                                   title="Search Domain" value="<?php echo $sld; ?>" placeholder="<?php esc_html_e('example', 'whcom')?>">
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_form_field">
                                            <select name="ext" id="search_ext" title="Select TLD">
												<?php
												if ( ! empty ( $domains_list ) && is_array( $domains_list ) ) {
													foreach ( $domains_list as $tld => $det ) {
														$selected = ( $tld == $tld_req ) ? 'selected' : '';
														echo '<option value="' . $tld . '" ' . $selected . '>' . $tld . '</option>';
													}
												}
												?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_3">
                                        <div class="whcom_form_field">
                                            <button type="submit"
                                                    class="whcom_button whcom_button_block"><?php esc_html_e( 'Transfer', 'whcom' ) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				<?php } ?>
				<?php if ( ! empty( $whmcs_settings ) && ! empty( $whmcs_settings['AllowOwnDomain'] ) && strtolower( $whmcs_settings['AllowOwnDomain'] ) == 'on' ) { ?>
                    <div class="whcom_op_product_domain_option">
                        <div class="whcom_form_field">
                            <label class="whcom_radio <?php echo ( $domaintype == 'existing' && empty( $curr_domains ) ) ? 'whcom_checked' : ''; ?>">
                                <input type="radio" value="domain_existing"
                                       name="whcom_op_product_domain_option_selector" <?php echo ( $domaintype == 'existing' && empty( $curr_domains ) ) ? 'checked="checked"' : ''; ?>>
								<?php esc_html_e( 'I will use my existing domain and update my nameservers', 'whcom' ) ?>
                            </label>
                        </div>
                        <div class="whcom_op_product_domain_option_form" id="domain_existing"
                             style="display: <?php echo ( $domaintype == 'existing' && empty( $curr_domains ) ) ? 'block' : 'none'; ?>;">
                            <form class="whcom_op_check_product_domain <?php echo ( $domaintype == 'existing' && $domain_provided ) ? 'whcom_op_submit_on_load' : ''; ?>"
                                  method="post">
                                <input type="hidden" name="check_domain" value="1">
                                <input type="hidden" name="domaintype" value="existing">
                                <input type="hidden" name="action" value="whcom_op">
                                <input type="hidden" name="whcom_op_what" value="check_product_domain">
                                <div class="whcom_row whcom_row_no_gap">
                                    <div class="whcom_col_sm_7">
                                        <div class="whcom_form_field">
	                                        <span class="whcom_form_field_addon">www.</span>
                                            <input required="required" type="search" name="domain" id="search_domain"
                                                   title="Domain Name" value="<?php echo $sld; ?>" placeholder="<?php esc_html_e('example', 'whcom')?>">
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_2">
                                        <div class="whcom_form_field">
                                            <input type="text" name="ext" required="required" id="search_ext"
                                                   title="Enter TLD" value="<?php echo $tld_req; ?>" placeholder="<?php esc_html_e('.com', 'whcom')?>">
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_3">
                                        <div class="whcom_form_field">
                                            <button type="submit"
                                                    class="whcom_button whcom_button_block"><?php esc_html_e( 'Use', 'whcom' ) ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				<?php } ?>
            </div>
            <div class="whcom_op_domain_response"></div>
        </div>

		<?php return ob_get_clean();
	}
}

if ( ! function_exists( 'whcom_get_domain_clean' ) ) {
	function whcom_get_domain_clean( $domain ) {
		$domain = ltrim( $domain, '//' );

		if ( substr( strtolower( $domain ), 0, 7 ) == "http://" ) {
			$domain = substr( $domain, 7 );
		}
		if ( substr( strtolower( $domain ), 0, 8 ) == "https://" ) {
			$domain = substr( $domain, 8 );
		}
		$domain = "http://" . $domain;
		$domain = parse_url( $domain );
		if ( strtolower( substr( $domain["host"], 0, 4 ) ) == "www." ) {
			$domain["host"] = substr( $domain["host"], 4 );
		}
		if ( strtolower( substr( $domain["host"], 0, 3 ) ) == "ww." ) {
			$domain["host"] = substr( $domain["host"], 3 );
		}

		return $domain['host'];
	}
}

if ( ! function_exists( 'whcom_render_free_domain_billingcycles' ) ) {
	function whcom_render_free_domain_billingcycles ($billingcycles_list = '') {
        $return_string = '';
        $billingcycles_array = (is_array($billingcycles_list)) ? $billingcycles_list : explode(',', $billingcycles_list);
        $counter = 0;
        $length = count($billingcycles_array);
        foreach ($billingcycles_array as $billingcycle) {
            if (is_string($billingcycle)) {
                $return_string .= whcom_convert_billingcycle($billingcycle);
                if ($counter != $length - 1) {
                    $return_string .= ', ';
                }
	            $counter++;
            }
        }
        return $return_string;
	}
}

if ( ! function_exists( 'whcom_render_free_domain_tlds' ) ) {
	function whcom_render_free_domain_tlds ($billingcycles_list = '') {
		$return_string = '';
		$billingcycles_array = (is_array($billingcycles_list)) ? $billingcycles_list : explode(',', $billingcycles_list);
		$counter = 0;
		$length = count($billingcycles_array);
		foreach ($billingcycles_array as $billingcycle) {
			if (is_string($billingcycle)) {
				$return_string .= $billingcycle;
				if ($counter != $length - 1) {
					$return_string .= ', ';
				}
				$counter++;
			}
		}
		return $return_string;
	}
}


/*if ( ! function_exists( 'whcom_check_free_domain' ) ) {
	//	function whcom_check_free_domain($product, $billingcycle, $tld) {
	//
	//	}
}*/
