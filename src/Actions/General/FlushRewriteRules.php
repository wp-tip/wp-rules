<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class FlushRewriteRules
 *
 * @package WP_Rules\Actions
 */
class FlushRewriteRules extends AbstractAction {

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'flush_rewrite_rules',
			'name'        => __( 'Flush Rewrite Rules', 'rules' ),
			'description' => __( ' Remove rewrite rules and then recreate them again.', 'rules' ),
			'group'       => __( 'General', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [];
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
		flush_rewrite_rules();
	}

}
