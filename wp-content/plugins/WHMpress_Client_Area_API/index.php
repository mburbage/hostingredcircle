<?php
/*
 * Plugin Name: WHMPress - WHMCS Client Area
 *  * Plugin URI: http://WHMpress.com
 * Description: WHMCS Client Area using API (WCAP) for WordPress impliments WHMCS Client Area within WordPress using API. It uses WHMCS API and Extended API called WHMPress Helper.
 * Version: 3.4-revision-6
 * Text domain: whcom
 * Domain Path: /common/languages
 * Author: creativeON
 * Author URI: http://creativeon.com
*/

if (!defined('WCAP_PATH')) {
    define('WCAP_PATH', dirname(__FILE__));
}
if (!defined('WCAP_ADMIN_DIR')) {
    define('WCAP_ADMIN_DIR', WCAP_PATH . '/admin');
}
if (!defined('WCAP_URL')) {
    define('WCAP_URL', untrailingslashit(plugins_url(basename(dirname(__FILE__)))));
}
if (!defined('WCAP_ADMIN_URL')) {
    define('WCAP_ADMIN_URL', WCAP_URL . '/admin');
}
if (!defined('WCAP_FILE')) {
    define('WCAP_FILE', __FILE__);
}
if (!defined('WCAP_VERSION')) {
    define('WCAP_VERSION', '3.4-revision-6');
}


## Adding Common functions
if (!defined('WHCOM_VERSION')) {
    if (!defined('WHCOM_URL')) {
        define('WHCOM_URL', plugin_dir_url(__FILE__) . "common");
    }
    require_once(WCAP_PATH . '/common/whcom.php');
}
require_once WCAP_ADMIN_DIR . '/vc.php';
require_once WCAP_ADMIN_DIR . '/fb.php';
require_once WCAP_ADMIN_DIR . '/admin.php';
require_once WCAP_PATH . '/wcap-elementor-main-class.php';
require_once(ABSPATH . WPINC . '/class-phpass.php');
$wp_hasher = new PasswordHash(10, false);

include_once WCAP_PATH . "/library/WCAP.php";

$W = new WCAP();

include_once WCAP_PATH . '/library/functions.php';
include_once WCAP_PATH . '/library/functions_i.php';

function wcap_load_textdomain()
{

    load_plugin_textdomain('whcom', FALSE, basename(dirname(__FILE__)) . '/common/languages/');


}

add_action('plugins_loaded', 'wcap_load_textdomain');

if (!defined('CC_SAVEABLE')) {
    define('CC_SAVEABLE', wcap_cc_saveable());
}