<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
* get style and script
* @author Dahz
* @since  1.5.0
*/
class Dahz_Customizer_Scripts {

  private $suffix;

  function __construct() {

    $this->suffix = dahz_get_min_suffix();

    add_action('customize_controls_enqueue_scripts', array( $this, 'EnqueueScripts' ));
    //register custom control scripts
    add_action('customize_controls_enqueue_scripts', array( $this, 'customize_controls_register_script' ), 0);
  }

  function EnqueueScripts() {
      wp_enqueue_style('dahz-customizer', DF_CORE_CSS_DIR . 'dahz-customizer'. $this->suffix .'.css');
      //HOOK
      do_action('dahz_enqueue_customizer_admin');

      wp_enqueue_script('dahz-semantic-ui-transition', DF_CORE_JS_DIR . 'transition.min.js', array( 'jquery' ), false, true );
      wp_enqueue_script('dahz-semantic-ui-dropdown', DF_CORE_JS_DIR . 'dropdown.min.js', array( 'jquery' ), false, true );
      wp_enqueue_script('dahz-semantic-ui-popup', DF_CORE_JS_DIR . 'popup.min.js', array( 'jquery' ), false, true );
      wp_enqueue_script('dahz-customizer-main', DF_CORE_JS_DIR . 'customizer-main'. $this->suffix .'.js', array( 'customize-controls' ), false, true );
  }

  function customize_controls_register_script(){
      wp_register_script('dahz-api-controls', DF_CORE_JS_DIR . 'api-controls'. $this->suffix .'.js', array( 'jquery' ), false, true);
  }


}
new Dahz_Customizer_Scripts;
