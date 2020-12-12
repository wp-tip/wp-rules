<?php
namespace WP_Rules\Core\Admin;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Core\Admin
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'core_admin_rule_posttype',
		'core_admin_rule_subscriber',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();
		$container->add( 'core_admin_rule_posttype', '\WP_Rules\Core\Admin\Rule\Posttype' );
		$container->share( 'core_admin_rule_subscriber', '\WP_Rules\Core\Admin\Rule\Subscriber' )
			->addArgument( $container->get( 'core_admin_rule_posttype' ) );
	}
}
