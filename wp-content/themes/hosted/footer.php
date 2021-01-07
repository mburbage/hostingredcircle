<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hosted
 */
?>
    <?php 
        if ( is_active_sidebar( 'footer-area-1' )
        || is_active_sidebar( 'footer-area-2' )
        || is_active_sidebar( 'footer-area-3'  )
        || is_active_sidebar( 'footer-area-4' ) ){ 
    ?>
    <footer>
        <div class="container">
            <div class="row">
                <?php get_sidebar('footer');?>
            </div>
        </div>
    </footer>
    <?php } ?>
    <a id="scroll-top"><i class="fa fa-angle-up"></i></a>



<?php wp_footer(); ?>

</body>
</html>
