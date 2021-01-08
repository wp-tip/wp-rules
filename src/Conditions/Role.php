<?php
namespace WP_Rules\Conditions;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class Role extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return void
	 */
	protected function init() {
		$this->id   = 'role';
		$this->name = __( 'Current logged-in user role', 'rules' );
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

	protected function evaluate( $condition_options, $trigger_hook_args ) {
		$user = wp_get_current_user();
		return in_array( $condition_options['loggedin_role'], (array) $user->roles );
	}
}
