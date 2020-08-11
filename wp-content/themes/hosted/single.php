<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hosted
 */
get_header(); ?>

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
    $title   = hosted_get_option('title_single') ? hosted_get_option('title_single') : esc_html__('Single Blog', 'hosted');
?>
<section class="header-page" <?php if($img) { ?>style="background-image: url(<?php echo esc_url($img); ?>); background-size: cover;"<?php } ?>>
    <div class="container">
        <h2 class="page-title"><?php echo esc_html($title); ?></h2>
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

<?php while (have_posts()): the_post(); ?>

<div id="content" class="<?php echo esc_attr( hosted_get_option('post_layout') ); ?>">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-list blog-single">
                    <div class="single-post">
                        <?php                                                     
                            $format = get_post_format();
                            $link_video = get_post_meta(get_the_ID(),'_cmb_link_video', true);
                            $link_audio = get_post_meta(get_the_ID(),'_cmb_link_audio', true);
                        ?>
                        <div class="post-content">
                            <?php if($format == 'video') {  ?>
                                <div class="post-image">
                                    <div class="video-post">
                                        <iframe width="100%" height="315" src="<?php echo esc_url( $link_video ); ?>"></iframe>
                                    </div>
                                </div>
                            <?php }elseif($format == 'audio') { ?>
                                <div class="post-image">
                                    <iframe style="width:100%" height="150" scrolling="no" frameborder="no" src="<?php echo esc_url( $link_audio ); ?>"></iframe>
                                </div>
                            <?php }elseif($format == 'gallery') { ?>
                                <div class="post-image">
                                    <div class="owl-carousel owl-theme blog-slide">
                                    <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                                        <?php $images = rwmb_meta( '_cmb_images', "type=image" ); ?>
                                        <?php if($images){ ?>              
                                            <?php  foreach ( $images as $image ) {  ?>
                                                <?php $img = $image['full_url']; ?>
                                                <div class="item"><img src="<?php echo esc_url($img); ?>" alt=""></div>
                                            <?php } ?>                

                                        <?php } ?>
                                    <?php } ?>
                                    </div>
                                </div>
                            <?php }elseif($format == 'image') { ?>
                                <div class="post-image">
                                    <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                                        <?php $images = rwmb_meta( '_cmb_image', "type=image" ); ?>
                                        <?php if($images){ ?>              
                                            <?php  foreach ( $images as $image ) {  ?>
                                                <?php $img = $image['full_url']; ?>
                                                <img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
                                            <?php } ?>                
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <div class="post-text">
                                <div class="post-meta">
                                    <span class="post-date"><?php echo esc_html__("Posted on","hosted"); ?> <?php the_time( get_option( 'date_format' ) ) ?></span>
                                    <span class="post-author"> <?php echo esc_html__("by","hosted"); ?> <?php the_author_posts_link(); ?></span>
                                    <span class="post-cate"><?php echo esc_html__("under","hosted"); ?> <?php the_category(', '); ?></span>
                                </div>
                                <h4><?php the_title(); ?></h4>
                                <?php the_content(); ?>
                                <?php if(has_tag()) { ?>
                                    <div class="list-tag"><?php echo esc_html__("Tags: ","hosted"); ?> <?php the_tags('', ', ' ); ?></div>
                                <?php } ?>
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
                            </div>

                        </div>
                    </div>
                    
                </div>

                <div class="comment-area">
                <?php
                   if ( comments_open() || get_comments_number() ) :
                    comments_template();
                   endif;
                ?>
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

<?php endwhile; ?>

<?php get_footer(); ?>