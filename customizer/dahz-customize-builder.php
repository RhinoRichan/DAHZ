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

		add_action('customize_register', array( $this, 'regControlType' ), 1);
		add_action('customize_register', array( $this, 'isBuildCustomizer' ), 99 );
	}

	public function isBuildCustomizer( $wp_customize ) {
		$controls = $this->getAllControl();
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
			$setting				= 'df_options['. $control['setting'] .']';
			$id							= sanitize_key( str_replace( '[', '-', str_replace( ']', '', $setting ) ) );
			$sanitize_cb    = dahz_get_sanitization( $control['type'] );

			$wp_customize->add_setting( $setting, array(
					'default'    => $default,
					'type'       => 'option',
					'capability' => 'edit_theme_options',
					'transport'  => $transport,
					'sanitize_callback' => $sanitize_cb,
				) );

				$option_control_parameters = array(
					'type'              => $control['type'],
					'priority'          => $priority,
					'section'           => $section,
					'label'             => $label,
					'description'       => $description,
					'settings'          => $setting
				);

				if( in_array( $control['type'], array( 'select', 'radio', 'images_radio' ) ) ) {
					$option_control_parameters['choices'] = $choices;
				}

			if( in_array( $control['type'], array( 'text', 'textarea', 'url', 'password', 'email' ) ) ) {
						$wp_customize->add_control( $id, $option_control_parameters );
			} else {
						$control_object = $this->get_object_controls( $control['type'] );
						$wp_customize->add_control( new $control_object ( $wp_customize, $id,
						 array_merge( $option_control_parameters, array( 'mode' => $mode, 'direction' => $dir, 'input_attrs' => $input_attrs ) )
						 ) );
				}
		}

	}

	public function getAllControl() {

		$controls = apply_filters( 'df_customizer_controls', array() );
		return $controls;

	}

	public function regControlType( $wp_customize ) {

		$custom_control_files = array(
		  'controls/media/media-uploader-custom-control.php',
		  'controls/typography/typography-custom-control.php',
		  'controls/text/text-description-custom-control.php',
		  'controls/text/text-subtitle-custom-control.php',
		  'controls/text/text-slider-custom-control.php',
		  'controls/layout/layout-picker-custom-control.php',
		  'controls/select/selectbox-dropdown-custom-control.php',
		  'controls/text/checkbox-custom-control.php',
		  'controls/text/radiobox-custom-control.php'
		);

		foreach ( $custom_control_files as $files ) {
				require_once( DF_CUSTOMIZER_CONTROL_DIR . $files );
		}

		$wp_customize->register_control_type( 'DAHZ_Subtitle_Control' );
		$wp_customize->register_control_type( 'DAHZ_TextDescription_Control' );
		$wp_customize->register_control_type( 'DAHZ_Layout_Picker_Control' );
		$wp_customize->register_control_type( 'DAHZ_Selectbox_Dropdown_Control' );
		$wp_customize->register_control_type( 'DAHZ_Typography_Control' );
	}

	public function get_object_controls( $control_type ){
		switch ( $control_type ) {
			case 'description':
			return 'DAHZ_TextDescription_Control';
				break;

			case 'sub-title':
			return 'DAHZ_Subtitle_Control';
				break;

			case 'images_radio':
			return 'DAHZ_Layout_Picker_Control';
				break;

			case 'slider':
			return 'DAHZ_RangeSlider_Control';
				break;

			case 'uploader':
			return 'DAHZ_Media_Uploader_Control';
				break;

			case 'image':
			return 'WP_Customize_Image_Control';
				break;

			case 'color':
			return	'WP_Customize_Color_Control';
				break;

			case 'select':
			return	'DAHZ_Selectbox_Dropdown_Control';
				break;

			case 'checkbox':
			return	'DAHZ_Checkbox_Control';
				break;

			case 'radio':
			return	'DAHZ_Radiobox_Control';
				break;
		}

		return FALSE;
	}

}
