<?php
/**
 * Template Name: FullWidth
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
    
<?php while (have_posts()) : the_post(); ?>

    <?php the_content(); ?>

<?php endwhile; ?>

<?php get_footer(); ?>