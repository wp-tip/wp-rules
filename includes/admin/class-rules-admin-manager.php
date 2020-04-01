<?php
namespace Rules\Admin;

use Rules\Admin\Rules\Rules_Manager;
use Rules\Admin\Triggers\Rules_Trigger_Manager;
use Rules\Common\Traits\Rules_Component;

defined( 'ABSPATH' ) || exit;

class Rules_Admin_Manager {

	use Rules_Component;

	public function __construct()
	{
		$args = [
			'id' => 'admin_manager',
			'name' => 'Admin Manager'
		];
		$this->init( $args );
	}

	public function setup() {
		//load menu manager

		//load triggers manager
		$triggers_manager = new Rules_Trigger_Manager();
		$triggers_manager->setup();

		//load rules manager
		$rules_manager = new Rules_Manager( $triggers_manager );
		$rules_manager->setup();

		//load conditions manager

		//load actions manager
	}

}
