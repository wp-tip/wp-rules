<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

class StopSubmission extends AbstractAction {

	/**
	 * @inerhitDoc
	 */
	protected function init() {
		return [
			'id'    => 'cf7_stop_submission',
			'name'  => __( 'Contact form 7 stop form submission', 'rules' ),
			'group' => __( 'ThirdParty', 'rules' ),
		];
	}

	/**
	 * @inerhitDoc
	 */
	protected function admin_fields() {
		return [
			[
				'type'  => 'text',
				'label' => __( 'Form ID', 'rules' ),
				'name'  => 'form_id',
			],
		];
	}

	/**
	 * @inerhitDoc
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		add_filter( 'wpcf7_before_send_mail', function ( $data, &$abort ) use ( $action_options ) {
			if ( $action_options['form_id'] !== $data->id() ) {
				return;
			}

			$abort = true;
		}, 10, 2 );
	}
}
