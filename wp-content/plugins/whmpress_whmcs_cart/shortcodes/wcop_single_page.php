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
	'currency_id'                      => wcop_param_value('currency','cid','int',whcom_get_current_currency_id()),
	'billingcycle'                     => wcop_param_value('billingcycle','bicy','string'),
	'affiliate_id'                     => ( isset( $_REQUEST['affiliate_id'] ) && is_string( $_REQUEST['affiliate_id'] ) ) ? $_REQUEST['affiliate_id'] : '',
	'domain_products'                  => ( ! empty( $_REQUEST['dp'] ) && strtolower( $_REQUEST['dp'] ) == 'yes' ) ? true : false,
	'hide_navigation'                  => wcop_param_value('hide_navigation','hn','string'),
	'hide_domain'                      => wcop_param_value('hide_domain','hd','string'),
	'hide_domain_transfer'             => wcop_param_value('hide_domain_transfer','hdt','string'),
    'hide_domain_owned'                => wcop_param_value('hide_domain_owned','hdo','string'),
	'hide_domain_configuration'        => wcop_param_value('hide_domain_configuration','hdc','string'),
	'hide_product'                     => wcop_param_value('hide_product','hp','string'),
	'hide_additional_services'         => wcop_param_value('hide_additional_services','has','string'),
	'hide_promo'                       => wcop_param_value('hide_promo','hpc','string'),
	'gids'                             => ( isset( $_REQUEST['gids'] ) && is_string( $_REQUEST['gids'] ) ) ? $_REQUEST['gids'] : '',
	'pids'                             => ( isset( $_REQUEST['pids'] ) && is_string( $_REQUEST['pids'] ) ) ? $_REQUEST['pids'] : '',
	'style'                            => wcop_param_value('style','st','string','01_default'),
    //== copy all elegant parameters to core
    'pid'                              => ( isset( $_REQUEST['pid'] ) && is_integer( intval( $_REQUEST['pid'] ) ) ) ? $_REQUEST['pid'] : '0',
    'promocode'                        => wcop_param_value('promocode','pc','string'),
    'hide_selected_product_section'    => wcop_param_value('hide_selected_product_section','hsps','string'),
    'hide_selected_product'            => wcop_param_value('hide_selected_product','hsp','string'),
    'show_summary_product_description' => wcop_param_value('show_summary_product_description','spds','string'),
    'hosting_section_title'            => wcop_param_value('hosting_section_title','hst','string'),
    'addon_section_title'              => wcop_param_value('addon_section_title','ast','string'),
    'hide_summary_group_name'          => wcop_param_value('hide_summary_group_name','hsgn','string'),
    'post_load_login_form'             => wcop_param_value('post_load_login_form','pllf','string'),
    'hide_server_fields'               => wcop_param_value('hide_server_fields','hsf','string'),
    'show_domain_nameservers'          => wcop_param_value('show_domain_nameservers','sdn','string'),
    'hide_hosting_section_title'       => wcop_param_value('hide_hosting_section_title','hhst','string'),
], $atts );

extract( $atts );
$currency_id = whcom_validate_currency_id( $currency_id );
whcom_update_current_currency( $currency_id ); ?>
<?php
$file = wcop_get_template_directory() . '/templates/single_page/' . $atts["style"] . '/01_main.php';
if ( is_file( $file ) ) {
	require $file;
}
else {
	require wcop_get_template_directory() . '/templates/single_page/01_default/01_main.php';
}
if($atts["style"] == '08_elegant') {
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









