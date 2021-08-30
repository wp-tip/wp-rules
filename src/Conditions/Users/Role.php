<?php
namespace WP_Rules\Conditions\Users;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class Role
 *
 * @package WP_Rules\Conditions
 */
class Role extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'role',
			'name'        => __( 'Current logged-in user role', 'rules' ),
			'description' => __( 'Check whether the current user has the specified role.', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Current logged-in user role', 'rules' ),
				'name'    => 'loggedin_role',
				'options' => $wp_roles->get_names(),
			],
		];
	}

	/**
	 * Evaluate current condition.
	 *
	 * @param array $condition_options Condition Options array.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return bool If it passes or not.
	 */
	protected function evaluate( $condition_options, $trigger_hook_args ) {
		$user = wp_get_current_user();
		return in_array( $condition_options['loggedin_role'], (array) $user->roles, true );
	}
}
