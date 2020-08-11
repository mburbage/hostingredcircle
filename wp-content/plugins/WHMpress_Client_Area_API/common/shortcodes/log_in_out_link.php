<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );


$order_url = get_option('wcapfield_client_area_url' . whcom_get_current_language(), '');
$order_url = (empty($order_url)) ? home_url('/') . 'client-area' : $order_url;
$product_url = $order_url . '?whmpca=';

$defaults = [
	'login_link_class'          => 'whcom_button',
	'login_link_text'           => esc_html__( 'Log In', 'whcom' ),
	'login_link_link_override'  => $product_url . 'login',
	'logout_link_class'         => 'whcom_button',
	'logout_link_text'          => esc_html__( 'Log Out', 'whcom' ),
	'logout_link_link_override' => $product_url . 'process_logout',
];
$params = shortcode_atts( $defaults, $atts );

if (whcom_is_client_logged_in()) {
	?>
	<a href="<?php echo $params['logout_link_link_override']; ?>" class="<?php echo $params['logout_link_class']; ?>">
		<?php echo $params['logout_link_text']; ?>
	</a>
	<?php
}
else {
	?>
	<a href="<?php echo $params['login_link_link_override']; ?>" class="<?php echo $params['login_link_class']; ?>">
		<?php echo $params['login_link_text']; ?>
	</a>
	<?php
}






