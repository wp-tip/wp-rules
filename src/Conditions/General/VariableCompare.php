<?php
namespace WP_Rules\Conditions\General;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class VariableCompare
 *
 * @package WP_Rules\Conditions
 */
class VariableCompare extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'variable-compare',
			'name'        => __( 'Variable Compare', 'rules' ),
			'description' => __( 'Compare variable with predefined value.', 'rules' ),
			'group'       => __( 'General', 'rules' ),
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
				'label' => __( 'Variable', 'rules' ),
				'name'  => 'variable',
			],

			[
				'type'    => 'select',
				'label'   => __( 'Operator', 'rules' ),
				'name'    => 'operator',
				'options' => [
					'='           => __( 'Equals', 'rules' ),
					'!='          => __( 'Not Equals', 'rules' ),
					'>'           => __( 'Greater Than', 'rules' ),
					'>='          => __( 'Greater Than Or Equals', 'rules' ),
					'<'           => __( 'Less Than', 'rules' ),
					'<='          => __( 'Less Than Or Equals', 'rules' ),
					'contain'     => __( 'Contains', 'rules' ),
					'not_contain' => __( 'Doesn\'t Contain', 'rules' ),
				],
			],

			[
				'type'  => 'text',
				'label' => __( 'Reference Value', 'rules' ),
				'name'  => 'ref_value',
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
		switch ( $condition_options['operator'] ) {
			case '!=':
				return $condition_options['variable'] !== $condition_options['ref_value'];
			case '>':
				return $condition_options['variable'] > $condition_options['ref_value'];
			case '>=':
				return $condition_options['variable'] >= $condition_options['ref_value'];
			case '<':
				return $condition_options['variable'] < $condition_options['ref_value'];
			case '<=':
				return $condition_options['variable'] <= $condition_options['ref_value'];
			case 'contain':
				return false !== stripos( $condition_options['variable'], $condition_options['ref_value'] );
			case 'not_contain':
				return ! ( false !== stripos( $condition_options['variable'], $condition_options['ref_value'] ) );
			case '=':
			default:
				return $condition_options['variable'] === $condition_options['ref_value'];
		}
	}
}
