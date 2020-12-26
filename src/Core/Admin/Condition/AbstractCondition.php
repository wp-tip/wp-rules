<?php
namespace WP_Rules\Core\Admin\Condition;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;
use WP_Post;

/**
 * Class AbstractCondition
 *
 * @package WP_Rules\Core\Admin\Condition
 */
abstract class AbstractCondition implements SubscriberInterface {

	/**
	 * Condition unique ID.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Condition visible name.
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
	 * AbstractCondition constructor.
	 */
	public function __construct() {
		$this->render_field = rules_render_fields();
		$this->init();
	}

	/**
	 * Initialize condition details like id, name.
	 *
	 * @return void
	 */
	abstract protected function init();

	/**
	 * Return condition options fields array.
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
			'rules_conditions_list'        => 'register_condition',
			'rules_condition_options_html' => [ 'get_condition_options_html', 10, 5 ],
		];
	}

	/**
	 * Add current condition to conditions list.
	 *
	 * @param array $conditions_list Current list of conditions.
	 *
	 * @return array List of conditions after adding current one.
	 */
	public function register_condition( array $conditions_list ) {
		$conditions_list[ $this->id ] = $this->name;
		return $conditions_list;
	}

	/**
	 * Get/Print specific condition options fields HTML.
	 *
	 * @param string $html Filter fields HTML.
	 * @param int    $number Current number of this condition to be used in field names.
	 * @param string $condition_id ID of this condition.
	 * @param array  $options Array of options' values saved on DB.
	 * @param bool   $with_container Return HTML enclosed inside container or not.
	 *
	 * @return string HTML of condition fields.
	 */
	public function get_condition_options_html( $html, $number, $condition_id, $options, $with_container = false ) {
		if ( $condition_id !== $this->id ) {
			if ( $with_container ) {
				return $this->render_field->container( $html, [ 'class' => 'rule-condition-options-container' ], false );
			}
			return $html;
		}

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			if ( $with_container ) {
				return $this->render_field->container( $html, [ 'class' => 'rule-condition-options-container' ], false );
			}
			return $html;
		}

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = $options[ $admin_field['name'] ] ?? null;
			$admin_field['name']  = "rule_condition_options[{$number}][{$admin_field['name']}]";
			$html                .= $this->render_field->render_field( $admin_field['type'], $admin_field, false );
		}

		if ( $with_container ) {
			return $this->render_field->container( $html, [ 'class' => 'rule-condition-options-container' ], false );
		}

		return $html;
	}

}
