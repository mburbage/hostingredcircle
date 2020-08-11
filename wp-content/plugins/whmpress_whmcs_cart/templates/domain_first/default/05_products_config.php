<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$curr_products = [];
$curr_cart     = whcom_get_cart()['all_items'];
foreach ( $curr_cart as $index => $item ) {
	if ( ! empty( $item['pid'] ) ) {
		$curr_products[] = [
			'cart_index' => $index,
			'item'       => $item,
		];
	}
} ?>

<div class="wcop_df_order_config_page wcop_df_page">
	<div class="wcop_df_page_heading">
		<?php $page = 'config' ?>
		<?php include_once wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/00_top_icons.php'; ?>
	</div>
	<div class="wcop_df_order_config_container wcop_df_page_content">
		<div class="wcop_df_page_heading">
			<i class="whcom_icon_ok-squared whcom_text_success"></i>
			<span><?php esc_html_e( 'Additional Services Configurations', "whcom" ); ?></span>
			<div class="whcom_text_success whcom_text_small">
				<strong><?php esc_html_e( 'Configure your desired options and continue ot checkout', 'whcom' ) ?></strong>
			</div>
		</div>
		<div class="wcop_df_order_config_form_container">
			<form class="wcop_df_products_config_form" method="post">
				<input type="hidden" name="action" value="wcop_domain_first">
				<input type="hidden" name="wcop_what" value="products_config">
				<div class="whcom_row">
					<div class="whcom_col_sm_8">
						<?php foreach ( $curr_products as $index => $curr_product ) {

							$product      = whcom_get_product_details( $curr_product['item']['pid'] );
							$cart_index   = $curr_product['cart_index'];
							$billingcycle = $billing_cycle = $curr_product['item']['billingcycle'];
							if ( $product ) { ?>
								<?php include wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/05_product_config.php'; ?>
							<?php }
							else {
								esc_html_e( 'Something went wrong...', "whcom" );
							}
						} ?>
					</div>
					<div class="whcom_col_sm_4 whcom_sticky_item whcom_padding_0_10">
						<div class="wcop_df_product_summary whcom_panel">
							<div class="whcom_panel_header">
								<?php esc_html_e( 'Additional Services Summary', 'whcom' ) ?>
								<span class="whcom_icon_spinner-1 whcom_animate_spin whcom_pull_right"></span>
							</div>
							<div class="whcom_panel_body">
								<div class="wcop_df_summary_sidebar">
								</div>
								<div class="whcom_text_center wcop_df_response">
								</div>
							</div>
							<div class="whcom_panel_footer">
								<div class="wcop_df_product_submit whcom_text_center">
									<button type="submit" class="whcom_button whcom_button_big"><?php esc_html_e( 'Continue', 'whcom' ) ?></button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>











