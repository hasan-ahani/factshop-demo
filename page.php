<?php get_header(); ?>
    <section id="main" class="my-4">
        <div class="container">
            <?php if (is_account_page() or class_exists('Dokan_Core') && dokan_is_seller_dashboard()): ?>
                <?php
                while (have_posts()) :
                    the_post();

                    the_content();

                endwhile; // End of the loop.
                ?>
            <?php elseif (is_shop() or is_product_taxonomy()): ?>
                <div class="row shop-active">
                    <div class="<?php if (is_active_sidebar('sidebar-shop')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                        <?php
                        while (have_posts()) :
                            the_post();
                            the_content();
                            ?>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php if (is_active_sidebar('sidebar-shop')) : ?>
                    <div class="col-md-3 sidbar">
                        <div class="sticky-sidbar">
                            <?php dynamic_sidebar('sidebar-shop'); ?>
                        </div>
                    </div>

                <?php endif; ?>
            <?php elseif (is_cart() or is_checkout()): ?>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    while (have_posts()) :
                    the_post();

                    ?>
                    <div class="card post-body mt-4">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <div class="content"><?php the_content(); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
        <?php elseif (is_page()): ?>
        <div class="row">
            <div class="<?php if (is_active_sidebar('sidebar-page')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                <?php get_ad('page', 1); ?>
                <?php remon_breadcrumbs(); ?>
                <?php get_ad('page', 2); ?>
                <?php get_slider_position('page'); ?>
                <?php get_ad('page', 3); ?>
                <?php
                while (have_posts()) :
                    the_post();

                    ?>

                    <?php if (has_post_thumbnail()): ?>
                    <div class="card post-image mb-4">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                <?php endif; ?>
                    <?php get_ad('page', 4); ?>
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
                        <div class="content"><?php the_content(); ?></div>
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
                    <?php get_ad('page', 5); ?>

                    <?php if (comments_open() || get_comments_number()) {
                    comments_template();
                } ?>
                <?php endwhile; ?>
                <?php get_ad('page', 6); ?>
            </div>
            <?php if (is_active_sidebar('sidebar-page')) : ?>
                <div class="col-md-3 sidbar">
                    <div class="sticky-sidbar">
                        <?php dynamic_sidebar('sidebar-page'); ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>
<?php get_footer(); ?>