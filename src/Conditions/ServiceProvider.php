<?php
namespace WP_Rules\Conditions;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Conditions
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'condition_user',
		'condition_role',
		'condition_current_page_url',
		'condition_current_post',
		'condition_current_admin_screen',
		'condition_current_user_capability',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'condition_user', '\WP_Rules\Conditions\User' );
		$container->share( 'condition_role', '\WP_Rules\Conditions\Role' );
		$container->share( 'condition_current_page_url', '\WP_Rules\Conditions\CurrentPageUrl' );
		$container->share( 'condition_current_post', '\WP_Rules\Conditions\CurrentPost' );
		$container->share( 'condition_current_admin_screen', '\WP_Rules\Conditions\CurrentAdminScreen' );
		$container->share( 'condition_current_user_capability', '\WP_Rules\Conditions\CurrentUserCapability' );
	}
}
