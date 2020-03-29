<?php
namespace Rules\Core\Form\Interfaces;
defined( 'ABSPATH' ) || exit;

interface Rules_Field {

	public function init( array $args );
	public function get_type();
	public function get_name();
	public function get_value();
	public function format_attributes();
	public function get_data();
	public function validate();
	public function sanitize();

}
