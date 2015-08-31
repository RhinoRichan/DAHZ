<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build Customizer
 * @param mixed $wp_customize
 * @author Dahz
 * @package Customizer
 * @since 1.2.1
 */
class Dahz_Customizer_Builder {

	/**
	 * The single instance of Dahz_Customizer_Builder.
	 * @static
	 * @var 	object
	 * @since 	2.0.0
	 */
	static $instance;

	/**
	 * The settings.
	 * @access public
	 * @var 	object
	 * @since 	2.0.0
	 */
	public $settings;

	/**
	 * The controls.
	 * @access public
	 * @var 	object
	 * @since 	2.0.0
	 */
	public $controls;


	/**
	 * Class constructor.
	 * @access  public
	 * @since   1.2.1
	 * @return  void
	 */
	public function __construct() {

		self::$instance =& $this;

		add_action('customize_register', array( $this, 'regControlType' ), 99);
		add_action('customize_register', array( $this, 'isBuildCustomizer' ), 99 );
	}


	/**
	 * Build Customizer setting default controls and custom controls
	 * @param $wp_customize
	 * @return void
	 */
	public function isBuildCustomizer( $wp_customize ) {
		$controls = $this->getAllControl();
		$callback_helper = new Dahz_Sanitization_Helper;
		// Early exit if controls are not set or if they're empty
		if ( ! isset( $controls ) || empty( $controls ) ) {
			return;
		}

		foreach ( $controls as $control ) {
			$priority       = ( isset( $control['priority'] ) ) ? $control['priority'] : '';
			$default        = ( isset( $control['default'] ) ) ? $control['default'] : '';
			$description    = ( isset( $control['description'] ) ) ? $control['description'] : '';
			$section        = ( isset( $control['section'] ) ) ? esc_attr( $control['section'] ) : '';
			$label					= ( isset( $control['label'] ) ) ? $control['label'] : '';
			$transport      = ( isset( $control['transport'] ) ) ? esc_attr( $control['transport'] ) : 'refresh';
			$input_attrs  	= ( isset( $control['input_attrs'] ) ) ? $control['input_attrs'] : array();
			$choices  			= ( isset( $control['choices'] ) ) ? $control['choices'] : array();
			$mode  					= ( isset( $control['mode'] ) ) ? $control['mode'] : '';
			$dir      			= ( isset( $control['direction'] ) ) ? $control['direction'] : '';
			$setting				= $control['setting'];
			$sanitize_cb    = $callback_helper::get_sanitization( $control['type'] );

			$wp_customize->add_setting( $setting, array(
					'default'    => $default,
					'type'       => 'theme_mod',
					'capability' => 'edit_theme_options',
					'transport'  => $transport,
					'sanitize_callback' => $sanitize_cb,
				) );

			// default controls
			if( in_array( $control['type'], array( 'text', 'url', 'password', 'email' ) ) ) {
						$wp_customize->add_control( $setting, array(
								'priority'          => $priority,
								'section'           => $section,
								'label'             => $label,
								'description'       => $description,
								'settings'          => $setting
							) );
			} else {
						$control_object = self::get_object_controls( $control['type'] );
						// custom controls
						$wp_customize->add_control( new $control_object ( $wp_customize, $setting, array(
							'priority'          => $priority,
							'mode'              => $mode,
							'direction'         => $dir,
							'section'           => $section,
							'label'             => $label,
							'description'       => $description,
							'choices'           => $choices,
							'input_attrs'       => $input_attrs,
							'settings'          => $setting
						) ) );
				}
		}

	}


	/**
	 * get control settings passing via filtering array
	 * @access public
	 * @return array
	 */
	public function getAllControl() {

		$controls = apply_filters( 'df_customizer_controls', array() );
		return $controls;

	}


	/**
	 * Register all custom controls
	 * @param $wp_customize
	 * @return void
	 */
	public function regControlType( $wp_customize ) {

		// Run the autoloader
	  spl_autoload_register( array( $this, 'autoload_classes' ) );

		$register_type = array( 'Subtitle', 'TextDescription', 'Layout_Picker', 'Selectbox_Dropdown', 'Typography' );
		foreach ( $register_type as $type ) {
				$wp_customize->register_control_type( 'DAHZ_'. $type .'_Control' );
		}

	}

	/**
	 * Autoloader callback for loading custom Customizer control classes.
   *
	 * @access private
	 * @param $class_name
	 * @return string
	 */
	private function autoload_classes( $class_name ) {

		if ( 0 === stripos( $class_name, 'DAHZ' ) ) {
					$control_path = DF_CUSTOMIZER_CONTROL_DIR . 'controls/';
					$filename = trailingslashit( $control_path ) . $class_name . '.php';
					if ( is_readable( $filename ) ) {
						require_once $filename;
					}
		}

	}

	/**
	 * create object controls base on type for custom controls
	 * @access public
	 * @static
	 * @param $control_type
	 * @return string
	 */
	public static function get_object_controls( $control_type ){
		switch ( $control_type ) {
			case 'description':
				$control_object = 'DAHZ_TextDescription_Control';
				break;

			case 'sub-title':
				$control_object = 'DAHZ_Subtitle_Control';
				break;

			case 'textarea':
				$control_object = 'DAHZ_Textarea_Control';
				break;

			case 'images_radio':
				$control_object = 'DAHZ_Layout_Picker_Control';
				break;

			case 'slider':
				$control_object = 'DAHZ_RangeSlider_Control';
				break;

			case 'uploader':
				$control_object = 'DAHZ_Media_Uploader_Control';
				break;

			case 'image':
				$control_object = 'WP_Customize_Image_Control';
				break;

			case 'color':
				$control_object =	'WP_Customize_Color_Control';
				break;

			case 'select':
				$control_object =	'DAHZ_Selectbox_Dropdown_Control';
				break;

			case 'checkbox':
				$control_object =	'DAHZ_Checkbox_Control';
				break;

			case 'radio':
				$control_object =	'DAHZ_Radiobox_Control';
				break;
		}

		return $control_object;
	}

}
$dahz_Customizer_Builder = new Dahz_Customizer_Builder();
