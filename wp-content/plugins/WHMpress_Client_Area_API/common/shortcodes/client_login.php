<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


$order_url   = get_option( 'wcapfield_client_area_url' . whcom_get_current_language(), '' );
$order_url   = ( empty( $order_url ) ) ? home_url( '/' ) . 'client-area' : $order_url;
$product_url = $order_url . '?whmpca=';

$defaults = [
	'button_class' => 'whcom_button',
	'button_text'  => esc_html__( 'Log In', 'whcom' ),
	'redirect_url' => get_option('configure_product' . whcom_get_current_language(), esc_url( home_url( '/' ) ))
];
$params   = shortcode_atts( $defaults, $atts );

if ( ! whcom_is_client_logged_in() ) {
	?>
	<div class="whcom_login_form_container whcom_main">
		<form action="" method="post" class="whcom_login_form">
			<input type="hidden" name="action" value="whcom_ajax">
			<input type="hidden" name="whcom_ajax_what" value="client_login">
			<input type="hidden" name="redirect_url" value="<?php echo $params['redirect_url']; ?>">
			<?php echo whcom_render_login_form_fields(); ?>
			<div class="whcom_ajax_response"></div>
			<div class="whcom_text_center whcom_form_field">
				<button type="submit"><?php echo $params['button_text'] ?></button>
			</div>
		</form>
	</div>
	<?php
}
else {
	?><?php
}






