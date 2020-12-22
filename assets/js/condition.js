jQuery(document).ready(function () {
	if ( jQuery( '#rule_conditions_container' ).length > 0 ) {
		jQuery(document).on( 'click', '#rule_condition_add_button', function( e ){
			e.preventDefault();

			//send ajax request to get new condition HTML.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'rules_condition_new',
					conditions_count: jQuery( '#rule_conditions_container .rule_condition' ).length,
					rule_condition_nonce: jQuery( '#rule_condition_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					jQuery( '#rule_conditions_container' ).append( response );
				}
			});
		} );

		jQuery(document).on( 'click', '.rule_condition_remove', function( e ){
			e.preventDefault();

			var this_button = jQuery(this);
			if ( confirm( 'Are you sure?' ) ) {
				this_button.parent( '.rules-field-container' ).remove();
			}
		});

	}
});
