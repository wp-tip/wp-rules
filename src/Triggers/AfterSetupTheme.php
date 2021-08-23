<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AfterSetupTheme
 *
 * @package WP_Rules\Triggers
 */
class AfterSetupTheme extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'after_setup_theme',
			'wp_action'          => 'after_setup_theme',
			'name'               => __( 'After Theme Setup', 'rules' ),
			'description'        => __( 'Fires after the theme is loaded.', 'rules' ),
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
