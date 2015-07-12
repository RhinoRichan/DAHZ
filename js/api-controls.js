( function( $, api ) {

	// Layout Picker
	api.controlConstructor['images_radio'] = api.Control.extend( {
		ready: function() {
			var control = this;

			control.container.on( 'change', 'input:radio',
				function() {
					control.setting.set( jQuery( this ).val() );
				}
			);
		}
	} );

  // Selectbox
	api.controlConstructor['select'] = api.Control.extend( {
    ready: function() {
        var control = this;

        control.container.on( 'change', 'select',
            function() {
                control.setting.set( jQuery( this ).val() );
            }
        );
    }
} );

})( jQuery, wp.customize );
