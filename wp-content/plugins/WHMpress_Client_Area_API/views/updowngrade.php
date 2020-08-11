<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("my_services");

$service_id = $_POST["id"];
$upgrade_type = $_POST["type"];

if (isset($_POST["upoptions_id"])) {
    $service_id = isset($_POST["upoptions_id"]);
}

$product = wcap_get_client_products([
    "serviceid" => $service_id,
]);

$product_fetched=FALSE;

if ($product["result"] == "success") {
    $product_fetched=TRUE;
    $product = $product["products"]["product"][0];

    $product_id = $product["pid"];
    $product_group = $product["translated_groupname"];
    $product_name = $product["translated_name"];
    $product_domain = $product["domain"];
    $product_billingcycle = $product["billingcycle"];
    $invoice_pending = wcap_service_pending_invoice($user_id, $service_id);
    if ($upgrade_type == "configoptions") {
        $config_options = $product["configoptions"]["configoption"];
    }

}

$curr = whcom_get_current_currency();

$payment_method = wcap_get_client_payment_method();
$user_id = whcom_get_current_client_id();


$args = [
    "userid" => $user_id,
    "status" => "Unpaid"
];


?>

<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_header">
                        <?php esc_html_e('Up/Downgrade', "whcom") ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_bordered whcom_list_padded">
                            <li>
                                <div>
                                    <?php echo __("Product/Service", "whcom") ?>
                                </div>

                                <strong>
                                    <?php echo $product_group . " - " . $product_name; ?>
                                </strong>
                            </li>
                            <li>
                                <div><?php echo esc_html__("Domain", "whcom") . ":" ?></div>
                                <?php echo $product_domain ?>
                            </li>
                        </ul>
                    </div>
                    <div class="whcom_panel_footer">
                        <a class="wcap_load_page"
                           href=" <?php echo "id=" . $service_id ?>"
                           data-page="productdetails">
                            <button class="whcom_button whcom_button_block">
                                <span class="whcom_icon_angle-circled-left"></span>
                                <?php esc_html_e("Back to Service Details", "whcom") ?>
                            </button>
                        </a>

                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span>
                    <?php
                    if ($upgrade_type == "configoptions") {
                        esc_html_e("Upgrade/Downgrade Options", "whcom");
                    } else {
                        esc_html_e("Upgrade/Downgrade", "whcom");
                    }
                    ?>
                </span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">
                <div class="">

                    <?php if (! ($product_fetched)) {
                        echo wcap_render_message("ERROR", $product["message"], "danger");
                    }
                    ?>

                    <?php if ($product_fetched) {  ?>

                        <?php if ($invoice_pending) { ?>
                            <!-- invoice pending messages -->
                            <div class="whcom_alert whcom_alert_warning">
                                <p>
                                    <?php esc_html_e("You cannot currently upgrade or downgrade this product because an invoice has already been generated for the next renewal.", "whcom"); ?>
                                </p>

                                <p>
                                    <?php esc_html_e("To proceed, please first pay the outstanding invoice and then you will be able to upgrade or downgrade immediately following that and be charged the difference or credited as appropriate.", "whcom"); ?>

                                </p>
                            </div>
                            <div class="whcom_text_left">
                                <?php echo wcap_render_back_button(
                                        "productdetails",
                                        "id=" . $service_id
                                );
/*                                <a href="<?php echo "?whmpca=productdetails&id=" . $service_id ?>">
                                    <button class="button_secondary"><?php esc_html_e("back", "whcom") */?><!--</button>
 </a>-->
                            </div>
                        <?php } ?>


                        <?php if (!($invoice_pending) && $upgrade_type != "configoptions") { ?>
                            <!-- product upgrade start -->
                            <div id="upgrade_package" class="whcom_margin_bottom_30">
                                <p>
                                    <?php _e("Choose the package you want to upgrade/downgrade your current package to from the options below.", "whcom") ?>
                                </p>
                                <div class="whcom_row whcom_margin_bottom_30">
                                    <div class="whcom_col_sm_3">
                                        <?php _e("Current Configuration", "whcom") ?>:
                                    </div>
                                    <div class="whcom_col_sm_9">
                                        <strong><?php echo $product_group . " - " . $product_name ?></strong>
                                        <?php echo ($product_domain != "") ? "(" . $product_domain . ")" : ""; ?>
                                    </div>
                                </div>

                                <div class="whcom_row">
                                    <div class="whcom_col_sm_3 whcom_margin_bottom_15">
                                        <?php _e("New Configuration", "whcom") ?>:
                                    </div>
                                </div>

                                <?php
                                ## Getting upgrade-able products from database.
                                $pids = wcap_get_upgradable_products("pid=" . $product["pid"]);
                                if (empty($pids)) {
                                    $products = [];
                                } else {
                                    ## Converting product ids into csv string.
                                    $pids = implode(",", $pids);
                                    $products = wcap_get_products("pid=$pids");
                                }

                                if (empty($products)) {
                                    echo "<h2>No upgradable options!</h2>";
                                }

                                foreach ($products as $key => $prd) {
                                    if ($key == "total") {
                                        continue;
                                    } else if (is_numeric($key)) {
                                        $group_id = $products[$key][0]["gid"];
                                        //echo "Group ID: " . $group_id;

                                        $payment_method = wcap_get_client_payment_method();

                                        foreach ($products[$key] as $product1) {
                                            ?>
                                            <div class="whcom_panel">
                                                <div class="whcom_panel_header">
                                                    <strong><?php echo $product1["name"] ?></strong>
                                                </div>
                                                <div class="whcom_panel_body">
                                                    <div class="whcom_margin_bottom_15 whcom_text_left">
                                                        <div class="whcom_row">
                                                            <div class="whcom_col_sm_7">
                                                                <?php echo $product1["description"]; ?>
                                                            </div>
                                                            <div class="whcom_col_sm_5">
                                                                <form class="updowngrade_form">
                                                                    <input type="hidden" name="action"
                                                                           value="wcap_requests">
                                                                    <input type="hidden" name="calconly" value="1">
                                                                    <input type="hidden" name="what"
                                                                           value="calculate_updowngrade">
                                                                    <input type="hidden" name="newproductid"
                                                                           value="<?php echo $product1["pid"] ?>">
                                                                    <input type="hidden" name="serviceid"
                                                                           value="<?php echo $product["id"] ?>">
                                                                    <input type="hidden" name="paymentmethod"
                                                                           value="<?php echo $payment_method ?>">
                                                                    <div class="whcom_margin_bottom_15 whcom_form_field">
                                                                        <select name="newproductbillingcycle">
                                                                            <?php if ($product1['paytype'] == 'recurring') { ?>
	                                                                            <?php foreach ($product1["price_info2"][$curr["code"]] as $k => $prd) {
		                                                                            $setupfee = $product1["price_setup_info"][$curr["code"]][substr($k, 0, 1) . "setupfee"];
		                                                                            ?>
                                                                                    <option value="<?php echo $k ?>">
			                                                                            <?php echo $curr["prefix"] . $prd . " " . $curr["suffix"];
			                                                                            echo " " . ucwords($k);
			                                                                            if ($setupfee > 0) {
				                                                                            echo " - " . $curr["prefix"] . $setupfee . " " . $curr["suffix"] . " ";
				                                                                            echo __("Setup Fee", "whcom");
			                                                                            }
			                                                                            ?>
                                                                                    </option>
	                                                                            <?php } ?>
                                                                            <?php }
                                                                            else if ($product1['paytype'] == 'onetime') {
                                                                                $k = 'monthly';
	                                                                            $setupfee = $product1["price_setup_info"][$curr["code"]][substr($k, 0, 1) . "setupfee"]; ?>
                                                                                <option value="<?php echo 'onetime' ?>">
		                                                                            <?php echo $curr["prefix"] . $prd . " " . $curr["suffix"];
		                                                                            echo " " . whcom_convert_billingcycle('onetime');
		                                                                            if ($setupfee > 0) {
			                                                                            echo " - " . $curr["prefix"] . $setupfee . " " . $curr["suffix"] . " ";
			                                                                            echo __("Setup Fee", "whcom");
		                                                                            }
		                                                                            ?>
                                                                                </option>
                                                                            <?php }
                                                                            else if ($product1['paytype'] == 'free') {
	                                                                            $k = 'free'; ?>
                                                                                <option value="<?php echo $k ?>">
		                                                                            <?php echo whcom_convert_billingcycle($k); ?>
                                                                                </option>

                                                                            <?php } ?>


                                                                        </select>
                                                                    </div>
                                                                    <button type="submit"
                                                                            class="whcom_button whcom_button_block">
                                                                        <?php esc_html_e("Choose Product", "whcom") ?>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                    }
                                }
                                ?>
                            </div>
                            <!-- product upgrade end -->
                        <?php } ?>


                        <?php if (!($invoice_pending) && $upgrade_type == "configoptions") { ?>
                            <!-- options upgrade start -->
                            <div id="upgrade_config" class="whcom_margin_bottom_30">
                                <div class="whcom_margin_bottom_30">
                                    <?php
                                    if (empty($config_options)) {
                                        esc_html_e("No upgrade options available for this product.", "whcom");
                                    } else {
                                        esc_html_e("Upgrade/Downgrade the configurable options on this product.", "whcom");
                                    }
                                    ?>
                                </div>


                                <?php if ($pending_uprade) { ?>
                                    <div class="whcom_alert whcom_alert_danger">
                                        <?php
                                        esc_html_e("You cannot currently upgrade or downgrade this product because an upgrade or downgrade is already in progress.", "whcom");

                                        esc_html_e("To proceed, please first pay the outstanding invoice and then you will be able to upgrade or downgrade immediately following that and be charged the difference or credited as appropriate.", "whcom");

                                        esc_html_e("If you believe you are receiving this message in error, please submit a trouble ticket.", "whcom"); ?>


                                    </div>
                                <?php } ?>



                                <?php if (!(empty($config_options))) { ?>

                                    <?php
                                    ## Getting upgrade-able options
                                    $response = wcap_get_whmcs_products("pid=" . $product_id);
                                    if ($response["status"] == "OK") {
                                        $product2 = $response["data"];
                                    } else {
                                        wcap_show_error($response["message"]);
                                    }
                                    if (!isset($product2[0])) {
                                        echo __("Product not found in database", "whcom");
                                        exit;
                                    }
                                    $product2 = $product2[0];
                                    $config_options2 = $product2["configoptions"];

                                    //change array with associative with ids
                                    foreach ($config_options2 as $tmp) {
                                        $options2[$tmp["id"]] = $tmp;
                                    }
                                    ?>

                                    <ul class="whcom_list_padded">
                                        <li>
                                            <div class="whcom_row">

                                                <div class="whcom_col_sm_4">
                                                    <strong><?php esc_html_e("Option Name", "whcom") ?></strong>
                                                </div>

                                                <div class="whcom_col_sm_4 whcom_text_center">
                                                    <strong><?php esc_html_e("Current Configuration", "whcom") ?></strong>
                                                </div>

                                                <div class="whcom_col_sm_4 whcom_text_center">
                                                    <strong><?php esc_html_e("New Configuration", "whcom") ?></strong>
                                                </div>
                                            </div>
                                        </li>
                                        <li>


                                            <form id="updowngrade_options_form">
                                                <input type="hidden" name="action" value="wcap_requests">
                                                <input type="hidden" name="calconly" value="1">
                                                <input type="hidden" name="type" value="configoptions">
                                                <input type="hidden" name="what" value="calculate_updowngrade_options">
                                                <input type="hidden" name="serviceid" value="<?php echo $service_id ?>">
                                                <input type="hidden" name="paymentmethod"
                                                       value="<?php echo $payment_method ?>">
                                                <ul class="whcom_list_stripped whcom_list_padded">
                                                    <?php
                                                    $current_options = $config_options;

                                                    ?>

                                                    <?php foreach ($current_options as $current_selected) {
                                                        ?>
                                                        <?php // current_selected_new = cs_new
                                                        //New selectable options for the currently selected option

                                                        $cs_new = $options2[$current_selected["id"]]; ?>
                                                        <li>
                                                            <div class="whcom_row">

                                                                <!--First column -->
                                                                <div class="whcom_col_sm_4">
                                                                    <span><?php echo $current_selected["option"] ?></span>
                                                                </div>

                                                                <!-- 2nd column -->
                                                                <div class="whcom_col_sm_3">
		                                                <span>
		                                                    <?php
                                                            if ($current_selected["type"] == "yesno") {
                                                                echo ($current_selected["value"] == 0) ? "No" : "Yes";
                                                            } else {
                                                                echo $current_selected["value"];
                                                            }
                                                            ?>
		                                                </span>
                                                                </div>

                                                                <!--3rd column -->
                                                                <div class="whcom_col_sm_5">


                                                                    <div class="whcom_form_field">

                                                                        <?php
                                                                        // type1,2

                                                                        if (($current_selected["type"] == "dropdown") || ($current_selected["type"] == "radio")) { ?>
                                                                            <select name="configoptions[<?php echo $current_selected["id"] ?>]">
                                                                                <option value="<?php echo $current_selected["value"]; ?>"><?php esc_html_e("No Change", "whcom") ?></option>

                                                                                <?php foreach ($cs_new["options"] as $o) { ?>
                                                                                    <option value="<?php echo $o["id"] ?>">
                                                                                        <?php
                                                                                        echo $o["optionname"] . " - ";
                                                                                        echo $o["pricing"][strtolower($product_billingcycle)];
                                                                                        ?>
                                                                                    </option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        <?php } ?>

                                                                        <?php
                                                                        //type,3/yesno
                                                                        if ($current_selected["type"] == "yesno") {
                                                                            $o = $cs_new["options"]["0"];
                                                                            $class = ($current_selected["value"] == "1") ? "whcom_checked" : "";
                                                                            $checked = ($current_selected["value"] == "1") ? "checked" : "";
                                                                            ?>
                                                                            <div class="whcom_checkbox_container">
                                                                                <label class="whcom_checkbox <?php echo $class ?>">
                                                                                    <input name="configoptions[<?php echo $current_selected["id"] ?>]"
                                                                                           type="checkbox"
                                                                                           id="<?php $cs_new["id"] ?>"
                                                                                           value="1" <?php echo $checked; ?>>
                                                                                    <?php echo $o["optionname"] . " - " . $o["pricing"][strtolower($product_billingcycle)]; ?>
                                                                                </label>
                                                                            </div>
                                                                        <?php } ?>

                                                                        <?php
                                                                        // type 4/quantity
                                                                        if ($current_selected["type"] == "quantity") {
                                                                            $o = $cs_new["options"]["0"];
                                                                            ?>
                                                                            <span class="whcom_minus">-</span>
                                                                            <input type="number"
                                                                                   name="configoptions[<?php echo $current_selected["id"] ?>]"
                                                                                   id="text2"
                                                                                   class="whcom_plus_minus"
                                                                                   value="<?php echo $current_selected["value"] ?>">
                                                                            <span class="whcom_plus">+</span>
                                                                            <label><?php echo " x  " . $o["optionname"] . " - " . $o["pricing"][strtolower($product_billingcycle)]; ?></label>

                                                                        <?php } ?>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                    <li>
                                                        <div class="whcom_text_center">
                                                            <button class="whcom_button"><?php esc_html_e("Click to Continue >>", "whcom") ?></button>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </form>
                                        </li>
                                    </ul>
                                <?php } ?>
                            </div>
                            <!-- config upgrade end -->
                        <?php } ?>

                    <?php } ?>
                </div>

            </div>


        </div>
    </div>
</div>

