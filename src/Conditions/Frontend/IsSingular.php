<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsSingular
 *
 * @package WP_Rules\Conditions
 */
class IsSingular extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-singular',
			'name'        => __( 'Is On Single Post Type Page', 'rules' ),
			'description' => __( 'Determines whether the query is for an existing single post of any post type (post, attachment, page, custom post types).', 'rules' ),
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
				'name'       => 'post_types',
				'label'      => __( 'Post Types', 'rules' ),
				'type'       => 'select',
				'options'    => $this->get_post_types_list(),
				'attributes' => [
					'multiple' => 'multiple',
				],
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
		$post_types_list  = [];

		foreach ( $post_types_array as $post_type ) {
			$post_types_list[ $post_type->name ] = $post_type->labels->singular_name;
		}

		return $post_types_list;
	}

	/**
	 * Evaluate current condition.
	 *
	 * @param array $condition_options Condition Options array.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return bool If it passes or not.
	 */
	protected function evaluate( $condition_options, $trigger_hook_args ) {
		return is_singular( ! empty( $condition_options['post_types'] ) ? $condition_options['post_types'] : '' );
	}
}
