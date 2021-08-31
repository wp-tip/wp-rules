<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class PostClassRemove
 *
 * @package WP_Rules\Actions
 */
class PostClassRemove extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'post_class_remove',
			'name'        => __( 'Remove class from post', 'rules' ),
			'description' => __( 'Remove class from the list of CSS class names for the current post.', 'rules' ),
			'group'       => __( 'Posts', 'rules' ),
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
				'label' => __( 'Class to remove', 'rules' ),
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
			'post_class',
			function ( $classes ) use ( $action_options ) {
				return array_filter(
					$classes,
					function ( $item ) use ( $action_options ) {
						return $item !== $action_options['class_name'];
					}
				);
			}
		);
	}

}
