<?php
/**
 * Created by PhpStorm.
 * User: zain
 * Date: 4/7/2020
 * Time: 1:09 PM
 */ ?>

<div class="whcom_row">
    <div class="whcom_col_sm_3">

    </div>

    <div class="whcom_col_sm_6">
        <div class="">
            <div class="whcom_margin_bottom_30">
            </div>
            <div class="whcom_margin_bottom_30">
                <div class="whcom_page_heading">
                    <?php esc_html_e("Login", "whcom" ) ?>
                </div>
            </div>


            <div class="whcom_row">
                <div class="whcom_panel_body">
                    <div id="error_message" class="whcom_alert whcom_alert_danger" style="display: none;">
                    </div>

                    <form method="post" id="whmcs_validation_form">
                        <input type="hidden" name="login_form_flag" value="1">
                        <div class="whcom_form_field ">
                            <label for="email" class="main_label"><?php esc_html_e("Email Address", "whcom" ) ?></label>
                            <input id="email" type="email" name="email" required="required">
                        </div>

                        <div class="whcom_form_field ">
                            <label for="password" class="main_label"><?php esc_html_e("Password:", "whcom" ) ?></label>
                            <input id="password" type="password" name="password" required="required">
                        </div>


                        <div class="whcom_form_field whcom_text_center">
                            <input type="submit" class="whcom_button whcom_text_center" value="Login">
                            <button class="whcom_button whcom_button_secondary wcap_load_page"
                                    data-page="password_reset">
                                <?php esc_html_e("Reset Password", "whcom" ) ?>
                            </button>
                        </div>

                    </form>
                    <!--                    <div class="whcom_form_field whcom_form_field_horizontal">
                        <a href="#" class="wcap_load_page" data-page="create_client_account"><i
                                    class="fa fa-user"></i> <?php /*esc_html_e("Register", "whcom" ) */ ?></a>
                    </div>
-->
                </div>
            </div>

        </div>
        <div class="whcom_col_sm_3">

        </div>
    </div>
</div>
