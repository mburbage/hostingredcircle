<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("security_settings", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

$response = wcap_get_security_questions();
if ($response["status"]=="OK"){
    $questions=$response["data"];
} else
{
    wcap_show_error($response["message"]);
}

?>

<div class="wcap_security_settings ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_profile_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Security Settings", "whcom" ) ?></span>
            </div>

            <?php //main content ?>
            <div class="whcom_margin_bottom_15">


                <h3><?php esc_html_e("Change Security Question", "whcom" ); ?></h3>

                <div class="whcom_alert whcom_alert_info"><span>
                    <?php
                    esc_html_e("Setting a security question and answer helps protect your account from unauthorized password resets and allows us to verify your identity when requesting account changes.", "whcom" );
                    ?>
                    </span></div>

                <form id="security_question">
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="update_security_question">
                    <!-- Security Questions -->
                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <label for="security_question" class="main_label">
                            <?php esc_html_e('Please choose a security question', 'whcom') ?>
                        </label>
                        <select name="security_question" id="inputCardType" class="form-control">
                            <?php foreach ($questions as $question) { ?>
                                <option value="<?php echo $question["id"] ?>">
                                    <?php echo wcap_decrypt_security_questions(["security_questions" => $question["question"]]) ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- Enter Answer -->
                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <label for="securityqans"
                               class="main_label"><?php esc_html_e('Please enter an answer', 'whcom') ?></label>
                        <input type="password" name="securityqans" id="securityqans" value="">
                    </div>

                    <!-- Confirm Answer -->
                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <label for="securityqans2"
                               class="main_label"><?php esc_html_e('Please confirm your answer', 'whcom') ?></label>
                        <input type="password" name="securityqans2" id="securityqans2" value="">
                    </div>

                    <!-- Buttons -->
                    <div class="whcom_row whcom_row_no_gap">
                        <div class="whcom_col_sm_12 whcom_text_center">
                                <button><?php esc_html_e("Save Changes", "whcom" ) ?></button>
                                <button class="whcom_button_secondary"><?php esc_html_e("Cancel", "whcom" ) ?></button>
                        </div>
                        <div class="whcom_col_sm_3"></div>
                    </div>
                </form>

                <div id="success_message" class="whcom_alert whcom_alert_success" style="display: none;"></div>
                <div id="success_error" class="whcom_alert whcom_alert_danger" style="display: none;"></div>


            </div>


        </div>
    </div>
</div>









