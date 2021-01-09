<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class Init
 *
 * @package WP_Rules\Triggers
 */
class Init extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                    => 'init',
			'wp_action'             => 'init',
			'name'                  => __( 'WordPress initialize', 'rules' ),
			'wp_action_priority'    => 10,
			'wp_action_args_number' => 0,
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
