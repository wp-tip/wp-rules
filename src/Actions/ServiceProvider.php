<?php
namespace WP_Rules\Actions;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Actions
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'action_admin_notices',
		'action_debug',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'action_admin_notices', '\WP_Rules\Actions\AdminNotices' );
		$container->share( 'action_debug', '\WP_Rules\Actions\Debug' );
	}
}
