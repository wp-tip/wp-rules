<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;
use WPCF7_ContactForm;

/**
 * Class MailSent
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7\Triggers
 */
class MailSent extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'wpcf7_mail_sent',
			'wp_action'          => 'wpcf7_mail_sent',
			'name'               => __( 'Contact Form 7 - Mail sent', 'rules' ),
			'description'        => __( 'Email sent successfully.', 'rules' ),
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
