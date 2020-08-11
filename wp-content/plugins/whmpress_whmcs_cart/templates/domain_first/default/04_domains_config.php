<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$curr_domains = [];
$curr_cart    = whcom_get_cart()['all_items'];
foreach ( $curr_cart as $index => $item ) {
	if ( ! empty( $item['domain'] ) ) {
		$curr_domains[] = [
			'cart_index'  => $index,
			'domain_name' => $item['domain'],
			'domain_type' => $item['domaintype'],
			'domain_tld'  => whcom_get_tld_from_domain( $item['domain'] ),
			'item'  => $item
		];
	}
}


?>

<div class="wcop_df_domain_eligibility_page wcop_df_page">
	<?php if ( empty( $curr_domains ) ) { ?>
		<div class="whcom_alert whcom_alert_warning">
			<span><?php esc_html_e( 'Something went wrong, kindly refresh the page and start over...', "whcom" ) ?></span>
		</div>
	<?php }
	else { ?>
		<div class="wcop_df_page_header_2">
			<?php $page = 'config' ?>
			<?php include_once wcop_get_template_directory('domain_first') . '/templates/domain_first/default/00_top_icons.php'; ?>
		</div>
		<div class="wcop_df_page_heading">
			<i class="whcom_icon_ok-squared whcom_text_success"></i>
			<span><?php esc_html_e( 'Domain Configurations', "whcom" ); ?></span>
		</div>
		<div class="wcop_df_domain_eligibility_container wcop_df_page_content">
			<form class="wcop_df_domains_config_form" method="post">
				<input type="hidden" name="action" value="wcop_domain_first">
				<input type="hidden" name="wcop_what" value="domains_config">
				<?php foreach ( $curr_domains as $cart_index => $curr_domain ) { ?>
					<?php include wcop_get_template_directory('domain_first') . '/templates/domain_first/default/04_domain_config.php'; ?>
				<?php } ?>
				<div class="wcop_df_domains_nameservers_container">
					<?php echo whcom_render_nameservers() ?>
				</div>
				<div class="whcom_form_field whcom_form_field_horizontal whcom_text_center_xs">
					<button type="submit"><?php esc_html_e( 'Continue', "whcom" ) ?></button>
				</div>
			</form>
		</div>
	<?php } ?>
</div>
