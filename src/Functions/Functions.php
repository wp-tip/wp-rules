<?php

if ( ! function_exists( 'wpbr_render_fields' ) ) {
	/**
	 * Get instance of RenderField class.
	 *
	 * @return \WP_Rules\Core\Template\RenderField
	 */
	function wpbr_render_fields() {
		static $render_fields_object = null;

		if ( is_null( $render_fields_object ) ) {
			$container            = apply_filters( 'rules_container', null );
			$render_fields_object = $container->get( 'core_template_render_field' );
		}

		return $render_fields_object;
	}
}

if ( ! function_exists( 'wpbr_recursive_sanitize_text' ) ) {
	/**
	 * Recursive sanitization for an array.
	 *
	 * @param array $array Array to be sanitized.
	 *
	 * @return array Sanitized array.
	 */
	function wpbr_recursive_sanitize_text( array $array ) {
		foreach ( $array as $key => &$value ) {
			if ( is_array( $value ) ) {
				$value = wpbr_recursive_sanitize_text( $value );
			} else {
				$value = sanitize_textarea_field( $value );
			}
		}

		return $array;
	}
}

if ( ! function_exists( 'wpbr_get_filesystem' ) ) {
	/**
	 * Get filesystem instance.
	 *
	 * @return WP_Filesystem_Direct Filesystem instance
	 */
	function wpbr_get_filesystem() {
		static $filesystem = null;

		if ( is_null( $filesystem ) ) {
			require_once wpbr_get_constant( 'ABSPATH' ) . 'wp-admin/includes/class-wp-filesystem-base.php';
			require_once wpbr_get_constant( 'ABSPATH' ) . 'wp-admin/includes/class-wp-filesystem-direct.php';
			$filesystem = new WP_Filesystem_Direct( new StdClass() );
		}

		return $filesystem;
	}
}

if ( ! function_exists( 'wpbr_has_constant' ) ) {
	/**
	 * Check if Constant is defined or not.
	 *
	 * @param string $constant_name Constant name.
	 *
	 * @return bool If constant is defined or not.
	 */
	function wpbr_has_constant( string $constant_name ) {
		return defined( $constant_name );
	}
}

if ( ! function_exists( 'wpbr_get_constant' ) ) {
	/**
	 * Get constant defined value.
	 *
	 * @param string $constant_name Constant name.
	 * @param mixed  $default Default value if not defined.
	 *
	 * @return mixed Constant value if found otherwise default value.
	 */
	function wpbr_get_constant( $constant_name, $default = null ) {
		if ( ! wpbr_has_constant( $constant_name ) ) {
			return $default;
		}

		return constant( $constant_name );
	}
}
