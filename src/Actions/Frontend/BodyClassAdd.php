<?php
namespace WP_Rules\Actions\Frontend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class BodyClassAdd
 *
 * @package WP_Rules\Actions
 */
class BodyClassAdd extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'body_class_add',
			'name'        => __( 'Add class to body tag', 'rules' ),
			'description' => __( 'Add class to the list of CSS body class names for the current post or page.', 'rules' ),
			'group'       => __( 'Frontend', 'rules' ),
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
				'label' => __( 'Class to add', 'rules' ),
				'name'  => 'class_name',
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
		if ( empty( $action_options['class_name'] ) ) {
			return;
		}

		add_filter(
			'body_class',
			function ( $classes ) use ( $action_options ) {
				$classes[] = $action_options['class_name'];
				return $classes;
			}
		);
	}

}
