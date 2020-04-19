<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_Term_Delete extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_term_delete';
		$name = __('Term delete', 'wp-rules');
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
			'label' => 'Taxonomy',
			'name' => 'rules_trigger_taxonomy',
			'type' => 'taxonomies'
		]];
	}
}
