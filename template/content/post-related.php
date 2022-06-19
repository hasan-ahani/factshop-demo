<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );
if (cs_get_option('show-post-related')):
    $orig_post = $post;
    global $post;
    $num = (is_sidebar_in_page(true) == true) ? 3 : 4;
    $args = array(
        'posts_per_page' => $num, // How many items to display
        'post__not_in'   => array( get_the_ID() ), // Exclude current post
        'no_found_rows'  => true, // We don't ned pagination so this speeds up the query
    );
    $cats = wp_get_post_terms( get_the_ID(), 'category' );
    $cats_ids = array();
    foreach( $cats as $wpex_related_cat ) {
        $cats_ids[] = $wpex_related_cat->term_id;
    }
    if ( ! empty( $cats_ids ) ) {
        $args['category__in'] = $cats_ids;
        $my_query = new wp_query($args);
        if ($my_query->have_posts()) {
            ?>
            <div class="card card-title my-4">
                <div class="row">
                    <div class="col-7 col-md-9">
                        <h3><?php echo cs_get_option('translate-relatedpost','مطالب مرتبط');?></h3></div>
                </div>
            </div>
            <div class="posts row">
                <?php while ($my_query->have_posts()) {
                    $my_query->the_post();
                    get_template_part('template/content/post-loop');
                } ?>
            </div>

            <?php
        }
        $post = $orig_post;
        wp_reset_query(); ?>

    <?php
    }

endif;