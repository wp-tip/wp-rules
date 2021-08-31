<?php
namespace WP_Rules\Actions\Frontend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AuthRedirect
 *
 * @package WP_Rules\Actions
 */
class AuthRedirect extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'auth_redirect',
			'name'        => __( 'Require Login', 'rules' ),
			'description' => __( 'Checks if a user is logged in, if not it redirects them to the login page.', 'rules' ),
			'group'       => __( 'Frontend', 'rules' ),
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
		if ( is_user_logged_in() ) {
			return;
		}

		auth_redirect();
	}

}
