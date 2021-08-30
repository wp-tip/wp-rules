<?php
namespace WP_Rules\Conditions\General;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class CurrentPageUrl
 *
 * @package WP_Rules\Conditions
 */
class CurrentPageUrl extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'current-page-url',
			'name'        => __( 'Current Page', 'rules' ),
			'description' => __( 'Compare visitor\'s visited page url with predefined one.', 'rules' ),
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
				'label' => __( 'Page Url', 'rules' ),
				'name'  => 'page_url',
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
		return ! empty( $_SERVER['REQUEST_URI'] ) && site_url( esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) === $condition_options['page_url'];
	}
}
