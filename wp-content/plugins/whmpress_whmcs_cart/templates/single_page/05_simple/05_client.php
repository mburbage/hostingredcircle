<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

?>



<?php if ( whcom_is_client_logged_in() ) { ?>
    <div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
        <i class="whcom_icon_user-3"></i>
        <span><?php esc_html_e( "Billing Info", "whcom" ) ?></span>
    </div>
    <div class="wcop_sp_section_content">
		<?php echo whcom_render_logged_in_client_form(); ?>
        <!--Payment Selection-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e( 'Payment Selection', 'whcom' ) ?></span>
        </div>
		<?php echo wcop_sp_render_payment_selection(); ?>
    </div>
<?php }
else { ?>
    <div class="wcop_sp_section_heading whcom_bg_primary whcom_text_white">
        <i class="whcom_icon_credit-card"></i>
        <span><?php esc_html_e( "Enter Your Billing Info", "whcom" ) ?></span>
    </div>
    <div class="wcop_sp_section_content">
        <div class="whcom_text_right">
                <span class="whcom_button whcom_button_warning"
                      style="display: none" id="wcop_sp_register_account_link">
                    <?php esc_html_e( 'Register New Account', 'whcom' ) ?>
                </span>
            <span class="whcom_button whcom_button_info"
                  style="display: inline-block" id="wcop_sp_user_login_link">
                    <?php esc_html_e( 'Already Registered?', 'whcom' ) ?>
                </span>
        </div>
        <div class="whcom_tabs_content active wcop_sp_billing_tab_link" id="wcop_sp_register_account" style="display: block">
            <input type="hidden" name="currency" value="<?php echo whcom_get_current_currency_id(); ?>">
		    <?php echo whcom_render_register_form_fields('client_'); ?>
        </div>
        <div class="whcom_tabs_content whcom_op_login_form wcop_sp_billing_tab_link" id="wcop_sp_user_login"
             style="display: none">
            <div class="whcom_sub_heading_style_1">
                <span><?php esc_html_e( "Existing Customer Login", "whcom" ) ?></span>
            </div>
		    <?php echo whcom_render_login_form_fields(); ?>
        </div>
        <!--Payment Selection-->
        <div class="whcom_sub_heading_style_1">
            <span><?php esc_html_e( 'Payment Selection', 'whcom' ) ?></span>
        </div>
		<?php echo wcop_sp_render_payment_selection(); ?>
    </div>
    <input type="hidden" name="wcop_sp_client_type" value="register" id="wcop_sp_client_type_login">
<?php } ?>


