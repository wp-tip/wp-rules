<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsPage
 *
 * @package WP_Rules\Conditions
 */
class IsPage extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-page',
			'name'        => __( 'Is on Page', 'rules' ),
			'description' => __( 'Determines whether the query is for an existing specific single page.', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Choose Page', 'rules' ),
				'name'    => 'page_id',
				'options' => $this->get_pages_list(),
			],
		];
	}

	/**
	 * Get list of pages.
	 *
	 * @return array
	 */
	private function get_pages_list() {
		$post_list = get_posts(
			[
				'orderby'     => 'title',
				'sort_order'  => 'asc',
				'numberposts' => -1,
				'post_type'   => 'page',
			]
			);

		$posts = [
			0 => __( 'Choose Page', 'rules' ),
		];

		foreach ( $post_list as $post ) {
			$posts[ $post->ID ] = get_the_title( $post ) . ' #' . $post->ID;
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
		return ! empty( $condition_options['page_id'] ) && is_page( (int) $condition_options['page_id'] );
	}

}
