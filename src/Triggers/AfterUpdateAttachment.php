<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AfterUpdateAttachment
 *
 * @package WP_Rules\Triggers
 */
class AfterUpdateAttachment extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'attachment_updated',
			'wp_action'          => 'attachment_updated',
			'name'               => __( 'After Update Attachment', 'rules' ),
			'description'        => __( 'Fires once an existing attachment has been updated.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'post_id',
				'post_after',
				'post_before',
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
