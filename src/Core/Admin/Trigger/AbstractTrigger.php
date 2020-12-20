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
	 * Trigger WordPress action name.
	 *
	 * @var string
	 */
	protected $wp_action = '';

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
		$this->render_field = rules_render_fields();
		$this->init();
	}

	/**
	 * Initialize trigger details like id, name, wp_action.
	 *
	 * @return void
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
		$options_html = '';

		$admin_fields = $this->admin_fields();
		if ( empty( $admin_fields ) ) {
			if ( ! $with_container ) {
				return;
			}

			$this->render_field->container( '', [ 'id' => 'rule_trigger_options_container' ] );
			return;
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

		if ( $current_trigger !== $this->id ) {
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
		if ( $trigger !== $this->id ) {
			return;
		}
		$this->print_trigger_options_for_rule( $post_id, false );
	}

}
