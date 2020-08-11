<?php defined('ABSPATH') or die("Cannot access pages directly.");

?>



<?php if (whcom_is_client_logged_in()) { ?>
    <div class="wcop_sp_section_heading">
        <i class="whcom_icon_user-3"></i>
        <span><?php esc_html_e("Billing Info", "whcom") ?></span>
    </div>
    <div class="wcop_sp_section_content">
        <?php echo whcom_render_logged_in_client_form(); ?>
        <?php echo wcop_sp_render_payment_selection(); ?>
    </div>
<?php } else { ?>
        <div class="wcop_sp_section_heading">
            <i class="whcom_icon_credit-card"></i>
            <span><?php esc_html_e("Enter Your Billing Info", "whcom") ?></span>
        </div>
    <div class="wcop_sp_section_content">
        <div class="whcom_tabs_container whcom_tabs_fancy_2">
            <ul class="whcom_tab_links whcom_text_center">
                <li data-tab="wcop_sp_register_account"
                    class="active whcom_tab_link wcop_sp_client_type_switch wcop_sp_billing_tab_link">
                    <label for="wcop_sp_client_type_register">
                        <?php esc_html_e('Register New Account', "whcom") ?>
                    </label>
                </li>
                <li data-tab="wcop_sp_user_login"
                    class="whcom_tab_link wcop_sp_client_type_switch wcop_sp_billing_tab_link">
                    <label for="wcop_sp_client_type_login">
                        <?php esc_html_e('Already Registered?', "whcom") ?>
                    </label>
                </li>
            </ul>
            <div class="whcom_tabs_content active" id="wcop_sp_register_account">
                <?php echo whcom_render_register_form_fields('client_'); ?>
            </div>
            <div class="whcom_tabs_content wcop_login_form" id="wcop_sp_user_login">
                <?php echo whcom_render_login_form_fields(); ?>
            </div>
        </div>
        <?php echo wcop_sp_render_payment_selection(); ?>
    </div>
    <input type="hidden" name="wcop_sp_client_type" value="register" id="wcop_sp_client_type_login">
<?php } ?>


