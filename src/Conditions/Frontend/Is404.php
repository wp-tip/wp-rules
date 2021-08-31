<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class Is404
 *
 * @package WP_Rules\Conditions
 */
class Is404 extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-404',
			'name'        => __( 'Is On 404 Page', 'rules' ),
			'description' => __( 'Check if the user is on 404 not found page.', 'rules' ),
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
		return is_404();
	}
}
