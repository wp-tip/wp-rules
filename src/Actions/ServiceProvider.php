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
		'action_show_admin_bar',
		'action_show_login_page_message',
		'action_add_post_status',
		'action_remove_menu_page',
		'action_post_title_replace',
		'action_post_content_replace',
		'action_post_excerpt_replace',
		'action_post_class_add',
		'action_post_class_remove',
		'action_body_class_add',
		'action_body_class_remove',
		'action_post_password_protected',
		'action_add_schedule_interval',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'action_admin_notices', '\WP_Rules\Actions\Backend\AdminNotices' );
		$container->share( 'action_debug', '\WP_Rules\Actions\General\Debug' );
		$container->share( 'action_redirect', '\WP_Rules\Actions\Frontend\Redirect' );
		$container->share( 'action_create_post', '\WP_Rules\Actions\Posts\CreatePost' );
		$container->share( 'action_update_post', '\WP_Rules\Actions\Posts\UpdatePost' );
		$container->share( 'action_trash_post', '\WP_Rules\Actions\Posts\TrashPost' );
		$container->share( 'action_send_email', '\WP_Rules\Actions\General\SendEmail' );
		$container->share( 'action_create_user', '\WP_Rules\Actions\Users\CreateUser' );
		$container->share( 'action_update_user', '\WP_Rules\Actions\Users\UpdateUser' );
		$container->share( 'action_update_user_meta', '\WP_Rules\Actions\Users\UpdateUserMeta' );
		$container->share( 'action_delete_user_meta', '\WP_Rules\Actions\Users\DeleteUserMeta' );
		$container->share( 'action_delete_user', '\WP_Rules\Actions\Users\DeleteUser' );
		$container->share( 'action_add_image_size', '\WP_Rules\Actions\General\AddImageSize' );
		$container->share( 'action_remove_image_size', '\WP_Rules\Actions\General\RemoveImageSize' );
		$container->share( 'action_auth_redirect', '\WP_Rules\Actions\Frontend\AuthRedirect' );
		$container->share( 'action_add_update_option', '\WP_Rules\Actions\Backend\AddUpdateOption' );
		$container->share( 'action_delete_option', '\WP_Rules\Actions\Backend\DeleteOption' );
		$container->share( 'action_flush_rewrite_rules', '\WP_Rules\Actions\General\FlushRewriteRules' );
		$container->share( 'action_show_admin_bar', '\WP_Rules\Actions\Frontend\ShowAdminBar' );
		$container->share( 'action_show_login_page_message', '\WP_Rules\Actions\Frontend\ShowLoginPageMessage' );
		$container->share( 'action_add_post_status', '\WP_Rules\Actions\Posts\AddPostStatus' );
		$container->share( 'action_remove_menu_page', '\WP_Rules\Actions\Backend\RemoveMenuPage' );
		$container->share( 'action_post_title_replace', '\WP_Rules\Actions\Posts\PostTitleReplace' );
		$container->share( 'action_post_content_replace', '\WP_Rules\Actions\Posts\PostContentReplace' );
		$container->share( 'action_post_excerpt_replace', '\WP_Rules\Actions\Posts\PostExcerptReplace' );
		$container->share( 'action_post_class_add', '\WP_Rules\Actions\Posts\PostClassAdd' );
		$container->share( 'action_post_class_remove', '\WP_Rules\Actions\Posts\PostClassRemove' );
		$container->share( 'action_body_class_add', '\WP_Rules\Actions\Frontend\BodyClassAdd' );
		$container->share( 'action_body_class_remove', '\WP_Rules\Actions\Frontend\BodyClassRemove' );
		$container->share( 'action_post_password_protected', '\WP_Rules\Actions\Posts\PostPasswordProtected' );
		$container->share( 'action_add_schedule_interval', '\WP_Rules\Actions\General\AddScheduleInterval' );

	}
}
