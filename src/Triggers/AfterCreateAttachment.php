<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AfterCreateAttachment
 *
 * @package WP_Rules\Triggers
 */
class AfterCreateAttachment extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'add_attachment',
			'wp_action'          => 'add_attachment',
			'name'               => __( 'After Create Attachment', 'rules' ),
			'description'        => __( 'Fires once an attachment has been added.', 'rules' ),
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
