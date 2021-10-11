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
			'in_admin_header'                => 'show_templates_list',
			'admin_enqueue_scripts'          => 'enqueue_template_script',
			'wp_ajax_rules_template_details' => 'get_template_details',
			'wp_ajax_rules_save_new'         => 'save_rule',
		];
	}

	/**
	 * Show list of available templates.
	 */
	public function show_templates_list() {
		global $current_screen;

		if ( 'rules' !== $current_screen->id || 'add' !== $current_screen->action ) {
			return;
		}

		$data = [
			'templates'      => apply_filters( 'rules_templates_list', [] ),
			'template_nonce' => wp_create_nonce( 'rule_template_nonce' ),
		];

		$this->render_field->render_admin( 'templates-list', $data, true );

	}

	/**
	 * Enqueue action JS script file into create new rule and edit rule only.
	 *
	 * @param string $hook Represents current page.
	 */
	public function enqueue_template_script( $hook ) {
		if ( ! in_array( $hook, [ 'post-new.php' ], true ) ) {
			return;
		}
		wp_enqueue_script( 'rules_template', WP_RULES_URL . 'assets/js/template.js', [ 'jquery' ], wpbr_get_constant( 'WP_RULES_VERSION' ), true );
	}

	/**
	 * Ajax response for getting template details.
	 */
	public function get_template_details() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['template_nonce'] ?? null ), 'rule_template_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$template_id = ! empty( $_POST['template_id'] ) ? sanitize_title( wp_unslash( $_POST['template_id'] ) ) : '';
		if ( empty( $template_id ) ) {
			return;
		}

		$container = apply_filters( 'rules_container', [] );

		$template = $container->get( 'template_' . $template_id );

		$options_html = '';

		// Get template trigger options.
		$trigger_class  = $container->get( 'trigger_' . $template->get_trigger() );
		$trigger_fields = $trigger_class->get_admin_fields();
		foreach ( $trigger_fields as $trigger_field ) {
			$trigger_field['value'] = null;
			$trigger_field['name']  = "rule_trigger_options[{$trigger_field['name']}]";
			$options_html          .= $this->render_field->render_field( $trigger_field['type'], $trigger_field, false );
		}

		// Get template conditions options.
		foreach ( $template->get_conditions() as $condition_key => $condition_id ) {
			$condition_class = $container->get( 'condition_' . $condition_id );

			foreach ( $condition_class->get_admin_fields() as $conditions_field ) {
				$conditions_field['value'] = null;
				$conditions_field['name']  = "rule_condition_options[{$condition_key}][{$conditions_field['name']}]";
				$options_html             .= $this->render_field->render_field( $conditions_field['type'], $conditions_field, false );
			}
		}

		// Get template actions options.
		foreach ( $template->get_actions() as $action_key => $action_id ) {
			$action_class = $container->get( 'action_' . $action_id );

			foreach ( $action_class->get_admin_fields() as $actions_field ) {
				$actions_field['value'] = null;
				$actions_field['name']  = "rule_action_options[{$action_key}][{$actions_field['name']}]";
				$options_html          .= $this->render_field->render_field( $actions_field['type'], $actions_field, false );
			}
		}

		$output = [
			'has_options'     => ! empty( $options_html ),
			'options_html'    => $options_html,
			'template_id'     => $template_id,
			'save_rule_nonce' => wp_create_nonce( 'rules_post_nonce' ),
		];

		die( wp_json_encode( $output ) );
	}

	/**
	 * Ajax response for saving a new rule.
	 */
	public function save_rule() {
		if ( false === wp_verify_nonce( sanitize_key( $_REQUEST['rules_nonce'] ?? null ), 'rules_post_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$template_id = ! empty( $_POST['template_id'] ) ? sanitize_title( wp_unslash( $_POST['template_id'] ) ) : '';
		if ( empty( $template_id ) ) {
			return;
		}

		$container = apply_filters( 'rules_container', [] );

		$template = $container->get( 'template_' . $template_id );

		$_POST['rule_trigger_nonce']   = wp_create_nonce( 'rule_trigger_nonce' );
		$_POST['rule_condition_nonce'] = wp_create_nonce( 'rule_condition_nonce' );
		$_POST['rule_action_nonce']    = wp_create_nonce( 'rule_action_nonce' );
		$_POST['rule_trigger']         = $template->get_trigger();
		$_POST['rule_conditions']      = $template->get_conditions();
		$_POST['rule_actions']         = $template->get_actions();

		// Create the post.
		$post_id = wp_insert_post(
			[
				'post_title'  => $template->get_name(),
				'post_type'   => 'rules',
				'post_status' => 'publish',
			]
		);

		$output = [
			'status'             => 'success',
			'rule_post_id'       => $post_id,
			'rule_post_edit_url' => get_edit_post_link( $post_id ),
		];

		die( wp_json_encode( $output ) );

	}

}
