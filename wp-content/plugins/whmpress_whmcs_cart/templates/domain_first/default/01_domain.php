<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$sld     = ( ! empty( $_REQUEST['sld'] ) ) ? esc_attr( $_REQUEST['sld'] ) : '';
$tld     = ( ! empty( $_REQUEST['tld'] ) ) ? esc_attr( $_REQUEST['tld'] ) : '';
$type    = ( ! empty( $_REQUEST['domain'] ) ) ? esc_attr( $_REQUEST['domain'] ) : 'register';
$gids    = ( ! empty( $gids ) ) ? $gids : '';
$pids    = ( ! empty( $pids ) ) ? $pids : '';
$domain  = $sld . $tld;
$on_load = ( $domain <> "" ) ? 'wcop_df_submit_on_load' : '';

$curr_domains = [];
$curr_cart    = whcom_get_cart()['all_items'];
foreach ( $curr_cart as $item ) {
	if ( ! empty( $item['domain'] ) ) {
		$curr_domains = $item['domain'];
	}
}

?>
<?php if ( ( $domain == '' ) && empty( $curr_domains ) ) { ?>
	<div class="wcop_df_domain_search wcop_df_page">
		<?php
		$domains_list = whcom_get_all_tlds();
		$sld    = ( isset( $_GET['sld'] ) ) ? esc_attr( $_GET['sld'] ) : '';
		$tld    = ( isset( $_GET['tld'] ) ) ? esc_attr( $_GET['tld'] ) : '';
		$typ    = ( isset( $_GET['domain'] ) ) ? esc_attr( $_GET['domain'] ) : '';
		$domain = $sld . $tld;

		$cart_tab = $register_form = $register_tab = $transfer_form = $transfer_tab = '';
		if ( $typ == 'transfer' ) {
			$transfer_tab = 'active ';
			if ( ! empty( $domain ) ) {
				$transfer_form = 'wcop_submit_on_load';
			}
		}
		else {
			$register_tab = 'active ';
			if ( ! empty( $domain ) ) {
				$register_form = 'wcop_submit_on_load';
			}
		} ?>
		<div class="whcom_tabs_container">
			<div class="whcom_tabs_container whcom_tabs_fancy_5">
				<ul class="whcom_tab_links">
					<li data-tab="register_domain" class="whcom_tab_link <?php echo $register_tab; ?>">
						<?php esc_html_e( 'Register a new domain', "whcom" ) ?>
					</li>
					<li data-tab="transfer_domain" class="whcom_tab_link <?php echo $transfer_tab; ?>">
						<?php esc_html_e( 'Transfer a Domain', "whcom" ) ?>
					</li>
				</ul>
				<div class="whcom_tabs_content <?php echo $register_tab; ?>" id="register_domain">
					<form class="wcop_df_domain_search_form <?php echo $on_load ?>" method="post">
						<input type="hidden" name="action" value="wcop_domain_first">
						<input type="hidden" name="wcop_what" value="domain_search">
						<input type="hidden" name="domaintype" value="register">
						<input type="hidden" name="gids" value="<?php echo $gids ?>">
						<input type="hidden" name="pids" value="<?php echo $pids ?>">
						<div class="whcom_row whcom_row_no_gap">
							<div class="whcom_col_sm_7">
								<div class="whcom_form_field">
									<input required="required"
									       type="search"
									       name="domain"
									       value="<?php echo $sld; ?>"
									       title="Domain Name">
								</div>
							</div>
							<div class="whcom_col_sm_2">
								<div class="whcom_form_field">
									<select name="ext" title="Select TLD">
										<?php
										if ( is_array( $domains_list ) && ! empty ( $domains_list ) ) {
											foreach ( $domains_list as $tld_l => $det ) {
												$selected = ( $tld_l == $tld ) ? 'selected' : '';
												echo '<option value="' . $tld_l . '" ' . $selected . '>' . $tld_l . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="whcom_col_sm_3">
								<div class="whcom_form_field">
									<button type="submit"
									        class="whcom_button whcom_button_block"><?php esc_html_e( 'Check', "whcom" ) ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
				<div class="whcom_tabs_content <?php echo $transfer_tab; ?>" id="transfer_domain">
					<form class="wcop_df_domain_search_form <?php echo $on_load ?>" method="post">
						<input type="hidden" name="action" value="wcop_domain_first">
						<input type="hidden" name="wcop_what" value="domain_search">
						<input type="hidden" name="domaintype" value="transfer">
						<input type="hidden" name="gids" value="<?php echo $gids ?>">
						<input type="hidden" name="pids" value="<?php echo $pids ?>">
						<div class="whcom_row whcom_row_no_gap">
							<div class="whcom_col_sm_7">
								<div class="whcom_form_field">
									<input required="required"
									       type="search"
									       name="domain"
									       value="<?php echo $sld; ?>"
									       title="Search Domain">
								</div>
							</div>
							<div class="whcom_col_sm_2">
								<div class="whcom_form_field">
									<select name="ext" title="Select TLD">
										<?php
										if ( is_array( $domains_list ) && ! empty ( $domains_list ) ) {
											foreach ( $domains_list as $tld_l => $det ) {
												$selected = ( $tld_l == $tld ) ? 'selected' : '';
												echo '<option value="' . $tld_l . '" ' . $selected . '>' . $tld_l . '</option>';
											}
										}
										?>
									</select>
								</div>
							</div>
							<div class="whcom_col_sm_3">
								<div class="whcom_form_field">
									<button type="submit"
									        class="whcom_button whcom_button_block"><?php esc_html_e( 'Transfer', "whcom" ) ?></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="wcop_df_domain_search_result ">
			<div class="wcop_df_domain_search_result_content wcop_df_page_content" style="display: none">

			</div>
		</div>
	</div>
<?php }
else { ?>
	<?php include_once wcop_get_template_directory( 'domain_first' ) . '/templates/domain_first/default/02_product.php'; ?>
<?php }
