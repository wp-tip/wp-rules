<?php
namespace WP_Rules\Core\Admin\Rule;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;

class Subscriber implements SubscriberInterface {

	/**
	 * Posttype instance.
	 *
	 * @var Posttype
	 */
	private $post_type;

	/**
	 * Subscriber constructor.
	 *
	 * @param Posttype $post_type Post type instance.
	 */
	public function __construct( Posttype $post_type ) {
		$this->post_type = $post_type;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'init' => 'create_rules_post_type',
		];
	}

	/**
	 * Create rules post type.
	 */
	public function create_rules_post_type() {
		$this->post_type->create();
	}
}
