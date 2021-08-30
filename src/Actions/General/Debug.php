<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class Debug
 *
 * @package WP_Rules\Actions
 */
class Debug extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'debug',
			'name'        => __( 'Debug', 'rules' ),
			'description' => __( 'This will print a message then die so be careful when using it.', 'rules' ),
			'group'       => __( 'General', 'rules' ),
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
		wp_die( 'This is a test message to make sure that rule evaluation works properly!' );
	}

}
