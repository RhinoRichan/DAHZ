<?php
if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Customize for Subtitle, extend the WP customizer
 *
 * @since 1.2.0
 */
 class DAHZ_Subtitle_Control extends WP_Customize_Control {
  
     public $type = 'sub-title';
       /**
       * Render the content on the theme customizer page
       */
     public function render_content() {}
    
     public function content_template() {
     ?>
      <h4 class="customize-subtitle">{{ data.label }}</h4>
    <?php
    }

}
