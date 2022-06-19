<?php
define('WF_PATH', get_template_directory());
define('WF_URI', get_template_directory_uri());
define('WF_VER', '2.9');
include "app/autoloader.php";
include "app/FS_Elementor.php";
include "app/product_metabox.php";
if( ! function_exists( 'cs_framework_init' ) && ! class_exists( 'CSFramework' ) ) {
    require_once "inc/factshop-core.php";
}
new FS_Utility();
new FS_Woocommerce;
$fs_user = new FS_User;

function get_col_loop_home()
{
    if (is_active_sidebar('sidebar-main')) {
        echo 'col-lg-4 col-xl-4 ';
    } else {
        echo 'col-lg-3 col-xl-3 ';
    }
}

function get_fs_terms($taxonomy,$post_type){
    $args = array(
        'post_type' => $post_type,
        'taxonomy' => $taxonomy,
    );
    $arr = array();
    $terms = get_terms( $args );
    foreach ($terms as $id => $val){
        $arr[$val->term_id] = $val->name;
    }
    return $arr;
}

function get_col_loop_archive($bool = false)
{
    if ($bool == true) {
        if (is_active_sidebar('sidebar-archive')) {
            return true;
        } else {
            return false;
        }
    } else {
        if (is_active_sidebar('sidebar-archive')) {
            echo 'col-lg-4 col-xl-4 ';
        } else {
            echo 'col-lg-3 col-xl-3 ';
        }
    }

}

function is_sidebar_in_page($bool = false)
{
    $is_sidbar_on = false;
    $page_class = '';
    $page_class2 = '';
    if (is_single()) {
        if (is_active_sidebar('sidebar-post')) {
            $is_sidbar_on = true;
            $page_class = 'is_post_sidbar';
        }
        $page_class2 = 'in_post';
    } elseif (is_page()) {
        if (is_active_sidebar('sidebar-page')) {
            $is_sidbar_on = true;
            $page_class = 'is_page_sidbar';
        }
        $page_class2 = 'in_page';
    }
    if ($bool == true) {
        return ($is_sidbar_on == true) ? true : false;
    }
    echo ($is_sidbar_on == true) ? 'col-lg-4 col-xl-4 ' . $page_class . ' ' . $page_class2 : 'col-lg-3 col-xl-3 ' . $page_class . ' ' . $page_class2;
}

function wf_image_alt($image_url)
{
    global $wpdb;

    if (empty($image_url)) {
        return false;
    }

    $query_arr = $wpdb->get_col($wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid='%s';", strtolower($image_url)));
    $image_id = (!empty($query_arr)) ? $query_arr[0] : 0;

    return get_post_meta($image_id, '_wp_attachment_image_alt', true);
}

function getPostViews($postID, $is_related_post = false, $just_count = false)
{
    if (is_single() && $is_related_post == false) {
        $style_in_page = 'meta-unlike  float-left ';
    } else {
        $style_in_page = 'unlike ';
    }
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($just_count == true) {
        if ($count == '') {
            return '0';
        }
        return $count;
    } else {
        if ($count == '') {
            delete_post_meta($postID, $count_key);
            add_post_meta($postID, $count_key, '0');

            return '<a class="' . $style_in_page . '" href="javascript:;"><i class="fas fa-eye mr-1"></i>0</a>';
        }
        return '<a class="' . $style_in_page . '" href="javascript:;"><i class="fas fa-eye mr-1" ></i>' . thousandsCurrencyFormat($count) . '</a>';
    }

}


function setPostViews($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function factshop_prefix_rewrite_flush()
{
    flush_rewrite_rules();
}

add_action('after_switch_theme', 'factshop_prefix_rewrite_flush');

function is_crouse()
{
    return is_singular(array('crouse'));
}

function thousandsCurrencyFormat($num)
{

    if ($num > 1000) {

        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int)$x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];

        return $x_display;

    }

    return $num;
}

function remon_breadcrumbs()
{
    $class = "card breadcrumbs";
    $showOnHome = 1;
    $home = 'خانه';
    $showCurrent = 1;
    $before = '<li>';
    $after = '</li>';
    global $post;
    $homeLink = get_bloginfo('url');
    $q = (get_query_var('paged')) ? ' is_num_paged' : '';
    echo '<div class="card breadcrumbs mb-4 ' . $q . '"><div class="row"><div class="col-md-12 "><ul class="breadcrumbs-list list-unstyled">';

    if (is_home() || is_front_page()) {
        if ($showOnHome == 1) {
            echo '<li><a href="' . $homeLink . '">' . $home . '</a></li>';
        }

    } else {
        echo '<li><a href="' . $homeLink . '">' . $home . '</a></li>';
        if (is_category()) {
            echo '<li>';
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                echo get_category_parents($thisCat->parent, TRUE, '');
            }
            echo '</li>';

            echo $before . ' "' . single_cat_title('', false) . '"' . $after;
        } else
            if (is_search()) {
                echo $before . 'نتایج جستجو برای "' . get_search_query() . '"' . $after;
            } else
                if (is_day()) {
                    echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> </li> ';
                    echo '<li><a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a></li> ';
                    echo $before . get_the_time('d') . $after;
                } else
                    if (is_month()) {
                        echo '<li><a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> </li>';
                        echo $before . get_the_time('F') . $after;
                    } else
                        if (is_year()) {
                            echo $before . get_the_time('Y') . $after;
                        } else
                            if (is_single() && !is_attachment()) {
                                if (get_post_type() != 'post') {
                                    if (get_post_type() == 'product') {
                                        global $post;
                                        $terms = get_the_terms($post->ID, 'product_cat');
                                        foreach ($terms as $term) {
                                            echo '<li>';
                                            echo '<a href="' . site_url() . '/product-category/' . $term->slug . '">';
                                            echo $term->name;
                                            echo '</a>';
                                            echo '</li>';
                                        }
                                        if ($showCurrent == 1) {
                                            echo $before . get_the_title() . $after;
                                        }
                                    } else {
                                        $post_type = get_post_type_object(get_post_type());
                                        $slug = $post_type->rewrite;
                                        echo '<li><a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a></li>';
                                        if ($showCurrent == 1) {
                                            echo ' ' . $before . get_the_title() . $after;
                                        }
                                    }


                                } else {
                                    $cat = get_the_category();
                                    $cat = $cat[0];
                                    $cats = get_category_parents($cat, TRUE, '</li><li>');

                                    if ($showCurrent == 0) {
                                        $cats = preg_replace("#^(.+)\s\s$#", "$1", $cats);
                                    }
                                    echo '<li>';
                                    echo $cats;
                                    echo '</li>';
                                    if ($showCurrent == 1) {
                                        echo $before . get_the_title() . $after;
                                    }

                                }
                            } else
                                if (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
                                    $post_type = get_post_type_object(get_post_type());
                                    echo $before . $post_type->labels->singular_name . $after;

                                } else
                                    if (is_attachment()) {
                                        $parent = get_post($post->post_parent);
                                        $cat = get_the_category($parent->ID);
                                        $cat = $cat[0];
                                        echo get_category_parents($cat, TRUE, ' ');
                                        echo '<li><a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a></li>';
                                        if ($showCurrent == 1) {
                                            echo ' ' . $before . get_the_title() . $after;
                                        }

                                    } else
                                        if (is_page() && !$post->post_parent) {
                                            if ($showCurrent == 1) {
                                                echo $before . get_the_title() . $after;
                                            }

                                        } else
                                            if (is_page() && $post->post_parent) {
                                                $parent_id = $post->post_parent;
                                                $breadcrumbs = array();
                                                while ($parent_id) {
                                                    $page = get_page($parent_id);
                                                    $breadcrumbs[] = '<li><a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a></li>';
                                                    $parent_id = $page->post_parent;
                                                }
                                                $breadcrumbs = array_reverse($breadcrumbs);
                                                for ($i = 0; $i < count($breadcrumbs); $i++) {
                                                    echo $breadcrumbs[$i];
                                                    if ($i != count($breadcrumbs) - 1) {
                                                    }

                                                }
                                                if ($showCurrent == 1) {
                                                    echo $before . get_the_title() . $after;
                                                }

                                            } else
                                                if (is_tag()) {
                                                    echo $before . 'برچسب"' . single_tag_title('', false) . '"' . $after;
                                                } else
                                                    if (is_author()) {
                                                        global $author;
                                                        $userdata = get_userdata($author);
                                                        echo $before . 'مطالب نوشته شده توسط ' . $userdata->display_name . $after;
                                                    } else
                                                        if (is_404()) {
                                                            echo $before . 'یافت نشد' . $after;
                                                        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo '<li> (';
            }

            echo __('صفحه') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ')</li>';
            }

        }
        echo '</ul></div></div></div>';
    }
}

function wf_comments($comment, $args, $depth)
{
    $GLOBALS['comment'] = $comment;
    ?>
    <?php if ($comment->comment_approved == '1'): ?>
    <li id="#comment-<?php comment_ID(); ?>">
        <div class="comment-meta">
            <?php echo get_avatar($comment, '45', '', '', array('class' => 'user-pic')); ?>
            <b class="comment-user"><?php comment_author_link() ?></b>
            <small class="comment-date"><?php comment_date() ?></small>

            <?php if (cs_get_option('show-comment-like')) {
                echo get_simple_likes_button(get_comment_ID(), 1);
            } ?>
            <?php comment_reply_link(
                array(
                    'reply_text' => '<i class="icon-replay"></i>پاسخ'
                , 'depth' => isset($args['args']['depth']) ? $args['args']['depth'] : (int)3
                , 'max_depth' => isset($args['args']['max_depth']) ? $args['args']['max_depth'] : (int)5
                )
            ); ?>
            <div class="comment-text"><?php comment_text() ?></div>
        </div>

    </li>
<?php endif;
}

function is_edit_page($new_edit = null)
{
    global $pagenow;
    //make sure we are on the backend
    if (!is_admin()) return false;


    if ($new_edit == "edit")
        return in_array($pagenow, array('post.php',));
    elseif ($new_edit == "new") //check for new post page
        return in_array($pagenow, array('post-new.php'));
    else //check for either new or edit
        return in_array($pagenow, array('post.php', 'post-new.php'));
}

function wf_get_last_login($user_id, $prev = null)
{

    $last_login = get_user_meta($user_id);
    $time = current_time('timestamp');

    if (isset($last_login['_last_login_prev'][0]) && $prev) {
        $last_login = get_user_meta($user_id, '_last_login_prev', 'true');
    } else if (isset($last_login['_last_login'][0])) {
        $last_login = get_user_meta($user_id, '_last_login', 'true');
    } else {
        update_user_meta($user_id, '_last_login', $time);
        $last_login = current_time( 'timestamp', 1 );
    }

    return $last_login;
}

function wf_count_user_comments()
{
    global $wpdb, $current_user;
    $count = $wpdb->get_var('SELECT COUNT(comment_ID) FROM ' . $wpdb->comments . ' WHERE comment_author_email = "' . $current_user->user_email . '"');

    return $count;
}

function get_type_download_file_product()
{
    global $product;

    $downloads = $product->get_downloads();
    $formats = '';
    foreach ($downloads as $key => $each_download) {
        $info = pathinfo($each_download["file"]);
        $formats .= $info['extension'] . ", ";
    }

    return $formats;
}

function get_link_download_file_product()
{
    global $product;

    $downloads = $product->get_downloads();
    $link = '';
    foreach ($downloads as $key => $each_download) {
        $link = $each_download["file"];
    }

    return $link;
}

function getRemoteFilesize($url, $formatSize = true, $useHead = true)
{
    if (false !== $useHead) {
        stream_context_set_default(array('http' => array('method' => 'HEAD')));
    }
    $head = array_change_key_case(get_headers($url, 1));
    // content-length of download (in bytes), read from Content-Length: field
    $clen = isset($head['content-length']) ? $head['content-length'] : 0;

    // cannot retrieve file size, return "-1"
    if (!$clen) {
        return -1;
    }

    if (!$formatSize) {
        return $clen; // return size in bytes
    }

    $size = $clen;
    switch ($clen) {
        case $clen < 1024:
            $size = $clen . ' بایت';
            break;
        case $clen < 1048576:
            $size = round($clen / 1024, 2) . ' کیلوبایت';
            break;
        case $clen < 1073741824:
            $size = round($clen / 1048576, 2) . ' مگابایت';
            break;
        case $clen < 1099511627776:
            $size = round($clen / 1073741824, 2) . ' گیگابایت';
            break;
    }

    return $size; // return formatted size
}

function wf_pagination($wp_query = null, $echo = true)
{
    if (null === $wp_query) {
        global $wp_query;
    }
    $pages = paginate_links([
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'type' => 'array',
            'show_all' => false,
            'end_size' => 3,
            'mid_size' => 1,
            'prev_next' => true,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
            'add_args' => false,
            'add_fragment' => ''
        ]
    );
    if (is_array($pages)) {
        //$paged = ( get_query_var( 'paged' ) == 0 ) ? 1 : get_query_var( 'paged' );
        $pagination = '<div class="col-md-12 text-center"><ul class="pagination">';
        foreach ($pages as $page) {
            $pagination .= '<li class="page-item"> ' . str_replace('page-numbers', 'page-link', $page) . '</li>';
        }
        $pagination .= '</ul></div>';
        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }
    return null;
}

function wf_get_image_id($image_url)
{
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));
    return $attachment[0];
}

function get_star_rating()
{
    global $woocommerce, $product;
    $average = $product->get_average_rating();
    $review_count = $product->get_review_count();

    return '<div class="star-rating text-warning">
                <span style="width:' . (($average / 5) * 100) . '%" title="' .
        $average . '">
                    <strong itemprop="ratingValue" class="rating">' . $average . '</strong> ' . __('out of 5', 'woocommerce') .
        '</span>                    
            </div>' . '
            <p class="float-right m-0" style="font-size: 13px;" >امتیاز: <b>' . (int)$average . '</b> از <b>' . $review_count . '</b> رای</p>';

}

if (!class_exists('FS_Init')) {
    exit;
}

add_action('wp', 'wf_theme_check');
function wf_theme_check()
{
    if (FS_Init::is_activated() === true) {
        update_option('factshop_theme', true);
    } else {
        update_option('factshop_theme', false);
        if (is_home() || is_archive() || is_single() || is_page()) {
            return;
        }
    }
}

function already_liked($post_id, $is_comment)
{
    $post_users = NULL;
    $user_id = NULL;
    if (is_user_logged_in()) { // user is logged in
        $user_id = get_current_user_id();
        $post_meta_users = ($is_comment == 1) ? get_comment_meta($post_id, "_user_comment_liked") : get_post_meta($post_id, "_user_liked");
        if (count($post_meta_users) != 0) {
            $post_users = $post_meta_users[0];
        }
    } else { // user is anonymous
        $user_id = sl_get_ip();
        $post_meta_users = ($is_comment == 1) ? get_comment_meta($post_id, "_user_comment_IP") : get_post_meta($post_id, "_user_IP");
        if (count($post_meta_users) != 0) { // meta exists, set up values
            $post_users = $post_meta_users[0];
        }
    }
    if (is_array($post_users) && in_array($user_id, $post_users)) {
        return true;
    } else {
        return false;
    }
}

function get_simple_likes_button($post_id, $is_comment = NULL, $is_related_post = false)
{
    $is_comment = (NULL == $is_comment) ? 0 : 1;
    $output = '';
    $nonce = wp_create_nonce('simple-likes-nonce'); // Security
    if ($is_comment == 1) {
        $post_id_class = esc_attr(' sl-comment-button-' . $post_id);
        $comment_class = esc_attr(' sl-comment');
        $like_count = get_comment_meta($post_id, "_comment_like_count", true);
        $like_count = (isset($like_count) && is_numeric($like_count)) ? $like_count : 0;
    } else {
        $post_id_class = esc_attr(' sl-button-' . $post_id);
        $comment_class = esc_attr('');
        $like_count = get_post_meta($post_id, "_post_like_count", true);
        $like_count = (isset($like_count) && is_numeric($like_count)) ? $like_count : 0;
    }
    $count = get_like_count($like_count);
    $icon_empty = get_unliked_icon();
    $icon_full = get_liked_icon();
    // Loader
    if (is_single() && $is_related_post == false && $is_comment != 1) {
        $loader = '<span id="s-loader" class="like_in_single"></span>';
    } elseif ($is_comment == 1) {
        $loader = '<span id="s-loader" class="like_in_comment"></span>';
    } else {
        $loader = '<span id="s-loader"></span>';
    }

    // Liked/Unliked Variables
    if (already_liked($post_id, $is_comment)) {
        $class = esc_attr(' liked');
        $title = 'نمی پسندید';
        $icon = $icon_full;
    } else {
        $class = '';
        $title = 'می پسندید';
        $icon = $icon_empty;
    }
    if (is_single() && $is_related_post == false && $is_comment != 1) {
        $style_in_page = 'meta-like  float-left ';
    } elseif ($is_comment == 1) {
        $style_in_page = 'like comment-like';
    } else {
        $style_in_page = 'like ';
    }
    $output = '<a href="' . admin_url('admin-ajax.php?action=process_simple_like' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&is_comment=' . $is_comment . '&disabled=true') . '" class="sl-button ' . $style_in_page . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader;
    return $output;
}

function post_user_likes($user_id, $post_id, $is_comment)
{
    $post_users = '';
    $post_meta_users = ($is_comment == 1) ? get_comment_meta($post_id, "_user_comment_liked") : get_post_meta($post_id, "_user_liked");
    if (count($post_meta_users) != 0) {
        $post_users = $post_meta_users[0];
    }
    if (!is_array($post_users)) {
        $post_users = array();
    }
    if (!in_array($user_id, $post_users)) {
        $post_users['user-' . $user_id] = $user_id;
    }
    return $post_users;
}

function post_ip_likes($user_ip, $post_id, $is_comment)
{
    $post_users = '';
    $post_meta_users = ($is_comment == 1) ? get_comment_meta($post_id, "_user_comment_IP") : get_post_meta($post_id, "_user_IP");
    // Retrieve post information
    if (count($post_meta_users) != 0) {
        $post_users = $post_meta_users[0];
    }
    if (!is_array($post_users)) {
        $post_users = array();
    }
    if (!in_array($user_ip, $post_users)) {
        $post_users['ip-' . $user_ip] = $user_ip;
    }
    return $post_users;
}

function sl_get_ip()
{
    if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
    }
    $ip = filter_var($ip, FILTER_VALIDATE_IP);
    $ip = ($ip === false) ? '0.0.0.0' : $ip;
    return $ip;
}

function get_liked_icon()
{
    /* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart"></i> */
    $icon = '<span class="sl-icon"><i class="fa fa-heart"></i></span>';
    return $icon;
}

function get_unliked_icon()
{
    /* If already using Font Awesome with your theme, replace svg with: <i class="fa fa-heart-o"></i> */
    $icon = '<span class="sl-icon"><i class="fa fa-heart"></i></span>';
    return $icon;
}

function sl_format_count($number)
{
    $precision = 2;
    if ($number >= 1000 && $number < 1000000) {
        $formatted = number_format($number / 1000, $precision) . 'K';
    } else if ($number >= 1000000 && $number < 1000000000) {
        $formatted = number_format($number / 1000000, $precision) . 'M';
    } else if ($number >= 1000000000) {
        $formatted = number_format($number / 1000000000, $precision) . 'B';
    } else {
        $formatted = $number; // Number is less than 1000
    }
    $formatted = str_replace('.00', '', $formatted);
    return $formatted;
}

function get_like_count($like_count)
{
    $like_text = '0';
    if (is_numeric($like_count) && $like_count > 0) {
        $number = sl_format_count($like_count);
    } else {
        $number = $like_text;
    }
    $count = '<span class="sl-count">' . $number . '</span>';
    return $count;
}

function get_download_box($id)
{
    if (cs_get_option('show-post-download-box')):
        $download_files = get_post_meta($id, 'download_files', true);
        if (isset($download_files) && is_array($download_files) && isset($download_files['files']) && is_array($download_files['files'])):
            if (isset($download_files['free_download']) && ($download_files['free_download'] == true) && is_user_logged_in()):?>
                <div class="card downlod-box mb-4">
                    <div class="row">
                        <div class="col-md-7">
                            <label>لینک های دانلود</label>
                            <div class="download-links">
                                <?php foreach ($download_files['files'] as $file): ?>
                                    <a href="<?php echo $file['file']; ?>" class="btn btn-success"><i
                                                class="fa fa-download mr-2"></i><?php echo $file['subject']; ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php if (cs_get_option('show-post-download-password')): ?>
                                <div class="password-file-label mt-3">پسورد فایل ها:</div>
                                <div class="link-post float-right mt-0 w-50 pb-3">
                                    <input id="input-pass" type="text" class="form-control" readonly="readonly"
                                           value="<?php echo cs_get_option('post-download-box-pass'); ?>"/>
                                    <i id="btn-copy-pass" class="icon-copy"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($download_files['info_dowmload'])): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo $download_files['info_dowmload']; ?></div>
                            </div>
                        <?php elseif (cs_get_option('post-download-info')): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo cs_get_option('post-download-info'); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif (isset($download_files['free_download']) && ($download_files['free_download'] == true) && !is_user_logged_in()): ?>
                <div class="card downlod-box locked mb-4">
                    <span class="lk_text">شما قادر به مشاهده لینک های دانلود نمی باشید. برای مشاهده لینک ها وارد پنل کاربری خود شوید یا ثبت نام کنید.</span>
                    <div class="row">
                        <div class="col-md-7">
                            <label>لینک های دانلود</label>
                            <div class="download-links">
                                <?php foreach ($download_files['files'] as $file): ?>
                                    <a href="#" class="btn btn-success"><i
                                                class="fa fa-download mr-2"></i><?php echo $file['subject']; ?></a>
                                <?php endforeach; ?>
                            </div>

                            <?php if (cs_get_option('show-post-download-password')): ?>
                                <div class="password-file-label mt-3">پسورد فایل ها:</div>
                                <div class="link-post float-right mt-0 w-50 pb-3">
                                    <input id="input-pass" type="text" class="form-control" readonly="readonly"
                                           value="<?php echo cs_get_option('post-download-box-pass'); ?>"/>
                                    <i id="btn-copy-pass" class="icon-copy"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($download_files['info_dowmload'])): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo $download_files['info_dowmload']; ?></div>
                            </div>
                        <?php elseif (cs_get_option('post-download-info')): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo cs_get_option('post-download-info'); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php elseif (isset($download_files['free_download']) && ($download_files['free_download'] == false)): ?>
                <div class="card downlod-box mb-4">
                    <div class="row">
                        <div class="col-md-7">
                            <label>لینک های دانلود</label>
                            <div class="download-links">
                                <?php foreach ($download_files['files'] as $file): ?>
                                    <a href="<?php echo $file['file']; ?>" class="btn btn-success"><i
                                                class="fa fa-download mr-2"></i><?php echo $file['subject']; ?></a>
                                <?php endforeach; ?>
                            </div>

                            <?php if (cs_get_option('show-post-download-password')): ?>
                                <div class="password-file-label mt-3">پسورد فایل ها:</div>
                                <div class="link-post float-right mt-0 w-50 pb-3">
                                    <input id="input-pass" type="text" class="form-control" readonly="readonly"
                                           value="<?php echo cs_get_option('post-download-box-pass'); ?>"/>
                                    <i id="btn-copy-pass" class="icon-copy"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (isset($download_files['info_dowmload'])): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo $download_files['info_dowmload']; ?></div>
                            </div>
                        <?php elseif (cs_get_option('post-download-info')): ?>
                            <div class="col-md-4">
                                <div class="info-box"><?php echo cs_get_option('post-download-info'); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif;
        endif;
    endif;
}

function get_slider_position($position)
{
    if (isset($position)) {
        $show = $position . '-slider-show';
        $slid = $position . 'side';
        $slid = cs_get_option($slid);
        if (cs_get_option($show) && isset($slid[1]['photo'])): ?>
            <div class="card mb-4">
                <div id="main-home-slider" class="carousel slide" data-ride="carousel">
                    <ul class="carousel-indicators">
                        <?php
                        $i = 0;
                        foreach (cs_get_option($position . 'side') as $key):$i++; ?>
                            <?php if ($key['photo']): ?>
                                <li data-target="#main-home-slider" data-slide-to="<?php echo $i; ?>"
                                    class="<?php if ($i == 1) echo "active"; ?>"></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <?php
                        $i = 0;
                        foreach (cs_get_option($position . 'side') as $key):$i++ ?>
                            <?php if ($key['photo']): ?>
                                <div class="carousel-item <?php if ($i == 1) echo "active"; ?>">
                                    <?php if ($key['link']): ?>
                                        <a href="<?php echo $key['link']; ?>"><img
                                                    src="<?php echo $key['photo']; ?>"
                                                    alt="<?php echo wf_image_alt($key['photo']); ?>">
                                        </a>
                                    <?php else: ?>
                                        <img src="<?php echo $key['photo']; ?>"
                                             alt="<?php echo wf_image_alt($key['photo']); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#main-home-slider" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                    <a class="carousel-control-next" href="#main-home-slider" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>

                </div>
            </div>
        <?php endif;
    }
}

function get_current_ip()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                    return $ip;
                }
            }
        }
    }
}

function fsdate($format, $time, $tr_num = '')
{
    if (function_exists('wpp_jdate')) {
        return wpp_jdate($format, $time, $tr_num);
    } else {
        return date($format, $time);
    }
}

function get_ad($page, $location)
{
    if (isset($page) && isset($location)) {
        $show = "show-" . $page . "-ad-" . $location;
        $ad = cs_get_option($page . 'ads' . $location);
        if (cs_get_option($show) && is_array($ad)): ?>
            <?php
            foreach ($ad as $key):?>
                <?php if ($key['adphoto'] != ''): ?>
                    <div class="card ads mb-4">
                        <a href="<?php echo ($key['adlink']) ? $key['adlink'] : 'javascript:;'; ?>"><img
                                    src="<?php echo $key['adphoto']; ?>"/></a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif;
    }
}

function fs_get_avatar_url($user)
{
    if ($user) {
        $user = get_user_by('id', $user);
    }

    if ($user && is_object($user)) {
        $picture_id = get_user_meta($user->data->ID, 'profile_pic');
        if (!empty($picture_id)) {
            $avatar = wp_get_attachment_url($picture_id[0]);
            if (!empty($avatar)) {
                $url = $avatar;
            } else {
                $url = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
            }
        }else{
            $url = (cs_get_option('local_avatar_default')) ? wp_get_attachment_url(cs_get_option('local_avatar_default')) : WF_URI."/assets/img/avatar.png";
        }
    }
    return $url;
}

add_filter('woocommerce_get_price_html', 'fs_product_zero_price', 100, 2);
add_filter('woocommerce_loop_add_to_cart_link', 'fs_change_addtocart_btn', 100, 2);
if (isset($_GET['download_file']) && isset($_GET['key']) && $_GET['free']) {
    add_action('init', 'fs_download_free_product_file');
}


function fs_change_addtocart_btn($button)
{
    global $product,$post;
    if ($product->is_downloadable() AND $product->get_price() == 0) {
        $files = $product->get_downloads();
        $files = array_keys($files);
        if(cs_get_option('free-product-downloadinsingle')){
            $download_url = get_permalink( $post->ID );
        }else{
            $download_url = home_url('?download_file=' . $post->ID . '&key=' . $files[0] . '&free=1');
        }
        $button = sprintf('<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="tocart">%s</a>',
            esc_url($download_url),
            esc_attr($post->ID),
            esc_attr($product->get_sku()),
            esc_attr(isset($quantity) ? $quantity : 1),
            esc_html(cs_get_option('translate-download','دانلود'))
        );
    }
    return $button;
}

function fs_download_free_product_file()
{
    $product_id = absint($_GET['download_file']);
    $_product = wc_get_product($product_id);

    if ($_product->get_price() == 0) {
        WC_Download_Handler::download($_product->get_file_download_path(filter_var($_GET['key'], FILTER_SANITIZE_STRING)), $product_id);
    }
}

function fs_product_zero_price($price, $product)
{
    if ('' === $product->get_price() || 0 == $product->get_price()) {
        $price = '<span class="woocommerce-Price-amount amount">'.cs_get_option('translate-free','رایگان').'</span>';
    }

    return $price;
}


add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
add_action( 'woocommerce_save_account_details', 'my_woocommerce_save_account_details' );

function my_woocommerce_edit_account_form() {

    $user_id = get_current_user_id();
    $user = get_userdata( $user_id );

    if ( !$user )
        return;

    $twitter = get_user_meta( $user_id, 'twitter', true );
    $facebook = get_user_meta( $user_id, 'facebook', true );
    $instagram = get_user_meta( $user_id, 'instagram', true );
    $telegram = get_user_meta( $user_id, 'telegram', true );
    $google = get_user_meta( $user_id, 'google+', true );
    $url = $user->user_url;
    $bio = $user->description;

    ?>

    <fieldset>
        <legend>شبکه های اجتماعی</legend>
        <p class="form-row form-row-thirds">
            <label for="twitter">توئیتر:</label>
            <input type="text" name="twitter" value="<?php echo esc_attr( $twitter ); ?>" class="form-control text-left" />
        </p>
    </fieldset>
    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="facebook"> فیسبوک:</label>
            <input type="text" name="facebook" value="<?php echo esc_attr( $facebook ); ?>" class="form-control text-left" />
        </p>
    </fieldset>
    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="instagram"> اینستاگرام:</label>
            <input type="text" name="instagram" value="<?php echo esc_attr( $instagram); ?>" class="form-control text-left" />
        </p>
    </fieldset>
    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="telegram"> تلگرام:</label>
            <input type="text" name="telegram" value="<?php echo esc_attr( $telegram ); ?>" class="form-control text-left" />
        </p>
    </fieldset>
    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="google+"> گوگل پلاس:</label>
            <input type="text" name="google+" value="<?php echo esc_attr( $google ); ?>" class="form-control text-left" />
        </p>
    </fieldset>

    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="url">وب سایت:</label>
            <input type="text" name="url" value="<?php echo esc_attr( $url ); ?>" class="form-control text-left" style="" />
        </p>
    </fieldset>
    <fieldset>
        <p class="form-row form-row-thirds">
            <label for="bio">بیوگرافی:</label>
            <textarea class="form-control" id="bio" name="bio" rows="8" style="height:100%;"><?php echo esc_attr( $bio ); ?></textarea>
        </p>
    </fieldset>

    <?php

}

function my_woocommerce_save_account_details( $user_id ) {

    update_user_meta( $user_id, 'twitter', htmlentities( $_POST[ 'twitter' ] ) );
    update_user_meta( $user_id, 'facebook', htmlentities( $_POST[ 'facebook' ] ) );
    update_user_meta( $user_id, 'instagram', htmlentities( $_POST[ 'instagram' ] ) );
    update_user_meta( $user_id, 'telegram', htmlentities( $_POST[ 'telegram' ] ) );
    update_user_meta( $user_id, 'google+', htmlentities( $_POST[ 'google+' ] ) );
    $user = wp_update_user( array(
            'ID' => $user_id,
            'user_url' => esc_url( $_POST[ 'url' ] ),
            'description' =>  sanitize_textarea_field($_POST[ 'bio' ]),
        )
    );

}

function is_actived_user(){
    if(cs_get_option('factshop-signup-verification')) {
        if (is_user_logged_in()) {
            $verif = get_user_meta(get_current_user_id(), 'verification');
            if (!$verif) {
                return false;
            }
        }
    }
    return true;

}

function is_user_verified($id){
    if (cs_get_option('email-user-verify-is')){
        if(get_user_meta($id,'is_activated')){
            return true;
        }
        else{
            return false;
        }
    }else{
        return true;
    }
}

function new_modify_user_table( $column ) {
    $column['is_activated'] = 'وضعیت حساب';
    return $column;
}

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    if ( 'is_activated' == $column_name ) {
        if (get_user_meta( $user_id,'is_activated' )){
            return '<span style="color:green;">تایید شده</span>';
        }else{
            return '<span style="color:red;">تایید نشده</span>';
        }
    }
    return $val;
}

add_action('pre_get_posts','users_own_attachments');
function users_own_attachments( $wp_query_obj ) {
    global $current_user, $pagenow;
    $is_attachment_request = ($wp_query_obj->get('post_type')=='attachment');

    if( !$is_attachment_request )
        return;

    if( !is_a( $current_user, 'WP_User') )
        return;

    if( !in_array( $pagenow, array( 'upload.php', 'admin-ajax.php' ) ) )
        return;

    if( !current_user_can('delete_pages') )
        $wp_query_obj->set('author', $current_user->ID );

    return;
}
function check_is_fact_shop_actived() {
    if(is_plugin_active('factshop-core/factshop-core.php')){
        add_action( 'admin_notices', 'factshop_core_active_missing' );
    }
}
add_action( 'admin_init', 'check_is_fact_shop_actived' );

function factshop_core_active_missing() {
    $class = 'notice notice-error';
    $message = "<b>پلاگین هسته فکت شاپ</b> فعال می باشد، در نسخه جدید دیگر نیاز به این پلاگین ندارید. در لیست افزونه ها آن را غیرفعال و حذف کنید.";
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), $message );
}

function factshop_dokan_dashboard_nav( $active_menu = '' ) {

    $nav_menu          = dokan_get_dashboard_nav();
    $active_menu_parts = explode( '/', $active_menu );

    if ( isset( $active_menu_parts[1] )
        && $active_menu_parts[0] == 'settings'
        && isset( $nav_menu['settings']['sub'] )
        && array_key_exists( $active_menu_parts[1], $nav_menu['settings']['sub'] )
    ) {
        $urls        = $nav_menu['settings']['sub'];
        $active_menu = $active_menu_parts[1];
    } else {
        $urls = $nav_menu;
    }

    $menu           = '';
//    $hamburger_menu = apply_filters( 'dokan_load_hamburger_menu', true );
//
//    if ( $hamburger_menu ) {
//        $menu .= '<div id="dokan-navigation" area-label="Menu">';
//        $menu .= '<label id="mobile-menu-icon" for="toggle-mobile-menu" aria-label="Menu">&#9776;</label>';
//        $menu .= '<input id="toggle-mobile-menu" type="checkbox" />';
//    }

    $menu .= '<ul class="my-acount-menus list-unstyled dokan-menu">';

    foreach ( $urls as $key => $item ) {
        $class = ( $active_menu == $key ) ? 'is-active ' . $key : $key;
        $menu .= sprintf( '<li class="%s"><a href="%s">%s %s</a></li>', $class, $item['url'], $item['icon'], $item['title'] );
    }

    $common_links = '
            <li class="dokan-common-links dokan-clearfix"><a  href="' . dokan_get_store_url( dokan_get_current_user_id() ) .'" target="_blank"><i class="fa fa-external-link"></i>' . __( 'Visit Store', 'dokan-lite' ) . '</a></li>
            <li class="dokan-common-links dokan-clearfix"><a href="' . dokan_get_navigation_url( 'edit-account' ) . '"><i class="fa fa-user"></i>' . __( 'Edit Account', 'dokan-lite' ) . '</a></li>
            <li class="dokan-common-links dokan-clearfix"><a href="' . wp_logout_url( home_url() ) . '"><i class="fa fa-power-off"></i>' . __( 'Log out', 'dokan-lite' ) . '</a></li>
        </li>';

    $menu .= apply_filters( 'dokan_dashboard_nav_common_link', $common_links );

    $menu .= '</ul>';

//    if ( $hamburger_menu ) {
//        $menu .= '</div>';
//    }

    return $menu;
}


function fs_pre_get_posts($query){
    if ($query->is_main_query() && !$query->is_feed() && !is_admin() && is_category() or is_tag() or is_author() or is_search()) {
        $query->set('page_val', get_query_var('paged'));
        $query->set('paged', 0);
    }
}
add_action('pre_get_posts', 'fs_pre_get_posts');

function factshop_elementor_widget_categories( $elements_manager ) {

    $elements_manager->add_category(
        'factshop-elements',
        [
            'title' =>'فکت شاپ',
            'icon' => 'fa fa-plug',
        ]
    );

}
add_action( 'elementor/elements/categories_registered', 'factshop_elementor_widget_categories' );


function get_notification_unread($post_id){
    global $current_user;
    if(get_user_meta(get_current_user_id(), 'read_post_' . $post_id, true) == ""){
        if(fsdate('Y-m-d',get_the_date('Y-m-d',$post_id)) >= fsdate('Y-m-d', $current_user->user_registered)){
            echo 'unread_post';
        }
    }
}