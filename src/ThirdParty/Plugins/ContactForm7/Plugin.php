<?php
namespace WP_Rules\ThirdParty\Plugins\ContactForm7;

use WP_Rules\ThirdParty\Plugins\AbstractPlugin;
use WP_Rules\ThirdParty\Plugins\ContactForm7\Actions\SkipMail;
use WP_Rules\ThirdParty\Plugins\ContactForm7\Actions\StopSubmission;
use WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers\BeforeSendEmail;
use WP_Rules\ThirdParty\Plugins\ContactForm7\Triggers\FormSubmitted;

/**
 * Class Plugin
 *
 * @package WP_Rules\ThirdParty\Plugins\CotactForm7
 */
class Plugin extends AbstractPlugin {

	/**
	 * Status of this plugin activation.
	 *
	 * @return bool
	 */
	public static function is_allowed(): bool {
		return wpbr_has_constant( 'WPCF7_PLUGIN' );
	}

	/**
	 * Register this list of classes.
	 *
	 * @return string[]
	 */
	public static function register(): array {
		return [
			'trigger_before_send_email' => BeforeSendEmail::class,
			'trigger_submit_form'       => FormSubmitted::class,

			'action_stop_submission'    => StopSubmission::class,
			'action_skip_mail'          => SkipMail::class,
		];
	}

}
