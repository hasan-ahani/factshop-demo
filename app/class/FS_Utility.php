<?php

if (!defined('ABSPATH'))
    die('Fizzle');

class FS_Utility
{
    public function __construct()
    {
        if (cs_get_option('is_captcha_comment') && cs_get_option('is_google_captcha')) new FS_Comment();
        if (cs_get_option('is_local_avatar')) new FS_Avatar();
        new FS_Customize();



        add_action('init', array($this, 'fs_make_user_writer'));
        add_action('init', array($this, 'fs_notification_user'));
        add_filter('the_content', array($this, 'fs_notification_guestes'));
        add_filter('intermediate_image_sizes_advanced', array($this, 'fs_remove_default_images'));
        $this->init();
        add_action('widgets_init', array($this, 'fs_widgets_init'));
        add_filter('user_contactmethods', array($this, 'fs_user_contactmethods'), 10, 1);

        if(cs_get_option('wp-login-redirect')){
            add_action('init', array($this ,'seacure_login_page'));
        }
        add_action('wp_login', 'fs_set_last_login', 0, 2);
        if (!is_admin()) {
            add_filter('ajax_query_attachments_args', array($this, 'fs_seacure_media'));
        }
        add_action('wp_ajax_nopriv_process_simple_like', array($this, 'process_like_post'));
        add_action('wp_ajax_process_simple_like', array($this, 'process_like_post'));
        add_shortcode('fs_like', array($this, 'fs_like_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'fs_style_load'));
        if (class_exists('Awesome_Support')) {
            $role = get_role('subscriber');
            $role->add_cap('create_ticket');
        }
        add_action('after_switch_theme', array($this, 'fact_shop_activated'));
        add_option('factshop_theme',false);
        if(cs_get_option('is_ajax_search_header')){
            add_action('wp_ajax_factshop_live_search', array($this, 'factshop_live_search'));
            add_action('wp_ajax_nopriv_factshop_live_search', array($this, 'factshop_live_search'));
        }

        add_action( 'init', array($this,'maybe_rewrite_rules'));

    }
    public function maybe_rewrite_rules() {

        $ver = filemtime( __FILE__ ); // Get the file time for this file as the version number
        $defaults = array( 'version' => 0, 'time' => time() );
        $r = wp_parse_args( get_option( __CLASS__ . '_flush', array() ), $defaults );

        if ( $r['version'] != $ver || $r['time'] + 172800 < time() ) { // Flush if ver changes or if 48hrs has passed.
            flush_rewrite_rules();
            // trace( 'flushed' );
            $args = array( 'version' => $ver, 'time' => time() );
            if ( ! update_option( __CLASS__ . '_flush', $args ) )
                add_option( __CLASS__ . '_flush', $args );
        }
    }

    function factshop_live_search()
    {
        $search = sanitize_text_field($_POST['search']);
        $pt = (is_array(cs_get_option('ajax_search_query'))) ? cs_get_option('ajax_search_query') : array('post', 'product') ;
        $q = new WP_Query(
            array(
                'post_type' => $pt,
                'posts_per_page' => 8,
                's' => $search
            )
        );
        $output = '';
        if ($q->have_posts()) {

            echo '<ul class="feather-post  live-search">';
            while ($q->have_posts()) : $q->the_post();
                echo '<li>';
                echo '<a href="' . get_permalink() . '">';
                if (has_post_thumbnail()):
                    the_post_thumbnail('thumbnail');
                else:
                    echo '<img src="' . WF_URI . '/assets/img/nopic.png">';
                endif;
                echo '<h6>' . get_the_title() . ' </h6>';
                if(get_post_type(get_the_ID()) == 'product'){
                    global $product;
                    echo '<b class="price">';
                    echo  $product->get_price_html();
                    echo '</b>';
                }else{
                    echo '<small>';
                    echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش';
                    echo '</small>';
                }
                echo '</a>';
                echo '</li>';
                /* end loop */
            endwhile;
            echo '</ul>';
        } else {
            echo 'error';

        }
        wp_reset_query();

        die();

    }

    public function fs_style_load()
    {
        wp_enqueue_style('factshop-font', WF_URI . '/assets/css/'.cs_get_customize_option('site_font','yekan-bakh').'.css', array(), '1.1', false);
        wp_enqueue_style('factshop', WF_URI . '/assets/css/theme.min.css', array(), '2.9', false);
        wp_enqueue_style('vplayer', 'https://cdn.plyr.io/2.0.13/plyr.css', array(), '2.0.13', false);
        if(cs_get_option('custom_css')){
            wp_add_inline_style( 'factshop',cs_get_option('custom_css'));
        }
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        wp_deregister_script('jquery');
        wp_enqueue_script('jquery', WF_URI . '/assets/js/jquery.min.js', array(), null, true);

        wp_enqueue_script('factshop_scripts', WF_URI . '/assets/js/theme.min.js', array('jquery'),'2.9',true );
        wp_localize_script('factshop_scripts', 'factshop', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'like' => 'می پسندید',
            'unlike' => 'نمی پسندید',
            'redirecturl' => $this->get_redirect_url(),
            'loadingmessage' => __('در حال ارسال اطلاعات، لطفا کمی صبر کنید ...')
        ));


        if(cs_get_option('custom_js')){
            wp_add_inline_script( 'factshop_scripts',cs_get_option('custom_js'));
        }

        wp_enqueue_script('vplayer', 'https://cdn.plyr.io/2.0.13/plyr.js', array('jquery'),'',true );

        wp_add_inline_script('vplayer', 'plyr.setup();');
    }

    private function get_redirect_url(){
        global $wp;
        if(!is_home()){
            return home_url( $wp->request );
        }
        return home_url();
    }


    public function fact_shop_activated()
    {
        flush_rewrite_rules();
    }

    public function init()
    {
        remove_action('wp_head', 'rest_output_link_wp_head');
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
        remove_action('wp_head', 'start_post_rel_link');
        remove_action('wp_head', 'index_rel_link');
        remove_action('wp_head', 'adjacent_posts_rel_link');
        remove_action('wp_head', 'wp_shortlink_wp_head');
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
        remove_action('wp_head', 'noindex', 1);
        add_theme_support('title-tag');
        remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination');
        remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
        add_theme_support('post-thumbnails');
        add_image_size('loop', 500, '');
        add_image_size('single-post', 400, '', true);
        add_image_size('single-crouse', 1280, '720', true);
        register_nav_menus(
            array(
                'top-bar' => 'منو بالا',
                'main-menu' => 'منو اصلی',
            )
        );
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            )
        );
        add_action('set_comment_cookies', function ($comment, $user) {
            setcookie('ta_comment_wait_approval', '1', 0, '/');
        }, 10, 2);

        add_action('init', function () {
            if (isset($_COOKIE['ta_comment_wait_approval']) && $_COOKIE['ta_comment_wait_approval'] === '1') {
                setcookie('ta_comment_wait_approval', '0', 0, '/');
                add_action('comment_form_before', function () {
                    echo "<p id='success_comment' style='padding-top: 40px;' class='text-success'><strong>دیدگاه شما با موفقیت ثبت شد.</strong></p>";
                });
            }
        });

        add_filter('comment_post_redirect', function ($location, $comment) {
            $location = get_permalink($comment->comment_post_ID) . '#success_comment';
            return $location;
        }, 10, 2);
        add_action('init', array($this, 'fs_theme_init'));
    }

    public function fs_remove_default_images($sizes)
    {
        unset($sizes['small']);
        unset($sizes['medium']);
        unset($sizes['large']);
        unset($sizes['medium_large']);
        return $sizes;
    }

    public function fs_make_user_writer()
    {
        add_role('wf_writer', 'نویسنده پنل قالب',
            array(
                'read' => true,
                'upload_files' => true,
                'edit_pages' => true,
                'edit_posts' => true,
                'edit_post' => true,
                'edit_others_posts' => true,
                'edit_others_pages' => true,
                'edit_published_posts' => true,
                'edit_published_pages' => true
            ));
    }

    public function fs_notification_user()
    {
        $supports = array(
            'title',
            'editor',
            'custom-fields',
        );
        $labels = array(
            'name' => 'اطلاعیه ها',
            'singular_name' => 'اطلاعیه',
            'menu_name' => 'اطلاعیه',
            'name_admin_bar' => 'اطلاعیه',
            'add_new' => 'افزودن',
            'add_new_item' => 'اطلاعیه جدید',
            'new_item' => 'اطلاعیه جدید',
            'edit_item' => 'ویرایش اطلاعیه',
            'view_item' => 'نمایش اطلاعیه',
            'all_items' => 'همه اطلاعیه ها',
            'search_items' => 'جستجو اطلاعیه',
            'not_found' => 'اطلاعیه ای وجود ندارد',
        );
        $args = array(
            'supports' => $supports,
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'query_var' => true,
            'rewrite' => array('slug' => 'notification'),
            'has_archive' => true,
            'menu_icon' => 'dashicons-megaphone',
            'hierarchical' => false,
        );
        register_post_type('notification', $args);
    }

    public function fs_notification_guestes($content)
    {
        global $post;
        if ($post->post_type == 'notification') {
            if (!is_user_logged_in()) {
                $content = 'شما قادر به مشاهده این اطلاعیه نیستید.';
            }
        }
        return $content;
    }

    public function fs_widgets_init()
    {
        register_sidebar(
            array(
                'name' => 'سایدبار صفحه اصلی',
                'id' => 'sidebar-main',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );

        register_sidebar(
            array(
                'name' => 'سایدبار صفحه پست',
                'id' => 'sidebar-post',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );

        register_sidebar(
            array(
                'name' => 'سایدبار فروشگاه',
                'id' => 'sidebar-shop',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );

        register_sidebar(
            array(
                'name' => 'سایدبار آرشیو',
                'id' => 'sidebar-archive',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );

        register_sidebar(
            array(
                'name' => 'سایدبار صفحه محصول',
                'id' => 'sidebar-product',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );

        register_sidebar(
            array(
                'name' => 'سایدبار صفحات',
                'id' => 'sidebar-page',
                'description' => 'ویجت ها را اینجا اضافه کنید تا در نوار کناری ظاهر شوند.',
                'before_widget' => ' <div id="%1$s" class="card widget  %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="widget-title">',
                'after_title' => '</div>',
            )
        );
        register_widget('FS_Widget_Ad');
        register_widget('FS_Posts');
        register_widget('FS_Instagram');
    }

    public function fs_user_contactmethods($contact_methods)
    {
        $contact_methods['facebook'] = 'فیسبوک';
        $contact_methods['twitter'] = 'توئیتر';
        $contact_methods['instagram'] = 'اینستاگرام';
        $contact_methods['telegram'] = 'تلگرام';
        $contact_methods['google+'] = 'گوگل پلاس';
        return $contact_methods;
    }
    public function seacure_login_page()
    {
        global $page_id;
        $login_page = home_url();
        $page = basename($_SERVER['REQUEST_URI']);

        if ($page == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET') {
            wp_redirect($login_page);
            exit;
        }
    }

    public function fs_set_last_login($login, $user)
    {
        $user = get_user_by('login', $login);
        $time = current_time('timestamp');
        $last_login = get_user_meta($user->ID, '_last_login', 'true');

        if (!$last_login) {
            update_user_meta($user->ID, '_last_login', $time);
        } else {
            update_user_meta($user->ID, '_last_login_prev', $last_login);
            update_user_meta($user->ID, '_last_login', $time);
        }

    }

    public function fs_seacure_media($query)
    {
        $user_id = get_current_user_id();
        if ($user_id) {
            $query['author'] = $user_id;
        }
        return $query;
    }

    public function fs_like_shortcode()
    {
        return get_simple_likes_button(get_the_ID(), 0);
    }

    public function process_like_post()
    {
        $nonce = isset($_REQUEST['nonce']) ? sanitize_text_field($_REQUEST['nonce']) : 0;
        if (!wp_verify_nonce($nonce, 'simple-likes-nonce')) {
            exit(__('Not permitted', 'YourThemeTextDomain'));
        }
        $disabled = (isset($_REQUEST['disabled']) && $_REQUEST['disabled'] == true) ? true : false;
        $is_comment = (isset($_REQUEST['is_comment']) && $_REQUEST['is_comment'] == 1) ? 1 : 0;
        $post_id = (isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id'])) ? $_REQUEST['post_id'] : '';
        $result = array();
        $post_users = NULL;
        $like_count = 0;
        if ($post_id != '') {
            $count = ($is_comment == 1) ? get_comment_meta($post_id, "_comment_like_count", true) : get_post_meta($post_id, "_post_like_count", true); // like count
            $count = (isset($count) && is_numeric($count)) ? $count : 0;
            if (!already_liked($post_id, $is_comment)) { // Like the post
                if (is_user_logged_in()) { // user is logged in
                    $user_id = get_current_user_id();
                    $post_users = post_user_likes($user_id, $post_id, $is_comment);
                    if ($is_comment == 1) {
                        // Update User & Comment
                        $user_like_count = get_user_option("_comment_like_count", $user_id);
                        $user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
                        update_user_option($user_id, "_comment_like_count", ++$user_like_count);
                        if ($post_users) {
                            update_comment_meta($post_id, "_user_comment_liked", $post_users);
                        }
                    } else {
                        // Update User & Post
                        $user_like_count = get_user_option("_user_like_count", $user_id);
                        $user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
                        update_user_option($user_id, "_user_like_count", ++$user_like_count);
                        if ($post_users) {
                            update_post_meta($post_id, "_user_liked", $post_users);
                        }
                    }
                } else { // user is anonymous
                    $user_ip = sl_get_ip();
                    $post_users = post_ip_likes($user_ip, $post_id, $is_comment);
                    // Update Post
                    if ($post_users) {
                        if ($is_comment == 1) {
                            update_comment_meta($post_id, "_user_comment_IP", $post_users);
                        } else {
                            update_post_meta($post_id, "_user_IP", $post_users);
                        }
                    }
                }
                $like_count = ++$count;
                $response['status'] = "liked";
                $response['icon'] = get_liked_icon();
            } else { // Unlike the post
                if (is_user_logged_in()) { // user is logged in
                    $user_id = get_current_user_id();
                    $post_users = post_user_likes($user_id, $post_id, $is_comment);
                    // Update User
                    if ($is_comment == 1) {
                        $user_like_count = get_user_option("_comment_like_count", $user_id);
                        $user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
                        if ($user_like_count > 0) {
                            update_user_option($user_id, "_comment_like_count", --$user_like_count);
                        }
                    } else {
                        $user_like_count = get_user_option("_user_like_count", $user_id);
                        $user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
                        if ($user_like_count > 0) {
                            update_user_option($user_id, '_user_like_count', --$user_like_count);
                        }
                    }
                    // Update Post
                    if ($post_users) {
                        $uid_key = array_search($user_id, $post_users);
                        unset($post_users[$uid_key]);
                        if ($is_comment == 1) {
                            update_comment_meta($post_id, "_user_comment_liked", $post_users);
                        } else {
                            update_post_meta($post_id, "_user_liked", $post_users);
                        }
                    }
                } else { // user is anonymous
                    $user_ip = sl_get_ip();
                    $post_users = post_ip_likes($user_ip, $post_id, $is_comment);
                    // Update Post
                    if ($post_users) {
                        $uip_key = array_search($user_ip, $post_users);
                        unset($post_users[$uip_key]);
                        if ($is_comment == 1) {
                            update_comment_meta($post_id, "_user_comment_IP", $post_users);
                        } else {
                            update_post_meta($post_id, "_user_IP", $post_users);
                        }
                    }
                }
                $like_count = ($count > 0) ? --$count : 0; // Prevent negative number
                $response['status'] = "unliked";
                $response['icon'] = get_unliked_icon();
            }
            if ($is_comment == 1) {
                update_comment_meta($post_id, "_comment_like_count", $like_count);
                update_comment_meta($post_id, "_comment_like_modified", date('Y-m-d H:i:s'));
            } else {
                update_post_meta($post_id, "_post_like_count", $like_count);
                update_post_meta($post_id, "_post_like_modified", date('Y-m-d H:i:s'));
            }
            $response['count'] = get_like_count($like_count);
            $response['testing'] = $is_comment;
            if ($disabled == true) {
                if ($is_comment == 1) {
                    wp_redirect(get_permalink(get_the_ID()));
                    exit();
                } else {
                    wp_redirect(get_permalink($post_id));
                    exit();
                }
            } else {
                wp_send_json($response);
            }
        }
    }

    public function fs_theme_init()
    {
        $settings = [
            'name' => '<strong>قالب فکت شاپ</strong>',
            'product_token' => 'b2d00ed8-de32-4631-8ef5-d930c5bccb6d',
            'parent_slug' => 'themes.php',
        ];
        FS_Init::instance($settings);
        if (FS_Init::is_activated() !== true) {
            if (is_admin()) {
                $black_list = array('factshop-options',);
                if (isset($_GET['page']) && in_array($_GET['page'], $black_list)) {
                    if (isset($_GET['page']) && $_GET['page'] == 'zhk_guard_register') {
                        return;
                    }
                    wp_die('لطفا کلید لایسنس <strong>قالب فکت شاپ</strong> را وارد نمایید.');
                }
                if (isset($_GET['post_type']) && get_post_type($_GET['post_type']) == 'notification') {
                    wp_die('لطفا کلید لایسنس <strong>قالب فکت شاپ</strong> را وارد نمایید.');
                }
            }
        }
    }

}