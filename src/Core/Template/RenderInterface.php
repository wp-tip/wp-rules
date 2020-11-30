<?php

namespace WP_Rules\Core\Template;

interface RenderInterface {

	public function render( string $template, array $data ) : string ;

}
