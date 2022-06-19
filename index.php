<?php
get_header();
?>

    <section id="main" class="my-4">
        <div class="container">
            <div class="row closet_sibar">
                <div class="col-md-12"><?php get_ad('home', 1);?></div>
                <div class="<?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>col-md-8 col-sm-12 col-lg-9 col-xl-9 <?php else:?>col-md-12<?php endif; ?>">
                    <?php  get_slider_position('home');?>
                    <?php get_ad('home', 2);?>
                    <?php if (cs_get_option("show-home-product1")): ?>
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-7 "><h3><?php echo cs_get_option('subject-home-product1');?></h3></div>
                                <div class="col-5"><a href="<?php echo cs_get_option('link-home-product1');  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i> </a></div>
                            </div>
                        </div>
                        <div class="products row">
                            <?php $cat = (cs_get_option('category-home-product1') != null) ? cs_get_option('category-home-product1') : -1;?>
                            <?php $num= (cs_get_option('number-home-product1') != null) ? cs_get_option('number-home-product1') : '6';?>
                            <?php
                            if($cat == '-1'){
                                $args = array('post_type' => 'product', 'posts_per_page' => $num, 'terms' => '42', 'orderby' => 'time');
                            }else{
                                $args = array('post_type' => 'product', 'posts_per_page' => $num, 'terms' => '42', 'orderby' => 'time',
                                    'tax_query'     => array(
                                        array(
                                            'taxonomy'  => 'product_cat',
                                            'field'     => 'id',
                                            'terms'     => $cat
                                        )
                                    )
                                );
                            }

                            $loop = new WP_Query($args);
                            if($loop->have_posts()):
                                while ($loop->have_posts()) : $loop->the_post();
                                    global $product; ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
                                        <div class="post product card">
                                            <header>
                                                <a href="<?php echo get_permalink($loop->post->ID) ?>"
                                                   title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                                    <?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'loop'); else echo '<img src="' . WF_URI . '/assets/img/nopic.png"'; ?>

                                                </a>
                                            </header>

                                            <div class="post-detail">
                                                <a href="<?php echo get_permalink($loop->post->ID) ?>"><h2><?php the_title(); ?></h2></a>
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
                                                <?php $previewonline =   get_post_meta($loop->post->ID, 'previewonline', true);
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
                            <?php wp_reset_query(); ?>
                        </div>
                    <?php endif; ?>
                    <?php get_ad('home', 3);?>
                    <?php if (cs_get_option("show-home-post1")): ?>
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-7"><h3><?php echo cs_get_option("subject-home-post1");?></h3></div>
                                <div class="col-5 "><a href="<?php echo cs_get_option("link-home-post1");  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i></a></div>
                            </div>
                        </div>
                        <div class="posts row">
                            <?php $cat = (cs_get_option("category-home-post1") == '-1' or cs_get_option('category-home-post1') == null) ? null : '&cat='.cs_get_option('category-home-post1');?>
                            <?php $num= (cs_get_option('number-home-post1') != null) ? '&showposts='.cs_get_option('number-home-post1') : '&showposts=6';?>
                            <?php query_posts($num.$cat); ?>
                            <?php if(have_posts()):?>
                                <?php while (have_posts()) : the_post();
                                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                                    if(isset($settings) && $settings != null){
                                        $settings = $settings[0];
                                    }
                                    ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
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
                                <?php
                                endwhile; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost','مطلبی وجود ندارد');?></div>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    <?php endif; ?>
                    <?php get_ad('home', 4);?>
                    <?php if (cs_get_option("show-home-post2")): ?>
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-7"><h3><?php echo cs_get_option("subject-home-post2");?></h3></div>
                                <div class="col-5 "><a href="<?php echo cs_get_option("link-home-post2");  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i></a></div>
                            </div>
                        </div>
                        <div class="posts row">
                            <?php $cat = (cs_get_option("category-home-post2") == '-1' or cs_get_option('category-home-post2') == null) ? null : '&cat='.cs_get_option('category-home-post2');?>
                            <?php $num= (cs_get_option('number-home-post2') != null) ? '&showposts='.cs_get_option('number-home-post2') : '&showposts=6';?>
                            <?php query_posts($num.$cat); ?>
                            <?php if(have_posts()):?>
                                <?php while (have_posts()) : the_post();
                                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                                    if(isset($settings) && $settings != null){
                                        $settings = $settings[0];
                                    }
                                    ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
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
                                <?php
                                endwhile; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost','مطلبی وجود ندارد');?></div>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    <?php endif; ?>
                    <?php get_ad('home', 5);?>
                    <?php if (cs_get_option("show-home-post3")): ?>
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-7"><h3><?php echo cs_get_option("subject-home-post3");?></h3></div>
                                <div class="col-5 "><a href="<?php echo cs_get_option("link-home-post3");  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i></a></div>
                            </div>
                        </div>
                        <div class="posts row">
                            <?php $cat = (cs_get_option("category-home-post3") == '-1' or cs_get_option('category-home-post3') == null) ? null : '&cat='.cs_get_option('category-home-post3');?>
                            <?php $num= (cs_get_option('number-home-post3') != null) ? '&showposts='.cs_get_option('number-home-post3') : '&showposts=6';?>
                            <?php query_posts($num.$cat); ?>
                            <?php if(have_posts()):?>
                                <?php while (have_posts()) : the_post();
                                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                                    if(isset($settings) && $settings != null){
                                        $settings = $settings[0];
                                    }
                                    ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
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
                                <?php
                                endwhile; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost','مطلبی وجود ندارد');?></div>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    <?php endif; ?>
                    <?php get_ad('home', 6);?>
                    <?php if (cs_get_option("show-home-post4")): ?>
                        <div class="card card-title mb-4">
                            <div class="row">
                                <div class="col-7"><h3><?php echo cs_get_option("subject-home-post4");?></h3></div>
                                <div class="col-5 "><a href="<?php echo cs_get_option("link-home-post4");  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i></a></div>
                            </div>
                        </div>
                        <div class="posts row">
                            <?php $cat = (cs_get_option("category-home-post4") == '-1' or cs_get_option('category-home-post4') == null) ? null : '&cat='.cs_get_option('category-home-post4');?>
                            <?php $num= (cs_get_option('number-home-post4') != null) ? '&showposts='.cs_get_option('number-home-post4') : '&showposts=6';?>
                            <?php query_posts($num.$cat); ?>
                            <?php if(have_posts()):?>
                                <?php while (have_posts()) : the_post();
                                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                                    if(isset($settings) && $settings != null){
                                        $settings = $settings[0];
                                    }
                                    ?>
                                    <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
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
                                <?php
                                endwhile; ?>
                            <?php else: ?>
                                <div class="col-md-12">
                                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-nopost','مطلبی وجود ندارد');?></div>
                                </div>
                            <?php endif; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    <?php endif; ?>
                    <?php get_ad('home', 7);?>
                    <?php
                    for($i = 2; $i <= 8; $i++):
                        if (cs_get_option("show-home-product{$i}")): ?>
                            <div class="card card-title mb-4">
                                <div class="row">
                                    <div class="col-7 "><h3><?php echo cs_get_option("subject-home-product{$i}");?></h3></div>
                                    <div class="col-5"><a href="<?php echo cs_get_option("link-home-product{$i}");  ?>"><?php echo cs_get_option('translate-moresubjects','عناوین بیشتر');?><i class="icon-chevron-left"></i> </a></div>
                                </div>
                            </div>
                            <div class="products row">
                                <?php $cat = (cs_get_option("category-home-product{$i}") != null) ? cs_get_option("category-home-product{$i}") : -1;?>
                                <?php $num= (cs_get_option("number-home-product{$i}") != null) ? cs_get_option("number-home-product{$i}") : '6';?>
                                <?php
                                if($cat == '-1'){
                                    $args = array('post_type' => 'product', 'posts_per_page' => $num, 'terms' => '42', 'orderby' => 'time');
                                }else{
                                    $args = array('post_type' => 'product', 'posts_per_page' => $num, 'terms' => '42', 'orderby' => 'time',
                                        'tax_query'     => array(
                                            array(
                                                'taxonomy'  => 'product_cat',
                                                'field'     => 'id',
                                                'terms'     => $cat
                                            )
                                        )
                                    );
                                }

                                $loop = new WP_Query($args);
                                if($loop->have_posts()):
                                    while ($loop->have_posts()) : $loop->the_post();
                                        global $product; ?>
                                        <article class="col-md-6 col-sm-12 <?php get_col_loop_home();?>">
                                            <div class="post product card">
                                                <header>
                                                    <a href="<?php echo get_permalink($loop->post->ID) ?>"
                                                       title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                                                        <?php if (has_post_thumbnail($loop->post->ID)) echo get_the_post_thumbnail($loop->post->ID, 'loop'); else echo '<img src="' . WF_URI . '/assets/img/nopic.png"'; ?>

                                                    </a>
                                                </header>

                                                <div class="post-detail">
                                                    <a href="<?php echo get_permalink($loop->post->ID) ?>"><h2><?php the_title(); ?></h2></a>
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
                                                            $product, $args );?>
                                                        <a  class="user" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ), get_the_author_meta( 'user_nicename' ) ); ?>"><?php the_author(); ?></a>
                                                    </div>
                                                    <?php $previewonline =   get_post_meta($loop->post->ID, 'previewonline', true);
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
                                <?php wp_reset_query(); ?>
                            </div>
                        <?php endif;
                    endfor;
                    ?>

                </div>
                <?php if ( is_active_sidebar( 'sidebar-main' ) ) : ?>
                    <div class="col-md-4  col-sm-12 col-lg-3 col-xl-3 sidbar">
                        <div class="sticky-sidbar">
                            <?php dynamic_sidebar( 'sidebar-main' ); ?>
                        </div>

                    </div>
                <?php endif; ?>
            </div>
            <div class="row"><div class="col-md-12"><?php get_ad('home', 8);?></div></div>
        </div>
    </section>
<?php get_footer();
