<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$curr_product = ( ! empty( $product_array ) ) ? $product_array : [];
$tax_settings = whcom_get_whmcs_setting();
$tax_rates    = whcom_get_tax_levels();
$summary_html = [
	'side' => 'Something went wrong',
];

ob_start();
$pid           = ( empty( $curr_product['pid'] ) ) ? 0 : (int) $curr_product['pid'];
$billing_cycle = ( empty( $curr_product['billingcycle'] ) ) ? 'monthly' : (string) $curr_product['billingcycle'];
$product       = whcom_get_product_details( $pid );

$domain_details['is_free'] = false;
$no_options                = true;

?>


<?php if ( $product ) {
	$product_price = $product['all_prices'][ $billing_cycle ]['price'];
	$setup_price   = $product['all_prices'][ $billing_cycle ]['setup'];
	$amount        = [
		'setup'        => 0.00,
		'monthly'      => false,
		'quarterly'    => false,
		'semiannually' => false,
		'annually'     => false,
		'biennially'   => false,
		'triennially'  => false,
		'free_domain'  => false,
		'base_price'   => 0.00,
		'l1_amount'    => 0.00,
		'l2_amount'    => 0.00,
		'final_price'  => 0.00,
	];
	$total_amount  = 0.00;
	if ( $product['type'] == 'server' ) {
		$no_options = false;
	}
	if ( ! empty( $product['prd_addons'] ) && is_array( $product['prd_addons'] ) ) {
		$no_options = false;
	}
	if ( ! empty( $product['custom_fields'] ) && is_array( $product['custom_fields'] ) ) {
		$no_options = false;
	}
	if ( ! empty( $product['prd_configoptions'] ) && is_array( $product['prd_configoptions'] ) ) {
		$no_options = false;
	}
	?>

	<?php ob_start() ?>
	<div class="wcop_product_summary_product  whcom_margin_bottom_10 whcom_bordered_bottom whcom_padding_bottom_5">

		<div class="whcom_clearfix">
			<span class="whcom_pull_left"><?php echo $product['name'] ?></span>
			<span class="whcom_pull_right"><?php echo whcom_format_amount( $product_price ); ?></span>
			<?php
			$amount[ $billing_cycle ] = $product_price;
			?>
		</div>
		<?php if ( $setup_price > 0 ) { ?>
			<div class="whcom_clearfix">
				<span class="whcom_pull_left"><?php esc_html_e( 'Setup Price', 'whcom' ) ?></span>
				<span class="whcom_pull_right"><?php echo whcom_format_amount( $setup_price ); ?></span>
			</div>
		<?php } ?>
		<?php $amount['setup'] = $setup_price; ?>

		<?php if ( ( ! empty( $curr_product['configoptions'] ) ) && ( is_array( $curr_product['configoptions'] ) ) ) { ?>
			<div class="whcom_op_product_summary_configoptions">
				<?php foreach ( $curr_product['configoptions'] as $opt_id => $opt ) {
					$opt_details = $product['prd_configoptions'][ $opt_id ];
					if ( ! empty( $opt_details ) ) { ?>
						<?php switch ( $opt_details['optiontype'] ) {
							case '1' :
								{
									$sub_opt_details = $opt_details['sub_options'][ $opt ];
									$opt_amount      = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$opt_setup       = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									?>
									<div class="whcom_clearfix">
										<span class="whcom_pull_left whcom_padding_0_10">
											<i class="whcom_icon_angle-double-right"></i>
											<?php echo $opt_details['optionname']; ?>:
											<?php echo $sub_opt_details['optionname']; ?></span>
										<span class="whcom_pull_right">
											<?php if ( $opt_amount > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_amount ) ?>
											<?php } ?>
											<?php if ( $opt_amount > 0 && $opt_setup > 0 ) { ?>
												+
											<?php } ?>
											<?php if ( $opt_setup > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_setup ) ?>
												<?php esc_html_e( "Setup Fee", "whcom" ) ?>
											<?php } ?>
										</span>
									</div>
									<?php
									$amount[ $billing_cycle ] = (float) $amount[ $billing_cycle ] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$amount['setup']          = (float) $amount['setup'] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									break;
								}
							case '2' :
								{
									$sub_opt_details = $opt_details['sub_options'][ $opt ];
									$opt_amount      = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$opt_setup       = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									?>
									<div class="whcom_clearfix">
										<span class="whcom_pull_left whcom_padding_0_10">
											<i class="whcom_icon_angle-double-right"></i>
											<?php echo $opt_details['optionname']; ?>:
											<?php echo $sub_opt_details['optionname']; ?></span>
										<span class="whcom_pull_right">
											<?php if ( $opt_amount > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_amount ) ?>
											<?php } ?>
											<?php if ( $opt_amount > 0 && $opt_setup > 0 ) { ?>
												+
											<?php } ?>
											<?php if ( $opt_setup > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_setup ) ?>
												<?php esc_html_e( "Setup Fee", "whcom" ) ?>
											<?php } ?>
										</span>
									</div>
									<?php
									$amount[ $billing_cycle ] = (float) $amount[ $billing_cycle ] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$amount['setup']          = (float) $amount['setup'] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									break;
								}
							case '3' :
								{
									$sub_opt_details = reset( $opt_details['sub_options'] );
									$opt_amount      = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$opt_setup       = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									?>
									<div class="whcom_clearfix">
										<span class="whcom_pull_left whcom_padding_0_10">
											<i class="whcom_icon_angle-double-right"></i>
											<?php echo $opt_details['optionname']; ?>:
											<?php esc_html_e( 'Yes', 'whcom' ) ?>
										</span>
										<span class="whcom_pull_right">
											<?php if ( $opt_amount > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_amount ) ?>
											<?php } ?>
											<?php if ( $opt_amount > 0 && $opt_setup > 0 ) { ?>
												+
											<?php } ?>
											<?php if ( $opt_setup > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_setup ) ?>
												<?php esc_html_e( "Setup Fee", "whcom" ) ?>
											<?php } ?>
										</span>
									</div>
									<?php
									$amount[ $billing_cycle ] = (float) $amount[ $billing_cycle ] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'];
									$amount['setup']          = (float) $amount['setup'] + (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'];
									break;
								}
							case '4' :
								{
									$sub_opt_details = reset( $opt_details['sub_options'] );
									$opt_amount      = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['price'] * (float) $opt;
									$opt_setup       = (float) $sub_opt_details['all_prices'][ $billing_cycle ]['setup'] * (float) $opt;
									?>
									<div class="whcom_clearfix">
										<span class="whcom_pull_left whcom_padding_0_10">
											<i class="whcom_icon_angle-double-right"></i>
											<?php echo $opt_details['optionname']; ?>:
											<?php echo $opt; ?>
										</span>
										<span class="whcom_pull_right">
											<?php if ( $opt_amount > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_amount ) ?>
											<?php } ?>
											<?php if ( $opt_amount > 0 && $opt_setup > 0 ) { ?>
												+
											<?php } ?>
											<?php if ( $opt_setup > 0 ) { ?>
												<?php echo whcom_format_amount( $opt_setup ) ?>
												<?php esc_html_e( "Setup Fee", "whcom" ) ?>
											<?php } ?>
										</span>
									</div>
									<?php
									$amount[ $billing_cycle ] = (float) $amount[ $billing_cycle ] + (float) $opt_amount;
									$amount['setup']          = (float) $amount['setup'] + (float) $opt_setup;
									break;
								}
						} ?>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
		<?php
		$product_price = $amount[ $billing_cycle ];
		$product_setup = $amount['setup'];

		$product_total = $product_price + $product_setup;
		if ( ! empty( $product['tax'] ) && $product['tax'] == '1' ) {
			$product_total         = whcom_calculate_tax( $product_total, $tax_settings );
			$amount['base_price']  = $amount['base_price'] + $product_total['base_price'];
			$amount['l1_amount']   = $amount['l1_amount'] + $product_total['l1_amount'];
			$amount['l2_amount']   = $amount['l2_amount'] + $product_total['l2_amount'];
			$amount['final_price'] = $amount['final_price'] + $product_total['final_price'];
		}
		else {
			$amount['base_price']  = $amount['base_price'] + $product_total;
			$amount['final_price'] = $amount['final_price'] + $product_total;
		} ?>

		<?php if ( ( ! empty( $curr_product['addons'] ) ) && ( is_array( $curr_product['addons'] ) ) ) { ?>
			<div class="whcom_op_product_summary_addons">
				<?php foreach ( $curr_product['addons'] as $adn ) {
					$curr_addon = $product['prd_addons'][ $adn ];
					// Addon price logic
					$addon_billingcycle = strtolower( $curr_addon['billingcycle'] );
					if ( $addon_billingcycle == 'recurring' ) {
						if ( ! empty( $curr_addon['all_prices'][ $curr_product['billingcycle'] ] ) ) {
							$addon_billingcycle = $curr_product['billingcycle'];
							$curr_addon_price   = $curr_addon['all_prices'][ $addon_billingcycle ]['price'];
							$curr_addon_setup   = $curr_addon['all_prices'][ $addon_billingcycle ]['setup'];
						}
						else {
							reset( $curr_addon['lowest_price'] );
							$addon_billingcycle = key( $curr_addon['lowest_price'] );
							$curr_addon_price   = $curr_addon['lowest_price'][ $addon_billingcycle ]['price'];
							$curr_addon_setup   = $curr_addon['lowest_price'][ $addon_billingcycle ]['setup'];
						}
					}
					elseif ( $addon_billingcycle == 'free' ) {
						$curr_addon_price = 0.00;
						$curr_addon_setup = 0.00;
					}
					else {
						$curr_addon_price = $curr_addon['monthly'];
						$curr_addon_setup = $curr_addon['msetupfee'];
					}

					$amount[ $addon_billingcycle ] = $amount[ $addon_billingcycle ] + $curr_addon_price;
					$amount['setup']               = $amount['setup'] + $curr_addon_setup;
					if ( ! empty( $curr_addon ) ) { ?>
						<div class="whcom_clearfix">
							<span class="whcom_pull_left whcom_padding_0_10">+ <?php echo $curr_addon['name']; ?></span>
							<span class="whcom_pull_right">
								<?php echo whcom_format_amount( $curr_addon_price ) ?>
							</span>

						</div>
						<?php
						?>

						<?php
						$curr_addon_total = $curr_addon_price + $curr_addon_setup;
						if ( ! empty( $curr_addon['tax'] ) && $curr_addon['tax'] == '1' ) {
							$curr_addon_total      = whcom_calculate_tax( $curr_addon_total, $tax_settings );
							$amount['base_price']  = $amount['base_price'] + $curr_addon_total['base_price'];
							$amount['l1_amount']   = $amount['l1_amount'] + $curr_addon_total['l1_amount'];
							$amount['l2_amount']   = $amount['l2_amount'] + $curr_addon_total['l2_amount'];
							$amount['final_price'] = $amount['final_price'] + $curr_addon_total['final_price'];
						}
						else {
							$amount['base_price']  = $amount['base_price'] + $curr_addon_total;
							$amount['final_price'] = $amount['final_price'] + $curr_addon_total;
						}
						?>
					<?php } ?>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php if ( ! empty( $curr_product['domain'] ) ) {
		$domain_type    = ( $curr_product['domaintype'] == 'transfer' ) ? 'transfer' : 'register';
		$domain_details = whcom_op_get_current_domain_details( $curr_product['domain'], $domain_type, $curr_product['regperiod'], $product, $billing_cycle );
		?>
		<div class="whcom_clearfix">
			<strong class="whcom_pull_left"><?php echo $curr_product['domain'] ?></strong>
			<span class="whcom_pull_right"><?php echo whcom_format_amount( $domain_details['domain_price'] ); ?></span>
			<?php
			$total_amount = $total_amount + (float) $domain_details['domain_price'];
			?>
		</div>
		<div class="whcom_clearfix">
			<span class="whcom_pull_left"><?php echo $domain_details['domain_type']; ?></span>
			<span class="whcom_pull_right"><?php echo $domain_details['domain_duration'] ?></span>
		</div>
		<?php $no_options = false; ?>
	<?php } ?>
	<?php $details_html = ob_get_clean(); ?>

	<?php ob_start() ?>
	<div class="whcom_op_product_summary_totals whcom_margin_bottom_10 whcom_bordered_bottom whcom_padding_bottom_5">
		<?php foreach ( $amount as $key => $amt ) { ?>
			<?php if ( $amt || ( $key == 'setup' ) ) {
				$total_amount = $total_amount + $amt;
				if ( $key == 'onetime' ) {
					continue;
				}
				?>
				<div class="whcom_clearfix <?php echo $key; ?> <?php echo ( ( $key != 'setup' ) ) ? 'price' : ''; ?> <?php echo ( ( $amt <= 0 ) ) ? 'free' : ''; ?>">
					<span class="whcom_pull_left"><?php echo whcom_convert_billingcycle( $key ); ?></span>
					<span class="whcom_pull_right"><?php echo whcom_format_amount( [
							'amount'     => $amt,
							'add_suffix' => 'yes'
						] ); ?></span>
				</div>
			<?php } ?>
		<?php } ?>
		<?php if ( $amount['l1_amount'] > 0 ) { ?>
			<div class="whcom_clearfix">
				<span class="whcom_pull_left"><?php echo $tax_rates['level1_title'] ?>
					&#64; <?php echo $tax_rates['level1_rate'] ?>&#37;</span>
				<span class="whcom_pull_right"><?php echo whcom_format_amount( $amount['l1_amount'] ); ?></span>
			</div>
		<?php } ?>
		<?php if ( $amount['l2_amount'] > 0 ) { ?>
			<div class="whcom_clearfix">
				<span class="whcom_pull_left"><?php echo $tax_rates['level2_title'] ?>
					&#64; <?php echo $tax_rates['level2_rate'] ?>&#37;</span>
				<span class="whcom_pull_right"><?php echo whcom_format_amount( $amount['l2_amount'] ); ?></span>
			</div>
		<?php } ?>
	</div>
	<div class="whcom_op_product_summary_grand_total">
		<div class="whcom_clearfix whcom_text_2x">
			<span class="whcom_pull_right"><?php echo whcom_format_amount( [
					'amount'     => $amount['final_price'],
					'add_suffix' => 'yes'
				] ); ?></span>
		</div>
		<div class="whcom_clearfix">
			<span class="whcom_pull_right"><?php esc_html_e( 'Total Due Today', 'whcom' ) ?></span>
		</div>
	</div>
	<?php $amount_html = ob_get_clean(); ?>


<?php } ?>

<?php
$summary_html = [
	'side'        => '<div class="whcom_sticky_item whcom_text_small">' . $details_html . $amount_html . '</div>',
	'free_domain' => $domain_details['is_free'],
	'no_options'  => $no_options,
	'details_html'  => $details_html,
	'totals_html'  => $amount_html,
	'totals_array'      => $amount,
];




