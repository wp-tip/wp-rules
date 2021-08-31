<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class BeforeDeleteAttachment
 *
 * @package WP_Rules\Triggers
 */
class BeforeDeleteAttachment extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'delete_attachment',
			'wp_action'          => 'delete_attachment',
			'name'               => __( 'Before Delete Attachment', 'rules' ),
			'description'        => __( 'Fires before an attachment is deleted.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'post_id',
			],
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
