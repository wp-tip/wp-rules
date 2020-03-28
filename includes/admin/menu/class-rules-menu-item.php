<?php

namespace Rules\Admin\Menu;

defined( 'ABSPATH' ) || exit;

class Rules_Menu_Item {

	private $parent_slug = '';

	private $page_title = '';

	private $menu_title = '';

	private $capability = '';

	private $menu_slug = '';

	private $position = 1;

	public function __construct()
	{
	}

}
