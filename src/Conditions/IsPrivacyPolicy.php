<?php
namespace WP_Rules\Conditions;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsPrivacyPolicy
 *
 * @package WP_Rules\Conditions
 */
class IsPrivacyPolicy extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'   => 'is-privacy-policy',
			'name' => __( 'Is On Privacy Policy Page', 'rules' ),
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
				'label'   => __( 'Visitor Is On Privacy Policy Page', 'rules' ),
				'name'    => 'is_privacy_policy',
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
		return ( is_privacy_policy() && 'yes' === $condition_options['is_privacy_policy'] ) || ( ! is_privacy_policy() && 'yes' !== $condition_options['is_privacy_policy'] );
	}
}
