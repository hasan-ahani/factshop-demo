<?php

namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/*
 *  Elementor widget for Section Title
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Title extends Widget_Base {
	
	public function get_name() {
		return 'factshop-section-title';
	}
	
	public function get_title() {
		return __( 'عنوان بلاک', 'factshop' );
	}
	
	public function get_icon() {
		return 'eicon-post-title';
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
			'title',
			[
				'label' => __( 'عنوان', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'دیدگاه مشتریان', 'factshop' ),
				'placeholder' => __( 'عنوان را وارد کنید', 'factshop' )
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<h3 class="section-title"><?php echo esc_attr($settings['title']); ?></h3>
		<?php
	}
	
	protected function _content_template() {
		?>
		<h3 class="section-title">{{{ settings.title }}}</h3>
		<?php
	}
}
?>