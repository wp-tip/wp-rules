<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class TemplateRedirect
 *
 * @package WP_Rules\Triggers
 */
class TemplateRedirect extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'template_redirect',
			'wp_action'          => 'template_redirect',
			'name'               => __( 'Template Redirect', 'rules' ),
			'description'        => __( 'Fires before determining which template to load, It is a good trigger to use if you need to do a redirect with full knowledge of the content that has been queried.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [],
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
