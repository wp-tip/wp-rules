<?php
namespace WP_Rules\Conditions\Backend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsAdminInterface
 *
 * @package WP_Rules\Conditions
 */
class IsAdminInterface extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-admin-interface',
			'name'        => __( 'Is On admin Interface', 'rules' ),
			'description' => __( 'Check if the user is on any admin page, this can\'t be user with WordPress initialize trigger.', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
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
		return is_admin();
	}
}
