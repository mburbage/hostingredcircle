<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar("change_password", true);

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}

?>

<div class="wcap_change_password wcap_view_container">
    <div class="whcom_row">
        <?php if ($show_sidebar) { ?>
            <div class="whcom_col_sm_3">
                <?php //side bar content ?>
                <?php wcap_render_profile_panel(); ?>
            </div>
        <?php } ?>
        <div class="<?php echo ($show_sidebar) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
            <div class="whcom_page_heading">
                <span><?php esc_html_e("Change Password", "whcom" ) ?></span>
            </div>

            <?php //main content
            ?>
            <div class="wcap_view_response"></div>
            <div class="whcom_margin_bottom_15 wcap_view_content">
                <div id="error_message" class="whcom_alert whcom_alert_danger" style="display: none;">
                </div>

                <div id="success_message" class="whcom_alert whcom_alert_success" style="display: none;">
                </div>

                <form id="wcap_update_password_form1">
                    <input type="hidden" name="action" value="wcap_requests">
                    <input type="hidden" name="what" value="update_client_password">
                    <input type="reset" style="display: none">
                    <div class="whcom_form_field">
                        <label for="old_password"
                               class="main_label"><?php esc_html_e("Existing Password", "whcom" ); ?></label>
                        <input type="password" name="old_password" id="old_password">
                    </div>
                    <div class="whcom_form_field">
                        <label for="new_password"
                               class="main_label"><?php esc_html_e("New Password", "whcom" ); ?></label>
                        <input type="password" name="password1" id="new_password">
                    </div>
                    <div class="whcom_alert whcom_alert_info">
                        <div class="whcom_text_bold">
                            <?php esc_html_e("Tips for a good password", "whcom" ); ?>
                        </div>
                        <?php esc_html_e("Use both upper and lowercase characters Include at least one symbol (# $ ! % & etc...) Don't use dictionary words", "whcom" ); ?>
                    </div>
                    <div class="whcom_form_field">
                        <label for="new_password_2"
                               class="main_label"><?php esc_html_e("Confirm New Password", "whcom" ); ?></label>
                        <input type="password" name="password2" id="new_password_2">
                    </div>
                    <div class="whcom_form_field whcom_text_center">
                        <button type="submit" class="whcom_button"><?php esc_html_e("Save Changes", "whcom" ); ?></button>
                    </div>
                </form>

            </div>


        </div>
    </div>
</div>

<script>
    jQuery(function(){
        jQuery("#wcap_update_password_form1").validate();
    });
</script>