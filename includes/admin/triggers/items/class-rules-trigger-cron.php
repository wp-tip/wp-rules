<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_Cron extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_cron';
		$name = __('Cron runs', 'wp-rules');
		$this->init($id, $name);
	}

	public function prepare()
	{
		// TODO: Implement prepare() method.
	}

	public function execute()
	{
		// TODO: Implement execute() method.
	}
}
