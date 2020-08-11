<?php
/**~~
 * Set Group Options in Detail
 *
 */

//~~ Get row for edit
$row = $wpdb->get_row( "SELECT * FROM `" . whmp_get_group_table_name() . "` WHERE `id`=" . $_GET["edit"] );
?>

<form action="?page=wpct-groups&edit=<?php echo $row->id ?>" method="post">
<h3>
	Manage settings for <strong style="color: #0085ba;"><?php echo $row->name ?></strong>
	<input style="float: right; margin-left: 10px" type="submit" value="<?php esc_html_e('Save Group Options', 'wpct')?>" class="button button-primary">
	<a href="?page=wpct-groups&plans=<?php echo $row->id?>" class="button button-primary" style="float: right; margin-left: 10px">
		Group Plans
	</a>
	<a href="?page=wpct-groups" class="button button-primary" style="float: right;">
		<span class="lnr lnr-arrow-left"></span> Back to List
	</a>
	<div style="clear: both"></div>
</h3>


<?php
/**~~ Data is submitted and handled on groups page,
 * TODO: Data editing should be moved to same page in future.
 */
?>

	<input type="hidden" name="id" value="<?php echo $row->id ?>"/>
	<div class="wpct_admin_row">
		<div class="wpct_admin_column-6">
			<table class="wpct_admin_pretty_table" id="table">
				<tr class="table-heading2">
					<th colspan="2"><?php esc_html_e('General Options', 'wpct')?></th>
				</tr>
				<tr>
					<td style="width: 40%">
						<label for="gname"><?php esc_html_e('Group Name:', 'wpct')?></label>
					</td>
					<td style="width: 60%"><input type="text" required="required" value="<?php echo $row->name ?>"
					                              name="name" id="gname" placeholder="<?php esc_html_e('Group Name', 'wpct')?>"/></td>
				</tr>
				<tr>
					<td>
						<?php esc_html_e('Group Description', 'wpct')?><br>
						<small>
							<em>
								<?php esc_html_e('Note: This description is not visible on front-end...', 'wpct')?>
							</em>
						</small>
					</td>
					<td colspan="3"><textarea style="width: 100%;height:75px" placeholder="<?php esc_html_e('Group Notes', 'wpct')?>" id="gdesc"
					                          name="description"><?php echo $row->description ?></textarea></td>
				</tr>
				<tr>
					<td><label for="description_separator"><?php esc_html_e('Description Separator', 'wpct')?></label></td>
					<td><input
							value="<?php echo empty( $row->description_separator ) ? ":" : $row->description_separator; ?>"
							name="description_separator" id="description_separator" placeholder="<?php esc_html_e('Description separator', 'wpct')?>">
					</td>
				</tr>
				
				<tr>
					<td><label for="ribbon_text"><?php esc_html_e('Highlight text for featured plan', 'wpct')?></label></td>
					<td><input name="ribbon_text" id="ribbon_text" value="<?php echo $row->ribbon_text == "" ? esc_html_e('Most Popular', 'wpct') : $row->ribbon_text;?>"></td>
				</tr>
				<tr>
					<td><label for="button_text"><?php esc_html_e('Button Text', 'wpct')?></label></td>
					<td><input value="<?php echo $row->button_text == "" ? "Buy Now" : $row->button_text; ?>"
					           name="button_text" id="button_text" placeholder="<?php esc_html_e('Buy Now', 'wpct')?>"></td>
				</tr>
				<tr class="table-heading2">
					<th colspan="2">
						<?php esc_html_e('Convert YES/NO (beta)', 'wpct')?>
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('Replace YES/NO with these fontawsome classes. For example if you want to show thumbs up for YES, use fa-thumbs-upFor more information on fontawsome icons and fontawesome visit: ', 'wpct')?>
								<a href="http://fontawesome.io/icons/"><?php esc_html_e('Font Awesome Icons', 'wpct')?></a>
							</em>
						</small>
					</td>
				</tr>
				<tr>
					<td>
						<label for="convert_to_symbol"><?php esc_html_e('Convert Yes/NO values to icons.', 'wpct')?></label></td>
					<td>
						<select name="convert_to_symbol" id="convert_to_symbol">
							<option value="0">No</option>
							<option <?php echo $row->convert_to_symbol == "1" ? "selected=selected" : "" ?> value="1">
								Yes
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="convert_yes_with"><?php esc_html_e('Convert Yes with', 'wpct')?></label></td>
					<td><input value="<?php echo $row->convert_yes_with == "" ? "fa-check" : $row->convert_yes_with; ?>"
					           name="convert_yes_with" id="convert_yes_with" placeholder="fa-check"></td>
				</tr>
				<tr>
					<td><label for="convert_no_with"><?php esc_html_e('Convert No with', 'wpct')?></label></td>
					<td><input value="<?php echo $row->convert_no_with == "" ? "fa-close" : $row->convert_no_with; ?>"
					           name="convert_no_with" id="convert_no_with" placeholder="fa-check"></td>
				</tr>
				
				<tr>
					<td><label for="enable_tooltips"><?php esc_html_e('Enable Tooltips (beta)', 'wpct')?></label></td>
					<td><select name="enable_tooltips" id="enable_tooltips">
							<option value="0">No</option>
							<option <?php echo $row->enable_tooltips == "1" ? "selected=selected" : "" ?> value="1">
								Yes
							</option>
						</select></td>
				</tr>
				
			
			</table>
		</div>
		<div class="wpct_admin_column-6">
			<table class="wpct_admin_pretty_table" id="table">
				
				
				<tr class="table-heading2">
					<th colspan="2"><?php esc_html_e('Billing Cycle', 'wpct')?></th>
				</tr>
				<tr>
					<td><label for="billingcycle">Select billing cycle:</label></td>
					<td><select name="billingcycle" id="billingcycle">
							<option value="annually">Annually</option>
							<option <?php echo $row->billingcycle == "monthly" ? "selected=selected" : "" ?>
								value="monthly">Monthly/One Time
							</option>
							<option <?php echo $row->billingcycle == "quarterly" ? "selected=selected" : "" ?>
								value="quarterly">Quarterly
							</option>
							<option <?php echo $row->billingcycle == "semiannually" ? "selected=selected" : "" ?>
								value="semiannually">Semi Annually
							</option>
							<option <?php echo $row->billingcycle == "biennially" ? "selected=selected" : "" ?>
								value="biennially">Biennially
							</option>
							<option <?php echo $row->billingcycle == "triennially" ? "selected=selected" : "" ?>
								value="triennially">Triennially
							</option>
						</select></td>
				</tr>
				<tr>
					<td>
						<label for="billingcycle2"><?php esc_html_e('Secondary billing cycle (beta):', 'wpct')?></label>
						<small style="display: block; font-style: italic">
							<?php esc_html_e('It should be longer than Primary billing cycle and required if you want to show discount.', 'wpct');?>
						</small>
					</td>
					<td><select name="billingcycle2" id="billingcycle2">
							<option value="none">None</option>
							<option <?php echo $row->billingcycle2 == "annually" ? "selected=selected" : "" ?>
								value="annually">Annually
							</option>
							<option <?php echo $row->billingcycle2 == "monthly" ? "selected=selected" : "" ?>
								value="monthly">Monthly
							</option>
							<option <?php echo $row->billingcycle2 == "quarterly" ? "selected=selected" : "" ?>
								value="quarterly">Quarterly
							</option>
							<option <?php echo $row->billingcycle2 == "semiannually" ? "selected=selected" : "" ?>
								value="semiannually">Semi Annually
							</option>
							<option <?php echo $row->billingcycle2 == "biennially" ? "selected=selected" : "" ?>
								value="biennially">Biennially
							</option>
							<option <?php echo $row->billingcycle2 == "triennially" ? "selected=selected" : "" ?>
								value="triennially">Triennially
							</option>
						</select></td>
				</tr>
<!--				<tr>
					<td><label for="currency"><?php /*esc_html_e('Select currency:', 'wpct')*/?></label></td>
					<td><select name="currency" id="currency">
							<option value="0">== Default ==</option>
							<?php /*$Q = "SELECT * FROM `" . whmp_get_currencies_table_name() . "`";
							$currs   = $wpdb->get_results( $Q );
							foreach ( $currs as $curr ): $S = $row->currency == $curr->id ? "selected=selected" : ""; */?>
								<option <?php /*echo $S */?>
									value="<?php /*echo $curr->id */?>"><?php /*echo $curr->code . " " . $curr->prefix . " " . $curr->suffix; */?></option>
							<?php /*endforeach; */?>
						</select></td>
				</tr>-->
				
				<tr class="table-heading2">
					<th colspan="2">
						<?php esc_html_e('Up-Sell Discount', 'wpct')?>
					</th>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('Discount feature assumes customer pays less for longer durations.', 'wpct');?>
								<?php esc_html_e('You must select secondary billing cycle if you want to use discount feature.', 'wpct');?>
							</em>
						</small>
					</td>
				</tr>
				<tr>
					<td>
						<label for="show_discount">Show Discount:</label>
					</td>
					<td>
						<select name="show_discount" id="show_discount">
							<option <?php echo $row->show_discount == "no" ? "selected=selected" : "" ?> value="no">No
							</option>
							<option <?php echo $row->show_discount == "percentage" ? "selected=selected" : "" ?>
								value="percentage">Percentage (%)
							</option>
							<option <?php echo $row->show_discount == "amount" ? "selected=selected" : "" ?>
								value="amount">Amount
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="show_discount_banner"><?php esc_html_e('Show Discount Banner:', 'wpct')?></label><br>
						<small>
							<em>
								<?php esc_html_e('This big, bold text is shown just above the duration selection button. ', 'wpct')?>
							</em>
						</small>
					</td>
					<td>
						<select name="show_discount_banner" id="show_discount_banner">
							<option <?php echo $row->show_discount_banner == "no" ? "selected=selected" : "" ?>
								value="no"><?php esc_html_e('No', 'wpct')?>
							</option>
							<option <?php echo $row->show_discount_banner == "yes" ? "selected=selected" : "" ?>
								value="yes"><?php esc_html_e('Yes', 'wpct')?>
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="show_discount_secondary"><?php esc_html_e('Show Discount for Secondary Billing Cycle:', 'wpct')?></label>
					</td>
					<td>
						<select name="show_discount_secondary" id="show_discount_secondary">
							<option <?php echo $row->show_discount_secondary == "no" ? "selected=selected" : "" ?>
								value="no"><?php esc_html_e('No', 'wpct')?>
							</option>
							<option <?php echo $row->show_discount_secondary == "yes" ? "selected=selected" : "" ?>
								value="yes"><?php esc_html_e('Yes', 'wpct')?>
							</option>
						</select>
					</td>
				</tr>
				
				<tr class="table-heading2">
					<th colspan="2"><?php esc_html_e('Others (beta)', 'wpct')?></th>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('These features are not available in all templates and short-codes. These depends on template design mostly...', 'wpct');?>
							</em>
						</small>
					</td>
				</tr>
				<tr>
					<td><label for="decimals">Decimals:</label></td>
					<td><select name="decimals" id="decimals">
							<?php for ( $x = 0; $x <= 3; $x ++ ): $S = $x == $row->decimals ? "selected=selected" : ""; ?>
								<option <?php echo $S ?> value="<?php echo $x ?>"><?php echo $x ?></option>
							<?php endfor; ?>
						</select></td>
				</tr>
				<tr>
					<td><label for="duration_style">Duration Style:</label></td>
					<td>
						<select name="duration_style" id="duration_style">
							<option value="duration" <?php echo strtolower( $row->duration_style ) == "duration" ? "selected=selected" : ""; ?>><?php _e( "Default", "whmpress" ) ?></option>
							<option value="long" <?php echo strtolower( $row->duration_style ) == "long" ? "selected=selected" : ""; ?>><?php _e( "Long (year)", "whmpress" ) ?></option>
							<option value="short" <?php echo strtolower( $row->duration_style ) == "short" ? "selected=selected" : ""; ?>><?php _e( "Short (yr)", "whmpress" ) ?></option>
							<option value="monthly" <?php echo strtolower( $row->duration_style ) == "monthly" ? "selected=selected" : ""; ?>><?php _e( "Convert to Months (12 month)", "whmpress" ) ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="duration_connector"><?php esc_html_e('Convert No with', 'wpct')?></label></td>
					<td><input value="<?php echo $row->duration_connector == "" ? "/" : $row->duration_connector; ?>"
					           name="duration_connector" id="duration_connector" placeholder="/"></td>
				</tr>
			
			</table>
		</div>
	</div>
	<div class="wpct_admin_row">
		<div class="wpct_admin_column-4">
			<table class="wpct_admin_pretty_table">
				<tr class="table-heading2">
					<th colspan="2">Comparison Table Options</th>
				</tr>
				<tr>
					<?php $files = $this->get_template_files("whmpress_comparison_table");
					//wpct_pretty_print($files);
					//die;
					?>
					
					<td>
						<label for="template_file">Select template file:</label>
					</td>
					<td>
						<select name="template_file" id="template_file">
							<option value="">== Template File ==</option>
							<?php foreach ( $files as $file ): $S = ( basename( $file ) == $row->template_file ) ? "selected=selected" : ""; ?>
								<option <?php echo $S ?>
									value="<?php echo basename( $file ) ?>"><?php echo basename( $file ) ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr id="template_file_info" style="display: none">
					<td colspan="2">
					
					</td>
				</tr>
				<tr>
					<td><label for="rows_comparison">Number of Rows for Features:</label></td>
					<td>
                    <input name="rows_comparison" type="number" value="<?php echo !empty($row->rows_comparison) ? $row->rows_comparison : '50';?>">
						<!--<select name="rows_comparison" id="rows-comparison">
							<option value="50">== All ==</option>
							<?php /*for ( $x = 1; $x <= 50; $x ++ ): $S = $x == $row->rows_comparison ? "selected=selected" : ""; */?>
								<option <?php /*echo $S */?> value="<?php /*echo $x */?>"><?php /*echo $x */?></option>
							<?php /*endfor; */?>
						</select>-->
					</td>
				</tr>
				<tr>
					<td><label for="hide_width_comparison"><?php esc_html_e('Hide Comparison Table below', 'wpct')?></label></td>
					<td><input name="hide_width_comparison" type="number" min="0" max="1200" value="<?php echo $row->hide_width_comparison;?>"> px</td>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('Select width on which you want to hide comparison table', 'wpct')?>
							</em>
						</small>
					</td>
				</tr>
			</table>
		</div>
		<div class="wpct_admin_column-4">
			<table class="wpct_admin_pretty_table">
				<tr class="table-heading2">
					<th colspan="2">Slider Options</th>
				</tr>
				<tr>
					<?php $files = $this->get_template_files("whmpress_order_slider"); ?>
					<td><label for="slider_template_file">Select template file:</label></td>
					<td>
						<select name="slider_template_file" id="slider_template_file">
							<option value="">== Template File ==</option>
							<?php foreach ( $files as $file ): $S = ( basename( $file ) == $row->slider_template_file ) ? "selected=selected" : ""; ?>
								<option <?php echo $S ?>
									value="<?php echo basename( $file ) ?>"><?php echo basename( $file ) ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr id="slider_template_file_info" style="display: none">
					<td colspan="2">
					
					</td>
				</tr>
				<tr>
					<td><label for="rows_slider"><?php esc_html_e('Number of Rows for Slider Features:', 'wpct')?></label></td>
                    <td><input name="rows_slider" type="number" value="<?php echo !empty($row->rows_slider) ? $row->rows_slider : '6';?>"></td>
					<!--<td><select name="rows_slider" id="rows_slider">
							<option value="6">== All ==</option>
							<?php /*for ( $x = 1; $x <= 6; $x ++ ): $S = $x == $row->rows_slider ? "selected=selected" : ""; */?>
								<option <?php /*echo $S */?> value="<?php /*echo $x */?>"><?php /*echo $x */?></option>
							<?php /*endfor; */?>
						</select>
					</td>-->
				</tr>
				<tr>
					<td><label for="hide_width_slider"><?php esc_html_e('Hide Slider below', 'wpct')?></label></td>
					<td><input name="hide_width_slider" type="number" min="0" max="1200" value="<?php echo $row->hide_width_slider;?>"> px</td>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('Select width on which you want to hide slider', 'wpct')?>
							</em>
						</small>
					</td>
				</tr>
			</table>
		</div>
		<div class="wpct_admin_column-4">
			<table class="wpct_admin_pretty_table">
				<tr class="table-heading2">
					<th colspan="2"><?php esc_html_e('Pricing Table Options', 'wpct')?></th>
				</tr>
				<tr>
					<?php $files = $this->get_template_files( "whmpress_pricing_table_group" ); ?>
					<td><label for="pricing_table_template_file"><?php esc_html_e('Select template file:', 'wpct')?></label></td>
					<td>
						<select name="pricing_table_template_file" id="pricing_table_template_file">
							<option value="">== Template File ==</option>
							<?php foreach ( $files as $file ): $S = ( basename( $file ) == $row->pricing_table_template_file ) ? "selected=selected" : ""; ?>
								<option <?php echo $S ?>
									value="<?php echo basename( $file ) ?>"><?php echo basename( $file ) ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr id="pricing_table_template_file_info" style="display: none">
					<td colspan="2">
					
					</td>
				</tr>
				<tr>
					<td><label for="rows_table">Number of Rows for Features:</label></td>
					<td>
                        <input name="rows_table" type="number" value="<?php echo !empty($row->rows_table) ? $row->rows_table : '50';?>">
                        <!--<select name="rows_table" id="rows_table">
							<option value="50">== All ==</option>
							<?php /*for ( $x = 1; $x <= 50; $x ++ ): $S = $x == $row->rows_table ? "selected=selected" : ""; */?>
								<option <?php /*echo $S */?> value="<?php /*echo $x */?>"><?php /*echo $x */?></option>
							<?php /*endfor; */?>
						</select>-->
					</td>
				</tr>
				<tr>
					<td><label for="hide_width_table"><?php esc_html_e('Hide Table Group below', 'wpct')?></label></td>
					<td><input name="hide_width_table" type="number" min="0" max="1200" value="<?php echo $row->hide_width_table;?>"> px</td>
				</tr>
				<tr>
					<td colspan="2">
						<small>
							<em>
								<?php esc_html_e('Select width on which you want to hide table group', 'wpct')?>
							</em>
						</small>
					</td>
				</tr>
				<tr>
					<td><label for="enable_table_dots"><?php esc_html_e('Enable Price Dots (beta)', 'wpct')?></label></td>
					<td>
						<select name="enable_table_dots" id="enable_table_dots">
							<option value="0">No</option>
							<option <?php echo $row->enable_table_dots == "1" ? "selected=selected" : "" ?> value="1">
								Yes
							</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="enable_table_carousel"><?php esc_html_e('Enable Table Carousel (beta)', 'wpct')?></label></td>
					<td>
						<select name="enable_table_carousel" id="enable_table_carousel">
							<option value="0">No</option>
							<option <?php echo $row->enable_table_carousel == "1" ? "selected=selected" : "" ?> value="1">
								Yes
							</option>
						</select>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div style="text-align: center;">
		<input type="submit" value="<?php esc_html_e('Save Group Options', 'wpct')?>" class="button button-primary button-big"/>
	</div>
</form>