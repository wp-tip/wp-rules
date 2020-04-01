<?php
namespace Rules\Admin\Triggers\Items;

use Rules\Admin\Triggers\Abstracts\Rules_Trigger;

class Rules_Trigger_Cron extends Rules_Trigger{

	public function __construct() {
		$id = 'trigger_cron';
		$name = __('Cron runs', 'wp-rules');
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
		return [
			[
				'label' => 'Runs Every: ',
				'name' => "trigger_cron_every",
				'type' => 'select',
				'options' => [
					'60' => __('1 Minute', 'wp-rules'),
					'3600' => __('1 Hour', 'wp-rules')
				]
			]
		];
	}
}
