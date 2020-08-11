<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("my_services");


$user_id = whcom_get_current_client_id();
$service_id = $_POST["upoptions_id"];
$upgrade_type = $_POST["type"];

//get the form data process it
$_POST["calconly"] = true;
if (isset($_POST["k"])) {
    $_POST["k"] = base64_decode($_POST["k"]);
}
parse_str($_POST["k"], $FORM_DATA);

if (is_array($FORM_DATA)) {
} else {
    $FORM_DATA = [];
}


if ($upgrade_type == "configoptions") {

    $data = wcap_updowngrade_options($FORM_DATA);

    //$upgrade_price = isset($data["price"]) ? $data["price"] : "0";

    $print = [];

    for ($counter = 1; $counter <= count($FORM_DATA["configoptions"]); $counter++) {
        if (!empty($data['configname' . $counter])) {
            $print[$counter]["description"] = $data['configname' . $counter] . ":" . $data['originalvalue' . $counter] . " => " . $data['newvalue' . $counter];
            $print[$counter]["price"] = $data['price' . $counter];
        } else {
            break;
        }
    }


    $product = wcap_get_client_products([
        "serviceid" => $service_id,
    ]);


    $product = $product["products"]["product"][0];
    $product_id = $product["pid"];
    $product_group = $product["translated_groupname"];
    $product_name = $product["translated_name"];
    $product_domain = $product["domain"];
    $product_billingcycle = $product["billingcycle"];
    $new_config_options = $product["configoptions"]["configoption"];

}

if ($upgrade_type != "configoptions") {

    $data = wcap_updowngrade_service($FORM_DATA);
    $service_id = $FORM_DATA['serviceid'];


    $upgrade_price = isset($data["price"]) ? $data["price"] : "0";
//$upgrade_price = whcom_format_amount( $upgrade_price );

    $product = wcap_get_client_products([
        "serviceid" => $service_id,
    ]);

    $product_fetched = FALSE;
    if ($product["result"] == "success") {
        $product_fetched = TRUE;
        $product = $product["products"]["product"][0];

        $product_id = $product["pid"];
        $product_group = $product["translated_groupname"];
        $product_name = $product["translated_name"];
        $product_domain = $product["domain"];
        $product_billingcycle = $product["billingcycle"];
    }

}

?>

<div class="wcap_updowngrade_final wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <div class="whcom_panel">
                    <div class="whcom_panel_header">
                        <?php esc_html_e('Up/Downgrade', "whcom") ?>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_bordered whcom_list_padded ">
                            <li>
                                <div>
                                    <?php echo __("Product/Service", "whcom") ?>
                                </div>

                                <strong>
                                    <?php echo $product_group . " - " . $product_name; ?>
                                </strong>
                            </li>
                            <li>
                                <div><?php esc_html_e("Domain", "whcom") ?></div>
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
            <div class="wcap_view_response"></div>
            <div class="whcom_margin_bottom_15 wcap_view_content">
                <div class="">

                    <div class="whcom_alert whcom_alert_info whcom_text_center whcom_margin_bottom_15">
                        <?php
                        echo esc_html__("Current Configuration", "whcom") . ":";
                        echo $product_group . " - " . $product_name;
                        echo ($product_domain != "") ? "(" . $product_domain . ")" : "";
                        ?>
                    </div>

                    <?php //------------- upgrade option --------- ?>
                    <? if ($upgrade_type == "configoptions") { ?>
                        <div id="upgrade_config_options" class="whcom_margin_bottom_15">
                            <!-- codes for upgrade config options -->

                            <ul class="whcom_list_stripped whcom_list_padded whcom_margin_bottom_15">
                                <li>
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_8">
                                            <strong><?php esc_html_e("Description", "whcom") ?></strong>
                                        </div>
                                        <div class="whcom_col_sm_4 whcom_text_center">
                                            <strong><?php esc_html_e("Price", "whcom") ?></strong>
                                        </div>
                                    </div>
                                </li>

                                <?php foreach ($print as $row) { ?>
                                    <li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_8">
                                                <span><?php echo $row["description"] ?></span>
                                            </div>
                                            <div class="whcom_col_sm_4 whcom_text_center">
                                                <span><?php echo $row["price"] ?></span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>

                                <li>
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_8 whcom_text_right">
                                            <strong><?php esc_html_e("Subtotal", "whcom") ?>:</strong>
                                        </div>
                                        <div class="whcom_col_sm_4 whcom_text_center">
                                            <strong><span><?php echo $data["subtotal"] ?></span></strong>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_8 whcom_text_right">
                                            <strong><?php esc_html_e("Total Due Today", "whcom") ?>:</strong>
                                        </div>
                                        <div class="whcom_col_sm_4 whcom_text_center">
                                            <strong><span><?php echo $data["total"] ?></span></strong>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <form id="updowngrade_options_form_final">
                                <?php
                                $FORM_DATA["calconly"] = 0;
                                $FORM_DATA["what"] = 'updowngrade_product_options';
                                foreach ($FORM_DATA as $key => $value) {
                                    if ($key == "configoptions") {
                                        foreach ($value as $k => $v) {
                                            echo "<input type='hidden' name='configoptions[{$k}]' value='{$v}'>";
                                        }

                                    } else {
                                        echo "<input type='hidden' name='{$key}' value='{$value}'>";
                                    }
                                }
                                ?>

                                <div class="whcom_text_center whcom_padding_15">
                                    <button class="button"><?php esc_html_e("Click to Continue >>", "whcom") ?></button>
                                </div>

                            </form>

                        </div>
                    <?php } ?>

                    <?php //------------- upgrade service --------- ?>
                    <? if ($upgrade_type != "configoptions") { ?>
                        <div id="upgrade_product" class="whcom_margin_bottom_15">
                            <form id="updowngrade_form_final">
                                <?php
                                $FORM_DATA["calconly"] = 0;
                                $FORM_DATA["what"] = 'updowngrade_product';
                                foreach ($FORM_DATA as $key => $value) {
                                    echo "<input type='hidden' name='{$key}' value='{$value}'>";
                                }

                                ?>


                                <ul class="whcom_list_stripped whcom_list_padded whcom_padding_bottom_30">
                                    <li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_8">
                                                <strong><?php esc_html_e("Description", "whcom") ?></strong>
                                            </div>
                                            <div class="whcom_col_sm_4 whcom_text_center">
                                                <strong><?php esc_html_e("Price", "whcom") ?></strong>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_8">
                                                <span><?php echo @$data["oldproductname"] . " => " . @$data["newproductname"]; ?></span>
                                            </div>
                                            <div class="whcom_col_sm_4 whcom_text_center">
                                                <span><?php echo $upgrade_price ?></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_8 whcom_text_right">
                                                <strong><?php esc_html_e("Subtotal", "whcom") ?>:</strong>
                                            </div>
                                            <div class="whcom_col_sm_4 whcom_text_center">
                                                <strong><span><?php echo $upgrade_price ?></span></strong>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_8 whcom_text_right">
                                                <strong><?php esc_html_e("Total Due Today", "whcom") ?>:</strong>
                                            </div>
                                            <div class="whcom_col_sm_4 whcom_text_center">
                                                <strong><span><?php echo $upgrade_price ?></span></strong>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="whcom_text_center">
                                    <button class="whcom_button"><?php esc_html_e("Click to Continue >>", "whcom") ?></button>
                                </div>

                            </form>
                        </div>
                    <?php } ?>
                </div>

            </div>


        </div>
    </div>
</div>

