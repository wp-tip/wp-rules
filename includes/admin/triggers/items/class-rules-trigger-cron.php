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
		$this->setup_hooks();
	}

	public function setup_hooks() {
		add_filter('cron_schedules', [$this, 'create_wp_schedules']);
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

	public function create_wp_schedules( $schedules ) {
		return array_merge($schedules, $this->get_schedules());
	}

	private function get_schedules() {
		$default_schedules = [
			'rules_15_minutes'     => array(
				'interval' => 0.25 * HOUR_IN_SECONDS,
				'display'  => __( 'Every 15 Minutes', 'wp-rules' ),
			),
			'rules_30_minutes'     => array(
				'interval' => 0.5 * HOUR_IN_SECONDS,
				'display'  => __( 'Every 30 Minutes', 'wp-rules' ),
			),
			'rules_1_hour'     => array(
				'interval' => HOUR_IN_SECONDS,
				'display'  => __( 'Every 1 Hour', 'wp-rules' ),
			),
			'rules_6_hours'     => array(
				'interval' => 6 * HOUR_IN_SECONDS,
				'display'  => __( 'Every 6 Hours', 'wp-rules' ),
			),
			'rules_12_hours'     => array(
				'interval' => 12 * HOUR_IN_SECONDS,
				'display'  => __( 'Every 12 Hours', 'wp-rules' ),
			),
			'rules_1_day'     => array(
				'interval' => DAY_IN_SECONDS,
				'display'  => __( 'Every 1 day', 'wp-rules' ),
			),
		];
		return apply_filters('rules_trigger_cron', $default_schedules);
	}

	private function get_schedules_named_ids(){
		$schedules = [];
		$schedules_list = $this->get_schedules();
		foreach ($schedules_list as $schedule_key => $schedule) {
			$schedules[$schedule_key] = $schedule['display'];
		}
		return $schedules;
	}

	public function admin_fields()
	{
		return [
			[
				'label' => 'Runs Every: ',
				'name' => "trigger_cron_every",
				'type' => 'select',
				'options' => $this->get_schedules_named_ids()
			]
		];
	}
}
