<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AddImageSize
 *
 * @package WP_Rules\Actions
 */
class AddImageSize extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'add_image_size',
			'name'        => __( 'Add Image Size', 'rules' ),
			'description' => __( 'Register a new image size.', 'rules' ),
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
			[
				'type'  => 'text',
				'label' => __( 'Width', 'rules' ),
				'name'  => 'width',
			],
			[
				'type'  => 'text',
				'label' => __( 'Height', 'rules' ),
				'name'  => 'height',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Crop', 'rules' ),
				'name'    => 'crop',
				'options' => [
					0 => __( 'No', 'rules' ),
					1 => __( 'Yes', 'rules' ),
				],
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
		if ( empty( $action_options['name'] ) || empty( $action_options['width'] ) || empty( $action_options['height'] ) ) {
			return;
		}

		if ( has_image_size( $action_options['name'] ) ) {
			return;
		}

		add_image_size( $action_options['name'], $action_options['width'], $action_options['height'], (bool) $action_options['crop'] ?? false );
	}

}
