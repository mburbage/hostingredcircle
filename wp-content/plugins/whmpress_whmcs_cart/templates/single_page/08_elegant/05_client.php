<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>
<?php if ( whcom_is_client_logged_in() ) { ?>
	<div class="wcop_sp_section_heading">
		<i class="whcom_icon_user-3"></i>
		<span><?php esc_html_e( "Billing Info", "whcom" ) ?></span>
	</div>
	<div class="wcop_sp_section_content wcop_logged_in_content" id="wcop_sp_login_register_container">
		<?php echo whcom_render_logged_in_client_form(); ?>
		<div class="whcom_form_field whcom_text_center">
			<button id="wcop_login_form_logout_button" class="whcom_button"><?php esc_html_e( 'Log Out', "whcom" ) ?></button>
		</div>
	</div>
<?php }
else { ?>
	<div class="wcop_sp_section_heading">
		<i class="whcom_icon_credit-card"></i>
		<span><?php esc_html_e( "Billing Info", "whcom" ) ?></span>
	</div>
	<div class="wcop_sp_section_content" id="wcop_sp_login_register_container">
		<div class="wcop_register_form" id="wcop_sp_register_account">
			<strong style="padding-left: 10px;"><?php esc_html_e( 'Already Registered?', "whcom" ) ?></strong>
			<button id="wcop_register_form_login_toggle" type="button" class="whcom_button"><?php esc_html_e( 'LogIn', "whcom" ) ?></button>
			<?php echo whcom_elegant_render_register_form_fields( 'client_' ); ?>
		</div>
		<div class="wcop_login_form" id="wcop_sp_user_login" style="display: none">
			<?php echo whcom_elegant_render_login_form_fields(); ?>
            <button id="wcop_login_form_login_button" class="whcom_button"><?php esc_html_e( 'Log In', "whcom" ) ?></button>
			<button id="wcop_login_form_register_toggle" class="whcom_button whcom_button_secondary"><?php esc_html_e( 'Go Back', "whcom" ) ?></button>
		</div>
	</div>
	<input type="hidden" name="wcop_sp_client_type" value="register" id="wcop_sp_client_type_login">
<?php } ?>



