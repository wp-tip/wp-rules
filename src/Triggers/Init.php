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
			'id'                 => 'init',
			'wp_action'          => 'init',
			'name'               => __( 'WordPress initialize', 'rules' ),
			'description'        => __(
				'Fires after WordPress has finished loading but before any headers are sent,
				Most of WP is loaded at this stage, and the user is authenticated. WP continues to load on the ‘init’ hook that follows (e.g. widgets),
				and many plugins instantiate themselves on it for all sorts of reasons (e.g. they need a user, a taxonomy, etc.).',
				'rules'
				),
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
