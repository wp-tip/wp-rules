<?php
namespace WP_Rules\Core\Admin\Trigger;

use WP_Rules\Core\Admin\Rule\PostMeta;
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
	 * Post Meta Instance.
	 *
	 * @var PostMeta
	 */
	private $post_meta;

	/**
	 * Subscriber constructor.
	 *
	 * @param PostMeta $post_meta PostMeta instance.
	 */
	public function __construct( PostMeta $post_meta ) {
		$this->render_field = wpbr_render_fields();
		$this->post_meta    = $post_meta;
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_metabox_trigger_fields'    => 'add_trigger_fields',
			'save_post_rules'                 => [ 'save_trigger', 10, 3 ],
			'admin_enqueue_scripts'           => 'enqueue_trigger_script',
			'wp_ajax_refresh_trigger_options' => 'refresh_trigger_options',
		];
	}

	/**
	 * Add trigger field to trigger metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_trigger_fields( $post ) {
		$selected_trigger = null;
		if ( isset( $post->ID ) ) {
			$selected_trigger = $this->post_meta->get_rule_trigger( $post->ID );
		}

		$triggers_list = apply_filters( 'rules_triggers_list', [ 0 => __( 'Please select trigger', 'rules' ) ] );
		$this->render_field->select( 'rule_trigger', __( 'Reacts on event', 'rules' ), $triggers_list, $selected_trigger, [], true );

		$this->render_field->hidden( 'rule_trigger_nonce', wp_create_nonce( 'rule_trigger_nonce' ), [ 'id' => 'rule_trigger_nonce' ], true );

		if ( ! empty( $selected_trigger ) ) {
			return;
		}

		$this->render_field->container( '', [ 'id' => 'rule_trigger_options_container' ], true );
	}

	/**
	 * Save trigger field and trigger options array field.
	 *
	 * @param int $post_ID Current Post ID.
	 */
	public function save_trigger( $post_ID ) {
		if ( wpbr_has_constant( 'DOING_AUTOSAVE' ) ) {
			return;
		}

		if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST['rule_trigger_nonce'] ?? null ), 'rule_trigger_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$this->post_meta->set_rule_trigger(
			$post_ID,
			isset( $_POST['rule_trigger'] ) ? sanitize_title( wp_unslash( $_POST['rule_trigger'] ) ) : ''
		);

		$this->post_meta->set_rule_trigger_options(
			$post_ID,
			isset( $_POST['rule_trigger_options'] ) ? sanitize_meta( 'rule_trigger_options', wp_unslash( $_POST['rule_trigger_options'] ), 'post' ) : []
		);

		// Reset rule variables.
		$this->post_meta->set_rule_variables( $post_ID, [] );

		do_action( 'rules_after_trigger_save', $post_ID );
	}

	/**
	 * Enqueue trigger JS script file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents page name.
	 */
	public function enqueue_trigger_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'rules_trigger', WP_RULES_URL . 'assets/js/trigger.js', [ 'jquery' ], '1.0', true );
	}

	/**
	 * Refresh trigger options on ajax request.
	 */
	public function refresh_trigger_options() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ?? null ), 'rule_trigger_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$trigger = sanitize_key( $_POST['trigger'] ?? null );
		$post_id = sanitize_key( $_POST['post_id'] ?? null );

		if ( is_null( $trigger ) || is_null( $post_id ) ) {
			return;
		}

		do_action( 'rules_trigger_options_ajax', $trigger, $post_id );
		do_action( "rules_trigger_{$trigger}_options_ajax", $post_id );

		die();
	}

}
