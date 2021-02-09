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
		'condition_current_user_meta',
		'condition_current_locale_isrtl',
		'condition_is_admin_interface',
		'condition_is_multisite',
		'condition_is_ssl',
		'condition_available_upload_space',
		'condition_is_archive',
		'condition_is_post_type_archive',
		'condition_is_attachment',
		'condition_is_author',
		'condition_is_category',
		'condition_is_tag',
		'condition_is_date',
		'condition_is_day',
		'condition_is_feed',
		'condition_is_comment_feed',
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
		$container->share( 'condition_current_user_meta', '\WP_Rules\Conditions\CurrentUserMeta' );
		$container->share( 'condition_current_locale_isrtl', '\WP_Rules\Conditions\LocaleIsRtl' );
		$container->share( 'condition_is_admin_interface', '\WP_Rules\Conditions\IsAdminInterface' );
		$container->share( 'condition_is_multisite', '\WP_Rules\Conditions\IsMultisite' );
		$container->share( 'condition_is_ssl', '\WP_Rules\Conditions\IsSsl' );
		$container->share( 'condition_available_upload_space', '\WP_Rules\Conditions\AvailableUploadSpace' );
		$container->share( 'condition_is_archive', '\WP_Rules\Conditions\IsArchive' );
		$container->share( 'condition_is_post_type_archive', '\WP_Rules\Conditions\IsPostTypeArchive' );
		$container->share( 'condition_is_attachment', '\WP_Rules\Conditions\IsAttachment' );
		$container->share( 'condition_is_author', '\WP_Rules\Conditions\IsAuthor' );
		$container->share( 'condition_is_category', '\WP_Rules\Conditions\IsCategory' );
		$container->share( 'condition_is_tag', '\WP_Rules\Conditions\IsTag' );
		$container->share( 'condition_is_date', '\WP_Rules\Conditions\IsDate' );
		$container->share( 'condition_is_day', '\WP_Rules\Conditions\IsDay' );
		$container->share( 'condition_is_feed', '\WP_Rules\Conditions\IsFeed' );
		$container->share( 'condition_is_comment_feed', '\WP_Rules\Conditions\IsCommentFeed' );
	}
}
