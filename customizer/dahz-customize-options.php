<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
* get options and customizer preview helper
* @author Dahz
* @since  1.5.0
*/
class Dahz_Customizer_Options
{


/**
 * Defaults Option Customizer
 *
 * Returns an associative array that holds
 * all of the default values for all Theme
 * options.
 *
 * @version 2.0.0
 * @uses  Dahz_Customizer_Builder::$instance->getAllControl()  defined in customizer/dahz-customize-builder.php *
 * @return  array $defaults associative array of option defaults
 */
  public static function getOptionDefault() {

      $need_options = array();

      $controls = Dahz_Customizer_Builder::$instance -> getAllControl();

      foreach ( $controls as $key ) {
         $setting = $key['setting'];
         // Add an associative array key
         // to the defaults array for each
         // option in the parameters array
         $need_options[$key['setting']] = maybe_unserialize( $key['default'] );
      }

      return apply_filters( 'df_options_default_setting', $need_options );
  }


  /**
   * Global Get Option Customizer
   * Store settings value with df_options[theme_settings].
   * Get theme’s settings from database with df_options('theme_settings').
   *
   * @param  string  $name
   * @param  boolean $default
   * @return mixed
   */
  public static function getOptionSetting( $name, $default = false ){

      $saved = get_option( 'df_options' );

      $default = apply_filters( 'df_options_set_default', array() );

      $options = wp_parse_args( $saved, $default );

      $mod = apply_filters( 'df_options_get_mod', $options, $name );

      if (isset( $mod[ $name ] )) {
          return $mod[ $name ];
      } else {
        return $default;
      }

  }


  /**
  * Returns a boolean on the customizer's state
  *
  * 1) Left panel ?
  * 2) Preview panel ?
  * 3) Ajax action from customizer ?
  *
  * @param boolean $is_customizing
  * @since 1.3.0
  * @return boolean
  */
  public static function isCustomizerPreview(){
      //checks if is customizing : two contexts, admin and front (preview frame)
      return in_array( 1, array(
      self::isCustomizePanel(),
      self::isCustomizePreviewFrame(),
      self::isCustomizeDoingAjax()
      ) );
  }


  /**
  * @return boolean
  * @since  1.5.0
  */
  private static function isCustomizePanel(){
     global $pagenow;
     return is_admin() && isset( $pagenow ) && 'customize.php' == $pagenow;
  }


  /**
  * @return boolean
  * @since  1.5.0
  */
  private static function isCustomizePreviewFrame(){
    return ! is_admin() && isset( $_REQUEST['wp_customize'] );
  }


  /**
  * @return boolean
  * @since  1.5.0
  */
  static function isCustomizeDoingAjax(){
    return isset( $_POST['customized'] ) && ( defined( 'DOING_AJAX' ) && DOING_AJAX );
  }

}


if(!function_exists('df_options')) :
/**
* Global Option Customizer
* Get theme’s settings from database with df_options('theme_settings').
* @see Dahz_Customizer_Options::getOptionSetting()
* @param array $name
* @return mixed
*/
  function df_options( $name, $default = false ) {
  	$options = new Dahz_Customizer_Options();
    	return $options::getOptionSetting( $name, $default );
  }
endif;

if( ! function_exists( 'df_is_customizing' ) ):
/**
* Returns a boolean on the customizer's state
* @see Dahz_Customizer_Options::isCustomizerPreview()
* @return boolean
*/
  function df_is_customizing() {
  	$preview = new Dahz_Customizer_Options();
  	return $preview::isCustomizerPreview();
  }
endif;
