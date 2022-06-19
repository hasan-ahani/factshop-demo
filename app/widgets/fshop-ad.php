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

class Ads extends Widget_Base {
	
	public function get_name() {
		return 'factshop-ad';
	}
	
	public function get_title() {
		return __( 'تبلیغات', 'factshop' );
	}
	
	public function get_icon() {
		return 'eicon-accordion';
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
            'image',
            [
                'label' => __( 'تصویر', 'factshop' ),
                'type' => Controls_Manager::MEDIA
            ]
        );
        $this->add_control(
			'link',
			[
				'label' => __( 'لینک', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'لینک را وارد کنید', 'factshop' )
			]
		);


		$this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings();
		?>
        <div class="card ads mb-4">
            <a href="<?php echo ($settings['link']) ? $settings['link'] : 'javascript:;'; ?>"><img
                        src="<?php echo $settings['image']['url']; ?>"/></a>
        </div>
		<?php
	}
	
	protected function _content_template() {
		?>
        <div class="card ads mb-4">
            <a href="{{{ settings.link }}}">
                <img src="{{{ settings.image.url }}}" alt="ads" />
            </a>
        </div>
		<?php
	}
}
?>