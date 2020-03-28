<?php

namespace Rules\Admin\Triggers;

use Rules\Admin\Triggers\Interfaces\Rules_Trigger as Trigger_Interface;

defined( 'ABSPATH' ) || exit;

class Rules_Trigger_List implements \Countable, \Iterator {

	private $triggers  = [];
	private $cur_index = 0;

	public function init( array $triggers = [] ) {
		$this->triggers = $triggers;
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
		return $this->triggers[ $this->cur_index ] instanceof Trigger_Interface;
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
