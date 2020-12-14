<?php
namespace WP_Rules\Core\Admin\Trigger;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Admin\Trigger
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
	 *
	 * @param RenderField $render_field RenderField class instance.
	 */
	public function __construct( RenderField $render_field ) {
		$this->render_field = $render_field;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_metabox_trigger_fields' => 'add_trigger_fields',
		];
	}

	/**
	 * Add trigger field to trigger metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_trigger_fields( $post ) {
		$triggers_list = apply_filters( 'rules_triggers_list', [] );

		$selected_trigger = null;
		if ( isset( $post->ID ) ) {
			$selected_trigger = get_post_meta( $post->ID, 'rule_trigger', true );
		}

		echo esc_html( $this->render_field->select( 'rule_trigger', __( 'Reacts on event', 'rules' ), $triggers_list, $selected_trigger ) );
	}

}
