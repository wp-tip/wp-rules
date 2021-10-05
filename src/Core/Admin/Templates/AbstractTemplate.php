<?php
namespace WP_Rules\Core\Admin\Templates;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;

abstract class AbstractTemplate implements SubscriberInterface {

	protected $id = '';

	protected $name = '';

	protected $group = '';

	protected $description = '';

	protected $thumbnail = '';

	protected $trigger = '';

	protected $conditions = [];

	protected $actions = [];

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	protected $render_field;

	/**
	 * AbstractAction constructor.
	 */
	public function __construct() {
		$this->fill_attributes( $this->init() );
		$this->render_field = wpbr_render_fields();
	}

	/**
	 * Initialize Action details like id, name.
	 *
	 * @return array
	 */
	abstract protected function init();

	/**
	 * Fill attributes for current action.
	 *
	 * @param array $params Current action parameters.
	 */
	private function fill_attributes( array $params ) {
		foreach ( $params as $param_key => $param ) {
			if ( isset( $this->$param_key ) ) {
				$this->$param_key = $param;
			}
		}
	}

	/**
	 * Returns an array of events that this subscriber wants to listen to.
	 *
	 * @return array Array of events and attached callbacks.
	 */
	public static function get_subscribed_events() {
		return [
			'rules_templates_list' => 'register_template',
			'wp_ajax_rules_template_details' => 'get_template_details',
		];
	}

	/**
	 * Add current template to templates list.
	 *
	 * @param array $templates_list Current list of templates.
	 *
	 * @return array List of templates after adding current one.
	 */
	public function register_template( array $templates_list ) {
		$templates_list[ $this->id ] = [
			'name' => $this->name,
			'description' => $this->description,
			'group' => $this->group,
			'thumbnail' => $this->thumbnail
		];
		return $templates_list;
	}

	public function get_template_details() {
		if ( ! wp_verify_nonce( sanitize_key( $_REQUEST['template_nonce'] ?? null ), 'rule_template_nonce' ) ) {
			esc_html_e( 'Play fair!', 'rules' );
			exit();
		}

		$template_id = esc_attr( $_POST['template_id'] );
		if ( $template_id !== $this->id ) {
			return;
		}

		// Get template trigger options.
		$trigger_fields = apply_filters( 'rules_trigger_' . $this->trigger . '_options', [] );

		// Get template conditions options.
		$conditions_fields = [];
		foreach ( $this->conditions as $condition_id ) {
			$conditions_fields = apply_filters( 'rules_condition_' . $condition_id . '_options', $conditions_fields );
		}

		// Get template actions options.
		$actions_fields = [];
		foreach ( $this->actions as $action_id ) {
			$actions_fields = apply_filters( 'rules_action_' . $action_id . '_options', $actions_fields );
		}

		$admin_fields = array_merge( $trigger_fields, $conditions_fields, $actions_fields );

		$output = [
			'has_options' => ! empty( $admin_fields ),
			'options_html' => '',
		];

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = null;
			$admin_field['name']  = "rule_trigger_options[{$admin_field['name']}]";
			$output['options_html'] .= $this->render_field->render_field( $admin_field['type'], $admin_field, false );
		}

		die( wp_json_encode( $output ) );
	}

}
