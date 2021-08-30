<?php
namespace WP_Rules\Actions\Users;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class CreateUser
 *
 * @package WP_Rules\Actions
 */
class CreateUser extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'create_user',
			'name'        => __( 'Create User', 'rules' ),
			'description' => __( 'Create a new user at the system.', 'rules' ),
			'group'       => __( 'Users', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		global $wp_roles;
		return [
			[
				'type'  => 'text',
				'label' => __( 'First Name', 'rules' ),
				'name'  => 'first_name',
			],
			[
				'type'  => 'text',
				'label' => __( 'Last Name', 'rules' ),
				'name'  => 'last_name',
			],
			[
				'type'  => 'text',
				'label' => __( 'Username', 'rules' ),
				'name'  => 'user_login',
			],
			[
				'type'  => 'text',
				'label' => __( 'Password', 'rules' ),
				'name'  => 'user_pass',
			],
			[
				'type'  => 'text',
				'label' => __( 'Email', 'rules' ),
				'name'  => 'user_email',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Role', 'rules' ),
				'name'    => 'role',
				'options' => $wp_roles->get_names(),
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
		wp_insert_user( $action_options );
	}

}
