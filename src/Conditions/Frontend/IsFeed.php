<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsFeed
 *
 * @package WP_Rules\Conditions
 */
class IsFeed extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-feed',
			'name'        => __( 'Is On Feed Page', 'rules' ),
			'description' => __( 'Check whether the user is on a feed page.', 'rules' ),
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
				'name'       => 'feed_types',
				'label'      => __( 'Feed Types', 'rules' ),
				'type'       => 'select',
				'options'    => [
					'rss2' => 'rss2',
					'atom' => 'atom',
					'rss'  => 'rss',
					'rdf'  => 'rdf',
				],
				'attributes' => [
					'multiple' => 'multiple',
				],
			],
		];
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
		return is_feed( ! empty( $condition_options['feed_types'] ) ? $condition_options['feed_types'] : '' );
	}
}
