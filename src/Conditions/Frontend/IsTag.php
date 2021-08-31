<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsTag
 *
 * @package WP_Rules\Conditions
 */
class IsTag extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-tag',
			'name'        => __( 'Is On Tag Archive Page', 'rules' ),
			'description' => __( 'Determines whether the query is for an existing tag archive page.', 'rules' ),
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
				'name'       => 'tag_ids',
				'label'      => __( 'Choose Tag(s)', 'rules' ),
				'type'       => 'select',
				'options'    => $this->get_tags_list(),
				'attributes' => [
					'multiple' => 'multiple',
				],
			],
		];
	}

	/**
	 * Get list of tags.
	 *
	 * @return array
	 */
	private function get_tags_list() {
		$tags_array = get_tags();
		if ( is_wp_error( $tags_array ) ) {
			return [];
		}

		$tags_list = [];

		foreach ( $tags_array as $tag ) {
			$tags_list[ $tag->term_id ] = $tag->name;
		}

		return $tags_list;
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
		return is_tag( ! empty( $condition_options['tag_ids'] ) ? $condition_options['tag_ids'] : '' );
	}
}
