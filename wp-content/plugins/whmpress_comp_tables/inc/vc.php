<?php
add_action( 'vc_before_init', 'wpct_group_vc_shortcode' );
function wpct_group_vc_shortcode() {
	$shortcodes = [
		"WPCT Order Slider"      => "whmpress_order_slider",
		"WPCT Tables Group"      => "whmpress_pricing_table_group",
		"WPCT Comparison Tables" => "whmpress_comparison_table",
	];

	global $WHMP_GRP;

	foreach ( $shortcodes as $title => $shortcode ) {
		$files = $WHMP_GRP->get_all_template_files( $shortcode );

		$Files = [];
		$Files['Select Template'] = '';
		foreach($files as $file) {
			$Files[$file['description']] = $file['file_path'];
		}

		$args = [
			"name"     => __( $title, "whmpress" ),
			"base"     => $shortcode,
			"category" => __( "WPCT", "whmpress" ),
			"icon"     => WPCT_GRP_URL . "/admin/images/logo.png",
			"params"   => [
				[
					"type"        => "dropdown",
					"heading"     => __( "ID", "whmpress" ),
					"param_name"  => "id",
					"value"       => array_merge( [ 'Select Plan' ], wpct_get_all_groups( true ) ),
					"description" => __( "Put Plan ID here", "whmpress" ),
				],
				[
					"type"        => "dropdown",
					"heading"     => __( "Template", "whmpress" ),
					"param_name"  => "html_template",
					//"value"       => array_merge( [ 'Select Template' ], wpct_get_shortcode_templates( $shortcode ) ),
					"value"       => $Files,
					"description" => __( "Which template do you want to use?", "whmpress" ),
				],
			],
		];
		vc_map( $args );
	}
}