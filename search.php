<?php get_header(); ?>

    <section id="main" class="my-4">
        <div class="container">
            <div class="row">
                <?php
                $post_type = array();
                $gettype = cs_get_option('search_query_page');
                if($gettype == 'all') $post_type[] = 'post'; $post_type[] = 'product';
                if($gettype == 'post') $post_type[] = 'post';
                if($gettype == 'product') $post_type[] = 'product';
                $s = get_search_query();
                $num = (get_col_loop_archive(true) == true) ? 9 : 12;
                $paged = (get_query_var('page_val') ? get_query_var('page_val') : 1);
                $args = array(
                    's' => $s,
                    'post_type' => $post_type,
                    'posts_per_page' => $num,
                    'orderby' => 'date',
                    'paged' => $paged,
                    'order' => 'DESC'
                );
                $the_query = new WP_Query($args);
                if ($gettype == 'all' or $gettype == 'post'):
                    ?>
                    <div class="<?php if (is_active_sidebar('sidebar-archive')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-12"><h3>نتایج جستجو "<?php echo get_search_query() ?>" در سایت</h3></div>
                            </div>
                        </div>
                        <div class="posts row mt-4">
                            <?php
                            if ($the_query->have_posts()):

                                while ($the_query->have_posts()) : $the_query->the_post();
                                    ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_archive(); ?>">
                                        <div class="post card">
                                            <?php
                                            if (isset($settings['is_video']) && ($settings['is_video'] == true)) {
                                                echo '<span class="is_video_post"><i class="fas fa-play-circle"></i>' . cs_get_option('translate-learnvideo', 'آموزش ویدیویی') . '</span>';
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
                                                    <a class="more"
                                                       href="<?php the_permalink() ?>"><?php echo cs_get_option('translate-morepost', 'ادامه مطلب'); ?></a>
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
                                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost', 'مطلبی وجود ندارد'); ?></div>
                                </div>
                            <?php
                            endif;
                            ?>
                            <nav class="col-md-12">
                                <?php
                                $big = 999999999;
                                echo str_replace("<ul class='page-numbers'>", '<ul class="pagination">', paginate_links(apply_filters('woocommerce_pagination_args', array( // WPCS: XSS ok.
                                    'prev_text' => '&rarr;',
                                    'next_text' => '&larr;',
                                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                    'format' => '/page/%#%',
                                    'current' => max(1, $paged),
                                    'type' => 'list',
                                    'show_all' => true,
                                    'total' => $the_query->max_num_pages
                                ))));
                                ?>
                            </nav>
                            <?php wp_reset_query(); ?>
                        </div>
                    </div>
                <?php
                else:?>
                <div class="<?php if (is_active_sidebar('sidebar-archive')) : ?>col-md-9 <?php else: ?>col-md-12<?php endif; ?>">
                    <div class="card card-title mb-4">
                        <div class="row">
                            <div class="col-12"><h3>نتایج جستجو "<?php echo get_search_query() ?>" در فروشگاه</h3></div>
                        </div>
                    </div>
                    <div class="products row">
                        <?php
                        if ($the_query->have_posts()):
                            while ($the_query->have_posts()) : $the_query->the_post();
                                global $product; ?>
                                <article class="col-md-6 col-sm-12 <?php get_col_loop_archive(); ?>">
                                    <div class="post product card">
                                        <header>
                                            <a href="<?php echo get_permalink($the_query->post->ID) ?>"
                                               title="<?php echo esc_attr($the_query->post->post_title ? $the_query->post->post_title : $the_query->post->ID); ?>">
                                                <?php if (has_post_thumbnail($the_query->post->ID)) echo get_the_post_thumbnail($the_query->post->ID, 'loop'); else echo '<img src="' . WF_URI . '/assets/img/nopic.png"'; ?>

                                            </a>
                                        </header>

                                        <div class="post-detail">
                                            <a href="<?php echo get_permalink($the_query->post->ID) ?>"><h2><?php the_title(); ?></h2></a>
                                            <b class="price"><?php echo $product->get_price_html(); ?></b>
                                            <?php if (cs_get_option('show-product-sales')): ?>
                                                    <b class="sales"><?php echo get_post_meta( $post->ID, 'total_sales', true ); ?> <?php echo cs_get_option('translate-sale','فروش');?> </b>
                                            <?php endif; ?>
                                            <div class="post-meta">
                                                <?php
                                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                                    sprintf( '<a href="%s" data-quantity="%s" class="tocart" %s>%s</a>',
                                                        esc_url( $product->add_to_cart_url() ),
                                                        esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
                                                        isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
                                                        cs_get_option('translate-addtocart','افزود به سبد خرید')
                                                    ),
                                                    $product, $args );
                                                ?>
                                                <a  class="user" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                                            </div>
                                            <?php $previewonline =   get_post_meta($the_query->post->ID, 'previewonline', true);
                                            if(isset($previewonline) &&  $previewonline != ''):?>
                                                <a href="<?php echo $previewonline;?>" target="_blank" class="product-show"><?php echo cs_get_option('translate-preview','پیشنمایش آنلاین');?></a>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="col-md-12">
                                <div class="card p-3 mb-4"><?php echo cs_get_option('translate-noproduct','محصولی وجود ندارد');?></div>
                            </div>
                        <?php endif; ?>
                        <nav class="col-md-12">
                            <?php
                            $big = 999999999;
                            echo str_replace("<ul class='page-numbers'>", '<ul class="pagination">', paginate_links(apply_filters('woocommerce_pagination_args', array( // WPCS: XSS ok.
                                'prev_text' => '&rarr;',
                                'next_text' => '&larr;',
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '/page/%#%',
                                'current' => max(1, $paged),
                                'type' => 'list',
                                'show_all' => true,
                                'total' => $query->max_num_pages
                            ))));
                            ?>
                        </nav>
                        <?php wp_reset_query(); ?>
                    </div>
                </div>

                <?php
                endif;?>

                <?php
                if (is_active_sidebar('sidebar-archive')) : ?>
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