<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$tld_details         = whcom_get_tld_details( $curr_domain['domain_tld'] );
$tld_register_prices = $tld_transfer_prices = [];
foreach ( $tld_details['register_price'] as $ry => $rp ) {
	$tld_register_prices[] = [
		'duration' => $ry,
		'price'    => $rp,
	];
}
foreach ( $tld_details['transfer_price'] as $ty => $tp ) {
	$tld_transfer_prices[] = [
		'duration' => $ty,
		'price'    => $tp,
	];
}
?>


<div class="wcop_df_domain_config_container">
	<div class="whcom_bg_success whcom_text_white whcom_padding_5_10 whcom_border_success whcom_alert">
		<span>
			<?php echo $curr_domain['domain_name']; ?>
			<?php esc_html_e( 'Configuration', "whcom" ) ?>
		</span>
	</div>
	<input type="hidden" name="cart_indexes[<?php echo $cart_index; ?>]">
	<?php if ( $curr_domain['domain_type'] == 'register' ) { ?>
		<div class="whcom_form_field whcom_form_field_horizontal">
			<label for="wcop_product_domainduration" class="main_label"><?php esc_html_e( 'Domain Duration', "whcom" ); ?></label>
			<select id="wcop_product_domainduration" name="domainduration[<?php echo $cart_index; ?>]">
				<?php
				foreach ( $tld_register_prices as $dur ) {
					$dur_txt = esc_html__( 'For', "whcom" );
					$dur_txt .= ' ' . $dur['duration'] . ' ';
					$dur_txt .= ( $dur['duration'] == 1 ) ? esc_html__( 'Year', "whcom" ) : esc_html__( 'Years', "whcom" );
					$selected = (!empty($curr_domain['item']['regperiod']) && $curr_domain['item']['regperiod'] == $dur['duration']) ? ' selected' : '';
					if ( $dur['price'] < 0 ) {
						continue;
					}
					echo '<option value="' . $dur['duration'] . '" ' . $selected . '>' . whcom_format_amount( [ 'amount' => $dur['price'] ] ) . ' ' . $dur_txt . '</option>';
				}
				?>
			</select>
		</div>
		<?php echo whcom_render_tld_specific_fields( $curr_domain['domain_tld'], $cart_index ); ?>
	<?php } ?>
	<?php if ( $curr_domain['domain_type'] == 'transfer' ) { ?>
		<div class="whcom_form_field whcom_form_field_horizontal">
			<label for="wcop_product_domainduration" class="main_label"><?php esc_html_e( 'Domain Duration', "whcom" ); ?></label>
			<select id="wcop_product_domainduration" name="domainduration[<?php echo $cart_index; ?>]">
				<?php foreach ( $tld_transfer_prices as $dur ) {
					$dur_txt = esc_html__( 'For', "whcom" );
					$dur_txt .= ' ' . $dur['duration'] . ' ';
					$dur_txt .= ( $dur['duration'] == 1 ) ? esc_html__( 'Year', "whcom" ) : esc_html__( 'Years', "whcom" );
					$selected = (!empty($curr_domain['item']['regperiod']) && $curr_domain['item']['regperiod'] == $dur['duration']) ? ' selected' : '';
					if ( $dur['price'] < 0 ) {
						continue;
					}
					echo '<option value="' . $dur['duration'] . '" ' . $selected . '>' . whcom_format_amount( [ 'amount' => $dur['price'] ] ) . ' ' . $dur_txt . '</option>';
				} ?>
			</select>
		</div>
		<div class="wcop_domain_epp">
			<div class="whcom_form_field whcom_form_field_horizontal">
				<label for="inputAuthCode" class="main_label">Authorization Code</label>
				<?php $epp_val = (!empty($curr_domain['item']['eppcode'])) ? $curr_domain['item']['eppcode'] : ''; ?>
				<input type="text" class="form-control" name="eppcode[<?php echo $cart_index; ?>]" id="inputAuthCode" placeholder="Epp Code / Auth Code" required="required" value="<?php echo $epp_val?>">
			</div>
		</div>
	<?php } ?>
	<?php echo whcom_render_tld_specific_addons($curr_domain['domain_tld'], $cart_index, $curr_domain['domain_type'], $curr_domain['item']); ?>
</div>



