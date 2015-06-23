<?php

if ( ! defined( 'ABSPATH' ) ) { 
  exit;
} 


/**
* DahzFramework customizer base
*
*
* @version 1.5.0
* @author  Dahz
* @since   1.5.0
*
* @package DahzFramework
* @subpackage Module
*   
* TABLE OF CONTENTS - CUSTOMIZER/DAHZ-CUSTOMIZER-BASE.PHP
*
* - Remove admin submenu page
* - Add the Customize link to the admin menu
* - Register customizer custom control
* - Theme Activated
* - register control type
* - add section
* - add control
* - output css
* - flush Rewrite
*/
class Dahz_Customizer_Base
{
  
  static $instance;

  function __construct(){
    self::$instance =& $this;

    add_action('wp_loaded',  array($this, 'loadAdmin') );
    add_action('customize_register',  array($this, 'regControlType') );

    add_action('customize_register',  array($this, 'add_customize_section_base') );
    add_filter('df_customizer_controls',  array($this, 'add_customize_control_base') );
    if (!is_admin()) { add_action( 'wp_head', array($this, 'output_custom_css'), 9999, 0 ); }

  }
  

  /**
   * [load_admin description]
   * @return [type] [description]
   */
  function loadAdmin(){

    global $pagenow;
    if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
      // Flush rewrite rules.
     add_action( 'admin_head', array( $this, 'isFlushRewriterules'), 9 );

     do_action('dahz_theme_activate');
    }

    add_action('admin_menu',  array( $this, 'unsetAdminMenu') );
    add_action('dahz_screen_menu',  array( $this, 'regAdminMenu') );
  }
  

  function unsetAdminMenu(){
     global $submenu;
     unset($submenu['themes.php'][6]); // remove customize link
  }
  

  function regAdminMenu(){
     add_submenu_page('dahzframework', 'Customize', 'Customize', 'edit_theme_options', 'customize.php', NULL );
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

  /**
   * Register section custom css
   *
   * @version 2.0.0 
   * @param  $wp_customize
   * @return array
   */
  function add_customize_section_base($wp_customize){
    
    $wp_customize->add_section('df_customizer_custom_style_section', array(
            'title' => _x('Custom CSS', 'backend customizer', 'dahztheme'),
            'priority' => 1000
    ));

  }
  
  /**
   * Add control custom css 
   *
   * @version 2.0.0 
   * @param  array $controls 
   * @return array
   */
  function add_customize_control_base($controls){

        $controls[] = array(
           'type'     => 'textarea',
           'setting'  => 'custom_styles',
           'label'    => _x( 'CSS', 'backend customizer' , 'dahztheme' ),
           'section'  => 'df_customizer_custom_style_section',
           'default'  => '',
           'priority' => 10
         );

        return $controls;
  }

  /**
   * Output custom css
   * 
   * @version 1.2.0
   * @return string
   */
  function output_custom_css() {
      if (df_options('custom_styles')) { 
        return printf('<style type="text/css">%s</style>', wp_strip_all_tags( df_options('custom_styles') ));
      }
  }


  /**
   * Flush the WordPress rewrite rules to refresh permalinks with updated rewrite rules.
   * @since  1.0.0
   * @return void
   */
  function isFlushRewriterules() {
    flush_rewrite_rules();
  } // End df_flush_rewriterules()

}
new Dahz_Customizer_Base();