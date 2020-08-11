<?php
/**
 * @package Admin
 * @todo    Services page for WHMpress admin panel
 */

if ( ! defined( 'WHMP_VERSION' ) ) {
	wp_die( "Direct acces not allowed by WHMPress", "Forbidden" );
}
$WHMPress = new WHMpress();

## If styles are generic/default and (active_theme/whmpress exists or whmpress_folder/themes/active_theme folder exists)
if ( ( is_dir( get_template_directory() . "/whmpress/" ) || is_dir( WHMP_PLUGIN_PATH . "themes/" . basename( get_template_directory() ) ) ) && get_option( 'load_sytle_orders' ) == '' ) {
	?>
	<div class="notice notice-success is-dismissible">
		<h3>WHMPress</h3>
        <p><?php echo esc_html_x( 'Matching Templates found for your active theme ','admin', 'whmpress' ). '<b>'. basename( get_template_directory() ) . '</b>' . esc_html_x( ' You can enable ','admin', 'whmpress' ) . '<b>' . basename( get_template_directory() ) . '</b>' . esc_html_x( ' support by selecting Template Source from ','admin', 'whmpress' ) . '<a href="admin.php?page=whmp-settings#styles">Settings > Styles</a>';?></p>
	</div>
	<?php
}

global $wpdb;
?>

<?php //notes//


/*__("string to translate", "whmpress");
esc_html__();
esc_html_x("string to translate","admin","whmpress");

_e();
esc_html_e();
echo esc_html_x()*/


?>

<div class="wrap whmp_wrap">
	<h2></h2>
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab"
		   href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x( 'Dashboard','admin', 'whmpress' ); ?></a>
		<a class="nav-tab nav-tab-active"
		   href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x( 'Products/Services','admin', 'whmpress' ); ?></a>
		<a class="nav-tab"
		   href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x( 'Settings','admin', 'whmpress' ); ?></a>

        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x('Pricing Tables','admin', 'whmpress')?></a>
		<a class="nav-tab"
		   href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x( 'Sync WHMCS', 'admin','whmpress' ); ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info','admin', 'whmpress')?></a>
	</h2>
	<!--<div class="whmp-main-title"><span class="whmp-title">WHMpress</span> <?php /*_e("Services", "whmpress") */ ?></div>-->
	<?php if ( ! $WHMPress->WHMpress_synced() ): ?>
		
		<div class="whmp_admin_notice whmp_admin_notice_error">
			<h3><?php echo esc_html_x( "Products and Services",'admin', "whmpress" ) ?>:</h3>
			<p><strong><?php echo esc_html_x( "WHMCS is not Synced",'admin', "whmpress" ) ?></strong>
				<?php echo esc_html_x('You will not be able to view/modify any products until you sync WHMCS','admin', 'whmpress')?></p>
			<a class="button button-primary" href="admin.php?page=whmp-sync"><?php esc_html_x( "Please Sync WHMCS",'admin', "whmpress" ) ?></a>
		</div>
	
	<?php else: ?>
		
		<div class="whmp_page_description">
			<p>
				<?php echo esc_html_x( "This page has all services list",'admin', "whmpress" ) ?>
			</p>
		</div>
		
		<?php
		$Q    = "SELECT DISTINCT `type` FROM `" . whmp_get_products_table_name() . "` WHERE `type`<>''";
		$tabs = whmp_get_service_types();
		?>
		
		<style>
			.mytr, .mytr th, .mytr th:hover {
				background-color: #666666 !important;
				color: #FFFFFF !important;
			}
		</style>
		
		<?php if ( isset( $_POST['save_values'] ) ) {
			unset( $_POST['save_values'] );
			foreach ( $_POST as $key => $value ) {
				update_option( $key, $value );
			}
		} ?>
		
		<div class="settings-wrap">
			<div id="whmp-services-tabs" class="tab-container">
				<ul class='etabs'>
					<?php $k = 1;
					foreach ( $tabs as $key => $tab ): ?>
						<li class='tab'><a href='#tab<?php echo $k ?>'><?php echo $tab ?></a></li>
						<?php $k ++; endforeach; ?>
					<li class='tab'><a href="#domains"><?php echo esc_html_x( "Domains",'admin', "whmpress" ) ?></a></li>
					<li class='tab'><a href="#currencies"><?php echo esc_html_x( "Currencies",'admin', "whmpress" ) ?></a></li>
				</ul>
				
				<form name="" method="post">
					<input type="hidden" name="save_values" value="1">
					<?php $k = 1;
					foreach ( $tabs as $key => $tab ) { ?>
						<div id='tab<?php echo $k ?>'>
							<table class="fancy" style="width:100%">
								<thead>
								<tr class="mytr">
									<th style="width:4%"><?php echo esc_html_x( "ID",'admin', "whmpress" ) ?></th>
									<th style="width:24%"><?php echo esc_html_x( "Name",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
									<th style="width:24%"><?php echo esc_html_x( 'Description','admin', 'whmpress' ) ?> <span class="dashicons dashicons-translation"></span></th>
									<th style="width:24%"><?php echo esc_html_x( 'Description Override','admin', 'whmpress' ) ?> <span class="dashicons dashicons-translation"></span></th>
									<th style="width:24%"><?php echo esc_html_x( 'Description Append','admin', 'whmpress' ) ?> <span class="dashicons dashicons-translation"></span></th>
								</tr>
								</thead>
								<tbody>
								<?php
								$groups = $wpdb->get_results( "SELECT `id`,`name`,`hidden` FROM `" . whmp_get_product_group_table_name() . "` ORDER BY `order`", ARRAY_A );
								foreach ( $groups as $group ) {
									$rows = $wpdb->get_results( "SELECT `id`, `name`,`description`,`hidden` FROM `" . whmp_get_products_table_name() . "` WHERE `gid`='{$group["id"]}' AND `type`='{$key}' ORDER BY `name`" );
									if ( is_array( $rows ) && sizeof( $rows ) > 0 ) {
										$hidden = $group["hidden"] == "on" ? " (<i>" . esc_html_x( 'Hidden','admin', 'whmpress' ) . "</i>)" : "";
										foreach ( $rows as $row ): ?>
											<tr>
												<td><?php echo $row->id; ?></td>
												<td>
													<label>
														<?php echo $row->name;
														if ( $row->hidden == "on" )
															echo " (<i>" . esc_html_x( 'Hidden','admin', 'whmpress' ) . "<i>)" ?>
														<br>
														<?php $field = "whmpress_product_" . $row->id . "_name_" . $WHMPress->get_current_language(); ?>
														<input style="padding:5px; width: 100%;"
														       placeholder="<?php echo esc_html_x( "Name override for current language",'admin','whmpress' ); ?>"
														       type="text" data-name="<?php echo $field; ?>"
														       value="<?php echo esc_attr( get_option( $field ) ) ?>">
													</label>
													<br>
													
													<!--													<?php /*$field = "whmpress_product_" . $row->id . "_showoff_price"; */ ?>
													<label>Show off Price<br>
													<input style="padding:5px; width: 100%;" class="input"
													       type="text" data-name="<?php /*echo $field; */ ?>"
													       value="<?php /*echo esc_attr( get_option( $field ) ) */ ?>">
													</label>-->
													
													<?php $field = "whmpress_product_" . $row->id . "_custom_desc_" . $WHMPress->get_current_language(); ?>
													<label><?php echo esc_html_x( 'Tag line','admin', 'whmpress' ) ?><br>
														<input style="padding:5px; width: 100%;" class="input"
														       type="text" data-name="<?php echo $field; ?>"
														       value="<?php echo esc_attr( get_option( $field ) ) ?>">
													</label>
												
												</td>
												<td style="vertical-align: top;">
													<div style="max-height: 100px; overflow-y: auto;">
														<?php echo $row->description; ?>&nbsp;
													</div>
												</td>
												<td>
													<div>
														<?php $field = "whmpress_product_" . $row->id . "_desc_" . $WHMPress->get_current_language(); ?>
														<textarea data-name="<?php echo $field ?>" cols="30" rows="5"
														          placeholder="<?php echo esc_html_x( 'Override description according to current language','admin', 'whmpress' ) ?>"><?php echo esc_attr( get_option( $field ) ); ?></textarea>
													</div>
												</td>
												<td>
													<div>
														<?php $field = "whmpress_product_" . $row->id . "_append_desc_" . $WHMPress->get_current_language(); ?>
														<textarea data-name="<?php echo $field ?>" cols="30" rows="5"
														          class="whmp_multilingual_input"
														          placeholder="<?php echo esc_html_x( 'Append description according to current language','admin', 'whmpress' ) ?>"><?php echo esc_attr( get_option( $field ) ); ?></textarea>
													</div>
												</td>
											</tr>
										<?php endforeach;
									}
								} ?>
								</tbody>
							</table>
							<button class="button button-primary"><?php echo esc_html_x( "Save",'admin', "whmpress" ); ?></button>
						</div>
						<?php $k ++;
					} ?>
					<div id="domains">
						<?php
						$Q            = "SELECT `id`,`autoreg`,`extension`,`group` FROM `" . whmp_get_domain_pricing_table_name() . "` ORDER BY `order`";
						$rows_domains = $wpdb->get_results( $Q, ARRAY_A );
						foreach ( $rows_domains as &$row ) {
							$row['registration_price'] = $WHMPress->get_domain_price( [
								"extension" => $row['extension'],
							] );
							$row['renew_price']        = $WHMPress->get_domain_price( [
								"extension"  => $row['extension'],
								"price_type" => "renew",
							] );
							$row['transfer_price']     = $WHMPress->get_domain_price( [
								"extension"  => $row['extension'],
								"price_type" => "transfer",
							] );
						}
						?>
						<div> <?php echo esc_html_x( 'You are selling','admin', 'whmpress' ) . " " . count( $rows_domains ); ?> domain(s)</div>
						<table class="fancy" style="width:100%">
							<thead>
							<tr>
								<th><?php echo esc_html_x( "ID",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Group",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Domain",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Registration",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Renewel",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Transfer",'admin', "whmpress" ) ?></th>
                                <th><?php echo esc_html_x( "Registrar",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Restore",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Promo",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Promo Text",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Promo Details",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Register Off",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Renew Off",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Transfer Off",'admin', "whmpress" ) ?></th>
								<th><?php echo esc_html_x( "Apply all years",'admin', "whmpress" ) ?></th>
							</tr>
							</thead>
							<tbody>
							<?php
							for ( $index = 0; $index < count( $rows_domains ); $index ++ ) { ?>
								<tr data-id="<?php echo $rows_domains[ $index ]["id"] ?>">
									<td><?php echo $rows_domains[ $index ]["id"] ?></td>
									<td><?php echo $rows_domains[ $index ]["group"] ?></td>
									<td><?php echo $rows_domains[ $index ]["extension"] ?></td>
									<td><?php echo $rows_domains[ $index ]["registration_price"] ?></td>
									<td><?php echo $rows_domains[ $index ]["renew_price"] ?></td>
									<td><?php echo $rows_domains[ $index ]["transfer_price"] ?></td>
                                    <td><?php echo $rows_domains[ $index ]["autoreg"] ?></td>
									
									<?php $field = "whmpress_domain_restore_price_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input value="<?php echo esc_attr( get_option( $field ) ) ?>"
										       class="input" data-name="<?php echo $field ?>"
										       type="number" min="0" style="max-width:70px;">
									</td>
									<?php $field = "whmpress_domain_promo_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="checkbox" value="1" <?php echo get_option( $field ) == "1" ? "checked=checked" : ""; ?>>
									</td>
									
									<?php $field = "whmpress_domain_promo_text_" . $rows_domains[ $index ]["id"] . $WHMPress->get_current_language(); ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="text" value="<?php echo esc_attr( get_option( $field ) ) ?>">
									</td>
									
									<?php $field = "whmpress_domain_promo_details_" . $rows_domains[ $index ]["id"] . $WHMPress->get_current_language(); ?>
									<td>
										<textarea class="input" data-name="<?php echo $field ?>" rows="1"><?php echo esc_attr( get_option( $field ) ) ?></textarea>
									</td>
									
									<?php $field = "whmpress_domain_promo_register_off_price_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="number" min="0" style="max-width:70px;" value="<?php echo esc_attr( get_option( $field ) ) ?>">
									</td>
									
									<?php $field = "whmpress_domain_promo_renew_off_price_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="number" min="0" style="max-width:70px;" value="<?php echo esc_attr( get_option( $field ) ) ?>">
									</td>
									
									<?php $field = "whmpress_domain_promo_transfer_off_price_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="number" min="0" style="max-width:70px;" value="<?php echo esc_attr( get_option( $field ) ) ?>">
									</td>
									
									<?php $field = "whmpress_domain_promo_apply_all_" . $rows_domains[ $index ]["id"]; ?>
									<td>
										<input class="input" data-name="<?php echo $field ?>" type="checkbox" value="1" <?php echo get_option( $field ) == "1" ? "checked=checked" : ""; ?>>
									</td>
								</tr>
							<?php } ?>
							<tr>
								<td colspan="14" style="text-align: center;">

									<input type="submit" value="<?php esc_html_x("Save",'admin',"whmpress")?>" class="button-primary"></td>
							</tr>
							</tbody>
						</table>
					</div>
					<div id="currencies">
						<?php
						$WHMPress->update_db();
						$Q    = "SELECT * FROM `" . whmp_get_currencies_table_name() . "`";
						$rows = $wpdb->get_results( $Q, ARRAY_A );
						?>
						<button class="button button-primary"><?php esc_html_x( "Save",'admin', "whmpress" ); ?></button>
						<table class="fancy" style="width:100%">
							<thead>
							<tr>
								<th><?php echo esc_html_x( "ID",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
								<th><?php echo esc_html_x( "Code",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
								<th><?php echo esc_html_x( "Prefix",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
								<th><?php echo esc_html_x( "Suffix",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
								<th><?php echo esc_html_x( "Decimal Sep.",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
								<th><?php echo esc_html_x( "Thousand Sep.",'admin', "whmpress" ) ?> <span class="dashicons dashicons-translation"></span></th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ( $rows as $row ) {
								$whmcs_decimal = '';
								$whmcs_thousand = '';
								switch ($row['format']) {
									case '1': {
										$whmcs_decimal = '.';
										break;
									}
									case '2': {
										$whmcs_decimal = '.';
										$whmcs_thousand = ',';
										break;
									}
									case '3': {
										$whmcs_decimal = ',';
										$whmcs_thousand = '.';
										break;
									}
									case '4': {
										$whmcs_decimal = '.';
										$whmcs_thousand = ',';
										break;
									}
									default: {
										$whmcs_decimal = '.';
										$whmcs_thousand = ',';
									}
								}
								
								?>
								<tr>
									<td><?php echo $row["id"] ?><?php if ( $row["default"] == "1" )
											echo " <sup>[default]</sup>" ?></td>
									<td>
										<?php echo $row["code"] ?>
										<?php $field = "whmpress_currencies_" . trim( $row['code'] ) . "_code_" . $WHMPress->get_current_language(); ?>
										<input placeholder="<?php echo esc_html_x( "Override code",'admin', "whmpress" ); ?>" type="text"
										       data-name="<?php echo $field ?>"
										       value="<?php echo esc_attr( get_option( $field ) ); ?>">
									</td>
									<td>
										<?php echo $row["prefix"] ?>
										<?php $field = "whmpress_currencies_" . trim( $row['prefix'] ) . "_prefix_" . $WHMPress->get_current_language(); ?>
										<input placeholder="<?php echo esc_html_x( "Override pefix",'admin', "whmpress" ); ?>" type="text"
										       data-name="<?php echo $field ?>"
										       value="<?php echo esc_attr( get_option( $field ) ); ?>">
									</td>
									<td>
										<?php echo( $row["suffix"] ); ?>
										<?php $field = "whmpress_currencies_" . trim( $row['suffix'] ) . "_suffix_" . $WHMPress->get_current_language(); ?>
										<input placeholder="<?php echo esc_html_x( "Override suffix",'admin', "whmpress" ); ?>" type="text"
										       data-name="<?php echo $field ?>"
										       value="<?php echo esc_attr( get_option( $field ) ); ?>">
									</td>
									<td>
										<?php echo $whmcs_decimal; ?>
										<?php $field = "whmpress_currencies_" . trim( $row['id'] ) . "_decimal_" . $WHMPress->get_current_language(); ?>
										<input placeholder="<?php echo esc_html_x( "Override decimal separator",'admin', "whmpress" ); ?>"
										       type="text"
										       data-name="<?php echo $field ?>"
										       value="<?php echo esc_attr( get_option( $field ) ); ?>">
									</td>
									<td>
										<?php echo $whmcs_thousand; ?>
										<?php $field = "whmpress_currencies_" . trim( $row['id'] ) . "_thousand_" . $WHMPress->get_current_language(); ?>
										<input placeholder="<?php echo esc_html_x( "Override thousand separator", "whmpress" ); ?>"
										       type="text"
										       data-name="<?php echo $field ?>"
										       value="<?php echo esc_attr( get_option( $field ) ); ?>">
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<button class="button button-primary"><?php echo esc_html_x( "Save",'admin', "whmpress" ); ?></button>
					</div>
				</form>
			</div>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(document).ready(function ()
	{
		jQuery('#whmp-services-tabs').easytabs();
		
		jQuery(document).on("change", "[data-name]", function (event)
		{
			event.preventDefault();
			
			var $this = jQuery(this);
			var name = $this.data("name");
			
			if ($this.is(":checkbox")) {
				val = $this.is(":checked") ? "1" : "0";
			}
			else if ($this.is(":radio")) {
				val = $this.is(":checked") ? "1" : "0";
			}
			else {
				var val = $this.val();
			}
			
			//$this.prop("disabled", true);
			$this.val("Saving...");
			$this.attr('disabled', true);
			jQuery.post(
				ajaxurl,
				{
					action: 'whmpress_update_field',
					name: name,
					val: val
				},
				function (data) {
					$this.attr('disabled', false);
					$this.val(val);
					if ($this.is(":checkbox")) {
						if (val == "1"){
							$this.attr('checked', true)
						}
						else {
							$this.attr('checked', false)
						}
					}
					else if ($this.is(":radio")) {
						if (val == "1"){
							$this.attr('checked', true)
						}
						else {
							$this.attr('checked', false)
						}
					}
					else {
						$this.val(val);
					}
				});
		});
	});
</script>