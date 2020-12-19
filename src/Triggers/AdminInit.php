<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

class AdminInit extends AbstractTrigger {

	protected function init() {
		$this->id = "admin_init";
		$this->wp_action = $this->id;
		$this->name = __( 'Admin initialize', 'rules' );
	}

	protected function admin_fields() {
		return [];
	}


}
