<?php
/**
 * Build Settings Customizer           
 * @since 1.2.1
 */
class Dahz_Customize_Settings extends Dahz_Customizer_Builder {
    
    /**
     * 
     * @param string $wp_manager 
     * @param string $control
     * @since 1.4.0 
     */
	public function add($wp_manager, $control){
		$this->add_setting( $wp_manager, $control );
	}

	/**
	 * 
	 * @param string $wp_manager  
	 * @param string $control     
	 * @param bool|string $id_override 
	 * @param mixed $callback    
	 * @since 1.2.1 
	 */
	public function add_setting($wp_manager, $control, $id_override = null, $default_override = null, $callback = null) {

		// setting
		$id     = ( ! is_null( $id_override ) ) ? $id_override : 'df_options[' .$control['setting']. ']';
		$default  = ( ! is_null( $default_override ) ) ? $default_override : $control['default'];
		$callback = ( ! is_null( $callback ) )  ? $callback : $this->sanitize_callback( $control );


		$wp_manager->add_setting($id, array(
				'default'    => $default,
				'type'       => 'option',
				'capability' => 'edit_theme_options',
				'transport'  => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				'sanitize_callback' => $callback,
			) );

	}

	public function sanitize_callback($control) {

		if ( isset( $control['sanitize_callback'] ) && ! empty( $control['sanitize_callback'] ) ) {
			return $control['sanitize_callback'];
		} else { // Fallback callback
			return self::get_sanitization( $control['type'] );
		}

	}

	/**
	 * Sanitizes the control transport.
	 *
	 * @param string the control type
	 * @return string the function name of a sanitization callback
	 * @since  1.4.0
	 */
	public static function get_sanitization($control_type) {

		switch ( $control_type ) {
			case 'checkbox' :
				$sanitize_callback = 'dahz_sanitize_checkbox';
				break;
			case 'select' :
				$sanitize_callback = 'sanitize_text_field';
				break;
			case 'color' :
				$sanitize_callback = 'sanitize_hex_color';
				break;
			case 'image' :
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'text' :
				$sanitize_callback = 'esc_attr';
				break;
			case 'textarea' :
				$sanitize_callback = 'dahz_sanitize_textarea';
				break;
			case 'uploader' :
				$sanitize_callback = 'esc_url_raw';
				break;
			case 'slider' :
				$sanitize_callback = 'dahz_sanitize_range';
				break;
			default:
				$sanitize_callback = 'dahz_sanitize_default';
		}

		return $sanitize_callback;

	}
	
}