<?php
namespace WP_Rules\Core\Admin;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;
use \WP_Filesystem_Direct;
use \StdClass;

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
		'core_admin_rule_metabox',
		'core_admin_rule_subscriber',
		'core_admin_trigger_subscriber',
		'core_admin_condition_subscriber',
		'core_admin_action_subscriber',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();
		$container->add( 'core_admin_rule_posttype', '\WP_Rules\Core\Admin\Rule\Posttype' );
		$container->add( 'core_admin_rule_metabox', '\WP_Rules\Core\Admin\Rule\MetaBox' );
		$container->share( 'core_admin_rule_subscriber', '\WP_Rules\Core\Admin\Rule\Subscriber' )
				->addArgument( $container->get( 'core_admin_rule_posttype' ) )
				->addArgument( $container->get( 'core_admin_rule_metabox' ) );

		$container->share( 'core_admin_trigger_subscriber', '\WP_Rules\Core\Admin\Trigger\Subscriber' );
		$container->share( 'core_admin_condition_subscriber', '\WP_Rules\Core\Admin\Condition\Subscriber' );
		$container->share( 'core_admin_action_subscriber', '\WP_Rules\Core\Admin\Action\Subscriber' );
	}
}
