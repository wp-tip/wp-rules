<?php
namespace WP_Rules\Core\General;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Core\General
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'core_general_scheduler',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->add( 'core_general_scheduler', '\WP_Rules\Core\General\Scheduler' );
	}
}
