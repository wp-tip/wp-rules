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
		$this->render_field = rules_render_fields();
	}

	/**
	 * Get Subscriber subscribed WP events.
	 *
	 * @inheritDoc
	 */
	public static function get_subscribed_events(): array {
		return [
			'rules_metabox_condition_fields'    => 'add_condition_fields',
			//'save_post_rules'                 => [ 'save_conditions', 10, 3 ],
			'admin_enqueue_scripts'           => 'enqueue_condition_script',
			'wp_ajax_rules_condition_new' => 'rules_condition_new',
			'wp_ajax_refresh_condition_options' => 'refresh_condition_options',
		];
	}

	/**
	 * Add condition field to condition metabox fields.
	 *
	 * @param WP_Post $post Current post object.
	 */
	public function add_condition_fields( $post ) {
		$this->render_field->hidden( 'rule_condition_nonce', wp_create_nonce( 'rule_condition_nonce' ), [ 'id' => 'rule_condition_nonce' ], true );
		$this->render_field->button( 'rule_condition_add', __( 'Add New Condition', 'rules' ), [ 'class' => 'button button-primary', 'id' => 'rule_condition_add_button' ], true );

		$current_conditions = get_post_meta( $post->ID, 'rule_conditions', true );
		if ( ! empty( $current_conditions ) ) {
			return;
		}

		//Load saved conditions fields.

		$this->render_field->container( '', [ 'id' => 'rule_conditions_container' ], true );
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

	public function rules_condition_new() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['rule_condition_nonce'] ?? null ), 'rule_condition_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$conditions_count = intval( $_POST['conditions_count'] ?? 0 );

		$this->print_condition( $conditions_count );

		die();
	}

	private function print_condition( $conditions_count, $selected_condition = '' ) {
		$conditions_list = apply_filters( 'rules_conditions_list', [ 0 => __( 'Please select condition', 'rules' ) ] );

		$output = "";
		$output .= $this->render_field->select( "rule_conditions[{$conditions_count}]", __( 'Choose condition'.$conditions_count, 'rules' ), $conditions_list, $selected_condition, [], false );
		$condition_options_html = apply_filters( 'rules_condition_options_html', '', $selected_condition );
		$output .= $this->render_field->container( $condition_options_html, [ 'class' => 'rule_condition_options_container' ], false );
		$output .= $this->render_field->button( 'rule_condition_remove', __( 'remove Condition', 'rules' ), [ 'class' => 'button rule-condition-remove' ], false );

		$this->render_field->container( $output, [ 'class' => 'rule-condition', 'container_class' => 'rule-condition-container' ], true );
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
		$post_id = sanitize_key( $_POST['post_id'] ?? null );

		if ( is_null( $condition ) || is_null( $post_id ) ) {
			return;
		}

		do_action( 'rules_condition_options_ajax', $condition, $post_id );
		do_action( "rules_condition_{$condition}_options_ajax", $post_id );

		die();
	}

}
