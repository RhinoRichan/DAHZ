<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Customizer
 * @param mixed $wp_manager 
 * @author Dahz
 * @return mixed            
 * @since 1.2.1
 */
class Dahz_Customizer_Builder {

	static $instance;
	public $settings;
	public $controls;       

	public function __construct() {

		self::$instance =& $this;

		add_action('customize_register', array( $this, 'isBuildCustomizer' ), 99 );
	}

	public function isBuildCustomizer($wp_manager) {

		$controls = $this->getAllControl();
		$this->settings = new Dahz_Customize_Settings();
		$this->controls = new Dahz_Customize_Controls();

		// Early exit if controls are not set or if they're empty
		if ( ! isset( $controls ) || empty( $controls ) ) {
			return;
		}
		foreach ( $controls as $control ) {
			$this->settings->add( $wp_manager, $control );
			$this->controls->add( $wp_manager, $control );
		}

	}

	public function getAllControl() {

		$controls = apply_filters('df_customizer_controls', array());
		return $controls;

	}

}
new Dahz_Customizer_Builder;

require_once 'dahz-customize-controls.php';
require_once 'dahz-customize-settings.php';