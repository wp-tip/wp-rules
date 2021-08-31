<?php
namespace WP_Rules\Conditions\Users;

use WP_Rules\Core\Admin\Condition\AbstractCondition;
use WP_User_Query;

/**
 * Class CurrentUserMeta
 *
 * @package WP_Rules\Conditions
 */
class CurrentUserMeta extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'current-user-meta',
			'name'        => __( 'Current User Has Meta', 'rules' ),
			'description' => __( 'Check if the current user has meta.', 'rules' ),
			'group'       => __( 'Users', 'rules' ),
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
				'type'  => 'text',
				'label' => __( 'Meta Key', 'rules' ),
				'name'  => 'meta_key',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Operator', 'rules' ),
				'name'    => 'meta_operator',
				'options' => $this->get_operators_list(),
			],
			[
				'type'  => 'text',
				'label' => __( 'Meta Value', 'rules' ),
				'name'  => 'meta_value',
			],
		];
	}

	/**
	 * Get list of all operators.
	 *
	 * @return array
	 */
	private function get_operators_list() {
		return [
			'='          => __( 'Equals', 'rules' ),
			'!='         => __( 'Not Equals', 'rules' ),
			'>'          => __( 'Greater Than', 'rules' ),
			'>='         => __( 'Greater Than Or Equals', 'rules' ),
			'<'          => __( 'Less Than', 'rules' ),
			'<='         => __( 'Less Than Or Equals', 'rules' ),
			'LIKE'       => __( 'Like', 'rules' ),
			'NOT LIKE'   => __( 'Not Like', 'rules' ),
			'EXISTS'     => __( 'Exists', 'rules' ),
			'Not EXISTS' => __( 'Not Exists', 'rules' ),
			'REGEXP'     => __( 'Regular Expressions', 'rules' ),
			'Not REGEXP' => __( 'Not Regular Expressions', 'rules' ),
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
		$args       = [
			'include'      => [ get_current_user_id() ],
			'meta_key'     => $condition_options['meta_key'], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'   => $condition_options['meta_value'], // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'meta_compare' => $condition_options['meta_operator'],
		];
		$user_query = new WP_User_Query( $args );

		return ! empty( $user_query->get_total() );

	}
}
