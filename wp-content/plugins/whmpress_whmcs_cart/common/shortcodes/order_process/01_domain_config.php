<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$curr_domain = ( empty( $curr_domain ) ) ? [] : $curr_domain;
$cart_index  = ( ! empty( $curr_domain ) && isset( $curr_domain['cart_index'] ) ) ? (int)$curr_domain['cart_index'] : - 1;
?>
<?php if ( ! empty( $curr_domain ) && is_array( $curr_domain ) && ($curr_domain['domain_type'] == 'register' || $curr_domain['domain_type'] == 'transfer') && $cart_index > -1 ) { ?>
	<div class="whcom_sub_heading_style_1">
		<span><?php echo $curr_domain['domain_name']; ?></span>
	</div>
	<div class="whcom_op_domain_config_container">
		<input type="hidden" name="cart_indexes[<?php echo $cart_index; ?>]" value="<?php echo $cart_index; ?>">
		<div class="whcom_row">
			<div class="whcom_col_sm_6">
				<div class="whcom_form_field whcom_form_field_horizontal">
					<label for="whcom_op_product_domainduration" class="main_label"><?php esc_html_e( 'Registration Period', 'whcom' ); ?></label>
					<select id="whcom_op_product_domainduration" name="domainduration[<?php echo $cart_index; ?>]">
						<?php
						foreach ( $tld_register_prices as $dur ) {
							$dur_txt = ' ' . esc_html__( 'For', 'whcom' );
							$dur_txt .= ' ' . $dur['duration'] . ' ';
							$dur_txt .= ( $dur['duration'] == 1 ) ? esc_html__( 'Year', 'whcom' ) : esc_html__( 'Years', 'whcom' );
							if ( $dur['duration'] == $curr_domain['domain_period'] ) {
								$selected = 'selected';
							}
							else {
								$selected = '';
							}
							if ( $dur['price'] < 0 ) {
								continue;
							}
							echo '<option value="' . $dur['duration'] . '" ' . $selected . '>' . whcom_format_amount( [ 'amount' => $dur['price'] ] ) . $dur_txt . '</option>';
							if ( $curr_domain['domain_type'] == 'transfer' ) {
								break;
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="whcom_col_sm_6 whcom_text_small">
				<div>Hosting</div>
				<?php if ( $curr_domain['has_hosting'] ) { ?>
					<div class="whcom_text_success">
						[<?php esc_html_e( "Has Hosting", "whcom" ) ?>]
					</div>
				<?php }
				else { ?>
					<div class="">
						<a href="<?php echo whcom_get_order_url() ?>&dp=yes">
							<span class="whcom_text_danger">[<?php esc_html_e( "No Hosting! Click to Add", "whcom" ) ?>]</span>
						</a>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="whcom_row">
			<?php if ( $curr_domain['domain_type'] == 'transfer' ) { ?>
				<div class="whcom_op_domain_epp whcom_col_sm_6">
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="inputAuthCode" class="main_label">Authorization Code</label>
						<input type="text" class="" name="eppcode[<?php echo $cart_index; ?>]" id="inputAuthCode" placeholder="Epp Code / Auth Code" required="required" value="<?php echo (!empty($curr_domain['cart_item']['eppcode'])) ? (string)$curr_domain['cart_item']['eppcode'] : ''; ?>">
					</div>
				</div>
			<?php } ?>
		</div>
		<?php if ( $curr_domain['domain_type'] == 'register' ) {
			echo whcom_render_tld_specific_fields( $curr_domain['domain_tld'], $cart_index, $curr_domain['cart_item'] );
		} ?>
		<?php echo whcom_render_tld_specific_addons( $curr_domain['domain_tld'], $curr_domain['cart_index'], $curr_domain['domain_type'] ) ?>
	</div>
<?php }


