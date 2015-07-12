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

		add_action('customize_register', array( $this, 'regControlType' ), 99);
		add_action('customize_register', array( $this, 'isBuildCustomizer' ), 99 );
	}

	public function isBuildCustomizer( $wp_customize ) {
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

		$controls = apply_filters( 'df_customizer_controls', array() );
		return $controls;

	}

	function regControlType( $wp_customize ) {

		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/media/media-uploader-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/typography/googlefont-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-description-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-subtitle-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/text-slider-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/layout/layout-picker-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/select/selectbox-dropdown-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/textarea-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/checkbox-custom-control.php';
		require_once DF_CUSTOMIZER_CONTROL_DIR . 'controls/text/radiobox-custom-control.php';

		$wp_customize->register_control_type( 'DAHZ_Subtitle_Control' );
		$wp_customize->register_control_type( 'DAHZ_TextDescription_Control' );
		$wp_customize->register_control_type( 'DAHZ_Layout_Picker_Control' );
		$wp_customize->register_control_type( 'DAHZ_Selectbox_Dropdown_Control' );
	}

}
new Dahz_Customizer_Builder;
