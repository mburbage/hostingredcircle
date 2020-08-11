<?php
/**
 * Hosted theme customizer
 *
 * @package Hosted
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Hosted_Customize {
	/**
	 * Customize settings
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * The class constructor
	 *
	 * @param array $config
	 */
	public function __construct( $config ) {
		$this->config = $config;

		if ( ! class_exists( 'Kirki' ) ) {
			return;
		}

		$this->register();
	}

	/**
	 * Register settings
	 */
	public function register() {
		/**
		 * Add the theme configuration
		 */
		if ( ! empty( $this->config['theme'] ) ) {
			Kirki::add_config(
				$this->config['theme'], array(
					'capability'  => 'edit_theme_options',
					'option_type' => 'theme_mod',
				)
			);
		}

		/**
		 * Add panels
		 */
		if ( ! empty( $this->config['panels'] ) ) {
			foreach ( $this->config['panels'] as $panel => $settings ) {
				Kirki::add_panel( $panel, $settings );
			}
		}

		/**
		 * Add sections
		 */
		if ( ! empty( $this->config['sections'] ) ) {
			foreach ( $this->config['sections'] as $section => $settings ) {
				Kirki::add_section( $section, $settings );
			}
		}

		/**
		 * Add fields
		 */
		if ( ! empty( $this->config['theme'] ) && ! empty( $this->config['fields'] ) ) {
			foreach ( $this->config['fields'] as $name => $settings ) {
				if ( ! isset( $settings['settings'] ) ) {
					$settings['settings'] = $name;
				}

				Kirki::add_field( $this->config['theme'], $settings );
			}
		}
	}

	/**
	 * Get config ID
	 *
	 * @return string
	 */
	public function get_theme() {
		return $this->config['theme'];
	}

	/**
	 * Get customize setting value
	 *
	 * @param string $name
	 *
	 * @return bool|string
	 */
	public function get_option( $name ) {
		if ( ! isset( $this->config['fields'][$name] ) ) {
			return false;
		}

		$default = isset( $this->config['fields'][$name]['default'] ) ? $this->config['fields'][$name]['default'] : false;

		return get_theme_mod( $name, $default );
	}
}

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function hosted_get_option( $name ) {
	global $hosted_customize;

	if ( empty( $hosted_customize ) ) {
		return false;
	}

	if ( class_exists( 'Kirki' ) ) {
		$value = Kirki::get_option( $hosted_customize->get_theme(), $name );
	} else {
		$value = $hosted_customize->get_option( $name );
	}

	return apply_filters( 'hosted_get_option', $value, $name );
}

/**
 * Move some default sections to `general` panel that registered by theme
 *
 * @param object $wp_customize
 */
function hosted_customize_modify( $wp_customize ) {
	$wp_customize->get_section( 'title_tagline' )->panel     = 'general';
	$wp_customize->get_section( 'static_front_page' )->panel = 'general';
}

add_action( 'customize_register', 'hosted_customize_modify' );

/**
 * Customizer configuration
 */
$hosted_customize = new Hosted_Customize(
	array(
		'theme'    => 'hosted',

		'panels'   => array(
			'general' => array(
				'priority' => 10,
				'title'    => esc_html__( 'General', 'hosted' ),
			),
			'header'  => array(
				'priority' => 11,
				'title'    => esc_html__( 'Header', 'hosted' ),
			),
			'socials'  => array(
				'priority' => 210,
				'title'    => esc_html__( 'Socials', 'hosted' ),
			),
		),

		'sections' => array(

			// Panel Header
			'top_header'      => array(
				'title'       => esc_html__( 'Top Header', 'hosted' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'header'      => array(
				'title'       => esc_html__( 'Navigation', 'hosted' ),
				'description' => '',
				'priority'    => 10,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'logo'        => array(
				'title'       => esc_html__( 'Site Logo', 'hosted' ),
				'description' => '',
				'priority'    => 50,
				'capability'  => 'edit_theme_options',
				'panel'       => 'header',
			),
			'page_header' => array(
				'title'       => esc_html__( 'Page Header', 'hosted' ),
				'description' => '',
				'priority'    => 15,
				'capability'  => 'edit_theme_options',
			),

			// Panel Socials
			'socials'      => array(
				'title'       => esc_html__( 'Socials', 'hosted' ),
				'description' => '',
				'priority'    => 220,
				'capability'  => 'edit_theme_options',
			),

			
			// Panel Content
			'content'     => array(
				'title'       => esc_html__( 'Blog', 'hosted' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Projects
			'project'     => array(
				'title'       => esc_html__( 'Portfolio', 'hosted' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Shop
			'shop'     => array(
				'title'       => esc_html__( 'Shop', 'hosted' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),

			// Panel Footer
			'footer'     => array(
				'title'       => esc_html__( 'Footer', 'hosted' ),
				'description' => '',
				'priority'    => 240,
				'capability'  => 'edit_theme_options',
			),


			// Coming Soon
			'csoon'     => array(
				'title'       => esc_html__( 'Coming Soon', 'hosted' ),
				'description' => '',
				'priority'    => 245,
				'capability'  => 'edit_theme_options',
			),


			// Panel Styling
			'styling'     => array(
				'title'       => esc_html__( 'Miscellaneous', 'hosted' ),
				'description' => '',
				'priority'    => 250,
				'capability'  => 'edit_theme_options',
			),
		),

		'fields'   => array(

			//Top Header
			'top_header' => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Enable Top Header', 'hosted' ),
				'section'  => 'top_header',
				'default'  => '1',
				'priority' => 10,
			),
			'bg_top'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background', 'hosted' ),
				'section'  => 'top_header',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'top_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'color_top'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text', 'hosted' ),
				'section'  => 'top_header',
				'default'  => '',
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'top_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'top_info'     => array(
				'type'     => 'repeater',
				'label'    => esc_html__( 'Top Infomation', 'hosted' ),
				'section'  => 'top_header',
				'priority' => 10,
				'fields'   => array(
					'icon' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Icon Class', 'hosted' ),
						'description' => esc_html__( 'This will be the icon: http://fontawesome.io/icons/', 'hosted' ),
						'default'     => '',
					),
					'details' => array(
						'type'        => 'textarea',
						'label'       => esc_html__( 'Details', 'hosted' ),
						'description' => esc_html__( 'This will be the details', 'hosted' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
					  	'setting'  => 'top_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'socials'     => array(
				'type'     => 'repeater',
				'label'    => esc_html__( 'Socials', 'hosted' ),
				'section'  => 'top_header',
				'priority' => 10,
				'default'  => array(),
				'fields'   => array(
					'icon' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Icon Class', 'hosted' ),
						'description' => esc_html__( 'This will be the social icon: http://fontawesome.io/icons/', 'hosted' ),
						'default'     => '',
					),
					'link' => array(
						'type'        => 'text',
						'label'       => esc_html__( 'Link URL', 'hosted' ),
						'description' => esc_html__( 'This will be the social link', 'hosted' ),
						'default'     => '',
					),
				),
				'active_callback' => array(
					array(
					  	'setting'  => 'top_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),

			'sticky'     => array(
				'type'     => 'toggle',
				'label'    => esc_html__( 'Sticky Header', 'hosted' ),
				'section'  => 'header',
				'default'  => '1',
				'priority' => 10,
			),
			'bg_menu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Main Menu', 'hosted' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'color_menu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Menu', 'hosted' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			
			'bg_smenu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Dropdown Menu', 'hosted' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			'color_smenu'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Dropdown Menu', 'hosted' ),
				'section'  => 'header',
				'default'  => '',
				'priority' => 10,
			),
			

			// Logo
			'logo'           => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo', 'hosted' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_width'     => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Width', 'hosted' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_height'    => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Logo Height', 'hosted' ),
				'section'  => 'logo',
				'default'  => '',
				'priority' => 10,
			),
			'logo_position'  => array(
				'type'     => 'spacing',
				'label'    => esc_html__( 'Logo Margin', 'hosted' ),
				'section'  => 'logo',
				'priority' => 10,
				'default'  => array(
					'top'    => '18px',
					'bottom' => '20px',
					'left'   => '0',
					'right'  => '0',
				),
			),
			

			// Page Header
			'page_header'    => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Page Header', 'hosted' ),
				'description' => esc_html__( 'Enable to show page header on whole site', 'hosted' ),
				'section'     => 'page_header',
				'default'     => '1',
				'priority'    => 10,
			),
			'page_header_padd'     => array(
				'type'     => 'number',
				'label'    => esc_html__( 'Padding Top & Bottom', 'hosted' ),
				'section'  => 'page_header',
				'default'  => 50,
				'priority' => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
				'output' => array(
					array(
						'element'  => '.header-page',
						'property' => 'padding-top',
						'units'    => 'px',
					),
					array(
						'element'  => '.header-page',
						'property' => 'padding-bottom',
						'units'    => 'px',
					),
				),
			),
			'page_header_bg' => array(
				'type'        => 'image',
				'label'       => esc_html__( 'Background Image', 'hosted' ),
				'description' => esc_html__( 'Upload a page header background image', 'hosted' ),
				'section'     => 'page_header',
				'default'     => '',
				'priority'    => 10,
				'active_callback' => array(
				 	array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),
			'page_bg_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Color', 'hosted' ),
				'section'  => 'page_header',
				'default'  => '',
				'priority' => 10,
			),
			'page_header_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Page Title', 'hosted' ),
				'section'  => 'page_header',
				'default'  => '#fff',
				'priority' => 10,
			),
			'breadcrumb'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Breadcrumb', 'hosted' ),
				'description' => esc_html__( 'Enable to show a breadcrumb bellow the site header', 'hosted' ),
				'section'     => 'page_header',
				'default'     => '1',
				'priority'    => 10,
			),
			'search_header'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Search Form', 'hosted' ),
				'description' => esc_html__( 'Enable to show search form in the page header', 'hosted' ),
				'section'     => 'page_header',
				'default'     => '1',
				'priority'    => 10,
				'active_callback' => array(
					array(
					  	'setting'  => 'page_header',
					  	'operator' => '==',
					  	'value'    => 1,
				 	),
				),
			),

			// Content
			'blog_layout'  => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Blog List Layout', 'hosted' ),
				'section'  => 'content',
				'default'  => 'default',
				'priority' => 10,
				'choices'  => array(
					'default' 	=> get_template_directory_uri() . '/framework/admin/images/right.png',
					'left-bar' 	=> get_template_directory_uri() . '/framework/admin/images/left.png',
					'no-bar' 	=> get_template_directory_uri() . '/framework/admin/images/full.png',
				),
			),
			'post_layout'  => array(
				'type'     => 'radio-image',
				'label'    => esc_html__( 'Single Blog Layout', 'hosted' ),
				'section'  => 'content',
				'default'  => 'default',
				'priority' => 10,
				'choices'  => array(
					'default' 	=> get_template_directory_uri() . '/framework/admin/images/right.png',
					'left-bar' 	=> get_template_directory_uri() . '/framework/admin/images/left.png',
					'no-bar' 	=> get_template_directory_uri() . '/framework/admin/images/full.png',
				),
			),
			'title_single' => array(
				'type'    		=> 'text',
				'label'   		=> esc_html__( 'Title Header Single', 'hosted' ),
				'section' 		=> 'content',
				'default' 		=> '',
				'priority'    	=> 12,
			),
			'read_more' => array(
				'type'    		=> 'text',
				'label'   		=> esc_html__( 'Read More Button', 'hosted' ),
				'section' 		=> 'content',
				'default' 		=> '',
				'priority'    	=> 12,
			),
			'excerpt_length' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Excerpt Length', 'hosted' ),
				'section' => 'content',
				'default' => 30,
				'choices' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
			),

			//Shop
			'page_header_shop' => array(
				'type'        => 'image',
				'label'       => esc_html__( 'Background Image', 'hosted' ),
				'description' => esc_html__( 'Upload a page header background image', 'hosted' ),
				'section'     => 'shop',
				'default'     => '',
				'priority'    => 10,
			),
			'per_shop' => array(
				'type'    		=> 'number',
				'label'   		=> esc_html__( 'Products Per Page', 'hosted' ),
				'section' 		=> 'shop',
				'default' 		=> '6',
				'priority'    	=> 12
			),

			//Footer
			'bg_bottom'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Background Footer', 'hosted' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
			),
			'color_bottom' => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Color Text Footer', 'hosted' ),
				'section'  => 'footer',
				'default'  => '',
				'priority' => 10,
			),

			
			// Coming Soon
			'logocms'           => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Logo', 'hosted' ),
				'section'  => 'csoon',
				'default'  => '',
				'priority' => 10,
			),
			'bgcms'           => array(
				'type'     => 'image',
				'label'    => esc_html__( 'Background Image', 'hosted' ),
				'section'  => 'csoon',
				'default'  => '',
				'priority' => 10,
			),
			'time_date'           => array(
				'type'     => 'datepicker',
				'label'    => esc_html__( 'Date Time', 'hosted' ),
				'section'  => 'csoon',
				'default'  => '08/30/2017',
				'description' => esc_html__( 'Date format: dd/mm/yyyy. Example: 10/25/2017', 'hosted' ),
				'priority' => 10,
			),
			'mailchimp'      => array(
				'type'     => 'text',
				'label'    => esc_html__( 'Shortcode Newsletter', 'hosted' ),
				'section'  => 'csoon',
				'default'  => '[mc4wp_form id="38"]',
				'priority' => 10,
				'description' => esc_html__( 'Find in MailChimp for WP > Forms.', 'hosted' ),
			),
			

			//Styling
			'preload'     => array(
				'type'        => 'toggle',
				'label'       => esc_html__( 'Preloader', 'hosted' ),
				'section'     => 'styling',
				'default'     => '1',
				'priority'    => 10,
			),
			'api_map'      => array(
				'type'     => 'text',
				'label'    => esc_html__( 'API Google Map', 'hosted' ),
				'section'  => 'styling',
				'default'  => 'AIzaSyAvpnlHRidMIU374bKM5-sx8ruc01OvDjI',
				'priority' => 10,
			),
			'main_color'    => array(
				'type'     => 'color',
				'label'    => esc_html__( 'Primary Color', 'hosted' ),
				'section'  => 'styling',
				'default'  => '#259b24',
				'priority' => 10,
			),
			'custom_css'     => array(
				'type'        => 'code',
				'label'       => esc_html__( 'Custom Code', 'hosted' ),
				'description' => esc_html__( 'Add more js, css, html... code here.', 'hosted' ),
				'section'     => 'styling',
				'default'     => '',
				'priority'    => 10,
			),
		),
	)
);