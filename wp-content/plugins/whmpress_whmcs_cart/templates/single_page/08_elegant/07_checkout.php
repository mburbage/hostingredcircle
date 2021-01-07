<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
?>

<div class="wcop_sp_section_heading">
	<i class="whcom_icon_thumbs-up-alt"></i>
	<span><?php esc_html_e( "Payment Methods", "whcom" ) ?></span>
	<span class="whcom_icon_spinner-1 whcom_animate_spin wcop_sp_product_summary_spinner" style="display: none;"></span>
</div>
<div class="wcop_sp_section_content">

	<?php echo wcop_sp_render_payment_selection('elegant_08_payment_options'); ?>
	<div class="wcop_sp_order_summary" style="display: none !important;">
	</div>
    <?php echo whcom_render_tos_fields('08_elegant'); ?>
	<div class="whcom_sp_order_response"></div>

	<div class="whcom_form_field whcom_text_center">
		<button type="submit" class="whcom_button whcom_button_big"><?php esc_html_e( "Checkout Now!", "whcom" ) ?></button>
	</div>
</div>