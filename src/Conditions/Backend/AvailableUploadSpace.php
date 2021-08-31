<?php
namespace WP_Rules\Conditions\Backend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class AvailableUploadSpace
 *
 * @package WP_Rules\Conditions
 */
class AvailableUploadSpace extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'available-upload-space',
			'name'        => __( 'Available Upload Space (multisite)', 'rules' ),
			'description' => __( 'Determines if there is any upload space left in the current blog\'s quota.', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
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
				'label'   => __( 'Operator', 'rules' ),
				'name'    => 'operator',
				'options' => [
					'='  => __( 'Equals', 'rules' ),
					'!=' => __( 'Not Equals', 'rules' ),
					'>'  => __( 'Greater Than', 'rules' ),
					'>=' => __( 'Greater Than Or Equals', 'rules' ),
					'<'  => __( 'Less Than', 'rules' ),
					'<=' => __( 'Less Than Or Equals', 'rules' ),
				],
			],

			[
				'type'  => 'text',
				'label' => __( 'Reference Value in Bytes', 'rules' ),
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
		if ( ! is_multisite() ) {
			return false;
		}

		$available_space = get_upload_space_available();
		switch ( $condition_options['operator'] ) {
			case '!=':
				return $available_space !== (int) $condition_options['ref_value'];
			case '>':
				return $available_space > (int) $condition_options['ref_value'];
			case '>=':
				return $available_space >= (int) $condition_options['ref_value'];
			case '<':
				return $available_space < (int) $condition_options['ref_value'];
			case '<=':
				return $available_space <= (int) $condition_options['ref_value'];
			case '=':
			default:
				return $available_space === (int) $condition_options['ref_value'];
		}
	}
}
