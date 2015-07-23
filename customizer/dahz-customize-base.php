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


      global $pagenow;
      if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {

       add_action('admin_head', array( $this, 'df_customizer_option_setup' ));
        // Flush rewrite rules.
       add_action( 'admin_head', array( $this, 'isFlushRewriterules' ), 9 );

       do_action('dahz_theme_activate');
      }

      add_action('admin_menu',  array( $this, 'unsetAdminMenu' ) );
      add_action('dahz_screen_menu',  array( $this, 'regAdminMenu' ) );

  }


  function unsetAdminMenu(){
     global $submenu;
     unset($submenu['themes.php'][6]); // remove customize link
  }


  function regAdminMenu(){
     add_submenu_page( 'dahzframework', 'Customize', 'Customize', 'edit_theme_options', 'customize.php', NULL );
  }


  /**
   * Update theme Customizer in database with options as stored in theme.
   * @since  1.0
   * @return void
   */
  function df_customizer_option_setup () {
    //Update EMPTY options
    $controls = array();
    add_option( 'df_options', $controls );

    $controls = Dahz_Customizer_Builder::$instance -> getAllControl();

    foreach ( $controls as $key => $value ) {
       $key                = $value['setting'];
       $need_options[$key] = maybe_unserialize( $value['default'] );
    }
    update_option( 'df_options', $need_options ) ;

  } // End df_customizer_option_setup()


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
