<?php
namespace WP_Rules\Core\General;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;

/**
 * Class Scheduler
 *
 * @package WP_Rules\Core\General
 */
class Scheduler implements SubscriberInterface {

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'admin_init' => 'start_schedulers',
		];
	}

	/**
	 * Register the new schedules for all intervals.
	 */
	public function start_schedulers() {
		$recurrences = array_keys( wp_get_schedules() );
		if ( empty( $recurrences ) ) {
			return;
		}

		foreach ( $recurrences as $recurrence ) {
			if ( wp_next_scheduled( 'rules_scheduler', [ $recurrence ] ) ) {
				continue;
			}

			wp_schedule_event( time(), $recurrence, 'rules_scheduler', [ $recurrence ] );
		}
	}

}
