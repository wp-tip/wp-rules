<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class RemoveImageSize
 *
 * @package WP_Rules\Actions
 */
class RemoveImageSize extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'remove_image_size',
			'name'        => __( 'Remove Image Size', 'rules' ),
			'description' => __( 'Remove registered image size by its name.', 'rules' ),
			'group'       => __( 'General', 'rules' ),
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
				'label' => __( 'Name', 'rules' ),
				'name'  => 'name',
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
		if ( empty( $action_options['name'] ) ) {
			return;
		}

		if ( ! has_image_size( $action_options['name'] ) ) {
			return;
		}

		remove_image_size( $action_options['name'] );
	}

}
