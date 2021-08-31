<?php
namespace WP_Rules\Actions\Backend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class RemoveMenuPage
 *
 * @package WP_Rules\Actions
 */
class RemoveMenuPage extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'remove_menu_page',
			'name'        => __( 'Remove Menu Page', 'rules' ),
			'description' => __( 'Removes a top-level admin menu.', 'rules' ),
			'group'       => __( 'Backend', 'rules' ),
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
				'label' => __( 'Menu page to remove', 'rules' ),
				'name'  => 'menu_slug',
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
		if ( empty( $action_options['menu_slug'] ) ) {
			return;
		}

		global $menu;
		if ( empty( $menu ) ) {
			return;
		}

		remove_menu_page( $action_options['menu_slug'] );
	}

}
