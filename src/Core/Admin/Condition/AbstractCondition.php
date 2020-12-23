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
			'rules_conditions_list'          => 'register_condition',
			//'rules_condition_options_html' => [ 'add_admin_options', 10, 2 ],
			'rules_condition_options_ajax'   => [ 'add_admin_options_ajax', 10, 3 ],
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
	 * Print condition options fields.
	 *
	 * @param int  $post_id Current rule post_ID.
	 * @param bool $with_container Enclose options fields into container div.
	 */
	private function print_condition_options_for_rule( $number, $admin_fields_values, $with_container = true ) {
		$options_html = '';

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			if ( ! $with_container ) {
				return;
			}

			$this->render_field->container( '', [ 'id' => 'rule_condition_options_container' ] );
			return;
		}

		foreach ( $admin_fields as $admin_field ) {
			$admin_field['value'] = $admin_fields_values[ $admin_field['name'] ] ?? null;
			$admin_field['name']  = "rule_condition_options[{$number}][{$admin_field['name']}]";
			$options_html        .= $this->render_field->render_field( $admin_field['type'], $admin_field, ! $with_container );
		}

		if ( ! $with_container ) {
			return;
		}

		$this->render_field->container( $options_html, [ 'id' => 'rule_condition_options_container' ], true );
	}

	/**
	 * Add admin options fields when page loaded.
	 *
	 * @param WP_Post $post Current rule.
	 */
	public function add_admin_options( $post ) {
		$current_trigger = get_post_meta( $post->ID, 'rule_trigger', true );

		if ( $current_trigger !== $this->id ) {
			return;
		}

		//$this->print_condition_options_for_rule( ,[], $post->ID );
	}

	/**
	 * Add admin options fields with ajax.
	 *
	 * @param string $condition Condition ID.
	 * @param int    $post_id Current rule post ID.
	 */
	public function add_admin_options_ajax( $condition, $post_id, $number = 0 ) {
		if ( $condition !== $this->id ) {
			return;
		}

		$admin_fields_values = $this->get_rule_condition_options( $post_id, $condition );
		$this->print_condition_options_for_rule( $number, $admin_fields_values, false );
	}

	private function get_rule_condition_options( $post_id, $condition ) {
		$saved_conditions = get_post_meta( $post_id, 'conditions', true );
		if ( empty( $saved_conditions ) ) {
			return [];
		}

		if ( ! isset( $saved_conditions[ $condition ] ) ) {
			return [];
		}

		return $saved_conditions[ $condition ];
	}

}
