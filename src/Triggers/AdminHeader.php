<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AdminHeader
 *
 * @package WP_Rules\Triggers
 */
class AdminHeader extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'in_admin_header',
			'wp_action'          => 'in_admin_header',
			'name'               => __( 'Admin Header', 'rules' ),
			'description'        => __( 'It fires between <code>&lt;div id="wpcontent"&gt;</code> and <code>&lt;div id="wpbody"&gt;</code> tags.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [],
		];
	}

	/**
	 * Return trigger options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [];
	}

}
