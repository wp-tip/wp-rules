<?php
namespace WP_Rules\Core\Admin\Condition;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class Subscriber
 *
 * @package WP_Rules\Core\Admin\Condition
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
			'rules_metabox_condition_fields'    => 'add_condition_fields',
			'save_post_rules'                   => 'save_conditions',
			'admin_enqueue_scripts'             => 'enqueue_condition_script',
			'wp_ajax_rules_condition_new'       => 'rules_condition_add_new',
			'wp_ajax_refresh_condition_options' => 'refresh_condition_options',
			'rules_condition_admin_fields'      => [
				[ 'add_inverted_field', 1000 ],
			],
		];
	}

	/**
	 * Add condition field to condition metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_condition_fields( $post ) {
		$this->render_field->hidden( 'rule_condition_nonce', wp_create_nonce( 'rule_condition_nonce' ), [ 'id' => 'rule_condition_nonce' ], true );
		$this->render_field->button(
			'rule_condition_add',
			__( 'Add New Condition', 'rules' ),
			[
				'class' => 'button button-primary',
				'id'    => 'rule_condition_add_button',
			],
			true
			);

		$conditions_html    = '';
		$current_conditions = get_post_meta( $post->ID, 'rule_conditions', true );
		if ( ! empty( $current_conditions ) ) {
			foreach ( $current_conditions as $condition_key_num => $condition_array ) {
				foreach ( $condition_array as $condition_id => $options ) {
					$conditions_html .= $this->get_condition_html( $condition_key_num, $condition_id, $options, false );
				}
			}
		}

		// Load saved conditions fields.

		$this->render_field->container( $conditions_html, [ 'id' => 'rule_conditions_container' ], true );
	}

	/**
	 * Enqueue condition JS script file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents current page.
	 */
	public function enqueue_condition_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php', 'post.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'rules_condition', WP_RULES_URL . 'assets/js/condition.js', [ 'jquery' ], '1.0', true );
	}

	/**
	 * Ajax print add new condition HTML.
	 */
	public function rules_condition_add_new() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['rule_condition_nonce'] ?? null ), 'rule_condition_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$conditions_count = intval( $_POST['conditions_count'] ?? 0 );

		$this->get_condition_html( $conditions_count );

		die();
	}

	/**
	 * Get/Print condition HTML.
	 *
	 * @param int    $conditions_count Number of this new condition.
	 * @param string $selected_condition Condition ID.
	 * @param array  $options Array of saved options for this condition.
	 * @param bool   $echo Print the output otherwise return it.
	 *
	 * @return string In case of return, get new condition HTML.
	 */
	private function get_condition_html( $conditions_count, $selected_condition = '', $options = [], $echo = true ) {
		$conditions_list = apply_filters( 'rules_conditions_list', [ 0 => __( 'Please select condition', 'rules' ) ] );

		$output  = '';
		$output .= $this->render_field->select( "rule_conditions[{$conditions_count}]", __( 'Choose condition', 'rules' ), $conditions_list, $selected_condition, [ 'class' => 'rule-condition-list' ], false );
		$output .= apply_filters( 'rules_condition_options_html', '', $conditions_count, $selected_condition, $options, true );
		$output .= $this->render_field->button( 'rule_condition_remove', __( 'remove Condition', 'rules' ), [ 'class' => 'button rule-condition-remove' ], false );

		return $this->render_field->container(
			$output,
			[
				'class'           => 'rule-condition',
				'container_class' => 'rule-condition-container',
				'data-number'     => $conditions_count,
			],
			$echo
		);
	}

	/**
	 * Refresh condition options on ajax request.
	 */
	public function refresh_condition_options() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ?? null ), 'rule_condition_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$condition = sanitize_key( $_POST['condition'] ?? null );
		$post_id   = sanitize_key( $_POST['post_id'] ?? null );
		$number    = sanitize_key( $_POST['number'] ?? 0 );

		if ( is_null( $condition ) || is_null( $post_id ) ) {
			return;
		}

		$options = $this->get_rule_condition_options( $post_id, $condition, $number );

		echo apply_filters( 'rules_condition_options_html', '', $number, $condition, $options, false );// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		die();
	}

	/**
	 * Get Condition saved options for specific rule.
	 *
	 * @param int    $post_id Current rule ID.
	 * @param string $condition_id Condition ID to get options for.
	 * @param int    $number Current index number of this condition.
	 *
	 * @return array DB saved Options.
	 */
	private function get_rule_condition_options( $post_id, $condition_id, $number ) {
		$saved_conditions = get_post_meta( $post_id, 'rule_conditions', true );

		if ( empty( $saved_conditions ) ) {
			return [];
		}

		if ( ! isset( $saved_conditions[ $number ][ $condition_id ] ) ) {
			return [];
		}

		return $saved_conditions[ $number ][ $condition_id ];
	}

	/**
	 * Save condition field and trigger options array field.
	 *
	 * @param int $post_ID Current Post ID.
	 */
	public function save_conditions( $post_ID ) {
		if ( ! isset( $_POST ) || empty( $_POST ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_key( $_POST['rule_condition_nonce'] ?? null ), 'rule_condition_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		// Prepare rule_conditions meta array.
		$post_rule_conditions        = wpbr_recursive_sanitize_text( wp_unslash( $_POST['rule_conditions'] ?? [] ) );// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
		$post_rule_condition_options = wpbr_recursive_sanitize_text( wp_unslash( $_POST['rule_condition_options'] ?? [] ) );// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

		if ( empty( $post_rule_conditions ) ) {
			delete_post_meta( $post_ID, 'rule_conditions' );
			return;
		}

		$rule_conditions = [];

		foreach ( $post_rule_conditions as $condition_key => $condition ) {
			$rule_conditions[] = [
				$condition => $post_rule_condition_options[ $condition_key ],
			];
		}

		update_post_meta( $post_ID, 'rule_conditions', $rule_conditions );

	}

	/**
	 * Add inverted field to all conditions.
	 *
	 * @param array $admin_fields Condition's admin fields.
	 *
	 * @return array
	 */
	public function add_inverted_field( array $admin_fields = [] ) {
		$admin_fields[] = [
			'type'        => 'checkbox',
			'name'        => 'inverted',
			'label'       => __( 'Inverted', 'rules' ),
			'field_class' => 'inverted-field',
		];

		return $admin_fields;
	}

}
