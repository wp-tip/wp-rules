<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class PostPasswordProtected
 *
 * @package WP_Rules\Actions
 */
class PostPasswordProtected extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'post_password_protected',
			'name'        => __( 'Make post password protected', 'rules' ),
			'description' => __( 'Protect the post with password, you may add dynamic password using variables.', 'rules' ),
			'group'       => __( 'Posts', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type'  => 'text',
				'label' => __( 'Password', 'rules' ),
				'name'  => 'password',
			],
		];
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
		if ( empty( $action_options['password'] ) ) {
			return;
		}

		if ( empty( $GLOBALS['post'] ) ) {
			return;
		}

		$GLOBALS['post']->post_password = $action_options['password'];
	}

}
