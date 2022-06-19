<?php
$paged = isset( $_GET['pagenum'] ) ? intval( $_GET['pagenum'] ) : 1;
$number = 10;
?>
<nav class="navbar navbar-expand-sm navbar-light user-nav bg-white  mb-4 rounded">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php echo (!isset($_GET['tab'])) ? 'active' : ''; ?>">
                <a class="nav-link"
                   href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')) . 'favorites'; ?>">مطالب </a>
            </li>
            <li class="nav-item <?php echo (isset($_GET['tab']) && ($_GET['tab'] == 'products')) ? 'active' : ''; ?>">
                <a class="nav-link"
                   href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')) . 'favorites/?tab=products'; ?>">محصولات</a>
            </li>
            <li class="nav-item <?php echo (isset($_GET['tab']) && ($_GET['tab'] == 'comments')) ? 'active' : ''; ?>">
                <a class="nav-link"
                   href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')) . 'favorites/?tab=comments'; ?>">دیدگاه
                    ها</a>
            </li>
        </ul>
    </div>
</nav>
<?php if (isset($_GET['tab']) && ($_GET['tab'] == 'products')): ?>
    <div class="card over-hidden">
        <table class="table mb-0">
            <thead class="bg-primary text-light text-center">
            <tr>
                <th class="text-center"></th>
                <th class="text-right">محصول</th>
                <th class="text-center">قیمت</th>
                <th class="text-center">خرید</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $args = array(
                'numberposts' => -1,
                'post_type' => 'product',
                'posts_per_page' =>  $number,
                'post_status' => array('publish'),
                'paged'          =>  $paged,
                'meta_query' => array(
                    array(
                        'key' => '_user_liked',
                        'compare' => 'LIKE'
                    )
                ));
            $sep = '';
            $like_query = new WP_Query($args);
            if ($like_query->have_posts()) :
                $num = null;
                while ($like_query->have_posts()) : $like_query->the_post();
                    global $product;
                    $get_all_user = get_post_meta(get_the_ID(), '_user_liked');
                    $get_all_user = $get_all_user[0];
                    if (is_array($get_all_user) && in_array(get_current_user_id(), $get_all_user)):
                        $num = true; ?>
                        <tr>
                            <td class="product-tbimg"><a href="<?php echo get_permalink($like_query->post->ID) ?>"
                                   title="<?php echo esc_attr($like_query->post->post_title ? $like_query->post->post_title : $like_query->post->ID); ?>">
                                    <?php if (has_post_thumbnail($like_query->post->ID)) echo get_the_post_thumbnail($like_query->post->ID, 'thumbnail'); else echo '<img src="' . WF_URI . '/assets/img/nopic.png"'; ?>
                                </a>
                            </td>
                            <td class="align-middle"><a href="<?php echo get_permalink($like_query->post->ID) ?>"
                                   title="<?php echo esc_attr($like_query->post->post_title ? $like_query->post->post_title : $like_query->post->ID); ?>"><?php echo esc_attr($like_query->post->post_title ? $like_query->post->post_title : $like_query->post->ID); ?>
                                </a>
                            </td>
                            <td class="text-center align-middle"><b class="price text-success"><?php echo $product->get_price_html(); ?></b></td>
                            <td class="text-center align-middle"><a  class="tocart btn btn-success btn-sm" href="<?php echo $product->add_to_cart_url();?>"><?php echo cs_get_option('translate-addtocart','افزود به سبد خرید');?></a></td>

                        </tr>
                    <?php
                    endif;
                endwhile;
                if($num == null):?>
                    <tr>
                        <td>محصول مورد علاقه ای ندارید</td>
                    </tr>
                <?php
                endif;
            else : ?>
                <tr><td>محصول مورد علاقه ای ندارید</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <nav class="col-md-12 my-4 p-0">
        <?php
        if ($like_query->found_posts > $number ){
            $pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    'format' => '',
                    'prev_text' => __( '&laquo;', 'lup' ),
                    'next_text' => __( '&raquo;', 'lup' ),
                    'total' => $like_query->max_num_pages,
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
<?php wp_reset_postdata();?>
<?php elseif (isset($_GET['tab']) && ($_GET['tab'] == 'comments')): ?>
    <div class="card over-hidden">
        <table class="table mb-0">
            <thead class="bg-primary text-light text-center">
            <tr>
                <th class="text-right" >متن دیدگاه</th>
                <th class="text-center" width="20%">پیوند دیدگاه</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $offset = ($paged - 1) * $number;
            $args = array(
                'status' => 'approve',
                'number' => $number,
                'offset' => $offset,
                'meta_query' => array(
                    array(
                        'key' => '_user_comment_liked',
                        'compare' => 'LIKE'
                    )
                )
            );
            $comments = get_comments($args);
            $all_com = (isset($comments)) ? count($comments) + $offset : count($comments);
            $max_num_pages = intval($all_com / $number) + 1;

            if ($comments) :
                foreach ($comments as $comment):?>
                    <tr>
                        <td class="align-middle">
                            <?php echo $comment->comment_content; ?>
                        </td>
                        <td class="text-center">
                            <a href="<?php echo get_comment_link( $comment->comment_ID, $args ); ?>" class="btn btn-link">نمایش نظر</a>

                        </td>
                    </tr>
                <?php
                endforeach;
            else :
                ?>
                <tr>
                    <td>دیدگاه مورد علاقه ای ندارید.</td>
                </tr>
            <?php
            endif;
            wp_reset_postdata();
            ?>
            </tbody>
        </table>
    </div>
    <nav class="col-md-12 my-4 p-0">
        <?php

        $current_page = max(1, $paged);
            $pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    add_query_arg( 'pagenum', '%#%' ),
                    'current' => $current_page,
                    'total' => $max_num_pages,
                    'prev_text' => __( '&laquo;', 'lup' ),
                    'next_text' => __( '&raquo;', 'lup' ),
                    'type'         => 'list',
                    'current' => $current_page
                )
            ));
            if ($pagination) {
                echo str_replace( "<ul class='page-numbers'>", '<ul class="pagination">',$pagination);
            }

        ?>
    </nav>
    <?php wp_reset_postdata();?>
<?php else: ?>
    <div class="card over-hidden">
        <table class="table mb-0">
            <thead class="bg-primary text-light text-center">
            <tr>
                <th></th>
                <th class="text-right">عناوین مورد علاقه</th>
                <th class="text-center">دسته بندی</th>
                <th class="text-center">نویسنده</th>
                <th class="text-center">تاریخ</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' =>  $number,
                'post_status' => array('publish'),
                'paged'          =>  $paged,
                'meta_query' => array(
                    array(
                        'key' => '_user_liked',
                        'compare' => 'LIKE'
                    )
                ));
            $sep = '';
            $like_query = new WP_Query($args);
            if ($like_query->have_posts()) :
                $num = null;
                while ($like_query->have_posts()) : $like_query->the_post();
                    $get_all_user = get_post_meta(get_the_ID(), '_user_liked');
                    $get_all_user = $get_all_user[0];
                    if (is_array($get_all_user) && in_array(get_current_user_id(), $get_all_user)):
                        $num = true; ?>
                        <tr>
                            <td class="product-tbimg"><a href="<?php echo get_permalink($like_query->post->ID) ?>"
                                                         title="<?php echo esc_attr($like_query->post->post_title ? $like_query->post->post_title : $like_query->post->ID); ?>">
                                    <?php if (has_post_thumbnail($like_query->post->ID)) echo get_the_post_thumbnail($like_query->post->ID, 'thumbnail'); else echo '<img src="' . WF_URI . '/assets/img/thumbnail.png"'; ?>
                                </a>
                            </td>
                            <td class="align-middle">
                                <?php echo $sep; ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </td>
                            <td class="text-center align-middle">
                                <?php
                                $categories = get_the_category();

                                if ( ! empty( $categories ) ) {
                                    echo esc_html( $categories[0]->name );
                                }
                                ?>
                            </td>
                            <td class="text-center align-middle"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('user_nicename')); ?>"
                                                       class="meta-user"> <?php the_author(); ?></a></td>
                            <td class="text-center align-middle"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'; ?></td>
                        </tr>
                    <?php
                    endif;
                endwhile;
                if($num == null):?>
                    <tr>

                        <td>مطلب مورد علاقه ای ندارید</td>
                    </tr>
                <?php
                endif;
            else : ?>
                <tr>
                    <td>مطلب مورد علاقه ای ندارید</td></tr>
            <?php
            endif;
            wp_reset_postdata();
            ?>
            </tbody>
        </table>
    </div>
    <nav class="col-md-12 my-4 p-0">
        <?php
        if ($like_query->found_posts > $number ){
            $pagination = paginate_links( apply_filters( 'woocommerce_pagination_args', array(
                    'base' => add_query_arg( 'pagenum', '%#%' ),
                    'format' => '',
                    'prev_text' => __( '&laquo;', 'lup' ),
                    'next_text' => __( '&raquo;', 'lup' ),
                    'total' => $like_query->max_num_pages,
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
    <?php wp_reset_postdata();?>
<?php endif; ?>