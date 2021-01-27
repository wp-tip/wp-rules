<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class SavePost
 *
 * @package WP_Rules\Triggers
 */
class SavePost extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                    => 'wp_insert_post',
			'wp_action'             => 'wp_insert_post',
			'name'                  => __( 'Save Post', 'rules' ),
			'wp_action_priority'    => 10,
			'wp_action_args' => [
				'post_id',
				'post',
				'update'
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
				'name' => 'newpost',
				'label' => __( 'New Post or Update', 'rules' ),
				'type' => 'select',
				'options' => [
					0 => __( 'New Post', 'rules' ),
					1 => __( 'Edit Post', 'rules' )
				]
			],
			[
				'name' => 'post_type',
				'label' => __( 'Post Types', 'rules' ),
				'type' => 'select',
				'options' => $post_types
			],
		];
	}

	private function get_post_types_list() {
		$post_types_array = get_post_types([ 'show_ui' => true ], 'objects');
		$post_types_list = [];

		foreach ($post_types_array as $post_type) {
			$post_types_list[$post_type->name] = $post_type->labels->singular_name;
		}

		return $post_types_list;
	}

	public function validate_trigger_options( $trigger_hook_args, $trigger_options, $rule_post_id ) {

	}

}
