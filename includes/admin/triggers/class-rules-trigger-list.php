<?php

namespace Rules\Admin\Triggers;

use Rules\Admin\Triggers\Interfaces\Rules_Trigger as Trigger_Interface;

defined( 'ABSPATH' ) || exit;

class Rules_Trigger_List implements \Countable, \Iterator {

	private $triggers  = [];
	private $cur_index = 0;

	public function init( $triggers = [] ) {
		$this->add_triggers( $triggers );
	}

	public function add_triggers ( $triggers = [] ) {
		foreach ($triggers as $trigger) {
			$trigger_object = $this->get_trigger($trigger);
			if(!is_null($trigger_object)){
				$this->triggers[] = $trigger_object;
			}
		}
	}

	public function get_trigger( $trigger ) {
		return $this->trigger_factory($trigger);
	}

	private function trigger_factory( $trigger ) {
		$object = null;
		$trigger_class_name = "Rules\Admin\Triggers\Items\Rules_".ucwords($trigger, '_');
		if(class_exists($trigger_class_name)){
			$object = new $trigger_class_name;
		}
		return $object;
	}

	/**
	 * @inheritDoc
	 */
	public function current() {
		 return $this->triggers[ $this->cur_index ];
	}

	/**
	 * @inheritDoc
	 */
	public function next() {
		$this->cur_index++;
	}

	/**
	 * @inheritDoc
	 */
	public function key() {
		 return $this->triggers[ $this->cur_index ]->get_id();
	}

	/**
	 * @inheritDoc
	 */
	public function valid() {
		return $this->cur_index < $this->count();
	}

	/**
	 * @inheritDoc
	 */
	public function rewind() {
		$this->cur_index = 0;
	}

	/**
	 * @inheritDoc
	 */
	public function count() {
		return count( $this->triggers );
	}
}
