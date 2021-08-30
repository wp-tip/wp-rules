<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsFrontPage
 *
 * @package WP_Rules\Conditions
 */
class IsFrontPage extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-front-page',
			'name'        => __( 'Is On Front Page', 'rules' ),
			'description' => __(
				'Check whether the user is on front page.
				This is for what is displayed at your site\'s main URL.Depends on the site\'s "Front page displays" Reading Settings \'show_on_front\' and \'page_on_front\'.
				If you set a static page for the front page of your site, this condition will be triggered when viewing that page.',
				'rules'
			),
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
		return is_front_page();
	}
}
