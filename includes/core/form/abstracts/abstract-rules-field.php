<?php
namespace Rules\Core\Form\Abstracts;
defined( 'ABSPATH' ) || exit;

use \Rules\Core\Form\Interfaces\Rules_Field as Field_Interface;

abstract class Rules_Field implements Field_Interface {

	private $label             = '';
	private $name              = '';
	private $value             = null;
	private $options           = [];
	private $attributes        = [];
	private $validation_rules  = [];
	private $data              = [];

	protected $type            = '';

	public function init( array $args ) {
		if(!empty($args)){
			foreach ($args as $arg_name => $arg_value){
				switch ($arg_name){
					case 'label':
						$this->set_label( $arg_value );
						break;
					case 'name':
						$this->set_name( $arg_value );
						break;
					case 'value':
						$this->set_value( $arg_value );
						break;
					case 'options':
						$this->set_options( $arg_value );
						break;
					case 'attributes':
						$this->set_attributes( $arg_value );
						break;
					case 'validation_rules':
						$this->set_validation_rules( $arg_value );
						break;
					default:
						$this->$arg_name = $arg_value;
						break;
				}
			}
		}
	}

	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}

	public function __get($name)
	{
		return $this->data[$name];
	}

	public function set_name($name){
		$this->name = $name;
	}

	public function get_name(){
		return $this->name;
	}

	public function set_label($label){
		$this->label = $label;
	}

	public function get_label(){
		return $this->label;
	}

	public function set_type($type){
		$this->type = $type;
	}

	public function get_type(){
		return $this->type;
	}

	public function set_value($value = null) {
		$this->value = $value;
	}

	public function get_options(){
		return $this->options;
	}

	public function set_options($options = []) {
		$this->options = $options;
	}

	public function get_value() {
		return $this->value;
	}

	public function add_attribute($attribute_name, $attribute_value = null) {
		$this->attributes[$attribute_name] = $attribute_value;
	}

	public function set_attributes( $attributes = [] ) {
		if (!empty( $attributes )) {
			foreach ($attributes as $attribute_name => $attribute_value) {
				$this->add_attribute( $attribute_name, $attribute_value );
			}
		}
	}

	public function get_attribute($attribute_name) {
		if (isset($this->attributes[$attribute_name])){
			return $this->attributes[$attribute_name];
		}else{
			return null;
		}
	}

	public function get_attributes() {
		return $this->attributes;
	}

	public function set_validation_rule( $rule_name, $rule_params = [] ) {
		$this->validation_rules[$rule_name] = $rule_params;
	}

	public function get_validation_rule($rule_name) {
		if( isset( $this->validation_rules[$rule_name] ) ){
			return $this->validation_rules[$rule_name];
		}else{
			return null;
		}
	}

	public function set_validation_rules ( $rules = '' ) {
		if(!empty($rules)){
			$rules_array = explode('|', $rules);
			foreach ($rules_array as $rule){
				$rule_params_array = explode(',', $rule);
				$rule_name = $rule_params_array[0];
				unset($rule_params_array[0]);
				$this->set_validation_rule($rule_name, $rule_params_array);
			}
		}else{
			return null;
		}
	}

	public function get_validation_rules() {
		return $this->validation_rules;
	}

	public function get_data() {
		return $this->data;
	}

	public function format_attributes() {
		$attributes = [];

		if(!empty($this->get_attributes())){
			foreach ($this->get_attributes() as $attribute_name => $attribute_value){
				$attributes[] = $attribute_name . '=' . '"' . $attribute_value . '"';
			}
		}
		return implode(' ', $attributes);
	}

	abstract public function validate();
}
