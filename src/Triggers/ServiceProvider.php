<?php
namespace WP_Rules\Triggers;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;
use \WP_Filesystem_Direct;
use \StdClass;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Triggers
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'trigger_admin_init',
		'trigger_init'
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'trigger_admin_init', '\WP_Rules\Triggers\AdminInit' );
		$container->share( 'trigger_init', '\WP_Rules\Triggers\Init' );
	}
}
