<?php
namespace WP_Rules\Conditions\Posts;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class CurrentPost
 *
 * @package WP_Rules\Conditions
 */
class CurrentPost extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'current-post',
			'name'        => __( 'Current Post', 'rules' ),
			'description' => __( 'Check if a user is on specific post page (frontend and backend).', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Choose Post', 'rules' ),
				'name'    => 'post_id',
				'options' => $this->get_posts_list(),
			],
		];
	}

	/**
	 * Get list of posts.
	 *
	 * @return array
	 */
	private function get_posts_list() {
		$post_list = get_posts(
			[
				'orderby'     => 'title',
				'sort_order'  => 'asc',
				'numberposts' => -1,
				'post_type'   => get_post_types( [ 'show_ui' => true ] ),
			]
			);

		$posts = [
			0 => __( 'Choose Post', 'rules' ),
		];

		foreach ( $post_list as $post ) {
			$posts[ $post->ID ] = get_post_type( $post ) . ' > ' . get_the_title( $post );
		}

		return $posts;
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
		global $post;
		return ! empty( $post ) && ! empty( $condition_options['post_id'] ) && (int) $condition_options['post_id'] === (int) $post->ID;
	}

}
