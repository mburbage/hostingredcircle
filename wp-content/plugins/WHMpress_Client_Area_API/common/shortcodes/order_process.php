<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$atts = shortcode_atts( [
    'currency_id'     => ( isset( $_REQUEST['currency'] ) && is_integer( intval( $_REQUEST['currency'] ) ) ) ? $_REQUEST['currency'] : whcom_get_current_currency_id(),
    'gids'            => '',
    'pids'            => '',
    'domain_products' => (!empty($_REQUEST['dp']) && strtolower($_REQUEST['dp']) == 'yes') ? 'yes' : 'no',
    'promocode'     => ''
], $atts );
extract( $atts );

$currency_id = whcom_validate_currency_id( $currency_id );
whcom_update_current_currency( $currency_id );

$promocode = ( isset( $_REQUEST['promocode'] ) && is_string( $_REQUEST['promocode'] ) ) ? $_REQUEST['promocode'] : $promocode;

$res = whcom_add_update_cart_item([
    'cart_index' => '0',
    'promocode' => $promocode,
]);


//if (! empty($_REQUEST["promocode"])) {
////    $res = whcom_add_update_cart_item([
////        'cart_index' => '0',
////        'promocode' => $_REQUEST["promocode"],
////    ]);
////}

extract($atts);

if ( ! empty( $_REQUEST['a'] ) ) {
    $action = (string) $_REQUEST['a']; ?>
    <div class="whcom_op_main whcom_main">
        <?php switch ( $action ) {
            case 'add' : {
                // Register/Transfer/Order domain
                if ( ! empty( $_REQUEST['domain'] ) && empty($_REQUEST['pid'])) {
                    ob_start();
                    include_once WHCOM_PATH . '/shortcodes/order_process/01_domain.php';
                    echo ob_get_clean();
                    break;
                }
                else if ( ! empty( $_REQUEST['pid'] ) && (int) $_REQUEST['pid'] > 0 ) {
                    $product_id = $_REQUEST['pid'];
                    ob_start();
                    include_once WHCOM_PATH . '/shortcodes/order_process/02_product.php';
                    echo ob_get_clean();
                    break;
                }
                else if (!empty($_REQUEST['serviceids']) && (int) $_REQUEST['serviceids'] > 0 && !empty($_REQUEST['addonids']) && (int) $_REQUEST['addonids'] > 0 ) {
                    whcom_add_update_cart_item($_REQUEST);
                    ob_start();
                    include_once WHCOM_PATH . '/shortcodes/order_process/03_summary.php';
                    echo ob_get_clean();
                    break;
                }
                continue;
            }
            case 'confdomains' : {
                ob_start();
                include_once WHCOM_PATH . '/shortcodes/order_process/01_domains_config.php';
                echo ob_get_clean();
                break;
            }
            case 'view' : {
                ob_start();
                include_once WHCOM_PATH . '/shortcodes/order_process/03_summary.php';
                echo ob_get_clean();
                break;
            }
            case 'checkout' : {
                ob_start();
                if (whcom_is_cart_empty()) {
                    include_once WHCOM_PATH . '/shortcodes/order_process/03_summary.php';
                }
                else {
                    include_once WHCOM_PATH . '/shortcodes/order_process/04_checkout.php';
                }
                echo ob_get_clean();
                break;
            }
            case 'viewinvoice' : {
                if ( ! empty( $_REQUEST['id'] ) && (int) $_REQUEST['id'] > 0 ) {
                    $order_complete_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '?whmpca=dashboard');
                    echo whcom_generate_invoice_iframe((int)$_REQUEST['id'], $order_complete_url);
                    break;
                }
                continue;
            }
            default : {
                echo whcom_order_list_products_render($atts, $content, $tag);
            }
        } ?>
    </div>
    <?php
}
else {
    echo whcom_order_list_products_render($atts, $content, $tag);
}




