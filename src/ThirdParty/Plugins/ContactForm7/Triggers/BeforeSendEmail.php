<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class BeforeSendEmail
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7\Triggers
 */
class BeforeSendEmail extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'wpcf7_before_send_mail',
			'wp_action'          => 'wpcf7_before_send_mail',
			'name'               => __( 'Contact Form 7 - Before sending email', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'form',
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
