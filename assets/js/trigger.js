jQuery(document).ready(function () {
	if ( jQuery( '#rule_trigger_options_container' ).length > 0 ) {
		jQuery( '#rule_trigger_field select' ).change(function() {
			var this_select = jQuery(this);
			var selected_trigger = this_select.find( 'option:selected' ).val();

			jQuery( '#rule_trigger_options_container' ).html( '....' );

			//Send the ajax request.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'refresh_trigger_options',
					trigger: selected_trigger,
					post_id: jQuery( '#post_ID' ).val(),
					nonce: jQuery( '#rule_trigger_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					jQuery( '#rule_trigger_options_container' ).html( response );
				}
			});
		});
	}
});
