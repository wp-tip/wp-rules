<?php
namespace Rules\Core\Form\Fields;

use Rules\Core\Form\Abstracts\Rules_Field;

defined( 'ABSPATH' ) || exit;

class Rules_Field_Textbox extends Rules_Field {

	protected $type = 'textbox';

	public function validate()
	{

	}

	public function sanitize($post_array = null)
	{
		if(is_null($post_array)){
			$post_array = $_POST;
		}
		if(isset($post_array[$this->get_name()])){
			return sanitize_text_field( $post_array[$this->get_name()] );
		}
		return null;
	}
}
