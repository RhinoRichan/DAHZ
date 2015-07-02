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

    add_action('after_setup_theme',  array($this, 'loadAdmin') );

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
