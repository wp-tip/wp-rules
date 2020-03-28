<?php

namespace Rules\Admin\Triggers;

use Rules\Common\Traits\Rules_Component;

defined( 'ABSPATH' ) || exit;

class Rules_Trigger_Manager {

	use Rules_Component;

	private $triggers = [];

	public function __construct()
	{
		$args = [
			'id' => 'trigger_manager',
			'name' => 'Trigger Manager'
		];
		$this->init( $args );
	}

	public function setup() {

	}

	public function load_triggers(Rules_Trigger_List $list) {
		$triggers = [];
		$list->init( $triggers );
		return $list;
	}

	public function get_trigger( $trigger_id ) {
		if(in_array($trigger_id, $this->triggers)){

		}else{
			throw new \Exception('Not valid Trigger with ID: ' . $trigger_id . '!');
		}
	}

}
