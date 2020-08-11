<?php
/*
Plugin Name: WHMpress
Plugin URI: http://www.whmpress.com
Description: WHMpress makes it easy for you to sell web hosting using WordPress & WHMCS. It offers you several options including prices, order links, order button, order drop downs, domain registration and domain search forms to integrate WHMCS services (plans, packages, resellers packages, VPS & dedicated servers) into your WordPress installation.
Version: 5.4-revision-2
Author: creativeON
Author URI: http://creativeon.com
*/

// Prevent direct file access
if (!function_exists('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    die("Access denied");
    exit();
}

if (!function_exists('plugin_get_version')) {
    function plugin_get_version()
    {
        if (!function_exists('get_plugins')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }
        $plugin_folder = get_plugins('/' . plugin_basename(dirname(__FILE__)));
        //var_dump($plugin_folder);
        $plugin_file = basename((__FILE__));
        //var_dump($plugin_file);

        return $plugin_folder[$plugin_file]['Version'];
    }
}

define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('WHMP_PLUGIN_PATH', plugin_dir_path(__FILE__));

$WHMP_Settings = [
    "domain_available_message",
    "domain_not_available_message",
    "domain_recommended_list",
    "ongoing_domain_available_message",
    "ongoing_domain_not_available_message",
    "register_domain_button_text",
    "load_more_button_text",
    "not_configured_override",
    "load_more_button_text",
    "zero_override",
    "onetime_override",
];

/*
* Tables used from WHMCS DB
*/
$Tables = [
    "tblpricing" => "pricing",
    "tblproducts" => "products",
    "tblproductgroups" => "productgroups",
    "tblcurrencies" => "currencies",
    "tbldomainpricing" => "domainpricing",
    "tblconfiguration" => "configuration",
    "tbladdons" => "addons",
    "tblclientgroups" => "clientgroups",
    "tblproductconfigoptionssub" => "productconfigoptionssub",
    "tblproductconfigoptions" => "productconfigoptions",
    "tblproductconfiglinks" => "productconfiglinks",
    "tblannouncements" => "announcements",
    "tbltax" => "tax",
    "tblproductconfiggroups" => "productconfiggroups",
    "tblbundles" => "bundles",
];

include_once(dirname(__FILE__) . '/whmpress.init.php');
include_once(WHMP_PLUGIN_DIR . '/includes/whmpress.class.php');
$WHMPress = new WHMpress();
include_once(WHMP_PLUGIN_DIR . '/includes/functions.php');
include_once(WHMP_PLUGIN_DIR . '/includes/functions_i.php');
# Initializing Countries List.
include_once WHMP_PLUGIN_DIR . "/includes/countries.php";
//== Initializing Tlds Tables
include_once WHMP_PLUGIN_DIR . "/includes/tlds.php";

function register_WHMP_settings()
{
    global $WHMP_Settings;
    $WHMP = new WHMPress();

    register_setting('whmp_settings', 'whmp_language_options');

    $lang = $WHMP->get_current_language();
    $extend = empty($lang) ? "" : "_" . $lang;
    foreach ($WHMP_Settings as $wsetting) {
        register_setting('whmp_settings', $wsetting . $extend);
    }

    register_setting('whmp_sync_settings', 'db_server');
    register_setting('whmp_sync_settings', 'db_name');
    register_setting('whmp_sync_settings', 'db_user');
    register_setting('whmp_sync_settings', 'db_pass');
    register_setting('whmp_sync_settings', 'sync_run');
    register_setting('whmp_sync_settings', 'sync_time');
    register_setting('whmp_sync_settings', 'whmp_save_pwd');

    # Settings page
    register_setting('whmp_settings', 'whmcs_url');
    register_setting('whmp_settings', 'load_sytle_orders');
    register_setting('whmp_settings', 'whmp_custom_css');
    register_setting('whmp_settings', 'whmp_custom_css_codes');
    register_setting('whmp_settings', 'tld_order');

    register_setting('whmp_settings', 'no_of_domains_to_show');
    register_setting('whmp_settings', 'enable_logs');
    register_setting('whmp_settings', 'use_whmcs_domain_search');
    register_setting('whmp_settings', 'whois_db');
    register_setting('whmp_settings', 'billingcycle');
    register_setting('whmp_settings', 'decimals');
    register_setting('whmp_settings', 'hide_decimal');
    register_setting('whmp_settings', 'decimals_tag');
    register_setting('whmp_settings', 'prefix');
    register_setting('whmp_settings', 'suffix');
    register_setting('whmp_settings', 'show_duration');
    register_setting('whmp_settings', 'show_duration_as');
    register_setting('whmp_settings', 'configureable_options');
    register_setting('whmp_settings', 'round_price');
    register_setting('whmp_settings', 'price_tax');
    register_setting('whmp_settings', 'calculate_tax');
    register_setting('whmp_settings', 'price_currency');
    register_setting('whmp_settings', 'price_type');
    register_setting('whmp_settings', 'convert_monthly');
    register_setting('whmp_settings', 'config_option_string');
    register_setting('whmp_settings', 'duration_type');
    register_setting('whmp_settings', 'combo_billingcycles');
    register_setting('whmp_settings', 'combo_decimals');
    register_setting('whmp_settings', 'combo_show_button');
    //register_setting( 'whmp_settings', 'combo_rows' );
    register_setting('whmp_settings', 'combo_button_text');
    register_setting('whmp_settings', 'combo_show_discount');
    register_setting('whmp_settings', 'combo_discount_type');
    register_setting('whmp_settings', 'combo_prefix');
    register_setting('whmp_settings', 'combo_suffix');
    //register_setting( 'whmp_settings', 'decimal_replacement' );
    register_setting('whmp_settings', 'default_currency_symbol');
    register_setting('whmp_settings', 'default_currency_duration_style');
    register_setting('whmp_settings', 'default_currency_duration_connector');
    register_setting('whmp_settings', 'default_decimal_places');
    register_setting('whmp_settings', 'calculate_configurable_price');
    register_setting('whmp_settings', 'include_setup_price');
    register_setting('whmp_settings', 'include_fontawesome');
    register_setting('whmp_settings', 'include_datatable');
    register_setting('whmp_settings', 'include_jquery_quicksearch');
    register_setting('whmp_settings', 'include_slickslider');
    register_setting('whmp_settings', 'show_trailing_zeros');
    register_setting('whmp_settings', 'overwrite_whmcs_url');
    register_setting('whmp_settings', 'whmpress_utf_encode_decode');
    register_setting('whmp_settings', 'whmpress_use_package_details_from_whmpress');

    # Domain Price
    register_setting('whmp_settings', 'dp_type');
    register_setting('whmp_settings', 'dp_decimals');
    register_setting('whmp_settings', 'dp_years');
    register_setting('whmp_settings', 'dp_hide_decimal');
    register_setting('whmp_settings', 'dp_decimals_tag');
    register_setting('whmp_settings', 'dp_prefix');
    register_setting('whmp_settings', 'dp_suffix');
    register_setting('whmp_settings', 'dp_show_duration');
    register_setting('whmp_settings', 'dp_price_tax');

    # Price Matrix
    register_setting('whmp_settings', 'pm_decimals');
    register_setting('whmp_settings', 'pm_show_hidden');
    register_setting('whmp_settings', 'pm_replace_zero');
    register_setting('whmp_settings', 'pm_replace_empty');
    //register_setting( 'whmp_settings', 'pm_type' );
    register_setting('whmp_settings', 'pm_hide_search');
    register_setting('whmp_settings', 'pm_search_label');
    register_setting('whmp_settings', 'pm_search_placeholder');

    # Price Matrix Domain
    register_setting('whmp_settings', 'pmd_decimals');
    register_setting('whmp_settings', 'pmd_show_renewel');
    register_setting('whmp_settings', 'pmd_show_transfer');
    register_setting('whmp_settings', 'pmd_hide_search');
    register_setting('whmp_settings', 'pmd_search_label');
    register_setting('whmp_settings', 'pmd_search_placeholder');
    register_setting('whmp_settings', 'pmd_show_disabled');
    register_setting('whmp_settings', 'pmd_num_of_rows');

    # Order Button
    register_setting('whmp_settings', 'ob_button_text');
    register_setting('whmp_settings', 'ob_billingcycle');

    # Pricing Table
    register_setting('whmp_settings', 'pt_billingcycle');
    register_setting('whmp_settings', 'pt_show_price');
    register_setting('whmp_settings', 'pt_process_description');
    register_setting('whmp_settings', 'pt_show_description_icon');
    register_setting('whmp_settings', 'pt_show_description_tooltip');
    register_setting('whmp_settings', 'pt_show_combo');
    register_setting('whmp_settings', 'pt_show_button');
    register_setting('whmp_settings', 'pt_button_text');

    # Domain Search
    register_setting('whmp_settings', 'ds_show_combo');
    register_setting('whmp_settings', 'ds_show_country_combo');
    register_setting('whmp_settings', 'ds_placeholder');
    register_setting('whmp_settings', 'ds_button_text');

    # Domain Search Ajax
    register_setting('whmp_settings', 'dsa_placeholder');
    register_setting('whmp_settings', 'dsa_button_text');
    register_setting('whmp_settings', 'dsa_whois_link');
    register_setting('whmp_settings', 'dsa_www_link');
    register_setting('whmp_settings', 'dsa_transfer_link');
    register_setting('whmp_settings', 'dsa_disable_domain_spinning');
    register_setting('whmp_settings', 'dsa_order_landing_page');
    register_setting('whmp_settings', 'dsa_order_link_new_tab');
    register_setting('whmp_settings', 'dsa_show_price');
    register_setting('whmp_settings', 'dsa_show_years');
    register_setting('whmp_settings', 'dsa_search_extensions');
    register_setting('whmp_settings', 'dsa_enable_transfer_link');

    # Domain Search Ajax Result
    register_setting('whmp_settings', 'dsar_whois_link');
    register_setting('whmp_settings', 'dsar_www_link');
    register_setting('whmp_settings', 'dsar_show_price');
    register_setting('whmp_settings', 'dsar_show_years');

    # Domain Search Bulk
    register_setting('whmp_settings', 'dsb_placeholder');
    register_setting('whmp_settings', 'dsb_button_text');

    # Domain WhoIS
    register_setting('whmp_settings', 'dw_placeholder');
    register_setting('whmp_settings', 'dw_button_text');

    # Order Link
    register_setting('whmp_settings', 'ol_link_text');

    # Description
    register_setting('whmp_settings', 'dsc_description');

    # Advanced settings page
    register_setting('whmp_settings', 'client_area_url');
    register_setting('whmp_settings', 'announcements_url');
    register_setting('whmp_settings', 'submit_ticket_url');
    register_setting('whmp_settings', 'downloads_url');
    register_setting('whmp_settings', 'support_tickets_url');
    register_setting('whmp_settings', 'knowledgebase_url');
    register_setting('whmp_settings', 'affiliates_url');
    register_setting('whmp_settings', 'order_url');
    register_setting('whmp_settings', 'pre_sales_contact_url');
    register_setting('whmp_settings', 'domain_checker_url');
    register_setting('whmp_settings', 'server_status_url');
    register_setting('whmp_settings', 'network_issues_url');
    register_setting('whmp_settings', 'whmcs_login_url');
    register_setting('whmp_settings', 'whmcs_register_url');
    register_setting('whmp_settings', 'whmcs_forget_password_url');
    register_setting('whmp_settings', 'whmp_countries_currencies');
    register_setting('whmp_settings', 'whmpress_default_currency');
    register_setting('whmp_settings', 'whmpress_cron_recurrance');
    register_setting('whmp_settings', 'whmpress_auto_change_currency_according_to_country');
    register_setting('whmp_settings', 'whmpress_session_cache_limiter_value');



    // Country Settings
    register_setting('whmp_countries', 'whmp_countries_currencies');
    register_setting('whmp_purchase_data', 'whmp_purchase_code');
    register_setting('whmp_purchase_data', 'whmp_purchase_email');
    register_setting('whmp_purchase_data', 'whmp_verified');

    // Price table extended
    register_setting('whmp_settings', 'back_button_url');
}

add_action('admin_init', 'register_WHMP_settings');


add_action('wp_ajax_whmpress_update_field', 'whmpress_update_field_value');
function whmpress_update_field_value()
{
    if (!isset($_POST["name"])) {
        die;
    }
    if (!isset($_POST["val"])) {
        die;
    }
    update_option($_POST["name"], $_POST["val"]);

    wp_die();
}

function whmpress_update_field($new_value, $old_value)
{
    var_dump($new_value);
    var_dump($old_value);

    return $new_value;
}

function whmpress_language_init()
{
    add_filter('pre_update_option_domain_available_message', 'whmpress_update_field', 10, 2);
}

add_action('init', 'whmpress_language_init');


// Initialize all shortcodes
include_once(WHMP_PLUGIN_DIR . "/includes/shortcodes.php");

// Adding functionality of addons.
if (is_dir(WHMP_PLUGIN_DIR . "/addons")) {
    $addons_files = @glob(WHMP_PLUGIN_DIR . "/addons/*.php");
    if (is_array($addons_files)) {
        foreach ($addons_files as $addon_file) {
            include_once($addon_file);
        }
    }
}

if (is_admin()) {
    /**
     * Checking folder name of the plugin directory.
     * Added in 2.4.1
     */
    function whmp_folder_name_check()
    {
        $c_folder = basename(dirname(__FILE__));

        if ("whmpress" <> $c_folder) {
            $c_folder_h = "<b><i>" . $c_folder . "</i></b>";
            $whmpress_h = "<i><b>" . esc_html__("whmpress") . "</b></i>";
            echo "<div class='error'><p><b>" . esc_html__("Caution: ") . "</b>";
            printf(esc_html__("Your WHMPress installation folder name is %1s. Please rename folder to %2s, otherwise you may face problems in performance.", 'whmpress'), $c_folder_h, $whmpress_h);
            echo "               
                </p>
            </div>";
        }
    }

    add_action('admin_notices', 'whmp_folder_name_check', 1);

    require_once WHMP_ADMIN_DIR . '/admin.php';

    # Initialize VC Composer, If VC installed
    if (function_exists('vc_map')) {
        require_once(WHMP_ADMIN_DIR . '/vc.php');
    }

//    if (function_exists('fusion_builder_map')) {
        require_once(WHMP_ADMIN_DIR . '/fusion-builder.php');
//    }


    add_action('wp_ajax_whmpress_action', 'whmp_frontend_ajax_action');
    add_action('wp_ajax_nopriv_whmpress_action', 'whmp_frontend_ajax_action');
}

function whmp_frontend_ajax_action()
{
    require_once(WHMP_PLUGIN_DIR . "/includes/ajax.php");
}

function whmp_theme_name_scripts()
{
    # Including WHMpress css file.
    # If active theme contains whmpress.css then this css file will not load.
    #if ($load_custom_css) {
    $custom_css_file = WHMP_PLUGIN_DIR . "/styles/" . whmpress_get_option("whmp_custom_css");
    if (!is_file($custom_css_file)) {
        $custom_css_file = WHMP_PLUGIN_DIR . "/styles/default.css";
    }

    if (is_file($custom_css_file)) {
        $custom_css_file = str_replace(WHMP_PLUGIN_DIR, WHMP_PLUGIN_URL, $custom_css_file);
        wp_enqueue_style('whmpress_css_file', $custom_css_file);
    }

    // Load a javascript file
    wp_enqueue_script('whmpress_scripts', WHMP_PLUGIN_URL . '/js/whmpress.js', ['jquery'], '1.0.0', true);
    wp_localize_script('whmpress_scripts', 'WHMPAjax', [
        // URL to wp-admin/admin-ajax.php to process the request
        'ajaxurl' => admin_url('admin-ajax.php'),
        //'ajaxurl' => WHMP_PLUGIN_URL.'/includes/ajax.php',

        // generate a nonce with a unique ID "myajax-post-comment-nonce"
        // so that you can check it later when an AJAX request is sent
        'security' => wp_create_nonce('45Gf&*wS4#'),
    ]);
    wp_localize_script('whmpress_scripts', 'whmp_page', '1');
    wp_enqueue_script('QuickSearch', WHMP_PLUGIN_URL . '/js/jquery.quicksearch.js', ['jquery'], false, true);


    # Adding DataTables libraries.
    /*if (!defined('WCAP_VERSION')) {
        if (get_option('include_datatable') == "1") {
            wp_enqueue_script('whmp_dataTables', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.js', ['jquery'], false, true);
            wp_enqueue_style('whmp_dataTables-style', WHMP_PLUGIN_URL . '/includes/DataTables/datatables.min.css');
        }
    }*/

    // Enqueue Slick Carousel Plugin.
    if (get_option('include_slickslider') == "1") {
        wp_enqueue_style('whmp_grp_slick', WHMP_PLUGIN_URL . '/includes/libs/slick/slick.css');
        wp_enqueue_style('whmp_grp_slick_theme', WHMP_PLUGIN_URL . '/includes/libs/slick/slick-theme.css');
        wp_enqueue_script('whmp_grp_slick', WHMP_PLUGIN_URL . '/includes/libs/slick/slick.min.js', ['jquery']);
    }
    # Adding  Select2 library.
    //wp_enqueue_style('select2-css', WHMP_PLUGIN_URL . '/includes/libs/select2/select2.min.css');
    //wp_enqueue_script('select2-js', WHMP_PLUGIN_URL . '/includes/libs/select2/select2.min.js', ['jquery']);
    //wp_enqueue_style('whmp_grp_style', WHMP_PLUGIN_URL . '/styles/style.css');


    /*if (is_file(WHMP_PLUGIN_DIR . "/templates/whmpress.css")) {
        wp_enqueue_style('whmpress-temp-style', WHMP_PLUGIN_URL . '/templates/whmpress.css');
    }*/

    $WHMPress = new WHMPress;
    $load_custom_css = true;
    if (get_option("load_sytle_orders") == "") {
        $load_custom_css = false;
    } else if (get_option("load_sytle_orders") == "whmpress") {
        if (is_file(WHMP_PLUGIN_DIR . "/themes/" . basename($WHMPress->whmp_get_template_directory()) . "/whmpress.css")) {
            wp_enqueue_style('whmpress-temp-style2', WHMP_PLUGIN_URL . '/themes/' . basename($WHMPress->whmp_get_template_directory()) . '/whmpress.css');
            $load_custom_css = false;
        } elseif (is_file($WHMPress->whmp_get_template_directory() . "/whmpress/whmpress.css")) {
            wp_enqueue_style('whmpress-temp-style2', get_stylesheet_directory_uri() . '/whmpress/whmpress.css');
            $load_custom_css = false;
        }
    } else {
        if (is_file($WHMPress->whmp_get_template_directory() . "/whmpress/whmpress.css")) {
            wp_enqueue_style('whmpress-temp-style2', get_stylesheet_directory_uri() . '/whmpress/whmpress.css');
            $load_custom_css = false;
        } elseif (is_file(WHMP_PLUGIN_DIR . "/themes/" . basename($WHMPress->whmp_get_template_directory()) . "/whmpress.css")) {
            wp_enqueue_style('whmpress-temp-style2', WHMP_PLUGIN_URL . '/themes/' . basename($WHMPress->whmp_get_template_directory()) . '/whmpress.css');
            $load_custom_css = false;
        }
    }


    if (get_option("whmp_custom_css_codes") <> "") {
        add_action('wp_head', 'whmpress_hook_css');
    }

    //wp_enqueue_style('pricetables', WHMP_PLUGIN_URL . '/styles/pricetables/pricing-tables.min.css' );

    // If WHMPress settings -> Styles -> include FontAwesome selected Yes
    /*if (get_option('include_fontawesome') == "1") {
        wp_enqueue_style('font-awesome-script', "//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css");
    }*/
    #}
}

add_action('wp_enqueue_scripts', 'whmp_theme_name_scripts', 50);
function whmpress_hook_css()
{
    echo "<!-- Output by WHMPress -->
    <style>" . get_option("whmp_custom_css_codes") . "</style>";
}


/**
 * Implementing Custom CSS
 */
function whmp_get_custom_css()
{
    # Custom theme whmpress.css support
    $custom_css_file = WHMP_PLUGIN_DIR . "/styles/" . get_option("whmp_custom_css");

    if (!is_file($custom_css_file)) {
        $custom_css_file = WHMP_PLUGIN_DIR . "/styles/default.css";
    }

    $WHMPress = new WHMPress;
    $custom_css = $WHMPress->read_local_file($custom_css_file);

    if (@$custom_css) {
        $css = '<!-- WHMpress Styles -->' . "\n";
        $css .= '<style>' . "\n";
        $css .= $custom_css . "\n";
        $css .= '</style>' . "\n";
        $css .= '<!-- Generated by WHMpress -->' . "\n";

        echo $css;
    }
}

//add_action( 'wp_head', 'whmp_get_custom_css', 20 );

function whmpress_replace_content($content)
{
    $content = str_replace('-**-', '&#91;', $content);
    $content = str_replace('_**_', '&#93;', $content);

    return $content;
}

add_filter('the_content', 'whmpress_replace_content');

define('WHMP_BASENAME', plugin_basename(__FILE__));

//On plugin activation schedule our daily database backup
register_activation_hook(__FILE__, 'whmp_schedule');
function whmp_schedule()
{
    $curr_theme = wp_get_theme()->get('Name');
    if ($curr_theme == "neXum") {
        update_option('load_sytle_orders', 'author');
    }

    //Use wp_next_scheduled to check if the event is already scheduled
    $timestamp = wp_next_scheduled('whmp_daily_check');

    //If $timestamp == false schedule daily backups since it hasn't been done previously
    if ($timestamp == false) {
        //Schedule the event for right now, then to repeat daily using the hook 'whmp_daily_check'
        wp_schedule_event(time(), 'daily', 'whmp_daily_check');
    }
}

//Hook our function , whmp_daily_check_now(), into the action whmp_daily_check
//add_action('whmp_daily_check', 'whmp_daily_check_now');
//function whmp_daily_check_now()
//{
//    global $WHMPress;
//    if (!$WHMPress) {
//        $WHMPress = new WHMPress();
//    }
//    $WHMPress->verify_purchase();
//}

// Setting language
//add_action( 'init', 'whmp_load_textdomain' );
function whmp_load_textdomain()
{
    load_plugin_textdomain('whmpress', false, dirname(plugin_basename(__FILE__)) . "/languages");
}

add_action('plugins_loaded', 'whmp_load_textdomain');


$api_url = 'http://plugins.creativeon.com/api/';
$plugin_slug = basename(dirname(__FILE__));

// Take over the update check
function check_for_plugin_update_whmpress($checked_data)
{
    global $api_url, $plugin_slug, $wp_version;

    //Comment out these two lines during testing.
    if (empty($checked_data->checked)) {
        return $checked_data;
    }

    $args = [
        'slug' => $plugin_slug,
        'version' => $checked_data->checked[$plugin_slug . '/' . $plugin_slug . '.php'],
    ];
    $request_string = [
        'body' => [
            'action' => 'basic_check',
            'request' => serialize($args),
            'api-key' => md5(get_bloginfo('url')),
        ],
        'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'),
    ];

    // Start checking for an update
    $raw_response = wp_remote_post($api_url, $request_string);

    if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)) {
        $response = unserialize($raw_response['body']);
    } else {
        $response = null;
    }

    // Feed the update data into WP updater
    if (is_object($response) && !empty($response)) {
        $checked_data->response[$plugin_slug . '/' . $plugin_slug . '.php'] = $response;
    }

    return $checked_data;
}

//add_filter( 'pre_set_site_transient_update_plugins', 'check_for_plugin_update_whmpress' );

// Take over the Plugin info screen
function plugin_api_call_whmpress($def, $action, $args)
{
    global $plugin_slug, $api_url, $wp_version;

    if (!isset($args->slug) || ($args->slug != $plugin_slug)) {
        return false;
    }

    // Get the current version
    $plugin_info = get_site_transient('update_plugins');
    $current_version = $plugin_info->checked[$plugin_slug . '/' . $plugin_slug . '.php'];
    $args->version = $current_version;

    $request_string = [
        'body' => [
            'action' => $action,
            'request' => serialize($args),
            'api-key' => md5(get_bloginfo('url')),
        ],
        'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url'),
    ];

    $request = wp_remote_post($api_url, $request_string);

    if (is_wp_error($request)) {
        $res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
    } else {
        $res = unserialize($request['body']);

        if ($res === false) {
            $res = new WP_Error('plugins_api_failed', __('An unknown error occurred', "whmpress"), $request['body']);
        }
    }

    return $res;
}

add_filter('plugins_api', 'plugin_api_call_whmpress', 10, 3);

function whmpress_addUpgradeMessageLink()
{
    /*$username = vc_settings()->get( 'envato_username' );
    $api_key = vc_settings()->get( 'envato_api_key' );
    $purchase_code = vc_settings()->get( 'js_composer_purchase_code' );
    echo '<style type="text/css" media="all">tr#wpbakery-visual-composer + tr.plugin-update-tr a.thickbox + em { display: none; }</style>';
    if ( empty( $username ) || empty( $api_key ) || empty( $purchase_code ) ) {
        echo ' <a href="' . $this->url . '">' . __( 'Download new version from CodeCanyon.', 'js_composer' ) . '</a>';
    } else {
        // update.php?action=upgrade-plugin&plugin=testimonials-widget%2Ftestimonials-widget.php&_wpnonce=6178d48b6e
        // echo '<a href="' . wp_nonce_url( admin_url( 'plugins.php?vc_action=vc_upgrade' ) ) . '">' . __( 'Update Visual Composer now.', 'js_composer' ) . '</a>';
        echo '<a href="' . wp_nonce_url( admin_url( 'update.php?action=upgrade-plugin&plugin='.vc_plugin_name() ), 'upgrade-plugin_'.vc_plugin_name() ) . '">' . __( 'Update Visual Composer now.', 'js_composer' ) . '</a>';
    }*/
//    echo "<a target='_blank' href='http://codecanyon.net/item/whmpress-whmcs-wordpress-integration-plugin-/9946066'>Download from CodeCanyon</a>";
}

add_action('in_plugin_update_message-whmpress/whmpress.php', 'whmpress_addUpgradeMessageLink');

/*
    Maintaining table for store domain search logs.
*/
$charset_collate = $wpdb->get_charset_collate();
$__table_name = whmp_get_logs_table_name();
$sql = "CREATE TABLE $__table_name (
  id int(13) NOT NULL AUTO_INCREMENT,
  search_term varchar(100) DEFAULT '' NOT NULL,
  search_time datetime NOT NULL,
  search_ip varchar(50) DEFAULT '' NOT NULL,
  domain_available boolean NOT NULL,
  UNIQUE KEY id (id)
) $charset_collate;";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

/*
    Set priority of WHMpress loading
*/
function whmp_plugin_first()
{
    // ensure path to this file is via main wp plugin path
    #$wp_path_to_this_file = preg_replace('/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR."/$2", __FILE__);
    //file_put_contents("D:\\abc.txt", $wp_path_to_this_file, FILE_APPEND);
    #$this_plugin = plugin_basename(trim($wp_path_to_this_file));

    //file_put_contents( 'D:\errors.txt' , ob_get_contents() );
    $active_plugins = get_option('active_plugins');

    if (in_array("whmpress/whmpress.php", $active_plugins) && in_array("js_composer/js_composer.php", $active_plugins) && in_array("WHMpress_Client_Area/client-area.php", $active_plugins)) {
        // If all 3 plugins are activated

        # Get WHMpress and remove
        $whmp_key = array_search("whmpress/whmpress.php", $active_plugins);
        array_splice($active_plugins, $whmp_key, 1);

        # Get ClientAre and remove
        $ca_key = array_search("WHMpress_Client_Area/client-area.php", $active_plugins);
        array_splice($active_plugins, $ca_key, 1);

        $js_key = array_search("js_composer/js_composer.php", $active_plugins);
        array_splice($active_plugins, ($js_key + 1), 0, "whmpress/whmpress.php");
        array_splice($active_plugins, ($js_key + 2), 0, "WHMpress_Client_Area/client-area.php");

        update_option('active_plugins', $active_plugins);
    } else if (in_array("whmpress/whmpress.php", $active_plugins) && in_array("WHMpress_Client_Area/client-area.php", $active_plugins)) {

        # Get ClientAre and remove
        $ca_key = array_search("WHMpress_Client_Area/client-area.php", $active_plugins);
        array_splice($active_plugins, $ca_key, 1);

        $whmp_key = array_search("whmpress/whmpress.php", $active_plugins);
        array_splice($active_plugins, ($whmp_key + 1), 0, "WHMpress_Client_Area/client-area.php");

        update_option('active_plugins', $active_plugins);
    } else if (in_array("whmpress/whmpress.php", $active_plugins) && in_array("js_composer/js_composer.php", $active_plugins)) {

        # Get WHMpress and remove
        $whmp_key = array_search("whmpress/whmpress.php", $active_plugins);
        array_splice($active_plugins, $whmp_key, 1);

        $js_key = array_search("js_composer/js_composer.php", $active_plugins);
        array_splice($active_plugins, ($js_key + 1), 0, "whmpress/whmpress.php");

        update_option('active_plugins', $active_plugins);
    }

    /*if (count($active_plugins)>1) {
        // Getting and removing WHMpress
        $whmp_key = array_search("whmpress/whmpress.php", $active_plugins);
        array_splice($active_plugins, $whmp_key, 1);

        $js_key = array_search("js_composer/js_composer.php", $active_plugins);
        if ($js_key!==false) {
            array_splice($active_plugins, ($js_key+1), 0, "whmpress/whmpress.php");
        }

        $ca_key = array_search("WHMpress_Client_Area/client-area.php", $active_plugins);
        if ($ca_key!==false) {
            array_splice($active_plugins, $ca_key, 1);
            $whmp_key = array_search("whmpress/whmpress.php", $active_plugins);
            array_splice($active_plugins, ($whmp_key+1), 0, "WHMpress_Client_Area/client-area.php");
        }

        update_option('active_plugins', $active_plugins);
    }*/
}

add_action("activated_plugin", "whmp_plugin_first");

if (get_option('whmpress_cron_recurrance') <> '') {

    add_action('whmpress_corn_hook', 'whmpress_cron_function');

    $timestamp = wp_next_scheduled('whmpress_corn_hook');

    // remove any existing event, since reocrruance may have changed.

    if ($timestamp) {
        $previous_reoccurance = wp_get_schedule("whmpress_corn_hook");
        $current_reoccurance = get_option('whmpress_cron_recurrance');

        if ($previous_reoccurance <> $current_reoccurance) {
            //unregister occurance and register new occrance
            wp_unschedule_event($timestamp, 'whmpress_corn_hook');
            wp_schedule_event(time(), $current_reoccurance, 'whmpress_corn_hook');
            whmpress_write_log("cron > removed > added new.");


        } else {
            //do nothing
        }

    } else {
        // schedule the event here
        wp_schedule_event(time(), get_option('whmpress_cron_recurrance'), 'whmpress_corn_hook');
        whmpress_write_log("cron > added new.");
    }

} else {
    // remove any scheduled events as it is disabled now.
    $timestamp = wp_next_scheduled('whmpress_corn_hook');

    if ($timestamp) {
        wp_unschedule_event($timestamp, 'whmpress_corn_hook');
        whmpress_write_log("cron > removed all.");
    }

}

include ('elementor-main-class.php');

// Making tooltips table

register_activation_hook(__FILE__, [$WHMPress, 'add_tooltips_table']);
register_activation_hook(__FILE__, [$WHMPress, 'add_ip2country_table']);