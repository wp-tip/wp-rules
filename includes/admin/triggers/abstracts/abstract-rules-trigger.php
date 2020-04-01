<?php

namespace Rules\Admin\Triggers\Abstracts;

use Rules\Admin\Triggers\Interfaces\Rules_Trigger as Trigger_Interface;
use Rules\Common\Traits\Rules_Component;

defined( 'ABSPATH' ) || exit;

abstract class Rules_Trigger implements Trigger_Interface {

	private $id;
	private $name;
	private $args = [];

	public function init($id, $name, $args = [])
	{
		$this->set_id($id);
		$this->set_name($name);
		if(!empty($args)){
			$this->set_args($args);
		}
		$this->setup();
	}

	protected function setup() {
		//check for ajax_steps
		$ajax_steps = $this->get_arg( 'ajax_steps' );
		if( $ajax_steps > 0 ){
			for ($step = 1;$step <= $ajax_steps;$step++) {
				//rules_trigger_XXX_step1_ajax
				add_action( 'wp_ajax_rules_trigger_'        . $this->get_id() .'_step' . $step . '_ajax', [$this, 'ajax_step_' . $step ] );
				add_action( 'wp_ajax_nopriv_rules_trigger_' . $this->get_id() .'_step' . $step . '_ajax', [$this, 'ajax_step_' . $step ] );
			}
		}
	}

	public function get_id()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	protected function set_id($id)
	{
		$this->id = $id;
	}

	public function get_name()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	protected function set_name($name)
	{
		$this->name = $name;
	}

	/**
	 * @return array
	 */
	public function get_args()
	{
		return $this->args;
	}

	private function get_arg( $arg ) {
		if(isset($this->args[$arg])){
			return $this->args[$arg];
		}
		return null;
	}

	/**
	 * @param array $args
	 */
	protected function set_args($args)
	{
		$this->args = $args;
	}

	public function get_attributes() {
		$ajax_steps = $this->get_arg( 'ajax_steps' );
		if($ajax_steps > 0){

			/*return [
				'text' => $this->get_name(),
				'data-ajax_steps' => $ajax_steps,
				''
			];*/
		}else{

		}
		return $this->get_name();
	}

	abstract public function admin_fields();
	abstract public function prepare();
	abstract public function execute();

}
