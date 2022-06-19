<?php
namespace FshopBuilder;

use FshopBuilder\Widgets\Ads;
use FshopBuilder\Widgets\Button;
use FshopBuilder\Widgets\Clients;
use FshopBuilder\Widgets\Bako_Contact;
use FshopBuilder\Widgets\Icon;
use FshopBuilder\Widgets\Portfolio;
use FshopBuilder\Widgets\Posts;
use FshopBuilder\Widgets\Price;
use FshopBuilder\Widgets\Products;
use FshopBuilder\Widgets\Service;
use FshopBuilder\Widgets\Skill;
use FshopBuilder\Widgets\Testimonial;
use FshopBuilder\Widgets\Timeline;
use FshopBuilder\Widgets\Title;

if ( ! defined( 'ABSPATH' ) ) exit;


class FS_Elementor {
	public function __construct() {
		$this->add_actions();
	}

	private function add_actions() {
		add_action( 'elementor/controls/controls_registered', [ $this, 'register_controls' ] );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
	}
	public function on_widgets_registered() {
		$this->includes();
		$this->register_widget();
	}

	private function includes() {
		require __DIR__ . '/widgets/fshop-button.php';
		require __DIR__ . '/widgets/fshop-clients.php';
		require __DIR__ . '/widgets/fshop-contact.php';
		require __DIR__ . '/widgets/fshop-icon.php';
		require __DIR__ . '/widgets/fshop-posts.php';
		require __DIR__ . '/widgets/fshop-product.php';
		require __DIR__ . '/widgets/fshop-price.php';
		require __DIR__ . '/widgets/fshop-ad.php';
		require __DIR__ . '/widgets/fshop-service.php';
		require __DIR__ . '/widgets/fshop-skill.php';
		require __DIR__ . '/widgets/fshop-testimonial.php';
		require __DIR__ . '/widgets/fshop-timeline.php';
		require __DIR__ . '/widgets/fshop-title.php';
	}

	private function register_widget() {
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Button() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Clients() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Bako_Contact() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Icon() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Posts() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Products() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Price() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Ads() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Service() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Skill() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Timeline() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Title() );
	}
	
	public function init_controls() {
	}
	
	public function register_controls() {
	}



}


new FS_Elementor();