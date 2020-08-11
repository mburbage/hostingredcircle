<?php
/*
 * Template Name: Canvas
 * Description: A Page Template with a Page Builder design.
 */
get_header(); ?>

<?php if (have_posts()){ ?>
	
		<?php while (have_posts()) : the_post()?>
			<?php the_content(); ?>
		<?php endwhile; ?>
	
	<?php }else {
		esc_html_e('Page Canvas For Page Builder', 'hosted'); 
	}?>

<?php get_footer(); ?>