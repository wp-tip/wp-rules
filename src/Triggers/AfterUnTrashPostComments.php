<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AfterUnTrashPostComments
 *
 * @package WP_Rules\Triggers
 */
class AfterUnTrashPostComments extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'untrashed_post_comments',
			'wp_action'          => 'untrashed_post_comments',
			'name'               => __( 'After Un Trash Post Comments', 'rules' ),
			'description'        => __( 'Fires after comments are restored for a post from the Trash.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'post_id',
			],
		];
	}

	/**
	 * Return trigger options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		$post_types = $this->get_post_types_list();
		return [
			[
				'name'    => 'post_type',
				'label'   => __( 'Post Types', 'rules' ),
				'type'    => 'select',
				'options' => $post_types,
			],
		];
	}

	/**
	 * Get list of current registered post types.
	 *
	 * @return array
	 */
	private function get_post_types_list() {
		$post_types_array = get_post_types( [ 'show_ui' => true ], 'objects' );
		$post_types_list  = [
			0 => __( 'All post types', 'rules' ),
		];

		foreach ( $post_types_array as $post_type ) {
			$post_types_list[ $post_type->name ] = $post_type->labels->singular_name;
		}

		return $post_types_list;
	}

	/**
	 * Validate trigger options by comparing options with trigger hook arguments.
	 *
	 * @param array $trigger_hook_args Array of Trigger hook arguments ( Associative ).
	 * @param array $trigger_options Array if Trigger saved options for each rule.
	 * @param int   $rule_post_id Current rule post ID.
	 *
	 * @return bool
	 */
	public function validate_trigger_options( $trigger_hook_args, $trigger_options, $rule_post_id ) {
		return empty( $trigger_options['post_type'] ) || get_post_type( $trigger_hook_args['post_id'] ) === $trigger_options['post_type'];
	}

}
