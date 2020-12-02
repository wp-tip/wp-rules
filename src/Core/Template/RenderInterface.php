<?php

namespace WP_Rules\Core\Template;

/**
 * Interface RenderInterface
 * Contract for all renderers if found.
 */
interface RenderInterface {

	/**
	 * Render template to get its contents based on the passed data.
	 *
	 * @param string $template Template name to be rendered.
	 * @param array  $data Array of data to be passed to template.
	 *
	 * @return string Contents of this template to be echoed wherever you want.
	 */
	public function render( string $template, array $data ) : string;

}
