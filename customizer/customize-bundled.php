<?php

/**
 * init customizer
 *
 * @since 2.0.0
 * @return void
 */
function dahz_customize_init_bundled(){
  		/* Customizer Setup */
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'helpers/sanitization.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-builder.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-scripts.php';
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-base.php';
        /* Backup Import / Export */
        require_once DF_CUSTOMIZER_CONTROL_DIR . 'dahz-customize-backup.php';
}
add_action('after_setup_theme', 'dahz_customize_init_bundled');
