<?php
if ( ! defined( 'ABSPATH' ) )
    die( 'Fizzle' );

class FS_Woocommerce
{
    public function __construct()
    {
        add_action( 'after_setup_theme', array($this,'woocommerce_support') );
        add_filter('loop_shop_columns', array($this,'loop_columns'), 999);
        remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
        add_action('woocommerce_before_shop_loop_item_title', array($this,'wf_product_thumbnail'), 10);
        if(!cs_get_option('show-product-first-tab')){
            add_filter('woocommerce_product_tabs', array($this,'fs_product_tab'));

        }

        add_action('template_redirect' , array($this, 'my_account_redirect'));
        if (is_user_logged_in()) {
            global $current_user;
            $user_role = $current_user->roles;
            if (in_array('wf_writer',$user_role)  or in_array('administrator',$user_role)) {
                if ($user_role == 'wf_writer') show_admin_bar(false);
                add_filter('woocommerce_account_menu_items', array($this,'fs_account_menu_writer'), 87, 1);
                add_action('woocommerce_init', array($this,'fs_account_menu_writer_endpoint'), 0);
                add_action('woocommerce_account_myposts_endpoint', array($this,'fs_myposts_endpoint_content'));
                add_action('woocommerce_account_sendpost_endpoint', array($this,'fs_sendpost_endpoint_content'));
                add_action('wp_head', array($this,'fs_edit_roles'));
            }
            add_filter('woocommerce_account_menu_items', array($this,'fs_account_menu_public'), 87, 1);
            add_action('woocommerce_init', array($this,'fs_account_menu_public_endpoint'), 0);
            add_action('woocommerce_account_favorites_endpoint', array($this,'fs_sendpost_favorites_content'));
            add_action('woocommerce_account_announcements_endpoint', array($this,'fs_announcements_content'));
        }

        add_action('woo_wallet_before_my_wallet_content', function () {
            remon_breadcrumbs();
            echo '<div class="card p-4 mt-4">';
        }, 20);

        add_action('woo_wallet_after_my_wallet_content', function () {
            echo '</div>';
        }, 20);
        add_filter('woocommerce_form_field', array($this,'customize_woocommerce_form_field'));
        add_filter('woocommerce_default_catalog_orderby', array($this,'custom_default_catalog_orderby'));
        add_filter( 'woocommerce_show_page_title' , array($this,'woo_hide_page_title') );
        add_filter('woocommerce_login_redirect', array($this,'fs_login_redirect'));
        add_action('wp_logout', array($this,'fs_logout_redirect'));

        add_filter( 'woocommerce_checkout_fields' , array($this,'fs_custom_remove_woo_checkout_fields') );
        if(cs_get_option('user_can_change_email')){
            add_filter('woocommerce_save_account_details_required_fields', array($this,'remove_required_email_address'));
        }

        add_filter ( 'woocommerce_account_menu_items', array($this,'fs_remove_my_account_links'),99 );
    }
    public function fs_remove_my_account_links( $menu_links ){

        $menus = cs_get_option('user_panel_menu_items');
        if(is_array($menus)){
            foreach($menu_links as $key => $val){
                if(!in_array($key,$menus)){
                    unset($menu_links[$key]);
                }
            }
        }
        return $menu_links;
    }

    function remove_required_email_address( $required_fields ) {
        unset($required_fields['account_email']);

        return $required_fields;
    }
    function fs_custom_remove_woo_checkout_fields( $fields ) {
        $billing_default = array(
            'billing_first_name',
            'billing_last_name',
            'billing_company',
            'billing_address_1',
            'billing_address_2',
            'billing_city',
            'billing_postcode',
            'billing_country',
            'billing_state',
            'billing_phone',
            'order_comments',
            'billing_email'
        );
        $billing = cs_get_option('woo-checkout-billing-fields');
        if(is_array($billing)){
            foreach($billing_default as $key){
                if(!in_array($key,$billing)){
                    unset($fields['billing'][$key]);
                }
            }
            if(!in_array('order_comments',$billing)){
                unset($fields['order']['order_comments']);
            }
        }
        $shipping_default = array(
            'shipping_first_name',
            'shipping_last_name',
            'shipping_company',
            'shipping_country',
            'shipping_state',
            'shipping_city',
            'shipping_address_1',
            'shipping_address_2',
            'shipping_postcode',
        );
        $shipping = cs_get_option('woo-checkout-shipping-fields');
        if(is_array($shipping)){
            foreach($shipping_default as $key){
                if(!in_array($key,$shipping)){
                    unset($fields['billing'][$key]);
                }
            }
        }
        return $fields;
    }

    public function my_account_redirect(){
        if (!is_user_logged_in() && is_account_page()) {
            wp_redirect(home_url('login'));
            exit;
        }
    }

    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    public function loop_columns() {
        return 3;
    }

    public function wf_product_thumbnail()
    {
        echo $this->wf_get_product_thumbnail();
    }

    public function wf_get_product_thumbnail()
    {
        global $post;
        $output = '<header>';
        $output .= '<a href="' . get_permalink($post->ID) . '">';
        if (has_post_thumbnail()) {
            $output .= get_the_post_thumbnail($post->ID, 'loop');
        }
        $output .= '</a>';
        $output .= '</header><div class="post-detail">';
        return $output;
    }


    public function fs_product_tab($tabs)
    {
        $tabs['info_product_tab'] = array(
            'title' => 'جزئیات محصول',
            'priority' => 1,
            'callback' => array($this ,'fs_product_tab_content')
        );
        return $tabs;

    }

    public function fs_product_tab_content()
    {
        woocommerce_template_single_title();
        if (cs_get_option('show-product-img-little')){
            the_post_thumbnail('single-post', array('class' => 'product-left-img'));
        }
        woocommerce_template_single_excerpt();
    }
    public function fs_account_menu_public($items)
    {
        $my_items['favorites'] = "علاقه مندی ها";
        $my_items['announcements'] = "اطلاعیه ها";
        $my_items = array_slice($items, 0, 5, true) +
            $my_items +
            array_slice($items, 1, count($items), true);


        return $my_items;
    }

    public function fs_account_menu_public_endpoint()
    {
        add_rewrite_endpoint('favorites', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('announcements', EP_ROOT | EP_PAGES);
    }

    public function fs_account_menu_writer($items)
    {
        $my_items = array(
            'sendpost' => "ارسال پست",
            'myposts' => "پست ها من",
        );
        $my_items = array_slice($items, 0, 5, true) +
            $my_items +
            array_slice($items, 1, count($items), true);

        return $my_items;
    }

    public function fs_account_menu_writer_endpoint()
    {
        add_rewrite_endpoint('sendpost', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('myposts', EP_ROOT | EP_PAGES);
    }

    public function fs_edit_roles(){
        if ( current_user_can( 'edit_posts' ) ){
            $user = new WP_User(get_current_user_id());
            $user->add_cap('edit_post');
            $user->add_cap('edit_others_pages');
            $user->add_cap('edit_published_pages');
        }
    }

    public function fs_sendpost_favorites_content()
    {
        get_template_part('template/user/favorites');
    }

    public function fs_myposts_endpoint_content(){
        get_template_part('template/user/mypost');
    }

    public function fs_sendpost_endpoint_content()
    {
        get_template_part('template/user/sendpost');
    }
    public function fs_announcements_content()
    {
        get_template_part('template/user/announcements');
    }

    public function customize_woocommerce_form_field($field)
    {
        return preg_replace(
            '#<p class="form-row (.*?)"(.*?)>(.*?)</p>#',
            '<div class="form-group $1 test"$2>$3</div>',
            $field
        );
    }

    public function custom_default_catalog_orderby() {
        return 'date';
    }

    public function woo_hide_page_title() {
        return false;
    }


    public function fs_login_redirect($redirect_to)
    {
        return home_url();
    }

    public function fs_logout_redirect()
    {
        wp_redirect(home_url());
        exit;
    }

}