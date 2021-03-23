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
		'action_trash_post',
		'action_send_email',
		'action_create_user',
		'action_update_user',
		'action_update_user_meta',
		'action_delete_user_meta',
		'action_delete_user',
		'action_add_image_size',
		'action_remove_image_size',
		'action_auth_redirect',
		'action_add_update_option',
		'action_delete_option',
		'action_flush_rewrite_rules',
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
		$container->share( 'action_trash_post', '\WP_Rules\Actions\TrashPost' );
		$container->share( 'action_send_email', '\WP_Rules\Actions\SendEmail' );
		$container->share( 'action_create_user', '\WP_Rules\Actions\CreateUser' );
		$container->share( 'action_update_user', '\WP_Rules\Actions\UpdateUser' );
		$container->share( 'action_update_user_meta', '\WP_Rules\Actions\UpdateUserMeta' );
		$container->share( 'action_delete_user_meta', '\WP_Rules\Actions\DeleteUserMeta' );
		$container->share( 'action_delete_user', '\WP_Rules\Actions\DeleteUser' );
		$container->share( 'action_add_image_size', '\WP_Rules\Actions\AddImageSize' );
		$container->share( 'action_remove_image_size', '\WP_Rules\Actions\RemoveImageSize' );
		$container->share( 'action_auth_redirect', '\WP_Rules\Actions\AuthRedirect' );
		$container->share( 'action_add_update_option', '\WP_Rules\Actions\AddUpdateOption' );
		$container->share( 'action_delete_option', '\WP_Rules\Actions\DeleteOption' );
		$container->share( 'action_flush_rewrite_rules', '\WP_Rules\Actions\FlushRewriteRules' );

	}
}
