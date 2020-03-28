<?php
namespace Rules\Core\Abstracts;

use Rules\Core\Form\Interfaces\Rules_Field;
use Rules\Core\Form\Interfaces\Rules_Field_List;
use \Rules\Core\Interfaces\Rules_Template as Rules_Template_Interface;

defined( 'ABSPATH' ) || exit;

abstract class Rules_Template implements Rules_Template_Interface {

	protected $views_folder;
	protected $common_data = [];

	public function init($views_folder, $common_data = []){
		$this->views_folder = $views_folder;
		$this->common_data = $common_data;
	}

	public function open_folder( $folder_name ) {
		$this->views_folder .= trailingslashit( $folder_name );
	}

	public function render($view, $data, $return = false) {
		$html = "";

		if (!empty($this->common_data)){
			extract($this->common_data);
		}
		if (!empty($data)){
			extract($data);
		}

		$view_file = $this->views_folder . $view . '.php';

		if ( file_exists( $view_file ) ) {
			ob_start();

			include $view_file;

			$contents = ob_get_contents();
			ob_end_clean();
			$html = $contents;
		}else{
			throw new \Exception('File [' . $view_file . '] Not found!');
		}

		if( $return ){
			return $html;
		}else {
			$this->output( $html );
		}
	}

	public function render_fields( Rules_Field_List $fields, $return = false ) {
		$html = '';

		/** @param $field Rules_Field **/
		foreach ($fields as $field_name => $field){
			$field_data = [
				'label' => $field->get_label(),
				'name' => $field->get_name(),
				'value' => $field->get_value(),
				'options' => $field->get_options(),
				'attributes' => $field->format_attributes()
			];
			$html .= $this->render( $this->get_field_type_file_name( $field->get_type() ), $field_data );
		}

		if( $return ){
			return $html;
		}else {
			$this->output( $html );
		}
	}

	private function get_field_type_file_name( $field_type ) {
		return $field_type;
	}

	protected function output($html){
		echo $html;
	}

}
