<?php

namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

/*
 *  Elementor widget for Skill Info
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Skill extends Widget_Base {
	
	public function get_name() {
		return 'factshop-skill';
	}
	
	public function get_title() {
		return __( 'اطلاعات مهارت', 'bako' );
	}
	
	public function get_icon() {
		return 'eicon-skill-bar';
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
				'default' => __( 'طراحی سایت', 'factshop' ),
				'placeholder' => __( 'عنوان مهارت را وارد کنید', 'factshop' )
			]
		);
		
		$this->add_control(
			'value',
			[
				'label' => __( 'Value', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '50', 'factshop' ),
				'placeholder' => __( 'مقدار مهارت را وارد کنید', 'bako' )
			]
		);
		
		$this->add_control(
			'symbol',
			[
				'label' => __( 'نماد', 'factshop' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( '%', 'factshop' ),
				'placeholder' => __( 'نماد مهارت را وارد کنید', 'factshop' )
			]
		);

		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<!-- skill item -->
		<div class="skill-item">
			<?php if( $settings['title'] || $settings['value'] ) { ?>
			<div class="skill-info clearfix">
				<?php if( $settings['title'] ) { ?>
				<h4 class="float-right mb-3 mt-0"><?php echo esc_attr($settings['title']); ?></h4>
				<?php } ?>
				<?php if( $settings['value'] ) { ?>
				<span class="float-left"><?php echo esc_attr($settings['value']) . esc_attr($settings['symbol']); ?></span>
				<?php } ?>
			</div>
			<?php } ?>
			<?php if( $settings['value'] ) { ?>
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?php echo esc_attr($settings['value']); ?>">
				</div>
			</div>

			<?php } ?>
		</div>
		<?php
	}
	
	protected function _content_template() {
		?>
		<!-- skill item -->
		<div class="skill-item">
			<# if( settings.title || settings.value ) { #>
			<div class="skill-info clearfix">
				<# if( settings.title ) { #>
				<h4 class="float-left mb-3 mt-0">{{{ settings.title }}}</h4>
				<# } #>
				<# if( settings.value ) { #>
				<span class="float-right">{{{ settings.value }}}{{{ settings.symbol }}}</span>
				<# } #>
			</div>
			<# } #>
			<# if( settings.value ) { #>
			<div class="progress">
				<div class="progress-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ settings.value }}">
				</div>
			</div>
			<# } #>
		</div>
		<?php
	}
}
?>