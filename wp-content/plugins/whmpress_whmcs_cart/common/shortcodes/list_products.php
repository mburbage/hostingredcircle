<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$currency_id = $gids = $pids = $domain_products = '';

extract( shortcode_atts( [
	'currency_id'     => ( isset( $_REQUEST['currency'] ) && is_integer( intval( $_REQUEST['currency'] ) ) ) ? $_REQUEST['currency'] : whcom_get_current_currency_id(),
	'gids'            => '',
	'pids'            => '',
	'domain_products' => (!empty($_REQUEST['dp']) && strtolower($_REQUEST['dp']) == 'yes') ? 'yes' : 'no'
], $atts ) );

$currency_id = whcom_validate_currency_id($currency_id);
whcom_update_current_currency($currency_id);

$groups = whcom_get_all_products( $gids, $pids );
$groups = ( empty( $groups['groups'] ) ) ? [] : $groups['groups'];
if ( empty( $groups ) ) {
	esc_html_e( 'No Groups/Products Found', 'whcom' );
	return;
}


if ( strtolower( $domain_products ) == 'yes' ) {
	foreach ( $groups as $key => $group ) {
		if ( ! empty( $group['products'] ) ) {
			foreach ( $group['products'] as $p_key => $product ) {
				if ( $product['showdomainoptions'] != '1' ) {
					unset( $groups[ $key ]['products'][ $p_key ] );
				}
			}
		}
	}
}


?>

<div class="whcom_op_products whcom_main">
	<div class="whcom_tabs_container whcom_tabs_vertical">
		<div class="whcom_row">
			<div class="whcom_col_sm_3">
				<div class="whcom_panel">
					<div class="whcom_panel_header whcom_has_icon">
						<i class="whcom_icon_basket-1"></i>
						<?php esc_html_e( "Categories", 'whcom' ) ?>
					</div>
					<div class="whcom_panel_body whcom_has_list">

						<ul class="whcom_tab_links whcom_list_fancy whcom_list_tabbed whcom_list_padded whcom_list_bordered">
							<?php
							$active = true;
							foreach ( $groups as $key => $group ) {
								if ( ! empty( $group['products'] ) ) {
									$group_unique_id = 'whcom_products_group_' . $key;
									$active          = ( $active ) ? 'active' : '';
									echo '<li data-tab="' . $group_unique_id . '" class="whcom_tab_link ' . $active . '">' . $group["name"] . '</li>';
									$active = false;
								}
							} ?>
						</ul>
					</div>
				</div>
			</div>
			<div class="whcom_col_sm_9">
				<?php
				$active = true;
				foreach ( $groups as $key => $group ) { ?>
					<?php if ( ! empty( $group['products'] ) ) { ?>
						<?php $group_unique_id = 'whcom_products_group_' . $key; ?>
						<?php $active = ( $active ) ? 'active' : ''; ?>
						<div class="whcom_tabs_content whcom_padding_0_10 <?php echo $active; ?>" id="<?php echo $group_unique_id; ?>">
							<div class="whcom_page_heading"><?php echo $group['name']; ?></div>
							<div class="whcom_op_product_boxes whcom_row">
								<?php foreach ( $group['products'] as $product ) { ?>
									<?php
									$price    = $product['lowest_price'];
									if ( ( empty( $billing_cycle ) ) && ( ! empty( $product['lowest_price'] ) ) ) {
										reset( $product['lowest_price'] );
										$billing_cycle = key( $product['lowest_price'] );
										$price    = $product['lowest_price'][$billing_cycle]['price'];
									}
									$duration = $billing_cycle;
									$price = whcom_format_amount( [ 'amount' => $price ] )
									?>
									<div class="whcom_col_lg_4 whcom_col_md_4 whcom_col_sm_6 whcom_col_xs_12">
										<div class="whcom_op_product_box whcom_panel">
											<div class="whcom_text_center whcom_panel_header">
												<span><?php echo $product["name"] ?></span>
											</div>
											<div class="whcom_panel_body">
												<div class="whcom_op_product_info">
													<?php echo whcom_render_product_price($product); ?>
												</div>
												<div class="whcom_op_product_description">
													<?php echo nl2br( strip_tags( $product["description"] ) ) ?><br>
												</div>
											</div>
											<div class="whcom_panel_footer whcom_text_center_xs">
												<a class="whcom_button whcom_button_success" href="<?php echo whcom_get_order_url(); ?>&a=add&pid=<?php echo $product["id"] ?>">
													<i class="whcom_icon_basket"></i> <?php esc_html_e('Order Now', 'whcom')?>
												</a>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
					<?php $active = false; ?>
				<?php } ?>
			</div>
		</div>
	</div>
</div>





