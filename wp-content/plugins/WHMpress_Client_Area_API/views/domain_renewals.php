<?php
//page initialization, veriables for whole page
$show_sidebar = wcap_show_side_bar( "domain_renewals" );

$currencies = whcom_get_current_currency();
$domains    = wcap_get_client_domains( [
	"clientid" => whcom_get_current_client_id(),
	"limitnum" => "999",
] );
$domains    = $domains["domains"]["domain"];

//keep only active domains here
if ( ! isset( $domains[0] ) ) {
	//echo "<div class='error'>" . esc_html_( "Domain detail not found" ) . "</div>";
} else {
	// unset all inactive domains
	foreach ( $domains as $index => $domain ) {
		if ( $domain["status"] != "Active" ) {
			unset( $domains[ $index ] );
		}
	}
}

?>

<div class="wcap_services ">
	<div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
			<div class="whcom_col_sm_3">
				<?php //side bar content ?>
				<?php
				wcap_render_categories_panel();
				wcap_render_domains_panel_action();
				?>

			</div>
		<?php } ?>
		<div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<div class="whcom_page_heading">
				<?php _e( "Domains Renew", "whcom" ) ?>
			</div>

			<?php //main content ?>
			<div class="whcom_margin_bottom_15">
				<form method="post" class="whcom_op_domain_renewals">
					<input type="hidden" name="action" value="whcom_op">
					<input type="hidden" name="whcom_op_what" value="domain_renewals">
					<!--input type="hidden" name="type" value="addon"-->

					<div class="whcom_margin_bottom_30">
						<ul class="whcom_list_stripped whcom_list_padded">

							<li>
								<div class="whcom_row">
									<div class="whcom_col_sm_5">
										<strong><?php esc_html_e( "Domain", "whcom" ) ?></strong>
									</div>

									<div class="whcom_col_sm_2">
										<strong><?php esc_html_e( "Status", "whcom" ) ?></strong>
									</div>

									<div class="whcom_col_sm_2">
										<strong><?php esc_html_e( "Days till expiry", "whcom" ) ?></strong>
									</div>

									<div class="whcom_col_sm_3">
										<strong><?php esc_html_e( "Action", "whcom" ) ?></strong>
									</div>

								</div>
							</li>

							<?php foreach ( $domains as $domain ) {  ?>

								<li>
									<div class="whcom_row">
										<div class="whcom_col_sm_5">
											<!--form element-1-->
											<div class="whcom_form_field">
												<div class="whcom_checkbox_container">
													<label class="whcom_checkbox">
														<input type="checkbox" name="domainrenewals-name[<?php echo $domain['domainname'] ?>]" value="on">
														<span>
															<?php echo $domain["domainname"] ?>
														</span>
													</label>
												</div>
											</div>
										</div>

										<div class="whcom_col_sm_2">
											<?php echo $domain["status"] ?>
										</div>

										<div class="whcom_col_sm_2">
											<?php
											$date1 = date_create( date( "Y-m-d" ) );

											$date2 = date_create( $domain["nextduedate"] );
											$diff  = date_diff( $date1, $date2 );

											$diff_days = $diff->format( "%R%a days" );
											( $diff_days >= 0 ) ? "+" . $diff_days : "-" . $diff_days;
											echo $diff_days;
											?>
										</div>

										<!--form element-2-->
										<div class="whcom_col_sm_3 whcom_form_field">
											<?php
											$tld       = whcom_get_tld_from_domain( $domain["domainname"] );
											$tld_years = whcom_get_tld_details( $tld );
											$tld_years = $tld_years["renew_price"];
											?>
											<select name="domainrenewals-period[<?php echo $domain['domainname'] ?>]">
												<?php foreach ( $tld_years as $year => $price ) { ?>
													<option value="<?php echo $year; ?>">
														<?php echo $year . " " . esc_html__( "Year/s", "whcom" ) . " @ " . whcom_format_amount( $price ) ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</li>

							<?php } ?>
						</ul>
					</div>
					<div class="whcom_op_response whcom_text_center"></div>
					<div class="whcom_text_center">
						<button type="submit" class="whcom_button whcom_button_success whcom_icon_cart-plus">
							<?php echo __( "Order Now", "whcom" ) ?>
						</button>
					</div>
				</form>
            </div>
            <div id="output">

            </div>

		</div>
	</div>
</div>






