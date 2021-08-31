<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class PostClassAdd
 *
 * @package WP_Rules\Actions
 */
class PostClassAdd extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'post_class_add',
			'name'        => __( 'Add class to post', 'rules' ),
			'description' => __( 'Add class to the list of CSS class names for the current post.', 'rules' ),
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
			'post_class',
			function ( $classes ) use ( $action_options ) {
				$classes[] = $action_options['class_name'];
				return $classes;
			}
		);
	}

}
