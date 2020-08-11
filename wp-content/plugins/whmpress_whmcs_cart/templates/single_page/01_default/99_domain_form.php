<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

$domains_list = whcom_get_all_tlds();
$curr_domains = [];
$curr_cart    = whcom_get_cart()['all_items'];
$tabs_class = empty($tabs_class) ? 'whcom_tabs_fancy_2' : $tabs_class;
if(!empty($curr_cart)) {
    foreach ($curr_cart as $index => $item) {
        if (!empty($item['domain']) && !empty($item['domaintype'])) {
            if (!empty($item['pid'])) {
                continue;
            }
            $item_ext = whcom_get_tld_from_domain($item['domain']);
            $item_domain = str_replace($item_ext, '', $item['domain']);
            $curr_domains[] = [
                'cart_index' => $index,
                'domain_name' => $item_domain,
                'domain_ext' => $item_ext,
                'domain_type' => $item['domaintype'],
                'domain_product' => $item['pid']
            ];
        }
    }
}

$sld    = ( isset( $_GET['sld'] ) ) ? esc_attr( $_GET['sld'] ) : '';
$tld    = ( isset( $_GET['tld'] ) ) ? esc_attr( $_GET['tld'] ) : '';
$typ    = ( isset( $_GET['domain'] ) ) ? esc_attr( $_GET['domain'] ) : '';
$domain = $sld . $tld;


$cart_tab = $register_form = $register_tab = $transfer_form = $transfer_tab = '';
if ( empty( $curr_domains ) ) {
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
	}
}
else {
	$cart_tab = 'active';
} ?>

<?php $hide_domain_transfer_option = $_SESSION['hide_domain_transfer_section'] ?>
<div class="whcom_tabs_container">
	<div class="whcom_tabs_container <?php echo $tabs_class ?>">
		<ul class="whcom_tab_links">
			<?php if ( ! empty( $curr_domains ) ) { ?>
				<li data-tab="already_in_cart" class="whcom_tab_link active">
					<?php esc_html_e( 'Already in Cart', "whcom" ) ?>
				</li>
			<?php } ?>
			<li data-tab="register_domain" class="whcom_tab_link <?php echo $register_tab; ?>">
				<?php esc_html_e( 'Register a new domain', "whcom" ) ?>
			</li>
            <?php if (strtolower($hide_domain_transfer_option) != 'yes') { ?>
			<li data-tab="transfer_domain" class="whcom_tab_link <?php echo $transfer_tab; ?>">
				<?php esc_html_e( 'Transfer a Domain', "whcom" ) ?>
			</li>
            <?php } ?>
			<li data-tab="existing_domain" class="whcom_tab_link">
				<?php esc_html_e( 'I already own a Domain', "whcom" ) ?>
			</li>
		</ul>
		<?php if ( ! empty( $curr_domains ) ) { ?>
			<div class="whcom_tabs_content active" id="already_in_cart">
				<form class="wcop_sp_check_product_domain domain_already_in_cart" method="post">
					<input type="hidden" name="check_domain" value="1">
					<input type="hidden" name="action" value="wcop_sp_process">
					<input type="hidden" name="wcop_sp_what" value="check_domain">
					<div class="whcom_row whcom_row_no_gap">
						<div class="whcom_col_sm_9">
							<div class="whcom_form_field">
								<select name="domain" class=""
								        title="<?php esc_html_e( 'Select a domain', "whcom" ) ?>">
									<?php foreach ( $curr_domains as $curr_domain ) {
										if ( ! empty( $curr_domain['domain_product'] ) && $curr_domain['domain_product'] > 0 ) {
											continue;
										} ?>
										<option value="<?php echo $curr_domain['domain_name']; ?>"
										        data-cart-index="<?php echo $curr_domain['cart_index'] ?>"
										        data-domain-tld="<?php echo $curr_domain['domain_ext'] ?>"
										        data-domain-type="<?php echo $curr_domain['domain_type'] ?>"
										><?php echo $curr_domain['domain_name'] ?><?php echo $curr_domain['domain_ext'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="whcom_col_sm_3">
							<div class="whcom_form_field">
								<button type="submit" id="require_Domain_already_cart"
								        class="whcom_button whcom_button_block"><?php esc_html_e( 'Use', "whcom" ) ?></button>
							</div>
						</div>
					</div>
				</form>
			</div>
		<?php } ?>
		<div class="whcom_tabs_content <?php echo $register_tab; ?>" id="register_domain">
			<form class="wcop_sp_check_product_domain <?php echo $register_form; ?>" method="post">
				<input type="hidden" name="check_domain" value="1">
				<input type="hidden" name="domaintype" value="register">
				<input type="hidden" name="action" value="wcop_sp_process">
				<input type="hidden" name="wcop_sp_what" value="check_domain">
				<div class="whcom_row whcom_row_no_gap">
					<div class="whcom_col_sm_7" id="domain_search_div">
						<div class="whcom_form_field">
							<input required="required"
							       type="search"
							       name="domain"
							       id="domain"
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
										echo '<option value="' . $tld_l . '" ' . $selected . '>' . strtoupper($tld_l) . '</option>';
									}
								}
								?>
							</select>
						</div>
					</div>
					<div class="whcom_col_sm_3">
						<div class="whcom_form_field">
							<button type="submit" id="require_Domain_search"
							        class="whcom_button whcom_button_block"><?php esc_html_e( 'Check', "whcom" ) ?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="whcom_tabs_content <?php echo $transfer_tab; ?>" id="transfer_domain">
			<form class="wcop_sp_check_product_domain <?php echo $transfer_form; ?>" method="post">
				<input type="hidden" name="check_domain" value="1">
				<input type="hidden" name="domaintype" value="transfer">
				<input type="hidden" name="action" value="wcop_sp_process">
				<input type="hidden" name="wcop_sp_what" value="check_domain">
				<div class="whcom_row whcom_row_no_gap">
					<div class="whcom_col_sm_7">
						<div class="whcom_form_field">
							<input required="required"
							       type="search"
							       name="domain"
							       id="domain_transfer"
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
							<button type="submit" id="require_Domain_transfer"
							        class="whcom_button whcom_button_block"><?php esc_html_e( 'Transfer', "whcom" ) ?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="whcom_tabs_content" id="existing_domain">
			<form class="wcop_sp_check_product_domain" method="post">
				<input type="hidden" name="check_domain" value="1">
				<input type="hidden" name="domaintype" value="existing">
				<input type="hidden" name="action" value="wcop_sp_process">
				<input type="hidden" name="wcop_sp_what" value="check_domain">
				<div class="whcom_row whcom_row_no_gap">
					<div class="whcom_col_sm_7">
						<div class="whcom_form_field">
							<input required="required"
							       type="search"
							       name="domain"
							       title="Domain Name"
							       id="domain_use"
							       placeholder="yourdomainname">
						</div>
					</div>
					<div class="whcom_col_sm_2">
						<div class="whcom_form_field">
							<input type="text" name="ext" required="required" title="Enter TLD TLD"
							       placeholder=".com">
						</div>
					</div>
					<div class="whcom_col_sm_3">
						<div class="whcom_form_field">
							<button type="submit" id="require_Domain_use"
							        class="whcom_button whcom_button_block"><?php esc_html_e( 'Use', "whcom" ) ?></button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

