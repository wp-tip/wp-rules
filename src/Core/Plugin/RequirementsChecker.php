<?php
namespace WP_Rules\Core\Plugin;

class RequirementsChecker {

	private $current_info = [];

	public function __construct( array $current_info ) {
		$this->current_info = $current_info;
	}

	public function process() {
		return true;
	}

	private function check_php() {

	}

	private function check_wordpress() {

	}

}
