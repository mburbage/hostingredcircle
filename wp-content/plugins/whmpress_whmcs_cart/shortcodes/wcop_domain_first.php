<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id = $billing_cycle = $currency_id = $order_type = $affiliate_id = $style = $pids = $gids = '';
if ( ! isset( $atts ) ) {
	$atts = [];
}
if ( isset( $_REQUEST['domain'] ) && ! isset( $_REQUEST['pid'] ) ) {
	$_REQUEST['order_type'] = 'order_domain';
}
if ( isset( $_REQUEST['order_type'] ) && $_REQUEST['order_type'] == 'order_product' ) {
	$_REQUEST['order_type'] = 'order_product';
}

$currency_id = '0';
if ( isset( $_REQUEST['currency'] ) && $_REQUEST['currency'] > 0 ) {
	$currency_id = whcom_validate_currency_id( $_REQUEST['currency'] );
	whcom_update_current_currency( $currency_id );
}
else {
	$currency_id = whcom_get_current_currency_id();
}
extract( shortcode_atts( [
	'product_id'    => ( isset( $_REQUEST['pid'] ) && is_integer( intval( $_REQUEST['pid'] ) ) ) ? $_REQUEST['pid'] : '0',
	'currency_id'   => whcom_get_current_currency_id(),
	'billing_cycle' => ( isset( $_REQUEST['billingcycle'] ) && is_string( $_REQUEST['billingcycle'] ) ) ? $_REQUEST['billingcycle'] : '',
	'order_type'    => ( isset( $_REQUEST['order_type'] ) && is_string( $_REQUEST['order_type'] ) ) ? $_REQUEST['order_type'] : 'order_domain',
	'affiliate_id'  => ( isset( $_REQUEST['affiliate_id'] ) && is_string( $_REQUEST['affiliate_id'] ) ) ? $_REQUEST['affiliate_id'] : '',
	'gids'          => '',
	'pids'          => '',
	'style'         => ''
], $atts ) );


$currency_id = whcom_validate_currency_id( $currency_id );
whcom_update_current_currency( $currency_id );

$file = wcop_get_template_directory('domain_first') . '/templates/domain_first/' . $style . '/01_main.php';
if ( is_file( $file ) ) {
	echo $file . '<br>';
	require $file;
}
else {

	require wcop_get_template_directory('domain_first') . '/templates/domain_first/01_default/01_main.php';
	//require wcop_get_template_directory('domain_first') . '/templates/domain_first/default/01_domain.php';
	//require wcop_get_template_directory() . '/templates/domain_first/default/02_product.php';
	//require wcop_get_template_directory() . '/templates/domain_first/default/03_domains_config.php';
	//require wcop_get_template_directory() . '/templates/domain_first/default/04_products_config.php';
	//require wcop_get_template_directory() . '/templates/domain_first/default/05_checkout.php';
}



