jQuery(document).ready(function () {
	if ( jQuery( '#rule_actions_container' ).length > 0 ) {
		jQuery(document).on( 'click', '#rule_action_add_button', function( e ){
			e.preventDefault();

			//send ajax request to get new action HTML.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'rules_action_new',
					actions_count: jQuery( '#rule_actions_container .rule-action' ).length,
					rule_action_nonce: jQuery( '#rule_action_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					jQuery( '#rule_actions_container' ).append( response );
				}
			});
		} );

		jQuery(document).on( 'click', '.rule-action-remove', function( e ){
			e.preventDefault();

			var this_button = jQuery(this);
			if ( confirm( 'Are you sure?' ) ) {
				this_button.parents( '.rule-action-container' ).remove();
			}
		});

		jQuery( document ).on( 'change', '.rule-action .rule-action-list', function( e ){
			var this_action_list = jQuery(this);
			var this_rule_action = this_action_list.parents( '.rule-action' );
			var selected_action = this_action_list.find( 'option:selected' ).val();

			this_rule_action.find('.rule-action-options-container').html( '....' );

			//Send the ajax request.
			jQuery.ajax({
				url: ajaxurl,
				data: {
					action: 'refresh_action_options',
					selected_action: selected_action,
					post_id: jQuery( '#post_ID' ).val(),
					number: this_rule_action.data( 'number' ),
					nonce: jQuery( '#rule_action_nonce' ).val()
				},
				type: 'POST',
				success: function( response ) {
					this_rule_action.find('.rule-action-options-container').html( response );
				}
			});
		});

	}
});
