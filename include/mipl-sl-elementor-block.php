<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}


// Login Form Widget
class MIPL_SL_Stockist_Widget extends \Elementor\Widget_Base {

    
    public function get_name() {
		return 'stockist_stores';
	}

	
	public function get_title() {
		return esc_html__( 'Stockist Stores');
	}

	
	public function get_icon() {
		return 'eicon-user-circle-o';
	}

	
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	
	public function get_categories() {
		return [ 'stockist-stores' ];
	}

	
	public function get_keywords() {
		return ['stockist_stores', 'code'];
	}
    

    protected function register_controls() {

		$this->start_controls_section(
			'stockist_stores_locator',
			[
				'label' => esc_html__( 'Stockist Stores' ),
			]
		);


		$this->add_control(
			'stockist_stores',
			[
				'label' => esc_html__( 'Stockist Stores'),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'Stockist Stores',
			]
		);


		$this->end_controls_section();

	}


    protected function render() {

		$setting = $this->get_settings_for_display();
		
		echo do_shortcode( '[mipl_stockist_store_locator]' );

	}


	protected function content_template() {}


}
