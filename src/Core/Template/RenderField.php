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
	 * @param bool   $echo Echo the content if true OR return it if false.
	 *
	 * @return string Contents of this field.
	 */
	public function render_field( string $field_name, array $data = [], bool $echo = true ) {
		$template_name = self::ADMIN_DIR . DIRECTORY_SEPARATOR . self::FIELDS_DIR . DIRECTORY_SEPARATOR . $field_name;

		if ( ! empty( $data['attributes'] ) ) {
			$data['attributes_html'] = '';
			foreach ( $data['attributes'] as $attribute_key => $attribute_value ) {
				$data['attributes_html'] .= " {$attribute_key}='{$attribute_value}' ";
			}
		}

		if ( ! empty( $data['attributes']['container_class'] ) ) {
			$data['container_class'] = $data['attributes']['container_class'] ?? '';
			unset( $data['attributes']['container_class'] );
		}

		if ( 'select' === $field_name ) {
			$data = $this->handle_select_groups( $data );
		}

		$return = $this->render( $template_name, $data );
		if ( ! $echo ) {
			return $return;
		}
		echo wp_kses_post( $return );
	}

	/**
	 * Render text field.
	 *
	 * @param string      $name Name attribute for textbox.
	 * @param string      $label Label for textbox.
	 * @param string|null $value Value for textbox.
	 * @param array       $attributes Additional attributes for textbox.
	 * @param bool        $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function text( string $name, string $label, string $value = null, array $attributes = [], bool $echo = true ) {
		$data = compact( 'name', 'label', 'value', 'attributes' );
		return $this->render_field( 'text', $data, $echo );
	}

	/**
	 * Render hidden text field.
	 *
	 * @param string      $name Name attribute for textbox.
	 * @param string|null $value Value for textbox.
	 * @param array       $attributes Additional attributes for hidden textbox.
	 * @param bool        $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function hidden( string $name, string $value = null, array $attributes = [], bool $echo = true ) {
		$data = compact( 'name', 'value', 'attributes' );
		return $this->render_field( 'hidden', $data, $echo );
	}

	/**
	 * Render textarea field.
	 *
	 * @param string      $name Name attribute for textarea.
	 * @param string      $label Label for textarea.
	 * @param string|null $value Value for textarea.
	 * @param array       $attributes Additional attributes for textarea.
	 * @param bool        $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function textarea( string $name, string $label, string $value = null, array $attributes = [], bool $echo = true ) {
		$data = compact( 'name', 'label', 'value', 'attributes' );
		return $this->render_field( 'textarea', $data, $echo );
	}

	/**
	 * Render select field.
	 *
	 * @param string $name Name attribute for select.
	 * @param string $label Label for select.
	 * @param array  $options Select available options.
	 * @param string $value Key of selected option.
	 * @param array  $attributes Additional attributes for select.
	 * @param bool   $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function select( string $name, string $label, array $options = [], string $value = '', array $attributes = [], bool $echo = true ) {
		$data = compact( 'name', 'label', 'options', 'value', 'attributes' );
		return $this->render_field( 'select', $data, $echo );
	}

	/**
	 * Handle select groups for select field.
	 *
	 * @param array $data Data array.
	 *
	 * @return array Data array after doing some logic on it.
	 */
	private function handle_select_groups( array $data ): array {
		$groups   = [];
		$nogroups = [];
		if ( ! empty( $data['options'] ) ) {
			foreach ( $data['options'] as $option_key => $option ) {
				if ( ! is_array( $option ) ) {
					$nogroups[ $option_key ] = $option;
					continue;
				}

				foreach ( $option as $item_group => $item_name ) {
					if ( ! isset( $groups[ $item_group ] ) ) {
						$groups[ $item_group ] = [];
					}

					$groups[ $item_group ][ $option_key ] = $item_name;
				}
			}
		}

		$data['multiple'] = array_key_exists( 'multiple', $data['attributes'] ?? [] );

		if ( ! empty( $groups ) ) {
			$data['groups'] = [];
			foreach ( $groups as $group => $options ) {
				$data['groups'][ $group ] = $this->render_field(
					'option',
					[
						'options'    => $options,
						'attributes' => $data['attributes'],
						'value'      => $data['value'],
					],
					false
				);
			}

			$data['nogroups_html'] = $this->render_field(
				'option',
				[
					'options'    => $nogroups,
					'attributes' => $data['attributes'],
					'value'      => $data['value'],
				],
				false
			);
		}else {
			$data['options_html'] = $this->render_field( 'option', $data, false );
		}

		if ( $data['multiple'] ) {
			$data['name'] .= '[]';
		}

		return $data;
	}

	/**
	 * Render select2 field.
	 *
	 * @param string $name Name attribute for select.
	 * @param string $label Label for select.
	 * @param array  $options Select available options.
	 * @param string $value Key of selected option.
	 * @param array  $attributes Additional attributes for select.
	 * @param bool   $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function select2( string $name, string $label, array $options = [], string $value = '', array $attributes = [], bool $echo = true ) {
		$attributes['class'] = 'select2';
		$data                = compact( 'name', 'label', 'options', 'value', 'attributes' );
		return $this->render_field( 'select', $data, $echo );
	}

	/**
	 * Render container field.
	 *
	 * @param string $contents HTML contents.
	 * @param array  $attributes Additional attributes for textbox.
	 * @param bool   $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function container( string $contents, array $attributes = [], bool $echo = true ) {
		$data = compact( 'contents', 'attributes' );
		return $this->render_field( 'container', $data, $echo );
	}

	/**
	 * Render button field.
	 *
	 * @param string      $name Name attribute for button.
	 * @param string|null $value Visible text on button.
	 * @param array       $attributes Additional attributes for textbox.
	 * @param bool        $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function button( string $name, string $value = null, array $attributes = [], bool $echo = true ) {
		$data = compact( 'name', 'value', 'attributes' );
		return $this->render_field( 'button', $data, $echo );
	}

	/**
	 * Render Table.
	 *
	 * @param array $rows Table rows like [ [ 'col_1_row_1', 'col_2_row_1' ], [ 'col_1_row_2', 'col_2_row_2' ] ].
	 * @param array $attributes Additional attributes for textbox.
	 * @param bool  $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function table( array $rows = [], array $attributes = [], bool $echo = true ) {
		$data = compact( 'rows', 'attributes' );
		return $this->render_field( 'table', $data, $echo );
	}

	/**
	 * Render Key/Value Table.
	 *
	 * @param array $items Table rows like [ [ 'col_1_row_1' => 'col_2_row_1' ], [ 'col_1_row_2' => 'col_2_row_2' ] ].
	 * @param array $attributes Additional attributes for textbox.
	 * @param bool  $echo Echo the content if true OR return it if false.
	 *
	 * @return string
	 */
	public function tableKeyValue( array $items = [], array $attributes = [], bool $echo = true ) {
		$data = compact( 'items', 'attributes' );
		return $this->render_field( 'tablekeyvalue', $data, $echo );
	}

}
