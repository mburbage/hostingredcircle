<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$curr_domains = [];
$curr_cart    = whcom_get_cart()['all_items'];
$gids         = ( ! empty( $gids ) ) ? $gids : '';
$pids         = ( ! empty( $pids ) ) ? $pids : '';
foreach ( $curr_cart as $index => $item ) {
	if ( ! empty( $item['domain'] ) ) {
		$curr_domains[] = [
			'cart_index'     => $index,
			'domain_name'    => $item['domain'],
			'domain_product' => $item['pid']
		];
	}
}


?>


<div class="wcop_df_products_page wcop_df_page">
	<div class="wcop_df_page_header_2">
		<?php $page = 'product' ?>
		<?php include_once wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/00_top_icons.php'; ?>
	</div>
	<div class="wcop_df_products_container wcop_df_page_content">
		<div class="wcop_df_products ">
			<div class="wcop_df_products_img_main">
				<?php if ( ! empty( $curr_domains ) ) { ?>
					<div class="wcop_df_domain_selector_container">
						<input type="hidden" name="pids" value="<?php echo $pids; ?>">
						<input type="hidden" name="gids" value="<?php echo $gids; ?>">
						<?php $counter = 0; ?>
						<?php foreach ( $curr_domains as $curr_domain ) {
							$domain_has_product = (!empty($curr_domain['domain_product'])) ? true : false;
							$domain_css_class = ($domain_has_product) ? 'whcom_text_success whcom_border_success' : '';
							?>
							<label class="whcom_alert  <?php echo ($counter == 0) ? 'whcom_bordered_2x' : ''; ?> <?php echo $domain_css_class  ;?>" data-domain-product-text="<?php esc_html_e('No Websites Attached (click here and attach a package from below)', 'whcom') ?>">
								<span class="domain_icon">
									<i class="whcom_icon whcom_icon_ok-circled"></i>
								</span>
								<span class="domain_name">
									<?php echo $curr_domain['domain_name'] ?>
								</span>
								<span class="domain_action">
									<span class="whcom_domain_product" >
										<?php if ($domain_has_product) {
											$product_details = whcom_get_product_details($curr_domain['domain_product']);
											echo $product_details['name'];
										}
										else {
											esc_html_e('No Websites Attached (click here and attach a package from below)', 'whcom');
										}
										?>
									</span>
									<span class="whcom_domain_button whcom_pill whcom_pill_success" style="display:<?php echo ($domain_has_product) ? 'block': 'none'; ?>;">
										<?php esc_html_e('Change', 'whcom')?>
									</span>
								</span>
								<input
										<?php echo ($counter == 0) ? 'checked' : ''; ?>
										name="wcop_df_domain_selector"
										type="radio"
										value="<?php echo $curr_domain['cart_index'] ?>"
										data-cart-index="<?php echo $curr_domain['cart_index'] ?>"
										data-domain-product="<?php echo $curr_domain['domain_product'] ?>"
										data-domain-name="<?php echo $curr_domain['domain_name'] ?>">
							</label>
							<?php $counter++; ?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>

			<div class="wcop_df_select_product_text whcom_margin_bottom_15">
				<i class="whcom_icon_ok-squared whcom_text_success"></i>
				<span class="wcop_df_select_product_domain_text"><?php esc_html_e('Select a product against domain', 'whcom')?></span>
				<strong class="wcop_df_select_product_domain_name whcom_text_success"><?php echo $curr_domains[0]['domain_name'] ?></strong>
			</div>
			<div class="wcop_df_products_wrapper">
				<?php $_REQUEST['cart_index'] = $curr_domains[0]['cart_index'] ?>
				<?php include_once wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/02_products_list.php'; ?>
			</div>

			<div class="wcop_df_products_continue whcom_margin_bottom_15 whcom_text_right">
				<button class="whcom_button whcom_button_success whcom_button_big" id="wcop_df_products_continue">
					<span><?php esc_html_e( 'Continue', "whcom" ) ?></span>
				</button>
			</div>
		</div>
		<div class="whcom_clearfix"></div>
	</div>
</div>







