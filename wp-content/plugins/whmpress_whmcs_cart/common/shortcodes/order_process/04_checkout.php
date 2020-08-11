<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$payment_gateways = whcom_get_payment_gateways()['payment_gateways'];
$currencies       = whcom_get_all_currencies();
$countries        = whcom_get_countries_array();
$cop_tags         = [
	'whmpress_store',
	'whmpress_cart_list_products',
	'whmpress_cart_config_product'
];
$is_wcop          = ( ! empty( $tag ) && in_array( $tag, $cop_tags ) ) ? 'yes' : 'no';
$merchant_gateway = '';
if (function_exists('wcop_use_merchant_gateway')) {
	$merchant_gateway = ( wcop_use_merchant_gateway() && get_option( 'merchant_gateway_key', '' ) != '' ) ? (string) get_option( 'merchant_gateway_key' ) : false;
}



?>

<?php ob_start();

$checked          = 'checked';
$show_cc          = 'none';
$checked_class    = 'whcom_checked';
$selected_gateway = '';
?>
<div class="whcom_form_field whcom_text_center">
    <div class="whcom_radio_container">
		<?php foreach ( $payment_gateways as $payment_gateway ) { ?>
            <label class="whcom_radio <?php echo $checked_class; ?>">
                <input type="radio"
                       name="paymentmethod"
                       class="whcom_sp_cc_switcher"
                       value="<?php echo $payment_gateway['module'] ?>" <?php echo $checked; ?>
                       data-merchent-gateway="<?php echo $merchant_gateway; ?>">
				<?php echo $payment_gateway['displayname']; ?>
            </label>
			<?php if ( $checked == 'checked' ) {
				$selected_gateway = (string) $payment_gateway['module'];
			} ?>
			<?php $checked = $checked_class = ''; ?>
		<?php } ?>
    </div>
</div>
<?php
$show_cc = ( ( $merchant_gateway ) && ( $selected_gateway == $merchant_gateway ) ) ? 'block' : 'none';

?>
<?php if ( $merchant_gateway && $is_wcop == 'yes') { ?>
    <div class="whcom_sp_cc_fields" style="display: <?php echo $show_cc; ?>;">
		<?php echo whcom_render_cc_form(); ?>
    </div>
<?php } ?>


<?php $payment_selection = ob_get_clean(); ?>

<div class="whcom_op_checkout_container">

    <div class="whcom_page_heading ">
		<?php esc_html_e( 'Checkout', 'whcom' ) ?>
    </div>
    <div class="whcom_margin_bottom_15 whcom_page_sub_heading">
		<?php esc_html_e( 'Please enter your personal details and billing information to checkout.', 'whcom' ) ?>
    </div>

    <form method="post" class="whcom_op_checkout_form" novalidate>
        <input type="hidden" name="action" value="whcom_op">
        <input type="hidden" name="whcom_op_what" value="checkout">
        <input type="hidden" name="is_wcop" value="<?php echo $is_wcop; ?>">
		<?php if ( whcom_is_client_logged_in() ) { ?>
            <?php echo whcom_render_logged_in_client_form(); ?>
		<?php } else { ?>
			<?php echo whcom_render_client_register_JS(); ?>
            <div class="whcom_op_section_content">
                <div class="whcom_op_register_login_container">
                    <div class="whcom_text_right">
						<span class="whcom_op_register_link whcom_button whcom_button_warning whcom_op_register_login_link"
                              style="display: none" id="whcom_op_register_link">
							<?php esc_html_e( 'Register New Account', 'whcom' ) ?>
						</span>
                        <span class="whcom_op_login_link whcom_button whcom_button_info whcom_op_register_login_link"
                              style="display: inline-block" id="whcom_op_login_link">
							<?php esc_html_e( 'Already Registered?', 'whcom' ) ?>
						</span>
                    </div>
                    <div class="whcom_tabs_content active" id="whcom_op_register_container" style="display: block">
                        <input type="hidden" name="currency" value="<?php echo whcom_get_current_currency_id(); ?>">
						<?php echo whcom_render_register_form_fields(); ?>
                    </div>
                    <div class="whcom_tabs_content whcom_op_login_form" id="whcom_op_login_container"
                         style="display: none">
                        <div class="whcom_sub_heading_style_1">
                            <span><?php esc_html_e( "Existing Customer Login", "whcom" ) ?></span>
                        </div>
                        <?php echo whcom_render_login_form_fields(); ?>
                    </div>
                </div>
                <input type="hidden" name="whcom_op_client_type" value="register" id="whcom_op_client_type">
            </div>
		<?php } ?>
        <div class="whcom_op_payment_method">
            <div class="whcom_sub_heading_style_1">
                <span><?php esc_html_e( "Payment Details", "whcom" ) ?></span>
            </div>
		    <?php echo $payment_selection;?>
        </div>
        <div class="whcom_op_tos_container">
			<?php echo whcom_render_tos_fields(); ?>
        </div>
        <div class="whcom_op_response">

        </div>
        <div class="whcom_op_submit_container whcom_text_center">
            <button type="submit"><?php esc_html_e( "Complete Order", "whcom" ) ?></button>
        </div>
    </form>
</div>
