<div <?php post_class(); ?>>
    <div class="post-content">
        <div class="post-image">
            <a href="<?php the_permalink(); ?>">
            <?php if( function_exists( 'rwmb_meta' ) ) { ?>
                <?php $images = rwmb_meta( '_cmb_image', "type=image" ); ?>
                <?php if($images){ ?>              
                    <?php  foreach ( $images as $image ) {  ?>
                        <?php $img = $image['full_url']; ?>
                        <img src="<?php echo esc_url($img); ?>" class="img-responsive" alt="">
                    <?php } ?>                
                <?php } ?>
            <?php } ?>
            </a>
        </div>
        <div class="post-text">
            <div class="post-meta">
                <span class="post-date"><?php echo esc_html__("Posted on","hosted"); ?> <?php the_time( get_option( 'date_format' ) ) ?></span>
                <span class="post-author"> <?php echo esc_html__("by","hosted"); ?> <?php the_author_posts_link(); ?></span>
                <span class="post-cate"><?php echo esc_html__("under","hosted"); ?> <?php the_category(', '); ?></span>
            </div>
            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>            
            <p><?php echo hosted_excerpt_length(); ?></p>
            <?php $rm   = hosted_get_option('read_more') ? hosted_get_option('read_more') : esc_html__('Read the rest', 'hosted'); ?>
            <div class="rm-btn"><a href="<?php the_permalink(); ?>"><?php echo esc_html($rm); ?></a></div>
        </div>
    </div>
</div>