<?php get_header(); ?>

    <section id="main" class="my-4">
        <div class="container">
            <div class="row">
                <div class="<?php if (is_active_sidebar('sidebar-archive')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                    <?php remon_breadcrumbs(); ?>
                    <div class="posts row mt-4">
                        <?php
                        $num = (get_col_loop_archive(true) == true) ? 9 : 12;
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
                        query_posts("&showposts={$num}&paged={$paged}");
                        if(have_posts()):
                        ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php

                            $settings = get_post_meta(get_the_ID(), 'fs_post_settings');
                            if (isset($settings) && $settings != null) {
                                $settings = $settings[0];
                            }
                            ?>
                            <article class="col-md-6 col-sm-12 <?php get_col_loop_archive(); ?>">
                                <div class="post card">
                                    <?php
                                    if (isset($settings['is_video']) && ($settings['is_video'] == true)) {
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
                                            <a class="more" href="<?php the_permalink() ?>"><?php echo cs_get_option('translate-morepost','ادامه مطلب'); ?></a>
                                            <?php echo get_simple_likes_button(get_the_ID()); ?>
                                            <?php echo getPostViews(get_the_ID()); ?>
                                            <a class="comment" href="<?php the_permalink() ?>#comments"><i
                                                        class="fas fa-comment-dots mr-1"></i><?php echo get_comments_number(); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        <?php
                        endwhile;
                        else:
                        ?>
                            <div class="col-md-12">
                                <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost','مطلبی وجود ندارد');?></div>
                            </div>
                        <?php
                        endif;
                        ?>
                        <nav class="col-md-12">
                            <?php
                            echo str_replace("<ul class='page-numbers'>", '<ul class="pagination">', paginate_links(apply_filters('woocommerce_pagination_args', array( // WPCS: XSS ok.
                                'prev_text' => '&rarr;',
                                'next_text' => '&larr;',
                                'type' => 'list',
                                'end_size' => 3,
                                'mid_size' => 3,
                            ))));
                            ?>
                        </nav>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
                <?php if (is_active_sidebar('sidebar-archive')) : ?>
                    <div class="col-md-3 sidbar">
                        <div class="sticky-sidbar">
                            <?php dynamic_sidebar('sidebar-archive'); ?>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>