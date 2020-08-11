<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hosted
 */

get_header(); ?>
    

    <?php if(hosted_get_option('page_header')) { ?>
    <?php $img = hosted_get_option( 'page_header_bg' ) ? hosted_get_option( 'page_header_bg' ) : ''; ?>
    <section class="header-page" <?php if($img) { ?>style="background-image: url(<?php echo esc_url($img); ?>); background-size: cover;"<?php } ?>>
        <div class="container">
            <h2 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'hosted' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
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
                    <?php // If no content, include the "No posts found" template.
                        else : ?>
                                                       
                            <h2 class="page-title"><?php esc_html_e( 'Nothing Found', 'hosted' ); ?></h2>
                            
                            <article class="page-content">
                                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'hosted' ); ?></p>
                                <div class="widget_search">
                                    <?php get_search_form(); ?>
                                </div>
                            </article><!-- .page-content -->
                    <?php endif; ?>
                    </div>
                    <div class="pagination text-center">
                        <?php echo hosted_pagination(); ?>    
                    </div>
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