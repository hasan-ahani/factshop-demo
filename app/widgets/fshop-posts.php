<?php
namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


/*
 *  Elementor icons widget
 *  @since 1.0
 */ 
 
class Posts extends Widget_Base {
    
    public function get_name() {
        return 'factshop-posts';
    }
    
    public function get_title() {
        return __( 'بلاک پست', 'factshop' );
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
				'default' => 'آخرین مطالب',
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
				'label' => __( 'تعداد مطلب', 'factshop' ),
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
                'options' => get_fs_terms('category','post'),
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
            $args = array( 'post_type' => 'post', 'posts_per_page' => $element_settings['pre-page'],'cat' =>$element_settings['category'] );
			$query = new \WP_Query( $args );
			if ($query->have_posts()) :
			while ($query->have_posts()) : $query->the_post();
                    $settings = get_post_meta(get_the_ID(),'fs_post_settings');
                    if(isset($settings) && $settings != null){
                        $settings = $settings[0];
                    }
                    ?>
                    <article class="col-md-6 col-sm-12 <?php echo 'col-lg-'.$element_settings['col'].' col-xl-'.$element_settings['col'];?>">
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
        </div>

		<?php wp_reset_postdata(); ?>


        <?php
	}

}

?>