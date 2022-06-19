<?php


class FS_Customize
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', array($this, 'Customize'));
    }
    public function Customize(){
        $args = array(
            'body' => array(
                'background-color' => 'back-color',
                'color' => 'text-color',
            ),
            '.slick-dots li.slick-active button:before,.price-item.recommended,.service-item:hover,button.ok-btn,.btn-primary,.card-title h3,.badge-primary,.main-nav ul>li:hover,.scroll-top,.bg-primary' => array(
                'background-color' => 'primary-color',
            ),
            '.service-item:hover,.btn-primary,.sidbar .widget-title:before,.main-nav>li>a:hover,.fw-title,.scroll-top,.user-nav .nav-item.active a,ul#last-announcements .unread_post a,div#product-gallery ol.carousel-indicators li.active' => array(
                'border-color' => 'primary-color',
            ),
            'ul.my-acount-menus li a:hover, ul.my-acount-menus li.is-active a' => array(
                'border-right-color' => 'primary-color',
            ),
            '.testimonial-item .symbol,.icon-simple,.main-nav>li>a:hover,.profile-menu li a:hover,.text-primary,.fw-title,ul.my-acount-menus li a:hover,ul#last-announcements .unread_post h6, ul.my-acount-menus li.is-active a,.user-nav .nav-item a:hover,.user-nav .nav-item.active a,ul.pagination>li>a:hover, ul.pagination>li>span.current, .page-numbers>li>a:hover, .page-numbers>li>span.current' => array(
                'color' => 'primary-color',
            ),

        );
        $css = $this->customize_css($args);
        if (cs_get_option('is_image_size_product') && cs_get_option('image_size_height_product')) {
            $prheight = (int) cs_get_option('image_size_height_product');
            $prhover = $prheight - 20;
            $css .= "
            .post.product header {
                height: {$prheight}px !important;
            }
            .post.product:hover header {
                height: {$prhover}px !important;
            }
           ";
        }
        if (cs_get_option('is_image_size_post') && cs_get_option('image_size_height_post')) {
            $poheight = (int) cs_get_option('image_size_height_post');
            $pohover = $poheight - 20;
            $css .= "
            .post header {
                height: {$poheight}px !important;
            }
            .post:hover header {
                height: {$pohover}px !important;
            }
           ";
        }
        if (cs_get_customize_option('primary-color')) {
            $css .= ".service-item:hover i{color:white !important;}.panel-user header {
                    background-color: ".cs_get_customize_option('primary-color')." ;
                    background: linear-gradient(180deg,#0009a4 0,".cs_get_customize_option('primary-color')." 100%) !important;
                }
                .btn-primary{box-shadow:none !important;}
                .price-item.recommended a.btn.btn-primary {
                    background-color: white !important;
                    border-color: white !important;
                    color: ".cs_get_customize_option('primary-color').";
                }
                .woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
                    color: white;
                }";
        }
        if (cs_get_customize_option('flat_site')) {
            $css .= ".dokan-panel, .dashboard-widget,ul#last-announcements a,.card,#main-menu,.user-nav,footer.bg-white.shadow-sm,ul.share-menu,.footer-widgets{ box-shadow : none !important;} .post:hover {box-shadow: 0px 0px 29px 0px rgba(0, 123, 255, 0.1) !important;}";
        }
        if (cs_get_customize_option('product_card') == 'two') {
            $color = (!empty(cs_get_customize_option('product-hover-btn'))) ? cs_get_customize_option('product-hover-btn') : "#007bff" ;
            $css .= '.post.product.card .post-meta {
                        border-top: 1px solid rgba(0, 0, 0, 0.05);
                        padding: 0;
                    }
                    .post.product.card .post-meta a {
                        width: 50%;
                        padding: 14px 8px;
                        border-left: 1px solid rgba(0, 0, 0, 0.05);
                        text-align: center;
                        margin: 0;
                    }
                    .post.product.card .post-meta a:hover {
                        background-color: '.$color.';
                        color: white !important;
                    }
                    .post.product.card .post-meta a:last-child {
                        border: 0;
                        border-radius: 0 0 0 6px;
                    }
                    .post.product.card .post-meta a:first-child {
                        border-radius: 0 0 6px 0;
                    }';
        }
        if (cs_get_customize_option('product_card') == 'three') {
            $color = (!empty(cs_get_customize_option('product-hover-btn'))) ? cs_get_customize_option('product-hover-btn') : "#007bff" ;
            $css .= '.post.product.card .post-meta a:last-child {
                        display: none;
                    }
                    .post.product.card .post-meta a:first-child {
                        width: 100%;
                        border: 0;
                        text-align: center;
                        margin: 0;
                    }
                    .post.product.card:hover .post-meta a:first-child {
                        background-color: '.$color.';
                        color: white !important;
                    }
                    .post.product.card .post-meta {
                        padding: 0;
                        margin: 0;
                    }';
        }
        if (cs_get_customize_option('post_card') == 'two') {
            $color = (!empty(cs_get_customize_option('post-hover-btn'))) ? cs_get_customize_option('post-hover-btn') : "#007bff" ;
            $css .= '.posts .post.card .post-meta {
                        padding: 0;
                    }
                    .posts .post.card .post-meta a {
                        display: none;
                    }
                    .posts .post.product.card .post-meta a {
                        display: inline-block;
                    }
                    .posts .post.card .post-meta a.more {
                        display: block;
                        text-align: center;
                        width: 100%;
                    }
                    .posts .post.card:hover .post-meta a.more {
                        background-color: '.$color.';
                        color: white !important;
                    }';
        }
        if (!empty(cs_get_customize_option('card_radius'))) {
            $css .= '.dokan-panel, .dashboard-widget,.card,.carousel-inner,ul.share-menu,div#product-gallery ol.carousel-indicators li{border-radius:'.cs_get_customize_option('card_radius').'px !important}
            .post header{border-radius:'.cs_get_customize_option('card_radius').'px '.cs_get_customize_option('card_radius').'px 0 0 !important}
            ul.my-acount-menus li:first-child a {
                border-radius: '.cs_get_customize_option('card_radius').'px '.cs_get_customize_option('card_radius').'px 0 0 !important;
            }
            ul.my-acount-menus li:last-child a {
                border-radius: 0px 0px '.cs_get_customize_option('card_radius').'px '.cs_get_customize_option('card_radius').'px !important;
            }';
            if (cs_get_customize_option('product_card') == 'two') {
                $css .= '.post.product.card .post-meta {
                            border-radius: 0 0 20px 20px;
                        }
                        .post.product.card .post-meta a:first-child {
                            border-radius: 0 0 '.cs_get_customize_option('card_radius').'px 0 !important;
                        }
                        .post.product.card .post-meta a:last-child {
                            border-radius: 0 0 0 '.cs_get_customize_option('card_radius').'px !important;
                        }';
            }
            if (cs_get_customize_option('widget_title') == 'two') {
                $color = (!empty(cs_get_customize_option('primary-color'))) ? cs_get_customize_option('primary-color') : "#007bff" ;
                $css .= '.sidebar .widget-title {
                            color: white;
                            padding: 20px !important;
                            background: '.$color.';
                        }
                       
                        .sidebar .widget-title:before {
                            display: none;
                        }';
            }
            if (cs_get_customize_option('product_card') == 'three') {
                $css .= '.post.product.card .post-meta a:first-child {
                            border-radius: 0 0 '.cs_get_customize_option('card_radius').'px '.cs_get_customize_option('card_radius').'px !important;
                        }
                        .post.product.card .post-meta {
                            border-radius: 0 0 '.cs_get_customize_option('card_radius').'px '.cs_get_customize_option('card_radius').'px;
                        }';
            }
        }
        if (cs_get_customize_option('block_title') == 'two') {
            $backcolor = (!empty(cs_get_customize_option("back-color"))) ? cs_get_customize_option("back-color") : "rgba(249,248,248,.55)";
            $css .= '.card-title {
                        background: none !important;
                        box-shadow: none !important;
                    }
                    .card-title h3 {
                        background-color: '.$backcolor.' !important;
                        color: #495057 !important;
                        font-size: 20px !important;
                    }
                    .card-title a {
                        background-color: '.$backcolor.' !important;
                    }
                    .card.card-title:before {
                        border-color: rgba(73, 80, 87, 0.43) !important;
                    }
                    ';
        }
        if(is_user_logged_in()){
            $css .= '.card.panel-user header:before 
                    {content: "";
                    width: 100%;height: 100%;
                    background-image: url('.get_avatar_url(get_current_user_id()).');
                    position: absolute;opacity: 0.3;
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center center;
                    }
                    .card.panel-user header {
                        overflow: hidden;
                    }';
        }
        wp_register_style( 'factshop-customize', false );
        wp_enqueue_style( 'factshop-customize' );
        wp_add_inline_style('factshop-customize', $css);

    }

    function customize_css($args){
        if (!is_array($args)) return false;
        $css = "";
        foreach ($args as $arg => $opt){
            $css .=  $arg . "{";
            foreach($opt as $key =>$val) {
                if (!empty(cs_get_customize_option($val))) {
                    $css .= $key . ":" . cs_get_customize_option($val)." !important;";
                }
            }
            $css .=  "}";
        }
        return $css;
    }
}