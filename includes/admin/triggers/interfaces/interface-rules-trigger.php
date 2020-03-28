<?php

namespace Rules\Admin\Triggers\Interfaces;

defined( 'ABSPATH' ) || exit;

interface Rules_Trigger {

	public function get_id();
	public function get_name();
	public function prepare();
	public function execute();

}
