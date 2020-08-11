<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$product_id = (!empty($product_id)) ? (int) $product_id : 0;
$page_url = (empty($page_url)) ? home_url( '/' ) : $page_url;

if ( $product_id < 1 ) {
	esc_html_e( 'No valid product_id provided', 'wcap_op' );
	return;
}

$final_array = whcom_get_product_details( $product_id );
if ( ! $final_array ) {
	esc_html_e( 'No valid product_id provided', 'wcap_op' );

	return;
}

if ( ( empty( $billing_cycle ) ) && ( ! empty( $final_array['lowest_price'] ) ) ) {
	reset( $final_array['lowest_price'] );
	$billing_cycle = key( $final_array['lowest_price'] );
}
$free_domain_billingcycles = [];
if ( ! empty ( $final_array['freedomainpaymentterms'] ) ) {
	$free_domain_billingcycles = explode( ',', $final_array['freedomainpaymentterms'] );
}


$gids         = ( ! empty( $gids ) ) ? $gids : '';
$pids         = ( ! empty( $pids ) ) ? $pids : '';


?>
<div id="wcap_op_page_container" class="wcap_op_page_container wcap_op_product_page">
	<?php if ( $final_array['showdomainoptions'] == '1' ) {
		echo whcom_render_domain_form();
	} ?>
	<div class="wcap_op_product_container" <?php echo ( $final_array['showdomainoptions'] == '1' ) ? 'style="display: none;"' : ''; ?>>

		<div class="whcom_page_heading ">
			<?php esc_html_e( 'Configure', 'wcap_op' ) ?>
		</div>
		<div class="whcom_margin_bottom_15">
			<?php esc_html_e( 'Configure your desired options and continue to checkout.', 'wcap_op' ) ?>
		</div>

		<form class="wcap_op_add_product" method="post">
			<div class="whcom_row">
				<div class="whcom_col_sm_8">
					<input type="hidden" name="cart_index" value="-1">
					<input type="hidden" name="pid" value="<?php echo $product_id; ?>">
					<input type="hidden" name="cid" value="<?php echo whcom_get_current_currency_id(); ?>">
					<input type="hidden" name="landing_page" value="<?php echo $page_url ?>">
					<input type="hidden" name="action" value="wcap_op_add_product_to_cart">
					<input type="hidden" name="required_domain" value="no">
					<?php if ( $final_array['showdomainoptions'] == '1' ) { ?>
						<input type="hidden" name="required_domain" value="yes">
					<?php } ?>
					<div class="wcap_op_product_details">
						<div class="wcap_op_product_details_container">
							<div class="wcap_op_product_config_description wcap_op_product_config_block">
								<div>
									<strong><?php echo $final_array['name']; ?></strong>
								</div>
								<?php echo $final_array['description']; ?>
								<?php //$current = '';
								//foreach ( $final_array['description_array'] as $des => $det ) {
								//	echo '<div class="wcap_op_product_feature">';
								//	echo '<div class="wcap_op_product_feature_title">' . $det['feature_title'] . '</div>';
								//	echo '<div class="wcap_op_product_feature_value">' . $det['feature_value'] . '</div>';
								//	echo '</div>';
								//} ?>
							</div>
							<div class="whcom_clearfix"></div>
							<?php if ( $final_array['paytype'] == 'recurring' ) { ?>
								<div class="wcap_op_product_config_block">
									<div class="wcap_op_product_billingcycle whcom_form_field">
										<?php $all_prices = $final_array['all_prices']; ?>
										<?php
										$billing_cycle_class = 'wcap_op_form_control wcap_op_input';
										if ( ! empty( $final_array['prd_configoptions'] ) ) {
											$billing_cycle_class .= ' wcap_op_update_product_options';
										}
										?>
										<label for="wcap_op_product_billingcycle" class="main_label"><?php esc_html_e( 'Choose Billing Cycle', 'wcap_op' ) ?></label>
										<select id="wcap_op_product_billingcycle" name="billingcycle" class="<?php echo $billing_cycle_class ?>">
											<?php $current = '';
											foreach ( $all_prices as $key => $price ) {
												( $billing_cycle == $key ) ? $current = 'selected' : $current = '';
												$option_string = '<option value="' . $key . '" ' . $current . '>';
												$option_string .= whcom_format_amount( [ 'amount' => $price['price'] ] ) . ' ' . $key . ' + ' . whcom_format_amount( [ 'amount' => $price['setup'] ] ) . ' ' . esc_html__( 'Setup Fee', 'wcap_op' );
												if ( in_array( $key, $free_domain_billingcycles ) ) {
													$option_string .= ' (' . esc_html__( 'Free Domain', 'wcap_op' ) . ') ';
												}
												$option_string .= '</option>';
												echo $option_string;
											}
											?>
										</select>
									</div>
								</div>
							<?php } ?>
							<?php if ( $final_array['paytype'] == 'free' ) { ?>
								<input type="hidden" name="billingcycle" value="<?php echo $billing_cycle ?>">
							<?php } ?>
							<?php if ( $final_array['paytype'] == 'onetime' ) { ?>
								<input type="hidden" name="billingcycle" value="<?php echo $billing_cycle ?>">
							<?php } ?>
							<?php if ( $final_array['type'] == 'server' ) { ?>
								<div class="whcom_sub_heading_style_1">
									<span><?php esc_html_e( 'Server Options', 'wcap_op' ) ?></span>
								</div>
								<div class="wcap_op_server_options_container wcap_op_product_config_block">
									<?php echo wcap_op_render_server_specific_fields(); ?>
								</div>
							<?php } ?>
							<?php if ( ! empty( $final_array['prd_configoptions'] ) ) { ?>
								<div class="wcap_op_product_config_block">
									<div class="whcom_sub_heading_style_1">
										<span><?php esc_html_e( 'Configurable Options', 'wcap_op' ) ?></span>
									</div>
									<div class="wcap_op_product_options_container">
										<?php echo wcap_op_render_product_config_options( $final_array, - 1, $billing_cycle ) ?>
									</div>
								</div>
							<?php } ?>
							<?php if ( ! empty( $final_array['custom_fields'] ) && is_array( $final_array['custom_fields'] ) ) { ?>
								<div class="wcap_op_product_config_block">
									<div class="whcom_sub_heading_style_1">
										<span>
											<?php esc_html_e( 'Additional Required Information', 'wcap_op' ) ?>
										</span>
									</div>
									<div class="wcap_op_product_custom_fields_container">
										<?php echo wcap_op_render_product_custom_fields( $final_array ); ?>
									</div>
								</div>
							<?php } ?>
							<?php if ( ! empty( $final_array['prd_addons'] ) && is_array( $final_array['prd_addons'] ) ) { ?>
								<div class="wcap_op_product_config_block">
									<div class="whcom_sub_heading_style_1">
										<span>
											<?php esc_html_e( 'Available Addons', 'wcap_op' ) ?>
										</span>
									</div>
									<?php echo wcap_op_render_product_addons( $final_array ); ?>
								</div>
							<?php } ?>
							<?php if ( $final_array['showdomainoptions'] == '1' ) { ?>
								<div class="whcom_sub_heading_style_1">
									<span>
										<?php esc_html_e( 'Domain Configuration', 'wcap_op' ) ?>
									</span>
								</div>
								<div class="wcap_op_product_config_block">
									<div class="wcap_op_product_domain_config_container">
									</div>
									<div class="wcap_op_free_tlds" style="display: none;">
										<?php if ( ! empty( $final_array['freedomainpaymentterms'] ) && ! empty( $final_array['freedomaintlds'] ) ) { ?>
											<div class="whcom_alert whcom_alert_info">
												<div>
													<?php esc_html_e( 'Free Domain is only available for following TLD\'s', 'wcap_op' ) ?>
												</div>
												<div><strong><?php echo $final_array['freedomaintlds']; ?></strong>
												</div>
											</div>
											<div class="whcom_alert whcom_alert_info">
												<div>
													<?php esc_html_e( 'Free Domain is only available for following billingcycles...', 'wcap_op' ) ?>
												</div>
												<div>
													<strong><?php echo $final_array['freedomainpaymentterms']; ?></strong>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<div class="whcom_col_sm_4">
					<div class="wcap_op_product_summary whcom_panel">
						<div class="whcom_panel_header">
							<?php esc_html_e( 'Order Summary', 'wcap_op' ) ?>
							<span class="whcom_icon_spinner-1 whcom_animate_spin whcom_pull_right"></span>
						</div>
						<div class="whcom_panel_body">
							<div class="whmpress_cart_product_name whcom_text_center">
								<strong><?php echo $final_array['name']; ?></strong>
							</div>
							<div class="wcap_op_summary_sidebar">
							</div>
							<div class="whcom_text_center wcap_op_response">

							</div>
						</div>
						<div class="whcom_panel_footer">
							<div class="wcap_op_product_submit whcom_text_center">
								<button type="submit" class="whcom_button whcom_button_big"><?php esc_html_e( 'Continue', 'wcap_op' ) ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

