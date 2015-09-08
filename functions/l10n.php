<?php


if ( ! function_exists( 'dahz_load_textdomain' ) ) {
/**
 * Load the theme's textdomain, as well as an optional child theme textdomain.
 * @since  1.0.0
 * @return void
 */
function dahz_load_textdomain () {
  load_theme_textdomain( 'dahztheme', get_template_directory() . '/lang' );
  if ( function_exists( 'load_child_theme_textdomain' ) )
    load_child_theme_textdomain( 'dahztheme' );
} // End df_load_textdomain()
}

add_action( 'after_setup_theme', 'dahz_load_textdomain', 10 );
