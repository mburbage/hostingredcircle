<?php

//show front menu where applicable
if (wcap_show_front_menu()) {
    include_once $this->Path . "/views/top_links_front.php";
}


?>
<div class="">

	<div class="wcap whcom_row">
        <div class="whcom_col_2"></div>
		<div class="whcom_col_sm_8 whcom_text_center">
            <div class="whcom_margin_bottom_15"></div>
            <div class="whcom_page_heading whcom_margin_bottom_15">
                <?php esc_html_e( "Lost Password Reset", "whcom" ) ?>
            </div>


            <div id="success_message" style="display: none" class="whcom_alert whcom_alert_success">
                    <strong><?php esc_html_e("Password Reset Successful", "whcom" ) ?></strong>
                <p>
                    <?php esc_html_e("Your password has now been reset. Continue to the client area", "whcom" ) ?>
                </p>
            </div>
            <div id="error_message" class="whcom_alert whcom_alert_danger" style="display: none;">
            </div>



            <?php esc_html_e("Please enter your desired new password below.","whcom" );?>
			<?php if ( wcap_validate_reset_password_url( $_POST ) ) { ?>
				<form id="wcap_update_password_form1">
					<input type="hidden" name="action" value="wcap_requests">
					<input type="hidden" name="what" value="update_whmcs_client_password">
					<input type="hidden" name="email" value="<?php echo @$_POST["email"] ?>">
					<input type="hidden" name="token" value="<?php echo @$_POST["token"] ?>">
					<input type="reset" style="display: none">

					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="new_password" class="main_label"><?php esc_html_e( "New Password", "whcom" ); ?></label>
						<input type="password" name="password1" id="new_password" required="required"
						       title="<?php esc_html_e("Password required at least 8 characters", "whcom" ); ?>" data-rule-minlength="8">
                    </div>
                        <div class="whcom_alert whcom_alert_info">
                            <div class="whcom_text_bold">
                                <?php esc_html_e("Tips for a good password", "whcom" ); ?>
                            </div>
                            <?php esc_html_e("Use both upper and lowercase characters Include at least one symbol (# $ ! % & etc...) Don't use dictionary words", "whcom" ); ?>
                        </div>
					<div class="whcom_form_field whcom_form_field_horizontal">
						<label for="new_password_2" class="main_label"><?php esc_html_e( "New password Again", "whcom" ); ?></label>
						<input data-rule-equalto="#new_password" type="password" name="password2" id="new_password_2"
						       title="<?php esc_html_e("Password must match with password 1", "whcom" ); ?>" required="required" data-rule-minlength="8">
					</div>
					<div class="whcom_form_field whcom_text_center">
						<button type="submit" class="whcom_button"><?php esc_html_e( "Save Changes", "whcom" ); ?></button>
					</div>
				</form>
			<?php } else { ?>
		        <div class="wp_error">
			        <h3><?php echo __("Invalid reset link or reset link expired", "whcom" ) ?></h3>
		        </div>
			<?php } ?>
		</div>
        <div class="whcom_col_2"></div>
	</div>
</div>


<script>
	jQuery(function(){
		jQuery("#wcap_update_password_form1").validate();
	});
</script>