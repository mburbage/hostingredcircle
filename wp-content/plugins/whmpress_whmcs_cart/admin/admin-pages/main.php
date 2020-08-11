<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$api_test    = whcom_api_test();
$helper_test = whcom_helper_test();

?>


<div class="wrap about-wrap whcom_admin_page">
    <h1><?php echo esc_html_x( "WHMCS Cart & Order Pages - WCOP", "admin", "whcom" ); ?></h1>

    <div class="about-text">
		<?php echo esc_html_x( 'WCOP has beautifully designed order pages, which are feature-rich, user-friendly and functional. Users will not link to WHMCS anymore, and whole order process will complete on WordPress site including user login/ registration if needed.', "admin", "whcom" ) ?>
		<?php echo esc_html_x( 'lets give your site visitors a better checkout experience and convert more customers.', "admin", "whcom" ) ?>
    </div>
    <div id="wcop_admin_logo" class="wp-badge">
		<?php echo esc_html_x( "Version", "admin", "whcom" ) ?><?php echo WCOP_VERSION; ?>
    </div>


    <div class="whcom_admin_page_content whcom_main">
        <div class="whcom_row" style="max-width: 992px;">
            <div class="whcom_col_sm_12">
				<?php if ( $api_test ) { ?>
                    <div class="whcom_alert whcom_alert_success">
                        <div><strong><?php echo esc_html_x( 'WHMCS API Configuration', "admin", "whcom" ) ?></strong>
                        </div>
                        <div><?php echo esc_html_x( 'You have successfully connected with your WHMCS API', "admin", "whcom" ) ?></div>
                    </div>
				<?php }
				else { ?>
                    <div class="whcom_alert whcom_alert_danger">
                        <div><strong><?php echo esc_html_x( 'WHMCS API Configuration', "admin", "whcom" ) ?></strong>
                        </div>
                        <div><?php echo esc_html_x( 'Either you have not entered all information or credentials are not correct.', 'whcom' ) ?></div>
                        <a href="<?php echo admin_url(); ?>admin.php?page=whcom-settings"
                           class=""><?php echo esc_html_x( 'Go to Settings', "admin", "whcom" ) ?></a>
                    </div>
				<?php } ?>

				<?php if ( $api_test ) { ?>
					<?php if ( $helper_test ) { ?>
                        <div class="whcom_alert whcom_alert_success">
                            <div>
                                <strong><?php echo esc_html_x( 'WHMPress Helper Configuration', "admin", "whcom" ) ?></strong>
                            </div>
                            <div><?php echo esc_html_x( 'You have successfully installed and activated WHMPress helper in WHMCS addon modules', "admin", 'whcom' ) ?></div>
                        </div>
					<?php }
					else { ?>
                        <div class="whcom_alert whcom_alert_danger">
                            <div>
                                <strong><?php echo esc_html_x( 'WHMPress Helper Configuration', "admin", "whcom" ) ?></strong>
                            </div>
                            <div><?php echo esc_html_x( 'WHMPress helper is not installed/active in WHMCS addon modules', "admin", "whcom" ) ?></div>
                            <a href="<?php echo admin_url(); ?>admin.php?page=whcom-settings"
                               class=""><?php echo esc_html_x( 'Go to Settings', "admin", "whcom" ) ?></a>
                        </div>
					<?php } ?>
				<?php }
				else { ?>
                    <div class="whcom_alert whcom_alert_info">
                        <div>
                            <strong><?php echo esc_html_x( 'WHMPress Helper Configuration', "admin", "whcom" ) ?></strong>
                        </div>
                        <div><?php echo esc_html_x( 'Kindly configure whmcs settings first by clicking on below button to check if helper is all good or not', "admin", "whcom" ) ?></div>
                        <a href="<?php echo admin_url(); ?>admin.php?page=whcom-settings"
                           class=""><?php echo esc_html_x( 'Go to Settings', "admin", "whcom" ) ?></a>
                    </div>
				<?php } ?>
            </div>
        </div>
        <div class="whcom_row" style="max-width: 992px">
            <div class="whcom_col_sm_6">
                <div class="whcom_panel">
                    <div class="whcom_panel_header whcom_panel_header_white">
                        <strong><?php echo esc_html_x( "Online Support", "admin", "whcom" ) ?></strong>
                    </div>
                    <div class="whcom_panel_body whcom_has_list">
                        <ul class="whcom_list_padded whcom_has_icons whcom_list_bordered">
                            <li class="whcom_has_icon">
                                <span class="whcom_icon_book"></span>
                                <strong><?php echo esc_html_x( "Online Documentation", "admin", "whcom" ) ?></strong><br>
                                <span>
                                    <?php
                                    $links = "<a href='http://docs.whmpress.com/docs/wcop-whmcs-cart-order-pages/getting-started/' target='_blank'>";
                                    $linke = "</a>";
                                    echo sprintf( esc_html_x( 'Here is a %1$s Step by Step Guide %2$s for first time setup.', "admin", "whcom" ), $links, $linke );
                                    ?></span>
                            </li>
                            <li class="whcom_has_icon">
                                <span class="whcom_icon_th-list"></span>
                                <strong><?php echo esc_html_x( "Browse FAQ's", "admin", "whcom" ) ?></strong><br>
                                <span><?php echo esc_html_x( "Instant solutions for most common issues", "admin", "whcom" ) ?></span>
                            </li>
                            <li class="whcom_has_icon">
                                <span class="whcom_icon_users"></span>
                                <strong><?php echo esc_html_x( "Ticket Support", "admin", "whcom" ) ?></strong><br>
                                <span><?php echo esc_html_x( "Direct help from our qualified support team", "admin", "whcom" ) ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="whcom_panel_footer whcom_text_center">
                        <a href="http://support.whmpress.com/" target="_blank" class="whcom_button">
							<?php echo esc_html_x( "Open Support Ticket", "admin", "whcom" ) ?></a>
                    </div>
                </div>
            </div>
            <div class="whcom_col_sm_6">
                <form class="wcop_verify_purchase_form">
                    <input type="hidden" name="action" value="wcop_verify_purchase">
                    <input type="hidden" name="confirm_string"
                           value="<?php esc_html_e( 'Are you sure you want to un-register?', 'whcom' ) ?>">
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x( "Plugin Registration", "admin", "whcom" ) ?></strong>
                        </div>
						<?php if ( is_wcop_verified() ) { ?>
                            <input type="hidden" name="verify_action" value="un_verify">
                            <div class="whcom_panel_body whcom_has_list">
                                <ul class="whcom_list_padded whcom_list_bordered">
                                    <li class="whcom_form_field">
                                        <div class="whcom_alert whcom_alert_success whcom_margin_bottom_0 whcom_alert_with_icon">
                                            <strong><?php esc_html_e( 'Your Copy of WCOP is Verified', 'whcom' ) ?></strong>
                                        </div>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcop_registration_email"><?php esc_html_e( 'Email Address', '' ) ?>
                                            :</label>
                                        <input type="text" id="wcop_registration_email"
                                               value="<?php echo get_option( 'wcop_registration_email', '' ); ?>" disabled readonly>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcop_registration_code"><?php esc_html_e( 'Purchase Code', '' ) ?>
                                            :</label>
                                        <input type="text" id="wcop_registration_code"
                                               value="<?php echo whcom_get_starred_string( get_option( 'wcop_registration_code', '' ) ); ?>"
                                               disabled readonly>
                                    </li>
                                </ul>
                            </div>
                            <div class="whcom_panel_footer">
                                <div class="whcom_form_field whcom_text_center">
                                    <button type="submit" class="whcom_button whcom_button_danger"><?php echo esc_html_x( "Un-Verify", "admin", "whcom" ) ?></button>
                                </div>
                            </div>
						<?php }
						else { ?>
                            <input type="hidden" name="verify_action" value="verify">
                            <div class="whcom_panel_body whcom_has_list">
                                <ul class="whcom_list_padded whcom_list_bordered">
                                    <li class="whcom_form_field">
                                        <div class="whcom_alert whcom_alert_danger whcom_margin_bottom_0 whcom_alert_with_icon">
                                            <strong><?php esc_html_e( 'Your Copy of WCOP is not Verified', 'whcom' ) ?></strong>
                                        </div>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcop_registration_email"><?php esc_html_e( 'Email Address', '' ) ?></label>
                                        <input type="text" id="wcop_registration_email" value="" name="email" required>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcop_registration_code"><?php esc_html_e( 'Purchase Code', '' ) ?></label>
                                        <input type="text" id="wcop_registration_code" value="" name="purchase_code"
                                               required>
                                    </li>
                                </ul>
                            </div>
                            <div class="whcom_panel_footer">
                                <div class="whcom_form_field whcom_text_center">
                                    <button type="submit"
                                            class="whcom_button whcom_button_primary"><?php echo esc_html_x( "Verify", "admin", "whcom" ) ?></button>
                                </div>
                            </div>
						<?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div style="clear: both"></div>
</div>

