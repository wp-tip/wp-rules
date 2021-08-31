<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7\Actions;

use WP_Rules\Core\Admin\Action\AbstractAction;

class SkipMail extends AbstractAction {

	/**
	 * Initialize Action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'cf7_skip_mail',
			'name'        => __( 'Contact form 7 Skip sending mail', 'rules' ),
			'description' => __( 'Skip sending the email when submitting Contact Form 7 form.', 'rules' ),
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
			'wpcf7_skip_mail',
			function ( $skip, $cf7form ) use ( $action_options ) {
				if ( (int) $action_options['form_id'] !== $cf7form->id() ) {
					return $skip;
				}

				return true;
			},
			10,
			2
		);
	}
}
