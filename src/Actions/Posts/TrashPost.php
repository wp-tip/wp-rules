<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class TrashPost
 *
 * @package WP_Rules\Actions
 */
class TrashPost extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'trash_post',
			'name'        => __( 'Trash Post', 'rules' ),
			'description' => __( 'Send a post to the trash, you may use post ID as a number or a variable.', 'rules' ),
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
				'label' => __( 'Post ID', 'rules' ),
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

		wp_trash_post( $action_options['ID'] );
	}

}
