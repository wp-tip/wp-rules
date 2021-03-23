<?php
namespace WP_Rules\Conditions;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsLoggedin
 *
 * @package WP_Rules\Conditions
 */
class IsLoggedin extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'   => 'is-loggedin',
			'name' => __( 'Is Loggedin', 'rules' ),
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
				'label'   => __( 'User is logged-in', 'rules' ),
				'name'    => 'is_loggedin',
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
		return ( is_user_logged_in() && 'yes' === $condition_options['is_loggedin'] ) || ( ! is_user_logged_in() && 'yes' !== $condition_options['is_loggedin'] );
	}
}
