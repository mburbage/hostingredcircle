<?php defined('ABSPATH') or die("Cannot access pages directly.");

if (!function_exists('whcom_render_tld_specific_fields')) {
	function whcom_render_tld_specific_fields($tld, $index = -1, $cart_item = [])
	{
		$additionaldomainfields = whcom_get_domain_fields($tld);
		$return_html = '';
		$internal_index = 0;
		$field_name = ($index > -1) ? 'domainfields[' . $index . ']' : 'domainfields';
		$cart_item = (empty($cart_item)) ? whcom_get_cart_item($index)['cart_item'] : $cart_item;
		if (!empty($additionaldomainfields) && is_array($additionaldomainfields)) {
			$return_html .= '<div class="whcom_sub_heading_style_1"><span>' . esc_html__('Domain Fields', 'whcom') . '</span></div>';
			$return_html .= '<div class="whcom_domain_fields">';
			foreach ($additionaldomainfields as $fld) {
				$type = $fld['Type'];
				$return_html .= '<div class="whcom_form_field whcom_form_field_horizontal">';
				$required_fld = (isset($fld['Required']) && ($fld['Required'] == '1' || $fld['Required'] == true || $fld['Required'] == 1)) ? 'required' : '';
				switch ($type) {
					case 'dropdown': {
							$rand = '_' . rand(11111, 99999);
							$options = explode(',', $fld['Options']);
							$return_html .= '<label for="dropdown' . $rand . '" class="main_label">' . $fld['Name'] . '</label>';
							$return_html .= '<select id="dropdown' . $rand . '" name="' . $field_name . '[' . $internal_index . ']" ' . $required_fld . ' >';
							foreach ($options as $option) {
								if (!empty($cart_item['domainfields']) && !empty($cart_item['domainfields'][$internal_index])) {
									$selected = ($cart_item['domainfields'][$internal_index] == $option) ? 'selected' : '';
								} else {
									$selected = ($option == $fld['Default']) ? 'selected' : '';
								}
								$return_html .= '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
							}
							$return_html .= '</select>';
							break;
						}
					case 'text': {
							$rand = '_' . rand(11111, 99999);
							if (!empty($cart_item['domainfields']) && !empty($cart_item['domainfields'][$internal_index])) {
								$value = $cart_item['domainfields'][$internal_index];
							} else {
								$value = $fld['Default'];
							}
							$return_html .= '<label for="dropdown' . $rand . '" class="main_label">' . $fld['Name'] . '</label>';
							$return_html .= '<input id="dropdown' . $rand . '" name="' . $field_name . '[' . $internal_index . ']" type="text" value="' . $value . '" maxlength="' . $fld['Size'] . '" ' . $required_fld . '>';
							break;
						}
					case 'tickbox': {
							$selected = $selected_class = '';
							$rand = '_' . rand(11111, 99999);
							$return_html .= '<label for="checkbox' . $rand . '" class="main_label">' . $fld['Name'] . '</label>';
							$return_html .= '<div class="whcom_checkbox_container">';
							if (!empty($cart_item['domainfields']) && !empty($cart_item['domainfields'][$internal_index])) {
								$selected = ($cart_item['domainfields'][$internal_index] == 'yes') ? 'checked' : '';
								$selected_class = ($cart_item['domainfields'][$internal_index] == 'yes') ? 'whcom_checked' : '';
							}
							$return_html .= '<label for="checkbox' . $rand . '" class="whcom_checkbox ' . $selected_class . '"> ';
							$return_html .= '<input id="checkbox' . $rand . '" ' . $selected . ' name="' . $field_name . '[' . $internal_index . ']" type="checkbox" ' . $required_fld . ' value="yes">';
							$return_html .= '</label>';
							$return_html .= '</div>';

							break;
						}
					case 'radio': {
							$options = explode(',', $fld['Options']);
							$return_html .= '<label class="main_label">' . $fld['Name'] . '</label>';
							$return_html .= '<div class="whcom_radio_container">';
							foreach ($options as $option) {
								$rand = '_' . rand(11111, 99999);
								if (!empty($cart_item['domainfields']) && !empty($cart_item['domainfields'][$internal_index])) {
									$selected = ($cart_item['domainfields'][$internal_index] == $option) ? 'checked' : '';
									$selected_class = ($cart_item['domainfields'][$internal_index] == $option) ? 'whcom_checked' : '';
								} else {
									$selected = ($option == $fld['Default']) ? 'checked' : '';
									$selected_class = ($option == $fld['Default']) ? 'whcom_checked' : '';
								}
								$return_html .= '<label for="radio' . $rand . '" class="whcom_radio ' . $selected_class . '"> ';
								$return_html .= '<input id="radio' . $rand . '" ' . $selected . ' name="' . $field_name . '[' . $internal_index . ']" type="radio" ' . $required_fld . '>';
								$return_html .= $option . '</label>';
							}
							$return_html .= '</div>';

							break;
						}
					case 'display': {
							if (!empty($cart_item['domainfields']) && !empty($cart_item['domainfields'][$internal_index])) {
								$value = $cart_item['domainfields'][$internal_index];
							} else {
								$value = $fld['Default'];
							}
							$return_html .= '<label class="main_label">' . $fld['Name'] . '</label>';
							$return_html .= '<div class="whcom_radio_container">' . $value . '</div>';

							break;
						}
					default: {
						}
				}
				$return_html .= '</div>';
				$internal_index++;
			}
			$return_html .= '</div>';
		}

		return $return_html;
	}
}

if (!function_exists('whcom_render_tld_specific_addons')) {
	function whcom_render_tld_specific_addons($tld, $index = -1, $type = 'register', $cart_item = [])
	{
		$tld = str_replace('..', '.', $tld);
		$return_html = '';
		$column_class = 'whcom_col_sm_12';
		$name_append = ($index > -1) ? '[' . $index . ']' : '';

		$all_addons = whcom_get_domain_addons();
		$tld_details = whcom_get_tld_details($tld);

		if (!empty($tld_details) && !empty($tld_details['min_price'] && !empty($tld_details['min_price'][$type]))) {

			$reg_years = $tld_details['min_price'][$type]['duration'];
			$reg_years_text = ($reg_years == '1') ? $reg_years . ' ' . esc_html__("Year", "whcom") : $reg_years . ' ' . esc_html__("Years", "whcom");

			$dnsmanagement_p = whcom_format_amount($all_addons['dnsmanagement']);
			$emailforwarding_p = whcom_format_amount($all_addons['emailforwarding']);
			$idprotection_p = whcom_format_amount($all_addons['idprotection']);
			$cart_item = (!empty($cart_item) && is_array($cart_item)) ? $cart_item : whcom_get_cart_item($index)['cart_item'];

			$dnsmanagement_checked = (!empty($cart_item) && !empty($cart_item['dnsmanagement'])) ? true : false;
			$emailforwarding_checked = (!empty($cart_item) && !empty($cart_item['emailforwarding'])) ? true : false;
			$idprotection_checked = (!empty($cart_item) && !empty($cart_item['idprotection'])) ? true : false;
			$addons_count = 0;
			if ($tld_details['dnsmanagement'] == 'on' || $tld_details['dnsmanagement'] == '1') {
				$addons_count++;
			}
			if ($tld_details['emailforwarding'] == 'on' || $tld_details['emailforwarding'] == '1') {
				$addons_count++;
			}
			if ($tld_details['idprotection'] == 'on' || $tld_details['idprotection'] == '1') {
				$addons_count++;
			}

			if ($addons_count > 0) {
				if ($addons_count == 1) {
					$column_class = 'whcom_col_sm_12';
				}
				if ($addons_count == 2) {
					$column_class = 'whcom_col_sm_6';
				}
				if ($addons_count == 3) {
					$column_class = 'whcom_col_sm_4';
				}

				ob_start();

?>
				<div class="whcom_sub_heading_style_1">
					<span><?php esc_html_e("Available Addons", "whcom") ?></span>
				</div>
				<div class="whcom_row">
					<?php if ($tld_details['dnsmanagement'] == 'on' || $tld_details['dnsmanagement'] == '1') { ?>
						<div class="<?php echo $column_class; ?>">
							<div class="whcom_panel whcom_text_small whcom_op_addon_container whcom_bg_white">
								<label style="cursor: pointer">
									<div class="whcom_panel_body whcom_form_field whcom_op_addon_container">
										<div class="whcom_checkbox_container whcom_text_center">
											<label class="whcom_checkbox whcom_text_small <?php echo ($dnsmanagement_checked) ? 'whcom_checked' : ''; ?>">

												<input name="dnsmanagement<?php echo $name_append ?>" value="1" <?php echo ($dnsmanagement_checked) ? 'checked' : ''; ?> type="checkbox" class="whcom_addon_input wcop_input">

												<strong style="cursor:pointer">
													<?php esc_html_e("DNS Management", "whcom"); ?>
												</strong> </label>
											<div>
												<?php esc_html_e("External DNS Hosting can help speed up your website and improve availability with reduced redundancy.", "whcom"); ?>
											</div>
										</div>
									</div>
									<div class="whcom_panel_footer whcom_bg_white whcom_text_center">
										<div class="whcom_padding_10">
											<?php echo $dnsmanagement_p . " / " . $reg_years . " Year/s" ?>
										</div>
										<span class="whcom_button whcom_button_block whcom_button_danger whcom_addon_remove_button" style="display: <?php echo ($dnsmanagement_checked) ? 'block' : 'none'; ?>">
											<i class="whcom_icon_basket-1"></i> <?php esc_html_e(" Added to Cart (Remove)", "whcom") ?>
										</span>
										<span class="whcom_button whcom_button_block whcom_button_success whcom_addon_add_button" style="display: <?php echo ($dnsmanagement_checked) ? 'none' : 'block'; ?>">
											<i class="whcom_icon_plus"></i> <?php esc_html_e("Add to Cart", "whcom") ?>
										</span>
									</div>
								</label>
							</div>
						</div>
					<?php } ?>
					<?php if ($tld_details['idprotection'] == 'on' || $tld_details['idprotection'] == '1') { ?>
						<div class="<?php echo $column_class; ?>">

							<div class="whcom_panel whcom_text_small whcom_op_addon_container whcom_bg_white">
								<label style="cursor: pointer">
									<div class="whcom_panel_body whcom_form_field">
										<div class="whcom_checkbox_container whcom_text_center">
											<label class="whcom_checkbox whcom_text_small <?php echo ($idprotection_checked) ? 'whcom_checked' : ''; ?>">
												<input name="idprotection<?php echo $name_append ?>" value="1" type="checkbox" <?php echo ($idprotection_checked) ? 'checked' : ''; ?> class="whcom_addon_input wcop_input"> <strong><?php esc_html_e("ID Protection", "whcom") ?></strong>
											</label>
											<div>
												<?php esc_html_e("Protect your personal information and reduce the amount of spam to your inbox by enabling ID Protection", "whcom"); ?>
											</div>
										</div>
									</div>
									<div class="whcom_panel_footer  whcom_bg_white whcom_text_center">
										<div class="whcom_padding_10">
											<?php echo $idprotection_p . " / " . $reg_years . " Year/s" ?>
										</div>
										<span class="whcom_button whcom_button_block whcom_button_danger whcom_addon_remove_button" style="display: <?php echo ($idprotection_checked) ? 'block' : 'none'; ?>">
											<i class="whcom_icon_basket-1"></i> <?php esc_html_e(" Added to Cart (Remove)", "whcom") ?>
										</span>
										<span class="whcom_button whcom_button_block whcom_button_success whcom_addon_add_button" style="display: <?php echo ($idprotection_checked) ? 'none' : 'block'; ?>">
											<i class="whcom_icon_plus"></i> <?php esc_html_e("Add to Cart", "whcom") ?>
										</span>
									</div>
								</label>
							</div>
						</div>
					<?php } ?>
					<?php if ($tld_details['emailforwarding'] == 'on' || $tld_details['emailforwarding'] == '1') { ?>
						<div class="<?php echo $column_class; ?>">
							<div class="whcom_panel whcom_text_small whcom_op_addon_container whcom_bg_white">
								<label style="cursor: pointer">
									<div class="whcom_panel_body whcom_form_field">
										<div class="whcom_checkbox_container whcom_text_center">
											<label class="whcom_checkbox whcom_text_small <?php echo ($emailforwarding_checked) ? 'whcom_checked' : ''; ?>">
												<input name="emailforwarding<?php echo $name_append ?>" value="1" type="checkbox" <?php echo ($emailforwarding_checked) ? 'checked' : ''; ?> class="whcom_addon_input wcop_input"> <strong><?php esc_html_e("Email Forwarding", "wca") ?></strong>
											</label>
											<div>
												<?php esc_html_e("Get emails forwarded to alternate email addresses of your choice so that you can monitor all from a single account.", "whcom"); ?>
											</div>
										</div>
									</div>
									<div class="whcom_panel_footer  whcom_bg_white whcom_text_center">
										<div class="whcom_padding_10">
											<?php echo $emailforwarding_p . " / " . $reg_years . " Year/s" ?>
										</div>
										<span class="whcom_button whcom_button_block whcom_button_danger whcom_addon_remove_button" style="display: <?php echo ($emailforwarding_checked) ? 'block' : 'none'; ?>">
											<i class="whcom_icon_basket-1"></i> <?php esc_html_e(" Added to Cart (Remove)", "whcom") ?>
										</span>
										<span class="whcom_button whcom_button_block whcom_button_success whcom_addon_add_button" style="display: <?php echo ($emailforwarding_checked) ? 'none' : 'block'; ?>">
											<i class="whcom_icon_plus"></i> <?php esc_html_e("Add to Cart", "whcom") ?>
										</span>
									</div>
								</label>
							</div>
						</div>
					<?php } ?>
				</div>

			<?php
				$return_html = ob_get_clean();
			}
		}

		return $return_html;
	}
}

if (!function_exists('whcom_render_product_config_options')) {
	function whcom_render_product_config_options($product, $index = -1, $billing_cycle = '')
	{
		if (!is_array($product)) {
			$product = whcom_get_product_details((int)$product);
		}
		$index_append = ($index > -1) ? '[' . $index . ']' : '';
		if (empty($product['all_prices'][$billing_cycle])) {
			reset($product['lowest_price']);
			$billing_cycle = key($product['lowest_price']);
		}
		ob_start();
		echo '';
		if (!empty($product['lowest_price'])) { ?>
			<div class="whcom_product_options">
				<?php foreach ($product['prd_configoptions'] as $i => $options_group) {
					switch ($options_group['optiontype']) {
						case '1': {
								// Case 1 represents <select> element
				?>
								<?php if ($options_group['hidden'] != 1) { ?>
									<div class="whcom_product_option whcom_form_field whcom_form_field_horizontal">
										<label class="whcom_product_option_label main_label" for="configoption[<?php echo $options_group['id']; ?>]"><?php echo $options_group['optionname']; ?>
										</label>
										<select class="whcom_op_input wcop_input" name="configoptions<?php echo $index_append . '[' . $options_group['id'] . ']'; ?>" id="configoption[<?php echo $options_group['id']; ?>]" data-option-index=' . $i . '>
											<?php foreach ($options_group['sub_options'] as $opt) {
												$sub_option_price = (float)$opt['all_prices'][$billing_cycle]['price'];
												$sub_option_setup = (float)$opt['all_prices'][$billing_cycle]['setup']; ?>
												<option value="<?php echo $opt['id'] ?>">
													<?php echo $opt['optionname'] ?>
													<?php if ($sub_option_price > 0) { ?>
														<?php echo whcom_format_amount($opt['all_prices'][$billing_cycle]['price']) ?>
													<?php } ?>
													<?php if ($sub_option_price > 0 && $sub_option_setup > 0) { ?>
														+
													<?php } ?>
													<?php if ($sub_option_setup > 0) { ?>
														<?php echo whcom_format_amount($opt['all_prices'][$billing_cycle]['setup']) ?>
														<?php esc_html_e("Setup Fee", "whcom") ?>
													<?php } ?>
												</option>
											<?php } ?>
										</select>
									</div>
								<?php } ?>
							<?php break;
							}
						case '2': {
								// case 2 represents <input type="radio">
							?>
								<?php if ($options_group['hidden'] != 1) { ?>
									<div class="whcom_product_option whcom_form_field whcom_form_field_horizontal">
										<label class="whcom_product_option_label main_label"><?php echo $options_group['optionname']; ?></label>
										<div class="whcom_radio_container">
											<?php
											$selected = 'checked';
											$selected_class = 'whcom_checked';
											foreach ($options_group['sub_options'] as $opt) {
												$sub_option_price = (float)$opt['all_prices'][$billing_cycle]['price'];
												$sub_option_setup = (float)$opt['all_prices'][$billing_cycle]['setup']; ?>
												<?php $local_rand = '_' . rand(1111, 9999); ?>
												<label class="whcom_radio <?php echo $selected_class; ?>" for="configoption<?php echo $local_rand; ?>">
													<input class="whcom_op_input wcop_input" name="configoptions<?php echo $index_append . '[' . $options_group['id'] . ']'; ?>" type="radio" value="<?php echo $opt['id']; ?>" id="<?php echo 'configoption' . $local_rand . '' ?>" <?php echo $selected; ?> data-option-index="<?php echo $i; ?>">
													<?php echo $opt['optionname']; ?>
													<?php if ($sub_option_price > 0) { ?>
														<?php echo whcom_format_amount($opt['all_prices'][$billing_cycle]['price']) ?>
													<?php } ?>
													<?php if ($sub_option_price > 0 && $sub_option_setup > 0) { ?>
														+
													<?php } ?>
													<?php if ($sub_option_setup > 0) { ?>
														<?php echo whcom_format_amount($opt['all_prices'][$billing_cycle]['setup']) ?>
														<?php esc_html_e("Setup Fee", "whcom") ?>
													<?php } ?>
												</label>
											<?php
												$selected = $selected_class = '';
											} ?>

										</div>
									</div>
								<?php } ?>

							<?php break;
							}
						case '3': {
								// case 3 represents <input type="checkbox">
							?>

								<?php $sub_option = reset($options_group['sub_options']); ?>
								<?php if ($options_group['hidden'] != 1) { ?>
									<div class="whcom_product_option whcom_form_field whcom_form_field_horizontal">
										<label class="whcom_product_option_label main_label"><?php echo $options_group['optionname']; ?></label>

										<div class="whcom_checkbox_container">
											<?php $local_rand = '_' . rand(1111, 9999); ?>
											<label class="whcom_checkbox" for="configoption<?php echo $local_rand; ?>">
												<input name="configoptions<?php echo $index_append . '[' . $options_group['id'] . ']'; ?>" value="1" id="configoption<?php echo $local_rand; ?>" class="whcom_op_input wcop_input" type="checkbox" data-option-index="<?php echo $i; ?>">
												<?php echo $sub_option['optionname']; ?>
												<?php
												$sub_option_price = (float)$sub_option['all_prices'][$billing_cycle]['price'];
												$sub_option_setup = (float)$sub_option['all_prices'][$billing_cycle]['setup'];
												?>
												<?php if ($sub_option_price > 0) { ?>
													<?php echo whcom_format_amount($sub_option_price) ?>
												<?php } ?>
												<?php if ($sub_option_price > 0 && $sub_option_setup > 0) { ?>
													+
												<?php } ?>
												<?php if ($sub_option_setup > 0) { ?>
													<?php echo whcom_format_amount($sub_option_setup) ?>
													<?php esc_html_e("Setup Fee", "whcom") ?>
												<?php } ?>
											</label>
										</div>
										<br>
										<div class="loading_class" style="display: none; text-align: center; padding: 50px 0px 0px 0px;">
											Loading...
										</div>
									</div>
								<?php } ?>
							<?php break;
							}
						case '4': {
								// case 2 represents <input type="number">
							?>
								<?php
								$sub_option = reset($options_group['sub_options']);
								$price = ($sub_option['all_prices'][$billing_cycle]['price']);
								$setup = ($sub_option['all_prices'][$billing_cycle]['setup']);
								$val = ' value="' . $options_group['qtyminimum'] . '" ';
								$min = ' min="' . $options_group['qtyminimum'] . '" ';
								$max = ($options_group['qtyminimum'] > $options_group['qtymaximum']) ? '' : ' max="' . $options_group['qtymaximum'] . '"';
								$val_min_max = $val . $min . $max;
								?>
								<?php if ($options_group['hidden'] != 1) { ?>
									<div class="whcom_product_option whcom_form_field whcom_form_field_horizontal">
										<label class="whcom_product_option_label main_label"><?php echo $options_group['optionname']; ?></label>
										<span class="whcom_minus">-</span>
										<input name="configoptions<?php echo $index_append . '[' . $options_group['id'] . ']'; ?>" <?php echo $val_min_max; ?> class="whcom_op_input wcop_input whcom_plus_minus" type="number" data-option-index="<?php echo $i; ?>">
										<span class="whcom_plus">+</span>
										<label class="whcom_padding_0_10"> x <?php echo $sub_option['optionname'] ?>
											<span><?php echo whcom_format_amount($price); ?></span> +
											<span><?php echo whcom_format_amount($setup); ?></span>
											<?php esc_html_e("Setup Fee", "whcom") ?>
										</label>
									</div>
								<?php } ?>
					<?php break;
							}
						default: {
							}
					}
					?>
				<?php } ?>
			</div>
		<?php
		}
		$return_html = ob_get_clean();

		return $return_html;
	}
}

if (!function_exists('whcom_render_product_addons')) {
	function whcom_render_product_addons($product, $index = -1, $style = "")
	{
		$return_html = '';
		$index_append = ($index > -1) ? '[' . $index . ']' : '';
		$random = '_' . rand(11111, 99999);
		$product = (!empty($product) && is_array($product)) ? $product : whcom_get_product_details((int)$product);
		if (!empty($product)) {
			ob_start(); ?>
			<div class="whcom_product_addons">
				<div class="whcom_row">
					<?php if ($style == '10_server') { ?>
						<label class="whcom_product_option_label main_label">Addons: </label>
					<?php } ?>
					<?php foreach ($product['prd_addons'] as $i => $addon) {
						$addon_billingcycle = strtolower($addon['billingcycle']);
						if ($addon_billingcycle == 'recurring') {
							reset($addon['lowest_price']);
							$addon_billingcycle = key($addon['lowest_price']);
							$curr_addon_price = $addon['lowest_price'][$addon_billingcycle]['price'];
							$curr_addon_setup = $addon['lowest_price'][$addon_billingcycle]['setup'];
						} else if ($addon_billingcycle == 'free') {
							$addon_billingcycle = '';
							$curr_addon_price = 0.00;
							$curr_addon_setup = 0.00;
						} else {
							$curr_addon_price = $addon['monthly'];
							$curr_addon_setup = $addon['msetupfee'];
						}

					?>
						<?php if ($style == '08_elegant') { ?>

							<div class="whcom_col_sm_12">
								<div class="whcom_addon_section_content">
									<div class="whcom_panel whcom_text_small whcom_text_center whcom_op_addon_container whcom_bg_white">
										<label style="cursor: pointer">
											<div class="whcom_row">
												<div class="whcom_col_xl_8 whcom_col_lg_8">
													<div class="whcom_op_product_addon whcom_panel_body whcom_form_field">
														<div class="whcom_product_addon_price whcom_checkbox_container">
															<label class="whcom_product_addon_recurring whcom_checkbox">
																<input name="addons<?php echo $index_append; ?>[]" value="<?php echo $addon['id']; ?>" id="whcom_product_addon_<?php echo $addon['id'] . $random; ?>" class="whcom_op_input wcop_input whcom_addon_input" type="checkbox">
																<strong><?php echo $addon['name']; ?></strong> </label>
															<div class="whcom_product_addon_description">
																<span><?php echo $addon['description']; ?></span>
															</div>
														</div>
													</div>
												</div>
												<div class="whcom_col_xl_4 whcom_col_lg_4">
													<div class="whcom_panel_footer  whcom_bg_white">
														<div class="whcom_row">
															<div class="whcom_col_xl_12 whcom_col_lg_12 whcom_col_sm_6 whcom_col_xs_6">
																<div class="whcom_padding_10">
																	<span><?php echo whcom_format_amount($curr_addon_price); ?></span>
																	<span><?php echo whcom_convert_billingcycle($addon_billingcycle); ?></span>
																	<br>
																	<span><i><?php echo $curr_addon_setup == 0 ? "Free" : whcom_format_amount($curr_addon_setup); ?></i></span>
																	<span><i><?php echo esc_html__('Setup', 'whcom'); ?></i></span>
																</div>
															</div>
															<div class="whcom_col_xl_12 whcom_col_lg_12 whcom_col_sm_6 whcom_col_xs_6">
																<span class="whcom_button whcom_button_danger whcom_addon_remove_button" style="display: none">
																	<?php esc_html_e("Remove", "whcom") ?>
																</span>
																<span class="whcom_button whcom_button_success whcom_addon_add_button">
																	<?php esc_html_e("Add", "whcom") ?>
																</span>
															</div>
														</div>
													</div>
												</div>
											</div>

										</label>
									</div>
								</div>
							</div>

						<?php } elseif ($style == '10_server') { ?>
							<label class="whcom_product_addon_recurring whcom_checkbox">
								<input name="addons<?php echo $index_append; ?>[]" value="<?php echo $addon['id']; ?>" id="whcom_product_addon_<?php echo $addon['id'] . $random; ?>" class="whcom_op_input wcop_input whcom_addon_input" type="checkbox">
								<span><?php echo $addon['name']; ?></span> </label>
						<?php } else { ?>
							<div class="whcom_col_sm_12">
								<div class="whcom_panel whcom_text_small whcom_text_left whcom_op_addon_container whcom_bg_white">
									<label style="cursor: pointer">
										<div class="whcom_op_product_addon whcom_panel_body whcom_form_field">
											<div class="whcom_product_addon_price whcom_checkbox_container">
												<label class="whcom_product_addon_recurring whcom_checkbox">
													<input name="addons<?php echo $index_append; ?>[]" value="<?php echo $addon['id']; ?>" id="whcom_product_addon_<?php echo $addon['id'] . $random; ?>" class="whcom_op_input wcop_input whcom_addon_input" type="checkbox">
													<strong><?php echo $addon['name']; ?></strong> </label>

												<div class="whcom_product_addon_description">
													<span><?php echo $addon['description']; ?></span>
												</div>
												<div class="whcom_product_price_custom">
													<span><?php echo whcom_format_amount($curr_addon_price); ?></span>
													<span><?php echo whcom_convert_billingcycle($addon_billingcycle); ?></span>
													<!-- +
													<span><?php echo whcom_format_amount($curr_addon_setup); ?></span>
													<span><?php echo esc_html__('Setup Fee', 'whcom'); ?></span> -->
												</div>
												<span class="whcom_button whcom_button_block whcom_button_danger whcom_addon_remove_button" style="display: none">
													<i class="whcom_icon_basket-1"></i> <?php esc_html_e("Remove", "whcom") ?>
												</span>
												<span class="whcom_button whcom_button_block whcom_button_success whcom_addon_add_button">
													<i class="whcom_icon_plus"></i> <?php esc_html_e("Add to Cart", "whcom") ?>
												</span>
											</div>
										</div>
									</label>
								</div>
							</div>
					<?php }
					} ?>
				</div>
			</div>
		<?php
			$return_html = ob_get_clean();
		}

		return $return_html;
	}
}

if (!function_exists('whcom_render_product_custom_fields')) {
	function whcom_render_product_custom_fields($product, $index = -1)
	{
		$index_append = ($index > -1) ? '[' . $index . ']' : '';
		ob_start(); ?>
		<div class="whcom_product_custom_fields">
			<?php foreach ($product['custom_fields'] as $i => $custom_field) {
				$required = ($custom_field['required'] == 'on') ? 'required' : '';

				$custom_field_display_name = explode("|", $custom_field['fieldname']);

				switch ($custom_field['fieldtype']) {
					case 'dropdown': {
							// Case 1 represents <select> element

							// $field_options = explode( ',', $custom_field['fieldoptions'] );

							//                            $key = array_search('|', $field_options);
							//                            $custom_field_option_name = explode("|",$field_options[$key]);
							$field_options = [];
							$field_options = explode(",", $custom_field['fieldoptions']);

							foreach ($field_options as $key => $custom_field['fieldoptions']) {
								$field_options[$key] = explode("|", $custom_field['fieldoptions']);
							}

							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<select class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';

							foreach ($field_options as $opt) {
								if (is_array($opt)) {
									// foreach ($opt as $val) {

									if (count($opt) > 1) {
										echo '<option value="' . $opt['1'] . '">' . $opt['1'] . '</option>';
									} else {
										echo '<option value="' . $opt['0'] . '">' . $opt['0'] . '</option>';
									}
								} else {
									echo '<option value="' . $opt . '">' . $opt . '</option>';
								}

								//echo '<option value="' . $opt . '">' . $opt .  '</option>';
							}

							echo '</select>';

							echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['description'] . '</label>';

							echo '</div>';
							break;
						}
					case 'tickbox': {
							// case 2 represents <input type="checkbox">
							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<div class="whcom_checkbox_container">';
							echo '<label class="whcom_checkbox" for="custom_field_[' . $custom_field['id'] . ']">';
							echo '<input type="checkbox" class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
							echo $custom_field['description'] . '</label>';
							echo '</div>';
							echo '</div>';
							break;
						}
					case 'password': {
							// case 2 represents <input type="number">
							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<input type="password" class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
							echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['description'] . '</label>';

							echo '</div>';
							break;

							break;
						}
					case 'text': {
							// case 2 represents <input type="number">
							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<input type="text" class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
							echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['description'] . '</label>';

							echo '</div>';
							break;

							break;
						}
					case 'link': {
							// case 2 represents <input type="number">
							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<input type="url" class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '>';
							echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['description'] . '</label>';

							echo '</div>';
							break;

							break;
						}
					case 'textarea': {
							// case 2 represents <input type="number">
							echo '<div class="whcom_product_custom_field whcom_form_field whcom_form_field_horizontal">';
							if (isset($custom_field_display_name['1'])) {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field_display_name['1'] . ':</label>';
							} else {
								echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['fieldname'] . ':</label>';
							}
							echo '<textarea class="" name="customfields' . $index_append . '[' . $custom_field['id'] . ']" id="custom_field_[' . $custom_field['id'] . ']" ' . $required . '></textarea>';
							echo '<label class="main_label" for="custom_field_[' . $custom_field['id'] . ']">' . $custom_field['description'] . '</label>';

							echo '</div>';
							break;

							break;
						}
					default: {
						}
				}

			?>
			<?php } ?>
		</div>


	<?php
		$return_html = ob_get_clean();

		return $return_html;
	}
}

if (!function_exists('whcom_render_server_specific_fields')) {
	function whcom_render_server_specific_fields($index = -1)
	{
		$index_append = ($index > -1) ? '[' . $index . ']' : '';
		ob_start(); ?>
		<div class="whcom_server_config">
			<div class="whcom_server_config_option whcom_form_field whcom_form_field_horizontal">
				<label for="inputHostname" class="main_label">Hostname</label>
				<input type="text" name="hostname<?php echo $index_append; ?>" class="whcom_op_input wcop_input" id="inputHostname" value="" placeholder="servername.yourdomain.com">
			</div>
			<div class="whcom_server_config_option whcom_form_field whcom_form_field_horizontal">
				<label for="inputRootpw" class="main_label">Root Password</label>
				<input type="password" name="rootpw<?php echo $index_append; ?>" class="" id="inputRootpw" value="">
			</div>
			<div class="whcom_server_config_option whcom_form_field whcom_form_field_horizontal">
				<label for="inputNs1prefix" class="main_label">NS1 Prefix</label>
				<input type="text" name="ns1prefix<?php echo $index_append; ?>" class="" id="inputNs1prefix" value="" placeholder="ns1">
			</div>
			<div class="whcom_server_config_option whcom_form_field whcom_form_field_horizontal">
				<label for="inputNs2prefix" class="main_label">NS2 Prefix</label>
				<input type="text" name="ns2prefix<?php echo $index_append; ?>" class="" id="inputNs2prefix" value="" placeholder="ns2">
			</div>
		</div>


	<?php
		$return_html = ob_get_clean();

		return $return_html;
	}
}

if (!function_exists('whcom_render_product_domain_config_fields')) {
	function whcom_render_product_domain_config_fields($domain = '', $type = 'register', $cart_index = '-1')
	{
		if (empty($domain)) {
			return '';
		}

		$domain = whcom_get_domain_clean($domain);
		$type = ($type == 'transfer') ? 'transfer' : 'register';
		$tld = whcom_get_tld_from_domain($domain);
		$tld_details = whcom_get_tld_details($tld);
		$tld_prices = [];
		if (!empty($tld_details[$type . '_price'])) {
			foreach ($tld_details[$type . '_price'] as $dur => $price) {
				if ($price >= 0) {
					$tld_prices[$dur] = $price;
				}
			}
		}

		$cart_item = whcom_get_cart_item($cart_index);
		$domain_duration = (!empty($cart_item) && !empty($cart_item['regperiod'])) ? '' : $cart_item['regperiod'];

		ob_start(); ?>
		<div class="whcom_product_domain">
			<input type="hidden" name="domain" value="<?php echo $domain; ?>">
			<input type="hidden" name="domaintype" value="<?php echo $type; ?>">
			<?php if ($cart_index > -1) {
				echo '<input type="hidden" name="cart_index" value="' . $cart_index . '">';
			} ?>
			<div class="whcom_form_field whcom_form_field_horizontal">
				<label class="main_label"><?php esc_html_e('Domain Duration', 'whcom') ?></label>
				<select name="regperiod" class="whcom_op_input" title="Domain Duration">
					<?php
					$c = 0;
					foreach ($tld_prices as $dur => $det) {
						$selected = (($c == 0) && empty($domain_duration)) ? 'selected' : '';
						if ($dur == $domain_duration) {
							$selected = 'selected';
						}
						$dur_txt = esc_html__('For', 'whcom') . 'Me';
						$dur_txt .= ' ' . $dur . ' ';
						$dur_txt .= ($dur == 1) ? esc_html__('Year', 'whcom') : esc_html__('Years', 'whcom');
						echo '<option value="' . $dur . '" ' . $selected . '>' . whcom_format_amount($det) . ' ' . $dur_txt . '</option>';
						if ($type == 'transfer') {
							break;
						}
						$c++;
					}
					?>
				</select>
			</div>
			<?php echo whcom_render_tld_specific_addons($tld, $cart_index, $type) ?>
			<?php if ($type == 'register') {
				echo whcom_render_tld_specific_fields($tld, $cart_index);
			} ?>
		</div>

	<?php
		return ob_get_clean();
	}
}

if (!function_exists('whcom_render_product_domain_dropdown')) {
	function whcom_render_product_domain_dropdown($options = [])
	{
		$type = !empty($options['domaintype']) ? $options['domaintype'] : 'register';
		$domain = !empty($options['domain']) ? $options['domain'] : '';
		$cart_index = !empty($options['cart_index']) ? $options['cart_index'] : '';
		$pid = !empty($options['pid']) ? $options['pid'] : 0;
		$domain_duration = !empty($options['regperiod']) ? $options['regperiod'] : 0;


		$domain = whcom_get_domain_clean($domain);
		$tld = whcom_get_tld_from_domain($domain);
		$tld_details = whcom_get_tld_details($tld);
		$product = whcom_get_product_details($pid);

		if (empty($domain) || empty($product)) {
			return '';
		}


		$tld_prices = [];
		if (!empty($tld_details[$type . '_price'])) {
			foreach ($tld_details[$type . '_price'] as $dur => $price) {
				if ($price >= 0) {
					$tld_prices[$dur] = $price;
				}
			}
		}

		$cart_item = whcom_get_cart_item($cart_index);
		if (!empty($cart_item) && !empty($cart_item['regperiod'])) {
			$domain_duration = $cart_item['regperiod'];
		}

		ob_start(); ?>

		<?php whcom_ppa($options); ?>
		<?php whcom_ppa($product); ?>
		<div class="whcom_product_domain">
			<input type="hidden" name="domain" value="<?php echo $domain; ?>">
			<input type="hidden" name="domaintype" value="<?php echo $type; ?>">
			<?php if ($cart_index > -1) {
				echo '<input type="hidden" name="cart_index" value="' . $cart_index . '">';
			} ?>
			<div class="whcom_form_field whcom_form_field_horizontal">
				<label class="main_label"><?php esc_html_e('Domain Duration', 'whcom') ?></label>
				<select name="regperiod" class="whcom_op_input" title="Domain Duration">
					<?php
					$c = 0;
					foreach ($tld_prices as $dur => $det) {
						$selected = (($c == 0) && empty($domain_duration)) ? 'selected' : '';
						if ($dur == $domain_duration) {
							$selected = 'selected';
						}
						$dur_txt = esc_html__('For', 'whcom') . ' ';
						$dur_txt .= ' ' . $dur . ' ';
						$dur_txt .= ($dur == 1) ? esc_html__('Year', 'whcom') : esc_html__('Years', 'whcom');
						echo '<option value="' . $dur . '" ' . $selected . '>' . whcom_format_amount($det) . ' ' . $dur_txt . '</option>';
						if ($type == 'transfer') {
							break;
						}
						$c++;
					}
					?>
				</select>
			</div>
			<?php echo whcom_render_tld_specific_addons($tld, $cart_index, $type) ?>
			<?php if ($type == 'register') {
				echo whcom_render_tld_specific_fields($tld, $cart_index);
			} ?>
			<div class="whcom_product_domain_notices">
				<div class="whcom_product_domain_free_label">
					<span>Domain Free</span>
				</div>
				<div class="whcom_product_domain_free_details">
					<div class="whcom_product_domain_free_durations">
						Domain is free
						for <?php echo whcom_render_free_domain_billingcycles($product['freedomainpaymentterms']); ?>
					</div>
				</div>
			</div>
		</div>

	<?php
		return ob_get_clean();
	}
}

if (!function_exists('whcom_check_domain_function')) {
	function whcom_check_domain_function($args)
	{
		if (isset($args)) {
			$check_type = esc_attr($args['domaintype']);
			if ($check_type == 'existing') {
				$response['message'] = esc_html__("Selected existing domain, so not checking anything", "whcom");
				$response['status'] = 'OK';
			} else {

				$domain = [
					'action' => 'DomainWhois',
					'domain' => esc_attr($args['domain']) . esc_attr($args['ext'])
				];

				$res = whcom_process_api($domain);
				if ($res['result'] != 'success') {
					$response['message'] = $res['message'];
					$response['status'] = 'ERROR';
				} else {
					$response['domain'] = $domain['domain'];
					$response['ext'] = esc_attr($args['ext']);
					$response['domaintype'] = $check_type;

					if ($check_type == 'register') {
						if ($res['status'] != 'available') {
							$response['message'] = esc_html__('Domain is not available for registration...');
							$response['status'] = 'ERROR';
						} else {
							$response['message'] = esc_html__('Domain is available...');
							$response['status'] = 'OK';
						}
					} else if ($check_type == 'transfer') {
						if ($res['status'] != 'available') {
							$response['message'] = esc_html__('Yes, domain is registered, proceed with transfer');
							$response['status'] = 'OK';
						} else {
							$response['message'] = esc_html__('Domain is not registered...');
							$response['status'] = 'ERROR';
						}
					}
				}
			}
		} else {
			$response['message'] = esc_html__("Something went wrong, kindly try again later ...", "whcom");
			$response['status'] = 'ERROR';
		}

		return $response;
	}
}

if (!function_exists('whcom_op_generate_current_product_summery_function')) {
	function whcom_op_generate_current_product_summery_function($product_array = [])
	{
		$summary_html = [];
		ob_start();
		include WHCOM_PATH . '/shortcodes/order_process/02_product_sidebar.php';
		ob_end_clean();

		return $summary_html;
	}
}

if (!function_exists('whcom_op_get_current_domain_details')) {
	function whcom_op_get_current_domain_details($domain = '', $type = 'register', $regperiod = '1', $product, $billingcycle)
	{
		$response = [
			'is_free' => false
		];
		$billingcycle = (string)$billingcycle;
		$domain = whcom_get_domain_clean($domain);
		$tld = whcom_get_tld_from_domain($domain);
		$tld_details = whcom_get_tld_details($tld);
		$regperiod = esc_attr($regperiod);
		$product = (!empty($product) && is_array($product)) ? $product : whcom_get_product_details((int)$product);
		$freedomain = ((string)$product['freedomain'] == 'on' || (string)$product['freedomain'] == 'once') ? true : false;
		$freedomaintlds = explode(',', (string)$product['freedomaintlds']);
		$freedomainpaymentterms = explode(',', (string)$product['freedomainpaymentterms']);
		if (($freedomain) && in_array($tld, $freedomaintlds) && in_array($billingcycle, $freedomainpaymentterms)) {
			$response['is_free'] = true;
		}
		foreach ($tld_details[$type . '_price'] as $dur => $prc) {
			if (isset($response['is_free'])) {
				//                $response['domain_price'] = 0.00;
				//                $response['domain_duration'] = 0.00;
				//                $response['domain_type'] = ($type == 'register') ? esc_html__('Registration For', 'whcom') : esc_html__('Transfer For', 'whcom');
				//                $response['domain_duration'] .= ((int)$dur == 1) ? esc_html__(' Year', 'whcom') : esc_html__(' Years', 'whcom');
				break;
			} else {
				$response['domain_duration'] = $dur;
				$response['domain_duration'] .= ((int)$dur == 1) ? esc_html__(' Year', 'whcom') : esc_html__(' Years', 'whcom');
				$response['domain_price'] = $prc;
				$response['domain_type'] = ($type == 'register') ? esc_html__('Registration For', 'whcom') : esc_html__('Transfer For', 'whcom');
				if ($dur == $regperiod) {
					break;
				}
			}
		}

		return $response;
	}
}

if (!function_exists('whcom_render_tos_fields')) {
	function whcom_render_tos_fields($style = "")
	{
		$required_fields = whcom_get_client_required_fields();
		ob_start(); ?>
		<?php if ($required_fields['accepttos']) { ?>
			<?php if ($style == '08_elegant') { ?>
				<div class="whcom_form_field">
					<div class="whcom_panel_body">
						<label class="checkbox whcom_checkbox">
							<input type="checkbox" name="accepttos" class="accepttos" <?php echo ($required_fields['accepttos']) ? '' : ''; ?>>
							<?php esc_html_e("I have read and agree to the", "whcom") ?>
							<a href="<?php echo $required_fields['tos_link']; ?>" target="_blank"><u><?php esc_html_e("Terms of Service", "whcom") ?></u></a> </label>
					</div>

				</div>
			<?php } else { ?>
				<div class="whcom_form_field">
					<div class="whcom_panel whcom_panel_danger whcom_panel_fancy_1">
						<div class="whcom_panel_header">
							<span class="panel-title">
								<i class="whcom_icon_attention"></i>
								<?php esc_html_e("Terms of Service", "whcom") ?>
							</span>
						</div>
						<div class="whcom_panel_body">
							<label class="checkbox whcom_checkbox">
								<input type="checkbox" name="accepttos" class="accepttos" <?php echo ($required_fields['accepttos']) ? 'required="required"' : ''; ?>>
								<?php esc_html_e("I have read and agree to the", "whcom") ?>
								<a href="<?php echo $required_fields['tos_link']; ?>" target="_blank"><?php esc_html_e("Terms of Service", "whcom") ?></a> </label>
						</div>
					</div>
				</div>
		<?php }
		} ?>
	<?php
		return ob_get_clean();
	}
}

if (!function_exists('whcom_generate_domain_text')) {
	function whcom_generate_domain_text($tld, $type, $duration, $free_domain = false, $cart_index = -1)
	{
		$response = [
			'price' => 0.00,
			'text' => ''
		];
		$domain = (!empty($tld) && is_array($tld)) ? $tld : whcom_get_tld_details($tld);
		$tld_register_prices = $tld_transfer_prices = $tld_renew_prices = [];
		if ($type == 'register') {

			foreach ($domain['register_price'] as $ry => $rp) {
				if ($free_domain) {
					$rp = 0.00;
				}
				$tld_register_prices[] = [
					'duration' => $ry,
					'price' => $rp,
				];
				if ($free_domain && $cart_index >= 0) {
					whcom_add_update_cart_item(['regperiod' => $ry], $cart_index);
					break;
				}
			}
			foreach ($tld_register_prices as $dur) {
				$dur_txt = esc_html__('For ', 'whcom');
				$dur_txt .= $dur['duration'];
				$dur_txt .= ($dur['duration'] == 1) ? esc_html__(' Year', 'whcom') : esc_html__(' Years', 'whcom');
				if ($dur['price'] < 0) {
					continue;
				}
				$response['text'] = $dur_txt;
				$response['price'] = $dur['price'];
				if ((int)$dur['duration'] == (int)$duration) {
					break;
				}
			}
		}
		if ($type == 'transfer') {
			foreach ($domain['transfer_price'] as $ty => $tp) {
				if ($free_domain) {
					$tp = 0.00;
				}
				$tld_transfer_prices[] = [
					'duration' => $ty,
					'price' => $tp,
				];
				if ($free_domain) {
					whcom_add_update_cart_item(['regperiod' => $ty], $cart_index);
					break;
				}
			}
			foreach ($tld_transfer_prices as $dur) {
				$dur_txt = esc_html__('For ', 'whcom');
				$dur_txt .= $dur['duration'];
				$dur_txt .= ($dur['duration'] == 1) ? esc_html__(' Year', 'whcom') : esc_html__(' Years', 'whcom');
				if ($dur['price'] < 0) {
					continue;
				}
				$response['text'] = $dur_txt;
				$response['price'] = $dur['price'];
				break;
			}
		}
		if ($type == 'renew') {
			$free_domain = false;
			foreach ($domain['renew_price'] as $ty => $tp) {
				$tld_renew_prices[] = [
					'duration' => $ty,
					'price' => $tp,
				];
			}
			foreach ($tld_renew_prices as $dur) {
				$dur_txt = esc_html__('For ', 'whcom');
				$dur_txt .= $dur['duration'];
				$dur_txt .= ($dur['duration'] == 1) ? esc_html__(' Year', 'whcom') : esc_html__(' Years', 'whcom');
				if ($dur['price'] < 0) {
					continue;
				}
				$response['text'] = $dur_txt;
				$response['price'] = $dur['price'];
				if ((int)$dur['duration'] == (int)$duration) {
					break;
				}
			}
		}

		return $response;
	}
}

if (!function_exists('whcom_generate_cart_summaries')) {
	function whcom_generate_cart_summaries()
	{
		$summary_html = [];
		ob_start();
		include WHCOM_PATH . '/shortcodes/order_process/03_summary_generator.php';
		ob_end_clean();

		return $summary_html;
	}
}

if (!function_exists('whcom_op_render_promo_form')) {
	function whcom_op_render_promo_form()
	{
		$current_promo = whcom_get_current_promo();
		ob_start(); ?>

		<?php if (empty($current_promo)) { ?>
			<form action="" method="post" class="whcom_op_promo_code_form">
				<input type="hidden" name="action" value="whcom_op">
				<input type="hidden" name="whcom_op_what" value="apply_remove_promo_code">
				<div class="whcom_form_field whcom_margin_bottom_0">
					<input type="text" name="promocode" placeholder="<?php esc_html_e("Enter Promo Code if you have one", "whcom") ?>" required>
				</div>
				<div class="whcom_form_field">
					<button type="submit" class="whcom_button_block whcom_button_secondary">
						<?php esc_html_e("Validate Code", "whcom") ?> <i class="whcom_icon_angle-double-right"></i>
					</button>
				</div>
			</form>
		<?php } else { ?>
			<form action="" method="post" class="whcom_op_promo_code_form">
				<input type="hidden" name="action" value="whcom_op">
				<input type="hidden" name="whcom_op_what" value="apply_remove_promo_code">
				<input type="hidden" name="promocode" value="to_unset_string">
				<div class="whcom_alert">
					<?php echo whcom_generate_promo_applied_text($current_promo) ?>
				</div>
				<div class="whcom_form_field">
					<button type="submit" class="whcom_button_block whcom_button_secondary">
						<?php esc_html_e("Remove Promotion Code", "whcom") ?> <i class="whcom_icon_angle-double-right"></i>
					</button>
				</div>
			</form>
		<?php } ?>
	<?php
		return ob_get_clean();
	}
}

if (!function_exists('whcom_op_render_estimate_taxes')) {
	function whcom_op_render_estimate_taxes()
	{
		ob_start();
		$countries = whcom_get_countries_array(); ?>
		<form action="" method="post" class="whcom_op_promo_code_form">
			<input type="hidden" name="action" value="whcom_op">
			<input type="hidden" name="whcom_op_what" value="estimate_taxes">
			<!-- Country -->
			<div class="whcom_form_field whcom_form_field_horizontal">
				<label for="country"><?php esc_html_e('Country', "whcom") ?></label>

				<select id="country" name="country">
					<?php
					foreach ($countries as $code => $country) {
						$selected = ($code == $_SESSION['whcom_tax_default_country']) ? 'selected="selected"' : '';
						echo '<option value="' . $code . '" ' . $selected . '>' . $country . '</option>';
					}
					?>
				</select>
			</div>
			<!-- State -->
			<div class="whcom_form_field whcom_form_field_horizontal">
				<label for="stateselect"><?php esc_html_e('State', "whcom") ?></label>
				<input type="text" id="stateinput" value="<?php echo $_SESSION['whcom_tax_default_state']; ?>" style="display: none;" placeholder="<?php esc_html_e('State/Region', 'whcom') ?>" title="<?php esc_html_e('State/Region', 'whcom') ?>">
				<select name="state" id="stateselect">
					<option value="">—</option>
				</select>
			</div>
			<div class="whcom_form_field whcom_text_center">
				<button type="submit" class="whcom_button_secondary">
					<?php esc_html_e("Update Totals", "whcom") ?>
				</button>
			</div>
		</form>
		<?php
		return ob_get_clean();
	}
}

if (!function_exists('whcom_generate_promo_applied_text')) {
	function whcom_generate_promo_applied_text($promo)
	{
		$current_promo = (is_array($promo)) ? $promo : whcom_get_promotion($promo);
		$promo_text = '';
		if (!empty($current_promo)) { ?>
			<?php echo $current_promo['code']; ?>
			-
			<?php if ($current_promo['type'] == 'Free Setup') { ?>
				<?php echo $current_promo['type']; ?>
			<?php } else if ($current_promo['type'] == 'Percentage') { ?>
				<?php echo $current_promo['value']; ?>%
			<?php } else { ?>
				<?php echo whcom_format_amount($current_promo['value']) ?>
				<?php echo $current_promo['type']; ?>
			<?php } ?>

			<?php if ($current_promo['recurring'] == '1') { ?>
				<?php esc_html_e('Recurring Discount', 'whcom') ?>
			<?php } else { ?>
				<?php esc_html_e('One Time Discount', 'whcom') ?>
			<?php } ?>
		<?php }

		return $promo_text;
	}
}

if (!function_exists('whcom_generate_invoice_iframe')) {
	function whcom_generate_invoice_iframe($invoice_id, $redirect_link = '#')
	{
		$args = [
			'goto' => "viewinvoice.php?wcap_no_redirect=1&id=" . (int)$invoice_id,
		];
		$url = whcom_generate_auto_auth_link($args);
		$redirect_link = '<a class="whcom_op_thickbox_redirect_overlay" href="' . $redirect_link . '">' . esc_html__('Close', "whcom") . '</a> ';
		$invoice_div = '<div style="position: relative; height: 80vh; max-height: 700px; width: 850px; margin: 0 auto;"><iframe style="width: 100%; height: 100%; overflow: auto;" src="' . $url . '"></iframe>' . $redirect_link . '</div>';

		return $invoice_div;
	}
}

if (!function_exists('whcom_render_continue_shopping_url')) {
	function whcom_render_continue_shopping_url()
	{
		$return_html = '';
		if (defined('WCOP_VERSION') && !empty(get_option('continue_shopping' . whcom_get_current_language(), ''))) {
			$return_html = '<a href="' . get_option('continue_shopping' . whcom_get_current_language(), '') . '">' . esc_html__('Continue Shopping', 'whcom') . '</a>';
		} else if (defined('WCAP_VERSION') && !empty(get_option('wcapfield_client_area_url' . whcom_get_current_language(), ''))) {
			$return_html = '<a href="' . get_option('wcapfield_client_area_url' . whcom_get_current_language(), '') . '">' . esc_html__('Continue Shopping', 'whcom') . '</a>';
		}

		return $return_html;
	}
}

if (!function_exists('whcom_get_cart_url')) {
	function whcom_get_cart_url()
	{
		$return_html = '#';
		if (defined('WCOP_VERSION') && !empty(get_option('configure_product' . whcom_get_current_language(), ''))) {
			$return_html = get_option('configure_product' . whcom_get_current_language(), '') . '?a=view';
		} else if (defined('WCAP_VERSION') && !empty(get_option('wcapfield_client_area_url' . whcom_get_current_language(), ''))) {
			$return_html = get_option('wcapfield_client_area_url' . whcom_get_current_language()) . '?whmpca=order_process&a=view';
		}

		return $return_html;
	}
}

if (!function_exists('whcom_get_checkout_url')) {
	function whcom_get_checkout_url()
	{
		$return_html = '#';
		if (defined('WCOP_VERSION') && !empty(get_option('configure_product' . whcom_get_current_language(), ''))) {
			$return_html = get_option('configure_product' . whcom_get_current_language(), '') . '?a=checkout';
		} else if (defined('WCAP_VERSION') && !empty(get_option('wcapfield_client_area_url' . whcom_get_current_language(), ''))) {
			$return_html = get_option('wcapfield_client_area_url' . whcom_get_current_language()) . '?whmpca=order_process&a=checkout';
		}

		return $return_html;
	}
}

if (!function_exists('whcom_render_order_complete_message')) {
	function whcom_render_order_complete_message($redirect_link, $invoice_link)
	{
		ob_start(); ?>
		<div class="whcom_order_complete_message">

			<div class="whcom_alert whcom_alert_success whcom_margin_bottom_45">
				<?php $field = 'whcom_order_complete_message_' . whcom_get_current_language() ?>
				<?php if (!empty(get_option($field, ''))) { ?>
					<?php $custom_message = get_option($field, '');
					$get_invoice_id = $_SESSION['get_invoice_id'];
					$invoice_details = whcom_get_invoice_number($get_invoice_id);
					$search = [
						'{{invoice_id}}',
						'{{payment_method}}',
						'{{total_price}}',
						'{{user_id}}'
					];
					$replace = [
						$invoice_details['invoiceid'],
						$invoice_details['paymentmethod'],
						$invoice_details['total'],
						$invoice_details['userid'],
					];
					$final_message = str_replace($search, $replace, $custom_message);
					echo $final_message;
					?>
				<?php } else { ?>
					<?php esc_html_e("Your order has been placed, it will be activated once the invoice is paid. If you have just paid the invoice, ignore this message", "whcom"); ?>
				<?php } ?>
			</div>

			<?php $field = 'whcom_conversion_tracking_code' ?>
			<?php echo get_option($field, ''); ?>
			<div class="whcom_row">
				<div class="whcom_col_sm_6 whcom_text_center whcom_text_right_sm whcom_margin_bottom_15">
					<?php echo $redirect_link; ?>
				</div>
				<div class="whcom_col_sm_6 whcom_text_center whcom_text_left_sm whcom_margin_bottom_15">
					<?php echo $invoice_link; ?>
				</div>
			</div>
		</div>
<?php return ob_get_clean();
	}
}
