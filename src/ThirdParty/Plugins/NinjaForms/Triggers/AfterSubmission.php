<?php
namespace WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AfterSubmission
 *
 * @package WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers
 */
class AfterSubmission extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'ninja_forms_after_submission',
			'wp_action'          => 'ninja_forms_after_submission',
			'name'               => __( 'Ninja Forms after submission', 'rules' ),
			'description'        => __( 'After visitor submits the form.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'form_data',
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

}
