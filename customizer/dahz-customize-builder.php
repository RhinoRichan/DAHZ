<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Customizer
 * @param mixed $wp_customize
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

	public function isBuildCustomizer($wp_customize) {
    $control_types = $this->regControlType($wp_customize);
		$controls = $this->getAllControl();
		$this->settings = new Dahz_Customize_Settings();
		$this->controls = new Dahz_Customize_Controls();

		// Early exit if controls are not set or if they're empty
		if ( ! isset( $controls ) || empty( $controls ) ) {
			return;
		}
		foreach ( $controls as $control ) {
			$this->settings->add( $wp_customize, $control );
			$this->controls->add( $wp_customize, $control );
		}

	}

	public function getAllControl() {

		$controls = apply_filters('df_customizer_controls', array());
		return $controls;

	}

	function regControlType($wp_customize) {

		$customizer_control = array(
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/media/media-uploader-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/typography/googlefont-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-description-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-subtitle-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-slider-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/layout/layout-picker-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/select/selectbox-dropdown-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/textarea-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/checkbox-custom-control.php',
								DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/radiobox-custom-control.php'
		);

		foreach ( $customizer_control as $control ) {
		require_once $control;
		}
		$wp_customize->register_control_type( 'DAHZ_Subtitle_Control' );
		$wp_customize->register_control_type( 'DAHZ_TextDescription_Control' );
		$wp_customize->register_control_type( 'DAHZ_Layout_Picker_Control' );
	}

}
new Dahz_Customizer_Builder;

require_once 'dahz-customize-controls.php';
require_once 'dahz-customize-settings.php';
