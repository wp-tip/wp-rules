<?php
namespace WP_Rules\Core\Admin\Action;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Admin\Action
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
			'rules_metabox_action_fields'    => 'add_action_fields',
			'save_post_rules'                => [ 'save_actions', 10, 3 ],
			'admin_enqueue_scripts'          => 'enqueue_action_script',
			'wp_ajax_rules_action_new'       => 'rules_action_add_new',
			'wp_ajax_refresh_action_options' => 'refresh_action_options',
			'admin_notices'                  => 'show_admin_notice_for_transient',
		];
	}

	/**
	 * Add action field to action metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_action_fields( $post ) {
		$this->render_field->hidden( 'rule_action_nonce', wp_create_nonce( 'rule_action_nonce' ), [ 'id' => 'rule_action_nonce' ], true );
		$this->render_field->button(
			'rule_action_add',
			__( 'Add New Action', 'rules' ),
			[
				'class' => 'button button-primary',
				'id'    => 'rule_action_add_button',
			],
			true
			);

		$actions_html    = '';
		$current_actions = get_post_meta( $post->ID, 'rule_actions', true );
		if ( ! empty( $current_actions ) ) {
			foreach ( $current_actions as $action_key_num => $action_array ) {
				foreach ( $action_array as $action_id => $options ) {
					$actions_html .= $this->get_action_html( $action_key_num, $action_id, $options, false );
				}
			}
		}

		$this->render_field->container( $actions_html, [ 'id' => 'rule_actions_container' ], true );
	}

	/**
	 * Enqueue action JS script file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents current page.
	 */
	public function enqueue_action_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'rules_action', WP_RULES_URL . 'assets/js/action.js', [ 'jquery' ], '1.0', true );
	}

	/**
	 * Ajax print add new action HTML.
	 */
	public function rules_action_add_new() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['rule_action_nonce'] ?? null ), 'rule_action_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$actions_count = intval( $_POST['actions_count'] ?? 0 );

		$this->get_action_html( $actions_count );

		die();
	}

	/**
	 * Get/Print action HTML.
	 *
	 * @param int    $actions_count Number of this new action.
	 * @param string $selected_action Action ID.
	 * @param array  $options Array of saved options for this action.
	 * @param bool   $echo Print the output otherwise return it.
	 *
	 * @return string In case of return, get new action HTML.
	 */
	private function get_action_html( $actions_count, $selected_action = '', $options = [], $echo = true ) {
		$actions_list = apply_filters( 'rules_actions_list', [ 0 => __( 'Please select action', 'rules' ) ] );

		$output  = '';
		$output .= $this->render_field->select( "rule_actions[{$actions_count}]", __( 'Choose action', 'rules' ), $actions_list, $selected_action, [ 'class' => 'rule-action-list' ], false );
		$output .= apply_filters( 'rules_action_options_html', '', $actions_count, $selected_action, $options, true );
		$output .= $this->render_field->button( 'rule_action_remove', __( 'Remove Action', 'rules' ), [ 'class' => 'button rule-action-remove' ], false );

		return $this->render_field->container(
			$output,
			[
				'class'           => 'rule-action',
				'container_class' => 'rule-action-container',
				'data-number'     => $actions_count,
			],
			$echo
		);
	}

	/**
	 * Refresh action options on ajax request.
	 */
	public function refresh_action_options() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ?? null ), 'rule_action_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$action  = sanitize_key( $_POST['selected_action'] ?? null );
		$post_id = sanitize_key( $_POST['post_id'] ?? null );
		$number  = sanitize_key( $_POST['number'] ?? 0 );

		if ( is_null( $action ) || is_null( $post_id ) ) {
			return;
		}

		$options = $this->get_rule_action_options( $post_id, $action, $number );

		echo apply_filters( 'rules_action_options_html', '', $number, $action, $options, false );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		die();
	}

	/**
	 * Get action saved options for specific rule.
	 *
	 * @param int    $post_id Current rule ID.
	 * @param string $action_id Action ID to get options for.
	 * @param int    $number Current index number of this action.
	 *
	 * @return array DB saved Options.
	 */
	private function get_rule_action_options( $post_id, $action_id, $number ) {
		$saved_actions = get_post_meta( $post_id, 'rule_actions', true );

		if ( empty( $saved_actions ) ) {
			return [];
		}

		if ( ! isset( $saved_actions[ $number ][ $action_id ] ) ) {
			return [];
		}

		return $saved_actions[ $number ][ $action_id ];
	}

	/**
	 * Save action field and trigger options array field.
	 *
	 * @param int $post_ID Current Post ID.
	 */
	public function save_actions( $post_ID ) {
		if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST['rule_action_nonce'] ?? null ), 'rule_action_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		// Prepare rule_actions meta array.
		$post_rule_actions        = wpbr_recursive_sanitize_text( wp_unslash( $_POST['rule_actions'] ?? [] ) );// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$post_rule_action_options = wpbr_recursive_sanitize_text( wp_unslash( $_POST['rule_action_options'] ?? [] ) );// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( empty( $post_rule_actions ) ) {
			delete_post_meta( $post_ID, 'rule_actions' );
			return;
		}

		$rule_actions = [];

		foreach ( $post_rule_actions as $action_key => $action ) {
			$rule_actions[] = [
				$action => $post_rule_action_options[ $action_key ],
			];
		}

		update_post_meta( $post_ID, 'rule_actions', $rule_actions );

	}

	/**
	 * Show delayed admin notices.
	 */
	public function show_admin_notice_for_transient() {
		$notice = get_transient( 'rules_admin_notice' );

		if ( empty( $notice ) ) {
			return;
		}

		delete_transient( 'rules_admin_notice' );

		printf(
			'<div class="notice notice-%s %s"><p>%s</p></div>',
			esc_attr( $notice['status'] ),
			( $notice['dismissable'] ? 'is-dismissible' : '' ),
			nl2br( esc_textarea( $notice['message'] ) )
		);
	}

}
