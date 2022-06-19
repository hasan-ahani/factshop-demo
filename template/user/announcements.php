<?php
$paged = isset($_GET['pagenum']) ? intval($_GET['pagenum']) : 1;
$number = 10;
if (isset($_GET['view'])) {
    $postid = $_GET['view'];
    $post = get_post($postid);
    if ($post) {
        update_user_meta(get_current_user_id(), 'read_post_' . $postid, true)
        ?>
        <div class="card p-4">
            <h4 class="card-head pt-3 pb-2 pl-3"><?php echo $post->post_title; ?></h4>
            <div class="card-body py-1 px-3 border-top">
                <div class="post-meta-single">
                    <span class="meta-time mr-3"><i class="fas fa-calendar-alt mr-1"></i>تاریخ: <?php echo fsdate('d-m-Y',$post->post_date) ?></span>
                </div>
                <div class="content p-0 pt-4">
                    <?php echo $post->post_content; ?>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="card card-title mb-4">
    <div class="row">
        <div class="col-7 "><h3>آخرین اطلاعیه ها</h3></div>
    </div>
    </div>
    <?php
    $args = array(
        'numberposts' => -1,
        'post_type' => 'notification',
        'posts_per_page' =>  $number,
        'post_status' => array('publish'),
        'paged'          =>  $paged,
        );
    $sep = '';
    $query = new WP_Query($args);
    if ($query->have_posts()) :
        $num = null;
    ?>
        <div class="notification">
            <ul id="last-announcements" >
                <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <li class="<?php get_notification_unread(get_the_ID());?>">
                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>announcements/?view=<?php the_ID(); ?>">
                            <span class="icon-notifi"></span>
                            <h6><?php the_title(); ?></h6>
                            <span class="notification-date"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش';?></span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    <?php else : ?>
        <div class="alert alert-info">
        اطلاعیه ای وجود ندارد
        </div>
    <?php endif; ?>
    <nav class="col-md-12 my-4 p-0">
        <?php
        if ($query->found_posts > $number ){
            $pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    'format' => '',
                    'prev_text' => __( '&laquo;', 'lup' ),
                    'next_text' => __( '&raquo;', 'lup' ),
                    'total' => $query->max_num_pages,
                    'type'         => 'list',
                    'current' => $paged
                )
            ));
            if ( $pagination ) {
                echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">',$pagination);
            }
        }

        ?>
    </nav>
    <?php wp_reset_query(); ?>
<?php }