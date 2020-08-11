<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
$api_test    = whcom_api_test();
$helper_test = whcom_process_helper();
global $whcom_style_overrides;

?>

<div class="wrap whcom_main">


	<div class="whcom_panel">
		<div class="whcom_panel_header whcom_panel_header_white">
			<span><?php echo esc_html_x( 'Colors and Styling Override Settings', "admin", 'whcom' ) ?></span>
		</div>
		<div class="whcom_panel_body">
			<div class="whcom_alert whcom_alert_info">
				<div>
					<?php echo esc_html_x( "Info: You can use this section to match WHMCS component style with your theme.", "admin", "whcom" ) ?>
				</div>
				<div>
					<?php echo esc_html_x( "Plugins affected by the following styling", "admin", "whcom" ) ?>
				</div>
				<div>
					<?php echo esc_html_x( "1. WCAP - WHMCS Client Area Plugin", "admin", "whcom" ) ?>
				</div>
				<div>
					<?php echo esc_html_x( "2. WCOP - WHMCS Cart & Order Pages", "admin", "whcom" ) ?>
				</div>
			</div>
			<form method="post" action="options.php">
				<?php settings_fields( 'whcom_style' ); ?>
				<?php foreach ( $whcom_style_overrides as $style ) { ?>
					<div class="whcom_form_field whcom_form_field_horizontal">
						<?php $field = 'whcom_st' . $style['key'] ?>
						<?php $color = ( $style['type'] == 'color' ) ? 'whcom_color_input' : ''; ?>
						<label for="<?php echo "$field" ?>"><?php echo $style['title'] ?></label>
						<input id="<?php echo "$field" ?>"
						       type="text"
						       class="<?php echo "$color" ?>"
						       name="<?php echo "$field" ?>"
						       value="<?php echo esc_attr( get_option( $field, $style['value'] ) ); ?>">
					</div>
				<?php } ?>
				<div class="whcom_form_field whcom_text_center">
					<button type="submit"
					        class="whcom_button"><?php echo esc_html_x( 'Save Settings', "admin", 'whcom' ) ?></button>
				</div>
			</form>
			<form method="post"
			      action="options.php"
			      onsubmit="return confirm('<?php esc_html_e( 'Are you sure you want to restore defaults?', 'whcom' ) ?>');">
				<?php settings_fields( 'whcom_style' ); ?>
				<?php foreach ( $whcom_style_overrides as $style ) { ?>
					<?php $field = 'whcom_st' . $style['key'] ?>
					<input type="hidden" name="<?php echo "$field" ?>" value="<?php echo $style['value']; ?>">
				<?php } ?>
				<div class="whcom_form_field whcom_text_center">
					<button type="submit"
					        class="whcom_button whcom_button_danger"><?php echo esc_html_x( 'Restore Defaults', "admin", 'whcom' ) ?></button>
				</div>
			</form>
		</div>
	</div>
</div>

