<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hosted
 */

if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area sidebar" role="complementary">
	<?php dynamic_sidebar( 'shop-sidebar' ); ?>
</div><!-- #secondary -->
