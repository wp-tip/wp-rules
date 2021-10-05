jQuery(document).ready(function () {

	jQuery('.rules-content__templates_item').click( function(){
		let template_id = jQuery(this).data( 'template_id' );
		let templates_section = jQuery( '#rules-content__templates' );

		templates_section.hide();

		if ( ! template_id ) {
			jQuery( '#wpbody' ).show();
			return;
		}

		//Send ajax request to get template details.
		jQuery.ajax({
			url: ajaxurl,
			data: {
				action: 'rules_template_details',
				template_nonce: jQuery( '#rule_template_nonce' ).val(),
				template_id: template_id
			},
			type: 'POST',
			success: function( response ) {
				jQuery('#rules-content__settings').show();
			}
		});
	} );

});
