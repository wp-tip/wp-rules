jQuery(document).ready(function () {
	if ( jQuery( '#rule_conditions_container' ).length > 0 ) {
		jQuery(document).on( 'click', '#rule_condition_add_button', function( e ){
			e.preventDefault();

			//send ajax request to get new condition HTML.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'rules_condition_new',
					conditions_count: jQuery( '#rule_conditions_container .rule-condition' ).length,
					rule_condition_nonce: jQuery( '#rule_condition_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					jQuery( '#rule_conditions_container' ).append( response );
				}
			});
		} );

		jQuery(document).on( 'click', '.rule-condition-remove', function( e ){
			e.preventDefault();

			var this_button = jQuery(this);
			if ( confirm( 'Are you sure?' ) ) {
				this_button.parents( '.rule-condition-container' ).remove();
			}
		});

		jQuery( document ).on( 'change', '.rule-condition .rule-condition-list', function( e ){
			var this_condition_list = jQuery(this);
			var this_rule_condition = this_condition_list.parents( '.rule-condition' );
			var selected_condition = this_condition_list.find( 'option:selected' ).val();

			this_rule_condition.find('.rule-condition-options-container').html( '....' );

			//Send the ajax request.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'refresh_condition_options',
					condition: selected_condition,
					post_id: jQuery( '#post_ID' ).val(),
					number: this_rule_condition.data( 'number' ),
					nonce: jQuery( '#rule_condition_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					this_rule_condition.find('.rule-condition-options-container').html( response );
				}
			});
		});

	}
});
