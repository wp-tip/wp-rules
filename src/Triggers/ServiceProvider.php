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
		'trigger_init',
		'trigger_save_post',
		'trigger_before_delete_post',
		'trigger_after_delete_post',
		'trigger_before_trash_post',
		'trigger_after_trash_post',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'trigger_admin_init', '\WP_Rules\Triggers\AdminInit' );
		$container->share( 'trigger_init', '\WP_Rules\Triggers\Init' );
		$container->share( 'trigger_save_post', '\WP_Rules\Triggers\SavePost' );
		$container->share( 'trigger_before_delete_post', '\WP_Rules\Triggers\BeforeDeletePost' );
		$container->share( 'trigger_after_delete_post', '\WP_Rules\Triggers\AfterDeletePost' );
		$container->share( 'trigger_before_trash_post', '\WP_Rules\Triggers\BeforeTrashPost' );
		$container->share( 'trigger_after_trash_post', '\WP_Rules\Triggers\AfterTrashPost' );
	}
}
