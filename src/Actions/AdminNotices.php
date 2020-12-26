<?php
namespace WP_Rules\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class AdminNotices extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return void
	 */
	protected function init() {
		$this->id   = 'admin_notices';
		$this->name = __( 'Show admin notice.', 'rules' );
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		global $wp_roles;

		return [
			[
				'type'  => 'textarea',
				'label' => __( 'Admin notice contents.', 'rules' ),
				'name'  => 'notice_contents',
			],
		];
	}

}
