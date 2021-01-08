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
	 * RenderField class instance.
	 *
	 * @var RenderField
	 */
	protected $render_field;

	/**
	 * AbstractAction constructor.
	 */
	public function __construct() {
		$this->render_field = rules_render_fields();
		$this->fill_attributes( (array) $this->init() );
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
			'rules_action_fired'        => [ 'fire_action', 10, 3 ],
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
		$actions_list[ $this->id ] = $this->name;
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
		if ( $action_id !== $this->id ) {
			if ( $with_container ) {
				return $this->render_field->container( $html, [ 'class' => 'rule-action-options-container' ], false );
			}
			return $html;
		}

		$admin_fields = $this->admin_fields();
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
	 */
	public function fire_action( $action_id, $action_options, $trigger_hook_args ) {
		if ( $action_id !== $this->id ) {
			return;
		}

		$this->evaluate( $action_options, $trigger_hook_args );
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
