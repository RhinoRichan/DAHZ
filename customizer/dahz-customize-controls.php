<?php 
/**
 * Build Controls Customizer           
 * @since 1.2.1
 */
class Dahz_Customize_Controls extends Dahz_Customizer_Builder {

	/**
	 * array of control
	 * @param $control 
	 * @since 1.3.1
	 */		
	public static function array_of_control($control) {
        
		if (  ! isset( $control['default'] ) ) {
			$control['default'] = '';
		}

		$control['description'] = isset( $control['description'] ) ? $control['description'] : '';
		$control['label'] = isset( $control['label'] ) ? $control['label'] : '';

		/**
		 * Compatibility tweak
		 *
		 * Previous versions of DahzFramework used 'setting' instead of 'settings'.
		 */
		if ( ! isset( $control['settings'] ) && isset( $control['setting'] ) ) {
			$control['settings'] = 'df_options['. $control['setting'] .']';
		}

		$control['id'] = sanitize_key( str_replace( '[', '-', str_replace( ']', '', $control['settings'] ) ) );

		$control['transport']   = isset( $control['transport'] ) ? $control['transport'] : 'refresh';

		return $control;

	}

    /**
     * 
     * @param string $wp_manager 
     * @param string $control
     * @since 1.3.0 
     */
	public function add( $wp_manager, $control ) {
			
		$control = self::array_of_control( $control );
         
         /**
         * use the default WordPress Core Customizer fields when possible
		 * and only add our own custom controls when needed.
		 */
		
		// control
			if ( 'description' == $control['type'] ) {
				
				$wp_manager->add_control( new DAHZ_TextDescription_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'sub-title' == $control['type'] ) {

				$wp_manager->add_control( new DAHZ_Subtitle_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'textarea' == $control['type'] ) {

				$wp_manager->add_control( new DAHZ_Textarea_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'images_radio' == $control['type'] ) {

				$wp_manager->add_control( new DAHZ_Layout_Picker_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'slider' == $control['type'] ) {
				
				$wp_manager->add_control( new DAHZ_RangeSlider_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'uploader' == $control['type'] ) {

				$wp_manager->add_control( new DAHZ_Media_Uploader_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'image' == $control['type'] ) {

				$wp_manager->add_control( new WP_Customize_Image_Control( $wp_manager, $control['id'], $control ));

			} elseif ( 'color' == $control['type'] ) {

				$wp_manager->add_control( new WP_Customize_Color_Control($wp_manager, $control['id'], $control ));

			} elseif ( 'select' == $control['type'] || ( 'select' == $control['type'] && isset( $control['mode'] ) && 'search' == $control['mode'] ) ) {

				$wp_manager->add_control( new DAHZ_Selectbox_Dropdown_Control($wp_manager, $control['id'], $control )); 

			} elseif ( 'checkbox' == $control['type'] || ( 'checkbox' == $control['type'] && isset( $control['mode'] ) && 'toggle' == $control['mode'] ) ) {

				$wp_manager->add_control( new DAHZ_Checkbox_Control($wp_manager, $control['id'], $control ));

			} elseif ( 'radio' == $control['type'] || ( 'radio' == $control['type'] && isset( $control['mode'] ) && 'buttonset' == $control['mode'] && 'image' == $control['mode']  ) ) {

				$wp_manager->add_control( new DAHZ_Radiobox_Control($wp_manager, $control['id'], $control ));

			} else {

				$wp_manager->add_control($control['id'], array(
					'type' => isset( $control['type'] ) ? $control['type'] : '',
					'label' => isset( $control['label'] ) ? $control['label'] : '',
					'section' => $control['section'],
					'priority' => $control['priority'],
					'settings' => $control['settings'],
					'choices' => isset( $control['choices'] ) ? $control['choices'] : '',
					'transport'   => isset( $control['transport'] ) ? $control['transport'] : 'refresh',
				));

			}

	}
	
}