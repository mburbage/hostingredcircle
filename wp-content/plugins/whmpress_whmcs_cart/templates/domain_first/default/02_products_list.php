<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$gids         = ( ! empty( $gids ) ) ? $gids : '';
$pids         = ( ! empty( $pids ) ) ? $pids : '';

$gids         = ( ! empty( $_REQUEST['gids'] ) ) ? $_REQUEST['gids'] : $gids;
$pids         = ( ! empty( $_REQUEST['pids'] ) ) ? $_REQUEST['pids'] : $pids;


$cart_index = ( isset( $_REQUEST['cart_index'] ) ) ? (int) esc_attr( $_REQUEST['cart_index'] ) : - 1;
$cart_item  = whcom_get_cart_item( $cart_index )['cart_item'];


$products = [];

$groups = whcom_get_all_products( $gids, $pids );
$groups = ( empty( $groups['groups'] ) ) ? [] : $groups['groups'];

if ( ! empty( $groups ) && is_array( $groups ) ) {
	foreach ( $groups as $group ) {
		if ( ! empty( $group['products'] ) && is_array( $group['products'] ) ) {
			foreach ( $group['products'] as $product ) {
				if ( $product['showdomainoptions'] == "1" ) {
					$products[] = $product;
				}
			}
		}
	}
}

?>


<?php if ( ! empty( $products ) ) { ?>
	<div class="whcom_row">
		<?php foreach ( $products as $product ) {
			$img   = WCOP_URL . '/assets/images/default/prod-' . $product['id'] . '.png';
			$price = $billingcycle = $setup = "";
			if ( ! empty( $product['lowest_price'] ) ) {
				foreach ( $product['lowest_price'] as $b => $prc ) {
					$price        = $prc['price'];
					$setup        = $prc['setup'];
					$billingcycle = $b;
				}
				$icon_class      = ( $cart_item['pid'] == $product['id'] ) ? 'whcom_icon_ok-circled2' : 'whcom_icon_circle-empty';
				$button_type      = ( $cart_item['pid'] == $product['id'] ) ? 'remove' : '';
				$product_checked = ( $cart_item['pid'] == $product['id'] ) ? 'checked' : '';
			}
			else {
				continue;
			}
			?>
			<div class="whcom_col_lg_3 whcom_col_md_4 whcom_col_sm_6 whcom_col_xs_12">
				<div class="wcop_df_product_wrapper whcom_alert whcom_padding_10_0">
					<div class="wcop_df_product whcom_text_center" id="wcop_df_product_whcom_pid_<?php echo $product['id']; ?>">
						<div class="wcop_df_product_icon">
							<i class="<?php echo $icon_class; ?>"></i>
						</div>
						<div class="wcop_df_product_name">
							<strong><?php echo $product["name"] ?></strong>
						</div>
						<div class="whcom_op_product_description">
							<?php echo nl2br( strip_tags( $product["description"] ) ) ?><br>
						</div>
						<div class="whcom_op_product_info whcom_bg_success whcom_text_white">
							<?php echo whcom_render_product_price( $product ); ?>
						</div>
						<div class="wcop_df_product_submit">
							<input
									type="checkbox"
								<?php echo $product_checked; ?>
									id="whcom_pid_<?php echo $product['id']; ?>"
									value="<?php echo $product['id']; ?>"
									name="whcom_product_add_remove"
									style="display: none"
									data-product-id="<?php echo $product['id']; ?>"
									data-product-cart-index="<?php echo $cart_index; ?>"
									data-product-name="<?php echo $product['name']; ?>"
									data-product-currency="<?php echo $product['currency']; ?>"
									data-product-price="<?php echo $price; ?>"
									data-product-setup="<?php echo $setup; ?>"
									data-product-billingcycle="<?php echo $billingcycle; ?>"
							>
							<label for="whcom_pid_<?php echo $product['id']; ?>" class="whcom_button <?php echo ($button_type =='remove') ? 'whcom_button_danger' : ''; ?>">
								<span class="add_text" style="display: <?php echo ($button_type =='remove') ? 'none' : 'block'; ?>">
									<?php esc_html_e( 'Select', "whcom" ) ?>
								</span>
								<span class="remove_text" style="display: <?php echo ($button_type =='remove') ? 'block' : 'none'; ?>">
									<?php esc_html_e( 'Remove', "whcom" ) ?>
								</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
<?php }
else { ?>
	<?php esc_html_e( 'No Products Found', "whcom" ) ?>
<?php } ?>









