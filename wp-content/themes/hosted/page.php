<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hosted
 */
get_header(); 

?>

<?php
    $bg = '';
    if ( ! function_exists('rwmb_meta') ) { 
        $bg = '';
    }else{
        $images = rwmb_meta('_cmb_bg_header', "type=image" ); 
        if(!$images){
             $bg = '';
        } else {
             foreach ( $images as $image ) { 
                $bg = $image['full_url']; 
                break;
            }
        }
    }
   
?>

<?php if(hosted_get_option('page_header')) { ?>
<?php 
    $img = hosted_get_option( 'page_header_bg' ) ? hosted_get_option( 'page_header_bg' ) : ''; 
    $img_src = $bg ? $bg : $img; 
?>
<section class="header-page" <?php if($img_src) { ?>style="background-image: url(<?php echo esc_url($img_src); ?>); background-size: cover;"<?php } ?>>
    <div class="container">
        <h2 class="page-title"><?php the_title(); ?></h2>
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
                <div class="page-default">
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_post_thumbnail() ?>
                    <?php the_content(); ?>
                    <?php
                        wp_link_pages( array(
                            'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'hosted' ) . '</span>',
                            'after'       => '</div>',
                            'link_before' => '<span>',
                            'link_after'  => '</span>',
                            'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'hosted' ) . ' </span>%',
                            'separator'   => '<span class="screen-reader-text">, </span>',
                        ) );
                    ?>
                    
                    <?php
                        if ( comments_open() || get_comments_number() ) :
                            comments_template();
                        endif;
                    ?>      
                <?php endwhile; ?>
                </div>

                <div class="text-center">
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
