<?php
namespace WP_Rules\Conditions\Users;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class CurrentUserCapability
 *
 * @package WP_Rules\Conditions
 */
class CurrentUserCapability extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'current-user-capability',
			'name'        => __( 'Current User Has Capability', 'rules' ),
			'description' => __( 'Check whether the current user has the specified capability.', 'rules' ),
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
				'label'   => __( 'Choose User Capability', 'rules' ),
				'name'    => 'cap_id',
				'options' => $this->get_capabilities_list(),
			],
		];
	}

	/**
	 * Get list of all capabilities.
	 *
	 * @return array
	 */
	private function get_capabilities_list() {
		// Get super admin capabilities.
		$super_admins_usernames = get_super_admins();
		if ( empty( $super_admins_usernames ) ) {
			return [];
		}

		$suer_admin = get_user_by( 'login', $super_admins_usernames[0] );

		$caps = [];
		foreach ( $suer_admin->allcaps as $cap_key => $cap ) {
			if ( $cap ) {
				$caps[ $cap_key ] = $cap_key;
			}
		}

		return $caps;

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
		return current_user_can( $condition_options['cap_id'] );
	}
}
