<?php
namespace WP_Rules\Core\Admin\Trigger;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;

abstract class AbstractTrigger implements SubscriberInterface {

	protected $id = "";

	protected $name = "";

	protected $wp_action = "";

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	protected $render_field;

	public function __construct() {
		$this->render_field = rules_render_fields();
		$this->init();
	}

	abstract protected function init();

	abstract protected function admin_fields();

	/**
	 * @inheritDoc
	 */
	public static function get_subscribed_events() {
		return [
			'rules_triggers_list' => 'register_trigger',
			'rules_metabox_trigger_fields' => 'add_admin_options',
			'rules_trigger_options_ajax' => [ 'add_admin_options_ajax', 10, 2 ]
		];
	}

	public function register_trigger( array $triggers_list ) {
		$triggers_list[ $this->id ] = $this->name;
		return $triggers_list;
	}

	private function print_trigger_options_for_rule( $post_id = null, $with_container = true ) {
		$options_html = "";

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			if ( ! $with_container ) {
				return;
			}

			echo $this->render_field->container( '', [
				'id' => 'rule_trigger_options_container'
			] );
			return;
		}

		$admin_fields_values = ! is_null( $post_id ) ? get_post_meta( $post_id, 'rule_trigger_options', true ) : [];

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = $admin_fields_values[ $admin_field['name'] ] ?? null;
			$admin_field['name'] = "rule_trigger_options[{$admin_field['name']}]";
			$options_html .= $this->render_field->render_field( $admin_field['type'], $admin_field );
		}

		if ( ! $with_container ) {
			echo $options_html;
			return;
		}

		echo $this->render_field->container( $options_html, [
			'id' => 'rule_trigger_options_container'
		] );
	}

	public function add_admin_options( $post ) {
		$current_trigger = get_post_meta( $post->ID, 'rule_trigger', true );

		if ( $current_trigger !== $this->id ) {
			return;
		}

		$this->print_trigger_options_for_rule( $post->ID );
	}

	public function add_admin_options_ajax( $trigger, $post_id ) {
		if ( $trigger !== $this->id ) {
			return;
		}
		$this->print_trigger_options_for_rule( $post_id, false );
	}

}
