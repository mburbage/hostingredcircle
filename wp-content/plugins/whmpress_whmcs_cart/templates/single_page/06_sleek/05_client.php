<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

?>


<div class="wcop__inner__billing__info" <?php echo $atts['post_load_login_form'] == 'yes' ? 'style="display: none"' : 'style="display: block"'  ?>>
<?php if ( whcom_is_client_logged_in() ) { ?>
    <div class="wcop_sp_section_heading">
        <i class="whcom_icon_user-3"></i>
        <span><?php esc_html_e( "Billing Info", "whcom" ) ?></span>
    </div>
    <div class="wcop_sp_section_content">
        <?php echo whcom_render_logged_in_client_form(); ?>
        <?php echo wcop_sp_render_payment_selection(); ?>
    </div>
    <!--<div class="whcom_form_field whcom_text_center">
        <button type="submit"
                class="whcom_button whcom_button_big"><?php /*esc_html_e( "Checkout Now!", "whcom" ) */?></button>
    </div>-->
<?php }
else { ?>
    <div class="wcop_sp_section_heading">
        <i class="whcom_icon_credit-card"></i>
        <span><?php esc_html_e( "Enter Your Billing Info", "whcom" ) ?></span>
    </div>
    <div class="wcop_sp_section_content">
        <div class="whcom_tabs_container whcom_tabs_fancy_2">
            <div class="whcom_row">
                <div class="whcom_col_sm_6 whcom_client-area">
                    <div class="whcom_tabs_content active" id="wcop_sp_register_account">
                        <div class="login-heading-title"> Register New Account</div>
                        <?php echo whcom_render_register_form_fields('client_'); ?>
                    </div>
                    <div class="whcom_tabs_content wcop_login_form" id="wcop_sp_user_login">
                        <div class="login-heading-title">Login Here</div>
                        <?php echo whcom_render_login_form_fields(); ?>
                    </div>
                    <?php echo wcop_sp_render_payment_selection(); ?>
                </div>
                <div class="whcom_col_sm_6 whcom_client-area">
                    <div class="whcom_tabs_content" style="display: block">
                        <div class="login-tab-1">
                            <div class="login-heading-title">I am New Here</div>
                            <div class="login-new-account">
                                Create account to:
                                <ul>
                                    <li>Place new orders</li>
                                    <li>Get access to ticketing system</li>
                                    <li>Track your existing orders</li>
                                </ul>
                            </div>
                        </div>
                        <div class="login-tab-2 selected">
                            <div class="login-heading-title">I am Already Customer</div>
                            <div class="login-new-account">
                                Use your existing account to
                            <ul>
                                <li>Manage your services</li>
                                <li>Manage your orders</li>
                                <li>Manage your bills and payment methods</li>
                            </ul>
                        </div>
                        </div>
                        <ul class="whcom_tab_links whcom_text_center">
                            <li data-tab="wcop_sp_register_account" id="register-tab" class="active whcom_tab_link wcop_sp_client_type_switch wcop_sp_billing_tab_link">
                                <label for="wcop_sp_client_type_register">
                                    <?php esc_html_e( 'Register New Account', "whcom" ) ?>
                                </label>
                            </li>
                            <li data-tab="wcop_sp_user_login" id="login-tab" class="whcom_tab_link wcop_sp_client_type_switch wcop_sp_billing_tab_link">
                                <label for="wcop_sp_client_type_login">
                                    <?php esc_html_e( 'Already Registered?', "whcom" ) ?>
                                </label>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
        <!--        --><?php //echo wcop_sp_render_payment_selection(); ?>
    </div>
    <input type="hidden" name="wcop_sp_client_type" value="register" id="wcop_sp_client_type_login">
    <!--<div class="whcom_form_field whcom_text_center">
        <button type="submit"
                class="whcom_button whcom_button_big"><?php /*esc_html_e( "Checkout Now!", "whcom" ) */?></button>
    </div>-->
<?php } ?>
</div>


