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
		'core_template_render_field',
		'core_admin_trigger_subscriber',
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

		$filesystem = new WP_Filesystem_Direct( new StdClass() );
		$container->add( 'core_template_render_field', '\WP_Rules\Core\Template\RenderField' )
				->addArgument( $container->get( 'template_dir' ) )
				->addArgument( $filesystem );
		$container->share( 'core_admin_trigger_subscriber', '\WP_Rules\Core\Admin\Trigger\Subscriber' )
				->addArgument( $container->get( 'core_template_render_field' ) );
	}
}
