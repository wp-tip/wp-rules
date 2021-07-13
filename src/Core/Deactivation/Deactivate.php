<?php
namespace WP_Rules\Core\Deactivation;

/**
 * Class Deactivate
 *
 * @package WP_Rules\Core\Deactivation
 */
class Deactivate {

	/**
	 * Entry point for deactivation.
	 */
	public static function index() {
		self::clear_schedules();
	}

	/**
	 * Clear all added schedules.
	 */
	private static function clear_schedules() {
		$recurrences = array_keys( wp_get_schedules() );
		if ( empty( $recurrences ) ) {
			return;
		}

		foreach ( $recurrences as $recurrence ) {
			wp_clear_scheduled_hook( 'rules_scheduler', [ $recurrence ] );
		}
	}

}
