<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hosted
 */

get_header(); ?>

    <?php if(hosted_get_option('page_header')) { ?>
    <?php $img = hosted_get_option( 'page_header_bg' ) ? hosted_get_option( 'page_header_bg' ) : ''; ?>
    <section class="header-page" <?php if($img) { ?>style="background-image: url(<?php echo esc_url($img); ?>); background-size: cover;"<?php } ?>>
        <div class="container">
            <h2 class="page-title"><?php if( is_home() && is_front_page() ) echo esc_html__( 'Blog', 'hosted' ); else echo get_the_title( get_option( 'page_for_posts' ) ); ?></h2>
            <?php if(hosted_get_option('search_header')) { ?>
            <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                <input type="text" value="" name="s" placeholder="<?php echo esc_html__( 'search...', 'hosted' ) ?>">
                <button><i class="fa fa-search"></i></button>
            </form>
            <?php } ?>
        </div>
    </section>
    <?php }if(hosted_get_option('breadcrumb') && function_exists('bcn_display') && !is_front_page()) { ?>
    <div class="page-breadcrumb">
        <div class="container">
            <?php bcn_display(); ?>
        </div>
    </div>
    <?php } ?>
    <div id="content" class="<?php echo esc_attr( hosted_get_option('blog_layout') ); ?>">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="blog-list">
                    <?php if( have_posts() ) : ?>
                        <?php 
                            while (have_posts()) : the_post();
                                get_template_part( 'content', get_post_format() ) ;
                            endwhile;
                        ?>
                    <?php endif; ?>
                    </div>
                    <?php echo hosted_pagination(); ?>    
                </div>

                <div class="col-md-4">
                    <div class="sidebar">
                        <?php get_sidebar();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>