<div class="settings-wrap">
	<div id="whmp-default-tabs" class="tab-container">
		<ul class='etabs'>
			<li class='tab'><a href="#Price1"><?php echo esc_html_x( "Price",'admin', "whmpress" ) ?></a></li>
			<li class='tab'><a href="#DomainPrice1"><?php echo esc_html_x( "Domain Price",'admin', "whmpress" ) ?></a></li>
			<li class='tab'><a href="#PriceMatrix"><?php echo esc_html_x( "Price Matrix",'admin', "whmpress" ) ?></a></li>
			<li class='tab'><a href="#PriceMatrixDomain"><?php echo esc_html_x( "Price Matrix Domain",'admin', "whmpress" ); ?></a></li>
			<li class='tab'><a href="#Combo1"><?php echo esc_html_x( "Order Combo",'admin', "whmpress" ); ?></a></li>
			<li class='tab'><a href="#OrderButton"><?php echo esc_html_x( "Order Button",'admin', "whmpress" ); ?></a></li>
			<li class='tab'><a href="#PricingTable"><?php echo esc_html_x( "Pricing Table",'admin', "whmpress" ); ?></a></li>
			<li class='tab'><a href="#DomainSearch"><?php echo esc_html_x( 'Domain Search','admin', 'whmpress' ); ?></a></li>
			<li class='tab'><a href="#DomainSearchAjax"><?php echo esc_html_x( 'Domain Search Ajax','admin', 'whmpress' ); ?></a></li>
			<li class='tab'><a href="#DomainSearchBulk"><?php echo esc_html_x( 'Domain Search Bulk','admin', 'whmpress' ); ?></a></li>
			<li class='tab'><a href="#DomainWhoIS"><?php echo esc_html_x( 'Domain WhoIS','admin', 'whmpress' ); ?></a></li>
			<li class='tab'><a href="#OrderLink"><?php echo esc_html_x( 'Order Link','admin', 'whmpress' ); ?></a></li>
			<li class='tab'><a href="#Description">Description</a></li>
		</ul>
		
		<div id="Price1">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Billing cycle",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'billingcycle' );
						$data     = [
							"monthly"      => esc_html_x( "Monthly",'admin', "whmpress" ),
							"annually"     => esc_html_x( "Annually",'admin', "whmpress" ),
							"quarterly"    => esc_html_x( "Quarterly",'admin', "whmpress" ),
							"semiannually" => esc_html_x( "Semi Annually",'admin', "whmpress" ),
							"biennially"   => esc_html_x( "Biennially",'admin', "whmpress" ),
							"triennially"  => esc_html_x( "Triennially",'admin', "whmpress" )
						];
						echo whmpress_draw_combo( $data, $selected, "billingcycle" );
						?>
						
						<span
							class="description"><?php echo esc_html_x( 'Select default billing cycle for price','admin', 'whmpress' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Hide decimals",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'hide_decimal' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "hide_decimal" );
						?>
						
						<span class="description"><?php echo esc_html_x( 'Hide/Show decimals with price','admin', 'whmpress' ); ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Decimals",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'decimals' );
						$data     = [ 0, 1, 2, 3 ];
						echo whmpress_draw_combo( $data, $selected, "decimals" );
						?>
						
						<?php
						$selected = whmpress_get_option( 'decimals_tag' );
						$data     = [
							""    => "==No Tag==",
							"b"   => "Bold",
							"i"   => "Italic",
							"u"   => "Underline",
							"sup" => "Superscript",
							"sub" => "Subscript"
						];
						echo whmpress_draw_combo( $data, $selected, "decimals_tag" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show prefix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'prefix' );
						$data     = [
							"No"  => "Do not show",
							"Yes" => "Show prefix",
							"b"   => "Bold tag",
							"i"   => "Italic tag",
							"u"   => "Underline tag",
							"sup" => "Superscript tag",
							"sub" => "Subscript tag"
						];
						echo whmpress_draw_combo( $data, $selected, "prefix" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show suffix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'suffix' );
						$data     = [
							"No"  => "Do not show",
							"Yes" => "Show suffix",
							"b"   => "Bold tag",
							"i"   => "Italic tag",
							"u"   => "Underline tag",
							"sup" => "Superscript tag",
							"sub" => "Subscript tag"
						];
						echo whmpress_draw_combo( $data, $selected, "suffix" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show duration",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'show_duration' );
						$data     = [
							"No"  => "Do not show",
							"Yes" => "Show duration",
							"b"   => "Bold tag",
							"i"   => "Italic tag",
							"u"   => "Underline tag",
							"sup" => "Superscript tag",
							"sub" => "Subscript tag"
						];
						echo whmpress_draw_combo( $data, $selected, "show_duration" );
						?>
						
						<?php
						$selected = whmpress_get_option( 'show_duration_as' );
						$data     = [
							"long" => esc_html_x( "Long Duration (Year)",'admin', "whmpress" ),
							"short" => esc_html_x( "Short Duration (Yr)",'admin', "whmpress" )
						];
						echo whmpress_draw_combo( $data, $selected, "show_duration_as" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Price/Setup",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'price_type' );
						$data     = [ "price" => "Price", "setup" => "Setup Fee", "total" => "Price + Setup Fee" ];
						echo whmpress_draw_combo( $data, $selected, "price_type" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Convert price into monthly price",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'convert_monthly' );
						$data     = [ "0" => "No", "1" => "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "convert_monthly" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Calculate configurable options",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'configureable_options' );
						$data     = [ "0" => "No", "1" => "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "configureable_options" );
						?>
					</td>
				</tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html_x( "Round Price",'admin', "whmpress" ) ?></th>
                    <td>
                        <?php
                        $selected = whmpress_get_option( 'round_price' );
                        $data     = [ "0" => "No", "1" => "Yes" ];
                        echo whmpress_draw_combo( $data, $selected, "round_price" );
                        ?>
                    </td>
                </tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "String for config price",'admin', "whmpress" ) ?></th>
					<td>
						<input name="config_option_string"
						       value="<?php echo esc_attr( whmpress_get_option( 'config_option_string' ) ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Price/Tax",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'price_tax' );
						$data     = [
							"default"   => "WHMCS Default",
							"inclusive" => "Inclusive Tax",
							"exclusive" => "Exclusive Tax",
							"tax"       => "Tax Only"
						];
						echo whmpress_draw_combo( $data, $selected, "price_tax" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Currency",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'price_currency' );
						$data     = [ "0" => "Default" ];
						foreach ( $currencies as $cur ) {
							$data[ $cur["id"] ] = $cur["code"];
						}
						//echo whmpress_draw_combo($data,$selected,"price_currency");
						?>
						<select name="price_currency">
							<?php foreach ( $data as $k => $v ) {
								$S = $selected == $k ? "selected=selected" : ""; ?>
								<option <?php echo $S ?> value="<?php echo $k ?>"><?php echo $v ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="DomainPrice1">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Type",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_type' );
						$data     = [
							"domainregister" => "Domain Registration",
							"domainrenew"    => "Domain Renew",
							"domaintransfer" => "Domain Transfer"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_type" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Years",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_years' );
						$data     = [];
						for ( $x = 1; $x <= 10; $x ++ ) {
							$data[] = $x;
						}
						echo whmpress_draw_combo( $data, $selected, "dp_years" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Decimals",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_decimals' );
						$data     = [];
						for ( $x = 1; $x <= 4; $x ++ ) {
							$data[] = $x;
						}
						echo whmpress_draw_combo( $data, $selected, "dp_decimals" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Hide Decimals",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_hide_decimal' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "dp_hide_decimal" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Decimals As",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_decimals_tag' );
						$data     = [
							""    => "-- No Tag --",
							"b"   => "Bold",
							"i"   => "Italic",
							"u"   => "Underline",
							"sup" => "Superscript",
							"sub" => "Subscript"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_decimals_tag" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Currency Prefix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_prefix' );
						$data     = [
							"Yes" => "Yes",
							"No"  => "Do not show prefix",
							"b"   => "Bold",
							"i"   => "Italic",
							"u"   => "Underline",
							"sup" => "Superscript",
							"sub" => "Subscript"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_prefix" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Currency Suffix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_suffix' );
						$data     = [
							"Yes" => "Yes",
							"No"  => "Do not show prefix",
							"b"   => "Bold",
							"i"   => "Italic",
							"u"   => "Underline",
							"sup" => "Superscript",
							"sub" => "Subscript"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_suffix" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show number of years",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_show_duration' );
						$data     = [
							"Yes" => "Yes",
							"No"  => "Do not show duration",
							"b"   => "Bold",
							"i"   => "Italic",
							"u"   => "Underline",
							"sup" => "Superscript",
							"sub" => "Subscript"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_show_duration" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Price/Tax",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dp_price_tax' );
						$data     = [
							"default"   => "WHMCS Default",
							"inclusive" => "Inclusive Tax",
							"exclusive" => "Exclusive Tax",
							"tax"       => "Tax Only"
						];
						echo whmpress_draw_combo( $data, $selected, "dp_price_tax" );
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="PriceMatrix">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Decimals",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_decimals' );
						$data     = [];
						for ( $x = 1; $x <= 4; $x ++ ) {
							$data[] = $x;
						}
						echo whmpress_draw_combo( $data, $selected, "pm_decimals" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Hidden",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_show_hidden' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "pm_show_hidden" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Replace Zero With",'admin', "whmpress" ) ?></th>
					<td>
						<input name="pm_replace_zero"
						       value="<?php echo esc_attr( whmpress_get_option( 'pm_replace_zero' ) ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Replace Empty With",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_replace_empty' );
						?>
						<input name="pm_replace_empty" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Hide Search",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_hide_search' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "pm_hide_search" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Search Label",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_search_label' );
						?>
						<input name="pm_search_label" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Search Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pm_search_placeholder' );
						?>
						<input name="pm_search_placeholder" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="PriceMatrixDomain">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Decimals",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_decimals' );
						$data     = [];
						for ( $x = 1; $x <= 4; $x ++ ) {
							$data[] = $x;
						}
						echo whmpress_draw_combo( $data, $selected, "pmd_decimals" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Renewel Price",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_show_renewel' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pmd_show_renewel" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Transfer Price",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_show_transfer' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pmd_show_transfer" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Hide Search",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_hide_search' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "pmd_hide_search" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Search Label",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_search_label' );
						?>
						<input name="pmd_search_label" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Search Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_search_placeholder' );
						?>
						<input name="pmd_search_placeholder" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Disabled Domains",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pmd_show_disabled' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "pmd_show_disabled" );
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="Combo1">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">Show duration
					</td>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_billingcycles' );
						$data     = [
							"monthly"      => "Monthly",
							"annually"     => "Annually",
							"quarterly"    => "Quarterly",
							"semiannually" => "Semi Annually",
							"biennially"   => "Biennially",
							"triennially"  => "Triennially"
						];
						echo whmpress_draw_combo_multiple( $data, $selected, "combo_billingcycles" );
						?>
						<span
							class="description"><?php echo esc_html_x( "Press {Ctrl} button for multiple selection",'admin', "whmpress" ) ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Decimals",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_decimals' );
						$data     = [ 0, 1, 2, 3 ];
						echo whmpress_draw_combo( $data, $selected, "combo_decimals" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show button",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_show_button' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "combo_show_button" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_button_text' );
						?>
						<input name="combo_button_text" value="<?php echo esc_attr( $selected ); ?>"/>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show discount",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_show_discount' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "combo_show_discount" );
						
						$selected = whmpress_get_option( 'combo_discount_type' );
						$data     = [ "yearly" => "%age", "monthly" => "Monthly" ];
						echo whmpress_draw_combo( $data, $selected, "combo_discount_type" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show prefix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_prefix' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "combo_prefix" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show suffix",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'combo_suffix' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "combo_suffix" );
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="OrderButton">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Billing Cycle",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'ob_billingcycle' );
						$data     = [
							"monthly"      => "Monthly",
							"annually"     => "Annually",
							"quarterly"    => "Quarterly",
							"semiannually" => "Semi Annually",
							"biennially"   => "Biennially",
							"triennially"  => "Triennially"
						];
						echo whmpress_draw_combo( $data, $selected, "ob_billingcycle" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'ob_button_text' );
						?>
						<input name="ob_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="PricingTable">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Billing Cycle",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'pt_billingcycle' );
						$data     = [
							"monthly"      => "Monthly",
							"annually"     => "Annually",
							"quarterly"    => "Quarterly",
							"semiannually" => "Semi Annually",
							"biennially"   => "Biennially",
							"triennially"  => "Triennially"
						];
						echo whmpress_draw_combo( $data, $selected, "pt_billingcycle" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Price",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pt_show_price' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pt_show_price" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Combo",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pt_show_combo' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "pt_show_combo" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show Button",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pt_show_button' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pt_show_button" );
						?>
					</td>
				</tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html_x( "Process Description",'admin', "whmpress" ) ?></th>
                    <td>
						<?php
						$selected = whmpress_get_option( 'pt_process_description' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pt_process_description" );
						?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html_x( "Show Description Icon",'admin', "whmpress" ) ?></th>
                    <td>
						<?php
						$selected = whmpress_get_option( 'pt_show_description_icon' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pt_show_description_icon" );
						?>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php echo esc_html_x( "Show Description Tooltip",'admin', "whmpress" ) ?></th>
                    <td>
						<?php
						$selected = whmpress_get_option( 'pt_show_description_tooltip' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "pt_show_description_tooltip" );
						?>
                    </td>
                </tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'pt_button_text' );
						?>
						<input name="pt_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="DomainSearch">
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show Combo",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'ds_show_combo' );
						$data     = [ "No", "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "ds_show_combo" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'ds_placeholder' );
						?>
						<input name="ds_placeholder" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button Text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'ds_button_text' );
						?>
						<input name="ds_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="DomainSearchAjax">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php $selected = whmpress_get_option( 'dsa_placeholder' ); ?>
						<input name="dsa_placeholder" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button Text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_button_text' );
						?>
						<input name="dsa_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show WhoIs Link",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_whois_link' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_whois_link" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show WWW Link",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_www_link' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_www_link" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show Transfer Link",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_transfer_link' );
						$data     = [ "Yes", "No" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_transfer_link" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Disable Domain Spinning",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_disable_domain_spinning' );
						$data     = [ "0" => "No", "1" => "Yes" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_disable_domain_spinning" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Order Landing Page",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_order_landing_page' );
						$data     = [
							"no"  => "No of years and Additional domains first",
							"yes" => "Go direct to domain settings"
						];
						echo whmpress_draw_combo( $data, $selected, "dsa_order_landing_page" );
						?>
					</td>
				</tr>
                <tr valign="top">
                    <th scope="row">
					<?php echo esc_html_x( "Order process in new tab?",'admin', "whmpress" ) ?></td>
                    <td>
						<?php
						$selected = whmpress_get_option( 'dsa_order_link_new_tab' );
						$data     = [
							"no"  => "Open domain link in new tab",
							"yes" => "Open domain link in same tab"
						];
						echo whmpress_draw_combo( $data, $selected, "dsa_order_link_new_tab" );
						?>
                    </td>
                </tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show Price",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_show_price' );
						$data     = [ "1" => "Yes", "0" => "No" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_show_price" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Show Years",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_show_years' );
						$data     = [ "1" => "Yes", "0" => "No" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_show_years" );
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
					<?php echo esc_html_x( "Search in Extensions",'admin', "whmpress" ) ?></td>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsa_search_extensions' );
						$data     = [ "1" => "Only Listed in WHMCS", "0" => "All" ];
						echo whmpress_draw_combo( $data, $selected, "dsa_search_extensions" );
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="DomainSearchBulk">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsb_placeholder' );
						?>
						<input name="dsb_placeholder" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button Text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsb_button_text' );
						?>
						<input name="dsb_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="DomainWhoIS">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Placeholder",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dw_placeholder' );
						?>
						<input name="dw_placeholder" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Button Text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dw_button_text' );
						?>
						<input name="dw_button_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="OrderLink">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Link Text",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'ol_link_text' );
						?>
						<input name="ol_link_text" value="<?php echo esc_attr( $selected ); ?>">
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
		<div id="Description">
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php echo esc_html_x( "Show As",'admin', "whmpress" ) ?></th>
					<td>
						<?php
						$selected = whmpress_get_option( 'dsc_description' );
						$data     = [ "ul" => "Unordered List", "ol" => "Ordered List", "s" => "Simple" ];
						echo whmpress_draw_combo( $data, $selected, "dsc_description" );
						?>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><?php submit_button(); ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>