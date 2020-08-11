<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
$whmp_installed = ( is_plugin_active( 'whmpress/whmpress.php' ) ) ? true : false;
$wcop_installed = ( is_plugin_active( 'whmpress_whmcs_cart/whmpress_whmcs_cart.php' ) ) ? true : false;
$wcap_installed = ( is_plugin_active( 'WHMpress_Client_Area_API/index.php' ) ) ? true : false;

?>

<div class="wrap about-wrap whcom_admin_page whcom_main">
	<h1><?php echo esc_html_x('WCOM',"admin", 'whcom')?></h1>

	<div class="about-text">
		<?php echo esc_html_x('Welcome to common settings area for WHMPress - A WHMCS WP Integration Stack. This section holds settings that are shared between two or more components. Unlike framing existing WHMCS-WordPress integration solutions, our integration works in modules so every user can have as much integration as he needs.', 'admin','whcom')?>
	</div>
	<div id="whcom_admin_logo" class="wp-badge">
		Version <?php echo WHCOM_VERSION; ?>
	</div>


	<div class="whcom_admin_page_content">
		<div class="whcom_row" style="max-width: 992px;">
			<div class="whcom_col_sm_12">
				<div class="whcom_alert">
					<?php echo esc_html_x('We have three components in this stack. Each component of the stack can work in collaboration with each other or individually',"admin", 'whcom')?>
				</div>
			</div>
			<div class="whcom_col_sm_4">
				<div class="whcom_panel whcom_panel_<?php echo ($whmp_installed) ? 'success': 'info'; ?> whcom_panel_fancy_1">
					<div class="whcom_panel_header">
						<?php echo esc_html_x('WHMpress',"admin", 'whcom')?>
					</div>
					<div class="whcom_panel_body whcom_text_primary">
						<?php echo esc_html_x('It is used to display WHMCS products in a fancy way, without effort. Links will still point to WHMCS. Can be further extended using Addon, WHMCS Sliders & Comparison Tables (WPCT). WPCT is intended for users who need Sliders & Comparison tables.
', 'whcom')?>
					</div>
					<div class="whcom_panel_footer whcom_text_center">
						<?php if ($whmp_installed) { ?>
							<a href="<?php echo admin_url() . 'admin.php?page=whmp-settings'?>" class="whcom_button"><?php echo esc_html_x('Go to Settings','admin', 'whcom')?></a>
						<?php }
						else { ?>
							<a href="https://codecanyon.net/item/whmpress-whmcs-wordpress-integration-plugin/9946066" class="whcom_button"><?php echo esc_html_x('Get it Now',"admin", 'whcom')?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="whcom_col_sm_4">
				<div class="whcom_panel whcom_panel_<?php echo ($wcop_installed) ? 'success': 'info'; ?> whcom_panel_fancy_1">
					<div class="whcom_panel_header">
						<?php echo esc_html_x('WHMCS Cart & Order Pages (WCOP)',"admin", 'whcom')?>
					</div>
					<div class="whcom_panel_body whcom_text_primary">
						<?php echo esc_html_x('WCOP has beautifully designed order pages, which are feature-rich, user-friendly and functional. Users will not link to WHMCS anymore, and whole order process will complete on WordPress site including user login/ registration if needed.',"admin", 'whcom')?>
					</div>
					<div class="whcom_panel_footer whcom_text_center">
						<?php if ($wcop_installed) { ?>
							<a href="<?php echo admin_url() . 'admin.php?page=wcop-settings'?>" class="whcom_button"><?php echo esc_html_x('Go to Settings','admin', 'whcom')?></a>
						<?php }
						else { ?>
							<a href="https://codecanyon.net/item/whmcs-cart-order-pages/20011354" class="whcom_button"><?php echo esc_html_x('Get it Now',"admin", 'whcom')?></a>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="whcom_col_sm_4">
				<div class="whcom_panel whcom_panel_<?php echo ($wcap_installed) ? 'success': 'info'; ?> whcom_panel_fancy_1">
					<div class="whcom_panel_header">
						<?php echo esc_html_x('WHMCS Client Area with API (WCAP)',"admin", 'whcom')?>
					</div>
					<div class="whcom_panel_body whcom_text_primary">
						<?php echo esc_html_x('WCAP will bring client area to WordPress, this is the part that user will access after logging into to their WHMCS.',"admin", 'whcom')?>
					</div>
					<div class="whcom_panel_footer whcom_text_center">
						<?php if ($wcap_installed) { ?>
							<a href="<?php echo admin_url() . 'admin.php?page=wcap-settings'?>" class="whcom_button"><?php echo esc_html_x('Go to Settings',"admin", 'whcom')?></a>
						<?php }
						else { ?>
							<a href="https://codecanyon.net/item/whmcs-client-area-whmpress-addon/11218646" class="whcom_button"><?php echo esc_html_x('Get it Now',"admin", 'whcom')?></a>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="clear: both"></div>
</div>

