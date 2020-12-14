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
	 * MetaBox instance.
	 *
	 * @var MetaBox
	 */
	private $meta_box;

	/**
	 * Subscriber constructor.
	 *
	 * @param Posttype $post_type Post type instance.
	 * @param MetaBox  $meta_box MetaBox instance.
	 */
	public function __construct( Posttype $post_type, MetaBox $meta_box ) {
		$this->post_type = $post_type;
		$this->meta_box  = $meta_box;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'init'           => 'create_rules_post_type',
			'add_meta_boxes' => 'create_metaboxes',
		];
	}

	/**
	 * Create rules post type.
	 */
	public function create_rules_post_type() {
		$this->post_type->create();
	}

	/**
	 * Create rules metaboxes.
	 */
	public function create_metaboxes() {
		$this->meta_box->create();
	}
}
