<?php
$currency = whcom_get_current_currency();

$domains = wcap_get_client_domains( [
	"clientid" => whcom_get_current_client_id(),
	"limitnum" => "999",
] );

// count status
$fill_array   = [
	"All"     => "0",
	"Active"  => "0",
	"Expired" => "0",
	"Pending" => "0",
];
$status_array = wcap_count_status( $fill_array, $domains["domains"]["domain"] );


$show_sidebar = wcap_show_side_bar( "my_domains");

?>

<div class="wcap_domains ">
	<div class="whcom_row">
		<?php if ( $show_sidebar ) { ?>
			<div class="whcom_col_sm_3">
				<!-- sidebar-->
				<div class="whcom_panel">
					<div class="whcom_panel_header whcom_has_icon">
						<i class="whcom_icon_filter panel_header_icon"></i><?php esc_html_e( 'View', "whcom" ) ?>
					</div>
					<div class="whcom_panel_body whcom_has_list">
						<ul class="whcom_list_wcap_style_2">
							<li>
								<a class="wcap_domains_filter" data-status="" href="#"><?php esc_html_e( 'All', "whcom" ) ?>
									<span class="whcom_pull_right"><?php echo $status_array["All"]; ?></span></a>
							</li>

							<li>
								<a class="wcap_domains_filter" data-status="Active" href="#"><?php esc_html_e( 'Active', "whcom" ) ?>
									<span class="whcom_pull_right"><?php echo $status_array["Active"]; ?></span></a>
							</li>
							<li>
								<a class="wcap_domains_filter" data-status="Expired" href="#"><?php esc_html_e( 'Expired', "whcom" ) ?>
									<span class="whcom_pull_right"><?php echo $status_array["Expired"]; ?></span></a>
							</li>
							<li>
								<a class="wcap_domains_filter" data-status="Pending" href="#"><?php esc_html_e( 'Pending', "whcom" ) ?>
									<span class="whcom_pull_right"><?php echo $status_array["Pending"]; ?></span></a>
							</li>
						</ul>
					</div>
				</div>
				<?php wcap_render_domains_panel_action(); ?>
			</div>
		<?php } ?>
		<div class="<?php echo ( $show_sidebar ) ? 'whcom_col_sm_9' : 'whcom_col_sm_12'; ?>">
			<div class="whcom_page_heading">
				<span><?php _e( "My Domains", "whcom" ) ?> </span>
			</div>
			<div class="wcap_domains_table whcom_table whcom_margin_bottom_15">
				<table class="dt-responsive data_table wcap_responsive_table" style="width: 100%">
					<thead>
						<tr>
							<th width="100px"><?php esc_html_e( "Domain", "whcom" ) ?></th>
							<th width="100px"><?php esc_html_e( "Reg Date", "whcom" ) ?></th>
							<th width="100px"><?php esc_html_e( "Next Due", "whcom" ) ?></th>
							<th width="100px"><?php esc_html_e( "Auto Renew", "whcom" ) ?></th>
							<th width="100px"><?php esc_html_e( "Status", "whcom" ) ?></th>
							<th width="100px"><?php //esc_html_e("Links","whcom" )?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach ( $domains["domains"]["domain"] as $domain ) {?>
							<tr data-status="<?php echo $domain["status"]; ?>">
								<td>
									<a href="http://www.<?php echo $domain["domainname"] ?>"><?php echo $domain["domainname"] ?>
								</td>
								<td><?php echo wcap_date( $domain["regdate"], 'd/m/Y' ) ?></td>
								<td><?php echo wcap_date( $domain["nextduedate"], 'd/m/Y' ) ?></td>
								<td>
									<?php// if ( $domain["status"] == "Active" ) { ?>
										<i class="<?php echo ( $domain["donotrenew"] == 0 ) ? 'whcom_icon_ok whcom_text_success': 'whcom_icon_cancel whcom_text_danger';  ?>"></i>
										<?php echo wcap_ed( $domain["donotrenew"] ); ?>
									<?php// }
									//else {
									//	echo wcap_yesno( $domain["donotrenew"] );
									//} ?>
								</td>
								<td>
									<span class="whcom_pill_block whcom_pill_<?php echo ( strtolower( $domain["status"] ) == 'active' ) ? 'success' : 'danger'; ?>"><?php echo wcap_status_ml($domain["status"]); ?></span>
								</td>
								<td>
									<div class="whcom_dropdown">
										<div class="whcom_button_group">
											<a data-page="domaindetail" href="?id=<?php echo $domain["id"] ?>" class="wcap_load_page whcom_button whcom_button_secondary whcom_button_small">
												<i class="whcom_icon_wrench-1"></i>
											</a>
											<a class="whcom_button whcom_button_secondary whcom_button_small whcom_dropdown_toggle">
												<i class="whcom_icon_down-dir"></i>
											</a>
										</div>

										<div class="whcom_dropdown_content" style="width: 200px; z-index: 9999;">
											<ul class="whcom_list_padded whcom_list_stripped">
												<li style="padding: 5px 10px;">
													<a href="?id=<?php echo $domain["id"] ?>&do=ns" class="wcap_load_page"
													   data-page="domaindetail">
														<?php esc_html_e( "Manage Nameservers", "whcom" ); ?>
													</a>
												</li>
												<li style="padding: 5px 10px;">
													<a href="?id=<?php echo $domain["id"] ?>&do=contact" class="wcap_load_page"
													   data-page="domaindetail">
														<?php esc_html_e( "Edit Contact Information", "whcom" ); ?>
													</a>
												</li>
												<li style="padding: 5px 10px;">
													<a href="?id=<?php echo $domain["id"] ?>&do=autorenew" class="wcap_load_page"
													   data-page="domaindetail">
														<?php esc_html_e( "Auto Renewal Status", "whcom" ); ?>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>




