<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$lang            = whcom_get_current_language();
$menu_array      = $this->get_menu_array();
$hidden_sections = ( get_option( "wcapfield_hide_whmcs_menu_sections" ) == '' ) ? [] : get_option( "wcapfield_hide_whmcs_menu_sections" );

$menu_array_front      = $this->get_front_menu_array();
$hidden_sections_front = ( get_option( "wcapfield_hide_whmcs_menu_sections_front" ) == '' ) ? [] : get_option( "wcapfield_hide_whmcs_menu_sections_front" );

if ( ! empty( $_GET["settings-updated"] ) && whcom_helper_test() ) {
	$status = whcom_process_helper( [ 'action'                       => 'change_redirect_url',
	                                  'wcapfield_whmcs_redirect_url' => esc_url( get_option( 'wcapfield_whmcs_redirect_url' ) )
	] );
	echo $status['status'] . ': ' . $status['message'];
}


?>
<div class="wrap wrap-about wcap_admin_wrapper">
	<h2></h2>
	<h1><?php echo esc_html_x( "Settings", "admin", "whcom" ) ?> - Client Area - WCAP</h1>
	<div class="whcom_main">
		<form action="options.php" method="post">
			<?php settings_fields( 'wcap_general' ); ?>
			<!-- General Settings -->
			<div class="whcom_panel">
				<div class="whcom_panel_header whcom_panel_header_white">
					<span><?php echo esc_html_x( 'General Settings', "admin", "whcom" ) ?></span>
				</div>
				<div class="whcom_panel_body">

					<div class="wcap_form_control">
						<div class="whcom_row">
							<?php $field = 'wcapfield_client_area_url' . $lang; ?>
							<div class="whcom_col_sm_4 whcom_text_right">
								<label for="<?php echo $field; ?>">
									<?php echo esc_html_x( "Client Area URL", "admin", "whcom" ) . " [" . $lang . "]" ?>
								</label>
							</div>
							<div class="whcom_col_sm_8">
								<input value="<?php echo get_option( $field ); ?>"
								       name="<?php echo $field; ?>"
								       id="<?php echo $field; ?>"
								       type="url">
								<div class="whcom_text_small">
									<?php echo esc_html_x( "help: Create a page with shrot-code [whmcs_client_area], and enter its URL here", "admin", "whcom" ) ?>
								</div>

							</div>
						</div>
					</div>


					<div class="wcap_form_control">
						<div class="whcom_row">
							<?php $field = 'wcapfield_after_login_redirect_url' . $lang; ?>
							<div class="whcom_col_sm_4 whcom_text_right">
								<label
									for="<?php echo $field; ?>"><?php echo esc_html_x( "Login Redirect URL (Optional)", "admin", "whcom" ) . " [" . $lang . "]" ?> </label>
							</div>
							<div class="whcom_col_sm_8">
								<input
									value="<?php echo get_option( $field ); ?>"
									name="<?php echo $field ?>"
									id="<?php echo $field ?>"
									type="url">
								<div class="whcom_text_small">
									<?php echo esc_html_x( "help: Default value is client area dashboard", "admin", "whcom" ) ?>

								</div>
							</div>
						</div>

						<div class="wcap_form_control">
							<div class="whcom_row">
								<?php $field = 'wcapfield_after_logout_redirect_url' . $lang; ?>
								<div class="whcom_col_sm_4 whcom_text_right">
									<label
										for="<?php echo $field ?>"><?php echo esc_html_x( "Logout Redirect URL (Optional)", "admin", "whcom" ) . " [" . $lang . "]" ?> </label>
								</div>
								<div class="whcom_col_sm_8">
									<input
										value="<?php echo get_option( $field ); ?>"
										name="<?php echo $field ?>"
										id="<?php echo $field ?>"
										type="url">
									<div class="whcom_text_small">
										<?php echo esc_html_x( "help: Default value is login page", "admin", "whcom" ) ?>

									</div>
								</div>
							</div>

							<div class="wcap_form_control">
								<div class="whcom_row">
									<div class="whcom_col_sm_4 whcom_text_right">
										<label
											for="wcapfield_curl_timeout"><?php echo esc_html_x( "cURL timeout in seconds", "admin", "whcom" ) ?> </label>
									</div>
									<div class="whcom_col_sm_8">
										<input
											value="<?php echo get_option( "wcapfield_curl_timeout" ); ?>"
											name="wcapfield_curl_timeout"
											id="wcapfield_curl_timeout"
											type="number">
									</div>
								</div>
							</div>

							<div class="wcap_form_control">
								<div class="whcom_row">
									<div class="whcom_col_sm_12 whcom_text_center">
										<button type="submit" class="button button-primary">
											<?php echo esc_html_x( "Save Settings", "admin", "whcom" ) ?>
										</button>

									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<!-- Invoice Settings -->
			<div class="whcom_panel">
				<div class="whcom_panel_header whcom_panel_header_white">
					<span><?php echo esc_html_x( 'Invoice Settings', "admin", "whcom" ) ?></span>
				</div>
				<div class="whcom_panel_body">
					<div class="wcap_form_control">
						<div class="whcom_row">
							<?php $field = 'wcapfield_show_invoice_as'; ?>
							<div class="whcom_col_sm_4 whcom_text_right">
								<label for="wcapfield_show_invoice_as"><?php echo esc_html_x( 'Show Invoice As', "admin", "whcom" ) ?></label>
							</div>
							<div class="whcom_col_sm_8">
								<select name="wcapfield_show_invoice_as" id="wcapfield_show_invoice_as">
									<option <?php echo get_option( "wcapfield_show_invoice_as", 'popup' ) == "popup" ? "selected" : "" ?>
										value="popup">
										<?php echo esc_html_x( "Popup", "admin", "whcom" ) ?>
									</option>
									<option <?php echo get_option( "wcapfield_show_invoice_as", 'popup' ) == "same_tab" ? "selected" : "" ?>
										value="same_tab">
										<?php echo esc_html_x( "Same Tab", "admin", "whcom" ) ?>
									</option>
									<option <?php echo get_option( "wcapfield_show_invoice_as", 'popup' ) == "new_tab" ? "selected" : "" ?>
										value="new_tab">
										<?php echo esc_html_x( "New Tab", "admin", "whcom" ) ?>
									</option>
									<option <?php echo get_option( "wcapfield_show_invoice_as", 'popup' ) == "minimal" ? "selected" : "" ?>
										value="minimal">
										<?php echo esc_html_x( "Minimal Interface/ WHMCS Invoice templates (Recommended)", "admin", "whcom" ) ?>
									</option>
								</select>
								<div id="minimal_interface_help"
								     style="display: <?php echo get_option( "wcapfield_show_invoice_as", 'popup' ) == "minimal" ? "block" : "none" ?>"
								     class="whcom_padding_15_0">
									<?php if ( esc_attr( get_option( 'whcom_whmcs_invoice_custom_templates' ), 'no' ) != 'yes' ) { ?>
										<div class="whcom_alert whcom_alert_warning">
											<div class="whcom_margin_bottom_15">
												<strong><?php echo esc_html_x( "Important", "admin", "whcom" ) ?>!</strong>
												<p><?php echo esc_html_x( "If you want to use Minimal Interface/ WHMCS Invoice templates, you will need to turn on WHMCS Invoice templates from below.", "admin", "whcom" ) ?></p>
											</div>
											<div class="whcom_text_center">
												<a href="?page=whcom-settings"
												   class="whcom_button whcom_button_info"><?php echo esc_html_x( "WCOM Settings", "admin", "whcom" ) ?></a>
											</div>
										</div>
									<?php }
									else { ?>
										<div class="whcom_alert whcom_alert_success">
											<div class="whcom_margin_bottom_15">
												<p><?php echo esc_html_x( "WHMCS invoice templates are enabled in WHMCS Config, you can use this option", "admin", "whcom" ) ?></p>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
					<div class="wcap_form_control">
						<div class="whcom_row">
							<div class="whcom_col_sm_12 whcom_text_center">
								<button type="submit" class="button button-primary">
									<?php echo esc_html_x( "Save Settings", "admin", "whcom" ) ?>
								</button>

							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- WHMCS Redirect URL -->
			<div class="whcom_panel">
				<div class="whcom_panel_header whcom_panel_header_white">
					<span><?php echo esc_html_x( 'Redirection from WHMCS', "admin", "whcom" ) ?></span>
				</div>
				<div class="whcom_panel_body">
					<div class="wcap_form_control">
						<div class="whcom_row">

							<div class="wcap_form_control">
								<div class="whcom_row">
									<?php $field = 'wcapfield_whmcs_redirect_url'; ?>
									<div class="whcom_col_sm_4 whcom_text_right">
										<label for="<?php echo $field; ?>">
											<?php echo esc_html_x( "Client Area URL to redirect visitors from WHMCS", "admin", "whcom" ) ?>
										</label>
									</div>
									<div class="whcom_col_sm_8">
										<input value="<?php echo get_option( $field ); ?>"
										       name="<?php echo $field; ?>"
										       id="<?php echo $field; ?>"
										       type="url">
										<div class="whcom_text_small">
											<?php echo esc_html_x( "help: If you want WHMCS visitors to be redirected to client area, fill this field with client area URL, where you have placed [WHMCS_client_area] shortcode", "admin", "whcom" ) ?>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="wcap_form_control">
						<div class="whcom_row">
							<div class="whcom_col_sm_12 whcom_text_center">
								<button type="submit" class="button button-primary">
									<?php echo esc_html_x( "Save Settings", "admin", "whcom" ) ?>
								</button>

							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Menu Settings -->
			<div class="whcom_panel">
				<div class="whcom_panel_header whcom_panel_header_white">
					<span><?php echo esc_html_x( 'Menu Settings', "admin", "whcom" ) ?></span>
				</div>
				<div class="whcom_panel_body">

					<!-- Menu after login -->
					<div class="wcap_form_control" style="padding: 0 15px">
						<div class="whcom_row">
							<div class="whcom_col_sm_4">
								<label for="wcapfield_hide_whmcs_menu">
									<strong><?php echo esc_html_x( "Hide WHMCS Menu (Login Area)", "admin", "whcom" ) ?></strong>
								</label>
							</div>
							<div class="whcom_col_sm_8">
								<label for="wcapfield_hide_whmcs_menu">
									<input
										value="1" <?php echo get_option( "wcapfield_hide_whmcs_menu" ) == "1" ? "checked" : "" ?>
										name="wcapfield_hide_whmcs_menu" id="wcapfield_hide_whmcs_menu"
										type="checkbox">
								</label>
							</div>
						</div>
					</div>

					<!-- Menu sections after login -->

					<div class="whcom_collapse whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<?php echo esc_html_x( 'Individual menu settings', "admin", "whcom" ) ?>
						</div>
						<div class="whcom_collapse_content">
							<?php foreach ( $menu_array as $menu_index => $menu_item ) { ?>
								<?php
								$parent_menu  = ( $menu_item["class"] == "no_load" ) ? true : false;
								$parent_style = ( $parent_menu ) ? ' style="background: #C0C0C0;  padding-top: 5px; padding-bottom: 5px;"' : '';
								?>
								<div class="wcap_form_control" style="padding: 0 15px">
									<div class="whcom_row" <?php echo $parent_style; ?>>
										<div class="whcom_col_sm_4">
											<label class="label_inline">
												<input
													value="hide"
													<?php
													if (
														( ! empty( $hidden_sections[ $menu_index ] ) )
														&& ( is_array( $hidden_sections[ $menu_index ] ) )
														&& ( ! empty ( $hidden_sections[ $menu_index ]['hide'] ) )
													) {
														echo 'checked';
													}
													?>
													name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][hide]"
													type="checkbox">
												<?php echo esc_html_x( 'Hide', "admin", "whcom" ) ?> <i
													class="whcom_icon_angle-right"></i> <?php echo $menu_item['label']; ?>
											</label>
										</div>
										<div class="whcom_col_sm_4">
											<?php $hidden = ( $parent_menu ) ? ' style="visibility: hidden"' : ''; ?>
											<label class="label_inline" <?php echo $hidden ?>>

												<input
													value="hide_sidebar"
													<?php
													if (
														( ! empty( $hidden_sections[ $menu_index ] ) )
														&& ( is_array( $hidden_sections[ $menu_index ] ) )
														&& ( ! empty ( $hidden_sections[ $menu_index ]['hide_sidebar'] ) )
													) {
														echo 'checked';
													}
													?>
													name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][hide_sidebar]"
													type="checkbox">
												<?php echo esc_html_x( 'Hide Sidebar', "admin", "whcom" ) ?>
											</label>
										</div>
										<div class="whcom_col_sm_4">
											<?php
											$url_override = '';
											if (
												( ! empty( $hidden_sections[ $menu_index ] ) )
												&& ( is_array( $hidden_sections[ $menu_index ] ) )
												&& ( ! empty ( $hidden_sections[ $menu_index ]['url_override'] ) )
											) {
												$url_override = $hidden_sections[ $menu_index ]['url_override'];
											}
											?>
											<input type="text"
											       name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][url_override]"
											       value="<?php echo $url_override; ?>"
											       placeholder="<?php echo esc_html_x( 'URL Override', "admin", "whcom" ) ?>">
										</div>
									</div>
								</div>
								<?php if ( ! empty( $menu_item['sub'] ) ) { ?>
									<?php foreach ( $menu_item['sub'] as $menu_index_sub => $menu_item_sub ) { ?>
										<div class="wcap_form_control" style="padding: 0 15px 0 60px">
											<div class="whcom_row">
												<div class="whcom_col_sm_4">
													<label class="label_inline">
														<input
															value="hide"
															<?php
															if (
																( ! empty( $hidden_sections[ $menu_index ]['sub'] ) )
																&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( is_array( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ]['hide'] ) )
															) {
																echo 'checked';
															}
															?>
															name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][hide]"
															type="checkbox">
														<?php esc_html_e( 'Hide', "admin", "whcom" ) ?> <i
															class="whcom_icon_angle-right"></i> <?php echo $menu_item_sub['label']; ?>
													</label>
												</div>
												<div class="whcom_col_sm_4">
													<label class="label_inline">
														<input
															value="hide_sidebar"
															<?php
															if (
																( ! empty( $hidden_sections[ $menu_index ]['sub'] ) )
																&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( is_array( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ]['hide_sidebar'] ) )
															) {
																echo 'checked';
															}
															?>
															name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][hide_sidebar]"
															type="checkbox">
														<?php echo esc_html_x( 'Hide Sidebar', "admin", "whcom" ) ?>
													</label>
												</div>

												<div class="whcom_col_sm_4">
													<?php
													$url_override = '';
													if (
														( ! empty( $hidden_sections[ $menu_index ]['sub'] ) )
														&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
														&& ( is_array( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ] ) )
														&& ( ! empty ( $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ]['url_override'] ) )
													) {
														$url_override = $hidden_sections[ $menu_index ]['sub'][ $menu_index_sub ]['url_override'];
													}
													?>
													<input type="text"
													       name="wcapfield_hide_whmcs_menu_sections[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][url_override]"
													       value="<?php echo $url_override; ?>"
													       placeholder="<?php echo esc_html_x( 'URL Override', "admin", "whcom" ) ?>">
												</div>
											</div>
										</div>
										<?php continue;
									} ?>
								<?php } ?>
							<?php } ?>
						</div>
					</div>


					<!-- Menu Front end -->
					<div class="wcap_form_control" style="padding: 0 15px">
						<div class="whcom_row">
							<div class="whcom_col_sm_4">
								<label for="wcapfield_hide_whmcs_menu_front">
									<strong><?php echo esc_html_x( "Hide WHMCS Menu (Frontend)", "admin", "whcom" ) ?></strong>
								</label>
							</div>
							<div class="whcom_col_sm_8">
								<label for="wcapfield_hide_whmcs_menu_front">
									<input
										value="1" <?php echo get_option( "wcapfield_hide_whmcs_menu_front" ) == "1" ? "checked" : "" ?>
										name="wcapfield_hide_whmcs_menu_front"
										id="wcapfield_hide_whmcs_menu_front"
										type="checkbox">
								</label>
							</div>
						</div>
					</div>

					<!-- Menu sections front -->
					<div class="whcom_collapse whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<?php echo esc_html_x( 'Individual menu settings (Front End)', "admin", "whcom" ) ?>
						</div>
						<div class="whcom_collapse_content">
							<?php foreach ( $menu_array_front as $menu_index => $menu_item ) { ?>
								<?php
								$parent_menu  = ( $menu_item["class"] == "no_load" ) ? true : false;
								$parent_style = ( $parent_menu ) ? ' style="background: #C0C0C0;  padding-top: 5px; padding-bottom: 5px;"' : '';
								?>
								<div class="wcap_form_control" style="padding: 0 15px">
									<div class="whcom_row" <?php echo $parent_style ?>>
										<div class="whcom_col_sm_4">
											<label class="label_inline">
												<input
													value="hide"
													<?php
													if (
														( ! empty( $hidden_sections_front[ $menu_index ] ) )
														&& ( is_array( $hidden_sections_front[ $menu_index ] ) )
														&& ( ! empty ( $hidden_sections_front[ $menu_index ]['hide'] ) )
													) {
														echo 'checked';
													}
													?>
													name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][hide]"
													type="checkbox">
												<?php echo esc_html_x( 'Hide', "admin", "whcom" ) ?> <i
													class="whcom_icon_angle-right"></i> <?php echo $menu_item['label']; ?>
											</label>
										</div>
										<div class="whcom_col_sm_4">
											<?php $hidden = ( $parent_menu ) ? ' style="visibility: hidden"' : ''; ?>
											<label class="label_inline" <?php echo $hidden ?>>
												<input
													value="hide_sidebar"
													<?php
													if (
														( ! empty( $hidden_sections_front[ $menu_index ] ) )
														&& ( is_array( $hidden_sections_front[ $menu_index ] ) )
														&& ( ! empty ( $hidden_sections_front[ $menu_index ]['hide_sidebar'] ) )
													) {
														echo 'checked';
													}
													?>
													name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][hide_sidebar]"
													type="checkbox">
												<?php echo esc_html_x( 'Hide Sidebar', "admin", "whcom" ) ?>
											</label>
										</div>
										<div class="whcom_col_sm_4">
											<?php
											$url_override = '';
											if (
												( ! empty( $hidden_sections_front[ $menu_index ] ) )
												&& ( is_array( $hidden_sections_front[ $menu_index ] ) )
												&& ( ! empty ( $hidden_sections_front[ $menu_index ]['url_override'] ) )
											) {
												$url_override = $hidden_sections[ $menu_index ]['url_override'];
											}
											?>
											<input type="text"
											       name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][url_override]"
											       value="<?php echo $url_override; ?>"
											       placeholder="<?php echo esc_html_x( 'URL Override', "admin", "whcom" ) ?>">
										</div>
									</div>
								</div>
								<?php if ( ! empty( $menu_item['sub'] ) ) { ?>
									<?php foreach ( $menu_item['sub'] as $menu_index_sub => $menu_item_sub ) { ?>
										<div class="wcap_form_control" style="padding: 0 15px 0 60px">
											<div class="whcom_row">
												<div class="whcom_col_sm_4">
													<label class="label_inline">
														<input
															value="hide"
															<?php
															if (
																( ! empty( $hidden_sections_front[ $menu_index ]['sub'] ) )
																&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( is_array( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ]['hide'] ) )
															) {
																echo 'checked';
															}
															?>
															name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][hide]"
															type="checkbox">
														<?php echo esc_html_x( 'Hide', "admin", "whcom" ) ?>
														<i
															class="whcom_icon_angle-right"></i> <?php echo $menu_item_sub['label']; ?>
													</label>
												</div>
												<div class="whcom_col_sm_4">
													<label class="label_inline">
														<input
															value="hide_sidebar"
															<?php
															if (
																( ! empty( $hidden_sections_front[ $menu_index ]['sub'] ) )
																&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( is_array( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
																&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ]['hide_sidebar'] ) )
															) {
																echo 'checked';
															}
															?>
															name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][hide_sidebar]"
															type="checkbox">
														<?php echo esc_html_x( 'Hide Sidebar', "admin", "whcom" ) ?>
													</label>
												</div>
												<div class="whcom_col_sm_4">
													<?php
													$url_override = '';
													if (
														( ! empty( $hidden_sections_front[ $menu_index ]['sub'] ) )
														&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
														&& ( is_array( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ] ) )
														&& ( ! empty ( $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ]['url_override'] ) )
													) {
														$url_override = $hidden_sections_front[ $menu_index ]['sub'][ $menu_index_sub ]['url_override'];
													}
													?>
													<input type="text"
													       name="wcapfield_hide_whmcs_menu_sections_front[<?php echo $menu_index; ?>][sub][<?php echo $menu_index_sub; ?>][url_override]"
													       value="<?php echo $url_override; ?>"
													       placeholder="<?php echo esc_html_x( 'URL Override', "admin", "whcom" ) ?>">
												</div>
											</div>
										</div>
										<?php continue;
									} ?>
								<?php } ?>
							<?php } ?>
						</div>
					</div>

					<!-- Menu after login -->
					<div class="wcap_form_control" style="padding: 0 15px">
						<div class="whcom_row">
							<div class="whcom_col_sm_4">
								<label for="wcapfield_hide_whmcs_menu_op">
									<strong><?php echo esc_html_x( "Hide WHMCS Menu (Order Process)", "admin", "whcom" ) ?></strong>
								</label>
							</div>
							<div class="whcom_col_sm_8">
								<label for="wcapfield_hide_whmcs_menu_op">
									<input
										value="1" <?php echo get_option( "wcapfield_hide_whmcs_menu_op" ) == "1" ? "checked" : "" ?>
										name="wcapfield_hide_whmcs_menu_op" id="wcapfield_hide_whmcs_menu_op"
										type="checkbox">
								</label>
							</div>
						</div>
					</div>

					<div class="wcap_form_control">
						<div class="whcom_row">
							<div class="whcom_col_sm_12 whcom_text_center">
								<button type="submit" class="button button-primary">
									<?php echo esc_html_x( "Save Settings", "admin", "whcom" ) ?>
								</button>

							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>