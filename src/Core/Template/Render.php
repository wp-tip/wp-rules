<?php

namespace WP_Rules\Core\Template;

class Render implements RenderInterface {

	private $template_dir;

	private $filesystem;

	public function __construct( string $templates_dir, $filesystem ) {
		$this->template_dir = $templates_dir;
		$this->filesystem   = $filesystem;
	}

	public function render( string $template, array $data = [] ): string {
		$template_full_path = $this->template_dir . $template . ".php";

		if ( ! $this->filesystem->is_readable( $template_full_path ) ) {
			return "";
		}

		if ( ! empty( $data ) ) {
			extract( $data );
		}

		ob_start();
		include $template_full_path;
		return trim( ob_get_clean() );
	}

}
