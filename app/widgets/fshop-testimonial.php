<?php

namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/*
 *  Elementor widget for Testimonial
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Testimonial extends Widget_Base {
	
	public function get_name() {
		return 'factshop-testimonial';
	}
	
	public function get_title() {
		return __( 'دیدگاه مشتریان', 'factshop' );
	}
	
	public function get_icon() {
		return 'eicon-posts-carousel';
	}
	
	public function get_categories() {
		return ['factshop-elements'];
	}
	
	protected function _register_controls() {
		$this->start_controls_section(
			'content',
			[
				'label' => __( 'محتوا', 'factshop' ),
			]
		);

        $this->add_control(
            'num',
            [
                'label' => __( 'تعداد دیدگاه', 'factshop' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '5',
            ]
        );


		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<div class="row testimonials-wrapper">
                <?php
                $args = array(
                    'orderby' => array('comment_date'),
                    'order' => 'DESC',
                    'number' => $settings['num']
                );
                $comment = get_comments($args);
                ?>
                <?php foreach($comment as $item) : ?>
                    <div class="col-md-6">
                        <!-- testimonial item -->
                        <div class="testimonial-item">
                            <span class="symbol"><i class="fas fa-quote-left"></i></span>
                            <?php if( $item->comment_content ) { ?>
                                <p><?php echo esc_attr($item->comment_content); ?></p>
                            <?php } ?>
                            <div class="testimonial-details">
                                    <div class="thumb">
                                        <img src="<?php echo get_avatar_url($item->comment_author_email); ?>" alt="<?php echo $item->comment_author; ?>" />
                                    </div>
                                    <div class="info">
                                            <h4><?php echo esc_attr($item->comment_author); ?></h4>
                                            <span><?php echo esc_attr($item->comment_date); ?></span>
                                    </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
		</div>
		<?php
	}
	

}
?>