<?php
namespace WP_Rules\Actions\General;

use WP_Rules\Core\Admin\Action\AbstractAction;

/**
 * Class AddScheduleInterval
 *
 * @package WP_Rules\Actions
 */
class AddScheduleInterval extends AbstractAction {

	/**
	 * Initialize action details like id, name.
	 *
	 * @return array
	 */
	protected function init() {
		return [
			'id'          => 'add_schedule_interval',
			'name'        => __( 'Add Schedule Interval', 'rules' ),
			'description' => __( 'Add time interval to the schedule trigger.', 'rules' ),
			'group'       => __( 'General', 'rules' ),
		];
	}

	/**
	 * Return condition options fields array.
	 *
	 * @return array Admin fields.
	 */
	protected function admin_fields() {
		return [
			[
				'type'  => 'text',
				'label' => __( 'Interval unique name', 'rules' ),
				'name'  => 'name',
			],
			[
				'type'  => 'text',
				'label' => __( 'Interval display name', 'rules' ),
				'name'  => 'display',
			],
			[
				'type'  => 'text',
				'label' => __( 'Interval', 'rules' ),
				'name'  => 'interval',
			],
			[
				'type'    => 'select',
				'label'   => __( 'Unit', 'rules' ),
				'name'    => 'unit',
				'options' => [
					1                 => __( 'Second', 'rules' ),
					MINUTE_IN_SECONDS => __( 'Minute', 'rules' ),
					HOUR_IN_SECONDS   => __( 'hour', 'rules' ),
					DAY_IN_SECONDS    => __( 'day', 'rules' ),
					WEEK_IN_SECONDS   => __( 'week', 'rules' ),
					MONTH_IN_SECONDS  => __( 'month', 'rules' ),
				],
			],
		];
	}

	/**
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	protected function evaluate( $action_options, $trigger_hook_args ) {
		if (
			empty( $action_options['name'] )
			||
			empty( $action_options['display'] )
			||
			empty( $action_options['interval'] )
			||
			empty( $action_options['unit'] )
		) {
			return;
		}

		add_filter(
			'cron_schedules', // phpcs:ignore WordPress.WP.CronInterval.ChangeDetected
			function ( $intervals ) use ( $action_options ) {
				$intervals[ $action_options['name'] ] = [
					'interval' => (int) $action_options['interval'] * (int) $action_options['unit'],
					'display'  => $action_options['display'],
				];

				return $intervals;
			}
		);
	}

}
