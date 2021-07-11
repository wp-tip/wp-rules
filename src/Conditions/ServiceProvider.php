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
		'condition_is_front_page',
		'condition_is_home',
		'condition_is_privacy_policy',
		'condition_is_month',
		'condition_is_page',
		'condition_is_paged',
		'condition_is_preview',
		'condition_is_robots',
		'condition_is_favicon',
		'condition_is_search',
		'condition_is_singular',
		'condition_is_trackback',
		'condition_is_year',
		'condition_is_404',
		'condition_is_loggedin',
		'condition_variable_compare',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'condition_user', '\WP_Rules\Conditions\Users\User' );
		$container->share( 'condition_role', '\WP_Rules\Conditions\Users\Role' );
		$container->share( 'condition_current_page_url', '\WP_Rules\Conditions\General\CurrentPageUrl' );
		$container->share( 'condition_current_post', '\WP_Rules\Conditions\Posts\CurrentPost' );
		$container->share( 'condition_current_admin_screen', '\WP_Rules\Conditions\Backend\CurrentAdminScreen' );
		$container->share( 'condition_current_user_capability', '\WP_Rules\Conditions\Users\CurrentUserCapability' );
		$container->share( 'condition_current_user_meta', '\WP_Rules\Conditions\Users\CurrentUserMeta' );
		$container->share( 'condition_current_locale_isrtl', '\WP_Rules\Conditions\Frontend\LocaleIsRtl' );
		$container->share( 'condition_is_admin_interface', '\WP_Rules\Conditions\Backend\IsAdminInterface' );
		$container->share( 'condition_is_multisite', '\WP_Rules\Conditions\Frontend\IsMultisite' );
		$container->share( 'condition_is_ssl', '\WP_Rules\Conditions\Frontend\IsSsl' );
		$container->share( 'condition_available_upload_space', '\WP_Rules\Conditions\Backend\AvailableUploadSpace' );
		$container->share( 'condition_is_archive', '\WP_Rules\Conditions\Frontend\IsArchive' );
		$container->share( 'condition_is_post_type_archive', '\WP_Rules\Conditions\Frontend\IsPostTypeArchive' );
		$container->share( 'condition_is_attachment', '\WP_Rules\Conditions\Frontend\IsAttachment' );
		$container->share( 'condition_is_author', '\WP_Rules\Conditions\Frontend\IsAuthor' );
		$container->share( 'condition_is_category', '\WP_Rules\Conditions\Frontend\IsCategory' );
		$container->share( 'condition_is_tag', '\WP_Rules\Conditions\Frontend\IsTag' );
		$container->share( 'condition_is_date', '\WP_Rules\Conditions\frontend\IsDate' );
		$container->share( 'condition_is_day', '\WP_Rules\Conditions\Frontend\IsDay' );
		$container->share( 'condition_is_feed', '\WP_Rules\Conditions\Frontend\IsFeed' );
		$container->share( 'condition_is_comment_feed', '\WP_Rules\Conditions\Frontend\IsCommentFeed' );
		$container->share( 'condition_is_front_page', '\WP_Rules\Conditions\Frontend\IsFrontPage' );
		$container->share( 'condition_is_home', '\WP_Rules\Conditions\Frontend\IsHome' );
		$container->share( 'condition_is_privacy_policy', '\WP_Rules\Conditions\Frontend\IsPrivacyPolicy' );
		$container->share( 'condition_is_month', '\WP_Rules\Conditions\Frontend\IsMonth' );
		$container->share( 'condition_is_page', '\WP_Rules\Conditions\Frontend\IsPage' );
		$container->share( 'condition_is_paged', '\WP_Rules\Conditions\Frontend\IsPaged' );
		$container->share( 'condition_is_preview', '\WP_Rules\Conditions\Frontend\IsPreview' );
		$container->share( 'condition_is_robots', '\WP_Rules\Conditions\Frontend\IsRobots' );
		$container->share( 'condition_is_favicon', '\WP_Rules\Conditions\Frontend\IsFavicon' );
		$container->share( 'condition_is_search', '\WP_Rules\Conditions\Frontend\IsSearch' );
		$container->share( 'condition_is_singular', '\WP_Rules\Conditions\Frontend\IsSingular' );
		$container->share( 'condition_is_trackback', '\WP_Rules\Conditions\Frontend\IsTrackback' );
		$container->share( 'condition_is_year', '\WP_Rules\Conditions\Frontend\IsYear' );
		$container->share( 'condition_is_404', '\WP_Rules\Conditions\Frontend\Is404' );
		$container->share( 'condition_is_loggedin', '\WP_Rules\Conditions\Frontend\IsLoggedin' );
		$container->share( 'condition_variable_compare', '\WP_Rules\Conditions\General\VariableCompare' );
	}
}
