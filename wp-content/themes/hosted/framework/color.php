<?php 

//Custom Style Frontend
if(!function_exists('hosted_color_scheme')){
    function hosted_color_scheme(){
        $main_color = '';

        //Main Color
        if(hosted_get_option('main_color')){
            $main_color = 
            '
			h2.under-line:after,
			h4.under-line:after,
			.bg-color,
			.btn-color,
			.btn-dark:hover,.btn-dark:focus,
			header.header,
			.main-nav ul ul a:hover,
			.mc4wp-form input[type=submit],
			#scroll-top,
			.pagination > li > a:hover, .pagination > li > span:hover,.pagination > li > span,
			.form-submit #submit,
			form.form-inline button:hover,
			.icon-fact i,
			.testimonial2.owl-theme .owl-controls .owl-page.active span,
			.color-box,
			.active.pricing .price-btn a,
			.hosted-domain-price .inner,
			.style2.whmpress_domain_search_ajax form button,.style2.whmpress_domain_search .submit_div input,
			.style3.style2.whmpress_domain_search .submit_div input:hover,
			.countdown,
			.wpb-js-composer div.vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs-position-top .vc_tta-tab>a:hover, 
			.wpb-js-composer div.vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs-position-top .vc_tta-tab.vc_active>a,
			div.whmp .btn.btn-primary,
			div.whmp .btn.btn-danger,
			div.whmp .alert.alert-danger,
			div.whmp .badge,
			div.whmp #thetopbar .badge,
			div.whmp section#home-banner input[type="submit"].btn.btn-warning,
			div.whmp .announcement-single a.label.label-warning:hover,
			div.whmp .announcement-single h3 span.label.label-default,
			div.whmp .sidebar .list-group a.list-group-item.active,
			div.whmp .login-form-panel h3.badge,
			div.whmp .login-form input[type="submit"]
			{background-color: '.hosted_get_option('main_color').';}

			.pagination > li > a:hover, .pagination > li > span:hover,.pagination > li > span, 
			.domain-search form,.style1.whmpress_domain_search_ajax form,.style1.whmpress_domain_search form,
			div.whmp .sidebar .list-group a.list-group-item.active
			{border-color: '.hosted_get_option('main_color').';}

			blockquote, 
			.preloader4
			{border-left-color: '.hosted_get_option('main_color').';}

			.preloader4
			{border-right-color: '.hosted_get_option('main_color').';}

			.project-filter li a.selected, 
			.pricing .pricing-title, 
			.black-box h3, 
			.preloader4
			{border-bottom-color: '.hosted_get_option('main_color').';}

			a:hover, 
			a:focus, 
			h2.line:after, 
			.id-color,.link-color a, 
			.info, 
			.social-top a, 
			.page-breadcrumb a:hover, 
			footer .widget h5, 
			.mc4wp-form input[type=submit]:hover, 
			.rm-btn a:hover, 
			.sidebar .widget h5, 
			.widget_tag_cloud li a:hover, 
			.contact-info li a, 
			.box1 .icon-img img,.icon-box .icon-img i, 
			.testimonial-s2 .owl-controls .owl-buttons div, 
			.arrow-list li:before, 
			.list-check li:before, 
			.pricing-features ul.price-list li:before, 
			.pricing-features ul.text-center i:before, 
			.pricing3 ul li i, 
			.wpb-js-composer div.vc_tta-color-grey.vc_tta-style-classic.vc_tta-tabs-position-left .vc_tta-tab.vc_active>a,
			div.whmp .home-shortcuts h2:after, 
			div.whmp a, 
			div.whmp .home-shortcuts li i, 
			div.whmp .announcement-single h3 a:hover, 
			div.whmp .announcement-single blockquote p a, 
			div.whmp .tweet a, #twitterFeedOutput a, 
			div.whmp .header-lined ol.breadcrumb li a, 
			div.whmp .kbcategories a,
			div.whmp .login-form p a:hover, 
			div.whmp .client-home-panels .list-group a span
			{color: '.hosted_get_option('main_color').';}
			';
        }

        if(! empty($main_color)){
			echo '<style type="text/css">'.$main_color.'</style>';
		}
    }
}
add_action('wp_head', 'hosted_color_scheme');