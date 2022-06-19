<?php

namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;

/*
 *  Elementor widget for Timeline
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Timeline extends Widget_Base {
	
	public function get_name() {
		return 'factshop-timeline';
	}
	
	public function get_title() {
		return __( 'نوار وضعیت', 'factshop' );
	}
	
	public function get_icon() {
		return 'eicon-time-line';
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
		
		$repeater = new Repeater();
		
		$repeater->add_control(
			'title',
			[
				'label' => __( 'عنوان', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '1398-1399', 'factshop' ),
				'placeholder' => __( 'عنوان را وارد کنید', 'factshop' )
			]
		);
		
		$repeater->add_control(
			'text',
			[
				'label' => __( 'عنوان اصلی', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'استارت شرکت', 'factshop' ),
				'placeholder' => __( 'عنوان اصلی را وارد کنید', 'bako' )
			]
		);

		$repeater->add_control(
			'description',
			[
				'label' => __( 'توضیح وضعیت', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. ', 'factshop' ),
				'placeholder' => __( 'توضیح را وارد کنید', 'factshop' )
			]
		);
		
		$this->add_control(
		    'timeline',
		    [
		        'label' => __( 'نوار وضعیت', 'factshop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
	        ]
	    );

		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<div class="timeline">
		    
		    <?php foreach($settings['timeline'] as $time) : ?>
			<div class="entry">
				<?php if( $time['title'] ) { ?>
				<div class="title">
					<span><?php echo esc_attr($time['title']); ?></span>
				</div>
				<?php } ?>
				<?php if( $time['text'] || $time['description'] ) { ?>
				<div class="body">
					<?php if( $time['text'] ) { ?>
					<h4 class="mt-0"><?php echo esc_attr($time['text']); ?></h4>
					<?php } ?>
					<?php if( $time['description'] ) { ?>
					<p><?php echo esc_attr($time['description']); ?></p>
					<?php } ?>
				</div>
				<?php } ?>
			</div>
			<?php endforeach; ?>
			
			<span class="timeline-line"></span>
		</div>
		<?php
	}
	
	protected function _content_template() {
		?>
		<div class="timeline">
		    <# _.each(settings.timeline, function(item) { #>
		    
			<div class="entry">
				<# if( item.title ) { #>
				<div class="title">
					<span>{{{ item.title }}}</span>
				</div>
				<# } #>
				<# if( item.text || item.description ) { #>
				<div class="body">
					<# if( item.text ) { #>
					<h4 class="mt-0">{{{ item.text }}}</h4>
					<# } #>
					<# if( item.description ) { #>
					<p>{{{ item.description }}}</p>
					<# } #>
				</div>
				<# } #>
			</div>
			
		    <# }); #>
			
			<span class="timeline-line"></span>
		</div>
		<?php
	}
}
?>