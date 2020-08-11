<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hosted
 */

get_header(); ?>
  
  <section class="no-padding bg-error">
    <div class="container">
      <div class="warp-404">
        <div class="warp-404-inner">
          <?php $top_img = hosted_get_option( 'top_img' ) ? hosted_get_option( 'top_img' ) : get_template_directory_uri().'/images/404.png'; ?>
          <img src="<?php echo esc_url($top_img); ?>" alt="">
          <h3 class="id-color"><?php esc_html_e('404','hosted'); ?></h3>
          <h2><?php esc_html_e('Page Not Found','hosted'); ?></h2>
          <span><?php esc_html_e('The page you have requested cannot be found.','hosted'); ?></span>
          <p><?php wp_kses( _e('Maybe the page was moved or deleted, or perhaps you just mistyped the address.<br> Why not to try and find your way using the navigation bar above or click on the logo to return to our  home page.','hosted'), wp_kses_allowed_html('post') ); ?></p>
        </div>
      </div>
    </div>
  </section>
	
<?php get_footer(); ?>
