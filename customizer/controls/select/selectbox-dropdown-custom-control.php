<?php

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * Class to create a custom text description control, extend the WP customizer
 *
 * @since 1.2.0
 */
  class DAHZ_Selectbox_Dropdown_Control extends WP_Customize_Control {

    public $type = 'select';
    public $mode = 'select';
    public $direction = 'auto'; // upward, down

    public function enqueue() {
    $suffix = dahz_get_min_suffix();
     wp_enqueue_script( 'dahz-api-controls' );
     wp_enqueue_style( 'customize-semantic-dropdown', DF_CORE_CSS_DIR . 'dropdown'.$suffix.'.css', null, null);
    }

    public function to_json()
    {
      parent::to_json();

      // The setting value.
      $this->json['value'] = $this->value();
      // The control choices.
      $this->json['choices'] = $this->choices;
      // The data link.
      $this->json['link'] = $this->get_link();
      // The direction box
      $this->json['dir'] = $this->direction;

      $this->json['mode'] = ( 'search' == $this->mode ) ? 'selectbox-search ui search selection dropdown' : 'selectbox';

      $this->json['ddClass'] = implode( " ", array( $this->json['mode'], $this->json['dir'] ) );

    }

    public function content_template()
    { ?>

    <# if ( ! data.choices ) {
    return;
    } #>

    <label>
      <# if ( data.label ) { #>
    <span class="customize-control-title">
    {{ data.label }}

    <# if ( data.description )  { #>
    <i data-content="{{{ data.description }}}" data-position="bottom right" class="icon tooltip"></i>
    <# } #>

    </span>
    <# } #>
   </label>

   <select class="{{{ data.ddClass }}}" {{{ data.link }}}>

    <# for ( key in data.choices ) { #>

        <option value="{{ key }}" <# if ( key === data.value ) { #> selected="selected" <# } #>>{{ data.choices[ key ] }}</option>

    <# } #>

  </select>

  <?php  }

  }
