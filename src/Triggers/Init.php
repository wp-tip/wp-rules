<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

class Init extends AbstractTrigger {

	protected function init() {
		$this->id = "init";
		$this->wp_action = $this->id;
		$this->name = __( 'Wordpress initialize', 'rules' );
	}

	protected function admin_fields() {
		return [];
	}


}
