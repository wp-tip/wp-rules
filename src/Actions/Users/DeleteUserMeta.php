<?php
namespace WP_Rules\Actions\Users;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class DeleteUserMeta
 *
 * @package WP_Rules\Actions
 */
class DeleteUserMeta extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'delete_user_meta',
			'name'        => __( 'Delete User Meta', 'rules' ),
			'description' => __( 'Delete user meta by user ID and meta key.', 'rules' ),
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
				'label' => __( 'Meta Key', 'rules' ),
				'name'  => 'meta_key',
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
		if ( empty( $action_options['ID'] ) || empty( $action_options['meta_key'] ) ) {
			return;
		}

		delete_user_meta( $action_options['ID'], $action_options['meta_key'] );
	}

}
