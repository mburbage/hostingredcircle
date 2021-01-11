<?php defined('ABSPATH') or die("Cannot access pages directly.");

if (!function_exists('wcop_verify_purchase')) {
    // Verify Purchase Code
    function wcop_verify_purchase()
    {
        $verify_action = (!empty($_POST) && !empty($_POST['verify_action'])) ? esc_attr($_POST['verify_action']) : '';
        if ($verify_action == 'verify') {
            echo wcop_verify_purchase_function($_POST);
        } else if ($verify_action == 'un_verify') {
            echo wcop_un_verify_purchase_function($_POST);
        } else {
            echo esc_html__('Incorrect Information', 'whcom');
        }
        die();
    }

    add_action('wp_ajax_wcop_verify_purchase', 'wcop_verify_purchase');
}

if (!function_exists('wcop_sp_process')) {
    // Single Page (template) functions start from here
    function wcop_sp_process()
    {
        $wcop_what = (!empty($_POST['wcop_sp_what'])) ? esc_attr($_POST['wcop_sp_what']) : 'nothing';
        $response = [];
        $response['post'] = $_POST;
        switch ($wcop_what) {
            case 'check_domain' :
                {
                    $response = whcom_check_domain_function($_POST);
                    $domain_ext = (!empty($_POST['ext'])) ? esc_attr($_POST['ext']) : '';
                    $domain_ext = "." . ltrim($domain_ext, ".");
                    $domain_name = (!empty($_POST['domain'])) ? esc_attr($_POST['domain']) : '';
                    $domain_type = (!empty($_POST['domaintype'])) ? esc_attr($_POST['domaintype']) : '';
                    $billing_cycle = !empty($_POST['default_billingcycle']) ? $_POST['default_billingcycle'] : '';
                    $is_free_domain_attached = !empty($_POST['is_free_domain_attached']) ? $_POST['is_free_domain_attached'] : '';

                    $tld_details = whcom_get_tld_details($domain_ext);
                    //== get product details to confirm the searched doamin in free or not
                    $product_details = !empty($_POST['pid']) ? whcom_get_product_details((int)$_POST['pid']) : "";
                    //== Determine Either searched domain is free or not
                    $free_domain = false;
                    if (!empty($product_details['freedomainpaymentterms']) && !empty($product_details['freedomaintlds'])) {
                        if (in_array($domain_ext, explode(',', $product_details['freedomaintlds'])) && in_array($billing_cycle, explode(',', $product_details['freedomainpaymentterms']))) {
                            $free_domain = true;
                        }
                    }

                    $tld_price = '';
                    if (!empty($tld_details[$domain_type . '_price'])) {
                        foreach ($tld_details[$domain_type . '_price'] as $dur => $price) {
                            if ($price >= 0) {
                                $tld_price = (string)$dur . ' ';
                                $tld_price .= ($dur == 1) ? esc_html__('Year', "whcom") : esc_html__('Years', "whcom");
                                $tld_price .= ' ' . esc_html__('for', "whcom") . ' ';
                                $tld_price .= whcom_format_amount(['amount' => $price, 'add_suffix' => 'yes']);
                                break;
                            }
                        }
                    }
                    $response['domaintype'] = $domain_type;
                    switch ($domain_type) {
                        case 'register' :
                            {
                                if ($response['status'] == 'OK') {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_text_success whcom_text_2x">
                                        <?php if ($_POST['wcop_sp_current_template'] == '08_elegant') {
                                            esc_html_e('Yes!', "whcom");
                                        } else {
                                            esc_html_e('Congratulations!', "whcom");
                                        } ?>
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e('is available!', "whcom") ?>
                                    </div>
                                    <div class="whcom_text_center whcom_margin_bottom_15">
                                        <?php esc_html_e('Continue to register this domain for', "whcom") ?>
                                        <?php if ($is_free_domain_attached == 'yes' || ($_POST['wcop_sp_current_template'] == '08_elegant' && $free_domain == 'true')) {
                                            esc_html_e('Free', "whcom");
                                        } else { ?>
                                            <?php echo $tld_price; ?>
                                        <?php } ?>
                                    </div>
                                    <form id="wcop_sp_attach_product_domain" class="wcop_sp_attach_product_domain whcom_text_center_xs" method="post">
                                        <input type="hidden" name="action" value="wcop_sp_process">
                                        <input type="hidden" name="wcop_sp_what" value="attach_domain">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <input type="hidden" name="tld" value="<?php echo $domain_ext; ?>">
                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e('Use This Domain', "whcom") ?></strong>
                                        </button>
                                        <button class="whcom_button whcom_button_danger wcop_sp_reset_domain_form">
                                            <strong><?php esc_html_e('Search Again', "whcom") ?></strong>
                                        </button>
                                    </form>
                                    <?php $response['domain_attachment_form'] = ob_get_clean();
                                } else {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e('is unavailable', "whcom") ?>
                                    </div>
                                    <?php if ($_POST['wcop_sp_current_template'] == '08_elegant') { ?>
                                        <div class="whcom_text_center">
                                            <button class="whcom_button whcom_button_danger wcop_sp_reset_domain_form">
                                                <strong><?php esc_html_e('Search Again', "whcom") ?></strong>
                                            </button>
                                        </div>
                                    <?php } ?>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'transfer' :
                            {
                                if ($response['status'] == 'OK') {
                                    ob_start() ?>
                                    <div class=" whcom_text_center whcom_margin_bottom_15 whcom_padding_15">
                                        <div class="whcom_margin_bottom_15 whcom_text_success whcom_text_2x">
                                            <?php esc_html_e('Your domain is eligible for transfer!', "whcom") ?>
                                        </div>
                                        <?php esc_html_e('Please ensure you have unlocked your domain at your current registrar before continuing.', "whcom") ?>
                                    </div>
                                    <div class="whcom_text_center whcom_margin_bottom_15">
                                        <?php esc_html_e('Transfer to us and extend by ', "whcom") ?>
                                        <?php echo $tld_price; ?>
                                    </div>
                                    <form class="wcop_sp_attach_product_domain whcom_text_center_xs" method="post">
                                        <input type="hidden" name="action" value="wcop_sp_process">
                                        <input type="hidden" name="wcop_sp_what" value="attach_domain">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <input type="hidden" name="tld" value="<?php echo $domain_ext; ?>">
                                        <label for="inputAuthCode" class="main_label">Authorization Code</label>
                                        <div class="whcom_row">
                                            <div class="whcom_col_lg_3 whcom_col_md_3 "></div>
                                            <div class="whcom_col_lg_6 whcom_col_md_6">
                                                <div class="whcom_form_field">
                                                    <input type="text" class="" name="eppcode"
                                                           placeholder="Epp Code / Auth Code">
                                                </div>
                                            </div>
                                            <div class="whcom_col_lg_3 whcom_col_md_3"></div>
                                        </div>

                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e('Use This Domain', "whcom") ?></strong>
                                        </button>
                                        <button class="whcom_button whcom_button_danger wcop_sp_reset_domain_form">
                                            <strong><?php esc_html_e('Search Again', "whcom") ?></strong>
                                        </button>
                                    </form>
                                    <?php $response['domain_attachment_form'] = ob_get_clean();
                                } else {
                                    ob_start() ?>
                                    <div class="whcom_text_center">
                                        <div class="whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                            <?php esc_html_e('Not Eligible for Transfer', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('The domain you entered does not appear to be registered.', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('If the domain was registered recently, you may need to try again later.', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('Alternatively, you can perform a search to register this domain.', "whcom") ?>
                                        </div>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'existing' :
                            {
                                ob_start() ?>
                                <form class="wcop_sp_attach_product_domain whcom_text_center_xs" method="post">
                                    <input type="hidden" name="action" value="wcop_sp_process">
                                    <input type="hidden" name="wcop_sp_what" value="attach_domain">
                                    <input type="hidden" name="domain"
                                           value="<?php echo $domain_name . $domain_ext; ?>">
                                    <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                    <input type="hidden" name="tld" value="<?php echo $domain_ext; ?>">
                                    <button type="submit" class="whcom_button whcom_button_success">
                                        <strong><?php esc_html_e('Use This Domain', "whcom") ?></strong>
                                    </button>
                                    <button class="whcom_button whcom_button_danger wcop_sp_reset_domain_form">
                                        <strong><?php esc_html_e('Search Again', "whcom") ?></strong>
                                    </button>
                                </form>
                                <?php $response['domain_attachment_form'] = ob_get_clean();
                                break;
                            }
                    }
                    break;
                }
            case 'attach_domain' :
                {
                    $product_details = !empty($_POST['pid']) ? whcom_get_product_details((int)$_POST['pid']) : "";
                    $default_billingcycle = !empty($_POST['default_billingcycle']) ? $_POST['default_billingcycle'] : '';
                    $wcop_sp_template = !empty($_POST['wcop_sp_template']) ? $_POST['wcop_sp_template'] : '';
                    $response = wcop_sp_render_domain_config($product_details, $default_billingcycle, $wcop_sp_template);
                    break;
                }
            case 'change_product' :
                {
                    $response['status'] = 'OK';
                    $response['response_html']['billingcycles'] = '';
                    $response['response_html']['configurations'] = '';
                    $wcop_sp_template = !empty($_POST['wcop_sp_template']) ? $_POST['wcop_sp_template'] : '';
                    $hide_server_fields = !empty($_POST['hide_server_fields']) ? $_POST['hide_server_fields'] : '';
                    if (!empty($_POST['pid'])) {
                        $product_details = whcom_get_product_details((int)$_POST['pid']);
                        $default_billingcycle = (!empty($_POST['default_billingcycle'])) ? esc_attr($_POST['default_billingcycle']) : '';
                        ob_start();
                        if ($product_details) {
                            $response['status'] = 'OK';
                            $response['template_name'] = $wcop_sp_template;
                            $response['response_html']['billingcycles'] = wcop_sp_render_product_billingcycles($product_details, $default_billingcycle, $wcop_sp_template);
                            ?>
                            <?php if (empty($product_details['prd_configoptions']) && empty($product_details['prd_addons']) && $product_details['type'] != 'server' && empty($product_details['custom_fields'])) { ?>
                                <div class="wcop_sp_product_no_options whcom_text_center">
                                    <strong><?php esc_html_e("No options available for this product", "whcom") ?></strong>
                                </div>
                            <?php } else { ?>
                                <?php $response['options_available'] = 'yes'; ?>
                                <div class="wcop_sp_product_options_container">
                                    <?php if (!empty($product_details['prd_configoptions'])) { ?>
                                        <?php if ($wcop_sp_template == '10_server') { ?>
                                            <div class="whcom_collapse">
                                                <div class="whcom_collapse_toggle">
                                                    <span><?php esc_html_e('Configurable Options', 'whcom') ?></span>
                                                    <i class="whcom_icon_down-open"></i>
                                                </div>
                                                <div class="whcom_collapse_content">
                                                    <?php echo whcom_render_product_config_options($product_details, -1); ?>
                                                </div>
                                            </div>


                                        <?php } else { ?>
                                            <div class="wcop_sp_config_options_container wcop_sp_product_config_block">
                                                <div class="whcom_sub_heading_style_1">
                                                    <span><?php esc_html_e('Configurable Options', 'whcom') ?></span>
                                                </div>
                                                <?php echo whcom_render_product_config_options($product_details, -1); ?>
                                            </div>
                                        <?php }
                                    } ?>
                                    <?php if (!empty($product_details['prd_addons'])) { ?>
                                        <?php if ($wcop_sp_template == '10_server') { ?>
                                            <div class="whcom_collapse">
                                                <div class="whcom_collapse_toggle">
                                                    <span><?php esc_html_e('Available Addons', 'whcom') ?></span>
                                                    <i class="whcom_icon_down-open"></i>
                                                </div>
                                                <div class="whcom_collapse_content">
                                                    <?php $wcop_current_template = !empty($_POST['wcop_sp_template']) ? $_POST['wcop_sp_template'] : ""; ?>
                                                    <?php echo whcom_render_product_addons($product_details, '-1', $wcop_current_template); ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="wcop_sp_addons_options_container wcop_sp_product_config_block">
                                                <div class="whcom_sub_heading_style_1">
                                                    <span><?php esc_html_e('Available Addons', 'whcom') ?></span>
                                                </div>
                                                <!-- pass current style to function to implement custom HTML by zain -->
                                                <?php $wcop_current_template = !empty($_POST['wcop_sp_template']) ? $_POST['wcop_sp_template'] : ""; ?>
                                                <?php echo whcom_render_product_addons($product_details, '-1', $wcop_current_template); ?>
                                            </div>
                                        <?php }
                                    } ?>
                                    <?php if ($product_details['type'] == 'server') { ?>
                                        <?php if ($wcop_sp_template == '10_server') { ?>
                                            <div class="whcom_collapse">
                                                <div class="whcom_collapse_toggle">
                                                    <span><?php esc_html_e('Server options', 'whcom') ?></span>
                                                    <i class="whcom_icon_down-open"></i>
                                                </div>
                                                <div class="whcom_collapse_content">
                                                    <?php echo whcom_render_server_specific_fields(); ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                        <?php if(isset($hide_server_fields) && $hide_server_fields != 'yes'){ ?>
                                            <div class="wcop_sp_server_options_container wcop_sp_product_config_block">
                                                <div class="whcom_sub_heading_style_1">
                                                    <span><?php esc_html_e('Server Options', 'whcom') ?></span>
                                                </div>
                                                <?php echo whcom_render_server_specific_fields(); ?>
                                            </div>
                                        <?php } }
                                    } ?>
                                    <?php if (!empty($product_details['custom_fields'])) { ?>
                                        <?php if ($wcop_sp_template == '10_server') { ?>
                                            <div class="whcom_collapse">
                                                <div class="whcom_collapse_toggle">
                                                    <span><?php esc_html_e('Additional Required information', 'whcom') ?></span>
                                                    <i class="whcom_icon_down-open"></i>
                                                </div>
                                                <div class="whcom_collapse_content">
                                                    <?php echo whcom_render_product_custom_fields($product_details); ?>
                                                </div>
                                            </div>
                                        <?php } else { ?>
                                            <div class="wcop_sp_custom_options_container wcop_sp_product_config_block">
                                                <div class="whcom_sub_heading_style_1">
                                                    <span><?php esc_html_e('Additional Required Information', 'whcom') ?></span>
                                                </div>
                                                <?php echo whcom_render_product_custom_fields($product_details); ?>
                                            </div>
                                        <?php  }
                                    } ?>
                                </div>
                            <?php } ?>

                            <?php
                            $response['domain_options'] = wcop_sp_render_domain_config($product_details, $default_billingcycle, $wcop_sp_template);
                        }
                        $response['response_html']['configurations'] = ob_get_clean();
                    } else {
                        ob_start(); ?>
                        <div class="whcom_text_center">
                            <?php esc_html_e('This section will lists configuration options for the selected product.', 'whcom') ?>
                        </div>
                        <?php $response['response_html']['configurations'] = ob_get_clean();
                    }
                    break;
                }
            case 'change_billingcycle' :
                {
                    if (!empty($_POST['pid'])) {
                        $billing_cycle = esc_attr($_POST['billingcycle']);
                        $product_details = whcom_get_product_details((int)$_POST['pid']);
                        if ((empty($billing_cycle) || empty($product_details['all_prices'][$billing_cycle])) && (!empty($product_details['lowest_price']))) {
                            reset($product_details['lowest_price']);
                            $billing_cycle = key($product_details['lowest_price']);
                        }
                        if ($product_details) {
                            $response['status'] = 'OK';
                            ob_start();
                            if (empty($product_details['prd_configoptions']) && empty($product_details['prd_addons']) && $product_details['type'] != 'server' && empty($product_details['custom_fields'])) { ?>
                                <?php $response['options_available'] = 'yes'; ?>
                                <div class="wcop_sp_product_no_options whcom_text_center">
                                    <strong><?php esc_html_e("No options available for this product", "whcom") ?></strong>
                                </div>
                            <?php } else { ?>
                                <?php if (!empty($product_details['prd_configoptions'])) { ?>
                                    <div class="whcom_sub_heading_style_1">
                                        <span><?php esc_html_e('Configurable Options', 'whcom') ?></span>
                                    </div>
                                    <?php echo whcom_render_product_config_options($product_details, -1, $billing_cycle);
                                }
                            }
                            $response['options_html'] = ob_get_clean();
                            $response['domain_options'] = wcop_sp_render_domain_config($product_details, $billing_cycle);
                        } else {
                            $response['message'] = esc_html__("Wrong Product ID provided", "whcom");
                            $response['status'] = 'ERROR';
                        }
                    } else {
                        $response['message'] = esc_html__("Wrong Product ID provided", "whcom");
                        $response['status'] = 'ERROR';
                    }

                    break;
                }
            case 'wcop_sp_generate_summary' :
                {
                    $response['summary_html'] = wcop_sp_generate_order_summary($_POST);
                    $response['status'] = 'OK';
                    $response['message'] = '<i class="whcom_icon_check"></i>' . " " . esc_html__('Product Summary Updated', "whcom");
                    break;
                }
            case 'add_order' :
                {
                    $client_id = false;
                    $product_id = (empty($_POST['pid'])) ? 0 : $_POST['pid'];
                    $product_fields = (empty($_POST['customfields'])) ? [] : $_POST['customfields'];
                    $client_fields = (empty($_POST['client_customfields'])) ? [] : $_POST['client_customfields'];

                    $product_details = whcom_get_product_details($product_id);
                    if (!empty($product_details) && !empty($product_details['showdomainoptions']) && empty($_POST['domain'])) {
                        $msg = esc_html__('The product you selected requires a domain to be attached with it, kindly select a domain using form above', 'whcom');
                        $response['message'] = $msg;
                    } else {
                        if (whcom_is_client_logged_in()) {
                            $client_id = whcom_get_current_client_id();
                            $response['message'] = esc_html__("Client is already logged in", "whcom");
                        } else {
                            // Validate/Register Client
                            if (!empty($_POST['wcop_sp_client_type'])) {
                                if (esc_attr($_POST['wcop_sp_client_type']) == 'register') {
                                    $response['message'] = esc_html__("Registering New Client", "whcom");
                                    $_POST['customfields'] = $client_fields;
                                    $temp_response = whcom_register_new_client($_POST);
                                    if ($temp_response['status'] == 'OK') {
                                        $client_id = whcom_get_current_client_id();
                                    } else {
                                        $response = $temp_response;
                                    }
                                } else {
                                    $response['message'] = esc_html__("Validating Client", "whcom");
                                    $credentials = [
                                        'email' => (!empty($_POST['login_email'])) ? esc_attr($_POST['login_email']) : '',
                                        'pass' => (!empty($_POST['login_pass'])) ? esc_attr($_POST['login_pass']) : '',
                                    ];
                                    $temp_response = whcom_validate_client($credentials);
                                    $response['rrcit'] = $temp_response;
                                    if ($temp_response['status'] == 'OK') {
                                        $client_id = whcom_get_current_client_id();
                                    } else {
                                        $response = $temp_response;
                                    }
                                }
                            }
                        }

                        // Add Order
                        if ($client_id && (int)$client_id > 0) {
                            $_POST['customfields'] = $product_fields;
                            $response = whcom_add_update_cart_item($_POST);
                            if ($response['status'] == 'OK') {
                                $response = whcom_submit_order();
                                if (!empty($response['result'])) {
                                    if ($response['result'] == 'success') {
                                        $response['status'] = 'OK';
                                        $response['message'] = esc_html__('Your product has been ordered...');
                                        $response_data = [];
                                        $response_data['redirect_link'] = $response['response_form'] = $response_data['invoice_link'] = $response['show_cc'] = '';
                                        $field = 'order_complete_redirect' . whcom_get_current_language();
                                        $response_data['redirect_link'] = '<a href="' . esc_attr(get_option($field)) . '" class="whcom_button">' . esc_html__('Dashboard', "whcom") . '</a> ';

                                        $args = [
                                            'action' => 'CreateSsoToken',
                                            'client_id' => $client_id,
                                            'destination' => 'sso:custom_redirect',
                                            'sso_redirect_path' => "viewinvoice.php?wcap_no_redirect=1&id=" . $response['invoiceid']
                                        ];

                                        $sso_result = whcom_process_api($args);
                                        $url = $sso_result["redirect_url"];
                                        /*$args = [
                                            'goto' => "viewinvoice.php?wcap_no_redirect=1&id=" . $response['invoiceid'],
                                        ];
                                        $url = whcom_generate_auto_auth_link($args);*/

                                        $order_complete_url = get_option('order_complete_redirect' . whcom_get_current_language(), home_url('/'));

                                        if (get_option('wcop_show_invoice_as', 'popup') == 'minimal') {
                                            $response_data['invoice_link'] = '<a target="_blank" href="' . $url . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
                                        } else if (get_option('wcop_show_invoice_as', 'popup') == 'same_tab') {
                                            $response_data['invoice_link'] = '<a href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
                                        } else if (get_option('wcop_show_invoice_as', 'popup') == 'new_tab') {
                                            $response_data['invoice_link'] = '<a target="_blank" href="?whmpca=order_process&a=viewinvoice&id=' . $response['invoiceid'] . '" class="whcom_button wcop_view_invoice_button">' . esc_html__('View Invoice', "whcom") . '</a> ';
                                        } else {
                                            $redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $order_complete_url . '">' . esc_html__('Close', 'whcom') . '</a> ';
                                            $invoice_div = '<div id="invoice_' . $response['invoiceid'] . '" style="display:none;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';
                                            $invoice_anchor = '<a href="#TB_inline?width=1050&height=550&inlineId=invoice_' . $response['invoiceid'] . '" class="thickbox whcom_button whcom_op_view_invoice_button">' . esc_html__('View Invoice', 'whcom') . '</a> ';
                                            $response_data['invoice_link'] = $invoice_anchor . $invoice_div;
                                        }
                                        if (wcop_use_merchant_gateway() && (esc_attr($_POST['paymentmethod']) == get_option('merchant_gateway_key', ''))) {

                                            $_POST['invoiceid'] = $response['invoiceid'];
                                            $_POST['clientid'] = whcom_get_current_client_id();
                                            $_POST['expdate'] = esc_attr($_POST['exp_month']) . esc_attr($_POST['exp_year']);
                                            $response = wcop_capture_payment_function($_POST);


                                            $field = 'order_complete_redirect' . whcom_get_current_language();
                                            $dashboard_url = esc_attr(get_option($field, home_url()));
                                            if ($response['status'] == 'OK') {
                                                ob_start();

                                                ?>
                                                <div class="whcom_form_field">
                                                    <?php esc_html_e('Thank you for your order. You will receive a confirmation email shortly.', "whcom") ?>
                                                </div>
                                                <div class="whcom_alert whcom_alert_info">
                                                    <span><?php esc_html_e('Your invoice ID is: ', "whcom") ?></span><?php echo $_POST['invoiceid'] ?>
                                                </div>
                                                <div class="whcom_form_field">
                                                    <?php esc_html_e('If you have any questions about your order, please open a support ticket from your client area and quote your order number.', "whcom") ?>
                                                </div>

                                                <div class="whcom_form_field whcom_text_center">
                                                    <a href="<?php echo $dashboard_url ?>"
                                                       class="whcom_button whcom_button_secondary"><?php esc_html_e('Continue To Client Area', "whcom") ?></a>
                                                </div>

                                                <?php
                                                $response['response_html'] = ob_get_clean();
                                            } else {
                                                ob_start();
                                                echo whcom_render_order_complete_message($response['redirect_link'], $response['invoice_link']);
                                                $response['response_html'] = ob_get_clean();
                                                $response['status'] = 'invoice_generated';
                                            }
                                            $response['show_cc'] = 'html';
                                        } else {
                                            $response['show_cc'] = 'show_invoice';
                                            ob_start();
                                            $get_invoice_id = $response['invoiceid'];
                                            $_SESSION['get_invoice_id'] = $get_invoice_id;
                                            echo whcom_render_order_complete_message($response_data['redirect_link'], $response_data['invoice_link']);
                                            $response['response_html'] = ob_get_clean();
                                        }
                                    } else {
                                        $response['status'] = 'ERROR';
                                    }
                                }
                            }
                        }
                    }
                    break;
                }
            case 'estimate_taxes' :
                {
                    $country = (isset($_POST['country'])) ? esc_attr($_POST['country']) : '';
                    $state = (isset($_POST['state'])) ? esc_attr($_POST['state']) : '';
                    $_SESSION['whcom_tax_default_country'] = $country;
                    $_SESSION['whcom_tax_default_state'] = $state;
                    $response = [
                        'status' => "OK",
                        'message' => esc_html__('Taxes estimated, reloading page', 'whcom'),
                    ];
                    break;
                }
            case 'add_remove_coupon' :
                {
                    $code = (!empty($_POST['promocode'])) ? esc_attr($_POST['promocode']) : '';
                    $promo_action = (!empty($_POST['promo_action'])) ? esc_attr($_POST['promo_action']) : '';
                    $response['promocode'] = '';

                    if ($promo_action == 'add_coupon') {
                        $current_promo = [];
                        if (!empty($code)) {
                            $current_promo = whcom_get_promotion($code);
                            $current_promo = reset($current_promo);
                        }
                        if (!empty($current_promo)) {
                            $response['status'] = 'OK';
                            $response['promocode'] = $code;
                            $response['response_html'] = wcop_sp_render_promo_html($current_promo);
                        } else {
                            $response['message'] = esc_html__("The promotion code entered does not exist", "whcom");
                        }
                    } else if ($promo_action == 'remove_coupon') {
                        $response['status'] = 'OK';
                        $response['response_html'] = wcop_sp_render_promo_html([]);
                    } else {
                        $response['message'] = esc_html__("No Propoer Action for Promo Code", "whcom");
                    }


                    break;
                }
            case 'process_login' :
                {
                    $credentials = [
                        'email' => (!empty($_POST['login_email'])) ? esc_attr($_POST['login_email']) : '',
                        'pass' => (!empty($_POST['login_pass'])) ? esc_attr($_POST['login_pass']) : '',
                    ];
                    $response = whcom_validate_client($credentials);
                    if ($response['status'] == 'OK') {
                        $response = ['status' => 'OK'];
                        $response['message'] = esc_html__("Login Successful.", "whcom");
                        $response['register_heading'] = esc_html__("Billing Info", "whcom");
                        $template_name = '01_default';
                        if (!empty($_POST['wcop_sp_template'])) {
                            $template_name = esc_attr__($_POST['wcop_sp_template']);
                        }
                        ob_start();
                        $file = wcop_get_template_directory() . '/templates/single_page/' . $template_name . '/05_client.php';
                        $response['file_path_before'] = $file;
                        if (!is_file($file)) {
                            $response['template_not_found'] = 'ERROR';
                            $file = wcop_get_template_directory() . '/templates/single_page/08_elegant/05_client.php';;
                        }
                        require $file;
                        $response['file_path'] = $file;
                        $response['register_html'] = ob_get_clean();
                        //$response['register_html']    = whcom_render_logged_in_client_form();
                    }
                    break;
                }
            case 'process_logout' :
                {
                    whcom_client_log_out();
                    $response['status'] = 'OK';
                    $response['message'] = esc_html__("Logout Successful.", "whcom");
                    $response['register_heading'] = esc_html__("Enter Your Billing Info", "whcom");
                    $template_name = '01_default';
                    if (!empty($_POST['wcop_sp_template'])) {
                        $template_name = esc_attr__($_POST['wcop_sp_template']);
                    }
                    ob_start();
                    $file = wcop_get_template_directory() . '/templates/single_page/' . $template_name . '/05_client.php';
                    $response['file_path_before'] = $file;
                    if (!is_file($file)) {
                        $response['template_not_found'] = 'ERROR';
                        $file = wcop_get_template_directory() . '/templates/single_page/08_elegant/05_client.php';;
                    }
                    require $file;
                    $response['file_path'] = $file;
                    $response['client_html'] = ob_get_clean();
                    break;
                }
            case 'wcop_include_client_section':
                {
                    $response['status'] = 'OK';
                    $response['message'] = esc_html__("Included Successfully.", "whcom");
                    /* ob_start();
                     ini_set('display_errors', 1);
                     error_reporting(E_ALL);
                     require_once wcop_get_template_directory() . '/templates/single_page/01_default/05_client.php';*/

                    /*$template_name = '01_default';
                    if (!empty($_POST['wcop_sp_template'])) {
                        $template_name = esc_attr__($_POST['wcop_sp_template']);
                    }
                    ob_start();
                    $file = wcop_get_template_directory() . '/templates/single_page/' . $template_name . '/05_client.php';
                    $response['file_path_before'] = $file;
                    if (!is_file($file)) {
                        $response['template_not_found'] = 'ERROR';
                        $file = wcop_get_template_directory() . '/templates/single_page/01_default/05_client.php';;
                    }
                    require $file;*/
                    //$response['file_path'] = $file;
                    //$response['client_section_html'] = ob_get_contents();
                    break;
                }
            default :
                {
                    $response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
                    $response['status'] = 'ERROR';
                }
        }
        echo json_encode($response, JSON_FORCE_OBJECT);
        die();
    }

    add_action('wp_ajax_wcop_sp_process', 'wcop_sp_process');
    add_action('wp_ajax_nopriv_wcop_sp_process', 'wcop_sp_process');
}

if (!function_exists('wcop_domain_first')) {
// Domain First (template) functions start from here
    function wcop_domain_first()
    {
        $wcop_what = (!empty($_POST['wcop_what'])) ? esc_attr($_POST['wcop_what']) : 'nothing';
        $response = [];
        $response['post'] = $_POST;
        switch ($wcop_what) {
            case 'domain_search' :
                {
                    $response = whcom_check_domain_function($_POST);
                    $domain_ext = (!empty($_POST['ext'])) ? esc_attr($_POST['ext']) : '';
                    $domain_ext = "." . ltrim($domain_ext, ".");
                    $domain_name = (!empty($_POST['domain'])) ? esc_attr($_POST['domain']) : '';
                    $domain_type = (!empty($_POST['domaintype'])) ? esc_attr($_POST['domaintype']) : '';
                    $gids = (!empty($_REQUEST['gids'])) ? esc_attr($_REQUEST['gids']) : '';
                    $pids = (!empty($_REQUEST['pids'])) ? esc_attr($_REQUEST['pids']) : '';


                    $tld_details = whcom_get_tld_details($domain_ext);
                    $tld_price = '';
                    if (!empty($tld_details[$domain_type . '_price'])) {
                        foreach ($tld_details[$domain_type . '_price'] as $dur => $price) {
                            if ($price >= 0) {
                                $tld_price = (string)$dur . ' ';
                                $tld_price .= ($dur == 1) ? esc_html__('Year', "whcom") : esc_html__('Years', "whcom");
                                $tld_price .= ' ' . esc_html__('for', "whcom") . ' ';
                                $tld_price .= whcom_format_amount(['amount' => $price, 'add_suffix' => 'yes']);
                                break;
                            }
                        }
                    }
                    $response['domaintype'] = $domain_type;
                    switch ($domain_type) {
                        case 'register' :
                            {
                                if ($response['status'] == 'OK') {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_text_success whcom_text_2x">
                                        <?php esc_html_e('Congratulations!', "whcom") ?>
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e('is available!', "whcom") ?>
                                    </div>
                                    <div class="whcom_text_center whcom_margin_bottom_15">
                                        <?php esc_html_e('Continue to register this domain for', "whcom") ?>
                                        <?php echo $tld_price; ?>
                                    </div>
                                    <form method="post" id="wcop_df_domain_search_submit" class="whcom_text_center">
                                        <input type="hidden" name="action" value="wcop_domain_first">
                                        <input type="hidden" name="wcop_what" value="domain_submit">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="pids" value="<?php echo $pids; ?>">
                                        <input type="hidden" name="gids" value="<?php echo $gids; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e('Continue', "whcom") ?></strong>
                                        </button>
                                    </form>
                                    <?php $response['response_form'] = ob_get_clean();
                                } else {
                                    ob_start() ?>
                                    <div class="whcom_text_center whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                        <strong><?php echo $domain_name ?><?php echo $domain_ext ?></strong> <?php esc_html_e('is unavailable', "whcom") ?>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                        case 'transfer' :
                            {
                                if ($response['status'] == 'OK') {
                                    ob_start() ?>
                                    <div class=" whcom_text_center whcom_margin_bottom_15 whcom_padding_15">
                                        <div class="whcom_margin_bottom_15 whcom_text_success whcom_text_2x">
                                            <?php esc_html_e('Your domain is eligible for transfer!', "whcom") ?>
                                        </div>
                                        <?php esc_html_e('Please ensure you have unlocked your domain at your current registrar before continuing.', "whcom") ?>
                                    </div>
                                    <div class="whcom_text_center whcom_margin_bottom_15">
                                        <?php esc_html_e('Transfer to us and extend by ', "whcom") ?>
                                        <?php echo $tld_price; ?>
                                    </div>
                                    <form method="post" id="wcop_df_domain_search_submit" class="whcom_text_center">
                                        <input type="hidden" name="action" value="wcop_domain_first">
                                        <input type="hidden" name="wcop_sp_what" value="domain_submit">
                                        <input type="hidden" name="domain"
                                               value="<?php echo $domain_name . $domain_ext; ?>">
                                        <input type="hidden" name="domaintype" value="<?php echo $domain_type; ?>">
                                        <input type="hidden" name="pids" value="<?php echo $pids; ?>">
                                        <input type="hidden" name="gids" value="<?php echo $gids; ?>">
                                        <button type="submit" class="whcom_button whcom_button_success">
                                            <strong><?php esc_html_e('Continue', "whcom") ?></strong>
                                        </button>
                                    </form>
                                    <?php $response['response_form'] = ob_get_clean();
                                } else {
                                    ob_start() ?>
                                    <div class="whcom_text_center">
                                        <div class="whcom_margin_bottom_15 whcom_text_danger whcom_text_2x">
                                            <?php esc_html_e('Not Eligible for Transfer', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('The domain you entered does not appear to be registered.', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('If the domain was registered recently, you may need to try again later.', "whcom") ?>
                                        </div>
                                        <div class="whcom_margin_bottom_15">
                                            <?php esc_html_e('Alternatively, you can perform a search to register this domain.', "whcom") ?>
                                        </div>
                                    </div>
                                    <?php $response['message'] = ob_get_clean();
                                }
                                break;
                            }
                    }
                    break;
                }
            case 'domain_submit' :
                {
                    $domain = whcom_get_domain_clean(esc_attr($_POST['domain']));
                    if (($domain == '') || ($domain == '')) {
                        $response['message'] = esc_html__("Domain was not selected properly, kindly try again...", "whcom");
                        $response['status'] = 'ERROR';
                    } else {
                        $tld = whcom_get_tld_from_domain($domain);
                        $tld_det = whcom_get_tld_details($tld);
                        $type = esc_attr($_POST['domaintype']);
                        $price_array = $tld_det[$type . '_price'];
                        $domain_duration = '1';
                        if (!empty($price_array)) {
                            foreach ($price_array as $y => $price) {
                                $domain_duration = $y;
                                break;
                            }
                        }
                        $item = [
                            'domain' => $domain,
                            'domaintype' => $type,
                            'regperiod' => $domain_duration,
                        ];
                        $response = whcom_add_update_cart_item($item);
                        ob_start();
                        include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/02_product.php');
                        $response['response_form'] = ob_get_clean();
                        $response['message'] = esc_html__("Loading Product Selection Form", "whcom");
                        $response['status'] = 'OK';
                    }
                    break;
                }
            case 'add_remove_domain' :
                {
                    $domain_action = esc_attr($_POST['domain_action']);
                    $cart_index = esc_attr($_POST['cart_index']);
                    $domain_name = esc_attr($_POST['domain']);
                    $domain_type = esc_attr($_POST['domain_type']);
                    $domain_duration = esc_attr($_POST['domain_duration']);

                    $item = [
                        'domain' => $domain_name,
                        'domaintype' => $domain_type,
                        'regperiod' => $domain_duration,
                    ];
                    if (empty($domain_duration) || ($domain_duration == "")) {
                        $response['status'] = "ERROR";
                        $response['message'] = esc_html__('Sorry! This domain can not be added to cart at the moment', "whcom");
                    } else {
                        if ($domain_action == 'add_item') {
                            $cart_items = whcom_get_cart()['all_items'];
                            $already_in_cart = false;
                            foreach ($cart_items as $key => $cart_item) {
                                if ((!empty($cart_item['domain'])) && ($cart_item['domain'] == $item['domain'])) {
                                    $response['cart_index'] = $key;
                                    $response['status'] = "OK";
                                    $response['already_added'] = "YES";
                                    $already_in_cart = true;
                                    break;
                                }
                            }
                            if (!$already_in_cart) {
                                $response = whcom_add_update_cart_item($item);
                            }
                            if ($response['status'] == "OK") {
                                $response['message'] = esc_html__('Domain is added to cart', "whcom");
                            }
                        } else {
                            $response = whcom_delete_cart_item($cart_index);
                            if ($response['status'] == "OK") {
                                $response['message'] = esc_html__('Domain is removed from cart', "whcom");
                            }
                        }
                    }

                    $response['current_cart'] = whcom_get_cart();
                    break;
                }
            case 'get_domain_products' :
                {
                    ob_start();
                    include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/02_products_list.php');
                    $response['products'] = ob_get_clean();
                    $response['message'] = esc_html__("Loading Product Selection Form", "whcom");
                    $response['status'] = 'OK';
                    break;
                }
            case 'attach_domain_product' :
                {
                    $product_action = esc_attr($_POST['product_action']);
                    $pid = esc_attr($_POST['pid']);
                    $cart_index = esc_attr($_POST['cart_index']);
                    $billingcycle = esc_attr($_POST['billingcycle']);

                    $item = [
                        'pid' => $pid,
                        'billingcycle' => $billingcycle,
                    ];
                    if (empty($billingcycle) || ($billingcycle == "")) {
                        $response['status'] = "ERROR";
                        $response['message'] = esc_html__('Sorry! This product can not be added to cart at the moment', "whcom");
                    } else {
                        if ($product_action == 'add_item') {
                            $cart_items = whcom_get_cart()['all_items'];
                            $already_in_cart = false;
                            if ((!empty($cart_items[$cart_index]['pid'])) && ($item['pid'] == $cart_items[$cart_index]['pid'])) {
                                $response['status'] = "OK";
                                $response['already_added'] = "YES";
                                $already_in_cart = true;
                            }
                            if (!$already_in_cart) {
                                $response = whcom_add_update_cart_item($item, $cart_index);
                            }
                            if ($response['status'] == "OK") {
                                $response['message'] = esc_html__('Product is attached with domain', "whcom");
                            }
                        } else {
                            $item = [
                                'pid' => "to_unset_string",
                                'billingcycle' => "to_unset_string",
                            ];
                            $response = whcom_add_update_cart_item($item, $cart_index);
                            if ($response['status'] == "OK") {
                                $response['message'] = esc_html__('Product is detached from domain', "whcom");
                            }
                        }
                    }

                    $response['item'] = $item;
                    $response['current_cart'] = whcom_get_cart();
                    break;
                }
            case 'domain_products_attached' :
                {
                    ob_start();
                    include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/04_domains_config.php');
                    $response['response_form'] = ob_get_clean();
                    $response['message'] = esc_html__("Loading Contact Form", "whcom");
                    $response['status'] = 'OK';
                    break;
                }
            case 'domains_config' :
                {
                    whcom_update_cart_domains($_POST);
                    ob_start();
                    include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/05_products_config.php');
                    $response['response_form'] = ob_get_clean();
                    $response['current_cart'] = whcom_get_cart();
                    $response['message'] = esc_html__("Loading Client Form", "whcom");
                    $response['status'] = 'OK';
                    break;
                }
            case 'get_product_options' :
                {
                    $billingcycle = esc_attr($_POST['billingcycle']);
                    $cart_index = esc_attr($_POST['cart_index']);
                    $product_id = esc_attr($_POST['product_id']);

                    $response['status'] = "OK";
                    $response['response_form'] = whcom_render_product_config_options($product_id, $cart_index, $billingcycle);
                    break;
                }
            case 'products_summary' :
                {
                    $product_ids = (!empty($_POST['pid']) && is_array($_POST['pid'])) ? $_POST['pid'] : [];
                    $amount_local = [
                        'setup' => 0.00,
                        'monthly' => 0.00,
                        'quarterly' => 0.00,
                        'semiannually' => 0.00,
                        'annually' => 0.00,
                        'biennially' => 0.00,
                        'triennially' => 0.00,
                        'free_domain' => 0.00,
                        'base_price' => 0.00,
                        'l1_amount' => 0.00,
                        'l2_amount' => 0.00,
                        'final_price' => 0.00,
                    ];
                    $total_amount = 0.00;

                    $summary_html_return = '';
                    $tax_rates = whcom_get_tax_levels();
                    foreach ($product_ids as $local_cart_index => $product_id) {
                        $product_array = [];
                        $product_array['pid'] = $product_id;
                        $product_array['billingcycle'] = (!empty($_POST['billingcycle']) && !empty($_POST['billingcycle'][$local_cart_index])) ? $_POST['billingcycle'][$local_cart_index] : '';
                        $product_array['configoptions'] = (!empty($_POST['configoptions']) && !empty($_POST['configoptions'][$local_cart_index])) ? $_POST['configoptions'][$local_cart_index] : [];
                        $product_array['addons'] = (!empty($_POST['addons']) && !empty($_POST['addons'][$local_cart_index])) ? $_POST['addons'][$local_cart_index] : [];


                        $summary_html = [];
                        ob_start();
                        include WHCOM_PATH . '/shortcodes/order_process/02_product_sidebar.php';
                        ob_end_clean();


                        ob_start();
                        $amount_local['setup'] = (float)$amount_local['setup'] + (float)$summary_html['totals_array']['setup'];
                        $amount_local['monthly'] = (float)$amount_local['monthly'] + (float)$summary_html['totals_array']['monthly'];
                        $amount_local['quarterly'] = (float)$amount_local['quarterly'] + (float)$summary_html['totals_array']['quarterly'];
                        $amount_local['semiannually'] = (float)$amount_local['semiannually'] + (float)$summary_html['totals_array']['semiannually'];
                        $amount_local['annually'] = (float)$amount_local['annually'] + (float)$summary_html['totals_array']['annually'];
                        $amount_local['biennially'] = (float)$amount_local['biennially'] + (float)$summary_html['totals_array']['biennially'];
                        $amount_local['triennially'] = (float)$amount_local['triennially'] + (float)$summary_html['totals_array']['triennially'];
                        $amount_local['base_price'] = (float)$amount_local['base_price'] + (float)$summary_html['totals_array']['base_price'];
                        $amount_local['l1_amount'] = (float)$amount_local['l1_amount'] + (float)$summary_html['totals_array']['l1_amount'];
                        $amount_local['l2_amount'] = (float)$amount_local['l2_amount'] + (float)$summary_html['totals_array']['l2_amount'];
                        $amount_local['final_price'] = (float)$amount_local['final_price'] + (float)$summary_html['totals_array']['final_price'];

                        echo $summary_html['details_html'];

                        $summary_html_return .= ob_get_clean();

                    } ?>
                    <?php ob_start() ?>
                    <div class="whcom_op_product_summary_totals whcom_margin_bottom_10 whcom_bordered_bottom whcom_padding_bottom_5">
                        <?php foreach ($amount_local as $key => $amt) { ?>
                            <?php if ($amt || ($key == 'setup')) {
                                $total_amount = $total_amount + $amt;
                                $ignored_keys = [
                                    'free_domain',
                                    'base_price',
                                    'l1_amount',
                                    'l2_amount',
                                    'final_price',
                                    'onetime',
                                ];
                                if (in_array($key, $ignored_keys)) {
                                    continue;
                                }
                                ?>
                                <div class="whcom_clearfix <?php echo $key; ?> <?php echo (($key != 'setup')) ? 'price' : ''; ?> <?php echo (($amt <= 0)) ? 'free' : ''; ?>">
                                    <span class="whcom_pull_left"><?php echo whcom_convert_billingcycle($key); ?></span>
                                    <span class="whcom_pull_right"><?php echo whcom_format_amount([
                                            'amount' => $amt,
                                            'add_suffix' => 'yes'
                                        ]); ?></span>
                                </div>
                            <?php } ?>
                        <?php } ?>
                        <?php if ($amount_local['l1_amount'] > 0) { ?>
                            <div class="whcom_clearfix">
								<span class="whcom_pull_left"><?php echo $tax_rates['level1_title'] ?>
                                    &#64; <?php echo $tax_rates['level1_rate'] ?>&#37;</span>
                                <span class="whcom_pull_right"><?php echo whcom_format_amount($amount_local['l1_amount']); ?></span>
                            </div>
                        <?php } ?>
                        <?php if ($amount_local['l2_amount'] > 0) { ?>
                            <div class="whcom_clearfix">
								<span class="whcom_pull_left"><?php echo $tax_rates['level2_title'] ?>
                                    &#64; <?php echo $tax_rates['level2_rate'] ?>&#37;</span>
                                <span class="whcom_pull_right"><?php echo whcom_format_amount($amount_local['l2_amount']); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="whcom_op_product_summary_grand_total">
                        <div class="whcom_clearfix whcom_text_2x">
							<span class="whcom_pull_right"><?php echo whcom_format_amount([
                                    'amount' => $amount_local['final_price'],
                                    'add_suffix' => 'yes'
                                ]); ?></span>
                        </div>
                        <div class="whcom_clearfix">
                            <span class="whcom_pull_right"><?php esc_html_e('Sub Total', 'whcom') ?></span>
                        </div>
                    </div>
                    <?php $totals_html = ob_get_clean(); ?>
                    <?php
                    $response['summary_html'] = $summary_html_return . $totals_html;
                    $response['status'] = 'OK';
                    $response['message'] = esc_html__('Repopulating product Summary', 'whcom');
                    break;
                }
            case 'products_config' :
                {
                    $product_durations = $_POST['billingcycle'];
                    $product_options = $_POST['configoptions'];
                    $product_addons = $_POST['addons'];
                    $product_fields = $_POST['customfields'];
                    $domainns1 = $_POST['domainns1'];
                    $domainns2 = $_POST['domainns2'];
                    $domainns3 = $_POST['domainns3'];
                    $domainns4 = $_POST['domainns4'];
                    $domainns5 = $_POST['domainns5'];

                    $response['ns_response'] = whcom_add_update_cart_item([
                        'domainns1' => $domainns1,
                        'domainns2' => $domainns2,
                        'domainns3' => $domainns3,
                        'domainns4' => $domainns4,
                        'domainns5' => $domainns5,
                    ], 0);
                    foreach ($product_durations as $cart_index => $product_duration) {
                        $response['pd_response'][] = whcom_add_update_cart_item(['billingcycle' => (string)$product_duration], $cart_index);
                    }
                    foreach ($product_options as $cart_index => $product_option) {
                        $response['pd_response'][] = whcom_add_update_cart_item(['configoptions' => $product_option], $cart_index);
                    }
                    foreach ($product_addons as $cart_index => $product_addon) {
                        $response['pd_response'][] = whcom_add_update_cart_item(['addons' => $product_addon], $cart_index);
                    }
                    foreach ($product_fields as $cart_index => $product_field) {
                        $response['pd_response'][] = whcom_add_update_cart_item(['customfields' => $product_field], $cart_index);
                    }
                    ob_start();
                    include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/06_summary_main.php');
                    $response['response_form'] = ob_get_clean();
                    $response['current_cart'] = whcom_get_cart();
                    $response['message'] = esc_html__("Loading Checkout Form", "whcom");
                    $response['status'] = 'OK';
                    break;
                }
            case 'review' :
                {
                    ob_start();
                    include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/06_checkout.php');
                    $response['response_form'] = ob_get_clean();
                    $response['status'] = 'OK';
                    break;
                }
            case 'checkout' :
                {
                    if (!empty($_POST['paymentmethod'])) {
                        whcom_add_update_cart_item(['paymentmethod' => (string)$_POST['paymentmethod']]);
                        $response = whcom_submit_order();
                        if (!empty($response['result']) && ($response['result'] == 'success')) {
                            if (wcop_use_merchant_gateway()) {
                                $_POST['invoiceid'] = $response['invoiceid'];
                                ob_start();
                                include(wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/07_capture_payment.php');
                                $response['response_form'] = ob_get_clean();
                            } else {
                                $response['response_form'] = $response['invoice_link'];
                            }
                            $response['message'] = esc_html__("Invoice Generated", "whcom");
                            $response['status'] = 'OK';
                        } else {
                            $response['status'] = 'OK';
                        }
                    } else {
                        $response['message'] = esc_html__('No Payment method selected', "whcom");
                        $response['status'] = 'ERROR';
                    }
                    break;
                }
            default :
                {
                    $response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
                    $response['status'] = 'ERROR';
                }
        }
        echo json_encode($response, JSON_FORCE_OBJECT);
        die();
    }

    add_action('wp_ajax_wcop_domain_first', 'wcop_domain_first');
    add_action('wp_ajax_nopriv_wcop_domain_first', 'wcop_domain_first');
}
















