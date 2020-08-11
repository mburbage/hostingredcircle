<?php
$params = ( empty( $params ) ) ? [] : $params;
$sld    = ( isset( $_REQUEST['sld'] ) ) ? esc_attr( $_REQUEST['sld'] ) : '';
$tld    = ( isset( $_REQUEST['tld'] ) ) ? esc_attr( $_REQUEST['tld'] ) : '';
$typ    = ( isset( $_REQUEST['domain'] ) ) ? esc_attr( $_REQUEST['domain'] ) : '';
$domain = $sld . $tld;
global $WHMPress;
$all_tlds = whmp_get_whmcs_tlds();
$filter_tlds = explode( ",", $params['filter_tlds'] );
if ( ! empty( $all_tlds ) && is_array( $all_tlds ) ) {
	$action_string = '';
	if (!empty(esc_url($params['action']))) {
		$action_string = 'action="'.$params['action'].'"';
	} ?>

    <div class="whmpress_domain_search_ajax_extended_container wcop_df_container whcom_main">
        <script>
		    function openWhois( a ) {
			    window.open( a, "whmpwin", "width=600,height=600,toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=0" );
		    }
        </script>
        <div class="whmpress_domain_search_ajax_extended_search_form_container">
            <form
                    method="get"
                    class="whmpress_domain_search_ajax_extended_search_form <?php echo ( ! empty( $tld ) && ! empty( $sld ) ) ? 'whcom_op_submit_on_load' : ''; ?>"
                    <?php echo $action_string ?>
                    <?php if (!empty($action_string)) { ?>
                        data-result_div_id="yes"
                    <?php } ?>
            >
                <?php if (empty($action_string)) { ?>
                    <input type="hidden" name="action" value="whmpress_action">
                    <input type="hidden" name="do" value="whmpress_domain_search_ajax_extended_results">
                    <input type="hidden" name="page_size" value="<?php echo $params['page_size']; ?>">
                    <input type="hidden" name="is_title" value="yes">
	                <?php foreach ( $params as $param_key => $param_val ) { ?>
                        <input type="hidden" name="params[<?php echo $param_key; ?>]" value="<?php echo $param_val; ?>">
	                <?php } ?>
                <?php } ?>
                <div class="whcom_row whcom_row_no_gap">
	                <div class="whcom_col_sm_12">
		                <div class="whcom_form_field">
			                <label class="whcom_checkbox whcom_checked whcom_text_large">
				                <input type="checkbox" title="" disabled>
				                <?php esc_html_e('SEARCH A NAME', 'whcom')?>
			                </label>
		                </div>
	                </div>
                    <div class="whcom_col_md_7 whcom_col_sm_12">
                        <div class="whcom_form_field">
                            <input type="search" name="sld" value="<?php echo $sld ?>"
                                   placeholder="<?php echo $params['placeholder'] ?>" required>
                        </div>
                    </div>
                    <div class="whcom_col_md_3 whcom_col_sm_6">
                        <div class="whcom_form_field">
	                        <div class="whcom_radio_container whcom_fancy_select_1">
                                <?php if (empty($params['filter_tlds'])){?>
                                    <select class="whmpress_domain_tlds" name="tld" title="Select TLD" multiple="multiple" required>
                                        <?php foreach ( $all_tlds as $tld_key => $tld_val ) { ?>
                                            <option value="<?php echo $tld_key ?>" <?php echo ( $tld == '.' . $tld_key || $tld == $tld_key ) ? 'selected' : '' ?>>
                                                .<?php echo $tld_key ?></option>
                                        <?php } ?>
                                    </select>
                                <?php }else{?>
                                    <select class="whmpress_domain_tlds" name="tld" title="Select TLD" required>
                                        <?php foreach ( $filter_tlds as $filter_tld ) {?>
                                            <option value="<?php echo $filter_tld ?>">
                                                .<?php echo $filter_tld ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
	                        </div>
                        </div>
                    </div>
                    <div class="whcom_col_md_2 whcom_col_sm_6">
                        <div class="whcom_form_field">
                            <button type="submit"
                                    class="whcom_button whcom_button_block"><?php echo $params['button_text'] ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="whmpress_domain_search_ajax_extended_search_result_title" style="display: none !important;">
        </div>

        <div class="whmpress_domain_search_ajax_extended_search_result_title_placeholder"
             style="display: none !important;">
            <input type="hidden" name="tld" value="">
            <span class="sld_placeholder"></span>.<span class="tld_placeholder"></span>
            <span class="whcom_icon_spinner-1 whcom_animate_spin"></span> <?php esc_html_e( 'Loading...', 'whmpress' ) ?>
        </div>
	    <div class="whcom_margin_bottom_15 whcom_bordered_bottom whcom_padding_bottom_5">
		    <span class="whcom_text_large"><?php echo whmpress_get_option( "domain_recommended_list" ); ?></span>
	    </div>
        <div class="whmpress_domain_search_ajax_extended_search_results">
        </div>
        <div class="whmpress_domain_search_ajax_extended_search_results_placeholders" style="display: none !important;">
            <div class="whmpress_domain_search_ajax_extended_search_result">
                <input type="hidden" name="tld" value="">
                <span class="sld_placeholder"></span>.<span class="tld_placeholder"></span>
                <span class="whcom_icon_spinner-1 whcom_animate_spin"></span> <?php esc_html_e( 'Loading...', 'whmpress' ) ?>
            </div>
        </div>
        <div class="whmpress_domain_search_ajax_extended_search_results_load_more whcom_text_center whcom_padding_15"
             style="display: none">
			<?php if ( ! empty( $params['disable_domain_spinning'] ) && strtolower( $params['disable_domain_spinning'] ) != 'yes' && strtolower( $params['disable_domain_spinning'] ) != '1' ) { ?>
                <button class="whcom_button whcom_button_primary whmpress_domain_search_ajax_extended_search_load_more_button">
					<?php echo $params['load_more_button_text'] ?>
                </button>
			<?php } ?>
            <a href="<?php echo $WHMPress->get_whmcs_url( 'confdomains' ); ?>"
               <?php echo (strtolower($params['order_link_new_tab']) == 'yes' || strtolower($params['order_link_new_tab']) == '1') ? ' target="_blank"': '';?>
               class="whcom_button whcom_button_primary whmpress_domain_search_ajax_extended_continue_button">
				<?php echo $params['continue_button_text'] ?>
            </a>
        </div>
    </div>
<?php } ?>
<!--<script>
    jQuery(document).ready(function() {
        jQuery('.whmpress_domain_tlds').select2();
    });
</script>-->

