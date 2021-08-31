<?php
namespace WP_Rules\Core\Admin\Action;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;

/**
 * Class AbstractAction
 *
 * @package WP_Rules\Core\Admin\Action
 */
abstract class AbstractAction implements SubscriberInterface {

	/**
	 * Action unique ID.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Action visible name.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Action description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Action group name.
	 *
	 * @var string
	 */
	protected $group = '';

	/**
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	protected $render_field;

	/**
	 * Fired in rules cache array [ action_id => [ rule_ids ] ]
	 *
	 * @var array
	 */
	private $fired_in_rules = [];

	/**
	 * AbstractAction constructor.
	 */
	public function __construct() {
		$this->render_field = wpbr_render_fields();
		$this->fill_attributes( $this->init() );
	}

	/**
	 * Initialize Action details like id, name.
	 *
	 * @return array
	 */
	abstract protected function init();

	/**
	 * Return Action options fields array.
	 *
	 * @return array Admin fields.
	 */
	abstract protected function admin_fields();

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
			'rules_actions_list'        => 'register_action',
			'rules_action_options_html' => [ 'get_action_options_html', 10, 5 ],
			'rules_action_fired'        => [ 'fire_action', 10, 4 ],
		];
	}

	/**
	 * Add current action to actions list.
	 *
	 * @param array $actions_list Current list of actions.
	 *
	 * @return array List of actions after adding current one.
	 */
	public function register_action( array $actions_list ) {
		$actions_list[ $this->id ] = empty( $this->group ) ? $this->name : [ $this->group => $this->name ];
		return $actions_list;
	}

	/**
	 * Get/Print specific action options fields HTML.
	 *
	 * @param string $html Filter fields HTML.
	 * @param int    $number Current number of this action to be used in field names.
	 * @param string $action_id ID of this action.
	 * @param array  $options Array of options' values saved on DB.
	 * @param bool   $with_container Return HTML enclosed inside container or not.
	 *
	 * @return string HTML of action fields.
	 */
	public function get_action_options_html( $html, $number, $action_id, $options, $with_container = false ) {
		if ( empty( $action_id ) ) {
			if ( $with_container ) {
				return $this->render_field->container( '', [ 'class' => 'rule-action-options-container' ], false );
			}
			return '';
		}

		if ( $action_id !== $this->id ) {
			return $html;
		}

		$admin_fields = $this->admin_fields();
		$html        .= ! empty( $this->description ) ?
			$this->render_field->render_field(
				'helper',
				[
					'name'    => "rule_action_{$action_id}_helper",
					'content' => $this->description,
				],
				false
			) : '';

		if ( empty( $admin_fields ) ) {
			if ( $with_container ) {
				return $this->render_field->container( $html, [ 'class' => 'rule-action-options-container' ], false );
			}
			return $html;
		}

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = $options[ $admin_field['name'] ] ?? null;
			$admin_field['name']  = "rule_action_options[{$number}][{$admin_field['name']}]";
			$html                .= $this->render_field->render_field( $admin_field['type'], $admin_field, false );
		}

		if ( $with_container ) {
			return $this->render_field->container( $html, [ 'class' => 'rule-action-options-container' ], false );
		}

		return $html;
	}

	/**
	 * Fire action when rule conditions pass.
	 *
	 * @param string $action_id Action ID.
	 * @param array  $action_options Action options.
	 * @param array  $trigger_hook_args Current rule trigger hook arguments.
	 * @param int    $rule_post_id Rule post ID.
	 */
	public function fire_action( $action_id, $action_options, $trigger_hook_args, $rule_post_id ) {
		if ( $action_id !== $this->id ) {
			return;
		}

		if ( $this->fired_before( $action_id, $action_options, $rule_post_id ) ) {
			remove_action( 'rules_action_fired', [ $this, 'fire_action' ] );
		}

		$this->evaluate( $action_options, $trigger_hook_args );

		$this->set_fired_before( $action_id, $action_options, $rule_post_id );
	}

	/**
	 * Check if this action is fired before for this rule.
	 *
	 * @param string $action_id Action ID.
	 * @param array  $action_options Action selected options.
	 * @param int    $rule_post_id Rule post ID.
	 *
	 * @return bool
	 */
	private function fired_before( string $action_id, array $action_options, int $rule_post_id ) {
		$action_hash = md5( wp_json_encode( [ $action_id, $action_options, $rule_post_id ] ) );
		return isset( $this->fired_in_rules[ $action_hash ] );
	}

	/**
	 * Set the fired action before to make it fired uniquely.
	 *
	 * @param string $action_id Action ID.
	 * @param array  $action_options Action selected options.
	 * @param int    $rule_post_id Rule post ID.
	 */
	private function set_fired_before( $action_id, $action_options, $rule_post_id ) {
		$action_hash = md5( wp_json_encode( [ $action_id, $action_options, $rule_post_id ] ) );

		$this->fired_in_rules[ $action_hash ] = true;
	}

	/**
	 * Evaluate / Run action code.
	 *
	 * @param array $action_options Action options.
	 * @param array $trigger_hook_args Current rule trigger hook arguments.
	 *
	 * @return void
	 */
	abstract protected function evaluate( $action_options, $trigger_hook_args );

}
