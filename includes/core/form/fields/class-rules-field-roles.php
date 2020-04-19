<?php
namespace Rules\Core\Form\Fields;

use Rules\Core\Form\Abstracts\Rules_Field;

defined( 'ABSPATH' ) || exit;

class Rules_Field_Roles extends Rules_Field {

	protected $type = 'select';

	public function init(array $args)
	{
		$args['options'] = rules_get_users_roles();
		parent::init($args);
	}

	public function validate()
	{

	}

	public function sanitize($post_array = null)
	{
		if(is_null($post_array)){
			$post_array = $_POST;
		}
		if(isset($post_array[$this->get_name()])){
			return sanitize_key( $post_array[$this->get_name()] );
		}
		return null;
	}
}
