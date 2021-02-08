<?php
namespace WP_Rules\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class Debug
 *
 * @package WP_Rules\Triggers
 */
class Debug extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'   => 'debug',
			'name' => __( 'Debug.', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [];
	}

	/**
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		wp_die("This is a test message to make sure that rule evaluation works properly!");
	}

}
