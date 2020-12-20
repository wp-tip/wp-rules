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
	 */
	public function __construct() {
		$this->render_field = rules_render_fields();
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_metabox_trigger_fields' => 'add_trigger_fields',
			'save_post_rules' => [ 'save_trigger', 10, 3 ],
			'admin_enqueue_scripts' => 'enqueue_trigger_script',
			'wp_ajax_refresh_trigger_options' => 'refresh_trigger_options'
		];
	}

	/**
	 * Add trigger field to trigger metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_trigger_fields( $post ) {
		$triggers_list = apply_filters( 'rules_triggers_list', [
			0 => __( 'Please select trigger', 'rules' )
		] );

		$selected_trigger = null;
		if ( isset( $post->ID ) ) {
			$selected_trigger = get_post_meta( $post->ID, 'rule_trigger', true );
		}

		echo $this->render_field->select( 'rule_trigger', __( 'Reacts on event', 'rules' ), $triggers_list, $selected_trigger );

		if ( ! empty( $selected_trigger ) ) {
			return;
		}

		echo $this->render_field->container( '', [
			'id' => 'rule_trigger_options_container'
		] );
	}

	public function save_trigger( $post_ID ) {
		$fields_to_save = [
			'rule_trigger',
			'rule_trigger_options'
		];

		foreach ( $fields_to_save as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				$field_value = sanitize_meta( $field, $_POST[ $field ], 'post' );
				update_post_meta($post_ID, $field, $field_value);
			}
		}
	}

	public function enqueue_trigger_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ] ) ) {
			return;
		}
		wp_enqueue_script( 'rules_trigger', WP_RULES_URL . 'assets/js/trigger.js', array(), '1.0' );
	}

	public function refresh_trigger_options() {
		$trigger = sanitize_key( $_POST['trigger'] );
		$post_id = sanitize_key( $_POST['post_id'] );

		do_action( 'rules_trigger_options_ajax', $trigger, $post_id );
		do_action( "rules_trigger_{$trigger}_options_ajax", $post_id );

		die();
	}

}
