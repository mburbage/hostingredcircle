<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


if ( ! function_exists( 'whcom_add_cart_item_ajax' ) ) {
    function whcom_add_update_cart_item_ajax() {
        $response = whcom_add_update_cart_item( $_POST );
        echo json_encode( $response, JSON_FORCE_OBJECT );
        die();
    }

    add_action( 'wp_ajax_whcom_add_cart_item_ajax', 'whcom_add_cart_item_ajax' );
    add_action( 'wp_ajax_nopriv_whcom_add_cart_item_ajax', 'whcom_add_cart_item_ajax' );
}

if ( ! function_exists( 'whcom_currency_updater_item' ) ) {
    function whcom_currency_updater_item() {
        $response = [
            'status' => 's'
        ];
        if ( ! empty( $_POST['currency_id'] ) && $_POST['currency_id'] > 0 ) {
            $response['status'] = whcom_update_current_currency( $_POST['currency_id'] );
        }
        echo json_encode( $response, JSON_FORCE_OBJECT );
        die();
    }

    add_action( 'wp_ajax_whcom_currency_updater_item', 'whcom_currency_updater_item' );
    add_action( 'wp_ajax_nopriv_whcom_currency_updater_item', 'whcom_currency_updater_item' );
}

if ( ! function_exists( 'whcom_process_logout' ) ) {
    function whcom_process_logout() {
        $response = [];
        if ( whcom_client_log_out() && whcom_reset_cart() ) {
            $response['status']  = 'OK';
            $response['message'] = esc_html__( "Client Logged Out", "whcom" );
        }
        else {
            $response['status']  = 'ERROR';
            $response['message'] = esc_html__( "There was some issue", "whcom" );
        }
        echo json_encode( $response, JSON_FORCE_OBJECT );
        die();
    }

    add_action( 'wp_ajax_whcom_process_logout', 'whcom_process_logout' );
    add_action( 'wp_ajax_nopriv_whcom_process_logout', 'whcom_process_logout' );
}

if ( ! function_exists( 'whcom_op' ) ) {
    function whcom_op() {
        $whcom_what = ( ! empty( $_POST['whcom_op_what'] ) ) ? esc_attr( $_POST['whcom_op_what'] ) : 'nothing';
        $response   = [];
        switch ( $whcom_what ) {
            case 'add_remove_domain_whmp' :
                {
                    $domain_action  = ( ! empty( $_POST['domain_action'] ) ) ? esc_attr( $_POST['domain_action'] ) : '';
                    $cart_index     = ( isset( $_POST['cart_index'] ) ) ? esc_attr( $_POST['cart_index'] ) : - 1;
                    $domain         = ( ! empty( $_POST['domain'] ) ) ? esc_attr( $_POST['domain'] ) : '';
                    $domaintype     = ( ! empty( $_POST['domaintype'] ) ) ? esc_attr( $_POST['domaintype'] ) : '';
                    $regperiod      = ( ! empty( $_POST['regperiod'] ) ) ? esc_attr( $_POST['regperiod'] ) : '';
                    $domain_details = [
                        'domain'     => $domain,
                        'regperiod'  => $regperiod,
                        'domaintype' => $domaintype
                    ];
                    if ( $domain_action == 'add_domain' ) {
                        $tld_details = whcom_get_tld_details(whcom_get_tld_from_domain($domain));
                        if (!empty($tld_details)) {
                            $response = whcom_add_update_cart_item( $domain_details, $cart_index );
                        }
                        else {
                            $response['message'] = esc_html__( 'Domain Details not found', 'whcom' );
                        }
                    }
                    else if ( $domain_action == 'remove_domain' ) {
                        $response = whcom_delete_cart_item( $cart_index );
                    }
                    else {
                        $response['message'] = esc_html__( 'No Proper Domain Action Selected', 'whcom' );
                    }
                    $response['post']           = $_POST;
                    $response['domain_details'] = $domain_details;
                    break;
                }
            case 'check_domain' :
                {
                    $response                  = whcom_check_domain_function( $_POST );
                    $response['response_form'] = '';
                    $domain_ext                = ( ! empty( $_POST['ext'] ) ) ? esc_attr( $_POST['ext'] ) : '';
                    $domain_name_unclean       = ( ! empty( $_POST['domain'] ) ) ? esc_attr( $_POST['domain'] ) : '';
                    $domain_name               = str_replace(' ', '', $domain_name_unclean);
                    $domain_type               = ( ! empty( $_POST['domaintype'] ) ) ? esc_attr( $_POST['domaintype'] ) : '';
                    $tld_details               = whcom_get_tld_details( $domain_ext );
                    $tld_price                 = '';

                    if ( ! empty( $tld_details[ $domain_type . '_price' ] ) ) {
                        ob_start(); ?>
                        <select name="regperiod" class="whcom_button whcom_button_secondary whcom_button_small"
                                title="Domain Duration">
                            <?php foreach ( $tld_details[ $domain_type . '_price' ] as $dur => $price ) { ?>
                                <?php if ( $price >= 0 ) {
                                    $dur_txt = esc_html__( 'For', 'whcom' );
                                    $dur_txt .= ' ' . $dur . ' ';
                                    $dur_txt .= ( $dur == 1 ) ? esc_html__( 'Year', 'whcom' ) : esc_html__( 'Years', 'whcom' );
                                    echo '<option value="' . $dur . '">' . whcom_format_amount( [
                                            'amount'     => $price,
                                            'add_suffix' => 'yes'
                                        ] ) . ' ' . $dur_txt . '</option>';
                                    if ( $domain_type == 'transfer' ) {
                                        break;
                                    }

                                } ?>
                            <?php } ?>
                        </select>
                        <?php $tld_price = ob_get_clean(); ?>
                    <?php }
                    switch ( $domain_type ) {
                        case 'register' :
                            {
                                if ( $response['status'] == 'OK' ) {
                                    ob_start() ?>
                                    <form class="whcom_op_add_domain_to_cart" method="post">
                                        <input type="hidden" name="domain" value="<?php echo $response['domain'] ?>">
                                        <input type="hidden" name="ext" value="<?php echo $response['ext'] ?>">
                                        <input type="hidden" name="domaintype" value="register">
                                        <input type="hidden" name="action" value="whcom_op">
                                        <input type="hidden" name="whcom_op_what" value="add_domain">
                                        <div class="whcom_text_center whcom_text_success whcom_text_2x">
                                            <?php esc_html_e( 'Congratulations', 'whcom' ) ?>!
                                            <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e( 'is available', 'whcom' ) ?>
                                            !
                                        </div>
                                        <div class="whcom_text_center whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Continue to register this domain for', 'whcom' ) ?>
                                            <?php echo $tld_price; ?>
                                        </div>
                                        <div class="whcom_op_domain_config_response_text"></div>
                                        <div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
                                            <button type="submit"><?php esc_html_e( 'Add to Cart', 'whcom' ) ?></button>
                                        </div>
                                    </form>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                else {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e( 'is unavailable', 'whcom' ) ?>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'transfer' :
                            {
                                if ( $response['status'] == 'OK' ) {
                                    ob_start() ?>
                                    <form class="whcom_op_add_domain_to_cart" method="post">
                                        <input type="hidden" name="domain" value="<?php echo $response['domain'] ?>">
                                        <input type="hidden" name="ext" value="<?php echo $response['ext'] ?>">
                                        <input type="hidden" name="domaintype" value="transfer">
                                        <input type="hidden" name="action" value="whcom_op">
                                        <input type="hidden" name="whcom_op_what" value="add_domain">
                                        <div class="whcom_text_success whcom_margin_bottom_30 whcom_text_center">
                                            <div class="whcom_margin_bottom_15 whcom_text_2x">
                                                <?php esc_html_e( 'Your domain is eligible for transfer', 'whcom' ) ?>!
                                            </div>
                                            <?php esc_html_e( 'Please ensure you have unlocked your domain at your current registrar before continuing.', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_text_center whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Transfer to us and extend by', 'whcom' ) ?>
                                            <?php echo $tld_price; ?>
                                        </div>
                                        <div class="whcom_op_domain_config_response_text"></div>
                                        <div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
                                            <button type="submit"><?php esc_html_e( 'Add to Cart', 'whcom' ) ?></button>
                                        </div>
                                    </form>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                else {
                                    ob_start() ?>
                                    <div class="whcom_alert whcom_text_center">
                                        <div class="whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                            <?php esc_html_e( 'Not Eligible for Transfer', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'The domain you entered does not appear to be registered.', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'If the domain was registered recently, you may need to try again later.', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Alternatively, you can perform a search to register this domain.', 'whcom' ) ?>
                                        </div>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                    }
                    break;
                }
            case 'add_domain' :
                {
                    $response = whcom_add_update_cart_item( $_POST );
                    if ( $response['status'] == 'OK' ) {
                        $response['redirect_url'] = whcom_get_order_url() . '&a=confdomains';
                    }
                    break;
                }
            case 'domain_renewals' :
                {
                    $order_array   = [
                        'domainrenewals' => []
                    ];
                    $names_array   = ( ! empty( $_POST['domainrenewals-name'] ) && is_array( $_POST['domainrenewals-name'] ) ) ? $_POST['domainrenewals-name'] : [];
                    $periods_array = ( ! empty( $_POST['domainrenewals-period'] ) && is_array( $_POST['domainrenewals-period'] ) ) ? $_POST['domainrenewals-period'] : [];

                    foreach ( $names_array as $name => $value ) {
                        if ( strtolower( $value ) == 'on' && ! empty( $periods_array[ $name ] ) ) {
                            $domain_renewal                = [ (string) $name => (int) $periods_array[ $name ] ];
                            $order_array['domainrenewals'] = array_merge( $order_array['domainrenewals'], $domain_renewal );
                        }
                    }

                    if ( empty( $order_array['domainrenewals'] ) ) {
                        $response['message'] = esc_html__( "No Valid domains submitted", "whcom" );

                    }
                    else {
                        $order_array['cart_index'] = 0;
                        $response                  = whcom_add_update_cart_item( $order_array );
                    }

                    $response['current_cart'] = whcom_get_cart();
                    if ( $response['status'] == 'OK' ) {
                        $response['redirect_url'] = whcom_get_order_url() . '&a=view';
                    }
                    break;
                }
            case 'check_product_domain' :
                {
                    $response    = whcom_check_domain_function( $_POST );
                    $cart_index  = ( isset( $_POST['cart_index'] ) && $_POST['cart_index'] > - 1 ) ? (int) $_POST['cart_index'] : '-1';
                    $domain_ext  = ( ! empty( $_POST['ext'] ) ) ? esc_attr( $_POST['ext'] ) : '';
                    $domain_ext  = "." . ltrim( $domain_ext, "." );
                    $domain_name_unclean = ( ! empty( $_POST['domain'] ) ) ? esc_attr( $_POST['domain'] ) : '';
                    $domain_name = str_replace(' ', '', $domain_name_unclean);
                    $domain_type = ( ! empty( $_POST['domaintype'] ) ) ? esc_attr( $_POST['domaintype'] ) : '';


                    $tld_details = whcom_get_tld_details( $domain_ext );
                    $tld_price   = '';
                    if ( ! empty( $tld_details[ $domain_type . '_price' ] ) ) {
                        ob_start(); ?>
                        <select name="regperiod" class="whcom_button whcom_button_secondary whcom_button_small"
                                title="Domain Duration">
                            <?php foreach ( $tld_details[ $domain_type . '_price' ] as $dur => $price ) { ?>
                                <?php if ( $price >= 0 ) {
                                    $dur_txt = esc_html__( 'For', 'whcom' );
                                    $dur_txt .= ' ' . $dur . ' ';
                                    $dur_txt .= ( $dur == 1 ) ? esc_html__( 'Year', 'whcom' ) : esc_html__( 'Years', 'whcom' );
                                    echo '<option value="' . $dur . '">' . whcom_format_amount( [
                                            'amount'     => $price,
                                            'add_suffix' => 'yes'
                                        ] ) . ' ' . $dur_txt . '</option>';
                                    if ( $domain_type == 'transfer' ) {
                                        break;
                                    }

                                } ?>
                            <?php } ?>
                        </select>
                        <?php $tld_price = ob_get_clean(); ?>
                    <?php }
                    $response['domaintype'] = $domain_type;
                    switch ( $domain_type ) {
                        case 'register' :
                            {
                                if ( $response['status'] == 'OK' ) {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_text_success whcom_text_2x">
                                        <?php esc_html_e( 'Congratulations', 'whcom' ) ?>!
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e( 'is available', 'whcom' ) ?>
                                        !
                                    </div>
                                    <form class="whcom_op_attach_product_domain whcom_text_center_xs" method="post">
                                        <div class="whcom_text_center whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Continue to register this domain for', 'whcom' ) ?>
                                            <?php echo $tld_price; ?>
                                        </div>
                                        <input type="hidden" name="action" value="whcom_op">
                                        <input type="hidden" name="whcom_op_what" value="attach_domain">
                                        <input type="hidden" name="cart_index" value="<?php echo $cart_index; ?>">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e( 'Continue', 'whcom' ) ?></strong></button>
                                    </form>
                                    <?php $response['domain_attachment_form'] = ob_get_clean();
                                }
                                else {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e( 'is unavailable', 'whcom' ) ?>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'transfer' :
                            {
                                if ( $response['status'] == 'OK' ) {
                                    ob_start() ?>
                                    <div class="whcom_alert whcom_alert_success whcom_text_center whcom_margin_bottom_15">
                                        <div class="whcom_margin_bottom_15 whcom_text_success whcom_text_2x">
                                            <?php esc_html_e( 'Your domain is eligible for transfer', 'whcom' ) ?>!
                                        </div>
                                        <?php esc_html_e( 'Please ensure you have unlocked your domain at your current registrar before continuing.', 'whcom' ) ?>
                                    </div>
                                    <form class="whcom_op_attach_product_domain whcom_text_center_xs" method="post">
                                        <div class="whcom_text_center whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Transfer to us and extend by', 'whcom' ) ?>
                                            <?php echo $tld_price; ?>
                                        </div>
                                        <input type="hidden" name="action" value="whcom_op">
                                        <input type="hidden" name="whcom_op_what" value="attach_domain">
                                        <input type="hidden" name="cart_index" value="<?php echo $cart_index; ?>">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e( 'Continue', 'whcom' ) ?></strong></button>
                                    </form>
                                    <?php $response['domain_attachment_form'] = ob_get_clean();
                                }
                                else {
                                    ob_start() ?>
                                    <div class="whcom_alert whcom_text_center">
                                        <div class="whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                            <?php esc_html_e( 'Not Eligible for Transfer', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'The domain you entered does not appear to be registered.', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'If the domain was registered recently, you may need to try again later.', 'whcom' ) ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e( 'Alternatively, you can perform a search to register this domain.', 'whcom' ) ?>
                                        </div>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'existing' :
                            {
                                ob_start() ?>
                                <form class="whcom_op_attach_product_domain whcom_text_center_xs" method="post">
                                    <input type="hidden" name="action" value="whcom_op">
                                    <input type="hidden" name="whcom_op_what" value="attach_domain">
                                    <input type="hidden" name="cart_index" value="<?php echo $cart_index; ?>">
                                    <input type="hidden" name="domain"
                                           value="<?php echo $domain_name . $domain_ext; ?>">
                                    <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                    <button type="submit" class="whcom_button whcom_button_success">
                                        <strong><?php esc_html_e( 'Continue', 'whcom' ) ?></strong></button>
                                </form>
                                <?php $response['domain_attachment_form'] = ob_get_clean();
                                break;
                            }
                    }
                    break;
                }
            case 'attach_domain' :
                {
                    $response    = [
                        'status'  => 'ERROR',
                        'message' => esc_html__( "Something went wrong, reloading the page...", "whcom" ),
                    ];
                    $cart_index  = ( isset( $_POST['cart_index'] ) && $_POST['cart_index'] > - 1 ) ? (int) $_POST['cart_index'] : '-1';
                    $domain_name = ( ! empty( $_POST['domain'] ) ) ? esc_attr( $_POST['domain'] ) : '';
                    $domain_type = ( ! empty( $_POST['domaintype'] ) ) ? esc_attr( $_POST['domaintype'] ) : '';
                    if ( $domain_type == 'existing' ) {
                        $response['domain_config_form'] .= '<input type="hidden" name="attached_domain" value="yes">';
                        $response['domain_config_form'] .= '<input type="hidden" name="domain" value="' . $domain_name . '">';
                        $response['domain_config_form'] .= '<input type="hidden" name="domaintype" value="existing">';
                        $response['status']             = 'OK';
                        $response['message']            = '<div class="whcom_alert whcom_alert_success">' . esc_html__( 'Domain is attached with product...', 'whcom' ) . '</div>';
                    }
                    else {
                        $response = whcom_add_update_cart_item( $_POST );
                        if ( $response ) {
                            $response['domain_config_form'] .= '<input type="hidden" name="attached_domain" value="yes">';
                            $response['domain_config_form'] .= "<input type='hidden' name='cart_index' value='" . $response['cart_index'] . "'>";
                            $response['status']             = 'OK';
                            $response['message']            = '<div class="whcom_alert whcom_alert_success">' . esc_html__( 'Domain is attached with product...', 'whcom' ) . '</div>';
                        }
                    }
                    break;
                }

            case 'change_billingcycle' :
                {
                    if ( ! empty( $_POST['pid'] ) ) {
                        $billing_cycle   = esc_attr( $_POST['billingcycle'] );
                        $product_details = whcom_get_product_details( (int) $_POST['pid'] );
                        if ( ( empty( $billing_cycle ) ) && ( ! empty( $product_details['lowest_price'] ) ) ) {
                            reset( $product_details['lowest_price'] );
                            $billing_cycle = key( $product_details['lowest_price'] );
                        }
                        if ( $product_details ) {
                            $response['status'] = 'OK';
                            ob_start();
                            if ( ! empty( $product_details['prd_configoptions'] ) ) {
                                echo whcom_render_product_config_options( $product_details, - 1, $billing_cycle );
                            }
                            $response['options_html'] = ob_get_clean();
                        }
                        else {
                            $response['message'] = esc_html__( "Wrong Product ID provided", "wcop" );
                            $response['status']  = 'ERROR';
                        }
                    }
                    else {
                        $response['message'] = esc_html__( "Wrong Product ID provided", "wcop" );
                        $response['status']  = 'ERROR';
                    }

                    break;
                }
            case 'add_product' :
                {
                    if ( ! empty ( $_POST['required_domain'] ) ) {
                        if ( $_POST['required_domain'] == 'yes' && empty( $_POST['attached_domain'] ) ) {
                            $response = [
                                'status'  => 'ERROR',
                                'message' => esc_html__( 'Domain is required with this package, kindly attach a domain using above options', 'whcom' )
                            ];
                        }
                        else {
                            $response     = whcom_add_update_cart_item( $_POST );
                            $conf_domains = false;
                            $current_cart = whcom_get_cart()['all_items'];
                            foreach ( $current_cart as $cart_item ) {
                                if ( ! empty( $cart_item['domain'] ) ) {
                                    $conf_domains = true;
                                    break;
                                }
                            }
                            if ( $conf_domains ) {
                                $response['redirect_url'] = whcom_get_order_url() . '&a=confdomains';
                            }
                            else {
                                $response['redirect_url'] = whcom_get_order_url() . '&a=view';
                            }
                        }
                    }
                    else {
                        $response = [
                            'status'  => 'ERROR',
                            'message' => esc_html__( 'Add product form has some issue in it.', 'whcom' )
                        ];
                    }
                    break;
                }

            case 'domains_config' :
                {
                    whcom_update_cart_domains();
                    $response['current_cart'] = whcom_get_cart();
                    $response['redirect_url'] = whcom_get_order_url() . '&a=view';
                    $response['message']      = esc_html__( "Loading Client Form", "whcom" );
                    $response['status']       = 'OK';
                    break;
                }
            case 'product_summary' :
                {
                    $product_id = ( ! empty( $_POST['pid'] ) && $_POST['pid'] > 0 ) ? $_POST['pid'] : 0;
                    if ( $product_id > 0 ) {
                        $response['summary_html'] = whcom_op_generate_current_product_summery_function( $_POST );
                        $response['status']       = 'OK';
                        $response['message']      = esc_html__( 'Repopulating product Summary', 'whcom' );
                    }
                    break;
                }
            case 'cart_summaries' :
                {
                    $response = whcom_generate_cart_summaries();
                    break;
                }
            case 'review' :
                {
                    $response['status']       = 'OK';
                    $response['message']      = esc_html__( 'Redirecting to Checkout Page', 'whcom' );
                    $response['redirect_url'] = whcom_get_order_url() . '&a=checkout';
                    break;
                }
            case 'checkout' :
                {
                    $client_id = false;

                    if ( whcom_is_client_logged_in() ) {
                        $client_id           = whcom_get_current_client_id();
                        $response['message'] = esc_html__( "Client is already logged in", "whcom" );
                    }
                    else {
                        // Validate/Register Client
                        if ( ! empty( $_POST['whcom_op_client_type'] ) ) {
                            if ( esc_attr( $_POST['whcom_op_client_type'] ) == 'register' ) {
                                $response['message'] = esc_html__( "Registering New Client", "whcom" );
                                $temp_response       = whcom_register_new_client( $_POST );
                                if ( $temp_response['status'] == 'OK' ) {
                                    $client_id = whcom_get_current_client_id();
                                }
                                else {
                                    $response = $temp_response;
                                }
                            }
                            else {
                                $response['message'] = esc_html__( "Validating Client", "whcom" );
                                $credentials         = [
                                    'email' => ( ! empty( $_POST['login_email'] ) ) ? esc_attr( $_POST['login_email'] ) : '',
                                    'pass'  => ( ! empty( $_POST['login_pass'] ) ) ? esc_attr( $_POST['login_pass'] ) : '',
                                ];
                                $temp_response       = whcom_validate_client( $credentials );
                                $response['rrcit']   = $temp_response;
                                if ( $temp_response['status'] == 'OK' ) {
                                    $client_id = whcom_get_current_client_id();
                                }
                                else {
                                    $response = $temp_response;
                                }
                            }
                        }
                    }


                    // Add Order
                    if ( $client_id && (int) $client_id > 0 ) {
                        $settings  = whcom_get_whmcs_setting();
                        $accepttos = ( ! empty( $settings ) && ! empty( $settings['EnableTOSAccept'] ) && (string) $settings['EnableTOSAccept'] == 'on' ) ? true : false;
                        if ( $accepttos && empty( $_POST['accepttos'] ) ) {
                            $response['status']  = 'ERROR';
                            $response['message'] = whcom_format_error_message( esc_html__( 'You must accept our Terms of Service' ) );
                        }
                        else {
                            unset( $_POST['customfields'] );
                            whcom_add_update_cart_item( $_POST );
                            $response = whcom_submit_order();
                            if ( ! empty( $response['result'] ) ) {
                                if ( $response['result'] == 'success' ) {
                                    $response['status']        = 'OK';
                                    $response['message']       = esc_html__( 'Your product has been ordered...' );
                                    $response['redirect_link'] = $response['response_form'] = $response['invoice_link'] = $response['show_cc'] = '';
                                    # Generate AutoAuth URL & Redirect
                                    $args = [
                                        'goto' => "viewinvoice.php?wcap_no_redirect=1&id=" . $response['invoiceid'],
                                    ];
                                    $url  = whcom_generate_auto_auth_link( $args );


                                    $is_wcop = ( ! empty( $_POST['is_wcop'] ) && (string) $_POST['is_wcop'] == 'yes' ) ? true : false;
                                    if ( $is_wcop ) {

                                        $field                     = 'order_complete_redirect' . whcom_get_current_language();
                                        $response['redirect_link'] = '<a href="' . esc_attr( get_option( $field ) ) . '" class="whcom_button">' . esc_html__( 'Dashboard', 'whcom' ) . '</a> ';

                                        $order_complete_url = get_option( 'order_complete_redirect' . whcom_get_current_language(), home_url( '/' ) );

                                        if ( get_option( 'wcop_show_invoice_as', 'popup' ) == 'minimal' ) {
                                            $response['invoice_link'] = '<a href="' . $url . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else if ( get_option( 'wcop_show_invoice_as', 'popup' ) == 'same_tab' ) {
                                            $response['invoice_link'] = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else if ( get_option( 'wcop_show_invoice_as', 'popup' ) == 'new_tab' ) {
                                            $response['invoice_link'] = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else {
                                            $redirect_link            = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__( 'Close', 'whcom' ) . '</a> ';
                                            $invoice_div              = '<div id="invoice_' . $response['invoiceid'] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
                                            $invoice_anchor           = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $response['invoiceid'] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', 'whcom' ) . '</a> ';
                                            $response['invoice_link'] = $invoice_anchor . $invoice_div;
                                        }
                                    }
                                    else {
                                        $response['redirect_link'] = '<a href="?whmpca=dashboard" class="whcom_button">' . esc_html__( 'Dashboard', 'whcom' ) . '</a> ';
                                        $order_complete_url        = get_option( 'wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard' );
                                        if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'minimal' ) {
                                            $response['invoice_link'] = '<a href="' . $url . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'same_tab' ) {
                                            $response['invoice_link'] = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else if ( get_option( 'wcapfield_show_invoice_as', 'popup' ) == 'new_tab' ) {
                                            $response['invoice_link'] = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', "whcom" ) . '</a> ';
                                        }
                                        else {
                                            $redirect_link            = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__( 'Close', 'whcom' ) . '</a> ';
                                            $invoice_div              = '<div id="invoice_' . $response['invoiceid'] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
                                            $invoice_anchor           = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $response['invoiceid'] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__( 'Review Invoice & Pay', 'whcom' ) . '</a> ';
                                            $response['invoice_link'] = $invoice_anchor . $invoice_div;
                                        }
                                    }

                                    ob_start();
                                    echo whcom_render_order_complete_message($response['redirect_link'], $response['invoice_link']);
                                    $response['response_html'] = ob_get_clean();
                                }
                                else {
                                    $response['status']  = 'ERROR';
                                    $response['message'] = '<div class="whcom_alert whcom_alert_danger">' . $response['message'] . '</div>';
                                }
                            }
                        }
                    }

                    break;
                }

            case 'order_addon' :
                {
                    $response = whcom_add_update_cart_item( $_POST );
                    if ( $response['status'] == 'OK' ) {
                        $response['redirect_url'] = whcom_get_order_url() . '&a=view';
                    }
                    break;
                }

            case 'reset_cart' :
                {
                    whcom_reset_cart();
                    $response = [
                        'status'  => "OK",
                        'message' => esc_html__( 'Cart is emptied, reloading the page', 'whcom' ),
                    ];
                    break;
                }
            case 'delete_cart_item' :
                {
                    $cart_index = esc_attr( $_POST['cart_index'] );
                    $response   = whcom_delete_cart_item( $cart_index );
                    break;
                }

            case 'apply_remove_promo_code' :
                {
                    $promo_code = ( ! empty( $_POST['promocode'] ) ) ? esc_attr( $_POST['promocode'] ) : '';
                    if ( ! empty( $promo_code ) && ( $promo_code == 'to_unset_string' || ! empty( whcom_get_promotion( (string) $promo_code ) ) ) ) {
                        $res = whcom_add_update_cart_item( [
                            'cart_index' => '0',
                            'promocode'  => $promo_code,
                        ] );
                        if ( $res ) {
                            $response = [
                                'status'  => "OK",
                                'message' => esc_html__( 'Promo Code Applied', 'whcom' ),
                            ];
                        }
                    }
                    else {
                        $response = [
                            'status'  => "ERROR",
                            'message' => esc_html__( 'The promotion code entered does not exist', 'whcom' ),
                        ];
                    }
                    break;
                }

            case 'estimate_taxes' :
                {
                    $country = ( isset( $_POST['country'] ) ) ? esc_attr( $_POST['country'] ) : '';
                    $state   = ( isset( $_POST['state'] ) ) ? esc_attr( $_POST['state'] ) : '';
                    $_SESSION['whcom_tax_default_country'] = $country;
                    $_SESSION['whcom_tax_default_state'] = $state;
                    $response = [
                        'status'  => "OK",
                        'message' => esc_html__( 'Taxes estimated, reloading page', 'whcom' ),
                    ];
                    break;
                }

            default :
                {
                    $response['message'] = esc_html__( "Something went wrong, kindly try again later ...", "whcom" );
                    $response['status']  = 'ERROR';
                }
        }

        echo json_encode( $response, JSON_FORCE_OBJECT );
        die();
    }

    add_action( 'wp_ajax_whcom_op', 'whcom_op' );
    add_action( 'wp_ajax_nopriv_whcom_op', 'whcom_op' );
}

if ( ! function_exists( 'whcom_ajax' ) ) {
    function whcom_ajax() {
        $whcom_what = ( ! empty( $_POST['whcom_ajax_what'] ) ) ? esc_attr( $_POST['whcom_ajax_what'] ) : 'nothing';
        $response   = [];
        switch ( $whcom_what ) {
            case 'client_login' :
                {

                    $response['message'] = esc_html__( "Validating Client", "whcom" );
                    $credentials         = [
                        'email' => ( ! empty( $_POST['login_email'] ) ) ? esc_attr( $_POST['login_email'] ) : '',
                        'pass'  => ( ! empty( $_POST['login_pass'] ) ) ? esc_attr( $_POST['login_pass'] ) : '',
                    ];
                    $response       = whcom_validate_client( $credentials );
                    if ( $response['status'] == 'OK' ) {
                        $response['redirect_url'] = ( ! empty( $_POST['redirect_url'] ) ) ? esc_url( $_POST['redirect_url'] ) : '';
                    }
                    break;
                }
            default :
                {
                    $response['message'] = esc_html__( "Something went wrong, kindly try again later ...", "whcom" );
                    $response['status']  = 'ERROR';
                }
        }

        echo json_encode( $response, JSON_FORCE_OBJECT );
        die();
    }

    add_action( 'wp_ajax_whcom_ajax', 'whcom_ajax' );
    add_action( 'wp_ajax_nopriv_whcom_ajax', 'whcom_ajax' );
}