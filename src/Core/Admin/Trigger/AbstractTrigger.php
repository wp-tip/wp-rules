<?php
namespace WP_Rules\Core\Admin\Trigger;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class AbstractTrigger
 *
 * @package WP_Rules\Core\Admin\Trigger
 */
abstract class AbstractTrigger implements SubscriberInterface {

	/**
	 * Trigger unique ID.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Trigger visible name.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Trigger description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Trigger WordPress action name.
	 *
	 * @var string
	 */
	protected static $wp_action = '';

	/**
	 * Trigger WP action priority.
	 *
	 * @var int Default is 10 like WordPress core.
	 */
	protected static $wp_action_priority = 10;

	/**
	 * Trigger WP action arguments number.
	 *
	 * @var int Default is 0.
	 */
	protected static $wp_action_args_number = 0;

	/**
	 * Trigger WP action arguments keys.
	 *
	 * @var array
	 */
	protected static $wp_action_args = [];

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	protected $render_field;

	/**
	 * AbstractTrigger constructor.
	 */
	public function __construct() {
		$this->render_field = wpbr_render_fields();
		$this->fill_attributes( $this->init() );
	}

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return array
	 */
	abstract protected function init();

	/**
	 * Return trigger options fields array.
	 *
	 * @return array Admin fields.
	 */
	abstract protected function admin_fields();

	/**
	 * Returns an array of events that this subscriber wants to listen to.
	 *
	 * @return array Array of events and attached callbacks.
	 */
	public static function get_subscribed_events() {
		return [
			'rules_triggers_list'          => 'register_trigger',
			'rules_metabox_trigger_fields' => 'add_admin_options',
			'rules_trigger_options_ajax'   => [ 'add_admin_options_ajax', 10, 2 ],
			self::$wp_action               => [ 'trigger_fired', self::$wp_action_priority, count( self::$wp_action_args ) ],
			'rules_trigger_validated'      => [ 'validate_trigger', 10, 4 ],
			'rules_variable_value'         => [ 'maybe_variable_value', 10, 3 ],
		];
	}

	/**
	 * Add current trigger to triggers list.
	 *
	 * @param array $triggers_list Current list of triggers.
	 *
	 * @return array List of triggers after adding current one.
	 */
	public function register_trigger( array $triggers_list ) {
		$triggers_list[ $this->id ] = $this->name;
		return $triggers_list;
	}

	/**
	 * Print trigger options fields.
	 *
	 * @param int  $post_id Current rule post_ID.
	 * @param bool $with_container Enclose options fields into container div.
	 */
	private function print_trigger_options_for_rule( $post_id, $with_container = true ) {

		$options_html = $this->render_field->render_field(
			'helper',
			[
				'name'    => "rule_trigger_{$this->id}_helper",
				'content' => $this->description,
			],
			! $with_container
		);

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			if ( ! $with_container ) {
				return;
			}

			$this->render_field->container( $options_html, [ 'id' => 'rule_trigger_options_container' ] );
		}

		$admin_fields_values = ! is_null( $post_id ) ? get_post_meta( $post_id, 'rule_trigger_options', true ) : [];

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = $admin_fields_values[ $admin_field['name'] ] ?? null;
			$admin_field['name']  = "rule_trigger_options[{$admin_field['name']}]";
			$options_html        .= $this->render_field->render_field( $admin_field['type'], $admin_field, ! $with_container );
		}

		if ( ! $with_container ) {
			return;
		}

		$this->render_field->container( $options_html, [ 'id' => 'rule_trigger_options_container' ], true );
	}

	/**
	 * Add admin options fields when page loaded.
	 *
	 * @param WP_Post $post Current rule.
	 */
	public function add_admin_options( $post ) {
		$current_trigger = get_post_meta( $post->ID, 'rule_trigger', true );

		if ( ! $this->is_allowed( $current_trigger ) ) {
			return;
		}

		$this->print_trigger_options_for_rule( $post->ID );
	}

	/**
	 * Add admin options fields with ajax.
	 *
	 * @param string $trigger Trigger name.
	 * @param int    $post_id Current rule post ID.
	 */
	public function add_admin_options_ajax( $trigger, $post_id ) {
		if ( ! $this->is_allowed( $trigger ) ) {
			return;
		}

		$this->print_trigger_options_for_rule( $post_id, false );
		exit();
	}

	/**
	 * Check if this trigger is the current trigger.
	 *
	 * @param string $current_trigger Current trigger ID.
	 *
	 * @return bool
	 */
	private function is_allowed( $current_trigger = null ) {
		if ( $current_trigger === $this->id ) {
			return true;
		}

		return false;
	}

	/**
	 * Fire an action with this trigger action.
	 *
	 * @param mixed ...$args Arguments passed to new action.
	 */
	public function trigger_fired( ...$args ) {
		$hook_args = [];

		if ( ! empty( $args ) && count( $args ) === count( $this->init()['wp_action_args'] ) ) {
			foreach ( $args as $arg_index => $arg ) {
				$hook_args[ $this->init()['wp_action_args'][ $arg_index ] ] = $arg;
			}
		}

		do_action( 'rules_trigger_fired', $this->id, $hook_args );
		do_action( "rules_trigger_{$this->id}_fired", $hook_args );
	}

	/**
	 * Fill attributes for current trigger.
	 *
	 * @param array $params Current trigger parameters.
	 */
	private function fill_attributes( array $params ) {
		foreach ( $params as $param_key => $param ) {
			switch ( $param_key ) {
				case 'wp_action':
					self::$wp_action = $param;
					break;
				case 'wp_action_priority':
					self::$wp_action_priority = $param ?? 10;
					break;
				case 'wp_action_args':
					self::$wp_action_args = $param ?? [];
					break;
				default:
					if ( isset( $this->$param_key ) ) {
						$this->$param_key = $param;
					}
			}
		}
	}

	/**
	 * Callback for rules_trigger_validated filter to validate current trigger.
	 *
	 * @param bool   $valid Current value for filter.
	 * @param string $trigger_id Current trigger Identifier.
	 * @param array  $trigger_hook_args Trigger hook passed arguments.
	 * @param int    $rule_post_id Current rule post ID.
	 *
	 * @return bool
	 */
	public function validate_trigger( bool $valid, string $trigger_id, array $trigger_hook_args, int $rule_post_id ) {
		if ( $trigger_id !== $this->id || ! method_exists( $this, 'validate_trigger_options' ) ) {
			return $valid;
		}

		$trigger_options = get_post_meta( $rule_post_id, 'rule_trigger_options', true );

		$validated = $this->validate_trigger_options( $trigger_hook_args, $trigger_options, $rule_post_id );

		return (bool) apply_filters( 'rules_validate_trigger_options', $validated, $trigger_id, $trigger_hook_args, $rule_post_id );
	}

	/**
	 * Register variable value if register_variable method is there.
	 *
	 * @param mixed  $final_value Final value of variable.
	 * @param string $variable_name Variable name.
	 * @param mixed  $variable_value Current variable value.
	 *
	 * @return mixed
	 */
	public function maybe_variable_value( $final_value, string $variable_name, $variable_value ) {
		if ( ! method_exists( $this, 'register_variable' ) ) {
			return $final_value;
		}

		$registered_value = $this->register_variable( $variable_name, $variable_value );
		if ( is_null( $registered_value ) ) {
			return $final_value;
		}

		return $registered_value;
	}

}
