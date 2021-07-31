<?php
namespace WP_Rules\ThirdParty\Plugins\NinjaForms;

use WP_Rules\ThirdParty\Plugins\AbstractPlugin;
use WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers\AfterSubmission;
use WP_Rules\ThirdParty\Plugins\NinjaForms\Triggers\BeforeResponse;

/**
 * Class Plugin
 *
 * @package WP_Rules\ThirdParty\Plugins\NinjaForms
 */
class Plugin extends AbstractPlugin {

	/**
	 * Status of this plugin activation.
	 *
	 * @return bool
	 */
	public static function is_allowed(): bool {
		return class_exists( 'Ninja_Forms' );
	}

	/**
	 * Register this list of classes.
	 *
	 * @return string[]
	 */
	public static function register(): array {
		return [
			'trigger_after_submission' => AfterSubmission::class,
			'trigger_before_response'  => BeforeResponse::class,
		];
	}

}
