<?php
namespace WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class BeforeResponse
 *
 * @package WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers
 */
class BeforeResponse extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'ninja_forms_before_response',
			'wp_action'          => 'ninja_forms_before_response',
			'name'               => __( 'Fires Before sending response to the form page.', 'rules' ),
			'description'        => __( '.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'response_data',
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
