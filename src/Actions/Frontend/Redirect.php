<?php
namespace WP_Rules\Actions\Frontend;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class Redirect
 *
 * @package WP_Rules\Actions
 */
class Redirect extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'redirect',
			'name'        => __( 'Redirect to', 'rules' ),
			'description' => __( 'Redirect to internal/external Url.', 'rules' ),
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
				'type'  => 'text',
				'label' => __( 'Url', 'rules' ),
				'name'  => 'url',
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
		wp_safe_redirect( $action_options['url'] );
		die();
	}

}
