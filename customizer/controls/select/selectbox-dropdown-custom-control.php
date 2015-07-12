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
    public $direction = ''; // upward, down

    public function enqueue() {
    $suffix = dahz_get_min_suffix();
     wp_enqueue_style( 'customize-semantic-dropdown', DF_CORE_CSS_DIR . 'dropdown'.$suffix.'.css', null, null);
    }

    /**
     * Render the content on the theme customizer page
     * TODO: Use content_template func
     */
    public function render_content() {

        if ( empty( $this->choices ) ){
          return;
        }


        $ids  = $this->id;
        $name = '_customize-select-' . $ids;
        $dir = $this->direction;
        $class = ( 'search' == $this->mode ) ? 'selectbox-search ui search selection dropdown' : 'selectbox';
        $dropdown_classes = implode( " ", array( $class, $dir ) );
        ?>

        <label>
        <?php if ( ! empty( $this->label ) ) : ?>
            <span class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>

            <?php if ( ! empty( $this->description ) ) : ?>
            <i data-content="<?php echo $this->description; ?>" data-position="bottom right" class="icon tooltip"></i>
            <?php endif; ?>

            </span>
          <?php endif; ?>
        </label>

      <select <?php $this->link(); ?> name="<?php echo esc_attr( $name ); ?>" class="<?php echo $dropdown_classes; ?>">
      <?php foreach ( $this->choices as $value => $label ): ?>
          <option value="<?php echo esc_attr( $value ) ?>" <?php selected( $this->value(), $value, false ); ?>><?php echo $label; ?></option>
      <?php endforeach; ?>
      </select>

        <?php

    }
  }
