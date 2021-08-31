<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

class StopSubmission extends AbstractAction {

	/**
	 * Initialize Action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'cf7_stop_submission',
			'name'        => __( 'Contact form 7 stop form submission', 'rules' ),
			'description' => __( 'Stop Contact Form 7 form submission when clicking on submit button.', 'rules' ),
			'group'       => __( 'ThirdParty', 'rules' ),
		];
	}

	/**
	 * Return Action options fields array.
	 *
	 * @return array Admin fields.
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
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		add_filter(
			'wpcf7_before_send_mail',
			function ( $data, &$abort ) use ( $action_options ) {
				if ( (int) $action_options['form_id'] !== $data->id() ) {
					return;
				}

				$abort = true;
			},
			10,
			2
		);
	}
}
