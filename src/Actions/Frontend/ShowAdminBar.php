<?php
namespace WP_Rules\Actions\Frontend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class ShowAdminBar
 *
 * @package WP_Rules\Actions
 */
class ShowAdminBar extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'show_admin_bar',
			'name'        => __( 'Show admin bar', 'rules' ),
			'description' => __( 'Show/Hide the Toolbar for the front side of your website (you cannot turn off the toolbar on the WordPress dashboard anymore).', 'rules' ),
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
				'type'    => 'select',
				'label'   => __( 'Show', 'rules' ),
				'name'    => 'show',
				'options' => [
					0 => __( 'No', 'rules' ),
					1 => __( 'Yes', 'rules' ),
				],
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
		if ( ! isset( $action_options['show'] ) ) {
			return;
		}

		add_filter(
			'show_admin_bar',
			function ( $shown ) use ( $action_options ) {
				return $shown && '1' === $action_options['show'];
			}
		);
	}

}
