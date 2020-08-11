<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$additionaldomainfields = [];
include WHCOM_PATH . '/includes/external/whmcs_lang.php';
include WHCOM_PATH . '/includes/external/domain_fields.php';
$hidden_domain_fields = get_option( 'whcom_hide_domain_fields', [] );


?>

<form method="post" action="options.php">
	<?php settings_fields( 'whcom_domains' ); ?>


    <div class="whcom_panel">
        <div class="whcom_panel_header whcom_panel_header_white">
            <span><?php echo esc_html_x( 'Deactivate Custom Domain Fields', "admin","whcom" ) ?></span>
        </div>
        <div class="whcom_panel_body">

            <div class="whcom_form_field whcom_form_field_horizontal">
                <input type="text" id="whcom_tld_fields_live_search" placeholder="<?php echo esc_html_x( "Type TLD for live search","admin", "whcom" ) ?>">
            </div>
            <div id="whcom_tld_fields_live_search_div">
				<?php if ( ! empty( $additionaldomainfields ) && is_array( $additionaldomainfields ) ) { ?>
					<?php foreach ( $additionaldomainfields as $tld => $domain_field ) { ?>

						<?php if ( empty( $domain_field ) || ! is_array( $domain_field ) ) {
							continue;
						} ?>


                        <div class="whcom_collapse whcom_margin_bottom_30" data-tld-name="<?php echo $tld; ?>">
                            <div class="whcom_collapse_toggle">
                                <i class="whcom_icon_down-open"></i>
								<?php echo esc_html_x( 'Deactivate custom domain fields for',"admin", "whcom" ) ?>
                                <strong><?php echo $tld; ?></strong>
                            </div>
                            <div class="whcom_collapse_content">
								<?php foreach ( $domain_field as $key => $sub_field ) {
									$random      = 'fld_' . str_replace( '.', '_', $tld ) . '_' . rand( 11111, 99999 );
									$fld_name    = str_replace( '.', '_', $tld ) . '_' . $key;
									$fld_checked = ( ! empty( $hidden_domain_fields[ $fld_name ] ) && ( $hidden_domain_fields[ $fld_name ] == 'hide' ) ) ? 'checked' : '';
									?>

                                    <div class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="<?php echo $random; ?>"><?php echo $sub_field['Name'] ?></label>
                                        <div class="whcom_checkbox_container">
                                            <label>
                                                <input type="checkbox"
                                                       id="<?php echo $random; ?>"
                                                       name="whcom_hide_domain_fields[<?php echo $fld_name; ?>]"
                                                       value="hide" <?php echo $fld_checked; ?>>
												<?php if ( ! empty( $sub_field['DisplayName'] ) ) { ?>
                                                    <div>
														<?php echo $sub_field['DisplayName']; ?>
                                                    </div>
												<?php } ?>
                                            </label>

                                        </div>

                                    </div>

								<?php } ?>
                                <div class="whcom_form_field whcom_text_center">
                                    <button class="whcom_button whcom_button_big"><?php echo esc_html_x( "Save All","admin", "whcom" ) ?></button>
                                </div>
                            </div>
                        </div>

					<?php } ?>
				<?php } ?>
            </div>
        </div>
    </div>
</form>


