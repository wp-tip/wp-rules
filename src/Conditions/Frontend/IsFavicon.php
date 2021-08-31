<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsFavicon
 *
 * @package WP_Rules\Conditions
 */
class IsFavicon extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-favicon',
			'name'        => __( 'Is Loading favicon.ico', 'rules' ),
			'description' => __( 'Check whether the favicon is being loaded.', 'rules' ),
			'group'       => __( 'Frontend', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [];
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
		return ( is_favicon() && 'yes' === $condition_options['is_favicon'] ) || ( ! is_favicon() && 'yes' !== $condition_options['is_favicon'] );
	}
}
