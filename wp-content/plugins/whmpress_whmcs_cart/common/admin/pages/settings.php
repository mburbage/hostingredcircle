<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$api_test    = whcom_api_test();
$helper_test = whcom_helper_test();

?>

<div class="wrap whcom_main">
	<h2></h2>
	<div class="whcom_margin_bottom_15">
		<h1><?php echo esc_html_x("Settings", "admin", "whcom") ?></h1>
	</div>
	<?php if ( ! empty( $_GET["settings-updated"] ) && $helper_test ) {
		if ( ( esc_attr( get_option( 'whcom_whmcs_invoice_custom_templates' ), 'no' ) == 'yes' ) && ! empty( esc_url( get_option( 'whcom_whmcs_invoice_redirect_url' ) ) ) ) {
			$status = whcom_process_helper(['action' => 'whcom_custom_template_on', 'whcom_whmcs_invoice_redirect_url' => esc_url( get_option( 'whcom_whmcs_invoice_redirect_url' ) )]);
			echo $status['status'] . ': ' . $status['message'];
			if ($status['status'] == 'OK') {
				update_option('whcom_whmcs_invoice_custom_templates_status', 'Yes');
			}
			else {
				update_option('whcom_whmcs_invoice_custom_templates_status', 'No');
			}
		}
		else {
			$status = whcom_process_helper(['action' => 'whcom_custom_template_off']);
			echo $status['status'] . ': ' . $status['message'];
			if ($status['status'] == 'OK') {
				update_option('whcom_whmcs_invoice_custom_templates_status', 'No');
			}
		}
	} ?>
	<form method="post" action="options.php">
		<?php settings_fields( 'whcom_whmcs' ); ?>
		<?php if ( $helper_test ) { ?>
			<div class="whcom_alert whcom_alert_success whcom_alert_with_icon">
				<div><strong><?php echo esc_html_x( 'WHMPress Helper Configuration', "admin", 'whcom' ) ?></strong></div>
				<div><?php echo esc_html_x( 'You have successfully installed and activated WHMPress helper in WHMCS addon modules', "admin", 'whcom' ) ?></div>
			</div>
		<?php }
		else { ?>
			<div class="whcom_alert whcom_alert_danger whcom_alert_with_icon">
				<div><strong><?php echo esc_html_x( 'WHMPress Helper Configuration', "admin", 'whcom' ) ?></strong></div>
				<div><?php echo esc_html_x( 'WHMPress helper is not installed/active in WHMCS addon modules', "admin", 'whcom' ) ?></div>
			</div>
			<div class="whcom_alert whcom_alert_info whcom_alert_with_icon">
				<?php echo esc_html_x( 'WHMpress helper takes WHMCS-WP integration to next level. It is an important component in the integration process and is installed on WHMCS.', "admin", 'whcom' ) ?>
				<?php echo esc_html_x( 'Visit below link for instructions on how to install and activate WHMPress helper', "admin", 'whcom' ) ?>
				<div><a href="http://docs.whmpress.com/docs/wcom/whmpress-helper/"><?php echo esc_html_x( 'Helper Docs', "admin", 'whcom' ) ?></a></div>
			</div>
		<?php } ?>
		<?php if ( $api_test ) { ?>
			<div class="whcom_alert whcom_alert_success whcom_alert_with_icon">
				<div><strong><?php echo esc_html_x( 'WHMCS API Configuration',"admin", "whcom" ) ?></strong></div>
				<div><?php echo esc_html_x( 'You have successfully connected with your WHMCS API', "admin", 'whcom' ) ?></div>
			</div>
		<?php }
		else {
			?>
			<div class="whcom_alert whcom_alert_danger whcom_alert_with_icon">
				<div><strong><?php echo esc_html_x( 'WHMCS API Configuration',"admin", "whcom" ) ?></strong></div>
				<div><?php echo esc_html_x( 'Either you have not entered all information or your WHMCS API can\'t be accessed using below credentials.', 'whcom' ) ?></div>
			</div>
		<?php } ?>

		<div class="whcom_panel">
			<div class="whcom_panel_header whcom_panel_header_white">
				<span><?php echo esc_html_x( 'WHMCS Authentication Credentials', "admin", 'whcom' ) ?></span>
			</div>
			<div class="whcom_panel_body">

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_admin_url'; ?>
					<label for="whmcs_admin_url">
						<?php echo esc_html_x( 'WHMCS Frontend URL (WHMCS homepage)', "admin", 'whcom' ) ?>
						<a href="http://docs.whmpress.com/docs/wcom/others/how-i-know-my-whmcs-system-url/"
						   target="_blank" style="text-decoration: none;"><i class="whcom_icon_help-circled"></i></a>
					</label>
					<input id="whmcs_admin_url" type="url" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_admin_user' ?>
					<label for="<?php echo "$field" ?>">
						<?php
						echo "<strong>".esc_html_x( 'WHMCS API Identifier', "admin", 'whcom' )."</strong>";
						echo "<br>";
						echo esc_html_x( '(or you can also use your WHMCS admin user name)', "admin", 'whcom' );
						?>
					</label>
					<input id="<?php echo "$field" ?>" type="text" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_admin_pass' ?>
					<label for="<?php echo "$field" ?>"><?php
						echo "<strong>" . esc_html_x( 'WHMCS API Secret', "admin", 'whcom' ) . "</strong>";
						echo "<br>";
						echo esc_html_x( '(or your admin password)', "admin", 'whcom' );
						?>
					</label>
					<input id="<?php echo "$field" ?>" type="password" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_admin_api_key' ?>
					<label for="<?php echo "$field" ?>">
						<?php echo esc_html_x( 'WHMCS API Key', "admin", 'whcom' ) ?>
						<a href="http://docs.whmpress.com/whmcs-cart-order-pages/creating-autoauth-key-in-whmcs/"
						   target="_blank"><i class="whcom_icon_help-circled"></i></a>
					</label>
					<input id="<?php echo "$field" ?>" type="text" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_admin_auth_key' ?>
					<label for="<?php echo "$field" ?>">
						<?php echo esc_html_x( 'WHMCS Invoice Auth Key', "admin", 'whcom' ) ?>
						<a href="http://docs.whmpress.com/whmcs-cart-order-pages/creating-autoauth-key-in-whmcs/"
						   target="_blank" style="text-decoration: none;"><i class="whcom_icon_help-circled"></i></a>
					</label>
					<input id="<?php echo "$field" ?>" type="text" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>


				<div class="whcom_text_center">
					<button type="submit"
					        class="whcom_button"><?php echo esc_html_x( 'Save Settings', "admin", 'whcom' ) ?></button>
				</div>

			</div>
		</div>

		<div class="whcom_panel">
			<div class="whcom_panel_header whcom_panel_header_white">
				<span><?php echo esc_html_x( 'Invoice Options', "admin", 'whcom' ) ?></span>
			</div>
			<div class="whcom_panel_body">

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_invoice_custom_templates' ?>
					<label for="<?php echo "$field" ?>">
						<?php echo esc_html_x( 'Use custom WHMCS templates', "admin", 'whcom' ) ?>:
					</label>
					<input id="<?php echo "$field" ?>" type="checkbox" name="<?php echo "$field" ?>"
					       value="yes" <?php echo ( esc_attr( get_option( $field ), 'no' ) == 'yes' ) ? 'checked' : ''; ?>>
					<div class="whcom_checkbox_container whcom_alert whcom_alert_info">
						<?php echo esc_html_x( 'recommended for a smoother client checkout experience, If your gateway do not allow iframes, you must use this option.', "admin", 'whcom' ) ?>
					</div>
				</div>

				<div class="whcom_form_field whcom_form_field_horizontal">
					<?php $field = 'whcom_whmcs_invoice_redirect_url' ?>
					<label for="<?php echo "$field" ?>">
						<?php echo esc_html_x( 'WHMCS Invoice Redirect URL', "admin", 'whcom' ) ?>
					</label>
					<input id="<?php echo "$field" ?>" type="text" name="<?php echo "$field" ?>"
					       value="<?php echo esc_attr( get_option( $field ) ); ?>">
				</div>


				<div class="whcom_text_center">
					<button type="submit"
					        class="whcom_button"><?php echo esc_html_x( 'Save Settings', "admin", 'whcom' ) ?></button>
				</div>

			</div>
		</div>

	</form>
</div>

