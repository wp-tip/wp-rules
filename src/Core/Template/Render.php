<?php

namespace WP_Rules\Core\Template;

use WP_Filesystem_Direct;

class Render implements RenderInterface {

	/**
	 * Main Templates/Views directory path.
	 *
	 * @var string
	 */
	private $template_dir;

	/**
	 * Filesystem instance.
	 *
	 * @var WP_Filesystem_Direct
	 */
	private $filesystem;

	/**
	 * Render constructor.
	 *
	 * @param string               $templates_dir Views directory path.
	 * @param WP_Filesystem_Direct $filesystem Filesystem instance.
	 */
	public function __construct( string $templates_dir, $filesystem ) {
		$this->template_dir = $templates_dir;
		$this->filesystem   = $filesystem;
	}

	/**
	 * Render template to get its contents based on the passed data.
	 *
	 * @param string $template Template name to be rendered.
	 * @param array  $data Array of data to be passed to template.
	 *
	 * @return string Contents of this template to be echoed wherever you want.
	 */
	public function render( string $template, array $data = [] ): string {
		$template_full_path = $this->template_dir . $template . '.php';

		if ( ! $this->filesystem->is_readable( $template_full_path ) ) {
			return '';
		}

		ob_start();
		include $template_full_path;
		return trim( ob_get_clean() );
	}

}
