<?php
namespace WP_Rules\Conditions;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsTrackback
 *
 * @package WP_Rules\Conditions
 */
class IsTrackback extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'   => 'is-trackback',
			'name' => __( 'Is On Trackback Page', 'rules' ),
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
				'label'   => __( 'Visitor Is On Trackback Page', 'rules' ),
				'name'    => 'is_trackback',
				'options' => [
					'no'  => __( 'No', 'rules' ),
					'yes' => __( 'Yes', 'rules' ),
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
		return ( is_trackback() && 'yes' === $condition_options['is_trackback'] ) || ( ! is_trackback() && 'yes' !== $condition_options['is_trackback'] );
	}
}
