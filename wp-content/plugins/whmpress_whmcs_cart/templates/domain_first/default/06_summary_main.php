<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$current_user     = whcom_get_current_client();
$user_email       = ( empty( $current_user ) ) ? '' : $current_user['email'];
$payment_gateways = whcom_get_payment_gateways()['payment_gateways'];
$cart_items       = whcom_get_cart()['all_items'];


?>

<div class="wcop_df_cart_list wcop_df_page">
	<div class="wcop_df_page_header_2">
		<?php $page = 'checkout' ?>
		<?php include_once wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/00_top_icons.php'; ?>
	</div>
	<div class="wcop_df_summary_container wcop_df_page_content">
		<div class="wcop_df_page_heading">
			<i class="whcom_icon_ok-squared whcom_text_success"></i>
			<span><?php esc_html_e( 'Review and Checkout', "whcom" ); ?></span>
		</div>
		<div class="whcom_op_cart_list whcom_row">
			<div class="whcom_col_sm_8 whcom_op_cart_list_main">
				<div class="whcom_op_promo_response">

				</div>

				<div class="whcom_panel whcom_panel_fancy_2 whcom_panel_primary">
					<div class="whcom_panel_header">
						<div class="whcom_row">
							<div class="whcom_col_sm_7">
								<?php esc_html_e( 'Product/Options', 'whcom' ) ?>
							</div>
							<div class="whcom_col_sm_5 whcom_text_right_sm">
								<?php esc_html_e( 'Price/Cycle', 'whcom' ) ?>
							</div>
						</div>
					</div>
					<div class="whcom_panel_body" style="padding: 0 !important; background: white !important;">
						<div class="whcom_op_universal_cart_summary_detailed">
							<div class="whcom_text_center_xs"><i class="whcom_icon_spinner-1 whcom_animate_spin"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="whcom_text_right whcom_op_cart_list_reset_button whcom_margin_bottom_45">
					<?php echo whcom_render_reset_cart(); ?>
				</div>
				<?php $taxes_temp = whcom_get_tax_levels(); ?>
				<?php if ( $taxes_temp['hav_countries'] || empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
					<div class="whcom_tabs_container whcom_tabs_fancy_4">
						<ul class="whcom_tab_links">
							<?php if ( empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
								<li class="whcom_tab_link active" data-tab="apply_promo_form">
									<?php esc_html_e( "Apply Promo Code", "whcom" ) ?>
								</li>
							<?php } ?>
							<?php if ( $taxes_temp['hav_countries'] ) { ?>
								<li class="whcom_tab_link"
								    data-tab="estimate_taxes_form"><?php esc_html_e( "Estimate Taxes", "whcom" ) ?></li>
							<?php } ?>
						</ul>
						<?php if ( empty( get_option( 'whcom_hide_calculate_discount_box', '' ) ) ) { ?>
							<div id="apply_promo_form" class="whcom_tabs_content active">
								<div class="whcom_op_promo_container">
									<?php echo whcom_op_render_promo_form(); ?>
								</div>
							</div>
						<?php } ?>

						<?php if ( $taxes_temp['hav_countries'] ) { ?>
							<div id="estimate_taxes_form" class="whcom_tabs_content">
								<div class="whcom_op_promo_container">
									<?php echo whcom_op_render_estimate_taxes(); ?>
								</div>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="whcom_col_sm_4 whcom_summary_sidebar" style="padding: 0 10px;">
				<div class="whcom_panel">
					<div class="whcom_panel_header">
						<span><?php esc_html_e( 'Order Summary', 'whcom' ) ?></span>
					</div>
					<div class="whcom_op_universal_cart_summary_side whcom_panel_body whcom_text_small">
						<div class="whcom_text_center_xs"><i class="whcom_icon_spinner-1 whcom_animate_spin"></i></div>
					</div>
					<div class="whcom_op_summary_footer whcom_panel_footer whcom_text_right">
						<div class="whcom_op_response">

						</div>
						<div class="whcom_margin_bottom_15">
							<form class="wcop_df_review_form" method="post">
								<input type="hidden" name="checkout" value="1">
								<input type="hidden" name="action" value="wcop_domain_first">
								<input type="hidden" name="wcop_what" value="review">
								<button type="submit"
								        class="whcom_universal_checkout_button whcom_button whcom_button_success whcom_button_big"
								        disabled="disabled"><?php esc_html_e( 'Checkout', 'whcom' ) ?>
									<i class="whcom_icon_right-big"></i></button>
							</form>
						</div>
						<div class="whcom_text_small">
							<?php echo whcom_render_continue_shopping_url(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>






