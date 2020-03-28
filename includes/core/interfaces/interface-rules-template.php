<?php
namespace Rules\Core\Interfaces;

defined( 'ABSPATH' ) || exit;

interface Rules_Template {

	public function render($view, $data, $return = false);
	public function init($views_folder, $common_data = []);

}
