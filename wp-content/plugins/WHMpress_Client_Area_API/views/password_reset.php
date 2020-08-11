<?php
//page initialization, veriables for whole page
//$show_sidebar = wcap_show_side_bar("password_reset");
$show_sidebar = false;


//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

?>


<div class="wcap_knowledgebase ">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_support_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Lost Password Reset", "whcom" ) ?></span>
            </div>

            <div class="whcom_row">
                <div class="whcom_col_sm_2">

                </div>

                <div class="whcom_col_sm_8 whcom_text_center">
                    <div class="whcom_margin_bottom_15"></div>
                    <div class="">
                        <div class="whcom_row">
                            <div class="whcom_panel_body">

                                <div id="success_message" style="display: none">
                                    <div class="whcom_alert whcom_alert_success">
                                        <strong><?php esc_html_e("Validation Email Sent", "whcom" ) ?></strong>
                                    </div>
                                    <p>
                                        <?php esc_html_e("The password reset process has now been started. Please check your email for instructions on what to do next.", "whcom" ) ?>
                                    </p>
                                </div>
                                <div id="error_message" class="whcom_alert whcom_alert_danger" style="display: none;">
                                </div>


                                <p>
                                    <?php esc_html_e("Forgotten your password? Enter your email address below to begin the reset process.", "whcom" ) ?>
                                </p>

                                <form id="whmcs_reset_pwd_form">
                                    <div class="whcom_form_field whcom_form_field_horizontal">
                                        <label class="main_label"><?php esc_html_e("Email Address", "whcom" ) ?></label>
                                        <input id="reset_email" type="email" name="email" required="required"
                                               title="<?php esc_html_e("Valid email address required") ?>">
                                    </div>

                                    <div class="whcom_form_field whcom_text_center">
                                        <input id="reset_submit" type="submit" class="whcom_button" value="<?php esc_html_e('Submit', 'whcom')?>">
                                    </div>

                                </form>


                            </div>
                        </div>

                    </div>
                    <div class="whcom_col_sm_2">

                    </div>
                </div>

                <script>
                    jQuery(function () {
                        jQuery("#whmcs_reset_pwd_form").validate();
                    });
                </script>

        </div>
    </div>
</div>

