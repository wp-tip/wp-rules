<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_User_Update extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_user_update';
		$name = __('User update', 'wp-rules');
		$args = [];
		$this->init($id, $name, $args);
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
			'label' => 'User Role',
			'name' => 'rules_trigger_role',
			'type' => 'roles'
		]];
	}
}
