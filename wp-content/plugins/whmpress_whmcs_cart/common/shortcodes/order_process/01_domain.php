<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$domain_price = [];

$active_tab = 'register';

$sld    = ( isset( $_REQUEST['sld'] ) ) ? esc_attr( $_REQUEST['sld'] ) : '';
$tld    = ( isset( $_REQUEST['tld'] ) ) ? esc_attr( $_REQUEST['tld'] ) : '';
$typ    = ( isset( $_REQUEST['domain'] ) ) ? esc_attr( $_REQUEST['domain'] ) : '';
$domain = $sld . $tld;

if ('transfer' != strtolower($typ)) {
	$typ = 'register';
}

$domains_list = whcom_get_all_tlds();
if ( strtolower($typ) == 'transfer' ) {
	$active_tab = 'transfer';
}

?>

<?php if ( $active_tab == 'register' ) { ?>
	<div class="whcom_op_domain_search whcom_margin_bottom_45">
		<div class="whcom_page_heading ">
			<?php esc_html_e( 'Register Domain', 'whcom' ) ?>
		</div>
		<form class="whcom_op_check_domain <?php echo ( $domain == '' ) ? '' : 'whcom_op_submit_on_load'; ?>"
		      method="post">
			<input type="hidden" name="check_domain" value="1">
			<input type="hidden" name="domaintype" value="register">
			<input type="hidden" name="action" value="whcom_op">
			<input type="hidden" name="whcom_op_what" value="check_domain">


			<div class="whcom_row whcom_row_no_gap">
				<div class="whcom_col_sm_7">
					<div class="whcom_form_field">
						<input required="required" type="search" name="domain" id="search_domain" title="Domain Name" value="<?php echo $sld; ?>">
					</div>
				</div>
				<div class="whcom_col_sm_2">
					<div class="whcom_form_field">
						<select name="ext" title="Select TLD">
							<?php
							if ( is_array( $domains_list ) && ! empty ( $domains_list ) ) {
								foreach ( $domains_list as $i => $domain ) {
									$selected = ( $i == $tld ) ? 'selected' : '';
									echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="whcom_col_sm_3">
					<div class="whcom_form_field">
						<button type="submit" class="whcom_button whcom_button_block"><?php esc_html_e( 'Search', 'whcom' ) ?></button>
					</div>
				</div>
			</div>
		</form>
	</div>
<?php }
else { ?>
	<div class="whcom_op_domain_search whcom_margin_bottom_45">
		<div class="whcom_page_heading ">
			<?php esc_html_e( 'Transfer Domain', 'whcom' ) ?>
		</div>
		<form class="whcom_op_check_domain <?php echo ( $domain == '' ) ? '' : 'whcom_op_submit_on_load'; ?>" method="post">
			<input type="hidden" name="check_domain" value="1">
			<input type="hidden" name="domaintype" value="transfer">
			<input type="hidden" name="action" value="whcom_op">
			<input type="hidden" name="whcom_op_what" value="check_domain">


			<div class="whcom_row whcom_row_no_gap">
				<div class="whcom_col_sm_7">
					<div class="whcom_form_field">
						<input required="required" type="search" name="domain" id="search_domain" title="Search Domain" value="<?php echo $sld; ?>">
					</div>
				</div>
				<div class="whcom_col_sm_2">
					<div class="whcom_form_field">
						<select name="ext" id="search_ext" title="Select TLD">
							<?php
							if ( is_array( $domains_list ) && ! empty ( $domains_list ) ) {
								foreach ( $domains_list as $i => $domain ) {
									$selected = ( $i == $tld ) ? 'selected' : '';
									echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
								}
							}
							?>
						</select>
					</div>
				</div>
				<div class="whcom_col_sm_3">
					<div class="whcom_form_field">
						<button type="submit" class="whcom_button whcom_button_block"><?php esc_html_e( 'Transfer', 'whcom' ) ?></button>
					</div>
				</div>
			</div>

		</form>
	</div>

<?php } ?>

<div class="whcom_op_domain_action_response_text whcom_max_width_640"></div>
<div class="whcom_op_domain_action_response_form"></div>






