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
	}

	public function get_id()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function set_id($id)
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
	public function set_name($name)
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

	/**
	 * @param array $args
	 */
	public function set_args($args)
	{
		$this->args = $args;
	}

	abstract public function prepare();
	abstract public function execute();

}
