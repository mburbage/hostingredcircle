<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hosted
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
    
</head>

<body <?php body_class(); ?> >
    <?php if(hosted_get_option('preload')){ ?>
    <div class="images-preloader">
      <div class="preloader4"></div>
    </div>
    <?php } ?>
        <?php if(hosted_get_option( 'top_header' )) { ?>
        <div class="top-info">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="menu-top">
                            <?php
                                $top = array(
                                    'theme_location'  => 'top',
                                    'menu'            => '',
                                    'container'       => '',
                                    'container_class' => '',
                                    'container_id'    => '',
                                    'menu_class'      => '',
                                    'menu_id'         => '',
                                    'echo'            => true,
                                    'fallback_cb'     => 'hosted_bootstrap_navwalker::fallback',
                                    'walker'          => new hosted_bootstrap_navwalker(),
                                    'before'          => '',
                                    'after'           => '',
                                    'link_before'     => '',
                                    'link_after'      => '',
                                    'items_wrap'      => '<ul>%3$s</ul>',
                                    'depth'           => 0,
                                );
                                if ( has_nav_menu( 'top' ) ) {
                                    wp_nav_menu( $top );
                                }
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="contact-right">
                            <div class="info">
                                <?php $info = hosted_get_option( 'top_info', array() ); ?>
                                <?php if($info) { ?>
                                    <?php foreach ( $info as $inf ) { ?>
                                    <div class="col">
                                        <?php if($inf['icon']) { ?><span class="id-color"><i class="fa <?php echo esc_attr($inf['icon']); ?>"></i></span><?php } ?><?php echo do_shortcode($inf['details']); ?>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>

                            <?php $socials = hosted_get_option( 'socials', array() ); ?>
                            <?php if($socials) { ?>
                            <div class="social-top">
                                <?php foreach ( $socials as $social ) { ?>
                                <a href="<?php echo esc_url($social['link']); ?>"><i class="fa <?php echo esc_attr($social['icon']); ?>" aria-hidden="true"></i></a>
                                <?php } ?>
                            </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <header id="<?php if(hosted_get_option('sticky')) echo 'stick'; ?>" class="header">
            <div class="container">
                <h1 class="logo">
                    <?php 
                        $logo = hosted_get_option( 'logo' ) ? hosted_get_option( 'logo' ) : get_template_directory_uri().'/images/logo.png'; 
                    ?>
                    <a href="<?php echo esc_url( home_url('/') ); ?>"><img class="logo-img" src="<?php echo esc_url($logo); ?>" alt=""></a> 
                </h1>
                <div class="mobile-menu">
                    <a href=""><i class="fa fa-bars"></i></a>
				</div>
				<div class="whmpress-cart">
				<?php echo do_shortcode('[whcom_op_cart_summary type="dropdown"]'); ?>
				</div>
                <div class="main-nav">
                    <?php
                        $primary = array(
                            'theme_location'  => 'primary',
                            'menu'            => '',
                            'container'       => '',
                            'container_class' => '',
                            'container_id'    => '',
                            'menu_class'      => '',
                            'menu_id'         => '',
                            'echo'            => true,
                            'fallback_cb'     => 'hosted_bootstrap_navwalker::fallback',
                            'walker'          => new hosted_bootstrap_navwalker(),
                            'before'          => '',
                            'after'           => '',
                            'link_before'     => '',
                            'link_after'      => '',
                            'items_wrap'      => '<ul id="mainmenu" class="main-nav-inner">%3$s</ul>',
                            'depth'           => 0,
                        );
                        if ( has_nav_menu( 'primary' ) ) {
                            wp_nav_menu( $primary );
                        }
                    ?>
				</div>
				
            </div>
        </header>
