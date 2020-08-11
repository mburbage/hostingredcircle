<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

    <div class="clearfix"></div>
    <?php if(hosted_get_option('page_header')) { ?>
    <section class="header-page shop-page">
	    <div class="container">
	        <h2 class="page-title"><?php woocommerce_page_title(); ?></h2>
	        <?php if(hosted_get_option('search_header')) { ?>
	        <form role="search" method="get" action="<?php echo home_url( '/' ); ?>">
	            <input type="text" value="" name="s" placeholder="<?php echo esc_html__( 'search...', 'hosted' ); ?>">
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
	<div class="site-content">
		
		<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 */
			do_action( 'woocommerce_before_main_content' );
		?>
		<div class="col-md-9 single-shop">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>
		</div>

			

		<div class="col-md-3">
		<?php
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
		?>
		</div>
		<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
		?>	
	</div>

<?php get_footer( 'shop' ); ?>
