<div class="wrap whmp_wrap">
	<?php
	## If styles are generic/default and (active_theme/whmpress exists or whmpress_folder/themes/active_theme folder exists)
	if ( ( is_dir( get_template_directory() . "/whmpress/" ) || is_dir( WHMP_PLUGIN_PATH . "themes/" . basename( get_template_directory() ) ) ) && get_option( 'load_sytle_orders' ) == '' ) {
		?>
		<div class="notice notice-success is-dismissible">
			<h3>WHMPress</h3>
            <p><?php echo esc_html_x( 'Matching Templates found for your active theme ','admin', 'whmpress' ). '<b>'. basename( get_template_directory() ) . '</b>' . esc_html_x( ' You can enable ','admin', 'whmpress' ) . '<b>' . basename( get_template_directory() ) . '</b>' . esc_html_x( ' support by selecting Template Source from ','admin', 'whmpress' ) . '<a href="admin.php?page=whmp-settings#styles">Settings > Styles</a>';?></p>
		</div>
		<?php
	}
	?>
	<h2></h2>
	
	<!--<div class="whmp-main-title"><span class="whmp-title">WHMpress</span> <?php /*_e("Sync WHMCS", "whmpress") */ ?></div>-->
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x('Dashboard','admin','whmpress') ?></a>
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x('Products/Services','admin','whmpress') ?></a>
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x('Settings','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x('Pricing Tables','admin', 'whmpress')?></a>
		<a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x('Sync WHMCS','admin','whmpress') ?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info','admin', 'whmpress')?></a>
	</h2>
	
	<div class="whmp_page_description">
		<p><?php echo esc_html_x( "WHMpress makes your life easy by fetching all the services related information from WHMCS. Once you Sync WHMCS, all the services are fetched from WHMCS and are cached and made available in WHMpress for quick access",'admin', "whmpress" ) ?></p>
        <?php
        $server_url = get_option("db_server");
        if($server_url == "nexum-whmcs.whmpress.com"){
           echo "<p style='color: #0073AA;'>" . esc_html_x( "As part of demo data import WHMPress is connected with demo WHMCS install. Please change information below to connect to your WHMCS",'admin', "whmpress" ) . "</p>";
        }
        ?>
	</div>
	<?php
	if ( @$_GET["settings-updated"] == "true" ) {
		echo whmp_fetch_data();
	}
	$options = get_option( 'whmp_settings' );
	?>
	<form method="post" action="options.php">
		<?php settings_fields( 'whmp_sync_settings' );
		do_settings_sections( 'whmp_sync_settings' );
		?>
		<input type="hidden" name="sync_run" value="1"/>
		<table class="form-table">
			<tr valign="top">
				<td style="width:30%;" scope="row"><?php echo esc_html_x( "WHMCS Database Server",'admin', "whmpress" ) ?></td>
				<td><input style="width:100%;" required="required" name="db_server"
				           value="<?php echo esc_attr( get_option( 'db_server' ) ); ?>"/></td>
			</tr>
			<tr valign="top">
				<td scope="row"><?php echo esc_html_x( "WHMCS Database Name",'admin', "whmpress" ) ?></td>
				<td><input style="width:100%;" required="required" name="db_name"
				           value="<?php echo esc_attr( get_option( 'db_name' ) ); ?>"/></td>
			</tr>
			<tr valign="top">
				<td scope="row"><?php echo esc_html_x( "WHMCS Database User",'admin', "whmpress" ) ?></td>
				<td><input style="width:100%;" required="required" name="db_user"
				           value="<?php echo esc_attr( get_option( 'db_user' ) ); ?>"/></td>
			</tr>
			<tr valign="top">
				<td scope="row"><?php echo esc_html_x( "WHMCS Database Password",'admin', "whmpress" ) ?></td>
				<td><input value="<?php echo get_option( "db_pass" ) ?>" type="password" style="width:80%;"
				           name="db_pass"/>
					<label><input <?php echo get_option( 'whmp_save_pwd' ) == "1" ? "checked=checked" : "" ?>
							type="checkbox" name="whmp_save_pwd" value="1"/> Save password</label>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="color:#CC0000;font-style:italic;text-align:right;"><b>Note:</b> Saving password
					is not recommended on production server.
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><?php submit_button( esc_html_x( 'Sync WHMCS','admin', "whmpress" ), 'primary', 'wpdocs-save-settings', true ); ?></td>
			</tr>
		</table>
	</form>
</div>