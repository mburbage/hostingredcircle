<?php
/**
 * @package Admin
 *
 */

if ( ! defined( 'WHMP_VERSION' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


global $WHMPress;
$lang   = $WHMPress->get_current_language();
$extend = empty( $lang ) ? "" : "_" . $lang;

global $wpdb;
$countries  = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}whmpress_countries` ORDER BY `country_name`" );
$WHMP       = new WHMPress;
$currencies = $WHMP->get_currencies();

$settings_file = str_replace( "\\", "/", get_stylesheet_directory() ) . "/whmpress/settings.ini";
if ( ! is_file( $settings_file ) ) {
	$settings_file = str_replace( "\\", "/", WHMP_PLUGIN_DIR ) . "/themes/" . basename( get_stylesheet_directory() ) . "/settings.ini";
}

$newTR = "<tr>";
$newTR .= '<td><select name="whmp_countries_currencies[country][]">';
$newTR .= '<option value="">-- Select Country --</option>';
foreach ( $countries as $country ):
	$newTR .= '<option value="' . $country->country_code . '">' . $country->country_name . '</option>';
endforeach;
$newTR .= '</select>';
$newTR .= '</td>';
$newTR .= '<td>';
$newTR .= '<select name="whmp_countries_currencies[currency][]">';
$newTR .= '<option value="">-- Currency --</option>';
foreach ( $currencies as $currency ) {
	$newTR .= '<option value="' . $currency["id"] . '">' . $currency["code"] . '</option>';
}
$newTR .= '</select> ';
$newTR .= '[<a title="Remove this country" href="javascript:;" onclick="Remove(this)">X</a>]';
$newTR .= '</td>';
$newTR .= '</tr>';
$newTR = str_replace( '"', "'", $newTR );

global $wpdb; ?>
<div class="full_page_loader">
	<div class="whmp_loader"><?php esc_html_x( "Loading",'admin', "whmpress" ) ?>...</div>
</div>
<div class="wrap whmp_wrap">
	<h2></h2>
	<!--<div class="whmp-main-title"><span class="whmp-title">WHMpress</span> <?php /*_e("Settings", "whmpress") */ ?></div>-->
	<h2 class="nav-tab-wrapper">
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-dashboard"><?php echo esc_html_x('Dashboard','admin', 'whmpress')?></a>
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-services"><?php echo esc_html_x('Products/Services','admin', 'whmpress')?></a>
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-settings"><?php echo esc_html_x('Settings','admin', 'whmpress')?></a>
        <a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-pricing-tables"><?php echo esc_html_x('Pricing Tables','admin', 'whmpress')?></a>
		<a class="nav-tab" href="<?php echo admin_url() ?>admin.php?page=whmp-sync"><?php echo esc_html_x('Sync WHMCS','admin', 'whmpress')?></a>
		<a class="nav-tab nav-tab-active" href="<?php echo admin_url() ?>admin.php?page=whmp-debug"><?php echo esc_html_x('Debug info','admin', 'whmpress')?></a>
	</h2>
    <div id="debug_info">
        <table class="fancy" style="width: 100%;">
            <tr>
                <th colspan="2"><?php echo esc_html_x( "WordPress",'admin', "whmpress" ) ?></th>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Site URL",'admin', "whmpress" ) ?></td>
                <td><?php echo site_url(); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Home URL",'admin', "whmpress" ) ?></td>
                <td><?php echo home_url(); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Version",'admin', "whmpress" ) ?></td>
                <td><?php bloginfo( 'version' ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Multisite",'admin', "whmpress" ) ?></td>
                <td><?php if ( is_multisite() ) {
						echo esc_html_x( 'Yes','admin', 'whmpress' );
					}
					else {
						echo esc_html_x( 'No','admin', 'whmpress' );
					} ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Language",'admin', "whmpress" ) ?></td>
                <td><?php echo get_locale(); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Debug Mode",'admin', "whmpress" ) ?></td>
                <td><?php if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                        echo esc_html_x( 'Yes','admin', 'whmpress' );
					}
					else {
                        echo esc_html_x( 'No','admin', 'whmpress' );
					} ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Active Plugins",'admin', "whmpress" ) ?></td>
                <td><?php echo count( (array) get_option( 'active_plugins' ) ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Max Upload Size",'admin', "whmpress" ) ?></td>
                <td>
					<?php
					$wp_upload_max     = wp_max_upload_size();
					$server_upload_max = intval( str_replace( 'M', '', ini_get( 'upload_max_filesize' ) ) ) * 1024 * 1024;

					if ( $wp_upload_max <= $server_upload_max ) {
						echo size_format( $wp_upload_max );
					}
					else {
						echo '<span class="whmp_danger">' . sprintf( esc_html_x( '%s (The server only allows %s)','admin', 'whmpress' ), size_format( $wp_upload_max ), size_format( $server_upload_max ) ) . '</span>';
					}
					?>
                </td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WordPress Memory Limit",'admin', "whmpress" ) ?></td>
                <td><?php echo WP_MEMORY_LIMIT; ?></td>
            </tr>

            <tr>
                <th colspan="2"><?php echo esc_html_x( "Server Info",'admin', "whmpress" ) ?></th>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "PHP Version",'admin', "whmpress" ) ?></td>
                <td><?php if ( function_exists( 'phpversion' ) ) {
						echo esc_html( phpversion() );
					} ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Server Software",'admin', "whmpress" ) ?></td>
                <td><?php echo esc_html( @$_SERVER['SERVER_SOFTWARE'] ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "MySQLi Extension",'admin', "whmpress" ); ?></td>
                <td><?php echo function_exists( 'mysqli_connect' ) ? esc_html_x( "Installed",'admin', "whmpress" ) : "<span class='whmp_danger'>" . esc_html_x( "Not Installed",'admin', "whmpress" ) . "</span>"; ?></td>
            </tr>
            <tr>
                <td class="row-title">cURL Extension</td>
                <td><?php echo function_exists( 'curl_version' ) ? esc_html_x( "Installed",'admin', "whmpress" ) : "<span class='whmp_danger'>" . esc_html_x( "Not Installed",'admin', "whmpress" ) . "</span>"; ?></td>
            </tr>

            <tr>
                <th colspan="2">WHMpress Info</th>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Version",'admin', "whmpress" ) ?></td>
                <td><?php echo WHMP_VERSION ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Last Synced",'admin', "whmpress" ) ?></td>
                <td><?php $last_synced = get_option( "sync_time" );
					if ( $last_synced == "" ) {
						echo "<span class='whmp_danger'>Not yet synced</span>";
					}
					else {
						echo $last_synced;
					}
					?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WHMCS Version",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='Version'" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Company Name",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='CompanyName'" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Email address",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT `value` FROM `" . whmp_get_configuration_table_name() . "` WHERE `setting`='email'" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Domains",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_domain_pricing_table_name() . "`" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Products",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_products_table_name() . "`" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Product Groups",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_product_group_table_name() . "`" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Currencies",'admin', "whmpress" ) ?></td>
                <td><?php echo $wpdb->get_var( "SELECT COUNT(*) FROM `" . whmp_get_currencies_table_name() . "`" ); ?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "WHMCS URL",'admin', "whmpress" ) ?></td>
                <td><?php echo whmp_get_installation_url(); ?></td>
            </tr>
			<?php if ( is_active_cap() ): ?>
                <tr>
                    <td class="row-title"><?php echo esc_html_x( "Client Area URL",'admin', "whmpress" ) ?></td>
                    <td><?php
						$page = $WHMP->get_current_client_area_page();
						if ( substr( $page, 0, 4 ) == "http" ) {
							echo $page;
						}
						else {
							echo get_bloginfo( "url" ) . "/" . $page;
						}
						?></td>
                </tr>
			<?php endif; ?>

            <tr>
                <th colspan="2"><?php echo esc_html_x( "Plugins",'admin', "whmpress" ) ?></th>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Installed",'admin', "whmpress" ) ?></td>
                <td>
					<?php
					$active_plugins = (array) get_option( 'active_plugins', [] );

					if ( is_multisite() ) {
						$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', [] ) );
					}

					$wp_plugins = [];

					foreach ( $active_plugins as $plugin ) {

						$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
						$dirname        = dirname( $plugin );
						$version_string = '';

						if ( ! empty( $plugin_data['Name'] ) ) {

							// link the plugin name to the plugin url if available
							$plugin_name = $plugin_data['Name'];
							if ( ! empty( $plugin_data['PluginURI'] ) ) {
								$plugin_name = '<a target="_blank" href="' . esc_url( $plugin_data['PluginURI'] ) . '" title="Visit plugin homepage">' . $plugin_name . '</a>';
							}

							$wp_plugins[] = $plugin_name . ' by ' . $plugin_data['Author'] . ' version ' . $plugin_data['Version'] . $version_string;

						}
					}

					if ( sizeof( $wp_plugins ) == 0 ) {
						echo '-';
					}
					else {
						echo implode( ', <br/>', $wp_plugins );
					}
					?>
                </td>
            </tr>
            <tr>
                <th colspan="2"><?php echo esc_html_x( "Theme",'admin', "whmpress" ) ?></th>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Theme Name",'admin', "whmpress" ) ?></td>
                <td><?php
					$active_theme = wp_get_theme();
					echo $active_theme->Name;
					?></td>
            </tr>
            <tr class="alt">
                <td class="row-title"><?php echo esc_html_x( "Theme Version",'admin', "whmpress" ) ?></td>
                <td><?php
					echo $active_theme->Version;
					?></td>
            </tr>
            <tr>
                <td class="row-title"><?php echo esc_html_x( "Theme Author URL",'admin', "whmpress" ) ?></td>
                <td><?php
					echo $active_theme->{'Author URI'};
					?></td>
            </tr>
            <tr class="alt">
                <td class="row-title"><?php echo esc_html_x( "Is Child Theme",'admin', "whmpress" ) ?></td>
                <td><?php echo is_child_theme() ? esc_html_x( 'Yes','admin', 'whmpress' ) : esc_html_x( 'No','admin', 'whmpress' ); ?></td>
            </tr>
			<?php
			if ( is_child_theme() ) :
				$parent_theme = wp_get_theme( $active_theme->Template );
				?>
                <tr>
                    <td class="row-title"><?php echo esc_html_x( "Parent Theme Name",'admin', "whmpress" ) ?></td>
                    <td><?php echo $parent_theme->Name; ?></td>
                </tr>
                <tr class="alt">
                    <td class="row-title"><?php echo esc_html_x( "Parent Theme Version",'admin', "whmpress" ) ?></td>
                    <td><?php echo $parent_theme->Version; ?></td>
                </tr>
                <tr>
                    <td class="row-title"><?php echo esc_html_x( "Parent Theme Author URL",'admin', "whmpress" ) ?></td>
                    <td><?php
						echo $parent_theme->{'Author URI'};
						?></td>
                </tr>
			<?php endif; ?>
            <tr>
                <th colspan="2"><?php echo esc_html_x( "Addons",'admin', "whmpress" ) ?></th>
            </tr>
			<?php if ( is_active_cap() ): global $plugin_data_ca; ?>
                <tr>
                    <td class="row-title"><?php echo @$plugin_data_ca["Name"]; ?></td>
                    <td>v<?php echo @$plugin_data_ca["Version"]; ?></td>
                </tr>
			<?php endif;?>
			<?php if ( is_active_wpct() ): global $plugin_data_grp; ?>
                <tr>
                    <td class="row-title"><?php echo @$plugin_data_grp["Name"]; ?></td>
                    <td>WHMCS slider & comparision tabels <?php echo @$plugin_data_grp["Version"]; ?></td>
                </tr>
			<?php endif; ?>
			<?php if ( ! is_active_wpct()  && ! is_active_cap() ): ?>
                <tr>
                    <td></td>
                    <td><span class="whmp_danger"><?php esc_html_x('No addon installed','admin','whmpress') ?></span></td>
                </tr>
			<?php endif; ?>
        </table>
        <br>
<!--        <div style="text-align: center;">
            <input onclick="SendInfo()" type="button" class="button button-red"
                   value="Send this information to Author"/>
        </div>
-->    </div>
</div>