<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$all_gateways      = whcom_get_payment_gateways()['payment_gateways'];
$merchant_gateways = [];
if ( ! empty( $all_gateways ) && is_array( $all_gateways ) ) {
	foreach ( $all_gateways as $gateway ) {
		if ( whcom_payment_gateway_type( (string) $gateway['module'] ) == 'm' ) {
			$merchant_gateways[] = $gateway;
		}
	}
}


?>

<div class="wrap whcom_admin_page">
    <div class="wcop_admin_content">
        <form method="post" action="options.php">
			<?php settings_fields( "wcop" ); ?>
            <div class="whcom_row">
                <div class="whcom_col_sm_12">
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x( 'General settings', "admin", "whcom" ) ?></strong>
                        </div>
                        <div class="whcom_panel_body">
                            <div class="whcom_form_field whcom_form_field_horizontal">
                                <label for="configure_product"><?php echo esc_html_x( 'Order Process URL', "admin", "whcom" ); ?></label>
								<?php $field = 'configure_product' . whcom_get_current_language(); ?>
                                <input id="configure_product" type="url" name="<?php echo "$field" ?>"
                                       value="<?php echo esc_attr( get_option( $field ) ); ?>">
                                <label></label>
                                <div class="whcom_checkbox_container">
                                    <strong>
										<?php if ( url_to_postid( esc_attr( get_option( $field ) ) ) == '0' ) {
											echo esc_html_x( 'Page URL is not correct', "admin", "whcom" );
										}
										else {
											$page_id  = url_to_postid( esc_attr( get_option( $field ) ) );
											$page_url = get_permalink( $page_id );
											echo '<a href="' . esc_html( $page_url ) . '" target="_blank">';
											echo esc_html_x( 'Visit Page', "admin", "whcom" ) . '</a>';
										} ?>
                                    </strong><br>
                                    <i>help: create a page with shrot-code [whmpress_cart_config_product], and enter its
                                        URL here</i><br><br>
                                </div>
                            </div>

                            <div class="whcom_form_field whcom_form_field_horizontal">
                                <label for="continue_shopping"><?php echo esc_html_x( 'Continue Shopping URL', "admin", "whcom" ) ?></label>
								<?php $field = 'continue_shopping' . whcom_get_current_language(); ?>
                                <input id="continue_shopping" type="url" name="<?php echo "$field" ?>"
                                       value="<?php echo esc_attr( get_option( $field ) ); ?>">
                                <label></label>
                                <div class="whcom_checkbox_container">
                                    <strong>
										<?php echo '<a href="' . esc_url( get_option( $field ) ) . '" target="_blank">' . esc_html_x( 'Visit Page', "admin", "whcom" ) . '</a>'; ?>
                                    </strong>
                                    <i>
										<?php echo esc_html_x( 'help: Enter URL to page with product listings, your users will be redirected to this page when the click continue shopping', "admin", "whcom" ) ?>
                                    </i><br>
                                </div>
                            </div>

                            <div class="whcom_form_field whcom_form_field_horizontal">
                                <label for="order_complete_redirect"><?php echo esc_html_x( 'Order Complete Redirect URL', "admin", "whcom" ) ?></label>
								<?php $field = 'order_complete_redirect' . whcom_get_current_language(); ?>
                                <input id="order_complete_redirect" type="url" name="<?php echo "$field" ?>"
                                       value="<?php echo esc_attr( get_option( $field ) ); ?>">
                                <label></label>
                                <div class="whcom_checkbox_container">
                                    <strong>
										<?php echo '<a href="' . esc_url( get_option( $field ) ) . '" target="_blank">' . esc_html_x( 'Visit Page', "admin", "whcom" ) . '</a>'; ?>
                                    </strong><br>
                                    <i><?php echo esc_html_x( 'help: You can enter the link to Client Area page here, so user can be redirected to client-area...', "admin", "whcom" ); ?></i>
                                </div>
                            </div>




                            <div class="whcom_form_controll whcom_text_center_xs">
                                <button type="submit"
                                        class="button button-primary"><?php echo esc_html_x( 'Save Settings', "admin", "whcom" ) ?></button>
                            </div>

                        </div>
                    </div>

                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x( 'Invoice Settings', "admin", "whcom" ) ?></strong>
                        </div>
                        <div class="whcom_panel_body">
                            <div class="whcom_form_field whcom_form_field_horizontal">
                                <label for="wcop_show_invoice_as"><?php echo esc_html_x( 'Show Invoice As', "admin", "whcom" ) ?></label>
		                        <?php $field = 'wcop_show_invoice_as'; ?>
                                <select name="wcop_show_invoice_as" id="wcop_show_invoice_as">
                                    <option <?php echo get_option( "wcop_show_invoice_as", 'popup' ) == "popup" ? "selected" : "" ?>
                                            value="popup"><?php echo esc_html_x( "Popup", "admin", "whcom" ) ?></option>
                                    <option <?php echo get_option( "wcop_show_invoice_as", 'popup' ) == "same_tab" ? "selected" : "" ?>
                                            value="same_tab">
				                        <?php echo esc_html_x( "Same Tab", "admin", "whcom" ) ?>
                                    </option>
                                    <option <?php echo get_option( "wcop_show_invoice_as", 'popup' ) == "new_tab" ? "selected" : "" ?>
                                            value="new_tab">
				                        <?php echo esc_html_x( "New Tab", "admin", "whcom" ) ?>
                                    </option>
                                    <option <?php echo get_option( "wcop_show_invoice_as", 'popup' ) == "minimal" ? "selected" : "" ?>
                                            value="minimal">
				                        <?php echo esc_html_x( "Minimal (Recommended)", "admin", "whcom" ) ?>
                                    </option>
                                </select>
                                <label></label>
                                <div id="minimal_interface_help"
                                     style="display: <?php echo get_option( "wcop_show_invoice_as", 'popup' ) == "minimal" ? "block" : "none" ?>"
                                     class="whcom_padding_15_0 whcom_checkbox_container">
			                        <?php if ( esc_attr( get_option( 'whcom_whmcs_invoice_custom_templates' ), 'no' ) != 'yes' ) { ?>
                                        <div class="whcom_alert whcom_alert_warning">
                                            <div class="whcom_margin_bottom_15">
                                                <strong><?php echo esc_html_x( "Important", "admin", "whcom" ) ?>
                                                    !</strong>
                                                <p><?php echo esc_html_x( "If you want to use minimal interface, you will need to use custom templates, turn them on by visiting to following link", "admin", "whcom" ) ?></p>
                                            </div>
                                            <div class="whcom_text_center">
                                                <a href="?page=whcom-settings"
                                                   class="whcom_button whcom_button_info"><?php echo esc_html_x( "WHCOM Settings", "admin", "whcom" ) ?></a>
                                            </div>
                                        </div>
			                        <?php }
			                        else { ?>
                                        <div class="whcom_alert whcom_alert_success">
                                            <div class="whcom_margin_bottom_15">
                                                <strong><?php echo esc_html_x( "Good to go", "admin", "whcom" ) ?>
                                                    !</strong>
                                                <p><?php echo esc_html_x( "Customg Templates are being used", "admin", "whcom" ) ?></p>
                                            </div>
                                        </div>
			                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x( 'Advance Payment Settings', "admin", "whcom" ) ?></strong>
                        </div>
                        <div class="whcom_panel_body">
                            <div class="whcom_alert whcom_alert_info">
                                <strong><?php echo esc_html_x( "Note: You do not need to enable this option until you are using a Merchant Gateway.", "admin", "whcom" ) ?></strong><br>
                                <div>

                                </div>
								<?php echo esc_html_x( "Merchant Gateways store credit card information securely in the WHMCS database. Majorty of small hosts use Third party gateways, which require no configuration in this plugins. To find out more about how payment gateways work, visit below link on WHMCS site.", "admin", "whcom" ) ?>
                                <div>
                                    <a href="https://docs.whmcs.com/Payment_Gateways#Merchant_Gateways"><?php echo esc_html_x( "WHMCS Merchant Gateways", "admin", "whcom" ) ?></a>
                                </div>

                            </div>
							<?php if ( empty( $merchant_gateways ) ) { ?>
                                <div class="whcom_alert whcom_alert_info">
                                    <strong><?php echo esc_html_x( "No Merchant Gateway found!", "admin", "whcom" ) ?></strong><br>
                                </div>
							<?php }
							else { ?>

                                <div class="whcom_form_field whcom_form_field_horizontal">

                                    <label for="use_merchant"><?php echo esc_html_x( 'Use Merchant Gateway? (beta)', "admin", "whcom" ) ?></label>
									<?php $field = 'use_merchant_gateway'; ?>
									<?php $checked = ( esc_attr( get_option( $field ) ) == 'yes' ) ? ' checked' : ''; ?>
                                    <input id="use_merchant" type="checkbox" name="<?php echo "$field" ?>"
                                           value="yes" <?php echo $checked; ?>>
                                </div>

                                <div class="whcom_form_field whcom_form_field_horizontal">
                                    <label for="merchant_gateway_key"><?php echo esc_html_x( 'Merchant Gateway key (text), ie. bluepay', "admin", "whcom" ) ?></label>
									<?php $field = 'merchant_gateway_key'; ?>
                                    <select name="merchant_gateway_key" id="merchant_gateway_key">
										<?php foreach ( $merchant_gateways as $merchant_gateway ) { ?>
                                            <option value="<?php echo $merchant_gateway['module'] ?>" <?php echo ( esc_attr( get_option( $field ) == $merchant_gateway['module'] ) ) ? 'selected' : ''; ?>>
												<?php echo $merchant_gateway['displayname'] ?>
                                            </option>
										<?php } ?>
                                    </select>
                                </div>

                                <div class="whcom_form_controll whcom_text_center_xs">
                                    <button type="submit"
                                            class="button button-primary"><?php echo esc_html_x( 'Save Settings', "admin", "whcom" ) ?></button>
                                </div>
							<?php } ?>


                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>






