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
			'rules_metabox_trigger_fields' => 'add_admin_options'
		];
	}

	public function register_trigger( array $triggers_list ) {
		$triggers_list[$this->id] = $this->name;
		return $triggers_list;
	}

	public function add_admin_options( $post ) {
		$current_trigger = get_post_meta( $post->ID, 'rule_trigger', true );

		if ( $current_trigger !== $this->id ) {
			return;
		}

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			return;
		}

		$options_html = "";
		$admin_fields_values = get_post_meta( $post->ID, 'rule_trigger_options', true );

		foreach ( $admin_fields as $admin_field ) {
			switch ( $admin_field['type'] ) {
				case 'select':
					$options_html .= $this->render_field->select(
						"rule_trigger_options[{$admin_field['name']}]",
						$admin_field['label'],
						(array) $admin_field['options'],
						$admin_fields_values[$admin_field['name']] ?? null,
						$admin_field['attributes'] ?? []
					);
					break;

				default:
				case 'text':
					$options_html .= $this->render_field->text(
						"rule_trigger_options[{$admin_field['name']}]",
						$admin_field['label'],
						$admin_fields_values[$admin_field['name']] ?? null,
						$admin_field['attributes'] ?? []
					);
					break;
			}
		}

		echo $options_html;
	}

}
