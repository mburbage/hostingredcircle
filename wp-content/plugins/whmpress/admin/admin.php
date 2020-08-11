<?php
global $wpdb;
include_once realpath( dirname( __FILE__ ) . "/../includes/whmpress.class.php" );
include_once realpath( dirname( __FILE__ ) . "/../includes/functions.php" );
$WHMPress = new WHMpress();
// Check if sync not run first time.
if ( get_option( "sync_run" ) <> "1" ) {
	function whmpress_not_synced() {
		?>
		<div class="error">
			<h3><?php echo esc_html_x( 'WHMpress Warning!', 'admin' , 'whmpress' ); ?></h3>
			<p><?php printf( esc_html_X( "No data synced from hosting server, Please run %s to use WHMpress", 'admin', 'whmpress' ), "<a href='admin.php?page=whmp-sync'>Sync WHMCS</a>" ); ?></p>
		</div>
		<?php
	}

	add_action( 'admin_notices', 'whmpress_not_synced' );
}


    if (!$WHMPress->verified_purchase()) {
        function whmpress_not_verified()
        {
            ?>
            <div class="error" id="not_whmp">
            <h3><?php echo esc_html_x('Verify Purchase', 'admin', 'whmpress'); ?></h3>
            <?php
            $dashboard = "<a class='button button-primary' style='display: inline' href='admin.php?page=whmp-dashboard#div2'>";
            $buy = "<a class='button button-primary' href='http://codecanyon.net/item/whmpress-whmcs-wordpress-integration-plugin-/9946066' target='_blank'> ";
            printf(esc_html_x('%1s WHMPress is not verified, kindly click %2s here%3s to verify your purchase.%4s', 'admin', 'whmpress'), '<p>', $dashboard, '</a>', '</p>');
            printf(esc_html_x('%1s Or you can purchase WHMPress using below link %2s %3s purchase WHMPress %4s', 'admin', 'whmpress'), '<p>', '</p><p>', $buy, '</a></p>');
            ?>
            </div><?php
        }

        add_action('admin_notices', 'whmpress_not_verified');
    }

// if WHMPress tables do not exist then show warning message
$Ts = $wpdb->get_results( "SHOW TABLES LIKE '" . whmp_get_configuration_table_name() . "'", ARRAY_A );
if ( sizeof( $Ts ) == 0 && get_option( "sync_run" ) == "1" ) {
	function whmpress_not_synced() {
		?>
		<div class="error">
			<h3><?php echo esc_html_x( 'WHMpress Warning!','admin', 'whmpress' ); ?></h3>
			<p>
				<?php
				$syncwhmcs = "<a href='admin.php?page=whmp-sync'>";
				printf( esc_html_x( 'WHMpress data not found, Please run %1s Sync WHMCS %2s to use WHMpress','admin', 'whmpress' ), $syncwhmcs, '</a>' );
				?>
			</p>
		</div>
		<?php
	}

	add_action( 'admin_notices', 'whmpress_not_synced' );
}

function whmp_admin_enqueue_styles( $page ) {
	wp_enqueue_style( 'whmp-admin', WHMP_ADMIN_URL . '/css/style.css', [], 1, 'all' );
	wp_enqueue_script( 'whmp-scripts', WHMP_PLUGIN_URL . '/admin/js/scripts.js', [ 'jquery' ], WHMP_VERSION, true );
	wp_enqueue_script( 'whmp-hash-change', WHMP_PLUGIN_URL . '/js/easytabs/jquery.hashchange.min.js', [ 'jquery' ], WHMP_VERSION, true );
	wp_enqueue_script( 'whmp-easy-tabs', WHMP_PLUGIN_URL . '/js/easytabs/jquery.easytabs.min.js', [ 'jquery' ], WHMP_VERSION, true );

	// Linear Icons
	wp_register_style( 'custom_wp_admin_icons', '//cdn.linearicons.com/free/1.0.0/icon-font.min.css', false, '1.0.0' );
	wp_enqueue_style( 'custom_wp_admin_icons' );
}

add_action( 'admin_enqueue_scripts', 'whmp_admin_enqueue_styles' );


// Adding link to top admin bar
/**
 * Adds admin bar items for easy access to the theme creator and editor
 */
//add_action('wp_before_admin_bar_render', 'whmp_child_theme_creator_admin_bar_render', 100);
function whmp_child_theme_creator_admin_bar_render() {
	whmpress_add_admin_bar( 'WHMpress', "admin.php?page=whmp-dashboard" );
	whmpress_add_admin_bar( 'Products/Services', 'admin.php?page=whmp-myservices', 'WHMpress' );
	//whmpress_add_admin_bar('Groups', 'admin.php?page=whmp-groups', 'WHMpress');
	whmpress_add_admin_bar( 'Settings', 'admin.php?page=whmp-settings', 'WHMpress' );
	whmpress_add_admin_bar( 'Sync WHMCS', 'admin.php?page=whmp-sync', 'WHMpress' );
}

/**
 * Add's menu parent or submenu item.
 *
 * @param string $name   the label of the menu item
 * @param string $href   the link to the item (settings page or ext site)
 * @param string $parent Parent label (if creating a submenu item)
 *
 * @return void
 * */
function whmpress_add_admin_bar( $name, $href = '', $parent = '', $custom_meta = [] ) {
	global $wp_admin_bar;
	if ( ! is_super_admin() || ! is_admin_bar_showing() || ! is_object( $wp_admin_bar ) || ! function_exists( 'is_admin_bar_showing' ) ) {
		return;
	}

	// Generate ID based on the current filename and the name supplied.
	$id = str_replace( '.php', '', basename( __FILE__ ) ) . '-' . $name;
	$id = preg_replace( '#[^\w-]#si', '-', $id );
	$id = strtolower( $id );
	$id = trim( $id, '-' );

	$parent = trim( $parent );

	// Generate the ID of the parent.
	if ( ! empty( $parent ) ) {
		$parent = str_replace( '.php', '', basename( __FILE__ ) ) . '-' . $parent;
		$parent = preg_replace( '#[^\w-]#si', '-', $parent );
		$parent = strtolower( $parent );
		$parent = trim( $parent, '-' );
	}

	// links from the current host will open in the current window
	$site_url = site_url();

	$meta_default = [];
	$meta_ext     = [ 'target' => '_self' ]; // external links open in new tab/window then mention _blank here

	$meta = ( strpos( $href, $site_url ) !== false ) ? $meta_default : $meta_ext;
	$meta = array_merge( $meta, $custom_meta );

	$wp_admin_bar->add_node( [
		'parent' => $parent,
		'id'     => $id,
		'title'  => $name,
		'href'   => $href,
		'meta'   => $meta,
	] );
}


function whmp_add_pages() {
	// The first parameter is the Page name(admin-menu), second is the Menu name(menu-name)
	//and the number(5) is the user level that gets access
	// Icons from http://melchoyce.github.io/dashicons/
	add_menu_page( esc_html_x( 'WHMpress Dashboard','admin', 'whmpress' ), esc_html_x( 'WHMpress','admin', 'whmpress' ), 'manage_options', 'whmp-dashboard', 'whmp_dashboard', WHMP_ADMIN_URL . "/images/whitelogo-16.png", '81.69856' );
	global $whmp_submenu_pages;

	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		 esc_html_x( 'Dashboard','admin', 'whmpress' ),
		'manage_options',
		'whmp-dashboard',
		'whmp_load_page',
		null,
	];
	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		esc_html_x( 'Products/Services','admin', 'whmpress' ),
		'manage_options',
		'whmp-services',
		'whmp_load_page',
		null,
	];
	/*if (is_file(PLUGIN_PATH."/g")) {
		$whmp_submenu_pages[] = array(
			'whmp-dashboard',
			'',
			"Pricing Table Groups",
			'manage_options',
			'whmp-groups',
			'whmp_load_page',
			null,
		);
	}*/
	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		esc_html_x( 'Settings','admin', 'whmpress' ),
		'manage_options',
		'whmp-settings',
		'whmp_load_page',
		null,
	];
	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		esc_html_x( 'Pricing Tables','admin', 'whmpress' ),
		'manage_options',
		'whmp-pricing-tables',
		'whmp_load_page',
		null,
	];
	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		esc_html_x( 'Sync WHMCS','admin', 'whmpress' ),
		'manage_options',
		'whmp-sync',
		'whmp_load_page',
		null,
	];
	
	$whmp_submenu_pages[] = [
		'whmp-dashboard',
		'',
		esc_html_x( 'Debug Info','admin', 'whmpress' ),
		'manage_options',
		'whmp-debug',
		'whmp_load_page',
		null,
	];

	if ( get_option( 'enable_logs' ) == "1" ) {
		$whmp_submenu_pages[] = [
			'whmp-dashboard',
			'',
			esc_html_x( 'Search Logs','admin', 'whmpress' ),
			'manage_options',
			'whmp-search-logs',
			'whmp_load_page',
			null,
		];
	}
	$whmp_submenu_pages[] = array(
			'whmp-dashboard',
			'',
			"Country Settings",
			'manage_options',
			'whmp-country-settings',
			'whmp_load_page',
			null,
		);

	/*if (is_active_cap()) {
		$whmp_submenu_pages[] = array(
			'whmp-dashboard',
			'',
			__('Client Area','whmpress'),
			'manage_options',
			'whmp-client-area',
			'whmp_load_page',
		);
	}*/

//	$whmp_submenu_pages[] = [
//		'whmp-dashboard',
//		'',
//		"<span style='color:#FA3C00'>" . __( "Addons", "whmpress" ) . "</span>",
//		'manage_options',
//		'whmp-extensions',
//		'whmp_load_page',
//		null,
//	];

	// Allow submenu pages manipulation
	$whmp_submenu_pages = apply_filters( 'whmp_submenu_pages', $whmp_submenu_pages );

	// Loop through submenu pages and add them
	if ( count( $whmp_submenu_pages ) ) {
		foreach ( $whmp_submenu_pages as $submenu_page ) {
			// Add submenu page
			$admin_page = add_submenu_page( $submenu_page[0], $submenu_page[2] . ' - ' . 'WHMpress:', $submenu_page[2], $submenu_page[3], $submenu_page[4], $submenu_page[5] );

			if ( "Settings" == $submenu_page[2] ) {
				//add_action('load-' . $admin_page, 'new_tab_styles');
			}

			// Check if we need to hook
			if ( isset( $submenu_page[6] ) && null != $submenu_page[6] && is_array( $submenu_page[6] ) && count( $submenu_page[6] ) > 0 ) {
				foreach ( $submenu_page[6] as $submenu_page_action ) {
					add_action( 'load-' . $admin_page, $submenu_page_action );
				}
			}
		}
	}

	global $submenu;
	if ( isset( $submenu['whmp-dashboard'] ) ) {
		$submenu['whmp-dashboard'][0][0] = 'Dashboard';
	}

	#add_submenu_page('whmp-dashboard','Styles','Styles','administrator','whmp-custom-css','whmp_css');
	#add_submenu_page('whmp-dashboard','Import','Import','administrator','whmp-import','whmp_import');
	#add_submenu_page('whmp-dashboard','Export','Export','administrator','whmp-export','whmp_export');
}

function new_tab_styles() {
	wp_register_script( 'whmp-settings-script', WHMP_ADMIN_URL . '/js/settings-script.js', [ 'jquery' ], WHMP_VERSION );
	wp_enqueue_script( 'whmp-settings-script' );

	wp_register_style( 'whmp-settings-style', WHMP_ADMIN_URL . '/css/settings-style.css', [], WHMP_VERSION );
	wp_enqueue_style( 'whmp-settings-style' );
}

function whmp_load_page() {
	if ( isset( $_GET['page'] ) ) {
		switch ( $_GET["page"] ) {
			case "whmp-dashboard":
				require_once( WHMP_ADMIN_DIR . "/dashboard.php" );
				break;
			case "whmp-settings":
				require_once( WHMP_ADMIN_DIR . "/settings.php" );
				break;
			case "whmp-pricing-tables":
				require_once( WHMP_ADMIN_DIR . "/pricing_tables.php" );
				break;
			case "whmp-services":
				require_once( WHMP_ADMIN_DIR . "/services.php" );
				break;
			case "whmp-sync":
				require_once( WHMP_ADMIN_DIR . "/sync.php" );
				break;
			case "whmp-debug":
				require_once( WHMP_ADMIN_DIR . "/debug.php" );
				break;
			case "whmp-extensions":
				require_once( WHMP_ADMIN_DIR . "/extensions.php" );
				break;
			case "whmp-client-area":
				require_once( WHMP_ADMIN_DIR . "/client_area.php" );
				break;
			case "whmp-search-logs":
				require_once( WHMP_ADMIN_DIR . "/search_logs.php" );
				break;
			case "whmp-country-settings":
				require_once( WHMP_ADMIN_DIR . "/country_settings.php" );
				break;
			default:
				require_once( WHMP_ADMIN_DIR . "/dashbaord.php" );
		}
		/*if (is_file(WHMP_ADMIN_DIR . "/".$_GET['page'].".php")) {
			require_once(WHMP_ADMIN_DIR . "/".$_GET['page'].".php");
		} else {
			require_once(WHMP_ADMIN_DIR . "dashbaord.php");
		}*/
	}
}

function whmp_css() {
	include_once( WHMP_ADMIN_DIR . "/custom-css.php" );
}

function whmp_dashboard() {
	include_once WHMP_ADMIN_DIR . "/dashboard.php";
}

function whmp_services() {
	include_once WHMP_ADMIN_DIR . "/services.php";
}

function whmp_import() {
	include_once WHMP_ADMIN_DIR . "/import.php";
}

function whmp_export() {
	include_once WHMP_ADMIN_DIR . "/export.php";
}

function whmp_settings() {
	include_once WHMP_ADMIN_DIR . "/settings.php";
}

function whmp_sync_db() {
	include_once WHMP_ADMIN_DIR . "/sync.php";
}

add_action( 'admin_menu', 'whmp_add_pages' );


add_action( 'admin_head', 'whmpress_print_shortcodes_in_js' );
#add_action('admin_head', 'my_add_tinymce');
function whmpress_print_shortcodes_in_js() {
	?>
	<script type="text/javascript">
		var my_shortcodes = [ '[haha]', '[hehe]' ];
	</script>
	<?php
}

add_action( 'admin_head', 'whmpress_add_my_tc_button' );
function whmpress_add_my_tc_button() {
	global $typenow;
	// check user permissions
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	// verify the post type
	if ( ! in_array( $typenow, [ 'post', 'page' ] ) ) {
		return;
	}
	// check if WYSIWYG is enabled
	if ( get_user_option( 'rich_editing' ) == 'true' ) {
		add_filter( "mce_external_plugins", "whmpress_add_tinymce_plugin" );
		add_filter( 'mce_buttons', 'whmpress_register_my_tc_button' );
	}
}

function whmpress_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['whmpress_tc_button'] = WHMP_ADMIN_URL . '/js/shortcodes.js.php';

	return $plugin_array;
}

function whmpress_register_my_tc_button( $buttons ) {
	array_push( $buttons, "whmpress_tc_button" );

	return $buttons;
}

add_action( 'wp_ajax_whmp_verify', 'whmp_veirfy_func' );
function whmp_veirfy_func() {
	global $WHMPress;
	echo $WHMPress->verify_purchase( $_POST );
	wp_die();
}

add_action( 'wp_ajax_whmp_unverify', 'whmp_unveirfy_func' );
function whmp_unveirfy_func() {
	global $WHMPress;
	echo $WHMPress->unverify_purchase();
	wp_die();
}

add_action( 'wp_ajax_send_info_to_author', 'whmp_author_info' );
function whmp_author_info() {
	global $WHMPress;
	echo $WHMPress->send_info_to_author( $_POST );
	wp_die();
}