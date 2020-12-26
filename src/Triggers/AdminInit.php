<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class AdminInit
 *
 * @package WP_Rules\Triggers
 */
class AdminInit extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return void
	 */
	protected function init() {
		$this->id        = 'admin_init';
		$this->wp_action = $this->id;
		$this->name      = __( 'Admin initialize', 'rules' );
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