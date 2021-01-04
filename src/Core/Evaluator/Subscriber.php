<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Evaluator
 */
class Subscriber implements SubscriberInterface {

	/**
	 * Subscriber constructor.
	 */
	public function __construct() {

	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_trigger_fired' => [ 'evaluate_trigger', 10, 2 ]
		];
	}

	public function evaluate_trigger( $trigger_id, $args ) {
		//Get this trigger rules.
	}

}
