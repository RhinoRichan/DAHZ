jQuery(function($) {

var api = wp.customize, customControls;

customControls = {

	init : function() {
		  this.$buttonset  = $('.df-radio-control-buttonset, .df-radio-control-image');
		  this.$range      = $('.input_df_slider_text');
			this.$tooltip 	 = 	$( '.tooltip' );

			// Initialize Button sets
			if (this.$buttonset.length > 0) {
				this.buttonset();
			}

			// Initialize tooltip
			if (this.$tooltip.length > 0) {
				this.tooltip();
			}

			// Initialize ranges
			if (this.$range.length > 0) {
				this.range();
			}

	},

	// Radio Buttonset
	buttonset: function() {
  	this.$buttonset.buttonset();
	},

	// Tooltip
	tooltip: function() {
		this.$tooltip.popup({
				className   : {
								popup       : 'ui popup small'
							}
			});
	},

	// Slider Range
	range: function(){

		this.$range.each(function() {
				var $input = $(this),
					$slider = $input.parent().find('.slider_df_slider_text'),
					value = parseFloat( $input.val() ),
					min = parseFloat( $input.attr('min') ),
					max = parseFloat( $input.attr('max') ),
					step = parseFloat( $input.attr('step') );

				$slider.slider({
					value : value,
					min   : min,
					max   : max,
					step  : step,
					slide : function(e, ui) {
						$input.val(ui.value).keyup().trigger('change');
					}
				});
				$input.val( $slider.slider('value') );
				$input.on('keyup',function () {
				$slider.slider('value', this.value);
				});
			});

	}

};

// Load after Customizer initialization is complete.
jQuery(document).ready(function() {
	customControls.init();
});

});
