<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class WPLoaded
 *
 * @package WP_Rules\Triggers
 */
class WPLoaded extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'wp_loaded',
			'wp_action'          => 'wp_loaded',
			'name'               => __( 'WordPress Loaded', 'rules' ),
			'description'        => __( 'Fires once WP, all plugins, and the theme are fully loaded and instantiated.', 'rules' ),
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
