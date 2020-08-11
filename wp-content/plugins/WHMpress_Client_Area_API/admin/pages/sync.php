<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." ); ?>

<style>
    label.disable {
        color: #c6c6c6;
    }
</style>

<div class="wcap_admin_row" style="max-width: 992px">
	<?php

	if ( isset( $_GET["settings-updated"] ) && $_GET["settings-updated"] == "true" ) { ?>
		<?php
		if ( get_option( "wcapfield_perform_one_time_sync" ) == "Yes" ) {


			if ( get_option( "wcapfield_sync_direction" ) == "whmcs_to_wp" ) {
				$rows = $this->get_whmcs_users();
				$rows = $rows['data'];
				if ( ob_get_level() == 0 ) {
					ob_start();
				}
				foreach ( $rows as $row ) {
					echo "Syncing <b>" . $row["email"] . " ....</b> ";
					if ( $this->is_wp_user( $row["email"] ) ) {
						echo "<br>Already exists. Updating. ";
						echo $this->update_wp_user_from_whmcs( $row );

						ob_flush();
						flush();
					}
					else {
						echo "<br>Creating New User<br>";
						ob_flush();
						flush();
						$response = $this->create_wp_user_from_whmcs_row( $row );
						if ( $response == "OK" ) {
							echo "User Created";
						}
						else {
							echo $response;
						}
						ob_flush();
						flush();
					}

					echo "<br>";
				}

				ob_end_flush();
			}
			else {
				$rows     = $this->get_wp_users();
				$response = $this->update_whmcs_users( [ "postdata" => $rows ] );
				if ( $this->is_json( $response ) ) {
					$response = json_decode( $response, true );
					$response = $response["data"];
					echo $response;
				}
				else {
					echo $response;
				}
			}

		}
		?>
	<?php } ?>

    <form method="post" action="options.php">
		<?php settings_fields( 'wcap_sso' ); ?>
		<?php $roles = get_editable_roles(); ?>

        <div class="wcap_admin_column_12">
            <div class="wcap_admin_card">
                <div class="wcap_card_heading">
                    <h3><?php echo esc_html_x( 'SSO Settings', "admin,", "whcom" ) ?></h3>
                </div>
                <div class="wcap_card_body">
                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_4 wcap_admin_text_right">
                                <label for="wcapfield_enable_sso"><?php echo esc_html_x( "Enable WHMCS-WP SSO", "admin", "whcom" ) ?></label>
                            </div>
                            <div class="wcap_admin_column_8">
                                <label for="wcapfield_enable_sso">
                                    <input value="1" <?php echo get_option( "wcapfield_enable_sso" ) == "1" ? "checked" : "" ?>
                                           name="wcapfield_enable_sso" id="wcapfield_enable_sso" type="checkbox">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_4 wcap_admin_text_right">
                                <label
                                        for="wcapfield_hide_wp_admin_bar"><?php echo esc_html_x( "Hide WP Admin bar", "admin", "whcom" ) ?> </label>
                            </div>
                            <div class="wcap_admin_column_8">
                                <label for="wcapfield_hide_wp_admin_bar">
                                    <input
                                            value="1" <?php echo get_option( "wcapfield_hide_wp_admin_bar" ) == "1" ? "checked" : "" ?>
                                            name="wcapfield_hide_wp_admin_bar" id="wcapfield_hide_wp_admin_bar"
                                            type="checkbox">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_4 wcap_admin_text_right">
                                <label><?php echo esc_html_x( "Exclude WP roles from SSO", "admin", "whcom" ) ?> </label>
                            </div>
                            <div class="wcap_admin_column_8">
								<?php
								$exclude_roles = is_array( get_option( "wcapfield_exclude_sync_roles" ) ) ? get_option( "wcapfield_exclude_sync_roles" ) : [];
								foreach ( $roles as $k => $role ) { ?>
                                    <label class="label_inline">
                                        <input <?php echo in_array( $k, $exclude_roles ) ? "checked" : "" ?>
                                                type="checkbox" name="wcapfield_exclude_sync_roles[]"
                                                value="<?php echo $k ?>">
										<?php echo $role["name"] ?>
                                    </label>
								<?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_4 wcap_admin_text_right">
                                <label
                                        for="wcapfield_new_user_profile_fields"><?php echo esc_html_x( "Sync Address / Profile Fields", "admin", "whcom" ) ?> </label>
                            </div>
                            <div class="wcap_admin_column_8">
                                <label for="wcapfield_new_user_profile_fields">
                                    <input
                                            value="1" <?php echo get_option( "wcapfield_new_user_profile_fields" ) == "1" ? "checked" : "" ?>
                                            name="wcapfield_new_user_profile_fields"
                                            id="wcapfield_new_user_profile_fields"
                                            type="checkbox">
                                </label>
                            </div>
                        </div>

                    </div>


                    <div class="wcap_admin_notice wcap_admin_notice_info">
                        <span class="lnr lnr-pointer-right"></span>
						<?php echo esc_html_x( 'NOTE: By default WHMCS requires address fields for user creation, while WordPress dont. WCAP create these fileds in WP. Users who are already using address/profile fields from an other plugin, can map those fields with WHMCS fields below', "admin", "whcom" ) ?>
                        <br>
                    </div>

                    <div class="whcom_collapse">
                        <div class="whcom_collapse_toggle" data-collapse="profile-field-mapping">
                            <strong>
                                <i class="whcom_icon_down-open"></i>
								<?php echo esc_html_x( 'WHMCS-WP profile fields mapping', "admin,", "whcom" ) ?>
                            </strong>
                        </div>
                        <div class="whcom_collapse_content" id="profile-field-mapping">
                            <div class="wcap_form_control">
                                <div class="wcap_admin_row">
                                    <div class="wcap_admin_column_3">
                                        <p>
                                            <strong>
												<?php echo esc_html_x( 'WHMCS fields', "admin,", "whcom" ) ?>
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
							<?php
							$custom_fields             = $this->get_client_custom_fields();
							$fields_array              = $this->get_whmcs_record_array();
							$wcapfield_new_user_fields = get_option( 'wcapfield_new_user_fields' );

							foreach ( $fields_array as $field ) {
								?>
                                <div class="wcap_form_control">
                                    <div class="wcap_admin_row">
                                        <div class="wcap_admin_column_3">
                                            <label for="wcapfield_new_user_<?php echo $field ?>">
												<?php echo $field ?>
                                            </label>
                                        </div>
                                        <div class="wcap_admin_column_4">
                                            <input type="text"
                                                   name="wcapfield_new_user_fields[wcapfield_new_user_<?php echo $field ?>]"
                                                   value="<?php echo empty( $wcapfield_new_user_fields[ 'wcapfield_new_user_' . $field ] ) ? "whcom_" . $field : $wcapfield_new_user_fields[ 'wcapfield_new_user_' . $field ] ?>">
                                        </div>
                                    </div>
                                </div>
							<?php }
							foreach ( $custom_fields['data'] as $custom_field ) {
								if ( ! empty( $custom_field['fieldname'] ) ) { ?>
                                    <div class="wcap_form_control">
                                        <div class="wcap_admin_row">
                                            <div class="wcap_admin_column_3">
                                                <label for="wcapfield_new_user_<?php echo $custom_field["fieldname"] ?>">
													<?php echo $custom_field["fieldname"] ?>
                                                </label>
                                            </div>
                                            <div class="wcap_admin_column_4">
                                                <input type="text"
                                                       name="wcapfield_new_user_fields[wcapfield_new_user_<?php echo $custom_field["id"] ?>] ?>]"
                                                       value="<?php echo empty( $wcapfield_new_user_fields[ 'wcapfield_new_user_' . $custom_field["id"] ] ) ? "whcom_" . $custom_field["id"] : $wcapfield_new_user_fields[ 'wcapfield_new_user_' . $custom_field["id"] ] ?>">
                                            </div>
                                        </div>
                                    </div>
									<?php
								}
							} ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="wcap_admin_column_12">
            <div class="wcap_admin_card">
                <div class="wcap_card_heading">
                    <h3><?php echo esc_html_x( 'Sync Settings', "admin,", "whcom" ) ?></h3>
                    <p><?php echo esc_html_x( 'Following options are related to how new users are created and existing are synced in between WHMCS and WordPress when SSO is enabled', "admin", "whcom" ) ?></p>
                </div>
                <div class="wcap_card_body">
                    <p>
                        <strong>
							<?php echo esc_html_x( 'Settings to create users in WordPress', "admin,", "whcom" ) ?>
                        </strong>
                    </p>
                    <div id="whmcs_to_wp_flds" class="wcap_admin_fancy_box">
                        <div class="wcap_form_control">
                            <div class="wcap_admin_row">
                                <div class="wcap_admin_column_4 wcap_admin_text_right">
                                    <label for="wcapfield_new_user_role">
										<?php echo esc_html_x( "Role for new user", "admin", "whcom" ) ?>
                                    </label>
                                </div>
                                <div class="wcap_admin_column_8">
                                    <select name="wcapfield_new_user_role" id="wcapfield_new_user_role">
                                        <option value="subscriber">Subscriber</option>
										<?php foreach ( $roles as $k => $role ) {
											if ( $k == "subscriber" ) {
												continue;
											} ?>
                                            <option <?php echo get_option( "wcapfield_new_user_role" ) == $k ? "selected" : "" ?>
                                                    value="<?php echo $k ?>"><?php echo $role["name"] ?>
                                            </option>
										<?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="wcap_form_control">
                            <div class="wcap_admin_row">
                                <div class="wcap_admin_column_4 wcap_admin_text_right">
                                    <label for="wcapfield_new_user_username">
										<?php echo esc_html_x( "Username for new user", "admin", "whcom" ) ?>
                                    </label>
                                </div>
                                <div class="wcap_admin_column_8">
                                    <select name="wcapfield_new_user_username" id="wcapfield_new_user_username">
                                        <option <?php echo get_option( "wcapfield_new_user_username" ) == 'first_last' ? "selected" : "" ?>
                                                value="first_last"><?php echo esc_html_x( "First Name + Last Name", "admin", "whcom" ) ?></option>
                                        <option <?php echo get_option( "wcapfield_new_user_username" ) == 'email' ? "selected" : "" ?>
                                                value="email"><?php echo esc_html_x( "Email (Recommended)", "admin", "whcom" ) ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <p>
                        <strong>
							<?php echo esc_html_x( 'Settings to create users in WHMCS', "admin,", "whcom" ) ?>
                        </strong>
                    </p>
                    <div id="wp_to_whmcs_flds" class="wcap_admin_fancy_box">
                        <div class="wcap_admin_notice wcap_admin_notice_info">
                            <span class="lnr lnr-pointer-right"></span>
							<?php echo esc_html_x( 'WordPress by default do not have address fields. Select below how to handle empty address while WP users are created in WHMCS. 
                                This only take effect if *Sync Address* is enabled', "admin", "whcom" ) ?>
                        </div>

                        <div class="wcap_form_control">
                            <div class="wcap_admin_row">
                                <div class="wcap_admin_column_4 wcap_admin_text_right">
                                    <label for="wcapfield_new_user_address_phone_fields">
										<?php echo esc_html_x( "How to handle empty address fields?", "admin", "whcom" ) ?>
                                    </label>
                                </div>
                                <div class="wcap_admin_column_8">
                                    <select name="wcapfield_new_user_address_phone_fields"
                                            id="wcapfield_new_user_address_phone_fields">

                                        <option <?php echo get_option( "wcapfield_new_user_address_phone_fields" ) == 'empty_data' ? "selected" : "" ?>
                                                value="dummy_data"><?php echo esc_html_x( "Leave empty fields as its", "admin", "whcom" ) ?></option>

                                        <option <?php echo get_option( "wcapfield_new_user_address_phone_fields" ) == 'dummy_data' ? "selected" : "" ?>
                                                value="dummy_data"><?php echo esc_html_x( "Fill with Dummy Data", "admin", "whcom" ) ?></option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_12 wcap_admin_text_center">
                                <button type="submit" class="button button-primary">
									<?php echo esc_html_x( "Save SSO Settings", "admin", "whcom" ) ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="wcap_admin_column_12">

            <div class="wcap_admin_card">

                <div class="wcap_card_heading">
                    <h3><?php echo esc_html_x( 'One Time Sync', "admin,", "whcom" ) ?></h3>
                    <p><?php echo esc_html_x( "While SSO is enabled it keeps track and syncs users between WHMCS and WordPress. For the existing users (those are created before SSO is activated), you need to run sync process below. This is a one time task and is needed for a smooth SSO experience.", "admin", "whcom" ) ?></p>

                </div>
                <div class="wcap_card_body">
                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_4 wcap_admin_text_right">
                                <label for="wcapfield_sync_direction">
									<?php echo esc_html_x( "Sync. Direction", "admin", "whcom" ) ?>
                                </label>
                            </div>
                            <div class="wcap_admin_column_8">
                                <select name="wcapfield_sync_direction" id="wcapfield_sync_direction">
                                    <option <?php echo get_option( "wcapfield_sync_direction" ) == "wp_to_whmcs" ? "selected" : "" ?>
                                            value="whmcs_to_wp"><?php echo esc_html_x( "WHMCS to WP", "admin", "whcom" ) ?></option>
                                    <option <?php echo get_option( "wcapfield_sync_direction" ) == "wp_to_whmcs" ? "selected" : "" ?>
                                            value="wp_to_whmcs"><?php echo esc_html_x( "WP to WHMCS", "admin", "whcom" ) ?>
                                    </option>
                                </select>
								<?php echo esc_html_x( "You can run sync users from WHMCS to WP or other way around, or both to suit your needs", "admin", "whcom" ) ?>
                            </div>
                        </div>
                    </div>

                    <div class="wcap_form_control">
                        <div class="wcap_admin_row">
                            <div class="wcap_admin_column_12 wcap_admin_text_center">
                                <input type="hidden" value="No" name="wcapfield_perform_one_time_sync">
                                <button type="submit" class="button button-primary" id="wcap_one_time_sync_button">
									<?php echo esc_html_x( "Perform one time sync", "admin", "whcom" ) ?>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>