<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;
use WPCF7_ContactForm;

/**
 * Class FormSubmitted
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7\Triggers
 */
class FormSubmitted extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'wpcf7_contact_form',
			'wp_action'          => 'wpcf7_contact_form',
			'description'        => __( 'When the ajax request is sent with the submission data.', 'rules' ),
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

	/**
	 * Validate trigger options by comparing options with trigger hook arguments.
	 *
	 * @param array $trigger_hook_args Array of Trigger hook arguments ( Associative ).
	 * @param array $trigger_options Array if Trigger saved options for each rule.
	 * @param int   $rule_post_id Current rule post ID.
	 *
	 * @return bool
	 */
	public function validate_trigger_options( $trigger_hook_args, $trigger_options, $rule_post_id ) {
		return wpbr_has_constant( 'REST_REQUEST' );
	}

}
