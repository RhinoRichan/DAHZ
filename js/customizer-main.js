( function($) {

var api = wp.customize, customControls;

customControls = {

	cache: {},

	init : function() {
			// Populate cache
		  this.cache.$buttonset  = $('.df-radio-control-buttonset, .df-radio-control-image');
		  this.cache.$range      = $('.input_df_slider_text');
			this.cache.$tooltip 	 = 	$( '.tooltip' );
			this.cache.$selectbox   = $('.selectbox, .selectbox-search');

			// Initialize Button sets
			if (this.cache.$selectbox.length > 0) {
				this.select_dropdown();
			}

			// Initialize Button sets
			if (this.cache.$buttonset.length > 0) {
				this.buttonset();
			}

			// Initialize tooltip
			if (this.cache.$tooltip.length > 0) {
				this.tooltip();
			}

			// Initialize ranges
			if (this.cache.$range.length > 0) {
				this.range();
			}

	},

	// Select dropdown
	select_dropdown: function() {
	this.cache.$selectbox.dropdown();
	},

	// Radio Buttonset
	buttonset: function() {
  	this.cache.$buttonset.buttonset();
	},

	// Tooltip
	tooltip: function() {
		this.cache.$tooltip.popup({
				className   : {
								popup       : 'ui popup small'
							}
			});
	},

	// Slider Range
	range: function(){

		this.cache.$range.each(function() {
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

})( jQuery );
