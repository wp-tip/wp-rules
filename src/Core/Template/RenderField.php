<?php
namespace WP_Rules\Core\Template;

/**
 * Class RenderField
 *
 * @package WP_Rules\Core\Template
 */
class RenderField extends Render {

	/**
	 * Admin Directory name.
	 *
	 * @var string
	 */
	const ADMIN_DIR = 'admin';

	/**
	 * Fields Directory name.
	 *
	 * @var string
	 */
	const FIELDS_DIR = 'fields';

	/**
	 * Render field template contents.
	 *
	 * @param string $field_name Field name.
	 * @param array  $data Array of data passed to template.
	 *
	 * @return string Contents of this field.
	 */
	public function render_field( string $field_name, array $data = [] ) {
		$template_name = self::ADMIN_DIR . DIRECTORY_SEPARATOR . self::FIELDS_DIR . DIRECTORY_SEPARATOR . $field_name;
		return $this->render( $template_name, $data );
	}

	/**
	 * Render text field.
	 *
	 * @param string      $name Name attribute for textbox.
	 * @param string      $label Label for textbox.
	 * @param string|null $value Value for textbox.
	 * @param array       $attributes Additional attributes for textbox.
	 *
	 * @return string
	 */
	public function text( string $name, string $label, string $value = null, array $attributes = [] ) {
		$data = compact( 'name', 'label', 'value', 'attributes' );
		return $this->render_field( 'text', $data );
	}

	/**
	 * Render select field.
	 *
	 * @param string $name Name attribute for select.
	 * @param string $label Label for select.
	 * @param array  $options Select available options.
	 * @param string $selected_key Key of selected option.
	 * @param array  $attributes Additional attributes for select.
	 *
	 * @return string
	 */
	public function select( string $name, string $label, array $options = [], string $selected_key = '', array $attributes = [] ) {
		$data = compact( 'name', 'label', 'options', 'selected_key', 'attributes' );
		return $this->render_field( 'select', $data );
	}

	/**
	 * Render select2 field.
	 *
	 * @param string $name Name attribute for select.
	 * @param string $label Label for select.
	 * @param array  $options Select available options.
	 * @param string $selected_key Key of selected option.
	 * @param array  $attributes Additional attributes for select.
	 *
	 * @return string
	 */
	public function select2( string $name, string $label, array $options = [], string $selected_key = '', array $attributes = [] ) {
		$attributes['class'] = 'select2';
		$data                = compact( 'name', 'label', 'options', 'selected_key', 'attributes' );
		return $this->render_field( 'select', $data );
	}

}
