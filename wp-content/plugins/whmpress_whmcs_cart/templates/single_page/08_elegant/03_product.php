<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id    = $atts['pid'];
$billing_cycle = ( isset( $_REQUEST['billingcycle'] ) && is_string( $_REQUEST['billingcycle'] ) ) ? $_REQUEST['billingcycle'] : '';

$sld = ( isset( $_GET['sld'] ) ) ? esc_attr( $_GET['sld'] ) : '';
$tld = ( isset( $_GET['tld'] ) ) ? esc_attr( $_GET['tld'] ) : '';
$typ = ( isset( $_GET['domain'] ) ) ? esc_attr( $_GET['domain'] ) : '';
if ( ! empty( $sld ) && ! empty( $tld ) ) {
	$domain_products = 'yes';
}
$include_domain = true;
if ( ! empty( $product_id ) ) {
	$product_details = whcom_get_product_details( $product_id );
	//whcom_ppa( $product_details );
	if ( ! empty( $product_details && empty( $product_details['showdomainoptions'] ) ) ) {
		$domain_products = 'no';
	}
} ?>


<div class="wcop_sp_section_heading">
	<i class="whcom_icon_ok-circled"></i>
	<?php if ( !empty( $atts['hosting_section_title'] ) ) { ?>
		<span><?php echo $atts['hosting_section_title'] ?></span>
	<?php } else { ?>
		<span><?php echo esc_html_x( "Choose a Hosting Plan (Optional)", "whcom" ) ?></span>
	<?php } ?>
</div>
<div class="wcop_sp_section_content">
	<div class="whcom_form_field">
		<label for="wcop_sp_product_select"><?php esc_html_e( "Select Product /Service", "whcom" ) ?></label>
		<?php echo wcop_sp_render_products_dropdown( $product_id, $pids, $gids, $domain_products ); ?>
	</div>
	<div class="wcop_sp_prod_billingcycle">

	</div>
</div>