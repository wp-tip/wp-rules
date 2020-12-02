<?php
namespace WP_Rules\Core\Plugin;

class RequirementsChecker {

	/**
	 * Current plugin info.
	 *
	 * @var array
	 */
	private $current_info = [];

	/**
	 * RequirementsChecker constructor.
	 *
	 * @param array $current_info Current plugin info.
	 */
	public function __construct( array $current_info ) {
		$this->current_info = $current_info;
	}

	/**
	 * Start checking if WP Rules can be operated correctly on this WP install.
	 *
	 * @return bool Passes requirements check or not.
	 */
	public function process() {
		return true;
	}

	/**
	 * Check php version.
	 */
	private function check_php() {

	}

	/**
	 * Check WordPress version.
	 */
	private function check_wordpress() {

	}

}
