<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
}

// Extra post classes
$classes = array();
if ($woocommerce_loop['columns'] == 2) {
	$classes[] = 'product-item col-md-6 col-sm-6';
}elseif($woocommerce_loop['columns'] == 4){
	$classes[] = 'product-item col-md-3 col-sm-6';
}elseif($woocommerce_loop['columns'] == 6){
	$classes[] = 'product-item col-md-2 col-sm-6';
}else{
	$classes[] = 'product-item col-md-4 col-sm-6';
}
?>
<div <?php post_class( $classes ); ?>>

	<div class="inner-item">
		<?php
		/**
		 * woocommerce_before_shop_loop_item hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 10
		 */
		do_action( 'woocommerce_before_shop_loop_item' ); 

		?>

		<a href="<?php the_permalink(); ?>">
			<figure>		
		        <?php 
					/**
					 * woocommerce_before_shop_loop_item_title hook.
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
		    </figure> 
	    </a>   

	    <div class="product-detail">
		
			<a href="<?php the_permalink(); ?>" class="title-item">
				<?php 
				/**
				 * woocommerce_shop_loop_item_title hook.
				 *
				 * @hooked woocommerce_template_loop_product_title - 10
				 */
				do_action( 'woocommerce_shop_loop_item_title' );
				?>
			</a>

			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item hook.
			 *
			 * @hooked woocommerce_template_loop_product_link_close - 5
			 * @hooked woocommerce_template_loop_add_to_cart - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
		?>
    	</div>

    </div>

</div>


