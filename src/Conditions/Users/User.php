<?php
namespace WP_Rules\Conditions\Users;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class User
 *
 * @package WP_Rules\Conditions
 */
class User extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'loggedin-user',
			'name'        => __( 'Current logged-in user', 'rules' ),
			'description' => __( 'Check whether the current user is a specific user.', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Current logged-in user', 'rules' ),
				'name'    => 'loggedin_user',
				'options' => $this->get_users_list(),
			],
		];
	}

	/**
	 * Get list of all system users.
	 *
	 * @return array user ID => Display name - email
	 */
	private function get_users_list() {
		$users = get_users();

		if ( empty( $users ) ) {
			return [];
		}

		$output = [];
		foreach ( $users as $user ) {
			$output[ $user->ID ] = $user->display_name . ' - ' . $user->user_email;
		}
		return $output;
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
		$current_user_id = get_current_user_id();
		return $current_user_id === (int) $condition_options['loggedin_user'];
	}
}
