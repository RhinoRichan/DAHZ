<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
	return NULL;

/**
 * Customize for Textarea, extend the WP customizer
 *
 * @since 1.2.0
 */

class DAHZ_Textarea_Control extends WP_Customize_Control {

	public $type = 'textarea';


  /**
   * Render the control's content.
   *
   * Allows the content to be overriden without having to rewrite the wrapper.
   *
   * @since   10/16/2012
   * @return  void
   */
  public function render_content() {
    ?>
    <label>
      <span class="customize-control-title"><?php echo esc_html( $this->label ); ?>
      <?php if ( ! empty( $this->description ) ) : ?>
      <i data-content="<?php echo $this->description; ?>" data-position="bottom right" data-offset="10" class="icon tooltip"></i>
      <?php endif; ?>
      </span>
      <textarea class="large-text" cols="45" rows="5" <?php $this->link(); ?>>
        <?php echo esc_textarea( $this->value() ); ?>
      </textarea>
    </label>
    <?php
  }


}