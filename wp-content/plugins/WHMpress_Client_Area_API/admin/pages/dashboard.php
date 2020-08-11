<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>


<div id="wcap_admin_about" class="wrap wcap_admin_about whcom_admin_page wcap_admin_wrapper about-wrap">
    <h2></h2>
	<h1>WHMCS Client Area (WCAP)</h1>

	<div class="about-text">
		<?php esc_html_e('WCAP - WHMCS Client Area Plugin brings WHMCS client area (mainly the features within client login) inside WP. WCAP will integrate products, services, domains, invoices and support areas in WordPress frontend, where your client will be able to login and manage their account, instead of login to WHMCS',"admin", "whcom" )?>
	</div>
	<div id="wcap_admin_logo" class="wp-badge">
		Version <?php echo WCAP_VERSION; ?>
	</div>

	<div class="wcap_admin_content whcom_main">
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
                                    $links = "<a href='http://docs.whmpress.com/docs/wcap-whmcs-client-area-api/getting-started/' target='_blank'>";
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
                <form class="wcap_verify_purchase_form" method="post">
                    <input type="hidden" name="action" value="wcap_verify_purchase">
                    <input type="hidden" name="confirm_string"
                           value="<?php esc_html_e( 'Are you sure you want to un-register?', 'whcom' ) ?>">
                    <div class="whcom_panel">
                        <div class="whcom_panel_header whcom_panel_header_white">
                            <strong><?php echo esc_html_x( "Plugin Registration", "admin", "whcom" ) ?></strong>
                        </div>
						<?php if ( is_wcap_verified() ) { ?>
                            <input type="hidden" name="verify_action" value="un_verify">
                            <div class="whcom_panel_body whcom_has_list">
                                <ul class="whcom_list_padded whcom_list_bordered">
                                    <li class="whcom_form_field">
                                        <div class="whcom_alert whcom_alert_success whcom_margin_bottom_0 whcom_alert_with_icon">
                                            <strong><?php esc_html_e( 'Your Copy of WCAP is Verified', 'whcom' ) ?></strong>
                                        </div>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcap_registration_email"><?php esc_html_e( 'Email Address', '' ) ?>
                                            :</label>
                                        <input type="text" id="wcap_registration_email"
                                               value="<?php echo get_option( 'wcap_registration_email', '' ); ?>" disabled readonly>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcap_registration_code"><?php esc_html_e( 'Purchase Code', '' ) ?>
                                            :</label>
                                        <input type="text" id="wcap_registration_code"
                                               value="<?php echo whcom_get_starred_string( get_option( 'wcap_registration_code', '' ) ); ?>"
                                               disabled readonly>
                                    </li>
                                </ul>
                            </div>
                            <div class="whcom_panel_footer">
                                <div class="whcom_form_field whcom_text_center">
                                    <button type="submit"
                                            class="whcom_button whcom_button_danger"><?php echo esc_html_x( "Un-Verify", "admin", "whcom" ) ?></button>
                                </div>
                            </div>
						<?php }
						else { ?>
                            <input type="hidden" name="verify_action" value="verify">
                            <div class="whcom_panel_body whcom_has_list">
                                <ul class="whcom_list_padded whcom_list_bordered">
                                    <li class="whcom_form_field">
                                        <div class="whcom_alert whcom_alert_danger whcom_margin_bottom_0">
                                            <strong><?php esc_html_e( 'Your Copy of WCAP is not Verified', 'whcom' ) ?></strong>
                                        </div>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcap_registration_email"><?php esc_html_e( 'Email Address', '' ) ?></label>
                                        <input type="text" id="wcap_registration_email" value="" name="email" required>
                                    </li>
                                    <li class="whcom_form_field whcom_form_field_horizontal">
                                        <label for="wcap_registration_code"><?php esc_html_e( 'Purchase Code', '' ) ?></label>
                                        <input type="text" id="wcap_registration_code" value="" name="purchase_code"
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

