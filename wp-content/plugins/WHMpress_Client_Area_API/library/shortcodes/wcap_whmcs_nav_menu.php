<?php
$ca_url = ( ! empty( $args['ca_url'] ) ) ? $argc['ca_url'] : site_url( '/client-area/' );
?>

<li class="menu-item menu-item-has-children wcap_whmcs_universal_nav">
	<?php if ( whcom_is_client_logged_in() ) { ?>
		<a href="#" style="outline: none;"><span><?php echo esc_html_x( "Hello", "menu", "whcom" ) . " " . $this->get_user_data( "client_firstname" ); ?></span></a>
		<ul class="sub-menu">
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=profile">
					<span><?php esc_html_e( 'Edit Account Details', "whcom" ) ?></span>
				</a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=contacts">
					<span><?php esc_html_e( 'Contacts/Sub-Accounts', "whcom" ) ?></span>
				</a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=change_password">
					<span><?php esc_html_e( 'Change Password', "whcom" ) ?></span>
				</a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=email_history">
					<span><?php esc_html_e( 'Email History', "whcom" ) ?></span>
				</a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=process_logout">
					<span><?php esc_html_e( 'Logout', "whcom" ) ?></span>
				</a>
			</li>
		</ul>
	<?php }
	else { ?>
		<a href="#" style="outline: none;"><span><?php esc_html_e( 'Account', "whcom" ) ?></span></a>
		<ul class="sub-menu">
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=login"><span><?php esc_html_e( 'Login', "whcom" ) ?></span></a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=create_client_account"><span><?php esc_html_e( 'Register', "whcom" ) ?></span></a>
			</li>
			<li class="menu-item">
				<a class="wcap_load_page" href="<?php echo $ca_url ?>?whmpca=password_reset"><span><?php esc_html_e( 'Forgot Password?', "whcom" ) ?></span></a>
			</li>
		</ul>
	<?php } ?>
</li>