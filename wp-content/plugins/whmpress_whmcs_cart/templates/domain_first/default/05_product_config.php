<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$random = '_' . rand( 11111, 99999 );

?>


<div class="wcop_df_order_config_form_section">
	<div class="wcop_df_order_config_product">
		<div class="wcop_product_details_container">
			<div class="wcop_df_product_description whcom_alert whcom_bg_gray_light whcom_padding_10">
				<div class="whcom_text_success whcom_margin_bottom_10">
					<?php if ( ! empty( $curr_product['item']['domain'] ) ) { ?>
						<strong><?php echo $curr_product['item']['domain'] ?></strong>
					<?php } ?>
				</div>
				<div class="whcom_bg_white whcom_bordered whcom_border_success whcom_margin_bottom_0 whcom_alert">
					<div class="">
						<input type="hidden"
						       name="pid[<?php echo $cart_index; ?>]"
						       value="<?php echo $curr_product['item']['pid']; ?>">
						<div class="whcom_text_2x">
							<span><?php echo $product['name'] ?></span>
						</div>
<!--						--><?php //$current = '';
//						foreach ( $product['description_array'] as $des => $det ) {
//							echo '<div class="wcop_product_feature">';
//							echo '<span class="wcop_product_feature_title">' . $det['feature_title'] . '</span>';
//							echo '<span class="wcop_product_feature_value">' . $det['feature_value'] . '</span>';
//							echo '</div>';
//						} ?>
                        <div class="whcom_clearfix"></div>
                        <?php if ( $product['paytype'] == 'recurring' ) { ?>
                            <div class="wcop_product_config_main">
                                <div class="wcop_product_billingcycle whcom_form_field whcom_form_field_horizontal">
                                    <?php $all_prices = $product['all_prices']; ?>
                                    <label for="wcop_product_billingcycle"
                                           class="main_label"><?php echo esc_html__( 'Choose Billing Cycle', "whcom" ) . ": " ?></label>
                                    <div class="whcom_checkbox_container whcom_fancy_select_1">
                                        <select title="<?php esc_html_e('', 'Choose Billing Cycle')?>" name="billingcycle[<?php echo $cart_index; ?>]"
                                                class="wcop_form_control wcop_billingcycle_selector"
                                                data-product-id="<?php echo $product['id'] ?>"
                                                data-cart-index="<?php echo $cart_index ?>">
                                            <?php $current = '';
                                            foreach ( $all_prices as $key => $price ) {
                                                ( $billing_cycle == $key ) ? $current = 'selected' : $current = '';
                                                $option_string       = '<option value="' . $key . '" ' . $current . ' data-billingcycle="' . $key . '">';
                                                $option_string       .= whcom_format_amount( $price['price'] ) . ' ' . whcom_convert_billingcycle( $key ) . ' + ' . whcom_format_amount( [ 'amount' => $price['setup'] ] ) . ' ' . esc_html__( 'Setup Fee', "whcom" );
                                                $free_domain_options = explode( ',', $product['freedomainpaymentterms'] );
                                                if ( in_array( $key, $free_domain_options ) ) {
                                                    $option_string .= ' (' . esc_html__( 'Free Domain', "whcom" ) . ') ';
                                                }
                                                $option_string .= '</option>';
                                                echo $option_string;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php }
                        else { ?>
                            <input type="hidden"
                                   name="billingcycle[<?php echo $cart_index; ?>]"
                                   value="<?php echo $product['paytype']; ?>">
                        <?php } ?>
					</div>
				</div>


			</div>


			<!--Server Specific Fields-->
			<?php if ( $product['type'] == 'server' ) { ?>
				<div class="whcom_bg_success whcom_text_white whcom_padding_5_10 whcom_border_success whcom_alert">
					<span><?php esc_html_e('Configure Server', 'whcom')?></span>
				</div>
				<?php echo whcom_render_server_specific_fields( $cart_index ); ?>
			<?php } ?>
			<!--Product Config Options-->
			<?php if ( ! empty( $product['prd_configoptions'] ) ) { ?>
				<div class="whcom_bg_success whcom_text_white whcom_padding_5_10 whcom_border_success whcom_alert">
					<span><?php esc_html_e('Configurable Options', 'whcom')?></span>
				</div>
				<div id="wcop_df_product_options_<?php echo $cart_index; ?>">
					<?php echo whcom_render_product_config_options( $product, $cart_index, $billingcycle ) ?>
				</div>
			<?php } ?>
			<!--Product Custom Fields-->
			<?php if ( ! empty( $product['custom_fields'] ) && is_array( $product['custom_fields'] ) ) { ?>
				<div class="whcom_bg_success whcom_text_white whcom_padding_5_10 whcom_border_success whcom_alert">
					<span><?php esc_html_e('Additional Required Information', 'whcom')?></span>
				</div>
				<?php echo whcom_render_product_custom_fields( $product, $cart_index ) ?>
			<?php } ?>
			<!--Product Addons-->
			<?php if ( ! empty( $product['prd_addons'] ) && is_array( $product['prd_addons'] ) ) { ?>
				<div class="whcom_bg_success whcom_text_white whcom_padding_5_10 whcom_border_success whcom_alert">
					<span><?php esc_html_e('Available Addons', 'whcom')?></span>
				</div>
				<?php echo whcom_render_product_addons( $product, $cart_index ) ?>
			<?php } ?>
		</div>
	</div>
</div>






