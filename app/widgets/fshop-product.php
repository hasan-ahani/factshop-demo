<?php
namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*
 *  Elementor icons widget
 *  @since 1.0
 */ 
 
class Products extends Widget_Base {
    
    public function get_name() {
        return 'factshop-products';
    }
    
    public function get_title() {
        return __( 'بلاک محصولات', 'factshop' );
    }
    
    public function get_icon() {
        return 'eicon-posts-grid';
    }
    
    public function get_categories() {
		return [ 'factshop-elements' ];
	}
	
	protected function _register_controls() {

		$this->start_controls_section(
		    'content',
		    [
		        'label' => __( 'محتوا', 'factshop' )
		    ]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'عنوان', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'آخرین محصول',
			]
		);
		$this->add_control(
			'show-title',
			[
				'label' => __( 'نمایش عنوان', 'factshop' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'نمایش', 'factshop' ),
				'label_off' => __( 'مخفی', 'factshop' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
        $this->add_control(
            'col',
            [
                'label' => __( 'تعداد ستون', 'factshop' ),
                'type' => Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '12'  => __( '1', 'factshop' ),
                    '6'  => __( '2', 'factshop' ),
                    '4'  => __( '3', 'factshop' ),
                    '3'  => __( '4', 'factshop' ),
                    '2'  => __( '6', 'factshop' ),
                ],
            ]
        );
		$this->add_control(
			'pre-page',
			[
				'label' => __( 'تعداد محصول', 'factshop' ),
				'type' => Controls_Manager::NUMBER,
				'default' => '8',
			]
		);
		$this->add_control(
			'category',
			[
				'label' => __( 'دسته بندی', 'factshop' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => get_fs_terms('product_cat','product'),
			]
		);

		$this->end_controls_section();
		
	}
	
	protected function render() {
	    $element_settings = $this->get_settings();
        if('yes' == $element_settings['show-title']):?>
        <div class="card card-title mb-4">
            <div class="row">
                <div class="col-7"><h3><?php echo $element_settings['title'];?></h3></div>
            </div>
        </div>
        <?php endif;?>
        <div class="posts row">
            <?php
            $cat = $element_settings['category'];
            if(empty($cat)){
                $args = array('post_type' => 'product', 'posts_per_page' => $element_settings['pre-page'], 'orderby' => 'time');
            }else{
                $args = array('post_type' => 'product', 'posts_per_page' => $element_settings['pre-page'], 'orderby' => 'time',
                    'tax_query'     => array(
                        array(
                            'taxonomy'  => 'product_cat',
                            'field'     => 'id',
                            'terms'     => $cat
                        )
                    )
                );
            }
			$query = new \WP_Query( $args );
			if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                    if(isset($settings) && $settings != null){
                        $settings = $settings[0];
                    }
                    global $product;
                    ?>
                    <article class="col-md-6 col-sm-12 <?php echo 'col-lg-'.$element_settings['col'].' col-xl-'.$element_settings['col'];?>">
                        <div class="post product card">
                            <header>
                                <a href="<?php echo get_permalink($query->post->ID) ?>"
                                   title="<?php echo esc_attr($query->post->post_title ? $query->post->post_title : $query->post->ID); ?>">
                                    <?php if (has_post_thumbnail($query->post->ID)) echo get_the_post_thumbnail($query->post->ID, 'loop'); else echo '<img src="' . WF_URI . '/assets/img/nopic.png"'; ?>

                                </a>
                            </header>

                            <div class="post-detail">
                                <a href="<?php echo get_permalink($query->post->ID) ?>"><h2><?php the_title(); ?></h2></a>
                                <b class="price"><?php echo $product->get_price_html(); ?></b>
                                <?php if (cs_get_option('show-product-sales')): ?>
                                        <b class="sales"><?php echo get_post_meta( $query->ID, 'total_sales', true ); ?> <?php echo cs_get_option('translate-sale','فروش');?> </b>
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
                                <?php $previewonline =   get_post_meta($query->post->ID, 'previewonline', true);
                                if(isset($previewonline) &&  $previewonline != ''):?>
                                    <a href="<?php echo $previewonline;?>" target="_blank" class="product-show"><?php echo cs_get_option('translate-preview','پیشنمایش آنلاین');?></a>
                                <?php endif;?>
                            </div>
                        </div>
                    </article>
                <?php
                endwhile; ?>
            <?php else: ?>
                <div class="col-md-12">
                    <div class="card p-3 mb-4"><?php echo cs_get_option('translate-noproduct','محصولی وجود ندارد');?></div>
                </div>
            <?php endif; ?>
        </div>

		<?php wp_reset_postdata(); ?>


        <?php
	}

}

?>