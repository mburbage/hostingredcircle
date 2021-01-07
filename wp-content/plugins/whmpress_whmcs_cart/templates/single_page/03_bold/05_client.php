<?php defined('ABSPATH') or die("Cannot access pages directly.");

?>


<div class="wcop__inner__billing__info" <?php echo $atts['post_load_login_form'] == 'yes' ? 'style="display: none"' : 'style="display: block"' ?>>
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

    <?php echo whcom_render_tos_fields(); ?>
    <div class="whcom_sp_order_response">

    </div>
    <div class="wcop_sp_button">
    <button type="button" name="gotoprev" id="gotoprev" class="prev whcom_button_secondary" value="Previous"
            onclick="Gotoprev('.bold_billing_info_section')">
        ❮ Previous
    </button>
    <?php if ($atts['hide_promo'] != 'yes'){ ?>
    <button type="button" name="next" class="next" value="continue"
            onclick="Gotonext1('.bold_billing_info_section')">NEXT
        ❯
    </button>
    <?php }else{ ?>
        <div class="whcom_form_field whcom_text_center">
            <button type="submit"
                    class="whcom_button whcom_button_big"><?php esc_html_e("Checkout Now!", "whcom") ?></button>
        </div>
    <?php } ?>
    </div>
</div>
