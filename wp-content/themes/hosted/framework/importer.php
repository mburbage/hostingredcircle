<?php
/**
 * Hooks for importer
 *
 * @package MrBara
 */


/**
 * Importer the demo content
 *
 * @since  1.0
 *
 */
function mrbara_importer() {
	return array(
		array(
			'name'       => 'Hosted',
			'preview'    => get_template_directory_uri().'/framework/data/home.png',
			'content'    => get_template_directory_uri().'/framework/data/demo-content.xml',
			'customizer' => get_template_directory_uri().'/framework/data/customizer.dat',
			'widgets' 	 => get_template_directory_uri().'/framework/data/widgets.wie',
			'pages'      => array(
				'front_page' => 'Home 1',
				'blog'       => 'Blog, News & Announcements',				
				'shop'       => 'Shop',
				'cart'       => 'Cart',
				'checkout'   => 'Checkout',
				'my_account' => 'My Account',
			),
			'menus'      => array(
				'primary'      => 'main-menu',
				'top'          => 'top-menu'
			)
		),
	);
}

add_filter( 'soo_demo_packages', 'mrbara_importer', 30 );