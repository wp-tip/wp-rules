<?php

namespace Rules\Core\Form;

use Rules\Core\Form\Fields\Rules_Field_Select;
use Rules\Core\Form\Fields\Rules_Field_Textbox;
use Rules\Core\Form\Interfaces\Rules_Field as Field_Interface;
use Rules\Core\Form\Interfaces\Rules_Field_List as Field_List_Interface;

defined( 'ABSPATH' ) || exit;

class Rules_Field_List implements Field_List_Interface {

	private $fields  = [];
	private $cur_index = 0;

	public function init( $fields ) {
		foreach ($fields as $field) {
			$field_object = $this->field_type_factory($field['type']);
			unset($field['type']);
			$field_object->init($field);
			$this->fields[] = $field_object;
		}
	}

	private function field_type_factory( $type ) {
		$class_path = 'Rules\Core\Form\Fields\Rules_Field_' . ucwords($type, "_");
		return new $class_path;
	}

	/**
	 * @inheritDoc
	 */
	public function current() {
		return $this->fields[ $this->cur_index ];
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
		return $this->fields[ $this->cur_index ]->get_name();
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
		return count( $this->fields );
	}
}
