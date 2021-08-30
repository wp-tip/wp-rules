<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class SendEmail
 *
 * @package WP_Rules\Actions
 */
class SendEmail extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'send_email',
			'name'        => __( 'Send Email', 'rules' ),
			'description' => __( 'Send a customized email from WordPress.', 'rules' ),
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
				'label' => __( 'To (one or comma separated emails)', 'rules' ),
				'name'  => 'to',
			],
			[
				'type'  => 'text',
				'label' => __( 'Email Subject', 'rules' ),
				'name'  => 'subject',
			],
			[
				'type'  => 'text',
				'label' => __( 'Email Message', 'rules' ),
				'name'  => 'message',
			],
		];
	}

	/**
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		wp_mail( $action_options['to'], $action_options['subject'], $action_options['message'] );
	}

}
