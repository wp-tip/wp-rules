<?php

namespace Rules\Admin\Triggers\Abstracts;

use Rules\Admin\Triggers\Interfaces\Rules_Trigger as Trigger_Interface;
use Rules\Common\Traits\Rules_Component;

defined( 'ABSPATH' ) || exit;

abstract class Rules_Trigger implements Trigger_Interface {

	use Rules_Component;

	public function __construct(array $args)
	{
		$this->init($args);
	}

	abstract public function prepare();
	abstract public function execute();

}
