<?php defined('ABSPATH') or die("Cannot access pages directly.");
$cart_item = (!empty($cart_item)) ? $cart_item : [];
$tax_settings = whcom_get_whmcs_setting();
$tax_rates = whcom_get_tax_levels();
$domain_addons = whcom_get_domain_addons();
$product_id = (isset($_REQUEST['pid']) && is_integer(intval($_REQUEST['pid']))) ? $_REQUEST['pid'] : '0';

$current_discount = [];
if (!empty($cart_item['promocode'])) {
    $current_discount = whcom_get_promotion($cart_item['promocode']);
    $current_discount = reset($current_discount);
}


$summary_html = [
    'side' => 'Something went wrong',
];


?>

<?php ob_start(); ?>
<?php whcom_get_whmcs_setting(); ?>
    <div class="summary-simple-4">
        <div class="wcop_sp_summary_details">
            <ul class="whcom_list whcom_list_padded ">
                <?php if (!empty($cart_item)) {
                    $found_item = $product = $addon = $service = false;
                    $domain_text = $domain_details = [];
                    $tld = '';
                    $found_array = [
                        'product' => false,
                        'product_domain' => false,
                        'product_addons' => false,
                        'product_options' => false,
                        'product_domain_free' => false,
                        'addon' => false,
                        'domain' => false,
                        'renew_domain' => false,
                    ];
                    // Check if domain is found
                    if (!empty($cart_item['domain'])) {
                        $tld = whcom_get_tld_from_domain($cart_item['domain']);
                        $domain_details = whcom_get_tld_details($tld);
                        if (!empty($domain_details)) {
                            if ((!empty($cart_item['pid']) && (int)$cart_item['pid'] > 0)) {
                                $found_array['product_domain'] = true;
                            } else {
                                $found_array['domain'] = true;
                            }
                            $found_item = true;
                        }
                    }
                    // Check if product is found
                    if (!empty($cart_item['pid']) && (int)$cart_item['pid'] > 0) {
                        $pid = (empty($cart_item['pid'])) ? 0 : (int)$cart_item['pid'];
                        $billing_cycle = (empty($cart_item['billingcycle'])) ? '' : (string)$cart_item['billingcycle'];
                        $product = whcom_get_product_details($pid);
                        if ($product && !empty($product['lowest_price'])) {
                            $found_array['product'] = $found_item = true;
                            if (!empty($cart_item['configoptions'])) {
                                $found_array['product_options'] = (empty($cart_item['configoptions'])) ? [] : $cart_item['configoptions'];
                            }
                            if (!empty($cart_item['addons'])) {
                                $found_array['product_addons'] = (empty($cart_item['addons'])) ? [] : $cart_item['addons'];
                            }
                            if ($found_array['product_domain']) {
                                $free_domain_billingcycles = explode(',', $product['freedomainpaymentterms']);
                                $free_domain_tlds = explode(',', $product['freedomaintlds']);
                                if (((string)$product['freedomain'] == 'on' || (string)$product['freedomain'] == 'once')
                                    && (in_array($tld, $free_domain_tlds))
                                    && (in_array($cart_item['billingcycle'], $free_domain_billingcycles))
                                    && (in_array($cart_item['billingcycle'], $free_domain_billingcycles))) {
                                    $found_array['product_domain_free'] = true;
                                }
                            }
                        }
                    }

                    ?>

                    <?php // Product ?>
                    <?php if ($found_array['product']) { ?>
                        <?php
                        $hide_group_name_option = $_SESSION['hide_group_name'];
                        $product_price = (float)$product['all_prices'][$cart_item['billingcycle']]['price'];
                        $product_setup = (float)$product['all_prices'][$cart_item['billingcycle']]['setup'];
                        ?>
                        <li>
                            <div class="whcom_op_summary_item_container"
                                 id="whcom_op_summary_item_product_<?php echo $cart_item['pid'] ?>">
                                <div class="whcom_row">
                                    <div class="whcom_col_sm_7">
                                        <span class="whcom_summary_product_group_title"><?php echo $product['name']; ?></span><br>
                                        <?php if ($hide_group_name_option != 'yes') { ?>
                                            <strong class="whcom_summary_product_title"><?php echo $product['group_name']; ?></strong>
                                        <?php } ?>
                                        <?php /*if ( ! empty( $cart_item['domain'] ) ) { */ ?><!--
											<div class="whcom_text_small whcom_summary_product_domain">
												<a href="<?php /*echo $cart_item['domain']; */ ?>"
												   target="_blank"><?php /*echo $cart_item['domain']; */ ?></a>
											</div>
										--><?php /*} */ ?>
                                        <?php if (!empty($cart_item['hostname'])) { ?>
                                            <div class="whcom_text_small whcom_summary_product_hostname">
                                                <?php echo $cart_item['hostname']; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="whcom_col_sm_5 whcom_text_right">
                                        <div class="whcom_op_summary_item_price wcop_sp_replace_spinner whcom_summary_product_price <?php echo ((float)$product_price > 0) ? '' : 'free'; ?>">
                                            <strong><?php echo whcom_format_amount($product_price) ?></strong>
                                        </div>
                                        <div class="whcom_text_small whcom_summary_product_billingcycle">
                                            <?php echo whcom_convert_billingcycle($cart_item['billingcycle']); ?>
                                        </div>
                                        <div class="whcom_text_small wcop_sp_replace_spinner whcom_summary_product_setup <?php echo ((float)$product_setup > 0) ? '' : 'free'; ?>">
                                            <?php echo $product_setup == 0 ? "<i>Free</i>" : '<i>' . whcom_format_amount($product_setup) . '</i>' ?>
                                            <i><?php esc_html_e('Setup', 'whcom') ?></i>
                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_12">
                                    <?php if ($found_array['product_options']) { ?>
                                        <div class="whcom_text_small whcom_summary_product_configoptions whcom_padding_0_10">
                                            <?php foreach ($found_array['product_options'] as $option_id => $sub_option_id) { ?>
                                                <?php
                                                $curr_option = $product['prd_configoptions'][$option_id];
                                                $curr_option_html = $curr_option['optionname'] . ' ';
                                                $configoption_amount = 0.00;
                                                $configoption_setup = 0.00;
                                                ?>
                                                <?php switch ($curr_option['optiontype']) {
                                                    case '1':
                                                    case '2' :
                                                        {
                                                            $curr_sub_option = $curr_option['sub_options'][$sub_option_id];
                                                            $curr_option_html .= '(' . whcom_format_amount($curr_sub_option['all_prices'][$cart_item['billingcycle']]['price']) . ')';
                                                            $configoption_amount = (float)$curr_sub_option['all_prices'][$cart_item['billingcycle']]['price'];
                                                            $configoption_setup = (float)$curr_sub_option['all_prices'][$cart_item['billingcycle']]['setup'];
                                                            break;
                                                        }
                                                    case '3' :
                                                        {
                                                            $curr_sub_option = reset($curr_option['sub_options']);
                                                            if ($sub_option_id > 0) {
                                                                $curr_option_html .= '(' . whcom_format_amount($curr_sub_option['all_prices'][$cart_item['billingcycle']]['price']) . ')';
                                                                $configoption_amount = (float)$curr_sub_option['all_prices'][$cart_item['billingcycle']]['price'];
                                                                $configoption_setup = (float)$curr_sub_option['all_prices'][$cart_item['billingcycle']]['setup'];
                                                            }
                                                            break;
                                                        }
                                                    case '4' :
                                                        {
                                                            $curr_sub_option = reset($curr_option['sub_options']);
                                                            $curr_option_html .= '(';
                                                            $curr_option_html .= whcom_format_amount($curr_sub_option['all_prices'][$cart_item['billingcycle']]['price']) . ' x ';
                                                            $curr_option_html .= $sub_option_id;
                                                            $curr_option_html .= ')';

                                                            $configoption_amount = (float)($curr_sub_option['all_prices'][$cart_item['billingcycle']]['price'] * $sub_option_id);
                                                            $configoption_setup = (float)($curr_sub_option['all_prices'][$cart_item['billingcycle']]['setup'] * $sub_option_id);
                                                            break;
                                                        }
                                                    default :
                                                        {
                                                            $curr_sub_option = [];
                                                        }
                                                }
                                                ?>
                                                <div class="whcom_summary_product_configoption">
                                                    <i class="whcom_icon_angle-double-right"></i> <?php echo $curr_option_html ?>
                                                </div>
                                                <?php $product_price = $product_price + $configoption_amount; ?>
                                                <?php $product_setup = $product_setup + $configoption_setup; ?>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    </div>
                                    <?php // Final Array Population -> product


                                    // If product is discounted
                                    if (whcom_validate_item_promotion('product', $product['id'], $cart_item['billingcycle'], $current_discount)) {
                                        $product_discounts = whcom_apply_item_discount($product_price, $product_setup, $current_discount);
                                        $product_price = $product_discounts['price'];
                                        $product_setup = $product_discounts['setup'];
                                        $totals['discount'] = $totals['discount'] + $product_discounts['discount'];
                                    }

                                    $totals[$cart_item['billingcycle']] = $product_price;
                                    $product_total = $product_price + $product_setup;
                                    if (!empty($product['tax']) && $product['tax'] == '1') {
                                        $product_total = whcom_calculate_tax($product_total, $tax_settings);
                                        $totals['base_price'] = $totals['base_price'] + $product_total['base_price'];
                                        $totals['l1_amount'] = $totals['l1_amount'] + $product_total['l1_amount'];
                                        $totals['l2_amount'] = $totals['l2_amount'] + $product_total['l2_amount'];
                                        $totals['final_price'] = $totals['final_price'] + $product_total['final_price'];
                                    } else {
                                        $totals['base_price'] = $totals['base_price'] + $product_total;
                                        $totals['final_price'] = $totals['final_price'] + $product_total;
                                    }
                                    ?>
                                </div>


                            </div>
                        </li>
                    <?php } ?>

                    <?php
                    $show_prod_desc = $_SESSION['prod_desc'];
                    if ($show_prod_desc == 'yes') { ?>
                    <!-- Product Description -->
                    <div class="summary_product_description whcom_text_small"><?php
                        if (!empty($_REQUEST['pid'])) {
                            echo '<strong>Includes: </strong>' . wcop_sp_render_products_description($_REQUEST['pid']);
                        }
                        ?>
                    </div>
                        <?php } ?>

                    <?php // Addons with product ?>
                    <?php if ($found_array['product_addons']) { ?>
                        <?php foreach ($found_array['product_addons'] as $addon_id) { ?>
                            <li>
                                <div class="whcom_op_summary_item_container whcom_sp_product_addons"
                                     id="whcom_op_summary_item_product_addon_<?php echo $addon_id ?>">
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_7">
                                            <?php
                                            $curr_addon = $product['prd_addons'][$addon_id];
                                            // Addon price logic
                                            $addon_billingcycle = strtolower($curr_addon['billingcycle']);
                                            if ($addon_billingcycle == 'recurring') {
                                                if (isset($curr_addon[$cart_item['billingcycle']]) && $curr_addon[$cart_item['billingcycle']] >= 0) {
                                                    $addon_billingcycle = $cart_item['billingcycle'];
                                                    $curr_addon_price = $curr_addon['all_prices'][$addon_billingcycle]['price'];
                                                    $curr_addon_setup = $curr_addon['all_prices'][$addon_billingcycle]['setup'];
                                                } else {
                                                    reset($curr_addon['lowest_price']);
                                                    $addon_billingcycle = key($curr_addon['lowest_price']);
                                                    $curr_addon_price = $curr_addon['lowest_price'][$addon_billingcycle]['price'];
                                                    $curr_addon_setup = $curr_addon['lowest_price'][$addon_billingcycle]['setup'];
                                                }
                                            } else if ($addon_billingcycle == 'free') {
                                                $curr_addon_price = 0.00;
                                                $curr_addon_setup = 0.00;
                                            } else {
                                                $curr_addon_price = $curr_addon['monthly'];
                                                $curr_addon_setup = $curr_addon['msetupfee'];
                                            }
                                            ?>
                                            <div>
                                                <strong class="whcom_op_summary_item_product_addon_title"><?php echo $curr_addon['name']; ?></strong>
                                                <div class="whcom_text_small whcom_op_summary_item_product_addon_label">
                                                    <?php /*esc_html_e("Addon", "whcom"); */?>
                                                </div>
                                                <div class="whcom_text_small  wcop_sp_replace_spinner whcom_op_summary_item_product_addon_setup">
                                                    <?php echo $curr_addon_setup == 0 ? 'Free' : whcom_format_amount($curr_addon_setup); ?>
                                                    <?php esc_html_e("Setup Fee", "whcom"); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="whcom_col_sm_5 whcom_text_right  wcop_sp_replace_spinner whcom_op_summary_item_product_addon_price">
                                            <?php echo whcom_format_amount($curr_addon_price); ?>
                                            <div class="whcom_text_small whcom_op_summary_item_product_addon_billingcycle">
                                                <?php echo whcom_convert_billingcycle($addon_billingcycle); ?>
                                            </div>
                                        </div>

                                        <?php

                                        // If Product -> Addons is discounted
                                        if (whcom_validate_item_promotion('addon', $addon_id, $addon_billingcycle, $current_discount)) {
                                            $curr_addon_discounts = whcom_apply_item_discount($curr_addon_price, $curr_addon_setup, $current_discount);
                                            $curr_addon_price = $curr_addon_discounts['price'];
                                            $curr_addon_setup = $curr_addon_discounts['setup'];
                                            $totals['discount'] = $totals['discount'] + $curr_addon_discounts['discount'];
                                        }

                                        // Final Array Population -> product-addons
                                        $totals[$addon_billingcycle] = $totals[$addon_billingcycle] + $curr_addon_price;
                                        $curr_addon_total = $curr_addon_price + $curr_addon_setup;

                                        if (!empty($curr_addon['tax']) && $curr_addon['tax'] == '1') {
                                            $curr_addon_total = whcom_calculate_tax($curr_addon_total, $tax_settings);
                                            $totals['base_price'] = $totals['base_price'] + $curr_addon_total['base_price'];
                                            $totals['l1_amount'] = $totals['l1_amount'] + $curr_addon_total['l1_amount'];
                                            $totals['l2_amount'] = $totals['l2_amount'] + $curr_addon_total['l2_amount'];
                                            $totals['final_price'] = $totals['final_price'] + $curr_addon_total['final_price'];
                                        } else {
                                            $totals['base_price'] = $totals['base_price'] + $curr_addon_total;
                                            $totals['final_price'] = $totals['final_price'] + $curr_addon_total;
                                        }

                                        ?>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    <?php } ?>

                    <?php // Domain, with or without product ?>
                    <?php if (!empty($domain_details)) { ?>
                        <li class="whcom__domiandetials">
                            <div class="whcom_op_summary_item_container whcom_op_summary_item_domain">
                                <?php
                                $domain_text = whcom_generate_domain_text($domain_details, $cart_item['domaintype'], $cart_item['regperiod'], $found_array['product_domain_free'], $cart_index);
                                $domain_price = (float)$domain_text['price'];
                                ?>

                                <div class="whcom_op_summary_item_domains">
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_7">
                                            <strong class="whcom_op_summary_item_domain_label"><?php esc_html_e('Domain ', 'whcom') ?><?php echo ($cart_item['domaintype'] == 'register') ? esc_html__("Registration", "whcom") : ucfirst($cart_item['domaintype']); ?></strong>
                                            <div class="whcom_text_small whcom_op_summary_item_domain_link">
                                                <!-- make domain as un clickable by zain -->
                                                <?php echo $cart_item['domain']; ?>
                                                <!-- end -->

                                                <!--<a href="<?php /*echo $cart_item['domain']; */ ?>"
                                                   target="_blank"><?php /*echo $cart_item['domain']; */ ?></a>-->
                                            </div>
                                            <div class="whcom_text_small whcom_padding_0_10 whcom_op_summary_item_domain_addons">
                                                <?php if (!empty($cart_item['dnsmanagement'])) { ?>
                                                    <?php $domain_addon_price = (float)$domain_addons['dnsmanagement'] * (float)$cart_item['regperiod']; ?>
                                                    <div class="whcom_op_summary_item_domain_dnsmanagement  wcop_sp_replace_spinner">
                                                        <i
                                                                class="whcom_icon_angle-double-right"></i>
                                                        <?php esc_html_e("DNS Management", 'whcom') ?>
                                                        - <?php echo whcom_format_amount($domain_addon_price) . ' ' . $domain_text['text']; ?>
                                                    </div>
                                                    <?php $domain_price = $domain_price + (float)$domain_addon_price; ?>
                                                <?php } ?>
                                                <?php if (!empty($cart_item['emailforwarding'])) { ?>
                                                    <?php $domain_addon_price = (float)$domain_addons['emailforwarding'] * (float)$cart_item['regperiod']; ?>
                                                    <div class="whcom_op_summary_item_domain_emailforwarding  wcop_sp_replace_spinner">
                                                        <i
                                                                class="whcom_icon_angle-double-right"></i>
                                                        <?php esc_html_e("Email Forwarding", 'whcom') ?>
                                                        - <?php echo whcom_format_amount($domain_addon_price) . ' ' . $domain_text['text']; ?>
                                                    </div>
                                                    <?php $domain_price = $domain_price + (float)$domain_addon_price; ?>
                                                <?php } ?>
                                                <?php if (!empty($cart_item['idprotection'])) { ?>
                                                    <?php $domain_addon_price = (float)$domain_addons['idprotection'] * (float)$cart_item['regperiod']; ?>
                                                    <div class="whcom_op_summary_item_domain_idprotection  wcop_sp_replace_spinner">
                                                        <i
                                                                class="whcom_icon_angle-double-right"></i>
                                                        <?php esc_html_e("ID Protection", 'whcom') ?>
                                                        - <?php echo whcom_format_amount($domain_addon_price) . ' ' . $domain_text['text']; ?>
                                                    </div>
                                                    <?php $domain_price = $domain_price + (float)$domain_addon_price; ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="whcom_col_sm_5 whcom_text_right wcop_sp_replace_spinner whcom_op_summary_item_domain_price">
                                            <?php echo ($domain_price == 0) ? "<strong>FREE</strong>" : whcom_format_amount($domain_price); ?>
                                            <div class="whcom_op_summary_item_domain_text">
                                                <?php
                                                if ($cart_item['domaintype'] == "register") {
                                                    echo $found_array['product_domain_free'] == true ? '<del>' . whcom_format_amount($domain_details["register_price"]["1"]) . '</del>' : strtolower($domain_text['text']);
                                                } elseif ($cart_item['domaintype'] == 'transfer') {
                                                    echo $found_array['product_domain_free'] == true ? '<del>' . whcom_format_amount($domain_details["transfer_price"]["1"]) . '</del>' : strtolower($domain_text['text']);
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <?php

                                // If Domain is discounted
                                if (whcom_validate_item_promotion('domain', $domain_details['extension'], $cart_item['regperiod'], $current_discount)) {
                                    $domain_discounts = whcom_apply_item_discount($domain_price, 0.00, $current_discount);
                                    $domain_price = $domain_discounts['price'];
                                    $totals['discount'] = $totals['discount'] + $domain_discounts['discount'];
                                }


                                // Final Array Population -> domain
                                if (!empty($tax_settings['TaxDomains']) && $tax_settings['TaxDomains'] == 'on') {
                                    $domain_price = whcom_calculate_tax($domain_price, $tax_settings);
                                    $totals['base_price'] = $totals['base_price'] + $domain_price['base_price'];
                                    $totals['l1_amount'] = $totals['l1_amount'] + $domain_price['l1_amount'];
                                    $totals['l2_amount'] = $totals['l2_amount'] + $domain_price['l2_amount'];
                                    $totals['final_price'] = $totals['final_price'] + $domain_price['final_price'];
                                } else {
                                    $totals['base_price'] = $totals['base_price'] + $domain_price;
                                    $totals['final_price'] = $totals['final_price'] + $domain_price;
                                }
                                ?>
                            </div>
                        </li>
                    <?php } ?>
                    <?php $counter++; ?>


                <?php } ?>
            </ul>
        </div>
        <div class="wcop_sp_summary_totals">
            <!--<div class="whcom_clearfix whcom_margin_bottom_5 whcom_padding_5_0 ">
				<span class="whcom_pull_left"><?php /*esc_html_e( 'Subtotal', 'whcom' ) */ ?></span>
				<span class="whcom_pull_right  wcop_sp_replace_spinner"><?php /*echo whcom_format_amount( $totals['base_price'] + $totals['discount'] ); */ ?></span>
			</div>-->
            <?php if ($totals['l1_amount'] > 0 || $totals['l2_amount'] > 0 || $totals['discount'] > 0) { ?>
                <div class="whcom_padding_10_0 ">
                    <?php if ($totals['discount'] > 0) { ?>
                        <?php
                        $discount_value = $current_discount['value'];
                        $discount_type = esc_html__("One Time Discount", "whcom");
                        if ($current_discount['recurring'] == '1') {
                            $discount_type = esc_html__("Recurring Discount", "whcom");
                        }

                        switch ($current_discount['type']) {
                            case 'Free Setup' :
                                {
                                    $discount_value = esc_html__("Free Setup", "whcom");
                                    break;
                                }
                            case 'Fixed Amount' :
                                {
                                    $discount_value = whcom_format_amount($current_discount['value']);
                                    break;
                                }
                            case 'Price Override' :
                                {
                                    $discount_value = whcom_format_amount($current_discount['value']) . ' ' . esc_html__("Price Override", "whcom");
                                    break;
                                }
                            case 'Percentage' :
                                {
                                    $discount_value = $current_discount['value'] . esc_html__("%", "whcom");
                                    break;
                                }
                            default :
                                {

                                }
                        }
                        ?>
                        <div class="whcom_clearfix">
							<span class="whcom_pull_left">
								<?php echo $discount_value; ?>
                                <?php echo $discount_type; ?>
							</span>
                            <span class="whcom_pull_right  wcop_sp_replace_spinner"><?php echo whcom_format_amount($totals['discount']); ?></span>
                        </div>


                    <?php } ?>
                    <?php if ($totals['l1_amount'] > 0) { ?>

                        <div class="whcom_clearfix">
                        <span class="whcom_pull_left"><?php echo $tax_rates['level1_title'] ?>
                            &#64; <?php echo $tax_rates['level1_rate'] ?>&#37;</span>
                            <span class="whcom_pull_right  wcop_sp_replace_spinner"><?php echo whcom_format_amount($totals['l1_amount']); ?></span>
                        </div>
                    <?php } ?>
                    <?php if ($totals['l2_amount'] > 0) { ?>

                        <div class="whcom_clearfix">
                        <span class="whcom_pull_left"><?php echo $tax_rates['level2_title'] ?>
                            &#64; <?php echo $tax_rates['level2_rate'] ?>&#37;</span>
                            <span class="whcom_pull_right  wcop_sp_replace_spinner"><?php echo whcom_format_amount($totals['l2_amount']); ?></span>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if (empty(get_option('whcom_hide_calculate_discount_box', ''))) { ?>
                <?php $hide_promo_section = $_SESSION['hide_promo'] ?>
                <?php if (strtolower($hide_promo_section) != 'yes' && !empty($cart_item)) { ?>
                    <!--<strong><?php /*esc_html_e( 'Apply Promo Code', "whcom" ) */ ?></strong>-->
                    <div class="wcop_sp_promo_container">
                        <?php
                        $passed_promocode = $_SESSION['promocode'];
                        $promocode = (isset($_POST['promocode']) && is_string($_POST['promocode'])) ? $_POST['promocode'] : $passed_promocode;
                        $current_promo = whcom_get_promotion($promocode);
                        $current_promo = reset($current_promo);
                        ob_start(); ?>
                        <div class="whcom_form_field" style="padding: 0;">
                            <div class="whcom_checkbox_container">
                                <div class="whcom_row">
                                    <div class="whcom_col_sm_6">
                                        <?php if ($promocode) { ?>
                                            <div class="whcom_form_field" style="padding: 0; margin: 0;">
                                                <label for="wcop_coupon" class="cpn"><?php esc_html_e("Coupon Code", "whcom") ?></label>
                                                <input type="text" name="promocode" placeholder=""
                                                       value="<?php echo $promocode ?>">
                                            </div>
                                        <?php } else { ?>
                                            <div class="whcom_form_field" style="padding: 0; margin: 0;">
                                                <label for="wcop_coupon"><?php esc_html_e("Coupon Code", "whcom") ?></label>
                                                <input type="text" name="promocode" placeholder="">
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="whcom_col_sm_6">
                                        <button class="whcom_button whcom_button_primary whcom_button_block wcop_sp_summary_apply_remove_coupon <?php echo '' ?>"
                                                data-promo-action="add_coupon">
                                            <?php esc_html_e("Apply Coupon", "whcom") ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $promo_form_fields = ob_get_clean(); ?>
                        <?php if (empty($promocode)) { ?>
                            <?php echo $promo_form_fields ?>
                        <?php } else { ?>
                            <?php
                            $promo_status = 'valid';
                            if ($current_promo["startdate"] != "0000-00-00" && $current_promo["expirationdate"] != "0000-00-00") {
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
                                    <div class="whcom_checkbox_container">
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_6">
                                                <div class="whcom_alert">
                                                    <?php echo $current_promo['code'] ?>
                                                    <label for="wcop_coupon"><?php esc_html_e("Coupon Code", "whcom") ?></label>
                                                    <input type="hidden" name="promocode"
                                                           value="<?php echo $current_promo['code'] ?>">
                                                </div>
                                            </div>
                                            <div class="whcom_col_sm_6">
                                                <button class="whcom_button whcom_button_primary whcom_button_block wcop_sp_summary_apply_remove_coupon"
                                                        data-promo-action="remove_coupon">
                                                    <?php esc_html_e("Remove Coupon", "whcom") ?>
                                                </button>
                                            </div>
<!--                                            <div class="whcom_col_sm_12">-->
<!--                                                <small>--><?php //whcom_generate_promo_applied_text($current_promo) ?><!-- </small>-->
<!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <!--<div class="whcom_alert whcom_alert_danger whcom_text_center">
                                    <?php /*esc_html_e('The promotion code entered has expired', 'whcom') */?>
                                </div>-->
                                <?php echo $promo_form_fields ?>
                            <?php } ?>

                            <div class="wcop_sp_coupon_response">
                            </div>
                        <?php } ?>
                    </div>
                <?php }
            } ?>
            <div class="whcom_clearfix whcom_margin_bottom_5">
                <div class="whcom_pull_left_sm">
                    <span class="whcom_pull_left"><?php esc_html_e('Totals (Recurring)', 'whcom') ?></span>
                </div>
                <div class="whcom_pull_right_sm">
                    <?php
                    $billingcycles = [
                        'monthly',
                        'quarterly',
                        'semiannually',
                        'annually',
                        'biennially',
                        'triennially',
                    ];
                    ?>
                    <?php foreach ($totals as $key => $total) { ?>
                        <?php if ($total && in_array($key, $billingcycles)) { ?>
                            <div class="whcom_clearfix">
                                <div class="whcom_pull_right  wcop_sp_replace_spinner">
                                    <span><?php echo whcom_format_amount($total); ?></span>
                                    <span><?php echo whcom_convert_billingcycle($key) ?></span>
                                </div>
                            </div>
                            <?php break; ?>
                        <?php }else{ ?>
                            <div class="whcom_clearfix">
                                <div class="whcom_pull_right  wcop_sp_replace_spinner">
                                    <span><?php echo "0" ?></span>
                                </div>
                            </div>
                            <?php break; ?>
                    <?php } } ?>
                </div>
            </div>

            <div class="whcom_clearfix">
                <div class="whcom_text_right  wcop_sp_replace_spinner wcop_sp_replace_spinner whcom_text_2x">
                    <?php echo whcom_format_amount(['amount' => $totals['final_price'], 'add_suffix' => 'yes']); ?>
                </div>
                <div class="whcom_text_right desktop_summry_total_price"><?php esc_html_e('Total Due Today', 'whcom') ?></div>
                <div class="whcom_text_right mobile_summry_total_price"><?php esc_html_e('Total', 'whcom') ?></div>
            </div>

        </div>
    </div>
<?php ob_start();
if (!empty ($cart_item['promocode'])) {
    if (!empty($current_discount) && $current_discount["startdate"] <> "0000-00-00" && $current_discount["expirationdate"] <> "0000-00-00") {
        if (time() < strtotime($current_discount["startdate"]) || time() > strtotime($current_discount["expirationdate"])) { ?>
            <div class="whcom_alert whcom_alert_warning">
                <?php esc_html_e("The promotion code you entered has been expired", "whcom") ?>
            </div>
        <?php }
    } elseif (!empty($current_discount) && $current_discount["uses"] > 0 && $current_discount["maxuses"] > 0 && $current_discount["uses"] >= $current_discount["maxuses"]) { ?>
        <div class="whcom_alert whcom_alert_warning">
            <small> <?php esc_html_e("The coupon code you entered has been reached its limit", "whcom") ?></small>
        </div>
    <?php } elseif ((float)$totals['discount'] > 0.00) { ?>
        <div class="whcom_alert whcom_alert_success">
            <small><?php esc_html_e("Coupon accepted! Your order total is updated.", "whcom") ?></small>
        </div>
    <?php } else if (!empty($current_discount)) { ?>
        <div class="whcom_alert whcom_alert_info">
            <small><?php esc_html_e("promotion code valid, but does not apply to selected product.", "whcom") ?></small>
        </div>
    <?php } else { ?>
        <div class="whcom_alert whcom_alert_warning">
            <small><?php esc_html_e("Coupon is not valid", "whcom") ?></small>
        </div>
    <?php } ?>
<?php }
// Todo: place it on appropriate place
/*$taxes_temp = whcom_get_tax_levels();
if ( $taxes_temp['hav_countries'] ) { */ ?><!--
	<?php /*if ( $taxes_temp['hav_countries'] ) { */ ?>
		<strong><?php /*esc_html_e( 'Estimate Taxes', "whcom" ) */ ?></strong>
		<div class="whcom_tabs_content" id="wcop_sp_estimate_taxes_container">
			<div class="wcop_sp_estimate_taxes_container">
				<?php /*echo wcop_sp_render_estimate_taxes_html(); */ ?>
			</div>
		</div>
	<?php /*} */ ?>
--><?php /*}*/
$discount_message = ob_get_clean(); ?>

<?php

$summary_html = [
    'side' => ob_get_clean(),
    'free_domain' => $found_array['product_domain_free'],
    'no_options' => $no_options,
    'discount_message' => $discount_message
];