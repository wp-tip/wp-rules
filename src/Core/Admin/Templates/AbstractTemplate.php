<?php
namespace WP_Rules\Core\Admin\Templates;

use WP_Rules\Core\Plugin\EventManagement\SubscriberInterface;

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
	 * AbstractAction constructor.
	 */
	public function __construct() {
		$this->fill_attributes( $this->init() );
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
			'name' => $this->name,
			'description' => $this->description,
			'group' => $this->group,
			'thumbnail' => $this->thumbnail
		];
		return $templates_list;
	}

}
