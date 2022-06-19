<?php
/*
* Template Name: بلاگ
*/
get_header(); ?>

    <section id="main" class="my-4">
        <div class="container">
            <div class="row">
                <div class="<?php if (is_active_sidebar('sidebar-post')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                    <?php remon_breadcrumbs(); ?>
                    <div class="posts row mt-4">
                        <?php
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        $args=array('posts_per_page'=>12, 'paged'=>$paged);
                        $wp_query = new WP_Query( $args );
                        ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="col-md-4">
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
                                                    class="icon-comment-smile"></i><?php echo get_comments_number(); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>

                        <?php endwhile; ?>
                        <nav class="col-md-12">
                            <?php
                            echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">', paginate_links(  array( // WPCS: XSS ok.
                                'prev_text'    => '&rarr;',
                                'next_text'    => '&larr;',
                                'type'         => 'list',
                                'end_size'     => 3,
                                'mid_size'     => 3,
                            ) )  );
                            ?>
                        </nav>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>
                <?php if (is_active_sidebar('sidebar-post')) : ?>
                    <div class="col-md-3 sidbar">
                        <div class="sticky-sidbar">
                            <?php dynamic_sidebar('sidebar-post'); ?>
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>