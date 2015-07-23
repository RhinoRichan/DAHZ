<?php

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/**
 * Dahz Framework - A WordPress theme development framework.
 * @package   DahzFramework
 * @version   2.1.1
 * @author    Dahz
 * @copyright Copyright (c) 2015, Dahz
 */

    /**
     * Defines the constant paths for use within the core framework, parent theme, and child theme.
     * Constants prefixed with 'DF_' are for use only within the core framework and don't
     * reference other areas of the parent or child theme.
     *
     * @since 1.0.0
     */
        /* Sets the framework version number. */
        define( 'DF_VERSION', '2.1.1' );

        /* Sets the path to the parent theme directory. */
        define( 'THEME_DIR', get_template_directory() );

        /* Sets the path to the parent theme directory URI. */
        define( 'THEME_URI', get_template_directory_uri() );

        /* Sets the path to the child theme directory. */
        define( 'CHILD_THEME_DIR', get_stylesheet_directory());

        /* Sets the path to the child theme directory URI. */
        define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

        /* Sets the path to the core framework directory. */
        if( ! defined( 'DF_CORE_DIR' ) ) define( 'DF_CORE_DIR', trailingslashit( trailingslashit( get_template_directory() ) . 'dahz' ) );

        /* Sets the path to the core framework directory URI. */
        if( ! defined( 'DF_CORE_URI' ) ) define( 'DF_CORE_URI', trailingslashit( trailingslashit( get_template_directory_uri() ) . 'dahz' ) );

        define( 'DF_CUSTOMIZER_CONTROL_DIR', trailingslashit( trailingslashit( DF_CORE_DIR ) . 'customizer' ));

        /* Sets the path to the core framework extensions directory. */
        define( 'DF_EXTENSION_DIR', trailingslashit( trailingslashit( DF_CORE_DIR ) . 'extensions' ));

        /* Sets the path to the core framework functions directory. */
        define( 'DF_FUNCTION_DIR', trailingslashit( trailingslashit( DF_CORE_DIR ) . 'functions' ));

        /* Sets the path to the core framework CSS directory URI. */
        define( 'DF_CORE_CSS_DIR', trailingslashit( trailingslashit( DF_CORE_URI ) . 'css' ));

        /* Sets the path to the core framework JavaScript directory URI. */
        define( 'DF_CORE_JS_DIR', trailingslashit( trailingslashit( DF_CORE_URI ) . 'js' ));

        /* Sets the path to the core framework images directory URI. */
        define( 'DF_CORE_IMG_DIR', trailingslashit( trailingslashit( DF_CORE_URI ) . 'images' ));

        require_once DF_FUNCTION_DIR . 'basic.php';
        require_once DF_FUNCTION_DIR . 'data-head.php';
        require_once DF_FUNCTION_DIR . 'l10n.php';
        require_once DF_FUNCTION_DIR . 'attr.php';
        require_once DF_FUNCTION_DIR . 'post-formats.php';
        require_once DF_FUNCTION_DIR . 'template.php';
        require_once DF_FUNCTION_DIR . 'pagination.php';
        require_once DF_FUNCTION_DIR . 'breadcrumbs.php';
        require_once DF_FUNCTION_DIR . 'deprecated.php';

        require_once DF_EXTENSION_DIR . 'aqua-resizer.php';
        require_once DF_EXTENSION_DIR . 'get-the-image.php';

    function dahz_after_setup_theme_init(){

        require_once DF_CUSTOMIZER_CONTROL_DIR . 'helpers/sanitization.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-scripts.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-builder.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-base.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-options.php';
        /* Backup Import / Export */
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-backup.php';

        /* Admin Screen */
        if ( is_admin() && !df_is_customizing() ) {
        require_once DF_CORE_DIR . 'screen/dahz-screen-admin-base.php';
        require_once DF_CORE_DIR . 'screen/dahz-screen-home.php';
        require_once DF_CORE_DIR . 'screen/dahz-screen-addons.php';
        require_once DF_CORE_DIR . 'screen/dahz-screen-backup.php';
        }

    }
    add_action( 'after_setup_theme', 'dahz_after_setup_theme_init', -95 );

    if ( ! function_exists( 'dahz_redirect_after_activate' ) ) {
    /**
     * Hooked onto "dahz_theme_activate" at priority 10.
     * @since  2.0.0
     * @return void
     */
    function dahz_redirect_after_activate() {
      header( 'Location: ' . admin_url( esc_url_raw( 'admin.php?page=dahzframework&activated=true' ) ) );
    } // End dahz_redirect_after_activate()
    }
    add_action( 'dahz_theme_activate', 'dahz_redirect_after_activate', 10 );

    /**
     * Enqueue menu.css.
     * Used to control the display of DahzFramework menu items across the dashboard
     * @since  2.0.0
     * @return void
     */
    function dahz_menu_styles() {
      if( df_is_customizing() ) return;
    	$token = 'dahz';

    	wp_register_style( $token . '-menu', esc_url( DF_CORE_CSS_DIR . 'menu.css' ), array(), DF_VERSION );
    	wp_enqueue_style( $token . '-menu' );
    }

    add_action( 'admin_enqueue_scripts', 'dahz_menu_styles' );
