<?php
namespace WP_Rules\Core\Admin\Templates;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;
use WP_Rules\Core\Template\RenderField;

abstract class AbstractTemplate implements SubscriberInterface {

	/**
	 * Template ID.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * Template visible name.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Template Group.
	 *
	 * @var string
	 */
	protected $group = '';

	/**
	 * Template's Description.
	 *
	 * @var string
	 */
	protected $description = '';

	/**
	 * Template's thumbnail url.
	 *
	 * @var string
	 */
	protected $thumbnail = '';

	/**
	 * Template's trigger ID.
	 *
	 * @var string
	 */
	protected $trigger = '';

	/**
	 * Template's list of condition IDs.
	 *
	 * @var array
	 */
	protected $conditions = [];

	/**
	 * Template's list of action IDs.
	 *
	 * @var array
	 */
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
			'name'        => $this->name,
			'description' => $this->description,
			'group'       => $this->group,
			'thumbnail'   => $this->thumbnail,
		];
		return $templates_list;
	}

	/**
	 * Get current template's name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Get current template's trigger.
	 *
	 * @return string
	 */
	public function get_trigger() {
		return $this->trigger;
	}

	/**
	 * Get current template's conditions.
	 *
	 * @return array
	 */
	public function get_conditions() {
		return $this->conditions;
	}

	/**
	 * Get current template's actions.
	 *
	 * @return array
	 */
	public function get_actions() {
		return $this->actions;
	}

}
