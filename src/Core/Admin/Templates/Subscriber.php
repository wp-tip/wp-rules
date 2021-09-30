<?php
namespace WP_Rules\Core\Admin\Templates;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Admin\Templates
 */
class Subscriber implements SubscriberInterface {

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	private $render_field;

	/**
	 * Subscriber constructor.
	 */
	public function __construct() {
		$this->render_field = wpbr_render_fields();
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'in_admin_header' => 'show_templates_list',
		];
	}

	public function show_templates_list() {
		global $current_screen;

		if ( 'rules' !== $current_screen->id || 'add' !== $current_screen->action ) {
			return;
		}

		$data = [
			'templates' => apply_filters( 'rules_templates_list', [] ),
		];

		$this->render_field->render_admin( 'templates-list', $data, true );

	}

}
