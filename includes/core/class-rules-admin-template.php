<?php
namespace Rules\Core;
use Rules\Core\Abstracts\Rules_Template;

defined( 'ABSPATH' ) || exit;

class Rules_Admin_Template extends Rules_Template {

	public function setup($common_data = [])
	{
		$views_folder = RULES_ADMIN_VIEWS_PATH;
		parent::init($views_folder, $common_data);
	}

}
