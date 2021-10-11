jQuery(document).ready(function () {

	var rules_template_id = '';
	var rules_nonce = '';

	jQuery('[data-bg]').each(function (key, item) {
		jQuery(this).css('background-image', 'url(' + jQuery(this).data('bg') + ')');
	});

	jQuery('.rules-content__templates_item').click( function(){
		let template_id = jQuery(this).data( 'template_id' );
		let templates_section = jQuery( '#rules-content__templates' );

		let template_title = jQuery(this).find('.rules-content__templates_item_title').html();
		let template_thumbnail_img = jQuery(this).find('.rules-content__templates_item_thumbnail').data('bg');

		jQuery('#rules-settings__template_thumbnail_img').attr( 'src', template_thumbnail_img );
		jQuery('#rules-settings__template_title').html( template_title );

		jQuery('#rules-settings__fields').html('...');

		templates_section.slideUp( 'slow', function () {
			if ( template_id ) {
				jQuery( '#rules-content__settings' ).slideDown('slow').css('display', 'grid');

				jQuery('#rules-footer').fadeIn('slow');

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
						rules_show_settings(response);
					}
				});
			}
		} );
	} );

	function rules_show_settings(settings_response) {
		settings_response = JSON.parse(settings_response);

		rules_template_id = settings_response.template_id;

		if (settings_response.has_options) {
			rules_nonce = settings_response.save_rule_nonce;
			jQuery('#rules-settings__fields').html(settings_response.options_html);
		}
	}

	jQuery('#rules_template_save').click( function (event) {
		event.preventDefault();

		if ( ! rules_template_id ) {
			return;
		}

		//Send ajax request to save the new business rule and redirect to it.
		jQuery.ajax({
			url: ajaxurl,
			dataType: "json",
			data: jQuery('#rules-settings__fields').serialize() + '&action=rules_save_new&rules_nonce=' + rules_nonce + '&template_id=' + rules_template_id,
			type: 'POST',
			success: function( response ) {
				window.location.href = (response.rule_post_edit_url).replace(/&amp;/g, '&');
			}
		});

	} );

});
