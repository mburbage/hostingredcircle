<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
?>


<div class="wcop_sp_section_heading">
	<i class="whcom_icon_thumbs-up-alt"></i>
	<span><?php esc_html_e( "Review Order Details", "whcom" ) ?></span>
	<span class="whcom_icon_spinner-1 whcom_animate_spin wcop_sp_product_summary_spinner"></span>
</div>
<div class="wcop_sp_section_content">
	<?php $taxes_temp = whcom_get_tax_levels(); ?>
	<?php if ( $taxes_temp['hav_countries'] || empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
		<div class="whcom_tabs_container whcom_tabs_fancy_2">
			<ul class="whcom_tab_links whcom_text_center whcom_margin_bottom_0">
				<?php if ( empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
                <?php if ( strtolower($atts['hide_promo']) != 'yes') { ?>
					<li data-tab="wcop_sp_apply_promo_container" class="active whcom_tab_link">
						<?php esc_html_e( 'Apply Promo Code', "whcom" ) ?>
					</li>
				<?php } } ?>
				<?php if ( $taxes_temp['hav_countries'] ) { ?>
					<li data-tab="wcop_sp_estimate_taxes_container" class="whcom_tab_link">
						<?php esc_html_e( 'Estimate Taxes', "whcom" ) ?>
					</li>
				<?php } ?>
			</ul>
			<?php if ( empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
            <?php if ( strtolower($atts['hide_promo']) != 'yes') { ?>
				<div class="whcom_tabs_content active" id="wcop_sp_apply_promo_container">
					<div class="wcop_sp_promo_container">
						<?php echo wcop_sp_render_promo_html('',$promocode); ?>
					</div>
				</div>
			<?php } } ?>
			<?php if ( $taxes_temp['hav_countries'] ) { ?>
				<div class="whcom_tabs_content" id="wcop_sp_estimate_taxes_container">
					<div class="wcop_sp_estimate_taxes_container">
						<?php echo wcop_sp_render_estimate_taxes_html(); ?>
					</div>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<div class="wcop_sp_order_summary">
	</div>
	<?php echo whcom_render_tos_fields(); ?>
	<div class="whcom_sp_order_response">

	</div>
	<div class="whcom_form_field whcom_text_center">
		<button type="submit"
		        class="whcom_button whcom_button_big"><?php esc_html_e( "Checkout Now!", "whcom" ) ?></button>
	</div>
</div>