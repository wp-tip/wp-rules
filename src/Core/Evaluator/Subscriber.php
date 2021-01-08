<?php
namespace WP_Rules\Core\Evaluator;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Meta_Query;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Evaluator
 */
class Subscriber implements SubscriberInterface {

	/**
	 * Rule Instance.
	 *
	 * @var Rule
	 */
	private $rule;

	/**
	 * Subscriber constructor.
	 *
	 * @param Rule $rule Rule instance.
	 */
	public function __construct( Rule $rule ) {
		$this->rule = $rule;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_trigger_fired' => [ 'evaluate_trigger', 10, 2 ],
		];
	}

	/**
	 * Evaluate trigger code.
	 *
	 * @param string $trigger_id Trigger ID to be evaluated.
	 * @param array  $args Trigger hook arguments.
	 */
	public function evaluate_trigger( $trigger_id, $args ) {
		// Get this trigger rules.
		global $wpdb;

		$rules_results = $wpdb->get_results(
			$wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s", 'rule_trigger', $trigger_id )
		);

		if ( empty( $rules_results ) ){
			return;
		}

		foreach ( $rules_results as $rule ) {
			$this->rule->evaluate( $rule->post_id, $args );
		}
	}

}
