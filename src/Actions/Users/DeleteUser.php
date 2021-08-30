<?php
namespace WP_Rules\Actions\Users;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class DeleteUser
 *
 * @package WP_Rules\Actions
 */
class DeleteUser extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'delete_user',
			'name'        => __( 'Delete User', 'rules' ),
			'description' => __( 'Delete a user by ID, you may use user ID as a number or a variable.', 'rules' ),
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
		if ( empty( $action_options['ID'] ) ) {
			return;
		}

		if ( ! function_exists( 'wp_delete_user' ) ) {
			require_once wpbr_get_constant( 'ABSPATH' ) . 'wp-admin/includes/user.php';
		}

		wp_delete_user( $action_options['ID'] );
	}

}
