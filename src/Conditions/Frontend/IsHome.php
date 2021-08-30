<?php
namespace WP_Rules\Conditions\Frontend;

use WP_Rules\Core\Admin\Condition\AbstractCondition;

/**
 * Class IsHome
 *
 * @package WP_Rules\Conditions
 */
class IsHome extends AbstractCondition {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'is-home',
			'name'        => __( 'Is On Blog Home Page', 'rules' ),
			'description' => __(
				'Check whether the user is on blog homepage.
			The blog homepage is the page that shows the time-based blog content of the site.
			It is dependent on the site\'s "Front page displays" Reading Settings \'show_on_front\' and \'page_for_posts\'.
			If a static page is set for the front page of the site, this condition will be triggered only on the page you set as the "Posts page".',
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
		return is_home();
	}
}
