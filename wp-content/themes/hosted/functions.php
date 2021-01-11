<?php
/**
 * Redux Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package hosted
 */


if ( ! function_exists( 'hosted_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function hosted_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Redux Theme, use a find and replace
	 * to change 'hosted' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'hosted', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'hosted' ),
		'top' => esc_html__( 'Top Menu', 'hosted' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-list',
		'comment-form',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'audio',
		'image',
		'video',
		'gallery',
	) );
	
}
endif; // hosted_setup
add_action( 'after_setup_theme', 'hosted_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function hosted_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'hosted_content_width', 640 );
}
add_action( 'after_setup_theme', 'hosted_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hosted_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'hosted' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'hosted' ),  
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'hosted' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'hosted' ),  
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title id-color">',
		'after_title'   => '</h5>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer One Widget Area', 'hosted' ),
		'id'            => 'footer-area-1',
		'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'hosted' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Two Widget Area', 'hosted' ),
		'id'            => 'footer-area-2',
		'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'hosted' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Three Widget Area', 'hosted' ),
		'id'            => 'footer-area-3',
		'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'hosted' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Fourth Widget Area', 'hosted' ),
		'id'            => 'footer-area-4',
		'description'   => esc_html__( 'Footer Widget that appears on the Footer.', 'hosted' ),
		'before_widget' => '<div id="%1$s" class="widget footer-widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) ); 

	
}
add_action( 'widgets_init', 'hosted_widgets_init' );

/**
 * Enqueue Google fonts.
 */
function hosted_fonts_url() {
    $fonts_url = '';

    /* Translators: If there are characters in your language that are not
    * supported by Lora, translate this to 'off'. Do not translate
    * into your own language.
    */
    $nuni = _x( 'on', 'Nunito font: on or off', 'hosted' );
    $merr = _x( 'on', 'Merriweather font: on or off', 'hosted' );
 
 
    if ( 'off' !== $nuni || 'off' !== $merr) {
        $font_families = array();

        if ( 'off' !== $nuni ) {
            $font_families[] = 'Nunito:200,500';
        } 
        if ( 'off' !== $merr ) {
            $font_families[] = 'Merriweather:300,700';
        } 
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
 
    return esc_url_raw( $fonts_url );
}


/**
 * Enqueue scripts and styles.
 */
function hosted_scripts() {

	$protocol = is_ssl() ? 'https' : 'http';

	// Add custom fonts, used in the main stylesheet.
    wp_enqueue_style( 'hosted-fonts', hosted_fonts_url(), array(), null );

    /** All frontend css files **/ 
    wp_enqueue_style( 'bootstrap', get_template_directory_uri().'/css/bootstrap.css');
    //wp_enqueue_style( 'font-awesome', get_template_directory_uri().'/fonts/font-awesome/css/font-awesome.css');
    wp_enqueue_style( 'etline', get_template_directory_uri().'/js/owlcarousel/owl.carousel.css');
    wp_enqueue_style( 'magnific', get_template_directory_uri().'/js/magnific-popup/magnific-popup.css');
	wp_enqueue_style( 'owl-carousel', get_template_directory_uri().'/js/owlcarousel/owl.carousel.css');
	//wp_enqueue_style( 'hosted-woocommerce', get_template_directory_uri().'/css/woocommerce.css');

	wp_enqueue_style( 'hosted-style', get_stylesheet_uri() );
	

	/** All frontend js files **/
	//wp_enqueue_script("mapapi", "$protocol://maps.google.com/maps/api/js?key=".hosted_get_option('api_map')."",array(),false,false); 
	//wp_enqueue_script("parallax", get_template_directory_uri()."/js/parallax.js",array('jquery'),false,true);
	wp_enqueue_script("easing", get_template_directory_uri()."/js/easing.js",array('jquery'),false,true);
    //wp_enqueue_script("countTo", get_template_directory_uri()."/js/jquery.countTo.js",array('jquery'),false,true);
	wp_enqueue_script("isotope", get_template_directory_uri()."/js/jquery.isotope.min.js",array('jquery'),false,true);
    wp_enqueue_script("owl-carousel", get_template_directory_uri()."/js/owlcarousel/owl.carousel.js",array('jquery'),false,false);
    if(hosted_get_option('sticky')){
	wp_enqueue_script("sticky-kit", get_template_directory_uri()."/js/jquery.sticky-kit.min.js",array('jquery'),false,true);
	wp_enqueue_script("sticky", get_template_directory_uri()."/js/sticky.js",array('jquery'),false,true);
    }
	wp_enqueue_script("magnific", get_template_directory_uri()."/js/magnific-popup/jquery.magnific-popup.js",array('jquery'),false,true);
    wp_enqueue_script("hosted-js", get_template_directory_uri()."/js/script.js",array('jquery'),false,true);
}
add_action( 'wp_enqueue_scripts', 'hosted_scripts' );


/**
 * Implement the Custom Meta Boxs.
 */
require get_template_directory() . '/framework/meta-boxes.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/framework/template-tags.php';
require get_template_directory() . '/framework/importer.php';
/**
 * Custom shortcode plugin visual composer.
 */
require_once get_template_directory() . '/shortcodes.php';
require_once get_template_directory() . '/vc_shortcode.php';
require_once get_template_directory() . '/framework/customizer.php';
/**
 * Customizer Menu.
 */
require get_template_directory() . '/framework/wp_bootstrap_navwalker.php';
/**
 * Enqueue Style
 */
require get_template_directory() . '/framework/color.php';
require get_template_directory() . '/framework/styling.php';
/**
 * Customizer Shop.
 */
require get_template_directory() . '/framework/woocommerce-customize.php';

//Code Visual Composer.
// Add new Param in Row
if(function_exists('vc_add_param')){
	vc_add_param('vc_row', array(
								"type" => "dropdown",
								"heading" => esc_html__('Setup Full Width', 'hosted'),
								"param_name" => "fullwidth",
								"value" => array(   
								                esc_html__('No', 'hosted') => 'no',  
								                esc_html__('Yes', 'hosted') => 'yes',                                                                                
								              ),
								"description" => esc_html__("Select Full width for row : yes or not, Default: No fullwidth", "hosted"),      
					        )
    );
    vc_add_param('vc_row',array(
                              	"type" => "checkbox",
                              	"heading" => esc_html__('Background Parallax', 'hosted'),
                              	"param_name" => "parallax_bg",     
                            ) 
    );

    // Add new Param in Column	
    vc_add_param('vc_column',array(
		  "type" => "dropdown",
		  "heading" => esc_html__('CSS Animation', 'hosted'),
		  "param_name" => "animate",
		  "value" => array(   
							__('None', 'hosted') => 'none', 
							__('Fade In Up', 'hosted') => 'fadeinup', 
							__('Fade In Down', 'hosted') => 'fadeindown', 
							__('Fade In', 'hosted') => 'fadein', 
							__('Fade In Left', 'hosted') => 'fadeinleft',  
							__('Fade In Right', 'hosted') => 'fadinright',
						  ),
		  "description" => esc_html__("Select Animate , Default: None", 'hosted'),      
		) 
    );
    vc_add_param('vc_column',array(
          "type" => "textfield",
          "heading" => esc_html__('Animation time delay number', 'hosted'),
          "param_name" => "delay",
          "value" => "",
          "description" => esc_html__("Example : 0.2, 0.6, 1, etc", 'hosted'), 
          "dependency"  => array( 'element' => 'animate', 'value' => array( 'fadeinup', 'fadeindown', 'fadein', 'fadeinleft', 'fadinright' ) ),     
        ) 
    );
    vc_add_param('vc_column',array(
          "type" => "textfield",
          "heading" => esc_html__('Animation time duration number', 'hosted'),
          "param_name" => "duration",
          "value" => "",
          "description" => esc_html__("Example : 0.2, 0.6, 1, etc", 'hosted'),   
          "dependency"  => array( 'element' => 'animate', 'value' => array( 'fadeinup', 'fadeindown', 'fadein', 'fadeinleft', 'fadinright' ) ),   
        ) 
    );

    // Add new Param in Column inner
    vc_add_param('vc_column_inner',array(
          "type" => "dropdown",
          "heading" => esc_html__('CSS Animation', 'hosted'),
          "param_name" => "animate",
          "value" => array(   
                            esc_html__('None', 'hosted') => 'none', 
                            esc_html__('Fade In Up', 'hosted') => 'fadeinup', 
                            esc_html__('Fade In Down', 'hosted') => 'fadeindown', 
                            esc_html__('Fade In', 'hosted') => 'fadein', 
                            esc_html__('Fade In Left', 'hosted') => 'fadeinleft',  
                            esc_html__('Fade In Right', 'hosted') => 'fadeinright',
                          ),
          "description" => esc_html__("Select Animate , Default: None", 'hosted'),      
        ) 
    );
    vc_add_param('vc_column_inner',array(
          "type" => "textfield",
          "heading" => esc_html__('Animation time delay number', 'hosted'),
          "param_name" => "delay",
          "value" => "",
          "description" => esc_html__("Example : 0.2, 0.6, 1, etc", 'hosted'), 
          "dependency"  => array( 'element' => 'animate', 'value' => array( 'fadeinup', 'fadeindown', 'fadein', 'fadeinleft', 'fadeinright' ) ),     
        ) 
    );
    vc_add_param('vc_column_inner',array(
          "type" => "textfield",
          "heading" => esc_html__('Animation time duration number', 'hosted'),
          "param_name" => "duration",
          "value" => "",
          "description" => esc_html__("Example : 0.2, 0.6, 1, etc", 'hosted'),   
          "dependency"  => array( 'element' => 'animate', 'value' => array( 'fadeinup', 'fadeindown', 'fadein', 'fadeinleft', 'fadeinright' ) ),   
        ) 
    );
}

if(function_exists('vc_remove_param')){
	vc_remove_param( "vc_row", "parallax" );
	vc_remove_param( "vc_row", "parallax_image" );
	vc_remove_param( "vc_row", "parallax_speed_bg" );
	vc_remove_param( "vc_row", "parallax_speed_video" );
	vc_remove_param( "vc_row", "full_width" );
	vc_remove_param( "vc_row", "full_height" );
	vc_remove_param( "vc_row", "video_bg" );
	vc_remove_param( "vc_row", "video_bg_parallax" );
	vc_remove_param( "vc_row", "video_bg_url" );
	vc_remove_param( "vc_row", "columns_placement" );
	vc_remove_param( "vc_row", "gap" );	
}	

/**
 * Require plugins install for this theme.
 *
 * @since Split Vcard 1.0
 */
require_once get_template_directory() . '/framework/plugin-requires.php';
