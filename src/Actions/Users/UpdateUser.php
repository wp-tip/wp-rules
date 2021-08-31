<?php
namespace WP_Rules\Actions\Users;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class UpdateUser
 *
 * @package WP_Rules\Actions
 */
class UpdateUser extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'update_user',
			'name'        => __( 'Update User', 'rules' ),
			'description' => __( 'Update user details by user ID.', 'rules' ),
			'group'       => __( 'Users', 'rules' ),
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
				'label' => __( 'User ID', 'rules' ),
				'name'  => 'ID',
			],
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
				'options' => $this->get_roles_list(),
			],
		];
	}

	/**
	 * Get all roles list.
	 *
	 * @return array
	 */
	private function get_roles_list() {
		global $wp_roles;

		return array_merge( [ __( 'Choose Role', 'rules' ) ], $wp_roles->get_names() );
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
		$fields = [];

		foreach ( $this->admin_fields() as $admin_field ) {
			if ( empty( $action_options[ $admin_field['name'] ] ) ) {
				continue;
			}

			$fields[ $admin_field['name'] ] = $action_options[ $admin_field['name'] ];
		}

		wp_update_user( $fields );
	}

}
