<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AdminFooter
 *
 * @package WP_Rules\Triggers
 */
class AdminFooter extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'in_admin_footer',
			'wp_action'          => 'in_admin_footer',
			'name'               => __( 'Admin Footer', 'rules' ),
			'description'        => __( 'This is triggered just after the <code>&lt;div id="footer"&gt;</code> tag of the <code>wp-admin/admin-footer.php</code> page. This position makes it a prime location for hooking javascript that fires on <code>document.ready</code> for the admin page. Also good for php functions targeted at customization of the admin footer.', 'rules' ),
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
