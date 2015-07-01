<?php
/**
 * Dahz Framework output site data to 'head' tag.
 *
 * @package WordPress
 * @subpackage  DahzFramework
 * @category  Core
 * @author  Dahz
 * @since  2.0.0
 */

/**
 * Output Meta Content Function
 *
 * @return void
 * @since  1.0.0
 */
function dahz_meta () {
    do_action( 'dahz_meta' );
} // End dahz_meta()


/**
 * Adds the meta charset to the header.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function dahz_meta_charset() {
	printf( '<meta charset="%s" />' . "\n", esc_attr( get_bloginfo( 'charset' ) ) );
}
add_action( 'dahz_meta', 'dahz_meta_charset', 0 );


/**
 * Load responsive <meta> tags in the <head>
 * @since 2.0.0
 *
 */
function dahz_meta_viewport() {
        $html = '';

        $html .= "\n" . '<!--  Mobile viewport scale -->' . "\n";
        $html .= '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">' . "\n";

        echo $html;
}
// End dahz_meta_viewport()
add_action( 'dahz_meta', 'dahz_meta_viewport', 1 );


/**
 * Adds the pingback link to the header.
 *
 * @since  2.0.0
 * @access public
 * @return void
 */
function dahz_link_pingback() {
	if ( 'open' === get_option( 'default_ping_status' ) )
		printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
add_action( 'dahz_meta', 'dahz_link_pingback',  2 );


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
