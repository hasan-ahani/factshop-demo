<?php

$settings = get_post_meta(get_the_ID(),'fs_post_settings');
if(isset($settings) && $settings != null){
    $settings = $settings[0];
}
?>
<article class="col-md-6 col-sm-12 <?php is_sidebar_in_page();?>">
    <div class="post card">
        <?php
        if(isset($settings['is_video']) && ($settings['is_video'] == true)){
            echo '<span class="is_video_post"><i class="fas fa-play-circle"></i>'.cs_get_option('translate-learnvideo','آموزش ویدیویی').'</span>';
        }
        ?>
        <header>
            <a href="<?php the_permalink() ?>">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('loop'); ?>
                <?php else: ?>
                    <img src="<?php echo WF_URI . '/assets/img/nopic.png'; ?>"
                         alt="<?php the_title(); ?>">
                <?php endif; ?>
            </a>
        </header>
        <div class="post-detail">
            <a href="<?php the_permalink() ?>"><h2><?php the_title(); ?></h2></a>
            <p><?php strip_tags(the_excerpt()); ?></p>
            <div class="post-meta">
                <a class="more" href="<?php the_permalink() ?>"><?php echo cs_get_option('translate-morepost','ادامه مطلب');?></a>
                <?php echo get_simple_likes_button(get_the_ID()); ?>
                <?php echo getPostViews(get_the_ID()); ?>
                <a class="comment" href="<?php the_permalink() ?>#comments"><i class="fas fa-comment-dots mr-1"></i><?php echo get_comments_number(); ?></a>
            </div>
        </div>
    </div>
</article>
