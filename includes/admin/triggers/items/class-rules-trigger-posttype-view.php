<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_Posttype_View extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_posttype_view';
		$name = __('Post type view', 'wp-rules');
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
			'label' => 'Post type',
			'name' => 'rules_trigger_posttype',
			'type' => 'posttypes'
		]];
	}
}
