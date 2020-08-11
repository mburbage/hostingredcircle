<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$minimum_required = [
	'wp_multi' => [
		'required' => 'no',
		'recommended' => 'no'
	],
	'mem_limit' => [
		'required' => 256,
		'recommended' => 512
	],
	'request_time' => [
		'required' => 1000,
		'recommended' => 500
	],

	'version_php' => [
		'required' => "5.6",
		'recommended' => "5.6"
	],
	'version_wp' => [
		'required' => "4.8.0",
		'recommended' => "4.9.0"
	],
	'version_whmcs' => [
		'required' => "7.2.0",
		'recommended' => "7.4.0"
	],
	'version_helper' => [
		'required' => "3.6.2",
		'recommended' => "3.6.2"
	],
	'version_whcom' => [
		'required' => "2.6.3",
		'recommended' => "2.6.3"
	],
];
$whmcs_settings = whcom_get_whmcs_setting();

?>

<div class="wrap whcom_main whcom_admin_main">
	<h1><?php esc_html_e( 'Debug Info', "whcom" ) ?></h1>
	<div class="whcom_panel whcom_panel_fancy_2 whcom_panel_primary">
		<div class="whcom_panel_header">
			<span><?php _e( 'Debug info to copy and send', "whcom" ) ?></span>
		</div>
		<div class="whcom_panel_body">
			<div class="whcom_selectable_text" id="whcom_debug_container">
				<div class="whcom_debug_section whcom_debug_section_wp">
					<?php
					$collapse_class = 'success';

					// WordPress version
					$wp_version = get_bloginfo( 'version' );
					$wp_version_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $wp_version . '</span>';
					if (version_compare($wp_version, $minimum_required['version_wp']['required'], 'lt')) {
						// success
						$wp_version_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $wp_version . '</span>';
						$wp_version_string .= ' <span class="whcom_text_danger">' . esc_html__( "WP version should be at least ", "" ) . $minimum_required['version_wp']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if (version_compare($wp_version, $minimum_required['version_wp']['recommended'], 'lt')) {
						// warning
						$wp_version_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $wp_version . '</span>';
						$wp_version_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended WP version is ", "" ) . $minimum_required['version_wp']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}

					// Multi site
					$multi_site             = ( is_multisite() ) ? esc_html__( 'Yes', "whcom" ) : esc_html__( 'No', "whcom" );
					$multi_site_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $multi_site . '</span>';
					if ($multi_site == 'Yes') {
						// success
						$multi_site_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $multi_site . '</span>';
						$multi_site_string .= ' <span class="whcom_text_danger">' . esc_html__( "Our plugins are not compatible with Multi-site installs ", "" ) . '</span>';
						$collapse_class = 'danger active';
					}

					// debug mode
					$debug_mode             = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? esc_html__( 'TRUE', "whcom" ) : esc_html__( 'FALSE', "whcom" );

					// max upload size
					$wp_upload_max          = wp_max_upload_size();
					$server_upload_max      = intval( str_replace( 'M', '', ini_get( 'upload_max_filesize' ) ) ) * 1024 * 1024;
					$active_theme = wp_get_theme();
					if ( $wp_upload_max <= $server_upload_max ) {
						$max_upload_size = size_format( $wp_upload_max );
					}
					else {
						$max_upload_size = '<span style="color: red;">' . sprintf( __( '%s (The server only allows %s)', "whcom" ), size_format( $wp_upload_max ), size_format( $server_upload_max ) ) . '</span>';
					}

					// WP Memory Limit
					$wp_mem_limit = WP_MEMORY_LIMIT;
					$wp_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $wp_mem_limit . '</span>';
					if ((float) $wp_mem_limit < $minimum_required['mem_limit']['required']) {
						// success
						$wp_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $wp_mem_limit . '</span>';
						$wp_mem_limit_string .= ' <span class="whcom_text_danger">' . esc_html__( "Minimum Memory limit is ", "whcom" ) . $minimum_required['mem_limit']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if ((float) $wp_mem_limit < $minimum_required['mem_limit']['recommended']) {
						// warning
						$wp_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $wp_mem_limit . '</span>';
						$wp_mem_limit_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended Memory Limit is ", "whcom" ) . $minimum_required['mem_limit']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}



					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>WordPress info</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Site URL:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo site_url(); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Home URL:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo home_url(); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WordPress Version:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $wp_version_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WordPress Multi site:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $multi_site_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WordPress Language:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo whcom_get_current_language(); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WordPress Debug Mode:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $debug_mode; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Max Upload Size:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $max_upload_size; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Memory Limit WP:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $wp_mem_limit_string; ?></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_whmcs">
					<?php
					$collapse_class = 'success';

					// Response time for API request
					$time1                  = microtime( true ) * 1000;
					$api_test = whcom_api_test();
					$time2                  = microtime( true ) * 1000;
					$api_request_time       = ($api_test) ? round( $time2 - $time1, 0 ) . " Milliseconds" : esc_html__( "N/A", "whcom" );

					$request_time = (float) $api_request_time;
					$api_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $api_request_time . '</span>';
					if (empty($request_time) || $request_time > $minimum_required['request_time']['required']) {
						// danger
						$api_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $api_request_time . '</span>';
						$api_request_time_string .= ' <span class="whcom_text_danger">' . esc_html__( "Should not be exceeding ", "whcom" ) . $minimum_required['request_time']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if ($request_time > $minimum_required['request_time']['recommended']) {
						// warning
						$api_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $api_request_time . '</span>';
						$api_request_time_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is below ", "whcom" ) . $minimum_required['request_time']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}

					// Response time for Helper request
					$time1                  = microtime( true ) * 1000;
					$helper_version         = whcom_get_helper_version();
					$time2                  = microtime( true ) * 1000;
					$helper_request_time    = ((float) $helper_version>0) ? round( $time2 - $time1, 0 ) . " Milliseconds" : esc_html__( "N/A", "whcom" );

					$request_time = (float) $helper_request_time;
					$helper_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $helper_request_time . '</span>';
					if (empty($request_time) || $request_time > $minimum_required['request_time']['required']) {
						// danger
						$helper_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $helper_request_time . '</span>';
						$helper_request_time_string .= ' <span class="whcom_text_danger">' . esc_html__( "Should not be exceeding ", "whcom" ) . $minimum_required['request_time']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if ($request_time > $minimum_required['request_time']['recommended']) {
						// warning
						$helper_request_time_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $helper_request_time . '</span>';
						$helper_request_time_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is below ", "whcom" ) . $minimum_required['request_time']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}

					// Response time for Helper request with DB
					$time1                  = microtime( true ) * 1000;
					$whmcs_version          = whcom_get_whmcs_version();
					$time2                  = microtime( true ) * 1000;
					$helper_request_time_db = ((float) $whmcs_version > 0) ? round( $time2 - $time1, 0 ) . " Milliseconds" : esc_html__( "N/A", "whcom" );

					$request_time = (float) $helper_request_time_db;
					$helper_request_time_db_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $helper_request_time_db . '</span>';
					if (empty($request_time) || $request_time > $minimum_required['request_time']['required']) {
						// danger
						$helper_request_time_db_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $helper_request_time_db . '</span>';
						$helper_request_time_db_string .= ' <span class="whcom_text_danger">' . esc_html__( "Should not be exceeding ", "whcom" ) . $minimum_required['request_time']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if ($request_time > $minimum_required['request_time']['recommended']) {
						// warning
						$helper_request_time_db_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $helper_request_time_db . '</span>';
						$helper_request_time_db_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is below ", "whcom" ) . $minimum_required['request_time']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}


					// Helper version
					$helper_version_text = '<span class="whcom_button whcom_button_small whcom_button_success">' . $helper_version . '</span>';
					if (version_compare($helper_version, $minimum_required['version_helper']['required'], 'lt')) {
						// danger
						$helper_version_text = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $helper_version . '</span>';
						$helper_version_text .= ' <span class="whcom_text_danger">' . esc_html__( "Minimum required Helper version is ", "whcom" ) . $minimum_required['version_helper']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if (version_compare($helper_version, $minimum_required['version_helper']['recommended'], 'lt')) {
						// warning
						$helper_version_text = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $helper_version . '</span>';
						$helper_version_text .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is above ", "whcom" ) . $minimum_required['version_helper']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}



					// WHMCS version
					$whmcs_version_text = '<span class="whcom_button whcom_button_small whcom_button_success">' . $whmcs_version . '</span>';
					if (version_compare($whmcs_version, $minimum_required['version_whmcs']['required'], 'lt')) {
						// danger
						$whmcs_version_text = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $whmcs_version . '</span>';
						$whmcs_version_text .= ' <span class="whcom_text_danger">' . esc_html__( "Minimum Required WHMCS version is ", "whcom" ) . $minimum_required['version_whmcs']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if (version_compare($whmcs_version, $minimum_required['version_whmcs']['recommended'], 'lt')) {
						// warning
						$whmcs_version_text = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $whmcs_version . '</span>';
						$whmcs_version_text .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is above ", "whcom" ) . $minimum_required['version_whmcs']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}

					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>WHMCS info</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
                                <li class="whcom_row">
                                    <div class="whcom_col_sm_5"><?php esc_html_e( 'WHMCS Domain:', "whcom" ) ?></div>
                                    <div class="whcom_col_sm_7"><?php echo (!empty($whmcs_settings['Domain'])) ? $whmcs_settings['Domain'] : ''; ?></div>
                                </li>
                                <li class="whcom_row">
                                    <div class="whcom_col_sm_5"><?php esc_html_e( 'WHMCS System URL:', "whcom" ) ?></div>
                                    <div class="whcom_col_sm_7"><?php echo (!empty($whmcs_settings['SystemURL'])) ? $whmcs_settings['Domain'] : ''; ?></div>
                                </li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WHMCS Version:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $whmcs_version_text; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WHMPress Helper Version:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $helper_version_text; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'API Request/response time:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $api_request_time_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Helper Request/response time:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $helper_request_time_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Helper Request/response time (DB):', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $helper_request_time_db_string; ?></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_stack">
					<?php
					$collapse_class = 'success';

					$whmp_installed = ( is_plugin_active( 'whmpress/whmpress.php' ) ) ? true : false;
					$wcop_installed = ( is_plugin_active( 'whmpress_whmcs_cart/whmpress_whmcs_cart.php' ) ) ? true : false;
					$wcap_installed = ( is_plugin_active( 'WHMpress_Client_Area_API/index.php' ) ) ? true : false;


					if (!defined('WHCOM_VERSION')) {
						$whcom_version = '<span class="whcom_button whcom_button_danger whcom_button_small">' . esc_html__( "Not Installed", "whcom" ) . '</span>';
						$whcom_version .= '<span class="whcom_text_danger">' . esc_html__( "WHCOM is required", "whcom" ) . '</span>';
						$collapse_class = 'danger active';
					}
					else if (version_compare(WHCOM_VERSION, $minimum_required['version_whcom']['required'], 'lt')) {
						$whcom_version = '<span class="whcom_button whcom_button_danger whcom_button_small">' . WHCOM_VERSION . '</span> ';
						$whcom_version .= '<span class="whcom_text_danger">' . esc_html__( "WHCOM seems outdated, Minimum required is ", "whcom" ) . $minimum_required['version_whcom']['required'] .  '</span>';
						$whcom_version .= '<div class="whcom_padding_10_0"><strong>' . esc_html__( "WHCOM path", "whcom" ) . ':</strong> ' . WHCOM_PATH . ' </div>';
						$collapse_class = 'danger active';
					}
					else {
						$whcom_version = '<span class="whcom_button whcom_button_success whcom_button_small">' . WHCOM_VERSION . '</span>';
						$whcom_version .= '<div class="whcom_padding_10_0"><strong>' . esc_html__( "WHCOM path", "whcom" ) . ':</strong> ' . WHCOM_PATH . ' </div>';
					}

					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>WHMPress Stack</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li>
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_5"><?php esc_html_e( 'WHCOM:', "whcom" ) ?></div>
                                        <div class="whcom_col_sm_7"><?php echo $whcom_version ?></div>
                                    </div>
                                    <div class="whcom_row">
                                        <div class="whcom_col_sm_5"><?php esc_html_e( 'WHMCS Custom Invoice Template Enabled?:', "whcom" ) ?></div>
                                        <div class="whcom_col_sm_7"><?php echo (get_option('whcom_whmcs_invoice_custom_templates_status', 'no') == 'Yes') ? esc_html_e( 'Yes', "whcom" ): esc_html_e( 'No', "whcom" ); ?></div>
                                    </div>
								</li>
								<?php if ( is_plugin_active( 'whmpress/whmpress.php' ) ) { ?>
									<?php $whmp_version = @get_plugin_data(WP_PLUGIN_DIR . '/whmpress/whmpress.php', false, false)['Version']; ?>
									<li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5"><?php esc_html_e( 'WHMPress:', "whcom" ) ?></div>
                                            <div class="whcom_col_sm_7"><?php echo $whmp_version ?></div>
                                        </div>
									</li>
								<?php } ?>
								<?php if ( is_plugin_active( 'whmpress_whmcs_cart/whmpress_whmcs_cart.php' ) ) { ?>
									<?php $wcop_version = @get_plugin_data(WP_PLUGIN_DIR . '/whmpress_whmcs_cart/whmpress_whmcs_cart.php', false, false)['Version']; ?>
									<li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5"><?php esc_html_e( 'WCOP:', "whcom" ) ?></div>
                                            <div class="whcom_col_sm_7">
                                                <div><?php echo $wcop_version ?></div>
                                            </div>
                                        </div>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'Product configuration URL',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'configure_product' . whcom_get_current_language(); ?>
		                                        <?php if ( url_to_postid( esc_attr( get_option( $field ) ) ) == '0' ) {
			                                        echo esc_html_x( 'Page URL is not correct', "admin","whcom" );
		                                        }
		                                        else {
			                                        $page_id  = url_to_postid( esc_attr( get_option( $field ) ) );
			                                        $page_url = get_permalink( $page_id );
			                                        echo '<a href="' . esc_html( $page_url ) . '" target="_blank">' . $page_url . '</a>';
		                                        } ?>
                                            </div>
                                        </div>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'Cart and Checkout Page URL',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'cart_listing_page' . whcom_get_current_language(); ?>
		                                        <?php if ( url_to_postid( esc_attr( get_option( $field ) ) ) == '0' ) {
			                                        echo esc_html_x( 'Page URL is not correct', "admin","whcom" );
		                                        }
		                                        else {
			                                        $page_id  = url_to_postid( esc_attr( get_option( $field ) ) );
			                                        $page_url = get_permalink( $page_id );
			                                        echo '<a href="' . esc_html( $page_url ) . '" target="_blank">' . $page_url . '</a>';
		                                        } ?>
                                            </div>
                                        </div>

									</li>
								<?php } ?>
								<?php if ( is_plugin_active( 'WHMpress_Client_Area_API/index.php' ) ) { ?>
									<?php $wcap_version = @get_plugin_data(WP_PLUGIN_DIR . '/WHMpress_Client_Area_API/index.php', false, false)['Version']; ?>
									<li>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5"><?php esc_html_e( 'WCAP:', "whcom" ) ?></div>
                                            <div class="whcom_col_sm_7"><?php echo $wcap_version ?></div>
                                        </div>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'Client Area URL',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'wcapfield_client_area_url' . whcom_get_current_language(); ?>
		                                        <?php if ( url_to_postid( esc_attr( get_option( $field ) ) ) == '0' ) {
			                                        echo esc_html_x( 'Page URL is not correct', "admin","whcom" );
		                                        }
		                                        else {
			                                        $page_id  = url_to_postid( esc_attr( get_option( $field ) ) );
			                                        $page_url = get_permalink( $page_id );
			                                        echo '<a href="' . esc_html( $page_url ) . '" target="_blank">' . $page_url . '</a>';
		                                        } ?>
                                            </div>
                                        </div>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'After Login redirect URL',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'wcapfield_after_login_redirect_url' . whcom_get_current_language(); ?>
		                                        <?php echo '<a href="' . get_option( $field ) . '" target="_blank">' . get_option( $field ) . '</a>'; ?>
                                            </div>
                                        </div>
                                        <div class="whcom_row">
                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'After Logout redirect URL',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'wcapfield_after_logout_redirect_url' . whcom_get_current_language(); ?>
		                                        <?php echo '<a href="' . get_option( $field ) . '" target="_blank">' . get_option( $field ) . '</a>'; ?>
                                            </div>
                                        </div>
                                        <div class="whcom_row">

                                            <div class="whcom_col_sm_5">
		                                        <?php echo esc_html_x( 'Is SSO enabled?',"admin", "whcom" ); ?>
                                            </div>
                                            <div class="whcom_col_sm_7">
		                                        <?php $field = 'wcapfield_enable_sso'; ?>
		                                        <?php echo (get_option( $field, false ) == '1') ? esc_html_x( 'Yes',"admin", "whcom" ): esc_html_x( 'No',"admin", "whcom" ); ?>
                                            </div>
                                        </div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_plugins">
					<?php
					$collapse_class = 'success';
					$active_plugins = (array) get_option( 'active_plugins', array() );
					if ( is_multisite() ) {
						$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
					}
					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>Plugins</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'WordPress Active Plugins:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo count( $active_plugins ) ?></div>
								</li>
								<?php if ( count( $active_plugins ) > 0 ) { ?>
									<li class="whcom_row">
										<div class="whcom_col_sm_5"><?php esc_html_e( 'Active Plugins List:', "whcom" ) ?></div>
										<div class="whcom_col_sm_7">
											<ol>
												<?php foreach ( $active_plugins as $plugin ) {
													$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
													$dirname        = dirname( $plugin );
													$version_string = '';
													if ( ! empty( $plugin_data['Name'] ) ) {
														// link the plugin name to the plugin url if available
														echo '<li class="">';
														$plugin_name = $plugin_data['Name'];
														if ( ! empty( $plugin_data['PluginURI'] ) ) {
															$plugin_name = "" . $plugin_name;
														}
														echo $plugin_name . ' by ' . strip_tags( $plugin_data['Author'] ) . ' version ' . $plugin_data['Version'] . $version_string;
														echo "</li>";
													} ?>
												<?php } ?>
											</ol>
										</div>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_theme">
					<?php
					$collapse_class = 'success';
					global $wpdb;
					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>Theme</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Theme Name:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo wp_get_theme()->Name; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Theme Author URL:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo wp_get_theme()->{'Author URI'}; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Is Child Theme:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo is_child_theme() ? 'Yes' : 'No'; ?></div>
								</li>
								<?php if ( is_child_theme() ) { ?>
									<li class="whcom_row">
										<div class="whcom_col_sm_5"><?php esc_html_e( 'Parent Theme Name:', "whcom" ) ?></div>
										<div class="whcom_col_sm_7"><?php echo wp_get_theme( $active_theme->Template )->Name; ?></div>
									</li>
									<li class="whcom_row">
										<div class="whcom_col_sm_5"><?php esc_html_e( 'Parent Theme Version:', "whcom" ) ?></div>
										<div class="whcom_col_sm_7"><?php echo wp_get_theme( $active_theme->Template )->Version; ?></div>
									</li>
									<li class="whcom_row">
										<div class="whcom_col_sm_5"><?php esc_html_e( 'Parent Theme Author URL:', "whcom" ) ?></div>
										<div class="whcom_col_sm_7"><?php echo wp_get_theme( $active_theme->Template )->{'Author URI'}; ?></div>
									</li>
								<?php } ?>


							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_server">
					<?php
					$collapse_class = 'success';

					// PHP memory limit
					$php_mem_limit = ini_get("memory_limit");
					$php_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $php_mem_limit . '</span>';
					if ((float) $php_mem_limit < $minimum_required['mem_limit']['required']) {
						// success
						$php_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $php_mem_limit . '</span>';
						$php_mem_limit_string .= ' <span class="whcom_text_danger">' . esc_html__( "Minimum Memory limit is ", "whcom" ) . $minimum_required['mem_limit']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if ((float) $php_mem_limit < $minimum_required['mem_limit']['recommended']) {
						// warning
						$php_mem_limit_string = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $php_mem_limit . '</span>';
						$php_mem_limit_string .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended Memory Limit is ", "whcom" ) . $minimum_required['mem_limit']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}

					// PHP version
					$php_version = phpversion();
					$php_version_text = '<span class="whcom_button whcom_button_small whcom_button_success">' . $php_version . '</span>';
					if (version_compare($php_version, $minimum_required['version_php']['required'], 'lt')) {
						// danger
						$php_version_text = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $php_version . '</span>';
						$php_version_text .= ' <span class="whcom_text_danger">' . esc_html__( "Minimum Required PHP version is ", "whcom" ) . $minimum_required['version_php']['required'] . '</span>';
						$collapse_class = 'danger active';
					}
					else if (version_compare($php_version, $minimum_required['version_php']['recommended'], 'lt')) {
						// warning
						$php_version_text = '<span class="whcom_button whcom_button_small whcom_button_warning">' . $php_version . '</span>';
						$php_version_text .= ' <span class="whcom_text_warning">' . esc_html__( "Recommended is above ", "whcom" ) . $minimum_required['version_php']['recommended'] . '</span>';
						if ($collapse_class != 'danger active') {
							$collapse_class = 'warning active';
						}
					}


					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>Server info</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'PHP Version:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $php_version_text; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Memory Limit PHP:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $php_mem_limit_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'PHP Safe Mode:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo ( ini_get( 'safe_mode' ) ) ? esc_html__( 'ON', "whcom" ) : esc_html__( 'OFF', "whcom" ); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'PHP Time Execution:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo ini_get( 'max_execution_time' ); ?> Seconds <?php ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'PHP Temporary Directory:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo sys_get_temp_dir() ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'MySQL Version:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $wpdb->get_var( "SELECT VERSION()" ); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'Server Software:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo esc_html( @$_SERVER['SERVER_SOFTWARE'] ); ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'MySQLi Extension:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo function_exists( 'mysqli_connect' ) ? esc_html__( "Installed", "whcom" ) : esc_html__( "Not Installed", "whcom" ); ?></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="whcom_debug_section whcom_debug_section_curl">
					<?php
					$collapse_class = 'success';

					// Multi site
					$curl_installed = (function_exists( 'curl_version' )) ? esc_html__( 'Installed', "whcom" ) : esc_html__( 'Not Installed', "whcom" );
					$curl_installed_string = '<span class="whcom_button whcom_button_small whcom_button_success">' . $curl_installed . '</span>';
					if ($curl_installed == 'Not Installed') {
						// success
						$curl_installed_string = '<span class="whcom_button whcom_button_small whcom_button_danger">' . $curl_installed . '</span>';
						$curl_installed_string .= ' <span class="whcom_text_danger">' . esc_html__( "cURL is required but not installed, ", "whcom" ) . '</span>';
						$collapse_class = 'danger active';
					}




					// CURL google with http
					if ( ! function_exists( 'curl_version' ) ) {
						$curl_google = esc_html__('cURL not Installed', "whcom" );
					}
					else {
						$ch = curl_init();
						curl_setopt( $ch, CURLOPT_URL, "http://www.google.com" );
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						$result = curl_exec( $ch );
						if ( $result === false ) {
							$curl_google = '<span class="whcom_button whcom_button_small whcom_button_danger">' . esc_html__('Failed', "whcom" ) . '</span>';
							if ( $errno = curl_errno( $ch ) ) {
								$error_message = curl_error( $ch );
								$curl_google .= ' <span class="whcom_text_danger">'. $error_message . '</span>';
							}
							$collapse_class = 'danger active';
						}
						else {
							$curl_google = '<span class="whcom_button whcom_button_small whcom_button_success">' . esc_html__('Passed', "whcom" ) . '</span>';
						}
					}

					// CURL google with https
					if ( ! function_exists( 'curl_version' ) ) {
						$curl_google_https = esc_html__('cURL not Installed', "whcom" );
					}
					else {
						$ch = curl_init();
						curl_setopt( $ch, CURLOPT_URL, "https://www.google.com" );
						curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
						if (get_option('whcom_curl_ssl_verify', '') == 'yes') {
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
						}
						else {
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						}
						$result = curl_exec( $ch );
						if ( $result === false ) {
							$curl_google_https = '<span class="whcom_button whcom_button_small whcom_button_danger">' . esc_html__('Failed', "whcom" ) . '</span>';
							if ( $errno = curl_errno( $ch ) ) {
								$error_message = curl_error( $ch );
								$curl_google_https .= ' <span class="whcom_text_danger">'. $error_message . '</span>';
							}
							$collapse_class = 'danger active';
						}
						else {
							$curl_google_https = '<span class="whcom_button whcom_button_small whcom_button_success">' . esc_html__('Passed', "whcom" ) . '</span>';
						}
					}

					?>
					<div class="whcom_collapse whcom_collapse_<?php echo $collapse_class?> whcom_margin_bottom_30">
						<div class="whcom_collapse_toggle">
							<i class="whcom_icon_down-open"></i>
							<span>cURL Extension info</span>
						</div>
						<div class="whcom_collapse_content">
							<ul class="whcom_list whcom_list_padded whcom_list_bordered">
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'cURL Extension:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $curl_installed_string; ?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'cURL Test with google.com:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $curl_google?></div>
								</li>
								<li class="whcom_row">
									<div class="whcom_col_sm_5"><?php esc_html_e( 'cURL Test with port 443 and google.com:', "whcom" ) ?></div>
									<div class="whcom_col_sm_7"><?php echo $curl_google_https?></div>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
