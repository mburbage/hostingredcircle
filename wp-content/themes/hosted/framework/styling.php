<?php 

//Custom Style Frontend
if(!function_exists('hosted_custom_frontend_style')){
    function hosted_custom_frontend_style(){
    	$style_css 	= '';
        $bg_top     = '';
        $color_top  = '';
        $bg_h       = '';
        $bg_sm      = '';
        $color_sm   = '';
        $color_m    = '';

        $cl_pheader = '';
        $bg_pheader = '';
        $h_pheader  = '';

        $bg_hshop   = '';

        $logo_mar 	= '';
        $logo_w 	= '';
        $logo_h 	= '';
        $logo2_mar  = '';
        $logo2_w    = '';
        $logo2_h    = '';

        $bg_bt		= '';
        $color_bt	= '';

        $bgcms      = '';


        //Header

        if(hosted_get_option('bg_top')){
            $bg_top = 'header .top-info{ background: '.hosted_get_option('bg_top').'; }';
        }
        if(hosted_get_option('color_top')){
            $color_top = '.info, .info a, .menu-top li a{ color: '.hosted_get_option('color_top').'; }';
        }

        if(hosted_get_option('bg_menu')){
        	$bg_h = 'header.header{ background: '.hosted_get_option('bg_menu').'; }';
        }
        if(hosted_get_option('color_menu')){
        	$color_m = '.main-nav-inner li a{ color: '.hosted_get_option('color_menu').'; }';
        }
        if(hosted_get_option('bg_smenu')){
            $bg_sm = '.main-nav ul ul{ background: '.hosted_get_option('bg_smenu').'; } .main-nav ul ul li{ border-color: '.hosted_get_option('bg_smenu').'; }';
        }
        if(hosted_get_option('color_smenu')){
            $color_sm = '.main-nav ul ul a{ color: '.hosted_get_option('color_smenu').'; }';
        }

        //Logo
        if(hosted_get_option('logo_width')){
            $logo_w = '.header .logo img { width: '.hosted_get_option('logo_width').'px; }';
        }
        if(hosted_get_option('logo_height')){
            $logo_h = '.header .logo img { height: '.hosted_get_option('logo_height').'px; }';
        }
        if(hosted_get_option('logo_position')){
            $space = hosted_get_option('logo_position');
            $logo_mar = 'h1.logo { margin: '.$space["top"].' '.$space["right"].' '.$space["bottom"].' '.$space["left"].'; }';
        }
        //Logo Smaller
        if(hosted_get_option('logo_2_width')){
            $logo2_w = '.header.stuck .logo img { width: '.hosted_get_option('logo_2_width').'px; }';
        }
        if(hosted_get_option('logo_2_height')){
            $logo2_h = '.header.stuck .logo img { height: '.hosted_get_option('logo_2_height').'px; }';
        }
        if(hosted_get_option('logo_2_position')){
            $space2 = hosted_get_option('logo_2_position');
            $logo2_mar = '.header.stuck h1.logo { margin: '.$space2["top"].' '.$space2["right"].' '.$space2["bottom"].' '.$space2["left"].'; }';
        }

        //Page Header
        if(hosted_get_option('page_bg_color')){
            $bg_pheader = '.header-page{ background: '.hosted_get_option('page_bg_color').'; }';
        }
        if(hosted_get_option('page_header_color')){
            $h_pheader = '.header-page h2{ color:'.hosted_get_option('page_header_color').'; }';
        }

        //Page Header Shop
        if(hosted_get_option('page_header_shop')){
            $bg_hshop = '.header-page.shop-page{ background-image: url('.hosted_get_option('page_header_shop').'); background-size: cover; }';
        }

        //Coming Soon
        if(hosted_get_option('bgcms')){
            $bgcms = '.bgcms{ background-image: url('.hosted_get_option('bgcms').'); }';
        }

        //Footer
        if(hosted_get_option('bg_bottom')){
        	$bg_bt = 'footer, .top-footer{ background: '.hosted_get_option('bg_bottom').'; }';
        }
        if(hosted_get_option('color_bottom')){
        	$color_bt = 'footer p, footer a{ color: '.hosted_get_option('color_bottom').'; } footer .half-list li{ border: none; } ';
        }


        $style_css .= hosted_get_option('custom_css');
        $style_css .= $bg_top;
        $style_css .= $color_top;
        $style_css .= $bg_h;
        $style_css .= $color_m;
        $style_css .= $bg_sm;
        $style_css .= $color_sm;

        $style_css .= $logo_w;
        $style_css .= $logo_h;
        $style_css .= $logo_mar;
        $style_css .= $logo2_w;
        $style_css .= $logo2_h;
        $style_css .= $logo2_mar;

        $style_css .= $bgcms;

        $style_css .= $bg_hshop;

        $style_css .= $bg_bt;
        $style_css .= $color_bt;

        $style_css .= $bg_pheader;
        $style_css .= $h_pheader;

        if(! empty($style_css)){
			echo '<style type="text/css">'.$style_css.'</style>';
		}
    }
}
add_action('wp_head', 'hosted_custom_frontend_style');