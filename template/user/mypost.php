<?php
$paged = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;
global $current_user;
$number = 12;
$args = array(
    'author'         =>  $current_user->ID,
    'orderby'        =>  'post_date',
    'post'        =>  'post_date',
    'posts_per_page' =>  $number,
    'post_status' => array('publish', 'draft',  'trash'),
    'paged'          =>  $paged,
);
global $wp_query;

$query = new WP_Query($args); ?>
<div class="card over-hidden">
    <table class="table mb-0">
        <thead class="bg-primary text-light text-center">
        <tr>
            <th>#</th>
            <th class="text-right">عنوان</th>
            <th>تاریخ انتشار</th>
            <th>تعداد بازدید</th>
            <th>وضعیت</th>

        </tr>
        </thead>
        <?php
        if($query->have_posts()):
        while ($query->have_posts()) : $query->the_post(); ?>
            <tr class="text-center">
                <td><?php echo get_the_ID(); ?></td>
                <td class="text-right"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
                <td><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'; ?></td>
                <td><?php echo strip_tags(getPostViews(get_the_ID())); ?></td>
                <td>
                    <?php
                    switch (get_post_status()){
                        case 'publish':
                            echo '<b class="text-success">منتشر شده</b>';
                            break;
                        case 'draft':
                            echo '<b class="text-warning">در دست بررسی</b>';
                            break;
                        case 'trash':
                            echo '<b class="text-danger">تایید نشده</b>';
                            break;
                    }
                    ?>
                </td>
            </tr>
        <?php endwhile;

        else:?>
        <tr>شما هنوز هیچ پست ارسال نکرده اید.</tr>
        <?php endif;?>
    </table>
</div>
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
<?php wp_reset_query();
