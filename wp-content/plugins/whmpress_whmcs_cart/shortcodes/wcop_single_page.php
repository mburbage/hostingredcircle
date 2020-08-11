<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id = $billing_cycle = $currency_id = $order_type = $affiliate_id = $style = $pids = $gids = $domain_products = '';
if ( ! isset( $atts ) ) {
	$atts = [];
}
if ( isset( $_REQUEST['domain'] ) && ! isset( $_REQUEST['pid'] ) ) {
	$_REQUEST['order_type'] = 'order_domain';
}
if ( isset( $_REQUEST['order_type'] ) && $_REQUEST['order_type'] == 'order_product' ) {
	$_REQUEST['order_type'] = 'order_product';
}
if ( isset( $_REQUEST['currency'] ) && $_REQUEST['currency'] > 0 ) {
	$currency_id = whcom_validate_currency_id( $_REQUEST['currency'] );
	whcom_update_current_currency( $currency_id );
}
else {
	$currency_id = whcom_get_current_currency_id();
}

$atts = shortcode_atts( [
	'currency_id'                      => ( isset( $_REQUEST['currency'] ) && is_integer( intval( $_REQUEST['currency'] ) ) ) ? $_REQUEST['currency'] : whcom_get_current_currency_id(),
	'billingcycle'                     => ( ! empty( $_REQUEST['billingcycle'] ) ) ? esc_attr( $_REQUEST['billingcycle'] ) : '',
	'affiliate_id'                     => ( isset( $_REQUEST['affiliate_id'] ) && is_string( $_REQUEST['affiliate_id'] ) ) ? $_REQUEST['affiliate_id'] : '',
	'domain_products'                  => ( ! empty( $_REQUEST['dp'] ) && strtolower( $_REQUEST['dp'] ) == 'yes' ) ? true : false,
	'hide_navigation'                  => ( isset( $_REQUEST['hide_navigation'] ) && is_string( $_REQUEST['hide_navigation'] ) ) ? $_REQUEST['hide_navigation'] : '',
	'hide_domain'                      => ( isset( $_REQUEST['hide_domain'] ) && is_string( $_REQUEST['hide_domain'] ) ) ? $_REQUEST['hide_domain'] : '',
	'hide_domain_transfer'             => ( isset( $_REQUEST['hide_domain_transfer'] ) && is_string( $_REQUEST['hide_domain_transfer'] ) ) ? $_REQUEST['hide_domain_transfer'] : '',
	'hide_domain_configuration'        => ( isset( $_REQUEST['hide_domain_configuration'] ) && is_string( $_REQUEST['hide_domain_configuration'] ) ) ? $_REQUEST['hide_domain_configuration'] : '',
	'hide_product'                     => '',
	'hide_additional_services'         => ( isset( $_REQUEST['hide_additional_services'] ) && is_string( $_REQUEST['hide_additional_services'] ) ) ? strtolower($_REQUEST['hide_additional_services']) : '',
	'hide_promo'                       => ( isset( $_REQUEST['hide_promo'] ) ) ? strtolower($_REQUEST['hide_promo']) : '',
	'gids'                             => ( isset( $_REQUEST['gids'] ) && is_string( $_REQUEST['gids'] ) ) ? $_REQUEST['gids'] : '',
	'pids'                             => ( isset( $_REQUEST['pids'] ) && is_string( $_REQUEST['pids'] ) ) ? $_REQUEST['pids'] : '',
	'style'                            => ( isset( $_REQUEST['style'] ) && is_string( $_REQUEST['style'] ) ) ? $_REQUEST['style'] : '01_default',
    //== copy all gator parameters to core
    'pid'                              => ( isset( $_REQUEST['pid'] ) && is_integer( intval( $_REQUEST['pid'] ) ) ) ? $_REQUEST['pid'] : '0',
    'promocode'                        => (!empty($_REQUEST['promocode'])) ? esc_attr($_REQUEST['promocode']) : '',
    'hide_selected_product'            => isset( $_REQUEST['hide_selected_product'] )? strtolower($_REQUEST['hide_selected_product']) : '',
    'show_summary_product_description' => isset( $_REQUEST['show_summary_product_description'] )? strtolower($_REQUEST['show_summary_product_description']) : '',
    'hosting_section_title'            => ( isset( $_REQUEST['hosting_section_title'] ) && is_string( $_REQUEST['hosting_section_title'] ) ) ? $_REQUEST['hosting_section_title'] : '',
    'addon_section_title'              => ( isset( $_REQUEST['addon_section_title'] ) && is_string( $_REQUEST['addon_section_title'] ) ) ? $_REQUEST['addon_section_title'] : '',
    'hide_group_name_summary'          => ( isset( $_REQUEST['hide_group_name_summary'] ) ) ? strtolower($_REQUEST['hide_group_name_summary']) : '',
    'post_load_login_form'              => ( isset( $_REQUEST['post_load_login_form'] ) ) ? strtolower($_REQUEST['post_load_login_form']) : 'no',
], $atts );

extract( $atts );
$currency_id = whcom_validate_currency_id( $currency_id );
whcom_update_current_currency( $currency_id ); ?>
<?php
$file = wcop_get_template_directory() . '/templates/single_page/' . $style . '/01_main.php';
if ( is_file( $file ) ) {
	require $file;
}
else {
	require wcop_get_template_directory() . '/templates/single_page/01_default/01_main.php';
}
if($style == '08_gator') {
    require_once WCOP_PATH . '/skeleton.html';
    ?>
    <script>
        if (document.readyState === 'loading') {
            document.getElementById('wcop_skeleton').style.display = 'block';
            document.getElementById('wcop_sp_main').style.display = 'none';
        }
        document.onreadystatechange = function () {
            var state = document.readyState;
            if (state === 'interactive') {
                document.getElementById('wcop_skeleton').style.display = 'block';
                document.getElementById('wcop_sp_main').style.display = 'none';
            } else if (state === 'complete') {
                setTimeout(function() {
                    document.getElementById('wcop_skeleton').style.display = 'none';
                    document.getElementById('wcop_sp_main').style.display = 'block';
                },2000);
            }
        }
    </script>
    <?php
}









