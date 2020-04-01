<?php

namespace Rules\Admin\Triggers;

use Rules\Admin\Triggers\Items\Rules_Trigger_Cron;
use Rules\Admin\Triggers\Items\Rules_Trigger_Test;
use Rules\Common\Traits\Rules_Component;

defined( 'ABSPATH' ) || exit;

class Rules_Trigger_Manager {

	use Rules_Component;

	private $triggers;

	public function __construct()
	{
		$args = [
			'id' => 'trigger_manager',
			'name' => 'Trigger Manager'
		];
		$this->init( $args );
	}

	public function setup() {
		add_filter('rules_triggers_list', [$this, 'get_triggers']);
		add_filter('rules_triggers_named_ids', [$this, 'get_named_id']);
	}

	public function get_triggers( $triggers = [] ) {
		$triggers[] = 'trigger_cron';
		$triggers[] = 'trigger_test';

		$list = new Rules_Trigger_List();
		$list->init( $triggers );
		$this->triggers = $list;
	}

	public function get_named_id( $triggers = [] ) {
		$named_ids = [];
		$this->get_triggers( $triggers );
		if(!empty($this->triggers)){
			foreach ($this->triggers as $trigger) {
				$named_ids[ $trigger->get_id() ] = $trigger->get_attributes();
			}
		}

		return $named_ids;
	}

	public function get_trigger( $trigger_id ) {
		$trigger = $this->triggers->get_trigger($trigger_id);
		if( !is_null($trigger) ){
			return $trigger;
		}else{
			throw new \Exception('Not valid Trigger with ID: ' . $trigger_id . '!');
		}
	}

}
