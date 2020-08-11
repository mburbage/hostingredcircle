<?php defined( 'ABSPATH' ) or die( "Cannot access pages directly." );
/**====================================================================**/
/**==       CONSTANT Definitions                                     ==**/
/**====================================================================**/
if ( ! defined( 'WHCOM_VERSION' ) ) {
	define( 'WHCOM_VERSION', '2.6.3' );
}
if ( ! defined( 'WHCOM_FILE' ) ) {
	define( 'WHCOM_FILE', __FILE__ );
}
if ( ! defined( 'WHCOM_PATH' ) ) {
	define( 'WHCOM_PATH', str_replace('\\', '/', dirname( __FILE__ )) );
}
if ( ! defined( 'WHCOM_URL' ) ) {
	define( 'WHCOM_URL', plugin_dir_url( __FILE__ ));
}

$whcom_style_overrides = [
	[
		'title' => esc_html_x('Main Text Color', 'admin','whcom'),
		'type'  => 'color',
		'key'   => 'text_color',
		'value' => '#040404'
	],
	[
		'title' => esc_html_x('Main Font Size','admin', 'whcom'),
		'type'  => 'px',
		'key'   => 'font_size',
		'value' => '16px'
	],
	[
		'title' => esc_html_x('Primary Color (buttons bg, anchor color ect etc...)','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'color_primary',
		'value' => '#337ab7'
	],
	[
		'title' => esc_html_x('Link Color', 'admin','whcom'),
		'type'  => 'color',
		'key'   => 'link_color',
		'value' => '#0e5077'
	],
	[
		'title' => esc_html_x('Link Color Hover', 'admin','whcom'),
		'type'  => 'color',
		'key'   => 'link_color_hover',
		'value' => '#093149'
	],
	[
		'title' => esc_html_x('Button Primary: Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_cl_primary',
		'value' => '#ffffff'
	],
	[
		'title' => esc_html_x('Button Primary: Background','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_bg_primary',
		'value' => '#337ab7'
	],
	[
		'title' => esc_html_x('Button Primary: Border Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_br_primary',
		'value' => '#0b4160'
	],
	[
		'title' => esc_html_x('Button Primary Hover: Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_cl_primary_hover',
		'value' => '#ffffff'
	],
	[
		'title' => esc_html_x('Button Primary Hover: Background','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_bg_primary_hover',
		'value' => '#093149'
	],
	[
		'title' => esc_html_x('Button Primary Hover: Border Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_br_primary_hover',
		'value' => '#062233'
	],
	[
		'title' => esc_html_x('Button Secondary: Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_cl_secondary',
		'value' => '#e6e6e6'
	],
	[
		'title' => esc_html_x('Button Secondary: Background', 'admin','whcom'),
		'type'  => 'color',
		'key'   => 'btn_bg_secondary',
		'value' => '#ffffff'
	],
	[
		'title' => esc_html_x('Button Secondary: Border Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_br_secondary',
		'value' => '#040404'
	],
	[
		'title' => esc_html_x('Button Secondary Hover: Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_cl_secondary_hover',
		'value' => '#040404'
	],
	[
		'title' => esc_html_x('Button Secondary Hover: Background','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'btn_bg_secondary_hover',
		'value' => '#e6e6e6'
	],
	[
		'title' => esc_html_x('Button Secondary Hover: Border Color', 'admin','whcom'),
		'type'  => 'color',
		'key'   => 'btn_br_secondary_hover',
		'value' => '#d6d6d6'
	],
	[
		'title' => esc_html_x('Border Radius General','admin', 'whcom'),
		'type'  => 'px',
		'key'   => 'border_radius',
		'value' => '4px'
	],
	[
		'title' => esc_html_x('Border Radius Button','admin', 'whcom'),
		'type'  => 'px',
		'key'   => 'btn_br_radius',
		'value' => '4px'
	],
	[
		'title' => esc_html_x('Success Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'color_success',
		'value' => '#5cb85c'
	],
	[
		'title' => esc_html_x('Info Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'color_info',
		'value' => '#5bc0de'
	],
	[
		'title' => esc_html_x('Warning Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'color_warning',
		'value' => '#f0ad4e'
	],
	[
		'title' => esc_html_x('Danger Color','admin', 'whcom'),
		'type'  => 'color',
		'key'   => 'color_danger',
		'value' => '#d9534f'
	],
];


include_once WHCOM_PATH . "/includes/functions.php";