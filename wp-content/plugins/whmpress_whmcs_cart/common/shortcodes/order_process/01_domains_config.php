<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$curr_domains = [];
$curr_cart    = whcom_get_cart()['all_items'];
$show_ns = false;
foreach ( $curr_cart as $index => $item ) {
	if ( ! empty( $item['domain'] ) && (($item['domaintype'] == 'register') || ($item['domaintype'] == 'transfer')) ) {
		$curr_domains[] = [
			'cart_index'  => $index,
			'domain_name' => $item['domain'],
			'domain_type' => $item['domaintype'],
			'domain_period' => $item['regperiod'],
			'domain_tld'  => whcom_get_tld_from_domain( $item['domain'] ),
			'has_hosting' => (!empty($item['pid']) && (int)$item['pid'] > 0) ? true : false,
			'cart_item' => $item
		];
		if (empty($item['pid'])) {
			$show_ns = true;
		}
	}
}
?>


<?php if ( empty( $curr_domains ) ) { ?>
    <script>
	    var old_url = window.location.href;
	    var new_url = old_url.replace("a=confdomains", "a=view");
	    window.location.href = new_url
    </script>
<?php }
else { ?>
	<div class="whcom_page_heading ">
		<?php esc_html_e( 'Domains Configuration', 'whcom' ) ?>
	</div>
	<div class="whcom_margin_bottom_15">
		<?php esc_html_e( 'Please review your domain name selections and any addons that are available for them.', 'whcom' ) ?>
	</div>
	<div class="whcom_op_domains_config_form_container">
		<form class="whcom_op_domains_config_form" method="post">
			<input type="hidden" name="action" value="whcom_op">
			<input type="hidden" name="whcom_op_what" value="domains_config">
			<?php foreach ( $curr_domains as $cart_index => $curr_domain ) { ?>
				<?php
				$tld_details         = whcom_get_tld_details( $curr_domain['domain_tld'] );
				if (empty($tld_details)) {
					continue;
				}
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
				include WHCOM_PATH . '/shortcodes/order_process/01_domain_config.php';
				?>
			<?php } ?>
			<?php
			if ($show_ns) {
				echo whcom_render_nameservers();
			}
			?>
			<div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
				<button type="submit" class="whcom_op_domains_submit"><?php esc_html_e( 'Continue', 'whcom' ) ?></button>
			</div>
		</form>
	</div>
<?php } ?>
