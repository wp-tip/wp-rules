<?php
namespace WP_Rules\Templates;

use WP_Rules\Dependencies\League\Container\ServiceProvider\AbstractServiceProvider;

/**
 * Class ServiceProvider
 *
 * @package WP_Rules\Templates
 */
class ServiceProvider extends AbstractServiceProvider {

	/**
	 * Provides array.
	 *
	 * @var string[]
	 */
	public $provides = [
		'template_specific_user_notice',
		'template_specific_role_notice',
		'template_save_post_notice',
	];

	/**
	 * Register subscribers and classes.
	 */
	public function register() {
		$container = $this->getContainer();

		$container->share( 'template_specific_user_notice', '\WP_Rules\Templates\Backend\NoticeSpecificUser' );
		$container->share( 'template_specific_role_notice', '\WP_Rules\Templates\Backend\NoticeSpecificRole' );
		$container->share( 'template_save_post_notice', '\WP_Rules\Templates\Backend\NoticeSavePost' );

	}
}
