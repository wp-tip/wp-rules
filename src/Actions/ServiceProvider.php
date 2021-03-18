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
		'action_redirect',
		'action_create_post',
		'action_update_post',
		'action_send_email',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'action_admin_notices', '\WP_Rules\Actions\AdminNotices' );
		$container->share( 'action_debug', '\WP_Rules\Actions\Debug' );
		$container->share( 'action_redirect', '\WP_Rules\Actions\Redirect' );
		$container->share( 'action_create_post', '\WP_Rules\Actions\CreatePost' );
		$container->share( 'action_update_post', '\WP_Rules\Actions\UpdatePost' );
		$container->share( 'action_send_email', '\WP_Rules\Actions\SendEmail' );
	}
}
