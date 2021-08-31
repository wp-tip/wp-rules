<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;
use WPCF7_ContactForm;

/**
 * Class BeforeSendEmail
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7\Triggers
 */
class BeforeSendEmail extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'wpcf7_before_send_mail',
			'wp_action'          => 'wpcf7_before_send_mail',
			'name'               => __( 'Contact Form 7 - Before sending mail', 'rules' ),
			'description'        => __( 'Before sending the email trigger, this has `cf7form` variable that contains everything related to the form, from form settings till submitted data.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'cf7form',
			],
		];
	}

	/**
	 * Return trigger options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [];
	}

	/**
	 * Register variable value (convert object to array).
	 *
	 * @param string $variable_name Variable name.
	 * @param mixed  $variable_value Variable value to be converted.
	 *
	 * @return array
	 */
	protected function register_variable( $variable_name, $variable_value ) {
		if ( 'cf7form' !== $variable_name || ! ( $variable_value instanceof WPCF7_ContactForm ) ) {
			return null;
		}

		return array_merge(
			[
				'form_id' => $variable_value->id(),
			],
			(array) $variable_value->get_properties()
		);

	}

}
