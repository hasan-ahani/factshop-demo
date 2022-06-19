<div class="row">
    <div class="<?php if (is_active_sidebar('sidebar-post')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
        <?php get_ad('single', 1); ?>
        <?php remon_breadcrumbs(); ?>
        <?php get_ad('single', 2); ?>
        <?php get_slider_position('single'); ?>
        <?php get_ad('single', 3); ?>
        <?php
        while (have_posts()) :
            the_post();
            $settings = get_post_meta(get_the_ID(), 'fs_post_settings');
            if (isset($settings) && $settings != null) {
                $settings = $settings[0];
            }
            if(isset($settings['is_video']) && !empty($settings['video-link'])):
            ?>
            <div class="card post-image mb-4 " style="height: auto;">
                <video id="player" controls  poster="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'single-crouse');?>" controls>
                    <source src="<?php echo $settings['video-link'] ;?>" type="video/mp4">
                </video>
            </div>
            <?php
            elseif (isset($settings['show-pic']) && $settings['align'] == 'center' && has_post_thumbnail()):?>
                    <div class="card post-image mb-4">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php
            endif;
            ?>

            <div id="<?php the_ID(); ?>" class="card post-body mb-4">
                <?php if (cs_get_option('show-post-share')): ?>
                    <div class="share-block d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <ul class="share-menu list-unstyled">
                            <li>
                                <a href="https://telegram.me/share/url?url=<?php echo wp_get_shortlink(); ?> "><i
                                            class="icon-telegram"></i></a></li>
                            <li>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_get_shortlink(); ?> "><i
                                            class="icon-facebook"></i></a></li>
                            <li>
                                <a href="https://plus.google.com/share?url=<?php echo wp_get_shortlink(); ?> "><i
                                            class="icon-google"></i></a></li>
                            <li><a href="http://twitter.com/home?status=<?php echo wp_get_shortlink(); ?> "><i
                                            class="icon-twitter"></i></a></li>
                        </ul>
                    </div>
                <?php endif; ?>
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta single">
                    <?php if (cs_get_option('show-post-meta-cat')): ?>
                        <span class="category-meta mr-3">
                        <i class="fa fa-list-ul mr-1"></i><?php echo cs_get_option('translate-pcategory','دسته بندی ها:'); ?>
                            <?php
                            $categories = get_the_terms(get_the_ID(), 'category');
                            $i = 0;
                            foreach ($categories as $category) {
                                echo '<a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a>';
                                echo (++$i === count($categories)) ? '' : ',';
                            }
                            ?>
                    </span>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-post-meta-date')): ?>
                        <span class="meta-time mr-3"><i
                                    class="fas fa-calendar-alt mr-1"></i><?php echo cs_get_option('translate-createdate','تاریخ:'); ?><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'; ?>
                    </span>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-post-meta-author')): ?>
                        <span class="user_link mr-3"><i class="fas fa-user-tie mr-1"></i>نویسنده: <a
                                    href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"
                                    class="meta-user"> <?php the_author(); ?></a></span>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-post-meta-views')): ?>
                        <span class="view-chart mr-3"><i
                                    class="fas fa-chart-area mr-1"></i><?php echo cs_get_option('translate-countview','تعداد بازدید:'); ?> <?php echo getPostViews(get_the_ID(), false, true); ?></span>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-post-meta-comments')): ?>
                        <span class="comment_count mr-3"><i
                                    class="fas fa-comment-dots mr-1"></i><?php echo cs_get_option('translate-countcomment','تعداد دیدگاه ها:'); ?> <?php echo get_comments_number(); ?></span>
                    <?php endif; ?>
                    <?php if (cs_get_option('show-post-like')): ?>
                        <?php echo get_simple_likes_button(get_the_ID()); ?>
                    <?php endif; ?>
                </div>
                <div class="content">
                    <?php
                    $response = '';
                    if (isset($settings['show-pic']) && ($settings['show-pic'] == true)) {
                        if (isset($settings['align']) && ($settings['align'] == 'right') && has_post_thumbnail()) {
                            the_post_thumbnail('single-post', array('class' => 'float-right rounded mt-4 mr-3 mb-2'));
                        } elseif (isset($settings['align']) && ($settings['align'] == 'left') && has_post_thumbnail()) {
                            the_post_thumbnail('single-post', array('class' => 'float-left rounded mt-4 ml-3 mb-2'));
                        } elseif (!isset($settings['align']) && has_post_thumbnail()) {
                            the_post_thumbnail('single-post', array('class' => 'float-left rounded mt-4 ml-3 mb-2'));
                        }
                    }
                    the_content();
                    ?>
                </div>

                <?php if (cs_get_option('show-post-share')): ?>
                    <ul class="share-menu share-mobile list-unstyled d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <li>
                            <a href="https://telegram.me/share/url?url=<?php echo wp_get_shortlink(); ?> "><i
                                        class="icon-telegram"></i></a></li>
                        <li>
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo wp_get_shortlink(); ?> "><i
                                        class="icon-facebook"></i></a></li>
                        <li>
                            <a href="https://plus.google.com/share?url=<?php echo wp_get_shortlink(); ?> "><i
                                        class="icon-google"></i></a></li>
                        <li><a href="http://twitter.com/home?status=<?php echo wp_get_shortlink(); ?> "><i
                                        class="icon-twitter"></i></a></li>
                    </ul>
                <?php endif; ?>
                <div class="post-meta single footer-post <?php echo (cs_get_option('show-post-shortlink')) ? null : 'd-none'; ?>">
                    <?php if (cs_get_option('show-post-shortlink')): ?>
                        <div class="link-post-group float-left d-flex mt-1 mt-md-0 mt-lg-0 mt-xl-0">
                            <div class="link-post-label">لینک کوتاه:</div>
                            <div class="link-post">
                                <input id="input-post-link" type="text" class="form-control" readonly="readonly"
                                       value="<?php echo wp_get_shortlink(); ?> "/>
                                <i id="btn-copy-link" class="icon-copy"></i>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (cs_get_option('show-post-tags') && get_the_tag_list()): ?>
                <div class="card p-3 mb-4">
                    <?php echo get_the_tag_list('<ul class="tag-list-large list-unstyled"><li><i class="fas fa-tags"></i></li><li>', '</li><li>', '</li></ul>'); ?>
                </div>
            <?php endif; ?>
            <?php get_ad('single', 4); ?>
            <?php get_download_box($post->ID); ?>
            <?php get_ad('single', 5); ?>
            <?php if (cs_get_option('show-post-bio')): ?>
            <?php if (!empty(get_the_author_meta('description'))): ?>
            <div class="card user-bio mb-4">
                <div class="row">
                    <div class="col-md-12">
                        <?php if (function_exists('get_avatar')) {
                            echo get_avatar(get_the_author_meta('email'), '100');
                        } ?>
                        <ul class="social-menu list-unstyled list-inline m-0">
                            <?php if (get_the_author_meta('telegram')): ?>
                                <li><a href="<?php echo get_the_author_meta('telegram'); ?>"><i
                                                class="icon-telegram"></i></a></li>
                            <?php endif; ?>
                            <?php if (get_the_author_meta('instagram')): ?>
                                <li><a href="<?php echo get_the_author_meta('instagram'); ?>"><i
                                                class="icon-instagram"></i></a></li>
                            <?php endif; ?>
                            <?php if (get_the_author_meta('facebook')): ?>
                                <li><a href="<?php echo get_the_author_meta('facebook'); ?>"><i
                                                class="icon-facebook"></i></a></li>
                            <?php endif; ?>
                            <?php if (get_the_author_meta('google+')): ?>
                                <li><a href="<?php echo get_the_author_meta('google+'); ?>"><i class="icon-google"></i></a>
                                </li>
                            <?php endif; ?>
                            <?php if (get_the_author_meta('twitter')): ?>
                                <li><a href="<?php echo get_the_author_meta('twitter'); ?>"><i class="icon-twitter"></i></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <label><a href=" <?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author_meta('display_name'); ?></a></label>
                        <p><?php the_author_meta('description') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php endif; ?>
            <?php get_ad('single', 6); ?>
            <?php
            if(cs_get_option('show-post-related_before_comment')) get_template_part('template/content/post-related');
            if (comments_open() || get_comments_number()) {
                comments_template();
            } ?>
            <?php get_ad('single', 7);
                if(!cs_get_option('show-post-related_before_comment')) get_template_part('template/content/post-related');
            endwhile; ?>

        <?php get_ad('single', 8); ?>
    </div>
    <?php if (is_active_sidebar('sidebar-post')) : ?>
        <div class="col-md-3 sidbar">
            <div class="sticky-sidbar">
                <?php dynamic_sidebar('sidebar-post'); ?>
            </div>
        </div>

    <?php endif; ?>
</div>