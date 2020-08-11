<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("contact");

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

/*
            [setting] => ContactFormDept
            [value] => 1

            [setting] => ContactFormTo
            [value] => farooqomer@gmail.com
 */
$logged_in = whcom_is_client_logged_in();
$tmp= whcom_get_whmcs_setting();


if (!empty($tmp) && is_array($tmp)) {
    $response['status'] = 'OK';
    $response['message'] = 'Settings Found';
    $response['data'] = $tmp;
} else {
    $response = [];
    $response['status'] = 'ERROR';
    $response['message'] = 'Settings not found';
    $response['data'] = [];
}

//$some_setting = (!empty($response) && !empty($response['some_setting'])) ? : ;
if ($response["status"] == "OK") {
    $settings = $response["data"];
    $contact_form_dept =(int) $settings["ContactFormDept"];
    $contact_form_to = $settings["ContactFormTo"];
} else {
    wcap_show_error($response["message"]);
}

$submit_ticket = false;

if ($contact_form_dept > 0) {
    $submit_ticket = true;

    $depts = whcom_get_all_departments();
}


?>

    <div class="wcap_contactus wcap_view_container">
        <div class="whcom_row">
            <?php if ($show_sidebar) { ?>
                <div class="whcom_col_sm_3">
                    <?php //side bar content ?>
                    <?php wcap_render_profile_panel(); ?>
                </div>
            <?php } ?>
            <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
                <div class="whcom_page_heading">
                    <span><?php esc_html_e("Contact Us", "whcom") ?></span>
                </div>

                <?php //main content ?>
                <div class="whcom_margin_bottom_15 wcap_view_content">
                    <?php if ($response["status"] != "OK") { ?>
                        <div class="whcom_alert whcom_alert_danger whcom_text_center">
                            <?php echo $response["message"] ?>
                        </div>
                    <?php } ?>

                    <?php if ($response["status"] == "OK") { ?>

                        <form id="wcap_contactus_from">
                            <input type="hidden" name="action" value="wcap_requests">
                            <div class="whcom_row">
                                <div class="whcom_col_sm_6">
                                    <div class="whcom_form_field whcom_form_field">
                                        <label class="main_label"><?php esc_html_e('Name', "whcom") ?></label>
                                        <input type="text" name="name" value="" style="max-width: 100%">
                                    </div>
                                </div>
                                <div class="whcom_col_sm_6">
                                    <div class="whcom_form_field whcom_form_field">
                                        <label class="main_label"><?php esc_html_e('Email Address', "whcom") ?></label>
                                        <input type="text" name="email" value="" style="max-width: 100%">
                                    </div>
                                </div>
                                <div class="whcom_col_sm_12">
                                    <div class="whcom_form_field whcom_form_field">
                                        <label class="main_label"><?php esc_html_e('Subject', "whcom") ?></label>
                                        <input type="text" name="subject" style="max-width: 100%">
                                    </div>
                                </div>
                                <?php if ($submit_ticket) { ?>
                                    <div class="whcom_col_sm_6">
                                        <div class="whcom_form_field whcom_form_field">
                                            <label class="main_label"><?php esc_html_e('Department', "whcom") ?></label>
                                            <select name="deptid">
                                                <?php foreach ($depts as $dept) {
                                                    $selected = $dept["id"] == $contact_form_dept ? "selected=selected" : "";
                                                    ?>
                                                    <option <?php echo $selected ?>
                                                            value="<?php echo $dept["id"] ?>"><?php echo $dept["name"] ?></option>
                                                <?php } ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="whcom_col_sm_6">
                                        <div class="whcom_form_field whcom_form_field">
                                            <label class="main_label"><?php esc_html_e('Priority', "whcom") ?></label>
                                            <select name="priority">
                                                <option><?php esc_html_e("High","whcom" ) ?></option>
                                                <option selected="selected"><?php esc_html_e("Medium","whcom" ) ?></option>
                                                <option><?php esc_html_e("Low","whcom" ) ?></option>
                                            </select>
                                        </div>
                                    </div>

                                <?php } ?>
                                <div class="whcom_col_sm_12">
                                    <div class="whcom_form_field whcom_form_field">
                                        <label class="main_label"><?php esc_html_e('Message', "whcom") ?></label>
                                        <textarea name="message" class="summernote" rows="10"
                                                  style="max-width: 100%;"></textarea>
                                    </div>
                                </div>
                                <div class="whcom_col_sm_12">
                                    <div class="whcom_form_field whcom_text_center">
                                        <button class="whcom_button"><?php esc_html_e("Send Message", "whcom") ?></button>
                                    </div>
                                </div>

                            </div>
                        </form>


                    <?php } ?>
                </div>
                <div class="wcap_view_response wcap_response_div">

                </div>

            </div>
        </div>
    </div>


<?php



