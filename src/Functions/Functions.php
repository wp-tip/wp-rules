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
