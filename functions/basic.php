<?php

/**
 * Dahz Framework Basic Function.
 *
 * WARNING: This file is part of the core Dahz Framework. DO NOT EDIT if you unsure for what will you do. Believe me, skies will fall !
 *
 * @package WordPress
 * @subpackage  DahzFramework
 * @category  Core
 * @author  Dahz
 * @since  1.0.0
 */

/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS - FUNCTIONS/BASIC.PHP

- text domain
- suffix for minified
- convert hex to rgba
- Meta Content Function
- Dahz Title Format Function
- Word Trim function


-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'dahz_load_textdomain' ) ) {
/**
 * Load the theme's textdomain, as well as an optional child theme textdomain.
 * @since  1.0.0
 * @return void
 */
function dahz_load_textdomain () {
  load_theme_textdomain( 'dahztheme' );
  load_theme_textdomain( 'dahztheme', get_template_directory() . '/includes/lang' );
  if ( function_exists( 'load_child_theme_textdomain' ) )
    load_child_theme_textdomain( 'dahztheme' );
} // End df_load_textdomain()
}

add_action( 'init', 'dahz_load_textdomain', 10 );


/**
 * Function for grabbing a WP nav menu theme location name.
 *
 * @since  1.1.0
 * @access public
 * @param  string  $location
 * @return string
 */
function dahz_get_menu_location_name( $location ) {

  $locations = get_registered_nav_menus();

  return $locations[ $location ];
}

/**
 * Function for grabbing a dynamic sidebar name.
 *
 * @since  1.1.0
 * @access public
 * @param  string  $sidebar_id
 * @return string
 */
function dahz_get_sidebar_name( $sidebar_id ) {
  global $wp_registered_sidebars;

  if ( isset( $wp_registered_sidebars[ $sidebar_id ] ) )
    return $wp_registered_sidebars[ $sidebar_id ]['name'];
}

/**
 * Helper function for getting the script/style `.min` suffix for minified files.
 *
 * @since  1.3.0
 * @access public
 * @return string
 */
function dahz_get_min_suffix() {
  return defined( 'WP_DEBUG' ) && true === WP_DEBUG ? '' : '.min';
}

/**
 * Adds the default framework actions and filters.
 *
 * @since 1.1.0
 */
function dahz_default_filters() {
  /* Make text widgets and term descriptions shortcode aware. */
  add_filter( 'widget_text', 'do_shortcode' );
  add_filter( 'term_description', 'do_shortcode' );
  add_filter( 'the_excerpt', 'do_shortcode');
}
/* Initialize the framework's default actions and filters. */
add_action( 'after_setup_theme', 'dahz_default_filters', 3 );


if ( ! function_exists( 'dahz_comment_reply' ) ) {
/**
 * Enqueue the comment reply JavaScript on singular entry screens.
 * @since  1.0.0
 * @return void
 */
function dahz_comment_reply() {
  if ( is_singular() && get_option( 'thread_comments' ) && comments_open() ) wp_enqueue_script( 'comment-reply' );
} // End dahz_comment_reply()
}

add_action( 'wp_enqueue_scripts', 'dahz_comment_reply', 5 );


/* ----------------------------------------------------------------------------------- */
/* Convert Hex to RGBA                                                                  */
/* ----------------------------------------------------------------------------------- */
if (!function_exists('df_convert_rgba')) {

    function df_convert_rgba($color, $opacity) {
        $color = str_replace("#", "", $color);

        $r = hexdec(substr($color, 0, 2));
        $g = hexdec(substr($color, 2, 2));
        $b = hexdec(substr($color, 4, 2));
        $a = intval($opacity) / 100;

        return "rgba($r, $g, $b, $a)";
    }

}

/**
 * Meta Content Function
 * 
 * @return void
 * @since  1.0.0
 */
function dahz_meta () {
    do_action( 'dahz_meta' );
} // End dahz_meta()


if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
/**
 * Backward Compatibilty wp_title()
 * 
 * @return type
 * @since  1.2.1
 */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
  function dahz_render_title() {
  ?>
   <title><?php wp_title('|', true, 'right'); ?></title>
  <?php
  }
  add_action( 'wp_head', 'dahz_render_title' );
}
endif;


if ( ! function_exists( 'df_add_blog_name_to_title' ) ) {
/**
 * Add the site title to the wp_title() text.
 * @since  1.0.0
 * @param  string $title     Existing title value.
 * @param  string $sep       Separator string.
 * @param  string $raw_title Raw title value.
 * @return string            Modified title.
 */
  function df_add_blog_name_to_title ( $title, $sep, $raw_title ) {
    $site_title = get_bloginfo( 'name' );
    $title .= apply_filters( 'df_add_blog_name_to_title', $site_title );
    return $title;
  } // End df_add_blog_name_to_title()
}

if ( ! function_exists( 'df_maybe_add_page_number_to_title' ) ) {
/**
 * Maybe add the page number, if paginating, to the dahz_title() text.
 * @since  1.0.0
 * @param  string $title     Existing title value.
 * @param  string $sep       Separator string.
 * @param  string $raw_title Raw title value.
 * @return string            Modified title.
 */
function df_maybe_add_page_number_to_title ( $title, $sep, $raw_title ) {
  if ( is_paged() ) {
    $page = intval( get_query_var( 'page' ) );
    $paged = intval( get_query_var( 'paged' ) );
    $page_number = $paged;
    if ( 0 < $page ) {
      $page_number = $page;
    }

    $title .= apply_filters( 'df_maybe_add_page_number_to_title', ' ' . $sep . ' ' . sprintf( __( 'Page %s', 'dahztheme' ), intval( $page_number ) ) );
  }
  return $title;
} // End df_maybe_add_page_number_to_title()
}

if ( ! class_exists( 'WPSEO_Frontend' ) && ! defined( 'WPSEO_VERSION' ) ) {
  //add_filter( 'wp_title', 'df_add_blog_name_to_title', 10, 3 );
  //add_filter( 'wp_title', 'df_maybe_add_page_number_to_title', 10, 3 );
}

/**
 * Word Trim function
 * @param type $count 
 * @param type $ellipsis 
 * @return string
 * @since  1.0.0
 */
if ( ! function_exists( 'df_word_trim' ) ) :
function df_word_trim($string, $count, $ellipsis = FALSE){
          $words = explode(' ', $string);
          if (count($words) > $count){
                array_splice($words, $count);
                $string = implode(' ', $words);
                
                if (is_string($ellipsis)){
                        $string .= $ellipsis;
                }
                elseif ($ellipsis){
                        $string .= '&hellip;';
                }
          }
          return $string;
}
endif;