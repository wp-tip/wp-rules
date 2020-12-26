<?php

/**
 * Get instance of RenderField class.
 *
 * @return \WP_Rules\Core\Template\RenderField
 */
function rules_render_fields() {
	static $render_fields_object = null;

	if ( is_null( $render_fields_object ) ) {
		$container            = apply_filters( 'rules_container', null );
		$render_fields_object = $container->get( 'core_template_render_field' );
	}

	return $render_fields_object;
}

/**
 * Recursive sanitization for an array.
 *
 * @param array $array Array to be sanitized.
 *
 * @return array Sanitized array.
 */
function rules_recursive_sanitize_key( array $array ) {
	foreach ( $array as $key => &$value ) {
		if ( is_array( $value ) ) {
			$value = rules_recursive_sanitize_key( $value );
		} else {
			$value = sanitize_key( $value );
		}
	}

	return $array;
}
