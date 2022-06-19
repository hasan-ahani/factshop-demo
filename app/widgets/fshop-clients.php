<?php

namespace FshopBuilder\Widgets;

use Elementor\Widget_Base;
use Elementor\Repeater;
use Elementor\Controls_Manager;

/*
 *  Elementor widget for Clients
 *  @since 1.0
 */ 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Clients extends Widget_Base {
	
	public function get_name() {
		return 'factshop-clients';
	}
	
	public function get_title() {
		return __( 'مشتریان', 'factshop' );
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
		
		$repeater = new Repeater();
		
		$repeater->add_control(
			'image',
			[
				'label' => __( 'تصویر', 'factshop' ),
				'type' => Controls_Manager::MEDIA
			]
		);
		
		$this->add_control(
			'clients',
			[
				'label' => __( 'آیتم مشتری', 'factshop' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		if( $settings['clients'] ) { 
		?>
		<!-- clients wrapper -->
    	<div class="clients-wrapper row">
    		<?php foreach ( $settings['clients'] as $item ) : if( $item['image']['url'] ) : ?>
    		<div class="col-md-3">
    			<!-- client item -->
    			<div class="client-item">
    				<div class="inner">
    					<img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr('client-name', 'bako'); ?>" />
    				</div>
    			</div>
    		</div>
    		<?php endif; endforeach; ?>
    	</div>
		<?php
		}
	}
	
	protected function _content_template() {
		?>
		<# if( settings.clients ) { #>
		<!-- clients wrapper -->
		<div class="clients-wrapper row">
			<# _.each( settings.clients, function( item ) { #>
			<# if( item ) { #>
			<div class="col-md-3">
				<!-- client item -->
				<div class="client-item">
					<div class="inner">
						<img src="{{{ item.image.url }}}" alt="client-name" />
					</div>
				</div>
			</div>
			<# } #>
			<# }); #>
		</div>
		<# } #>
		<?php
	}
}
?>