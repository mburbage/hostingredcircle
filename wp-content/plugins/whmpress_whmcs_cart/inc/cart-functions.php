<?php defined('ABSPATH') or die("Cannot access pages directly.");

if (!function_exists('wcop_capture_payment_function')) {
    function wcop_capture_payment_function($invoice_data)
    {
        $response = [];
        $fields = [
            'clientid' => esc_html__('Client ID'),
            'invoiceid' => esc_html__('Invoice ID'),
            'cardtype' => esc_html__('Card Type'),
            'cardnum' => esc_html__('Card Number'),
            'expdate' => esc_html__('Card Expiry Date'),
            'cvv' => esc_html__('Card CVV'),
            //'paymentmethod' => esc_html__( 'Payment Gateway' ),
        ];
        $response['invoice_data'] = $invoice_data;
        if (isset($invoice_data)) {
            $user = [
                'action' => 'UpdateClient',
            ];
            foreach ($fields as $field => $title) {
                $response['status'] = 'info_invalid';
                if (!isset($invoice_data[$field])) {
                    $response['message'] = $title . ' ' . esc_html__('is required');
                    $response['status'] = 'ERROR';
                    break;
                } else {
                    $user[$field] = esc_attr($invoice_data[$field]);
                    $response['status'] = 'info_valid';
                }
            }
            if ($response['status'] == 'info_valid') {
                $response['api_res'] = $res = whcom_process_api($user);
                if ($res['result'] != 'success') {
                    $response['message'] = $res['message'] . 'API error in User editing';
                    $response['status'] = 'ERROR';
                    $response['user_id'] = $user;
                } else {
                    $invoice = [
                        'action' => 'CapturePayment',
                        'invoiceid' => (int)$invoice_data['invoiceid'],
                        'cvv' => (int)$invoice_data['cvv'],
                    ];
                    $response['api_res'] = $res = whcom_process_api($invoice);
                    if ($res['result'] != 'success') {
                        $response['message'] = $res['message'] . 'API error in Capture Payment';
                        $response['status'] = 'ERROR';
                    } else {
                        $response['message'] = esc_html__('Invoice payment successful');
                        $response['status'] = 'OK';
                    }
                }
            }
        } else {
            $response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
            $response['status'] = 'ERROR';
        }

        return $response;
    }
}

if (!function_exists('wcop_sp_render_domain_form')) {
    function wcop_sp_generate_domain_form($tabs_class = 'whcom_tabs_fancy_2', $template_name = '01_default')
    {

        ob_start();
        $file = wcop_get_template_directory() . '/templates/single_page/' . $template_name . '/99_domain_form.php';
        if (!is_file($file)) {
            $file = wcop_get_template_directory() . '/templates/single_page/01_default/99_domain_form.php';;
        }
        require $file;

        return ob_get_clean();

    }
}

if (!function_exists('wcop_sp_render_products_dropdown')) {
    function wcop_sp_render_products_dropdown($product_id = '', $pids = '', $gids = '', $domain_products = false, $id_append = '')
    {
        $groups = whcom_get_all_products($gids, $pids);
        $groups = (empty($groups['groups'])) ? [] : $groups['groups'];

        $products = [];
        if (!empty($groups) && is_array($groups)) {
            foreach ($groups as $group) {
                if (!empty($group['products']) && is_array($group['products'])) {
                    foreach ($group['products'] as $product) {
                        if (($domain_products == "yes") && ($product['showdomainoptions'] != "1")) {
                            continue;
                        } else if (($domain_products == "no") && ($product['showdomainoptions'] == "1")) {
                            continue;
                        }
                        $products[] = $product;
                    }
                }
            }
        }
        ob_start();
        ?>
        <select name="pid" id="wcop_sp_product_select<?php echo $id_append ?>"
                title="<?php esc_html_e('Select Product', 'whcom') ?>" data-billingcycle="">
            <option value=""><?php echo esc_html__('Select Product', "whcom") . ": " ?></option>
            <?php foreach ($products as $product) {
                $domain_required = ($product['showdomainoptions'] == "1") ? 'yes' : 'no';
                //== check for free domains
                $is_free_domain = (!empty($product['freedomainpaymentterms']) && !empty($product['freedomaintlds'])) ? 'yes' : 'no';
                ?>
                <option value="<?php echo $product['id']; ?>" <?php echo ($product_id == $product['id']) ? 'selected' : ''; ?>
                        data-domain-required="<?php echo $domain_required; ?>"
                        data-is-free-domain-attached="<?php echo $is_free_domain; ?>">
                    <?php echo $product['name']; ?>
                </option>
            <?php } ?>
        </select>

        <?php //todo: Remove this select in future implement it in a better way.
        ?>
        <div id="wcop_sp_product_free_domain_notice" style="display: none; margin: 15px 0 0;">
            <span><?php esc_html_e('Includes FREE domain', 'whcom') ?></span> <i id="myBtn"
                                                                                 class="whcom_icon_question-circle-o"></i>
        </div>
        <div id="wcop_sp_product_domain_notice" class="whcom_alert whcom_alert_warning whcom_alert_with_icon"
             style="display: none; margin: 15px 0 0;">
            <?php esc_html_e('This product requires a domain to be attached, kindly attach a domain using above form', 'whcom') ?>
        </div>

        <?php
        return ob_get_clean();
    }
}

if (!function_exists('wcop_sp_render_products_description')) {
    function wcop_sp_render_products_description($product_id = '')
    {
        $groups = whcom_get_product($product_id);
        $product_description = $groups['products']['product'][0]['description'];

        return $product_description;
    }
}

if (!function_exists('wcop_sp_render_products_radio')) {
    function wcop_sp_render_products_radio($product_id = '', $pids = '', $gids = '', $domain_products = false, $id_append = '')
    {
        $groups = whcom_get_all_products($gids, $pids);
        $groups = (empty($groups['groups'])) ? [] : $groups['groups'];

        $products = [];
        if (!empty($groups) && is_array($groups)) {
            foreach ($groups as $group) {
                if (!empty($group['products']) && is_array($group['products'])) {
                    foreach ($group['products'] as $product) {
                        if (($domain_products == "yes") && ($product['showdomainoptions'] != "1")) {
                            continue;
                        } else if (($domain_products == "no") && ($product['showdomainoptions'] == "1")) {
                            continue;
                        }
                        $products[] = $product;
                    }
                }
            }
        }
        ob_start();
        ?>
        <div class="whcom_radio_container">
            <div class="whcom_row">
                <?php foreach ($products as $product) {

                    $product_desc = $product['description'];

                    $product_desc = trim(strip_tags($product_desc), "\n");
                    $product_desc = explode("\n", $product_desc);

                    $domain_required = ($product['showdomainoptions'] == "1") ? 'yes' : 'no';
                    ?>
                    <div class="whcom_col_xl_4 whcom_col_lg_6 whcom_col_sm_12">
                        <label class="whcom_label_product whcom_radio">
                    <span class="whcom_product_content">
                    <input type="radio" name="pid" id="wcop_sp_product_select<?php echo $id_append ?>"
                           value="<?php echo $product['id']; ?>" data-domain-required="<?php echo $domain_required; ?>">
                    <strong class="header_product"><?php echo $product['name']; ?></strong>
                        </span>
                            <span class="item_product">
                        <div class="wcop_product_description_sleek"><?php
                            foreach ($product_desc as $line) {
                                if (trim($line) <> "") {
                                    $data = [];
                                    $totay = explode(":", $line);
                                    $data["feature_title"] = trim($totay[0]);
                                    $data["feature_value"] = isset($totay[1]) ? trim($totay[1]) : "";
                                }
                                ?>
                                <strong class="wcop_description_title"><?php echo $data["feature_title"] ?></strong>
                                <span class="wcop_description_value"><?php echo $data["feature_value"] ?></span>

                                <?php
                            }

                            ?></div>
                    </span>
                            <span class="footer_product">
                        <?php echo whcom_render_product_price_no_setup($product); ?>
                    </span>
                        </label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div id="wcop_sp_product_domain_notice" class="whcom_alert whcom_alert_warning whcom_alert_with_icon"
             style="display: none; margin: 15px 0 0;">
            <?php esc_html_e('This product requires a domain to be attached, kindly attach a domain using above form', 'whcom') ?>
        </div>

        <?php
        return ob_get_clean();
    }
}

if (!function_exists('wcop_sp_render_product_billingcycles')) {
    function wcop_sp_render_product_billingcycles($product_details = false, $billing_cycle = '', $current_template = '')
    {
        $product_details = (is_array($product_details)) ? $product_details : whcom_get_product_details((int)$product_details);


        if ((empty($billing_cycle)) && (!empty($product_details['lowest_price']))) {
            reset($product_details['lowest_price']);
            $billing_cycle = key($product_details['lowest_price']);
        }
        $free_domain_billingcycles = [];
        if (!empty ($product_details['freedomainpaymentterms'])) {
            $free_domain_billingcycles = explode(',', $product_details['freedomainpaymentterms']);
        }

        ob_start();
        if (!empty($product_details) && !empty($product_details['lowest_price'])) {
            ?>
            <?php if ($product_details['paytype'] == 'recurring') { ?>
                <div class="wcop_sp_product_billingcycle whcom_form_field">
                    <?php $all_prices = $product_details['all_prices']; ?>
                    <?php
                    $billing_cycle_class = 'wcop_form_control wcop_input';
                    if (!empty($product_details['prd_configoptions'])) {
                        $billing_cycle_class .= ' wcop_update_product_options';
                    }
                    ?>
                    <?php if ($current_template == '08_gator' || $current_template == '06_sleek') { ?>
                        <!-- Make billing cycles as radio in 08_gator and 06_sleek template -->


                        <label><?php esc_html_e("Choose Billing Cycle", "whcom") ?></label>

                        <?php $count = 0; ?>
                        <?php foreach ($all_prices as $key => $price) { ?>

                            <?php $product_billingcycle_label_text = '<strong class="wcop_price_key">' .$key . '</strong>' . " " . '<strong class="wcop_actual_price">' . whcom_format_amount(['amount' => $price['price']]) . ' ' . whcom_convert_billingcycle($key) .'</strong>'  . '<span class="wcop_price_setup_fee">' .' + ' .whcom_format_amount(['amount' => $price['setup']]) . ' ' . esc_html__('Setup Fee', "whcom") . '</span>' ?>
                            <?php ($billing_cycle == $key) ? $current = 'whcom_checked' : $current = ''; ?>
                            <?php ($billing_cycle == $key) ? $checked = 'checked' : $checked = ''; ?>
                            <div class="wcop_sp_radio_billingcycle_box">
                            <input type="radio"
                                   id="wcop_sp_product_billingcycle"
                                   name="billingcycle"
                                   class="<?php echo $billing_cycle_class ?> wcop_input whcom_sp_cc_switcher"
                                   value="<?php echo $key ?>" <?php echo $checked ?>>
                            <?php echo $product_billingcycle_label_text ?>
                            </div>
                            <?php $count++; ?>
                        <?php } ?>


                    <?php } else { ?>
                        <label id="wcop_sp_product_billingcycle_label" for="wcop_sp_product_billingcycle"
                               class="main_label">
                            <?php echo esc_html__('Choose Billing Cycle', "whcom"); ?></label>
                        <select id="wcop_sp_product_billingcycle" name="billingcycle"
                                class="<?php echo $billing_cycle_class ?> wcop_input">
                            <?php $current = '';
                            foreach ($all_prices as $key => $price) {
                                ($billing_cycle == $key) ? $current = 'selected' : $current = '';
                                $option_string = '<option value="' . $key . '" ' . $current . '>';
                                $option_string .= whcom_format_amount(['amount' => $price['price']]) . ' ' . whcom_convert_billingcycle($key) . ' + ' . whcom_format_amount(['amount' => $price['setup']]) . ' ' . esc_html__('Setup Fee', "whcom");
                                if (in_array($key, $free_domain_billingcycles)) {
                                    $option_string .= ' (' . esc_html__('Free Domain only with ' . whcom_render_free_domain_tlds($product_details['freedomaintlds']), "whcom") . ') ';
                                }
                                $option_string .= '</option>';
                                echo $option_string;
                            }
                            ?>
                        </select>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php if ($product_details['paytype'] == 'free') { ?>
                <input id="wcop_sp_product_billingcycle" class="wcop_input" type="hidden" name="billingcycle"
                       value="<?php echo $billing_cycle ?>">
            <?php } ?>
            <?php if ($product_details['paytype'] == 'onetime') { ?>
                <input id="wcop_sp_product_billingcycle" class="wcop_input" type="hidden" name="billingcycle"
                       value="<?php echo $billing_cycle ?>">
            <?php } ?>
            <?php if ($current_template != '08_gator') { ?>
                <div class="wcop_sp_free_tlds_info whcom_padding_0_10">
                    <?php if (!empty($product_details['freedomainpaymentterms']) && !empty($product_details['freedomaintlds'])) { ?>
                        <div class="whcom_alert whcom_alert_info">
                            <div>
                                <?php esc_html_e('Free Domain is only available for following TLD\'s', "whcom") ?>
                            </div>
                            <strong><?php echo whcom_render_free_domain_tlds($product_details['freedomaintlds']); ?></strong>
                        </div>
                        <div class="whcom_alert whcom_alert_info">
                            <div>
                                <?php esc_html_e('Free Domain is only available for following billingcycles...', "whcom") ?>
                            </div>
                            <div>
                                <strong><?php echo whcom_render_free_domain_billingcycles($free_domain_billingcycles); ?></strong>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php
        }

        return ob_get_clean();
    }
}

if (!function_exists('wcop_sp_render_domain_config')) {
    function wcop_sp_render_domain_config($product_details = false, $billing_cycle = '', $style = '')
    {

        $response = [
            'status' => 'ERROR',
            'message' => esc_html__('Loading domain options failed...', 'whcom'),
            'post' => $_POST
        ];
        $domain_type = (!empty($_POST['domaintype'])) ? esc_attr($_POST['domaintype']) : '';
        $tld = (!empty($_POST['tld'])) ? esc_attr($_POST['tld']) : '';
        if ($domain_type == 'existing') {
            $domain_name = (!empty($_POST['domain'])) ? esc_attr($_POST['domain']) : '';
            ob_start(); ?>
            <div class="wcop_sp_domain_no_config whcom_text_center">
                <strong><?php esc_html_e("No configuration for already own domain", "whcom") ?><br>
                </strong>
                <small>(<span id="edit_domain" style=" cursor: pointer"
                              onclick="jQuery( '#wcop_sp_choose_a_domain' ).show();"><?php esc_html_e("change", "whcom") ?></span>)
                </small>
            </div>
            <input type="hidden" name="attached_domain" value="yes">
            <input type="hidden" name="tld" value="<?php echo $tld ?>">
            <input type="hidden" name="domain" value="<?php echo $domain_name ?>">
            <input type="hidden" name="domaintype" value="<?php echo $domain_type ?>">
            <?php
            $response['domain_config_form'] = ob_get_clean();
            $response['status'] = 'OK';
            $response['message'] = '<div class="whcom_alert whcom_alert_success">' . esc_html__('Domain is attached with product...', "whcom") . '</div>';
        } else {

            $domain_name = (!empty($_POST['domain'])) ? esc_attr($_POST['domain']) : '';
            $tld_details = whcom_get_tld_details($tld);
            $free_domain = false;
            if (!empty($product_details['freedomainpaymentterms']) && !empty($product_details['freedomaintlds'])) {
                if (in_array($tld, explode(',', $product_details['freedomaintlds'])) && in_array($billing_cycle, explode(',', $product_details['freedomainpaymentterms']))) {
                    $free_domain = true;
                }
            }

            if (!empty($tld_details)) {
                ob_start();
                $tld_register_prices = $tld_transfer_prices = [];
                foreach ($tld_details['register_price'] as $ry => $rp) {
                    $tld_register_prices[] = [
                        'duration' => $ry,
                        'price' => $rp,
                    ];
                }
                foreach ($tld_details['transfer_price'] as $ty => $tp) {
                    $tld_transfer_prices[] = [
                        'duration' => $ty,
                        'price' => $tp,
                    ];
                }

                ?>
                <input type="hidden" name="attached_domain" value="yes">
                <input type="hidden" name="domain" value="<?php echo $domain_name ?>">
                <input type="hidden" name="tld" value="<?php echo $tld ?>">
                <input type="hidden" name="domaintype" value="<?php echo $domain_type ?>">
                <?php if ($free_domain) { ?>
                    <input type="hidden" name="free_domain" value="yes">
                <?php } else { ?>
                    <input type="hidden" name="free_domain" value="no">
                <?php } ?>
                <div class="whcom_form_field">
                    <label style="float: left;" for="wcop_sp_product_domainduration"
                           class="main_label <?php echo ($free_domain) ? 'wcop_sp_domain_free' : ''; ?>">
                        <?php /*if ( $free_domain ) { */ ?><!--
							<strong><span class="whcom_text_success"><?php /*esc_html_e( 'Free Domain', 'whcom' ) */ ?></span> <i class="whcom_icon_check-circle-o"></i></strong>
						--><?php /*}
						else { */ ?>
                        <strong><?php esc_html_e('Domain Added', 'whcom'); ?></strong>
                        <?php /*} */ ?><br>
                        <small><?php echo $domain_name . " " ?>(<span class="edit_inline_domain" id="edit_domain"
                                                                      style=" cursor: pointer"
                                                                      onclick="jQuery( '#wcop_sp_choose_a_domain' ).show();"><?php esc_html_e("change", "whcom") ?></span>)
                        </small>
                    </label>

                    <!-- Added by zain -->
                    <?php if ($free_domain && $style == '08_gator') { ?>
                        <label class="wcop__domainpricing" style="float: right;">
                            <?php if ($domain_type == 'register') { ?>
                                <small> 1st Year:
                                    <del><?php echo isset($tld_details["register_price"]["1"]) ? whcom_format_amount($tld_details["register_price"]["1"]) : '' ?></del>
                                    <strong>FREE</strong></small><br>
                            <?php } elseif ($domain_type == 'transfer') { ?>
                                <small> 1st Year:
                                    <del><?php echo isset($tld_details["transfer_price"]["1"]) ? whcom_format_amount($tld_details["transfer_price"]["1"]) : '' ?></del>
                                    <strong>FREE</strong></small><br>
                            <?php } ?>
                            <small> Renewal:
                                <del><?php echo isset($tld_details["renew_price"]["1"]) ? whcom_format_amount($tld_details["renew_price"]["1"]) : '' ?></del>
                                <strong>FREE</strong></small>
                        </label>
                        <div class="whcom_clearfix">
                        </div>
                        <!-- End -->
                    <?php } ?>
                    <select id="wcop_sp_product_domainduration" name="regperiod" class="wcop_input"
                            style="<?php echo $free_domain ? 'display:none' : '' ?>"
                            title="<?php esc_html_e('Registration Period', 'whcom') ?>">
                        <?php
                        foreach ($tld_register_prices as $dur) {
                            $dur_txt = esc_html__('for', 'whcom');
                            $dur_txt .= ' ' . $dur['duration'] . ' ';
                            $dur_txt .= ($dur['duration'] == 1) ? esc_html__('Year', 'whcom') : esc_html__('Years', 'whcom');
                            if ($dur['price'] < 0) {
                                continue;
                            }
                            echo '<option value="' . $dur['duration'] . '">' . whcom_format_amount(['amount' => ($free_domain) ? 0.00 : $dur['price']]) . ' ' . $dur_txt . '</option>';
                            if ($domain_type == 'transfer' || $free_domain) {
                                break;
                            }
                        }
                        ?>
                    </select>
                    <div class="loading_class" style="display: none; text-align: center; padding: 50px 0px 0px 0px;">
                        Loading...
                    </div>
                </div>
                <div class="">
                    <?php echo whcom_render_tld_specific_addons($tld, -1, $domain_type) ?>
                </div>
                <div class="">
                    <?php echo whcom_render_tld_specific_fields($tld, -1) ?>
                </div>
                <?php
                $response['domain_config_form'] = ob_get_clean();
                $response['status'] = 'OK';
                $response['free_domain'] = ($free_domain) ? 'yes' : 'no';
                $response['message'] = '<div class="whcom_alert whcom_alert_success">' . esc_html__('Domain is attached with product...', "whcom") . '</div>';
            }
        }

        return $response;
    }
}

if (!function_exists('wcop_sp_generate_order_summary')) {
    function wcop_sp_generate_order_summary($cart_item = [], $template_name = '01_default')
    {
        $summary_html = [];
        if (!empty($_POST['wcop_sp_template'])) {
            $template_name = esc_attr__($_POST['wcop_sp_template']);
        }
        ob_start();
        $file = wcop_get_template_directory() . '/templates/single_page/' . $template_name . '/10_summary_generator.php';
        if (!is_file($file)) {
            $file = wcop_get_template_directory() . '/templates/single_page/01_default/10_summary_generator.php';;
        }
        require $file;
        ob_end_clean();

        return $summary_html;
    }
}

if (!function_exists('wcop_sp_render_promo_html')) {
    function wcop_sp_render_promo_html($current_promo = [], $passed_promocode = '')
    {
        $promocode = (isset($_REQUEST['promocode']) && is_string($_REQUEST['promocode'])) ? $_REQUEST['promocode'] : $passed_promocode;
        ob_start(); ?>
        <div class="whcom_form_field" style="padding: 0;">
            <label for="wcop_coupon"><?php esc_html_e("Coupon Code", "whcom") ?></label>
            <div class="whcom_checkbox_container">
                <div class="whcom_row">
                    <div class="whcom_col_sm_8">
                        <?php if ($promocode) { ?>
                            <div class="whcom_form_field" style="padding: 0; margin: 0;">
                                <input type="text" name="promocode" placeholder="" value="<?php echo $promocode ?>">
                            </div>
                        <?php } else { ?>
                            <div class="whcom_form_field" style="padding: 0; margin: 0;">
                                <input type="text" name="promocode" placeholder="">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="whcom_col_sm_4">
                        <button class="whcom_button whcom_button_primary whcom_button_block wcop_sp_apply_remove_coupon <?php echo '' ?>"
                                data-promo-action="add_coupon">
                            <?php esc_html_e("Validate", "whcom") ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php $promo_form_fields = ob_get_clean();


        ob_start(); ?>

        <?php if (empty($current_promo)) { ?>
        <?php echo $promo_form_fields ?>
        <div class="wcop_sp_coupon_response">
        </div>
    <?php } else { ?>
        <?php
        $promo_status = 'valid';
        if ($current_promo["startdate"] <> "0000-00-00" && $current_promo["expirationdate"] <> "0000-00-00") {
            if (time() < strtotime($current_promo["startdate"]) || time() > strtotime($current_promo["expirationdate"])) {
                $promo_status = 'expired';
            }
        }
        // Checking if promo is usage limit is reached
        if ($current_promo["uses"] > 0 && $current_promo["maxuses"] > 0 && $current_promo["uses"] >= $current_promo["maxuses"]) {
            $promo_status = 'used';
        }

        ?>
        <?php if ($promo_status == 'valid') { ?>
            <div class="whcom_form_field" style="padding: 0;">
                <label for="wcop_coupon"><?php esc_html_e("Coupon Code", "whcom") ?></label>
                <div class="whcom_checkbox_container">
                    <div class="whcom_row">
                        <div class="whcom_col_sm_8">
                            <div class="whcom_alert">
                                <?php echo whcom_generate_promo_applied_text($current_promo) ?>
                                <input type="hidden" name="promocode" value="<?php echo $current_promo['code'] ?>">
                            </div>
                        </div>
                        <div class="whcom_col_sm_4">
                            <button class="whcom_button whcom_button_primary whcom_button_block wcop_sp_apply_remove_coupon"
                                    data-promo-action="remove_coupon">
                                <?php esc_html_e("Remove Coupon", "whcom") ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="whcom_alert whcom_alert_danger whcom_text_center">
                <?php esc_html_e('The promotion code entered has expired', 'whcom') ?>
            </div>
            <?php echo $promo_form_fields ?>
        <?php } ?>

        <div class="wcop_sp_coupon_response">
        </div>
    <?php } ?>
        <?php
        return ob_get_clean();
    }
}

add_shortcode('wcop_promo_code', 'wcop_sp_render_promo_html');

if (!function_exists('wcop_sp_render_estimate_taxes_html')) {
    function wcop_sp_render_estimate_taxes_html()
    {

        $countries = whcom_get_countries_array();

        ob_start(); ?>
        <div class="whcom_row whcom_country_state_container" data-state_name="estimate_tax_state"
             data-state_name_dummy="estimate_tax_state_dummy">
            <div class="whcom_col_sm_4">
                <!-- Country -->
                <div class="whcom_form_field whcom_padding_0">
                    <select class="whcom_country_select" name="estimate_tax_country"
                            title="<?php esc_html_e('Country', "whcom") ?>">
                        <?php
                        foreach ($countries as $code => $country) {
                            $selected = ($code == $_SESSION['whcom_tax_default_country']) ? 'selected="selected"' : '';
                            echo '<option value="' . $code . '" ' . $selected . '>' . $country . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <!-- State -->
                <div class="whcom_form_field whcom_padding_0">
                    <input type="text" class="whcom_state_input"
                           value="<?php echo $_SESSION['whcom_tax_default_state']; ?>" style="display: none;"
                           placeholder="<?php esc_html_e('State/Region', 'whcom') ?>"
                           title="<?php esc_html_e('State/Region', 'whcom') ?>">
                    <select name="state" class="whcom_state_select"
                            title="<?php esc_html_e('State/Region', 'whcom') ?>">
                        <option value="">—</option>
                    </select>
                </div>
            </div>
            <div class="whcom_col_sm_4">
                <div class="whcom_form_field whcom_text_center whcom_padding_0">
                    <label>&nbsp;</label>
                    <button type="submit" class="whcom_button whcom_button_block wcop_sp_estimate_taxes_button">
                        <?php esc_html_e("Update Totals", "whcom") ?>
                    </button>
                </div>
            </div>
        </div>

        <?php
        return ob_get_clean();
    }
}

if (!function_exists('wcop_sp_render_payment_selection')) {
    function wcop_sp_render_payment_selection($form_field_class = 'whcom_form_field_horizontal')
    {
        $payment_gateways = whcom_get_payment_gateways()['payment_gateways'];
        $merchant_gateway = (wcop_use_merchant_gateway() && get_option('merchant_gateway_key', '') != '') ? (string)get_option('merchant_gateway_key') : false;
        $checked = 'checked';
        $checked_class = 'whcom_checked';
        $selected_gateway = '';
        ob_start(); ?>
        <div class="whcom_form_field <?php echo $form_field_class ?>">
            <label><?php esc_html_e("Payment Gateway", "whcom") ?></label>
            <div class="whcom_radio_container">

                <?php foreach ($payment_gateways as $payment_gateway) { ?>
                    <label class="whcom_radio <?php echo $checked_class; ?>">
                        <input type="radio"
                               name="paymentmethod"
                               class="whcom_sp_cc_switcher"
                               value="<?php echo $payment_gateway['module'] ?>" <?php echo $checked; ?>
                               data-merchent-gateway="<?php echo $merchant_gateway; ?>">
                        <?php echo $payment_gateway['displayname']; ?>
                    </label>
                    <?php if ($checked == 'checked') {
                        $selected_gateway = (string)$payment_gateway['module'];
                    } ?>
                    <?php $checked = $checked_class = ''; ?>
                <?php } ?>
            </div>
        </div>

        <?php

        $show_cc = (($merchant_gateway) && ($selected_gateway == $merchant_gateway)) ? 'block' : 'none';
        ?>


        <?php if ($merchant_gateway) { ?>
        <div class="whcom_sp_cc_fields" style="display: <?php echo $show_cc; ?>;">
            <?php echo whcom_render_cc_form(); ?>
        </div>
    <?php }


        return ob_get_clean();
    }
}

if (!function_exists('wcop_sp_render_step_navigation')) {
    function wcop_sp_render_step_navigation($hide_steps_array)
    { ?>
        <?php
        $count = 0;
        foreach ($hide_steps_array as $single_step) {
            if ($single_step == 'yes') {
                $count++;
            }
        }
        ?>

        <div class="wcop-wight-ul">
            <div class="whcom_tabs_container whcom_tabs_fancy_2">
                <ul id="foo" class="whcom_tab_links">
                    <?php if ($count != 5) { ?>
                        <li class="step-0 active">
                            <span>1</span>
                        </li>
                        <?php if ($count != 4) { ?>
                            <li class="step-1">
                                <span>2</span>
                            </li>
                            <?php if ($count != 3) { ?>
                                <li class="step-2">
                                    <span>3</span>
                                </li>
                                <?php if ($count != 2) { ?>
                                    <li class="step-3">
                                        <span>4</span>
                                    </li>
                                    <?php if ($count != 1) { ?>
                                        <li class="step-4">
                                            <span>5</span>
                                        </li>
                                    <?php }
                                }
                            }
                        }
                    } ?>
                </ul>
            </div>
            <hr>
        </div>
    <?php }
}

if (!function_exists('wcop_sp_measure_step_count')) {
    function wcop_sp_measure_step_count($hide_steps_array)
    {
        $initial_step_count = 0;
        $steps_count_array = array();

        $steps_count_array['domain_count'] = 0;
        $steps_count_array['product_count'] = 1;
        $steps_count_array['service_count'] = 2;
        $steps_count_array['billing_count'] = 3;
        $steps_count_array['checkout_count'] = 4;


        if ($hide_steps_array['hide_domain'] == 'yes' && $hide_steps_array['hide_product'] != 'yes' && $hide_steps_array['hide_additional_services'] != 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['domain_count'] = $initial_step_count;

            $steps_count_array['product_count'] = $initial_step_count;
            $steps_count_array['service_count'] = $initial_step_count + 1;
            $steps_count_array['billing_count'] = $initial_step_count + 2;
            $steps_count_array['checkout_count'] = $initial_step_count + 3;
        }
        if ($hide_steps_array['hide_product'] == 'yes' && $hide_steps_array['hide_domain'] != 'yes' && $hide_steps_array['hide_additional_services'] != 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['product_count'] = $initial_step_count;

            $steps_count_array['domain_count'] = $initial_step_count;
            $steps_count_array['service_count'] = $initial_step_count + 1;
            $steps_count_array['billing_count'] = $initial_step_count + 2;
            $steps_count_array['checkout_count'] = $initial_step_count + 3;
        }
        if ($hide_steps_array['hide_additional_services'] == 'yes' && $hide_steps_array['hide_domain'] != 'yes' && $hide_steps_array['hide_product'] != 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['service_count'] = $initial_step_count;

            $steps_count_array['domain_count'] = $initial_step_count;
            $steps_count_array['product_count'] = $initial_step_count + 1;
            $steps_count_array['billing_count'] = $initial_step_count + 2;
            $steps_count_array['checkout_count'] = $initial_step_count + 3;
        }
        if ($hide_steps_array['hide_domain'] == 'yes' && $hide_steps_array['hide_product'] == 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['domain_count'] = $initial_step_count;
            $steps_count_array['product_count'] = $initial_step_count;

            $steps_count_array['service_count'] = $initial_step_count;
            $steps_count_array['billing_count'] = $initial_step_count + 1;
            $steps_count_array['checkout_count'] = $initial_step_count + 2;
        }
        if ($hide_steps_array['hide_domain'] == 'yes' && $hide_steps_array['hide_additional_services'] == 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['domain_count'] = $initial_step_count;
            $steps_count_array['service_count'] = $initial_step_count;

            $steps_count_array['product_count'] = $initial_step_count;
            $steps_count_array['billing_count'] = $initial_step_count + 1;
            $steps_count_array['checkout_count'] = $initial_step_count + 2;
        }
        if ($hide_steps_array['hide_product'] == 'yes' && $hide_steps_array['hide_additional_services'] == 'yes') {
            //== unuseable but don't remove it
            $steps_count_array['product_count'] = $initial_step_count;
            $steps_count_array['service_count'] = $initial_step_count;

            $steps_count_array['domain_count'] = $initial_step_count;
            $steps_count_array['billing_count'] = $initial_step_count + 1;
            $steps_count_array['checkout_count'] = $initial_step_count + 2;
        }

        return $steps_count_array;
    }
}

if (!function_exists('wcop_sp_billing_info_predecessor')) {
    function wcop_sp_billing_info_predecessor()
    {
        if (whcom_is_client_logged_in()) { ?>
            <div class="wcop_sp_section_heading">
                <i class="whcom_icon_user-3"></i>
                <span><?php esc_html_e("Billing Info", "whcom") ?></span>
            </div>
            <div class="wcop_sp_section_content">
                <?php echo whcom_render_logged_in_client_form(); ?>
                <?php echo wcop_sp_render_payment_selection(); ?>
            </div>
        <?php } else { ?>
            <div class="wcop_sp_section wcop_billing_info_predecessor">
                <div class="wcop_sp_section_heading">
                    <i class="whcom_icon_credit-card"></i>
                    <span><?php esc_html_e("Enter Your Billing Info", "whcom") ?></span>
                </div>
                <div class="wcop_billing_info_content wcop_sp_section_content whcom_row">
                    <!-- Register section  -->
                    <div class="whcom_form_field whcom_col_sm_6">
                        <div class="whcom_text_2x"><?php esc_html_e("Don't have an account?", 'whcom') ?></div>
                        <div class="wcop_billing_info_predecessor_text">
                            <p><?php esc_html_e('No problem. Click below to register now and then continue with checkout process', 'whcom') ?></p>
                        </div>
                        <button type="button" id="wcop_sp_client_register_section"
                                class="whcom_button whcom_pull_left whcom_margin_bottom_0"><?php esc_html_e('Register', "whcom") ?></button>
                    </div>
                    <!-- Login Section -->
                    <div class="whcom_form_field whcom_col_sm_6">
                        <div class="whcom_text_2x"><?php esc_html_e('Returning Customer', 'whcom') ?></div>
                        <div class="wcop_billing_info_predecessor_text">
                            <p><?php esc_html_e('If you already have an account click below to log in', 'whcom') ?></p>
                        </div>
                        <button type="button" id="wcop_sp_client_login_section"
                                class="whcom_button whcom_pull_left whcom_margin_bottom_0"><?php esc_html_e('Login', "whcom") ?></button>
                    </div>
                </div>
            </div>
        <?php }
    }
}

