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
		'trigger_before_untrash_post',
		'trigger_after_untrash_post',
		'trigger_before_trash_post_comments',
		'trigger_after_trash_post_comments',
		'trigger_before_untrash_post_comments',
		'trigger_after_untrash_post_comments',
		'trigger_stick_post',
		'trigger_unstick_post',
		'trigger_post_status_changed',
		'trigger_before_delete_attachment',
		'trigger_after_delete_attachment',
		'trigger_after_update_attachment',
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
		$container->share( 'trigger_before_untrash_post', '\WP_Rules\Triggers\BeforeUnTrashPost' );
		$container->share( 'trigger_after_untrash_post', '\WP_Rules\Triggers\AfterUnTrashPost' );
		$container->share( 'trigger_before_trash_post_comments', '\WP_Rules\Triggers\BeforeTrashPostComments' );
		$container->share( 'trigger_after_trash_post_comments', '\WP_Rules\Triggers\AfterTrashPostComments' );
		$container->share( 'trigger_before_untrash_post_comments', '\WP_Rules\Triggers\BeforeUnTrashPostComments' );
		$container->share( 'trigger_after_untrash_post_comments', '\WP_Rules\Triggers\AfterUnTrashPostComments' );
		$container->share( 'trigger_stick_post', '\WP_Rules\Triggers\StickPost' );
		$container->share( 'trigger_unstick_post', '\WP_Rules\Triggers\UnStickPost' );
		$container->share( 'trigger_post_status_changed', '\WP_Rules\Triggers\PostStatusChanged' );
		$container->share( 'trigger_before_delete_attachment', '\WP_Rules\Triggers\BeforeDeleteAttachment' );
		$container->share( 'trigger_after_delete_attachment', '\WP_Rules\Triggers\AfterDeleteAttachment' );
		$container->share( 'trigger_after_update_attachment', '\WP_Rules\Triggers\AfterUpdateAttachment' );
	}
}
