<?php
defined( 'ABSPATH' ) || exit;

use \Rules\Core\Rules_Admin_Template;
use \Rules\Core\Form\Interfaces\Rules_Field_List as Rules_Field_List_Interface;
use \Rules\Core\Form\Rules_Field_List;

function admin_render_view( $view_file, $data = [], $return = false ){
	if(!empty($view_file)) {
		$template_object = new Rules_Admin_Template();
		$template_object->setup();
		return $template_object->render($view_file, $data, $return);
	}
}

function admin_render_fields ( Rules_Field_List_Interface $fields, $return = false ){
	$template_object = new Rules_Admin_Template();
	$template_object->setup();
	$template_object->open_folder('fields');
	return $template_object->render_fields($fields, $return);
}

function initiate_field_list($fields) {
	$field_list_object = new Rules_Field_List();
	$field_list_object->init( $fields );
	return $field_list_object;
}

function rules_get_triggers_named_ids() {
	return apply_filters('rules_triggers_named_ids', []);
}

function rules_get_triggers() {
	return apply_filters('rules_triggers_list', []);
}
