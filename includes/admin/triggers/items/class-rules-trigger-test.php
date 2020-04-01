<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_Test extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_test';
		$name = __('Test', 'wp-rules');
		$args = [
			'ajax_steps' => 1
		];
		$this->init($id, $name, $args);
	}

	public function ajax_step1() {

	}

	public function prepare()
	{
		// TODO: Implement prepare() method.
	}

	public function execute()
	{
		// TODO: Implement execute() method.
	}

	public function admin_fields()
	{
		return [[
			'label' => 'Test',
			'name' => 'rules_rule_test',
			'type' => 'textbox'
		]];
	}
}
