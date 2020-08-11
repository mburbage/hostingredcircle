<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$api_test    = whcom_api_test();
$helper_test = whcom_helper_test();

?>


<form method="post" action="options.php">

    <?php settings_fields( 'whcom_advanced' ); ?>
    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_panel_header_white">
            <span><?php echo esc_html_x( 'Advanced Settings - cURL', "admin", 'whcom' ) ?></span>
        </div>
        <div class="whcom_panel_body">

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_curl_ssl_verify' ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'force SSL verification', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$field" ?>" type="checkbox" name="<?php echo "$field" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $field ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                    <?php esc_html_e( 'If checked, all cURL request will be forced to check for SSL verification via "CURLOPT_SSL_VERIFYPEER"', 'whcom' ) ?>
                </div>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_curl_use_get_method' ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'use GET method for helper cURL requests', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$field" ?>" type="checkbox" name="<?php echo "$field" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $field ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                    <?php esc_html_e( 'If checked, helper cURL request will be sent via GET method', 'whcom' ) ?>
                </div>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_curl_use_user_agent' ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'send USERAGENT with cURL requests', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$field" ?>" type="checkbox" name="<?php echo "$field" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $field ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                    <?php esc_html_e( 'If checked, cURL USERAGENT will be sent with cURL requests via CURLOPT_USERAGENT', 'whcom' ) ?>
                </div>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_hide_calculate_discount_box' ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'Hide Discount forms in order process', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$field" ?>" type="checkbox" name="<?php echo "$field" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $field ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_order_complete_message_' . whcom_get_current_language() ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'Custom Order Complete Message', "admin", 'whcom' ) ?>:
                </label>
                <span>Placeholders: {{invoice_id}},{{payment_method}},{{total_price}},{{user_id}}</span>
                <textarea class="whcom_margin_bottom_10"
                          id="<?php echo "$field" ?>"
                          name="<?php echo "$field" ?>"><?php echo get_option( $field ); ?></textarea>
                <label>&nbsp;</label>
                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                    <?php esc_html_e( 'You can use HTML here', 'whcom' ) ?>
                </div>
            </div>

            <!-- Custom Email Message -->

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $subject = 'whcom_custom_email_message_subject_' . whcom_get_current_language() ?>
                <label for="<?php echo "$subject" ?>">
                    <?php echo esc_html_x( 'Email Subject', "admin", 'whcom' ) ?>:
                </label>
                <textarea style="height: 32px;" class="whcom_margin_bottom_10"
                          id="<?php echo "$subject" ?>"
                          name="<?php echo "$subject" ?>"><?php echo get_option( $subject ); ?></textarea>
                <label>&nbsp;</label>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_custom_email_message_' . whcom_get_current_language() ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'Custom Email Message', "admin", 'whcom' ) ?>:
                </label>
                <textarea style="height: 190px;" class="whcom_margin_bottom_10"
                          id="<?php echo "$field" ?>"
                          name="<?php echo "$field" ?>"><?php echo get_option( $field ); ?></textarea>
                <label>&nbsp;</label>
            </div>

            <!-- Google reCaptcha-->
            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $captcha = 'whcom_recaptcha_on_off' ?>
                <label for="<?php echo "$captcha" ?>">
                    <?php echo esc_html_x( 'Google reCaptcha', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$captcha" ?>" type="checkbox" name="<?php echo "$captcha" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $captcha ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $sitekey = 'whcom_sitekey' ?>
                <label for="<?php echo "$sitekey" ?>">
                    <?php echo esc_html_x( 'Sitekey', "admin", 'whcom' ) ?>:
                </label>
                <textarea style="height: 32px;" class="whcom_margin_bottom_10"
                          id="<?php echo "$sitekey" ?>"
                          name="<?php echo "$sitekey" ?>"><?php echo get_option( $sitekey ); ?></textarea>
                <label>&nbsp;</label>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $secretkey = 'whcom_secretkey' ?>
                <label for="<?php echo "$secretkey" ?>">
                    <?php echo esc_html_x( 'Secretkey', "admin", 'whcom' ) ?>:
                </label>
                <textarea style="height: 32px;" class="whcom_margin_bottom_10"
                          id="<?php echo "$secretkey" ?>"
                          name="<?php echo "$secretkey" ?>"><?php echo get_option( $secretkey ); ?></textarea>
                <label>&nbsp;</label>
            </div>

            <!-- Email Verification Message -->
            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $email_verification = 'whcom_email_verification_message' ?>
                <label for="<?php echo "$email_verification" ?>">
                    <?php echo esc_html_x( 'Email Verification Message', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$email_verification" ?>" type="checkbox" name="<?php echo "$email_verification" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $email_verification ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
            </div>

            <!-- Debug Log -->
            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $debug_log = 'whcom_debug_log' ?>
                <label for="<?php echo "$debug_log" ?>">
                    <?php echo esc_html_x( 'Enable Debug Log', "admin", 'whcom' ) ?>:
                </label>
                <input id="<?php echo "$debug_log" ?>" type="checkbox" name="<?php echo "$debug_log" ?>"
                       value="yes" <?php echo ( esc_attr( get_option( $debug_log ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
            </div>

            <div class="whcom_form_field whcom_form_field_horizontal">
                <?php $field = 'whcom_conversion_tracking_code' ?>
                <label for="<?php echo "$field" ?>">
                    <?php echo esc_html_x( 'Conversion Tracking Code', "admin", 'whcom' ) ?>:
                </label>
                <textarea class="whcom_margin_bottom_10"
                          id="<?php echo "$field" ?>"
                          name="<?php echo "$field" ?>"><?php echo get_option( $field ); ?></textarea>
                <label>&nbsp;</label>
                <div class="whcom_checkbox_container whcom_alert whcom_alert_info">
                    <?php esc_html_e( 'Conversion tracking code including "script" tags', 'whcom' ) ?>
                </div>
            </div>


            <div class="whcom_text_center">
                <button type="submit"
                        class="whcom_button"><?php echo esc_html_x( 'Save Settings', "admin", 'whcom' ) ?></button>
            </div>

        </div>
    </div>

</form>
