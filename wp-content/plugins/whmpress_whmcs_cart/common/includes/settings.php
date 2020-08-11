<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

add_action( 'admin_init', 'whcom_register_setting' );

if (! function_exists('whcom_register_setting')) {
    function whcom_register_setting () {
        register_setting( 'whcom_whmcs', 'whcom_whmcs_admin_url');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_admin_user');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_admin_pass');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_admin_api_key');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_admin_auth_key');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_invoice_custom_templates');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_invoice_custom_templates_status');
        register_setting( 'whcom_whmcs', 'whcom_whmcs_invoice_redirect_url');


        register_setting( 'whcom_domains', 'whcom_hide_domain_fields');
        register_setting( 'whcom_advanced', 'whcom_curl_ssl_verify');
        register_setting( 'whcom_advanced', 'whcom_curl_use_get_method');
        register_setting( 'whcom_advanced', 'whcom_curl_use_user_agent');
        register_setting( 'whcom_advanced', 'whcom_order_complete_message_' . whcom_get_current_language());
        register_setting( 'whcom_advanced', 'whcom_custom_email_message_' . whcom_get_current_language());
        register_setting( 'whcom_advanced', 'whcom_custom_email_message_subject_' . whcom_get_current_language());
        register_setting( 'whcom_advanced', 'whcom_conversion_tracking_code');
        register_setting( 'whcom_advanced', 'whcom_hide_calculate_discount_box');
        register_setting( 'whcom_advanced', 'whcom_recaptcha_on_off');
        register_setting( 'whcom_advanced', 'whcom_sitekey');
        register_setting( 'whcom_advanced', 'whcom_secretkey');
        register_setting( 'whcom_advanced', 'whcom_email_verification_message');
        register_setting( 'whcom_advanced', 'whcom_debug_log');



        register_setting( 'whcom', 'whcom_');

        global $whcom_style_overrides;
        foreach ($whcom_style_overrides as $style) {
            register_setting( 'whcom_style', 'whcom_st' . $style['key']);
        }
    }
}


