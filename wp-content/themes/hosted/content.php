<div <?php post_class(); ?>>
    <div class="post-content">
        <?php if ( has_post_thumbnail() ) { ?>
        <div class="post-image">            
            <a href="<?php the_permalink(); ?>">
                <img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" alt="">
            </a>            
        </div>
        <?php } ?>
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