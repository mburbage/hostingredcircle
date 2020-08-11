<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "addons", true );

//show front menu where applicable
if ( wcap_show_front_menu() ) {
	include_once $this->Path . "/views/top_links_front.php";
}


$upgrade         = false;
$upgrade_options = false;

$service_id = $_POST["id"];

$product = wcap_get_client_products( [
	"serviceid" => $service_id,
] );

if ( ! isset( $product["products"]["product"][0] ) ) {
	echo __( "No service found", "whcom" );
}
else {
	$product = $product["products"]["product"][0];

	$product_id = $product["pid"];

## Check if producting is pending
	$is_pending = ( $product["status"] == "Pending" ) ? true : false;

## Getting upgrade-able products from database.
	$pids    = wcap_get_upgradable_products( "pid=" . $product_id );
	$upgrade = ( ! ( empty( $pids ) ) ) ? true : false;

## Check if options are upgradeable
	$upgrade_options = wcap_get_upgrade_options_status( $product_id );

}


$title = ( $product["domain"] == "" ) ? "Client Area" : $product["domain"];

//check if the service is in cancellation
$response = wcap_get_cancellation_status( $service_id );


$in_cancellation = ( $response["status"] == "OK" ) ? $response["data"] : "";

$product_details = whcom_get_product_details( $product['pid'] );

?>

<div class="wcap_knowledgebase ">
	<div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
			<div class="whcom_col_sm_3">
				<?php //side bar content ?>
				<div class="whcom_panel">
					<div class="whcom_panel_header whcom_has_icon">
						<i class="whcom_icon_star-1"></i> <?php esc_html_e( 'Overview', "whcom" ) ?>
					</div>
					<div class="whcom_list_wcap_style_2">
						<ul class="whcom_list_bordered whcom_has_icons whcom_has_links">
							<li>
								<a class="wcap_load_page" data-page="productdetails"
								   href="id=<?php echo $product["id"] ?>"><?php esc_html_e( 'Information', "whcom" ) ?></a>

							</li>
							<li>
								<a class="wcap_load_page" data-page="addons"
								   href="#"><?php esc_html_e( 'Addons', "whcom" ) ?></a>
							</li>
						</ul>
					</div>
				</div>
				<div class="whcom_panel">
					<div class="whcom_panel_header whcom_has_icon">
						<i class="whcom_icon_wrench whcom_has_icon"></i> <?php esc_html_e( 'Actions', "whcom" ) ?>
					</div>
					<div class="whcom_panel_body whcom_has_list">
						<ul class="whcom_list_wcap_style_1">
							<li>
								<a class="wcap_load_page" data-page="services"
								   href=""><?php esc_html_e( 'My Services', "whcom" ) ?></a>
							</li>
							<li>
								<a class="wcap_load_page" data-page="order_new_service"
								   href="#"><?php esc_html_e( 'Order New Services', "whcom" ) ?></a>
							</li>
							<?php if ( $upgrade ) { ?>
								<li>
									<a class="wcap_load_page" data-page="updowngrade"
									   href="id=<?php echo $product["id"] ?>"><?php esc_html_e( 'Upgrade/Downgrade', "whcom" ) ?></a>
								</li>
							<?php } ?>

							<?php if ( $upgrade_options ) { ?>
								<li>
									<a class="wcap_load_page" data-page="updowngrade"
									   href="type=configoptions&upoptions_id=<?php echo $product["id"] ?>"><?php esc_html_e( 'Upgrade/Downgrade Options', "whcom" ) ?></a>
								</li>
							<?php } ?>

							<li class="<?php ( $in_cancellation ) ? " whcom_disable" : "" ?>">
								<a class="wcap_load_page " data-page="request_cancel"
								   href="id=<?php echo $_POST["id"] ?>"
								   href="id=<?php echo $product["id"] ?>"><?php esc_html_e( 'Request Cancellation', "whcom" ) ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<div class="whcom_page_heading">
				<span><?php echo $title ?></span>
			</div>

			<?php //main content ?>
			<div class="whcom_margin_bottom_15">
				<div class="wcap_services_detail">
					<?php if ( $in_cancellation ) { ?>
						<!-- Message if service is in cacellation -->
						<div class="whcom_alert whcom_alert_danger whcom_text_center">
							<?php esc_html_e( "There is an outstanding cancellation request for this product/service", "whcom" ) ?>
						</div>
					<?php } ?>

					<?php if ( $is_pending ) { ?>
						<!-- Message if service is in cacellation -->
						<div class="whcom_alert whcom_alert_danger whcom_text_center">
							<div class="whcom_padding_5_10"><?php esc_html_e( "This hosting package is currently Pending.", "whcom" ) ?></div>
							<div><?php esc_html_e( "You cannot begin using this hosting account until it is activated.", "whcom" ) ?></div>
						</div>
					<?php } ?>


					<?php if ( strtolower( $product_details['servertype'] ) == 'cpanel' ) { ?>
						<div class="whcom_row">
							<div class="whcom_col_sm_6">
								<div class="whcom_panel">
									<div class="whcom_panel_header">
										<?php esc_html_e( 'Package/Domain', "whcom" ) ?>
									</div>
									<div class="whcom_panel_body">
										<div class="whcom_margin_bottom_15 whcom_text_center">
											<div>
												<small><?php echo $product["translated_groupname"] ?></small>
												<div class="text_large"><?php echo $product["translated_name"] ?></div>

												<div class="whcom_margin_bottom_15">
													<?php if ( ! trim( $product["domain"] ) == "" ) { ?>
														<a target="_blank"
														   href="http://www.<?php echo $product["domain"] ?>">www.<?php echo $product["domain"] ?>
														</a>
														<?php
													}
													?>

												</div>
											</div>
											<div class="wcap_service_dialog_links whcom_margin_bottom_15">
												<div id="whois_container_<?php echo $product['pid']; ?>" style="display:none;">
													<div class="wcap_whois_popup">
														<?php echo wcap_generate_whois_content($product["domain"]); ?>
													</div>
												</div>
												<a target="_blank" href="http://www.<?php echo $product["domain"] ?>">
													<button class="whcom_button_secondary"><?php esc_html_e( "Visit Website", "whcom" ) ?></button>
												</a>
												<a href="#TB_inline?width=900&height=550&inlineId=whois_container_<?php echo $product['pid']; ?>" class="thickbox whcom_button">
													<?php esc_html_e( "WHOIS Info", "whcom" ) ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="whcom_col_sm_6">
								<div class="whcom_panel">
									<div class="whcom_panel_header">

										<?php esc_html_e( 'Addons & Extras', "whcom" ) ?>
									</div>
									<div class="whcom_panel_body">

										<?php


										// lets get products from other method
										$response = wcap_get_all_products_x();
										if ( $response["status"] == "OK" ) {
											$products_x = $response["data"];
										}
//										$products_list = wcap_products_simple_list( $products_x );
										$tmp           = wcap_product_addons( $products_list, $product["pid"] );
										?>
										<form method="post" class="whcom_op_order_addon">
											<input type="hidden" name="action" value="whcom_op">
											<input type="hidden" name="whcom_op_what" value="order_addon">
											<input type="hidden" name="serviceids" value="<?php echo $service_id; ?>">


											<div class="whcom_row">
												<div class="whcom_col_sm_12">
													<div class="whcom_op_response"></div>
												</div>
												<div class="whcom_col_sm_6 whcom_form_field">
													<select name="addonids" title="Select Addon">
														<?php foreach ( $tmp as $addon ) { ?>
															<option value="<?php echo $addon["id"] ?>">
																<?php echo $addon["name"] ?></option>
														<?php } ?>
													</select>
												</div>
												<div class="whcom_col_sm_6">
													<button class="whcom_button whcom_button_secondary data">
														<?php esc_html_e( "Purchase & Activate", "whcom" ); ?>
													</button>
												</div>
											</div>

										</form>
									</div>
								</div>
								<div class="whcom_panel">
									<div class="whcom_panel_header">
										<?php esc_html_e( 'Upgrade/Downgrade', "whcom" ) ?>
									</div>
									<div class="whcom_panel_body">
										<a href="id=<?php echo $product["id"] ?>" class="wcap_load_page"
										   data-page="updowngrade"><?php esc_html_e( "Upgrade/Downgrade", "whcom" ) ?></a>
									</div>
								</div>
							</div>
						</div>
						<!--/detail row end-->
						<div class="whcom_panel">
							<div class="whcom_panel_header">
								<?php esc_html_e( 'Billing Overview', "whcom" ) ?>
							</div>
							<div class="whcom_panel_body">
								<div class="whcom_row">
									<div class="whcom_col_sm_6">
										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'First Payment Amount', "whcom" ) ?>

												</div>
												<div class="whcom_col_sm_6">
													<?php echo whcom_format_amount( $product["firstpaymentamount"] ) ?>
												</div>
											</div>
										</div>

										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'Recurring Amount', "whcom" ) ?>

												</div>
												<div class="whcom_col_sm_6">
													<?php echo whcom_format_amount( $product["recurringamount"] ) ?>
												</div>
											</div>
										</div>

										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'Billing Cycle', "whcom" ) ?>

												</div>
												<div class="whcom_col_sm_6">
													<?php echo whcom_convert_billingcycle( $product["billingcycle"] ) ?>
												</div>
											</div>
										</div>

										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'Payment Method', "whcom" ) ?>

												</div>
												<div class="whcom_col_sm_6">
													<?php echo $product["paymentmethodname"] ?>
												</div>
											</div>
										</div>

									</div>
									<div class="whcom_col_sm_6">
										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'Next due date', "whcom" ) ?>
												</div>
												<div class="whcom_col_sm_6">
													<?php echo $product["nextduedate"] ?>
												</div>
											</div>
										</div>

										<div class="wcap_package_price whcom_margin_bottom_15">
											<div class="whcom_row">
												<div class="whcom_col_sm_6">
													<?php esc_html_e( 'Registration Date', "whcom" ) ?>
												</div>
												<div class="whcom_col_sm_6">
													<?php echo $product["regdate"] ?>
												</div>
											</div>
										</div>


										<div class="wcap_package_registration_date whcom_margin_bottom_15">

										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="whcom_row">
							<?php if ( is_array( $product['configoptions']['configoption'] ) && ! empty( $product['configoptions']['configoption'] ) ) { ?>
								<div class="whcom_col_sm_12">
									<div class="whcom_panel">
										<div class="whcom_panel_header">
											<?php esc_html_e( 'Configurable Options', "whcom" ) ?>
										</div>
										<div class="whcom_panel_body">
											<?php foreach ( $product['configoptions']['configoption'] as $option ) { ?>
												<div class="whcom_row">
													<div class="whcom_col_sm_6 whcom_text_right whcom_text_bold">
														<?php echo $option['option']; ?>
													</div>
													<div class="whcom_col_sm_6 whcom_text_left">
														<?php
														if ( $option["type"] == "yesno" ) {
															echo wcap_yesno( $option["value"] );
														}
														else {
															echo $option["value"];
														}
														?>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
						<div class="whcom_row">
							<?php if ( is_array( $product['customfields']['customfield'] ) && ! empty( $product['customfields']['customfield'] ) ) { ?>
								<div class="whcom_col_sm_12">
									<div class="whcom_panel">
										<div class="whcom_panel_header">
											<?php esc_html_e( 'Additional Information', "whcom" ) ?>
										</div>
										<div class="whcom_panel_body">
											<div class="wcap_package_next_due_date whcom_margin_bottom_15">
												<?php foreach ( $product['customfields']['customfield'] as $customfield ) { ?>
													<div class="whcom_row">
														<div class="whcom_col_sm_6 whcom_text_right whcom_text_bold">
															<?php echo $customfield['name']; ?>
														</div>
														<div class="whcom_col_sm_6 whcom_text_left">
															<?php

															if ( trim( $customfield["value"] ) == "" ) {
																_e( "(no value)", "whcom" );
															}
															else {
																echo $customfield["value"];
															}
															?>
														</div>
													</div>
												<?php } ?>
											</div>

										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php }
					else { ?>
						<div class="whcom_row whcom_text_center wcap-service">
							<div class="whcom_col_sm_6">
								<div class="wcap-service-box <?php echo ( $product['status'] == 'Active' ) ? 'whcom_bg_success' : 'whcom_bg_warning'; ?>">
									<div class="whcom_text_center wcap-service-text">
										<div class="wcap-service-icon">
											<i class="whcom_icon_hdd"></i>
										</div>
										<div class="whcom_text_large"><?php echo $product["translated_name"] ?></div>
										<div class=""><?php echo $product["translated_groupname"] ?></div>
									</div>
									<div class="wcap-service-status-text">
										<?php echo $product["status"] ?>
									</div>
								</div>
								<?php if ($product['status'] == 'Active') { ?>
									<div class="">
										<?php if ( $in_cancellation ) { ?>
											<span class="disabled whcom_button whcom_button_danger whcom_button_block" data-page="request_cancel">
												<?php esc_html_e( 'Cancellation Requested', "whcom" ) ?>
											</span>
										<?php }
										else { ?>
											<a class="wcap_load_page whcom_button whcom_button_danger whcom_button_block" data-page="request_cancel"
											   href="id=<?php echo $_POST["id"] ?>"
											   href="id=<?php echo $product["id"] ?>">
												<?php esc_html_e( 'Request Cancellation', "whcom" )  ?>
											</a>
										<?php } ?>

									</div>
								<?php } ?>
							</div>
							<div class="whcom_col_sm_6">
								<div class="wcap-service-details">
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'Registration Date', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo $product["regdate"] ?></small>
										</div>
									</div>
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'First Payment Amount', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo whcom_format_amount( $product["firstpaymentamount"] ) ?></small>
										</div>
									</div>
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'Recurring Amount', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo whcom_format_amount( $product["recurringamount"] ) ?></small>
										</div>
									</div>
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'Billing Cycle', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo whcom_convert_billingcycle( $product["billingcycle"] ) ?></small>
										</div>
									</div>
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'Next due date', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo $product["nextduedate"] ?></small>
										</div>
									</div>
									<div class="whcom_margin_bottom_15">
										<div>
											<strong><?php esc_html_e( 'Payment Method', "whcom" ) ?></strong>
										</div>
										<div>
											<small><?php echo $product["paymentmethodname"] ?></small>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

				</div>

			</div>
		</div>
	</div>
</div>



