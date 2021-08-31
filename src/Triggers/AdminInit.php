<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class AdminInit extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'admin_init',
			'wp_action'          => 'admin_init',
			'name'               => __( 'Admin initialize', 'rules' ),
			'description'        => __( 'Fires as an admin screen or code is being initialized.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [],
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
