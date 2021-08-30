<?php
namespace WP_Rules\Actions\Frontend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class ShowLoginPageMessage
 *
 * @package WP_Rules\Actions
 */
class ShowLoginPageMessage extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'show_login_page_message',
			'name'        => __( 'Show login page message.', 'rules' ),
			'description' => __( 'Showing a predefined message before/after the form at login page.', 'rules' ),
			'group'       => __( 'Frontend', 'rules' ),
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
				'type'  => 'textarea',
				'label' => __( 'The message', 'rules' ),
				'name'  => 'message',
			],
			[
				'type'    => 'select',
				'label'   => __( 'In header or footer', 'rules' ),
				'name'    => 'header_footer',
				'options' => [
					0 => __( 'Header', 'rules' ),
					1 => __( 'Footer', 'rules' ),
				],
			],
			[
				'type'  => 'text',
				'label' => __( 'Additional Class', 'rules' ),
				'name'  => 'class',
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
		if ( empty( $action_options['message'] ) ) {
			return;
		}

		$hook_name = $action_options['header_footer'] ? 'login_footer' : 'login_header';

		add_action(
			$hook_name,
			function () use ( $action_options ) {
				printf(
					'<div class="show-login-page-message %s">%s</div>',
					sanitize_html_class( $action_options['class'] ),
					nl2br( esc_textarea( $action_options['message'] ) )
				);
			}
		);
	}

}
