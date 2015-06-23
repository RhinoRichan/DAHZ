( function( api ) {

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

})(wp.customize);