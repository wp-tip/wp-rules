<?php
namespace WP_Rules\Triggers;

use WP_Rules\Core\Admin\Trigger\AbstractTrigger;

/**
 * Class Scheduler
 *
 * @package WP_Rules\Triggers
 */
class Scheduler extends AbstractTrigger {

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'                 => 'rules_scheduler',
			'wp_action'          => 'rules_scheduler',
			'name'               => __( 'Scheduler', 'rules' ),
			'description'        => __( 'Cron Job schedule at different intervals.', 'rules' ),
			'wp_action_priority' => 10,
			'wp_action_args'     => [
				'recurrence',
			],
		];
	}

	/**
	 * Return trigger options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'name'    => 'schedule',
				'label'   => __( 'Interval', 'rules' ),
				'type'    => 'select',
				'options' => $this->get_schedules(),
			],
		];
	}

	/**
	 * Get all available schedules.
	 *
	 * @return array
	 */
	private function get_schedules() {
		$schedules = wp_get_schedules();
		if ( empty( $schedules ) ) {
			return [];
		}

		$output = [];
		foreach ( $schedules as $schedule_key => $schedule ) {
			$output[ $schedule_key ] = $schedule['display'];
		}

		return $output;
	}

	/**
	 * Validate trigger options by comparing options with trigger hook arguments.
	 *
	 * @param array $trigger_hook_args Array of Trigger hook arguments ( Associative ).
	 * @param array $trigger_options Array of Trigger saved options for each rule.
	 * @param int   $rule_post_id Current rule post ID.
	 *
	 * @return bool
	 */
	public function validate_trigger_options( $trigger_hook_args, $trigger_options, $rule_post_id ) {
		return empty( $trigger_options['schedule'] ) || $trigger_hook_args['recurrence'] === $trigger_options['schedule'];
	}

}
