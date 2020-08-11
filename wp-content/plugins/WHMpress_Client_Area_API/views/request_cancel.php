


<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("my_services", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$service_id = $_POST["id"];
$response = wcap_get_client_products([
    "serviceid" => $service_id,
]);
$product = $response["products"]["product"][0];
$product_group = $product["translated_groupname"];
$product_name = $product["translated_name"];
$product_domain = $product["domain"];

?>

<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_services_panel_action(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Account Cancellation Request", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">

                <div class="whcom_alert whcom_alert_info whcom_text_center">
                    <?php esc_html_e("Requesting Cancellation for"); ?>
                    :<strong><?php echo  $product_group . " - " . $product_name ?></strong>
                    <?php echo ($product_domain!="")? "(" . $product_domain . ")" : ""; ?>
                </div>

                <div>
                    <form id="wcap_request_cancel">
                        <input type="hidden" name="serviceid" value="<?php echo $service_id ?>">
                        <input type="hidden" name="action" value="wcap_requests">
                        <input type="hidden" name="what" value="add_request_cancel">

                        <div class="whcom_form_field">
                            <label for="text"><?php esc_html_e("Briefly Describe your reason for Cancellation","whcom" ); ?></label>
                            <textarea name="reason"></textarea>
                        </div>

                        <div class="whcom_form_field whcom_form_field_horizontal">
                            <label for="text"><?php esc_html_e("Cancellation Type:","whcom" ) ?></label>
                            <select name="type">
                                <option><?php esc_html_e("Immediate","whcom" ) ?></option>
                                <option><?php esc_html_e("End of Billing Period","whcom" ) ?></option>
                            </select>
                        </div>

                        <div class="whcom_text_center whcom_form_field">
                            <button class="whcom_button_danger"><?php esc_html_e("Request Cancellation","whcom" ) ?></button>
                            <button class="whcom_button_secondary wcap_load_page" data-page="services"><?php esc_html_e("Cancel","whcom" ) ?></button>
                        </div>
                    </form>
                </div>

                <?php //todo: on submit, success > hide form and show this mesage ---> It's done ?>
                <div id="cancelation_success">
                    <div class="whcom_alert whcom_alert_success whcom_text_center">
                        <?php esc_html_e("Thank You. Your cancellation request has been submitted. If you have done this in error, open a support ticket to notify us immediately or your account may be terminated.","whcom"); ?>
                    </div>
                    <div>
                        <a class="wcap_load_page"
                           href=" <?php echo "id=" . $service_id ?>"
                           data-page="productdetails">
                            <button class="whcom_button"><span class="whcom_icon_angle-circled-left"></span> <?php esc_html_e("Back to Service Details", "whcom" ) ?></button>
                        </a>

                    </div>

                </div>

                <div id="cancelation_error">
                    <div class="whcom_alert whcom_alert_danger whcom_text_center">
                        <?php esc_html_e("The following errors occurred:","whcom" ); ?>
                        <?php
                        $error_verialbe="You must enter a cancellation reason"; // assuming it will be returned by API
                        echo $error_verialbe; ?>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>

<script>
    jQuery(document).ready(function(){
        jQuery("#cancelation_success").css("display", "none");
        jQuery("#cancelation_error").css("display", "none");
        jQuery(".whcom_button_danger").click(function(){
            jQuery("#wcap_request_cancel").css("display", "none");
            jQuery("#cancelation_success").css("display", "block");
        });
    });
</script>




