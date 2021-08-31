<?php
namespace WP_Rules\Actions\Posts;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class PostContentReplace
 *
 * @package WP_Rules\Actions
 */
class PostExcerptReplace extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'post_excerpt_replace',
			'name'        => __( 'Replace in post excerpt', 'rules' ),
			'description' => __( 'Replaces a word with another in the post excerpt without changing it on Database, uses the filter `the_excerpt`.', 'rules' ),
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
				'label' => __( 'Search word', 'rules' ),
				'name'  => 'search',
			],
			[
				'type'  => 'text',
				'label' => __( 'Replace word', 'rules' ),
				'name'  => 'replace',
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
		if ( empty( $action_options['search'] ) ) {
			return;
		}

		add_filter(
			'the_excerpt',
			function ( $title ) use ( $action_options ) {
				return str_replace( $action_options['search'], $action_options['replace'] ?? '', $title );
			}
		);
	}

}
