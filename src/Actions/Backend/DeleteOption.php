<?php
namespace WP_Rules\Actions\Backend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class DeleteOption
 *
 * @package WP_Rules\Actions
 */
class DeleteOption extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'delete_option',
			'name'        => __( 'Delete Option', 'rules' ),
			'description' => __( 'Delete site option by key.', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
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
				'label' => __( 'Option Name', 'rules' ),
				'name'  => 'option_name',
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
		if ( empty( $action_options['option_name'] ) ) {
			return;
		}

		if ( ! get_option( $action_options['option_name'] ) ) {
			return;
		}

		delete_option( $action_options['option_name'] );
	}

}
