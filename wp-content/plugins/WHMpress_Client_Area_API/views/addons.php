<?php

$userid = whcom_get_current_client_id();
$currency = whcom_get_current_currency();
$current_lang = whcom_get_current_language();

$currency_prefix = $currency["prefix"];
$currency_code = $currency["code"];

//todo: this has gone redentant, check
$response = wcap_get_whmcs_products([
    "currency" => $currency_code,
]);

if ($response["status"] != "OK") {
    wcap_show_error($response["message"]);
} else {
    $products = $response["data"];
}

$store_url = '';
if (wcap_use_whmpress_cart_links()) {
    $field = 'configure_product' . $current_lang;
    $store_url = esc_attr(get_option($field));
}

?>

<?php
// lets get products from other method
$response = wcap_get_all_products_x();
$products_x = $response["data"];

$products = wcap_get_client_products([//"serviceid" => $_POST["id"],
    "status" => "Active",
    "clientid" => $userid,
]);
$is_products_available = true;
if ($products["active_services"] == 0) {
    $is_products_available = false;
} else {
    $active_products = wcap_services_filter($products, "Active", true);
    $active_products = wcap_products_with_addons($products_x, $active_products);
    (count($active_products) == 0) ? $is_products_available = false : $is_products_available = true;
}
?>

<?php
$addons = wcap_get_addons(["clientid" => whcom_get_current_client_id(),]);
$addons = wcap_get_addons();

$payment_method = whcom_get_payment_gateways(); //todo: change to our funciton
$lang = whcom_get_current_language();
$client_area_url = get_option("wcapfield_client_area_url" . $lang);
$client_area_url = $client_area_url . "?whmpca=order_process";
?>

<div class="wcap_services">
    <div class="whcom_row">
        <?php if (wcap_show_side_bar("addons", true)) { ?>
            <div class="whcom_col_sm_3">
                <?php
                wcap_render_categories_panel();
                wcap_render_services_panel_action(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo (wcap_show_side_bar("addons", true)) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Product Addons", "whcom" ) ?></span>
            </div>


            <?php if (!($is_products_available)){ ?>
                    <!-- Message if service is in cacellation -->
                    <div class="whcom_alert whcom_alert_danger whcom_text_center whcom_padding_10_5 whcom_margin_bottom_30">
                    <?php esc_html_e("No Addons Available for your Products & Services", "whcom" ) ?>                                          </div>

                <?php wcap_render_back_to_dashboard_button() ?>

            <?php } ?>

            <?php if ($is_products_available){ ?>
                <?php
                foreach ($addons['data'] as $addon) { ?>
                    <form method="post" class="whcom_op_order_addon">
                        <input type="hidden" name="action" value="whcom_op">
                        <input type="hidden" name="whcom_op_what" value="order_addon">
                        <input type="hidden" name="addonids" value="<?php echo $addon["id"] ?>">

                        <div class="whcom_panel">
                            <div class="whcom_panel_header">
                                <span><?php echo $addon["name"] ?></span>
                            </div>
                            <div class="whcom_panel_body">
                                <div class="whcom_row">
                                    <div class="whcom_col_md_12">
                                        <div class="whcom_op_response"></div>
                                    </div>
                                    <div class="whcom_col_md_7">
                                        <div class="whcom_form_field">
                                            <label for="<?php echo $addon["id"] ?>" class="whcom_text_small">
                                                <?php echo $addon["name"] ?>
                                                <?php echo $addon["description"]; ?>
                                            </label>
                                            <select name="serviceids" title="<?php esc_html_e("Select Service", "whcom" ) ?>">
                                                <?php foreach ($active_products as $product) { ?>
                                                    <option value="<?php echo $product["id"] ?>,<?php echo $product["billingcycle"] ?>">
                                                        <?php echo $product["name"] . " - " . $product["domain"] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="whcom_col_md_5">
                                        <div class="whcom_padding_15_0">
                                            <?php echo whcom_format_amount($addon["monthly"]) . " " . $addon["billingcycle"] ?>
                                            <?php if ($addon["msetupfee"] > 0) {
                                                echo "<br>" . whcom_format_amount($addon["msetupfee"]) . " ";
                                                echo __("Setup Fee", "whcom" );
                                            } ?>
                                            <div class="whcom_form_field whcom_text_left">
                                                <!--<button class="whcom_button" type="submit"><?php /*esc_html_e( "Order Now", "whcom" ) */ ?></button>-->
                                                <button class="whcom_button" type="submit"
                                                        value="submit"><?php esc_html_e("Order Now", "whcom" ) ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>





















